<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Models\Domain;
use App\Http\Requests\StoreHostnameRequest;
use App\Jobs\UpdateCaches;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Resources\DomainResource;

class HostnameController extends Controller
{
	public function show(Request $request, Domain $domain): Response{

		$this->authorize('view', $domain);

		(new UpdateCaches($domain))->handle();

		# render view
		return Inertia::render('DomainInfo', [
			'domainInfo' => new DomainResource($domain)
		]);
	}

	public function store(StoreHostnameRequest $request): RedirectResponse{
		
		$url = $request->validated()['hostname'];
		
		# get host part of the url
		$host = parse_url($url, PHP_URL_HOST);

		# encode to punycode
		$punycodeHostname = is_string($host) ? idn_to_ascii($host) : '';

		# get domain name
		$domainName = is_string($punycodeHostname) ? $punycodeHostname : '';
		preg_match('/(?P<domainName>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domainName, $hostnameParts);
		if(isset($hostnameParts['domainName'])){
			$domainName = $hostnameParts['domainName'];
		}else{
			return Redirect::back()->withErrors(['hostname' => 'The hostname field must be a valid URL.']);
		}

		# create or retrieve the domain name data from the database
		$domain = Domain::firstOrCreate(['domain_name_ascii' => $domainName]);

		# associate the user with the domain name
		$request->user()?->domains()->attach($domain);

		# send an 'UpdateCache' job to the queue
		UpdateCaches::dispatch($domain);
		
		return redirect()->back()->with(['status' => 'hostname-added', 'domain' => idn_to_utf8($domainName)]);
	}

}
