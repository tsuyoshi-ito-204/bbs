<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UnsubscribeControllerTest extends TestCase
{
	use DatabaseMigrations;
	
	protected function setUp() :void
	{
		parent::setUp();
		
		factory(User::class)->create();
	}
	
	public function testConfirm()
	{
		$user = User::find(1);
		
		$response = $this->get(route('confirm'));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->get(route('confirm'));
		$response->assertOk();
	}
	
	public function testUnsubscribe()
	{
		$user = User::find(1);
		
		$response = $this->post(route('unsubscribe',['id' => $user->id]));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->post(route('unsubscribe',['id' => $user->id]));
		$response->assertRedirect('/');
		
		$this->assertDatabaseMissing('users',[
			'id' => 1,
		]);
	}
	
	/*
	assertStatus(302)をroute('login')にするかどうか
	RefreshDatabaseをDatabaseMigrationにするかどうか
	csrfなのに302でassertしていいのだろうか
	*/
}
