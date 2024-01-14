<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserDomain;
use App\Models\Domain;

class DashboardTest extends TestCase
{
	use RefreshDatabase;

	public function test_authenticated_user_can_view_dashboard(): void {
		$user = User::factory()->create();
		$response = $this->actingAs($user)->get('/');

		$response->assertLocation('/');
	}

	public function test_unauthenticated_user_can_not_view_dashboard(): void{
		$response = $this->get('/');
		$response->assertStatus(302);
		$response->assertLocation('/signin');
	}

	public function test_user_can_add_valid_url(): void{
		$user = User::factory()->create();
		$url = 'http://your-example-url-001.org';
		$domainNameAscii = 'your-example-url-001.org';
		$response = $this->actingAs($user)->put('hostname', ['hostname' => $url]);
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseHas('domains', ['domain_name_ascii' => $domainNameAscii]);
	}

	public function test_user_can_not_add_invalid_url(): void{
		$user = User::factory()->create();
		$invalidUrl = 'http:/your-example-url-001.org';
		$domainNameAscii = 'your-example-url-001.org';
		$response = $this->actingAs($user)->put('hostname', ['hostname' => $invalidUrl]);
		$response->assertSessionHasErrors();
		$this->assertDatabaseMissing('domains', ['domain_name_ascii' => $domainNameAscii]);
	}

	public function test_user_can_delete_domain(): void {
		$user = User::factory()->create();
		$userDomain = UserDomain::factory()->create();
		$user->id = $userDomain->user_id;
		$domainId = $userDomain->domain_id;

		$this->assertDatabaseHas('user_domains', ['domain_id' => $domainId, 'user_id' => $user->id]);
		$response = $this->actingAs($user)->delete('/'.$domainId);
		$response->assertSessionHasNoErrors();
		$this->assertDatabaseMissing('user_domains', ['domain_id' => $domainId, 'user_id' => $user->id]);
	}
}
