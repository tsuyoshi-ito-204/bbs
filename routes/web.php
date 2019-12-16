<?php

Route::get('/','RootController');

Auth::routes();

Route::resource('article','ArticleController');

Route::post('favorite','FavoriteController')->middleware('auth');

Route::resource('comment','CommentController')->only([
	'store','update','destroy'
])->middleware('auth');

Route::get('profile/{name}','ProfileController@index')->name('profile');
Route::get('profile/{name}/comment','ProfileController@comment')->name('profile.comment');
Route::get('profile/{name}/favorite','ProfileController@favorite')->name('profile.favorite')->middleware('auth');
Route::get('profile/edit/profile','ProfileController@edit')->name('profile.edit')->middleware('auth');
Route::post('profile/update/user','ProfileController@update')->name('profile.update')->middleware('auth');

Route::get('confirm','UnsubscribeController@confirm')->name('confirm')->middleware('auth');
Route::post('unsubscribe/{id}','UnsubscribeController@unsubscribe')->name('unsubscribe')->middleware('auth');
