<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Date;
use App\Models\Domain;
use App\Models\UserDomain;
use App\Models\DNSRecord;
use App\Models\HttpData;
use App\Models\HtmlMetaData;
use App\Http\Requests\StoreHostnameRequest;
use App\Jobs\UpdateCache;
use Inertia\Inertia;
use Inertia\Response;

class HostnameController extends Controller
{
	public function show(Request $request, Domain $domain): Response{

		$this->authorize('view', $domain);

		(new UpdateCache($domain))->handle();

		# get cached dns 'A' records
		$dnsA = $domain->dnsRecordsA()->get() ?? new DNSRecord();

		# get cached dns 'MX' records
		$dnsMX = $domain->dnsRecordsMX()->get() ?? new DNSRecord();
		
		# get cached http records
		$httpData = $domain->httpRecords()->first() ?? new HttpData();

		# get cached html meta data
		$htmlData = $domain->htmlMetaData()->get() ?? new HtmlMetaData();;

		# get current server time
		$currentServerTime = Date::now()->timestamp;
		
		# get seconds since last updates or set to current server time
		$updateTimeDNSA = Date::createFromFormat('Y-m-d H:i:s', $dnsA->first()->updated_at)->timestamp ?? $currentServerTime;
		$updateTimeDNSMX = Date::createFromFormat('Y-m-d H:i:s', $dnsMX->first()->updated_at)->timestamp ?? $currentServerTime;
		$updateTimeHttp = Date::createFromFormat('Y-m-d H:i:s', $httpData->updated_at)->timestamp ?? $currentServerTime;
		$updateTimeHtml = Date::createFromFormat('Y-m-d H:i:s', $htmlData->first()->updated_at)->timestamp ?? $currentServerTime;

		# calculate seconds since last updates
		$updateAgeDNSA = $currentServerTime - $updateTimeDNSA;
		$updateAgeDNSMX = $currentServerTime - $updateTimeDNSMX;
		$updateAgeHttp = $currentServerTime - $updateTimeHttp;
		$updateAgeHtml = $currentServerTime - $updateTimeHtml;

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
		$request->user()->domains()->attach($domain);
		
		return redirect()->back()->with(['status' => 'hostname-added', 'domain' => idn_to_utf8($domainName)]);
	}

}
