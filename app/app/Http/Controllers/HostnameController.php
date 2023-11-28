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
use App\Traits\DomainInfoTrait;

class HostnameController extends Controller
{
	use DomainInfoTrait;

	public function show(Request $request, Domain $domain): View{

		$this->domain = $domain;
		$this->updateOrCreateDomainInformation();

		# fetch cached dns records
		$dnsA = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->get();
		$dnsMX = DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->get();

		# fetch data from http cache
		$httpData = $this->getHttpCache();
		
		# fetch data from html cache
		$htmlData = $this->getHtmlCache();

		# render view
		return view('hostname.show')->with('dnsA', $dnsA)
			      			->with('dnsMX', $dnsMX)
						->with('domainName', idn_to_utf8($domain
						->domain_name_ascii))->with('httpData', $httpData)
						->with('htmlData', $htmlData);
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
