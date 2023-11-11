<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserSetting;
use Illuminate\Support\Facades\View;

class PreferencesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
	if(!is_null($request->user())){
		$userId = $request->user()->id;
		$userPreferences = UserSetting::where('user_id', $userId)->first();
		View::share('userPreferences', $userPreferences);
	}
        return $next($request);
    }
}
