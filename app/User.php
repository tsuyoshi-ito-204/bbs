<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Article;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	public function articles()
	{
		return $this->hasMany('App\Article');
	}
	
	public function comments()
	{
		return $this->hasMany('App\Comment');
	}
	
	public function favorites()
	{
		return $this->belongsToMany('App\Article');
	}
}
