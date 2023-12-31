<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PreferencesUpdateRequest;
use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class PreferencesController extends Controller
{
    /**
     * Display the user's preferences form.
     */
    public function edit(Request $request): Response
    {

	$userSetting = UserSetting::where('user_id', $request->user()->id)->first();
	
	return Inertia::render('PreferencesEdit', [
            'userSetting' => $userSetting
        ]);
    }

    /**
     * Update the user's preferences.
     */
    public function update(PreferencesUpdateRequest $request): RedirectResponse
    {
	$userId = $request->user()->id;

	$userSetting = UserSetting::where('user_id', $userId)->first();
	
	if(is_null($userSetting)){
		$userSetting = new UserSetting;
		$userSetting->user_id = $userId;
	}

	$userSetting->theme = $request->validated()['theme'];
	$userSetting->save();

        return Redirect::route('preferences.edit')->with('status', 'preferences-updated');
    }

}
