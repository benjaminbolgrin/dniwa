<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Domain;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
	public function delete(Request $request, Domain $domain): RedirectResponse{
		
		# check if the domain is on user's list
		$this->authorize('delete', $domain);
		
		# delete domain from user's list
		$request->user()?->domains()->detach($domain);

		return redirect()->back()->with(['status' => 'domain-deleted', 'deletedDomain' => idn_to_utf8($domain->domain_name_ascii)]);
	}

	public function listDomains(Request $request): Response{
		
		# get user's domains
		$domains = $request->user()?->domains()->get(['domains.id', 'domain_name_ascii']) ?? array();

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
		return Inertia::render('Dashboard', ['domains' => $domainList]);
	}
}
