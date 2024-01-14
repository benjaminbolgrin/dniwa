<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\UserSetting;
use App\Models\User;
use Illuminate\Support\Str;

class UserSettingTest extends TestCase
{
	use RefreshDatabase;

	public function test_authenticated_user_can_view_preferences(): void{
		$userSetting = UserSetting::factory()->create();
		$user = User::factory()->create();
		$user->id = $userSetting->user_id;

		$response = $this->actingAs($user)->get('/preferences');
		$response->assertStatus(200);
	}

	public function test_unauthenticated_user_can_not_view_preferences(): void{
		$response = $this->get('/preferences');
		$response->assertStatus(302);
		$response->assertLocation('/signin');
	}

	public function test_authenticated_user_can_select_valid_theme(): void{
		$userSetting = UserSetting::factory()->create();
		$user = User::factory()->create(['id' => $userSetting->user_id]);
		$selectedTheme = rand(0,1) ? 'light' : 'dark';

		$response = $this->actingAs($user)->patch('/preferences', ['theme' => $selectedTheme]);
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas('user_settings', [
			'user_id' => $user->id,
			'theme' => $selectedTheme
		]);
	}

	public function test_authenticated_user_can_not_select_invalid_theme(): void{
		$userSetting = UserSetting::factory()->create();
		$user = User::factory()->create(['id' => $userSetting->user_id]);
		$selectedTheme = Str::random();

		$response = $this->actingAs($user)->patch('/preferences', ['theme' => $selectedTheme]);
		$response->assertSessionHasErrors();
		$this->assertDatabaseMissing('user_settings', [
			'user_id' => $user->id,
			'theme' => $selectedTheme
		]);
	}
}
