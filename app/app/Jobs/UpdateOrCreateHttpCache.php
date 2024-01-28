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
use App\Models\HttpData;


class UpdateOrCreateHttpCache implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var array<string, int|string> $httpRecords */
	protected array $httpRecords;

	public function __construct(protected Domain $domain, protected int $cacheMinutes){
		$this->httpRecords = array();
	}

	private function isHttpCacheFresh(): bool{
		return $this->domain->httpData()->first()?->updated_at?->gt(Date::now()->subMinutes($this->cacheMinutes)) ?? false;
	}

	/** @return array<string, string|int> */
	private function getHttpInformation(): array{
		try{
			$response = Http::timeout(10)->get('http://'.$this->domain->domain_name_ascii);
			if(!empty($response->header('Content-Type')) && preg_match('/(text\/html|application\/xhtml\+xml).*/', $response->header('Content-Type'))){
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
		}catch(Exception $e){
			report($e);
		}finally{
			return $this->httpRecords;
		}
	}

	public function handle(): void{
		if(!$this->isHttpCacheFresh()){
			$httpRecords = $this->getHttpInformation();
			if(count($httpRecords) > 0){
				$httpData = HttpData::updateOrCreate([
					'domain_id' => $this->domain->id
					],
					[
					'response_code' => $httpRecords['response_code'],
					'header' => $httpRecords['header'],
					'title' => $httpRecords['title']]);
				$httpData->touch();
			}
		}
	}
}
