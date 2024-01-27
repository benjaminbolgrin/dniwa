<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreferencesUpdateRequest;
use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class PreferencesController extends Controller
{
	/**
	* Display the user's preferences form.
	*/
	public function edit(Request $request): Response{

		$userSetting = $request->user()?->userSettings()->get(['theme']);

		return Inertia::render('PreferencesEdit', [
			'userSetting' => $userSetting
		]);
	}

	/**
	* Update the user's preferences.
	*/
	public function update(PreferencesUpdateRequest $request): RedirectResponse{

		# get or create user's settings
		$userSetting = UserSetting::firstOrCreate(['user_id' => $request->user()?->id]);

		# save user's selected theme
		$userSetting->theme = $request->validated()['theme'];
		$userSetting->save();

		return Redirect::route('preferences.edit')->with('status', 'preferences-updated');
	}
}
