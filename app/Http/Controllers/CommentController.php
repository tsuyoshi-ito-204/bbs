<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ValidateStoreComment;
use App\Http\Requests\ValidateUpdateComment;

class CommentController extends Controller
{
	public function store(ValidateStoreComment $request)
	{
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
	
	public function update(ValidateUpdateComment $request,$id)
	{
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
