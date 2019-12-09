<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['name'];
	
	function articles()
	{
		return $this->belongsToMany('App\Article','article_category');
	}
}
