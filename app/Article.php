<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title','content'];
	
	static $rules = [
		'title' => 'required|string|max:20',
		'content' => 'required|string|max:800',
		'category' => 'required|string',
		'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
	];
	
	static $messages = [
		'title.required' => 'タイトルを入力してください',
		'title.string' => '不正な値です',
		'title.max' => 'タイトルは20文字以内にしてください',
		'content.required' => '記事を入力してください',
		'content.string' => '不正な値です',
		'content.max' => '記事は800文字以内にしてください',
		'category.required' => 'カテゴリを入力してください',
		'category.string' => '不正な値です',
		'image.file' => '画像のアップロードに失敗しました',
		'image.image' => '画像ファイルではありません',
		'image.mimes' => 'jpeg,png,jpg,gifのみ指定できます',
		'image.max' => '画像ファイルは１０Ｍまでです',
	];
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
	
	public function categories()
	{
		return $this->belongsToMany('App\Category','article_category');
	}
	
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}
	
	public function favorites()
	{
		return $this->belongsToMany('App\User');
	}
}
