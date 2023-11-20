<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\UserDomain;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	public function delete(Request $request, Domain $domain): RedirectResponse{
		$domainId = $domain->id;
		$userId = $request->user()->id;

		# check if the domain is on user's list
		if(!UserDomain::where('domain_id', $domainId)->where('user_id', $userId)->exists()){
			abort(404);
		}
		
		# delete domain from user's list
		$userDomain = UserDomain::where('domain_id', $domainId)->where('user_id', $userId)->first();
		$userDomain->delete();

		return redirect()->back()->with(['status' => 'domain-deleted', 'deletedDomain' => idn_to_utf8($domain->domain_name_ascii)]);
	}

	public function listDomains(Request $request): View{
		$domains = DB::table('user_domains')->leftJoin('domains', 'user_domains.domain_id', '=', 'domains.id')->where('user_domains.user_id', $request->user()->id)->get();
		$domainNames = array();
		foreach($domains as $domain){
			$domainArray = ['id' => $domain->domain_id,
					'name' => idn_to_utf8($domain->domain_name_ascii)];
			array_push($domainNames, $domainArray);
		}
		return view('dashboard')->with('domains', $domainNames);
	}
}
