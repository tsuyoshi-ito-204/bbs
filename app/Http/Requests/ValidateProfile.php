<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProfile extends FormRequest
{
	public function authorize()
	{
	return true;
	}

	public function rules()
	{
        	return [
        		'name' => 'required|string|max:15',
                	'self_int' => '|max:200',
                        'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
		];
	}
	
	public function messages()
	{
		return [
        		'name.required' => '名前を入力してください',
                	'name.max' => '名前は15字以内にしてください',
	                'self_int.max' => '自己紹介は200字以内にしてください',
        	        'self_int.string' => '不正な値です',
 	                'image.file' => '画像のアップロードに失敗しました',
        	        'image.image' => '画像ファイルではありません',
 	                'image.mimes' => 'jpeg,png,jpg,gifのみ指定できます',
        	        'image.max' => '画像ファイルは１０Ｍまでです',
        	];
	}
}
