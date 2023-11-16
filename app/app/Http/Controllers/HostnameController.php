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

		$parsedHostname = parse_url($hostname, PHP_URL_HOST);

		if($parsedHostname){
			$asciiHostname = idn_to_ascii($parsedHostname);
			if($asciiHostname){
				$domain = Domain::firstOrCreate(['domain_name_ascii' => $asciiHostname]);
				$domainId = $domain->id;
				$userId = $request->user()->id;
				$userDomain = UserDomain::firstOrCreate(['user_id' => $userId, 'domain_id' => $domainId]);
				return Redirect::route('hostname.add')->with('status', 'hostname-added');
			}
		}
		return Redirect::route('hostname.add')->with('status', 'hostname-invalid');
	}
}
