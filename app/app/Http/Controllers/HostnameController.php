<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use App\Models\Domain;
use App\Models\UserDomain;
use App\Models\DNSRecord;
use App\Models\HttpData;
use App\Models\HtmlMetaData;
use App\Http\Requests\StoreHostnameRequest;
use Carbon\Carbon;
use App\Traits\DomainInfoTrait;
use Inertia\Inertia;
use Inertia\Response;

class HostnameController extends Controller
{
	use DomainInfoTrait;

	public function show(Request $request, Domain $domain): Response{

		$this->domain = $domain;

		if(! Gate::allows('view-domain-info', $this->domain)){
			abort(403);
		}

		$this->updateOrCreateDomainInformation();

		# fetch cached dns records
		$dnsA = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->get();
		$dnsMX = DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->get();

		# fetch data from http cache
		$httpData = $this->getHttpCache();
		
		# fetch data from html cache
		$htmlData = $this->getHtmlCache();

		# calculate seconds since last updates
		$currentServerTime = strtotime(date('Y-m-d H:i:s'));

		$updateTimeDNSA = $currentServerTime;
		$updateTimeDNSMX = $currentServerTime;
		$updateTimeHttp = $currentServerTime;
		$updateTimeHtml = $currentServerTime;
		
		if(!empty($dnsA[0])){
			$updateTimeDNSA = strtotime($dnsA[0]->updated_at);
		}
		if(!empty($dnsMX[0])){
			$updateTimeDNSMX = strtotime($dnsMX[0]->updated_at);
		}	
		if(!empty($httpData->response_code)){
			$updateTimeHttp = strtotime($httpData->updated_at);
		}
		if(!empty($htmlData[0])){
			$updateTimeHtml = strtotime($htmlData[0]->updated_at);
		}
		
		$updateAgeDNSA = floor($currentServerTime - $updateTimeDNSA);
		$updateAgeDNSMX = floor($currentServerTime - $updateTimeDNSMX);
		$updateAgeHttp = floor($currentServerTime - $updateTimeHttp);
		$updateAgeHtml = floor($currentServerTime - $updateTimeHtml);

		# render view
		return Inertia::render('DomainInfo', [
			'dnsA' => $dnsA,
			'dnsMX' => $dnsMX,
			'domainName' => idn_to_utf8($domain->domain_name_ascii),
			'httpData' => $httpData,
			'htmlData' => $htmlData,
			'updateAge' => [
				'a' => $updateAgeDNSA,
				'mx' => $updateAgeDNSMX,
				'http' => $updateAgeHttp,
				'html' => $updateAgeHtml
			]
		]);
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
		if(isset($hostnameParts['domainName'])){
			$domainName = $hostnameParts['domainName'];
		}else{
			return Redirect::back()->withErrors(['hostname' => 'The hostname field must be a valid URL.']);
		}

		# create or retrieve the domain name data from the database
		$domain = Domain::firstOrCreate(['domain_name_ascii' => $domainName]);

		# associate the user with the domain name
		$domainId = $domain->id;
		$userId = $request->user()->id;
		$userDomain = UserDomain::firstOrCreate(['user_id' => $userId, 'domain_id' => $domainId]);
		
		return redirect()->back()->with(['status' => 'hostname-added', 'domain' => idn_to_utf8($domainName)]);
	}

}
