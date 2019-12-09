<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Article;

class FavoriteControllerTest extends TestCase
{
	use RefreshDatabase;
	
	public function testFavorite()
	{
		$user = factory(User::class)->create();
		$article = factory(Article::class)->create();
		
		$request = $this->post('favorite',['article_id' => $article->id]);
		$request->assertStatus(302);
		
		$request = $this->actingAs($user)->post('favorite',['article_id' => $article->id]);
		$request->assertRedirect(route('article.show',['id' => $article->id]));
		
		$this->assertDatabaseHas('article_user',[
			'article_id' => $article->id,
			'user_id' => $user->id,
		]);
		
		//お気に入り解除
		$this->actingAs($user)->post('favorite',['article_id' => $article->id]);
		$this->assertDatabaseMissing('article_user',[
			'article_id' => $article->id,
			'user_id' => $user->id,
		]);
	}
}
