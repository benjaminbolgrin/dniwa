<?php
namespace App\Traits;
use App\Models\Domain;
use App\Models\DNSRecord;
use App\Models\HttpData;
use Carbon\Carbon;

class DomainInfoTrait{

	protected $domain;
	protected $dnsRecords = array();
	protected $httpRecords = array();
	protected $htmlRecords = array();
	protected $maxMinutes = 15;

	public function __construct(Domain $domain){
		$this->domain = $domain;
	}

	private function isDnsCacheFresh(): boolean{
		$timeAgo = Carbon::now()->subMinutes($maxMinutes);
		if(DNSRecord::where('domain_id', $this->domain->id)->first()->updated_at->lt($timeAgo)){
			return false;
		}
		return true;
		
	}

	private function isHttpCacheFresh(): boolean{
		$timeAgo = Carbon::now()->subMinutes($maxMinutes);
		if(HttpData::where('domain_id', $this->domain->id)->first()->updated_at->lt($timeAgo)){
			return false;
		}
		return true;
	}

	private function isHtmlCacheFresh(): boolean{
		$timeAgo = Carbon::now()->subMinutes($maxMinutes);
		$httpData = HttpData::where('domain_id', $this->domain->id)->first();
		if(HtmlMetaData::where('http_id', $httpData->id)->first()->updated_at->lt($timeAgo)){
			return false;
		}
		return true;
	{

	private function getDnsInformation(): array{
		try{
			$dnsA = dns_get_record($domain->domain_name_ascii, DNS_A);
			$dnsAWWW = dns_get_record('www.'.$domain->domain_name_ascii, DNS_A);
			$dnsMX = dns_get_record($domain->domain_name_ascii, DNS_MX);

			foreach($dnsA as $record){
				$element = [
					'type' => 'A',
					'content' => htmlspecialchars($record['ip']),
					'hostname' => htmlspecialchars($record['host'])
				]
				array_push($this->dnsRecords, $element);
			}

			foreach($dnsAWWW as $record){
				$element = [
					'type' => 'A',
					'content' => htmlspecialchars($record['ip']),
					'hostname' => htmlspecialchars($record['host'])
				]
				array_push($this->dnsRecords, $element);
				
			}
			foreach($dnsMX as $record){
				$element = [
					'type' => 'MX',
					'content' => htmlspecialchars($record['target']),
					'hostname' => htmlspecialchars($record['host'])
				]
				array_push($this->dnsRecords, $element);

			}
		}catch(\Exception $e){
			report($e);
		}finally{
			return $this->dnsRecords;
		}
	}

	private function getHttpInformation(): array{
		try{
			
		}catch(\Exception $e){
			report($e);
		}finally{
			return $this->httpRecords;
		}
	}

	private function getHtmlInformation(): array{
	{

	private function updateOrCreateDnsCache(): void{
		if(!isDnsCacheFresh){
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

	private function updateOrCreateHttpCache(): void{
		if(!isHttpCacheFresh){
			$httpRecords = $this->getHttpInformation();
			if(count($httpRecords) > 0){
				$httpData = HttpData::updateOrCreate([
					'domain_id' =>$this->domain->id,
					'response_code' => $httpRecords['response_code'],
					'header', $httpRecords['header'],
					'title', $httpRecords['title']
				]);
				$httpData->touch();
			}
		}
	}

	private function updateOrCreateHtmlCache(): void{
		if(!isHtmlCacheFresh){
			$this->getHtmlInformation();
		}
	}

	public function updateOrCreateDomainInformation(): void{
		$this->updateOrCreateDnsCache();
		$this->updateOrCreateHttpCache();
		$this->updateOrCreateHtmlCache();
	}
}
?>
