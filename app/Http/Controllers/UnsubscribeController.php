<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UnsubscribeController extends Controller
{
	public function confirm()
	{
		return view('unsubscribe.confirm',['user' => Auth::user()]);
	}
	
	public function unsubscribe($id)
	{
		User::find($id)->delete();
		return redirect('/');
	}
}
