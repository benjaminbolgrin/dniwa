<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use DOMDocument;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Date;
use App\Models\Domain;
use App\Models\HtmlMetaData;


class UpdateOrCreateHtmlCache implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var array<int, array<string, int|string|null>> $htmlRecords */
	protected $htmlRecords;

	public function __construct(protected Domain $domain, protected int $cacheMinutes){
		$this->htmlRecords = array();
	}

	private function isHtmlCacheFresh(): bool{
		return $this->domain->htmlMetaData()->first()?->updated_at?->gt(Date::now()->subMinutes($this->cacheMinutes)) ?? false;
	}

	/** @return array<int, array<string, int|string|null>> */
	private function getHtmlInformation(): array{
		try{
			$this->htmlRecords = array();
			$response = Http::timeout(10)->get('http://'.$this->domain->domain_name_ascii);
			if(!empty($response->header('Content-Type')) && preg_match('/(text\/html|application\/xhtml\+xml).*/', $response->header('Content-Type'))){

				$httpData = Domain::find($this->domain->id)?->httpData;

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
						$this->htmlRecords[] = $metaNode;
					}
				}
			}
				
		}catch(Exception $e){
			report($e);
		}finally{
			return $this->htmlRecords;
		}	
	}

	public function handle(): void{
		if(!$this->isHtmlCacheFresh()){
			$htmlRecords = $this->getHtmlInformation();
			if(count($htmlRecords) > 0){
				$httpData = $this->domain->httpData;
				HtmlMetaData::where('http_data_id', $httpData?->id)->delete();
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
}
