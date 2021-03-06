<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ValidateArticle;
use App\Article;
use App\User;
use App\Category;

class ArticleController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth')->except(['index','show']);
	}
	
	public function index(Request $request)
	{
		$keyword = $request->keyword;
		if($request->sort === 'favorite'){
			$sort = 'お気に入り順';
			$articles = $favorites = Article::with('favorites')
					->withCount('favorites')
					->orderBy('favorites_count','desc')
					->where('title','like','%'.$keyword.'%')
					->orWhere('content','like','%'.$keyword.'%')
					->paginate(10);
		}else{
			$sort = '新着順';
			$articles = Article::with(['categories','user'])
					->orderBy('created_at','desc')
					->where('title','like','%'.$keyword.'%')
					->orWhere('content','like','%'.$keyword.'%')
					->paginate(10);
		}
		$message = Article::all()->count() === 0 ? 'まだ投稿はありません' : '「' . $keyword . '」に一致する記事は見つかりませんでした。';
		$param = [
			'sort' => $sort,
			'message' => $message,
			'keyword' => $keyword,
			'articles' => $articles,
		];
		
		return view('article.index',$param);
	}
	
	public function show($id,Request $request)
	{	
		if(Auth::check()){
			$user = User::find(Auth::id());
			$favorite = is_null($user->favorites->find($id)) ? 
			'<button type="submit" class="btn btn-secondary">お気に入り登録</button>' : 
			'<button type="submit" class="btn btn-success">お気に入り解除</button>';
		}else{
			$favorite = null;
		}
		
		$article = Article::find($id);
		$categories = $article
			->load('categories:name')
			->categories()
			->orderBy('name')
			->get();
		$comment_count = $article->withCount('comments')->find($article->id)->comments_count;
		
		$param = [
			'favorite' => $favorite,
			'article' => $article,
			'categories' => $categories,
			'comment_count' => $comment_count,
		];
		
		return view('article.show',$param);
	}
	
	public function create(Request $request)
	{
		return view('article.create');
	}
	
	public function store(ValidateArticle $request)
	{
		$categories = mb_convert_kana($request->category,'s');
                $categories_in_array = array_unique(preg_split('/[\s]+/',$categories,-1,PREG_SPLIT_NO_EMPTY));	
		
		$article = new Article();
		$article->fill($request->all());
		$article->user()->associate(Auth::id());
		if(isset($request->image)){
			$article->image = $request->image->store('article');
		}
		$article->save();

		foreach($categories_in_array as $one_category){
			//無いなら新しくカテゴリ名を登録
			$category = Category::firstOrCreate(['name' => $one_category]);
			$article->categories()->attach($category->id);
		}
		return redirect()->route('article.show',['id' => $article->id]);
	}
	
	public function edit($id,Request $request)
	{
		$article = Article::find($id);
		
		if(Auth::id() !== $article->user->id){
			return redirect()->route('article.index');
		}

		$categories = $article->load('categories:name')->categories()->get();
		foreach($categories as $category){
			$cat_names[] = $category->name;
		}
		$categoryNames = implode(' ',$cat_names);
		$params = [
			'article' => $article,
			'categoryNames' => $categoryNames,
		];
		return view('article.edit',$params);
	}
	
	public function update($id,ValidateArticle $request)
	{
		
		$categories = mb_convert_kana($request->category,'s');
		$categories_in_array = array_unique(preg_split('/[\s]+/',$categories,-1,PREG_SPLIT_NO_EMPTY));	

		$article = Article::find($id);
		$article->fill($request->all());
		$article->user()->associate(Auth::user());
		if(isset($request->image)){
			if(isset($article->image)){
				Storage::delete($article->image);
			}
			$article->image = $request->image->store('article');
		}
		$article->save();
	
		$article->categories()->detach();
		foreach($categories_in_array as $one_category){
			$category = Category::firstOrCreate(['name' => $one_category]);
			$article->categories()->attach($category->id);
		}

		return redirect()->route('article.show',['article' => $id]);
	}
	
	public function destroy($id)
	{
		$article = Article::with('comments')->find($id);
		if(isset($article->image)){
			Storage::delete($article->image);
		}
		foreach($article->comments as $comment){
			if(isset($comment->image)){
				Storage::delete($comment->image);
			}
		}
		$article->delete();
		return redirect()->route('article.index');
	}
}
