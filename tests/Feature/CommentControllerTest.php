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

class CommentControllerTest extends TestCase
{
	use DatabaseMigrations;
	
	protected function setUp() :void
	{
		parent::setUp();

		$user = factory(User::class)->create();
		$article = factory(Article::class)->create();
		$comment = factory(Comment::class)->create();
		
		$user->articles()->save($article);
		$article->comments()->save($comment);
	}
	
	public function testStore()
	{
		$user = User::find(1);
		$article = Article::find(1);
		$comment = Comment::find(1);
		$image = UploadedFile::fake()->image('store.png');
		$postData = [
			'article_id' => $article->id,
			'comment' => 'おはよう',
			'image' => $image,
		];
		
		$response = $this->post(route('comment.store'),$postData);
		$response->assertStatus(302);
	
		$response = $this->actingAs($user)->post(route('comment.store'),$postData);
		$response->assertRedirect('/');
		
		$this->assertDatabaseHas('comments',[
			'comment' => 'おはよう',
			'image' => 'comment/' . $image->hashName(),
		]);
		
		$insertRecord = DB::table('comments')->orderBy('id','desc')->first();
		Storage::delete($insertRecord->image);
	}
	
	public function testUpdate()
	{
		$user = User::find(1);
		$comment = Comment::find(1);
		$image = UploadedFile::fake()->image('update.png');
		$postData = [
			'comment' => 'こんばんは',
			'image' => $image,
		];
	
		$response = $this->put(route('comment.update',['id' => $comment->id]),$postData);
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->put(route('comment.update',['id' => $comment->id]),$postData);
		$response->assertRedirect('/');
		
		$this->assertDatabaseHas('comments',[
			'comment' => 'こんばんは',
			'image' => 'comment/' . $image->hashName(),
		]);
		
		Storage::delete($comment->image);
	}

	public function testDestroy()
	{
		$user = User::find(1);
		$comment = Comment::find(1);
		
		$response = $this->delete(route('comment.destroy',['id' => $comment->id]));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->delete(route('comment.destroy',['id' => $comment->id]));
		$response->assertRedirect('/');
		
		$this->assertDatabaseMissing('comments',[
			'id' => 1,
		]);
	}
}
