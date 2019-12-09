<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Article;
use App\Comment;

class ProfileControllerTest extends TestCase
{
	use DatabaseMigrations;
	
	public function setUp() :void
	{
		parent::setUp();
		
		$user = factory(User::class)->create();
		$article = factory(Article::class)->create();
		$comment = factory(Comment::class)->create();
		
		$user->articles()->save($article);
		$article->comments()->save($comment);
	}
	
	public function testIndex()
	{
		$user = User::find(1);
		
		$response = $this->get(route('profile',['name' => $user->name]));
		$response->assertOk();
	}
	
	public function testComment()
	{
		$user = User::find(1);
		
		$response = $this->get(route('profile.comment',['name' => $user->name]));
		$response->assertOk();
	}
	
	public function testFavorite()
	{
		$user = User::find(1);
		
		$response = $this->get(route('profile.favorite',['name' => $user->name]));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->get(route('profile.favorite',['name' => $user->name]));
		$response->assertOk();
	}
	
	public function testEdit()
	{
		$user = User::find(1);
		
		$response = $this->get(route('profile.edit'));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->get(route('profile.edit'));
		$response->assertOk();
	}
	
	public function testUpdate()
	{
		$user = User::find(1);
		$article = Article::find(1);
		$image = UploadedFile::fake()->image('profile.png');
		$postData = [
			'name' => 'なまえ',
			'self_int' => '自己紹介',
			'image' => $image,
		];
		
		$response = $this->post(route('profile.update'),$postData);
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->post(route('profile.update'),$postData);
		$response->assertRedirect(route('profile',['name' => 'なまえ']));
		
		$this->assertDatabaseHas('users',[
			'name' => 'なまえ',
			'self_int' => '自己紹介',
			'image' => 'users/' . $image->hashName(),
		]);
		
		Storage::delete($user->image);
	}
}
