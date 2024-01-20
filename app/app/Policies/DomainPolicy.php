<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Domain;
use App\Models\UserDomain;
use Illuminate\Auth\Access\HandlesAuthorization;

class DomainPolicy
{
	use HandlesAuthorization;

	public function view(User $user, Domain $domain): bool{
		return UserDomain::where(['user_id' => $user->id, 'domain_id' => $domain->id])->exists();
	}

	public function delete(User $user, Domain $domain): bool{
		return UserDomain::where(['user_id' => $user->id, 'domain_id' => $domain->id])->exists();
	}
}
