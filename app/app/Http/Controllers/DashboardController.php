<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\UserDomain;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
	public function delete(Request $request, Domain $domain): RedirectResponse{
		
		# check if the domain is on user's list
		$this->authorize('delete', $domain);
		
		# delete domain from user's list
		$request->user()->domains()->detach($domain);

		return redirect()->back()->with(['status' => 'domain-deleted', 'deletedDomain' => idn_to_utf8($domain->domain_name_ascii)]);
	}

	public function listDomains(Request $request): Response{
		$domains = DB::table('user_domains')->leftJoin('domains', 'user_domains.domain_id', '=', 'domains.id')->where('user_domains.user_id', $request->user()->id)->orderBy('domain_name_ascii')->get();
		$domainNames = array();
		foreach($domains as $domain){
			$domainArray = ['id' => $domain->domain_id,
					'name' => idn_to_utf8($domain->domain_name_ascii)];
			array_push($domainNames, $domainArray);
		}
		return Inertia::render('Dashboard', ['domains' => $domainNames]);
	}
}
