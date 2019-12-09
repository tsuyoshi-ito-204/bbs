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
use App\Category;

class ArticleControllerTest extends TestCase
{
	use DatabaseMigrations;
	
	protected function setUp() :void
	{
		parent::setUp();
		
		$user = factory(User::class)->create();
		$article = factory(Article::class)->create();
		$category = factory(Category::class)->create();
		
		$user->articles()->save($article);
		$article->categories()->attach($category->id);
	}
	
	public function testIndex()
	{
		$response = $this->get(route('article.index'));
		$response->assertOk();
		
		$response = $this->get('no_route');
		$response->assertNotFound();
	}
	
	public function testShow()
	{
		$article = Article::find(1);
		
		$response = $this->get(route('article.show',['id'=>$article->id]));
		$response->assertOk();
	}
	
	public function testCreate()
	{
		$response = $this->get(route('article.create'));
		$response->assertStatus(302);
		
		$user = User::find(1);
		$response = $this->actingAs($user)->get(route('article.create'));
		$response->assertOk();
	}
	
	public function testStore()
	{
		$user = User::find(1);
		$image = UploadedFile::fake()->image('store.jpg');
		$postData = [
			'title' => '数字',
			'category' => 'いち　に　さん',
			'content' => '１，２，３',
			'image' => $image,
		];
		
		$response = $this->post(route('article.store'),$postData);
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->post(route('article.store'),$postData);	
		$response->assertRedirect(route('article.show',['id' => 2]));
		
		$this->assertDatabaseHas('articles',[
			'title' => '数字',
			'content' => '１，２，３',
			'image' => 'article/' . $image->hashName(),
		]);
		
		$this->assertDatabaseHas('categories',[
			'name' => 'いち',
			'name' => 'に',
			'name' => 'さん',
		]);
		
		Storage::delete(Article::find(2)->image);
	}
	
	public function testEdit()
	{
		$user = User::find(1);
		$article = Article::find(1);
		
		$response = $this->get(route('article.edit',['id'=>$article->id]));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->get(route('article.edit',['id'=>$article->id]));
		$response->assertOk();
	}
	
	public function testUpdate()
	{
		$user = User::find(1);
		$article = Article::find(1);
		$image = UploadedFile::fake()->image('update.jpg');
		$postDate = [
			'title' => 'number',
			'category' => 'one two three',
			'content' => '１，２，３',
			'image' => $image,
		];
		
		$response = $this->put(route('article.update',['id' => $article->id]),$postDate);
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->put(route('article.update',['id' => $article->id]),$postDate);
		$response->assertRedirect(route('article.show',['id' => $article->id]));
		
		$this->assertDatabaseHas('articles',[
			'title' => 'number',
			'content' => '１，２，３',
			'image' => 'article/' . $image->hashName(),
		]);
		
		$this->assertDatabaseHas('categories',[
			'name' => 'one',
			'name' => 'two',
			'name' => 'three',
		]);
		
		Storage::delete($article->image);
	}
	
	public function testDestroy()
	{
		$user = User::find(1);
		$article = Article::find(1);
		
		$response = $this->delete(route('article.destroy',['id' => $article->id]));
		$response->assertStatus(302);
		
		$response = $this->actingAs($user)->delete(route('article.destroy',['id' => $article->id]));
		$response->assertRedirect(route('article.index'));
		
		$this->assertDatabaseMissing('articles',[
			'id' => 1,
		]);
	}
}