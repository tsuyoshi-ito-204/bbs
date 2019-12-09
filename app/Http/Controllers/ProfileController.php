<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;

class ProfileController extends Controller
{
	public function index($name)
	{	
		$user = User::where('name',$name)->first();
		$articles = $user->articles()->orderBy('created_at','desc')->paginate(10);
		$params = [
			'user' => $user,
			'articles' => $articles,
		];
		return view('profile.index',$params);
	}
	
	public function comment($name)
	{
		$user = User::where('name',$name)->first();
		$comments = User::with(['comments','comments.article'])
				->find($user->id)
				->comments()
				->orderBy('created_at','desc')
				->paginate(10);
				
		$params = [
			'user' => $user,
			'comments' => $comments,
		];
		return view('profile.comment',$params);
	}
	
	public function favorite($name)
	{
		$user = User::where('name',$name)->first();
		
		$favorites = User::with('favorites')
				->find($user->id)
				->favorites()
				->paginate(10);
				
		$param = [
			'user' => $user,
			'favorites' => $favorites,
		];
		return view('profile.favorite',$param);
	}
	
	public function edit()
	{
		$user = Auth::user();
		return view('profile.edit',['user'=>$user]);
	}
	
	public function update(Request $request)
	{
		$validate_rules = [
			'name' => 'required|string|max:15',
			'self_int' => '|max:200',
			'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
		];
		
		$validate_messages = [
			'name.required' => '名前を入力してください',
			'name.max' => '名前は15字以内にしてください',
			'self_int.max' => '自己紹介は200字以内にしてください',
			'self_int.string' => '不正な値です',
			'image.file' => '画像のアップロードに失敗しました',
			'image.image' => '画像ファイルではありません',
			'image.mimes' => 'jpeg,png,jpg,gifのみ指定できます',
			'image.max' => '画像ファイルは１０Ｍまでです',
		];
		$this->validate($request,$validate_rules,$validate_messages);
		$user = Auth::user();
		$user->name = $request->name;
		$user->self_int = $request->self_int;
		
		if(isset($request->image) && $request->image->isValid()){
			if($user->image !== "apps/default_profile.png"){
				Storage::delete($user->image);
			}
			$user->image = $request->image->store('users');
		}
		$user->save();
		return redirect()->route('profile',['name'=>$user->name]);
	}
}
