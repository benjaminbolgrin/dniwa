<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSetting;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
	$theme = 'light';
	if(Auth::user()){
		$userSetting = UserSetting::where('user_id', Auth::user()->id)->first();
		if(!empty($userSetting->theme)){
			$theme = $userSetting->theme;
		}
	}   	
        return array_merge(parent::share($request), [
		'auth' => [
			'user' => [
				'username'=> Auth::user()?->name,
				'theme' => $theme,
			]
		]
        ]);
    }
}
