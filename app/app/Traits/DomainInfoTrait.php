<?php
namespace App\Traits
;
use App\Models\Domain;
use App\Models\DNSRecord;
use App\Models\HttpData;
use App\Models\HtmlMetaData;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use DOMDocument;

Trait DomainInfoTrait{

	protected $dnsRecords;
	protected $httpRecords;
	protected $htmlRecords;
	protected $maxMinutes;

	public function __construct(){
		$this->dnsRecords = array();
		$this->httpRecords = array();
		$this->htmlRecords = array();
		$this->maxMinutes = 15;
	}
	
	public function getHttpCache(): HttpData|null{
		if(HttpData::where('domain_id', $this->domain->id)->exists()){
			$httpCache = HttpData::where('domain_id', $this->domain->id)->first();
		}else{
			$httpCache = null;
		}
		return $httpCache;
	}

	public function getHtmlCache(): \Illuminate\Database\Eloquent\Collection|null{
		if(HttpData::where('domain_id', $this->domain->id)->exists()){
			$httpId = HttpData::where('domain_id', $this->domain->id)->first()->id;
			$htmlCache = HtmlMetaData::where('http_data_id', $httpId)->orderBy('meta_name')->get();
		}else{
			$htmlCache = null;
		}
		return $htmlCache;
	}

	private function isDnsCacheFresh(): bool{
		$timeAgo = Carbon::now()->subMinutes($this->maxMinutes);
		if(!DNSRecord::where('domain_id', $this->domain->id)->exists()){
			return false;
		}
		if(DNSRecord::where('domain_id', $this->domain->id)->first()->updated_at->lt($timeAgo)){
			return false;
		}
		return true;
		
	}

	private function isHttpCacheFresh(): bool{
		$timeAgo = Carbon::now()->subMinutes($this->maxMinutes);
		if(!HttpData::where('domain_id', $this->domain->id)->exists()){
			return false;
		}
		if(HttpData::where('domain_id', $this->domain->id)->first()->updated_at->lt($timeAgo)){
			return false;
		}
		return true;
	}

	private function isHtmlCacheFresh(): bool{
		if(!HttpData::where('domain_id', $this->domain->id)->exists()){
			return false;
		}
		$httpData = HttpData::where('domain_id', $this->domain->id)->first();
		if(!HtmlMetaData::where('http_data_id', $httpData->id)->exists()){
			return false;
		}
		$timeAgo = Carbon::now()->subMinutes($this->maxMinutes);
		if(HtmlMetaData::where('http_data_id', $httpData->id)->first()->updated_at->lt($timeAgo)){
			return false;
		}
		return true;
	}

	private function getDnsInformation(): array{
		try{
			$dnsA = dns_get_record($this->domain->domain_name_ascii, DNS_A);
			$dnsAWWW = dns_get_record('www.'.$this->domain->domain_name_ascii, DNS_A);
			$dnsMX = dns_get_record($this->domain->domain_name_ascii, DNS_MX);

			$this->dnsRecords = array();

			foreach($dnsA as $record){
				$element = [
					'type' => 'A',
					'content' => htmlspecialchars($record['ip']),
					'hostname' => htmlspecialchars($record['host'])
				];
				array_push($this->dnsRecords, $element);
			}

			foreach($dnsAWWW as $record){
				$element = [
					'type' => 'A',
					'content' => htmlspecialchars($record['ip']),
					'hostname' => htmlspecialchars($record['host'])
				];
				array_push($this->dnsRecords, $element);
				
			}
			foreach($dnsMX as $record){
				$element = [
					'type' => 'MX',
					'content' => htmlspecialchars($record['target']),
					'hostname' => htmlspecialchars($record['host'])
				];
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
			$response = Http::timeout(10)->get('http://'.$this->domain->domain_name_ascii);
			if(!is_null($response->header('Content-Type')) && preg_match('/(text\/html|application\/xhtml\+xml).*/', $response->header('Content-Type'))){
				# suppress DomDocument exceptions
				libxml_use_internal_errors(true);

				# retrieve html elements
				$domDoc = new DOMDocument();
				$domDoc->loadHTML($response->body());
				$htmlTitle = htmlspecialchars($domDoc->getElementsByTagName('title')[0]->textContent);

				$this->httpRecords = [
					'response_code' => $response->status(),
					'header' => $response->header('Content-Type'),
					'title' => $htmlTitle
				];
			}
		}catch(\Exception $e){
			report($e);
		}finally{
			return $this->httpRecords;
		}
	}

	private function getHtmlInformation(): array{
		try{
			$this->htmlRecords = array();
			$response = Http::timeout(10)->get('http://'.$this->domain->domain_name_ascii);
			if(!is_null($response->header('Content-Type')) && preg_match('/(text\/html|application\/xhtml\+xml).*/', $response->header('Content-Type'))){

				$httpData = HttpData::where('domain_id', $this->domain->id)->first();

				# suppress DomDocument exceptions
				libxml_use_internal_errors(true);

				# retrieve html elements
				$domDoc = new DOMDocument();
				$domDoc->loadHTML($response->body());
				
				$metaData = $domDoc->getElementsByTagName('meta');
				foreach($metaData as $meta){
					$name = '';
					$charset = '';
					$httpEquiv = '';
					$content = '';
					$property = '';
					$itemprop = '';
					if($meta->hasAttributes()){
						foreach($meta->attributes as $attribute){
							switch($attribute->nodeName){
								case 'name':
									$name = htmlspecialchars($attribute->nodeValue);
									break;
								case 'charset':
									$charset = htmlspecialchars($attribute->nodeValue);
									break;
								case 'content':
									$content = htmlspecialchars($attribute->nodeValue);
									break;
								case 'http-equiv':
									$httpEquiv = htmlspecialchars($attribute->nodeValue);
									break;
								case 'property':
									$property = htmlspecialchars($attribute->nodeValue);
									break;
								case 'itemprop':
									$itemprop = htmlspecialchars($attribute->nodeValue);
									break;
							}
						}
					}
					if($name != '' || $charset != '' || $httpEquiv != '' || $property != '' || $itemprop != ''){
						$metaNode = ['http_data_id' => $httpData->id, 
							'meta_name' => $name, 
							'meta_charset' => $charset, 
							'meta_http_equiv' => $httpEquiv, 
							'meta_content' => $content, 
							'meta_property' => $property,
							'meta_itemprop' => $itemprop];
						array_push($this->htmlRecords, $metaNode);
					}
				}
			}
				
		}catch(\Exception $e){
			report($e);
		}finally{
			return $this->htmlRecords;
		}	
	}

	private function updateOrCreateDnsCache(): void{
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

	private function updateOrCreateHttpCache(): void{
		if(!$this->isHttpCacheFresh()){
			$httpRecords = $this->getHttpInformation();
			if(count($httpRecords) > 0){
				$httpData = HttpData::updateOrCreate([
					'domain_id' => $this->domain->id,
					'response_code' => $httpRecords['response_code'],
					'header' => $httpRecords['header'],
					'title' => $httpRecords['title']]);
				$httpData->touch();
			}
		}
	}

	private function updateOrCreateHtmlCache(): void{
		if(!$this->isHtmlCacheFresh()){
			$htmlRecords = $this->getHtmlInformation();
			if(count($htmlRecords) > 0){
				$httpData = HttpData::where('domain_id', $this->domain->id)->first();
				HtmlMetaData::where('http_data_id', $httpData->id)->delete();
				foreach($this->htmlRecords as $record){
					HtmlMetaData::updateOrCreate([
						'http_data_id' => $httpData->id, 
						'meta_name' => $record['meta_name'], 
						'meta_charset' => $record['meta_charset'], 
						'meta_http_equiv' => $record['meta_http_equiv'], 
						'meta_content' => $record['meta_content'], 
						'meta_property' => $record['meta_property'],
						'meta_itemprop' => $record['meta_itemprop']
					]);
				}
			}
		}		
	}

	public function updateOrCreateDomainInformation(): void{
		$this->updateOrCreateDnsCache();
		$this->updateOrCreateHttpCache();
		$this->updateOrCreateHtmlCache();
	}
}
?>
