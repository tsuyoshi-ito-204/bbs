<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FavoriteController extends Controller
{
	public function __invoke(Request $request)
	{
		$validate_rules = [
			'article_id' => 'integer',
		];
		$validate_messages = [
			'article_id.integer' => '不正な値です',
		];
		$this->validate($request,$validate_rules,$validate_messages);
		
		Auth::user()->favorites()->toggle($request->article_id);
		
		return redirect()->route('article.show',['id' => $request->article_id]);
	}
}
