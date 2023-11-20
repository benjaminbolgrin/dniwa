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
use App\Http\Requests\StoreHostnameRequest;
use Carbon\Carbon;

class HostnameController extends Controller
{

	public function show(Request $request, Domain $domain): View{

		# check, if domain is on user's domain list
		if(!UserDomain::where('user_id', $request->user()->id)->where('domain_id', $domain->id)->exists()){
			abort(404);
		}

		$dnsA = [];
		$dnsMX = [];

		# check, if there are recent dns records for the domain
		if(DNSRecord::where('domain_id', $domain->id)->exists()){

			$dateTime15 = Carbon::now()->subMinutes(15);
			$dnsATemp = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->first();

			# check, if the dns records are not older than 15 minutes
			if($dnsATemp->updated_at->gt($dateTime15)){
				$dnsA = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->get();
				$dnsMX = DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->get();
				return view('hostname.show')->with('dnsA', $dnsA)->with('dnsMX', $dnsMX)->with('domainName', idn_to_utf8($domain->domain_name_ascii));
			}else{
				# delete cached records
				DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->delete();
				DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->delete();
			}
		}

		# fetch dns records
		$fetchDNSA = dns_get_record($domain->domain_name_ascii, DNS_A);
		$fetchDNSMX = dns_get_record($domain->domain_name_ascii, DNS_MX);

		# cache dns records
		foreach($fetchDNSA as $dnsRecord){
			$aRecord = DNSRecord::firstOrNew(['domain_id' => $domain->id, 'type' => 'A', 'content' => $dnsRecord['ip']]);
			$aRecord->save();
		}

		foreach($fetchDNSMX as $dnsRecord){
			$mxRecord = DNSRecord::firstOrNew(['domain_id' => $domain->id, 'type' => 'MX', 'content' => $dnsRecord['target']]);
			$mxRecord->save();
		}

		# fetch cached dns records
		$dnsA = DNSRecord::where('domain_id', $domain->id)->where('type', 'A')->get();
		$dnsMX = DNSRecord::where('domain_id', $domain->id)->where('type', 'MX')->get();

		# render view
		return view('hostname.show')->with('dnsA', $dnsA)->with('dnsMX', $dnsMX)->with('domainName', idn_to_utf8($domain->domain_name_ascii));
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
