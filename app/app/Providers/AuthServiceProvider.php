<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Domain;
use App\Models\UserDomain;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
	    Gate::define('view-domain-info', function(User $user, Domain $domain){
		    return UserDomain::where(['domain_id' => $domain->id, 'user_id' => $user->id])->exists();
	    });
    }
}
