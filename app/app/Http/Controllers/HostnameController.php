<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Domain;
use App\Models\UserDomain;
use App\Models\DNSRecord;
use App\Models\HttpData;
use App\Models\HtmlMetaData;
use App\Http\Requests\StoreHostnameRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use DOMDocument;

class HostnameController extends Controller
{

	public function show(Request $request, Domain $domain): View{
		
		function getHttpCache(Domain $domain): HttpData|null{
			$httpCache = HttpData::where('domain_id', $domain->id)->first();
			return $httpCache;
		}

		function updateHttp(Domain $domain){
			try{
				$response = Http::timeout(15)->get('http://'.$domain->domain_name_ascii);
				
				if(!is_null($response->header('Content-Type')) && preg_match('/(text\/html|application\/xhtml\+xml).*/', $response->header('Content-Type'))){		
					# suppress DomDocument exceptions
					libxml_use_internal_errors(true);
					
					# retrieve html elements
					$domDoc = new DOMDocument();
					$domDoc->loadHTML($response->body());
					$title = $domDoc->getElementsByTagName('title')[0]->textContent;
					
					# persist HttpData
					$httpData = HttpData::updateOrCreate(['domain_id' => $domain->id], ['response_code' => $response->status(), 'header' => $response->header('Content-Type'), 'title' => $title]);
					
					# update updated_at field
					$httpData->touch();
					
					# html meta data
					HtmlMetaData::where('http_data_id', $httpData->id)->delete();

					$metaData = $domDoc->getElementsByTagName('meta');
					foreach($metaData as $meta){
						$name = '';
						$charset = '';
						$httpEquiv = '';
						$content = '';
						$property = '';
						if($meta->hasAttributes()){
							foreach($meta->attributes as $attribute){
								switch($attribute->nodeName){
									case 'name':
										$name = $attribute->nodeValue;
										break;
									case 'charset':
										$charset = $attribute->nodeValue;
										break;
									case 'content':
										$content = $attribute->nodeValue;
										break;
									case 'http-equiv':
										$httpEquiv = $attribute->nodeValue;
										break;
									case 'property':
										$property = $attribute->nodeValue;
										break;
								}
							}
						}
						HtmlMetaData::updateOrCreate(['http_data_id' => $httpData->id, 
							'meta_name' => $name, 
							'meta_charset' => $charset, 
							'meta_http_equiv' => $httpEquiv, 
							'meta_content' => $content, 
							'meta_property' => $property]);
					}
				}
			}
			catch(\Exception $e){
				report($e);
				return false;
			}
		}

		function updateDNSRecords(Domain $domain){
			try{
				$fetchDNSA = dns_get_record($domain->domain_name_ascii, DNS_A);
				$fetchDNSMX = dns_get_record($domain->domain_name_ascii, DNS_MX);
				$fetchDNSAWWW = dns_get_record('www.'.$domain->domain_name_ascii, DNS_A);

				# cache dns records
				foreach($fetchDNSA as $dnsRecord){
					DNSRecord::updateOrCreate(['domain_id' => $domain->id, 'type' => 'A', 'content' => $dnsRecord['ip'], 'hostname' => $dnsRecord['host']]);
				}
				if($fetchDNSAWWW){
					foreach($fetchDNSAWWW as $dnsRecord){
						DNSRecord::updateOrCreate(['domain_id' => $domain->id, 'type' => 'A', 'content' => $dnsRecord['ip'], 'hostname' => $dnsRecord['host']]);
					}
				}

				foreach($fetchDNSMX as $dnsRecord){
					DNSRecord::updateOrCreate(['domain_id' => $domain->id, 'type' => 'MX', 'content' => $dnsRecord['target'], 'hostname' => $dnsRecord['host']]);
				}
		

			}catch(\Exception $e){
				report($e);
				return false;
			}
		}

		# check, if domain is on user's domain list
		if(!UserDomain::where('user_id', $request->user()->id)->where('domain_id', $domain->id)->exists()){
			abort(404);
		}

		$dnsA = [];
		$dnsMX = [];

		# check, if there are recent dns records for the domain
		if(!DNSRecord::where('domain_id', $domain->id)->exists()){
			
			# fetch dns records
			updateDNSRecords($domain);
		}else{
			# check, if the dns records are not older than 15 minutes
			$dateTime15 = Carbon::now()->subMinutes(15);
			$dnsATemp = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->first();

			if($dnsATemp->updated_at->lt($dateTime15)){
				# delete cached records
				DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->delete();
				DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->delete();
				# update dns records
				updateDNSRecords($domain);
			}
		}

		# fetch cached dns records
		$dnsA = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->get();
		$dnsMX = DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->get();

		# check if there is cached http data for the domain
		if(HttpData::where('domain_id', $domain->id)->exists()){
			# check if the cached data is not older than 15 minutes
			$dateTime15 = Carbon::now()->subMinutes(15);
			$httpDataTemp = HttpData::where('domain_id', $domain->id)->first();
			if($httpDataTemp->updated_at->lt($dateTime15)){
				# make a http request
				updateHttp($domain);
			}
		}else{
			# make a http request
			updateHttp($domain);
		}

		# fetch data from http cache
		$httpData = getHttpCache($domain);

		# render view
		return view('hostname.show')->with('dnsA', $dnsA)->with('dnsMX', $dnsMX)->with('domainName', idn_to_utf8($domain->domain_name_ascii))->with('httpData', $httpData);
	}

	public function add(Request $request): View{
		return view('hostname.add');
	}

	public function store(StoreHostnameRequest $request): RedirectResponse{
		
		$url = $request->validated()['hostname'];
		
		# get host part of the url
		$host = parse_url($url, PHP_URL_HOST);

		# encode to punycode
		$punycodeHostname = idn_to_ascii($host);

		# get domain name
		$domainName = $punycodeHostname;
		preg_match('/(?P<domainName>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domainName, $hostnameParts);
		$domainName = $hostnameParts['domainName'];

		# create or retrieve the domain name data from the database
		$domain = Domain::firstOrCreate(['domain_name_ascii' => $domainName]);

		# associate the user with the domain name
		$domainId = $domain->id;
		$userId = $request->user()->id;
		$userDomain = UserDomain::firstOrCreate(['user_id' => $userId, 'domain_id' => $domainId]);
		
		return redirect()->back()->with(['status' => 'hostname-added', 'domain' => idn_to_utf8($domainName)]);
	}

}
