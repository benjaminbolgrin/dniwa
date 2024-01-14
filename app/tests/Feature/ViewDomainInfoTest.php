<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Domain;
use App\Models\User;
use App\Models\UserDomain;

class ViewDomainInfoTest extends TestCase
{
	use RefreshDatabase;

	public function test_authenticated_user_can_not_view_unauthorized_domain_info(): void{
		$user = User::factory()->create();
		$domain = Domain::factory()->create();

		$response = $this->actingAs($user)->get('/hostname/'.$domain->id);
		$response->assertStatus(403);
	}

	public function test_authenticated_user_can_view_authorized_domain_info(): void{
		$user = User::factory()->create();
		$userDomain = UserDomain::factory()->create(['user_id' => $user->id]);

		$response = $this->actingAs($user)->get('/hostname/'.$userDomain->domain_id);
		$response->assertStatus(200);
	}
}
