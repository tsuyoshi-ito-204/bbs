<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class RootController extends Controller
{
	public function __invoke(){
		return view('welcome');
	}
}
