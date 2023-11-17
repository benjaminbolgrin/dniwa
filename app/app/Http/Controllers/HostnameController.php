<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Domain;
use App\Models\UserDomain;
use App\Http\Requests\StoreHostnameRequest;

class HostnameController extends Controller
{
	public function add(Request $request): View{
		return view('hostname.add');
	}

	public function store(StoreHostnameRequest $request): RedirectResponse{
		
		$hostname = $request->validated()['hostname'];

		if(strpos($hostname, '://')===false){
			$hostname = "http://".$hostname;
		}

		# Have to encode with the idn_to_ascii method once,
		# though it will return an incorrect result, when the protocol prefix exists.
		# We need the protocol prefix for the filter_var method to work correctly
		$asciiDomain = idn_to_ascii($hostname);

		if(filter_var($asciiDomain, FILTER_VALIDATE_URL)){
			# Now we have to to use the parse_url method on the url, to strip it of any protocol prefix
			$parsedHostname = parse_url($hostname, PHP_URL_HOST);

			if($parsedHostname){
				$asciiHostname = idn_to_ascii($parsedHostname);
				if($asciiHostname){
					$domain = Domain::firstOrCreate(['domain_name_ascii' => $asciiHostname]);
					$domainId = $domain->id;
					$userId = $request->user()->id;
					$userDomain = UserDomain::firstOrCreate(['user_id' => $userId, 'domain_id' => $domainId]);
					return redirect()->back()->with(['status' => 'hostname-added', 'domain' => $hostname]);
				}
			}
		}
		return redirect()->back()->withInput()->with('status', 'hostname-invalid');
	}
}
