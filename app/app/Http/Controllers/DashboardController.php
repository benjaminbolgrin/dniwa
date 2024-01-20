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
		
		# get user's domains
		$domains = Domain::whereRelation('users', 'users.id', $request->user()->id)->get();

		# create a domain list, containing only the fields 'id' and 'name'
		# encode punycode names to international domain name
		$domainList = array();
		foreach($domains as $domain){
			$domainArray = [
				'id' => $domain->id,
				'name' => idn_to_utf8($domain->domain_name_ascii)
			];
			$domainList[] = $domainArray;
		}

		# sort domain list by name ascending
		array_multisort(
			array_column($domainList, 'name'), SORT_ASC,
			$domainList
		);

		return Inertia::render('Dashboard', ['domains' => $domainList]);
	}
}
