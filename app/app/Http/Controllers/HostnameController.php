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
		$currentServerTime = strtotime(date('Y-m-d H:i:s'));
		
		# get seconds since last updates or set to current server time
		$updateTimeDNSA = strtotime($dnsA->first()->updated_at) ?? $currentServerTime;
		$updateTimeDNSMX = strtotime($dnsMX->first()->updated_at) ?? $currentServerTime;
		$updateTimeHttp = strtotime($httpData->updated_at) ?? $currentServerTime;
		$updateTimeHtml = strtotime($htmlData->first()->updated_at) ?? $currentServerTime;

		# calculate seconds since last updates
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
