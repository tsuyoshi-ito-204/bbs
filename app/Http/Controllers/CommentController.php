<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommentController extends Controller
{
	public function store(Request $request)
	{
		$validate_rules = [
			'article_id' => 'integer',
			'comment' => 'required|string',
			'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
		];
		$validate_messages = [
			'article_id.integer' => '不正な値です',
			'comment.required' => 'コメントを入力してください',
			'comment.string' =>	'文字列を入力してください',
			'image.file' => '画像のアップロードに失敗しました',
			'image.image' => '画像ファイルではありません',
			'image.mimes' => 'jpeg,png,jpg,gifのみ指定できます',
			'image.max' => '画像ファイルは１０Ｍまでです',
		];
		$this->validate($request,$validate_rules,$validate_messages);

		$comment = new Comment();
		$comment->fill($request->all());
		$comment->article()->associate(Article::find($request->article_id));
		$comment->user()->associate(Auth::user());
		if(isset($request->image)){
			$comment->image = $request->image->store('comment');
		}
		$comment->save();

		return back();
	}
	
	public function update(Request $request,$id)
	{
		$rules = [
			'comment' => 'required|string|max:800',
			'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
		];
		$messages = [
			'comment.required' => 'コメントを入力してください',
			'comment.string' => '不正な値です',
			'comment.max' => 'コメントは８００文字以内にしてください',
			'image.file' => '画像のアップロードに失敗しました',
			'image.image' => '画像ファイルではありません',
			'image.mimes' => 'jpeg,png,jpg,gifのみ指定できます',
			'image.max' => '画像ファイルは１０Ｍまでです',
		];
		$this->validate($request,$rules,$messages);
		$comment = Comment::find($id);
		$comment->fill($request->all());
		if(isset($request->image)){
			if(isset($comment->image)){
				Storage::delete($comment->image);
			}
			$comment->image = $request->image->store('comment');
		}
		$comment->save();
		return back();
	}
	
	public function destroy($id)
	{
		$comment = Comment::find($id);
		if(isset($comment->image)){
			Storage::delete($comment->image);
		}
		$comment->delete();
		return back();
	}
}
