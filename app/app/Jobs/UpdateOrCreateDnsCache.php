<?php
namespace App\Jobs;

use App\Models\DNSRecord;
use App\Models\Domain;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;

class UpdateOrCreateDnsCache implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	/** @var array<int, array<string, string>> $dnsRecords */
	protected array $dnsRecords;

	public function __construct(protected Domain $domain, protected int $cacheMinutes){
		$this->dnsRecords = array();
	}
	
	private function isDnsCacheFresh(): bool{
		return $this->domain->dnsRecords()->first()?->updated_at?->gt(Date::now()->subMinutes($this->cacheMinutes)) ?? false;
	}
	
	/**
	 * @return array<int, array<string, string>>
	 */
	private function getDnsInformation(): array{
		try{
			$dnsA = dns_get_record($this->domain->domain_name_ascii, DNS_A);
			$dnsAWWW = dns_get_record('www.'.$this->domain->domain_name_ascii, DNS_A);
			$dnsMX = dns_get_record($this->domain->domain_name_ascii, DNS_MX);

			$this->dnsRecords = array();
			
			if($dnsA){
				foreach($dnsA as $record){
					$element = [
						'type' => 'A',
						'content' => htmlspecialchars($record['ip']),
						'hostname' => htmlspecialchars($record['host'])
					];
					$this->dnsRecords[] = $element;
				}
			}

			if($dnsAWWW){
				foreach($dnsAWWW as $record){
					$element = [
						'type' => 'A',
						'content' => htmlspecialchars($record['ip']),
						'hostname' => htmlspecialchars($record['host'])
					];
					$this->dnsRecords[] = $element;
					
				}
			}

			if($dnsMX){
				foreach($dnsMX as $record){
					$element = [
						'type' => 'MX',
						'content' => htmlspecialchars($record['target']),
						'hostname' => htmlspecialchars($record['host'])
					];
					$this->dnsRecords[] = $element;

				}
			}

		}catch(Exception $e){
			report($e);
		}finally{
			return $this->dnsRecords;
		}
	}

	public function handle():void{
		if(!$this->isDnsCacheFresh()){
			$dnsRecords = $this->getDnsInformation();
			if(count($dnsRecords) > 0){
				DNSRecord::where('domain_id', $this->domain->id)->delete();
				foreach($dnsRecords as $record){
					DNSRecord::updateOrCreate([
						'domain_id' => $this->domain->id,
						'type' => $record['type'],
						'content' => $record['content'],
						'hostname' => $record['hostname']
					]);
				}
			}
		}
	}
}
