<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUpdateComment extends FormRequest
{
	public function authorize()
	{
        	return true;
	}

	public function rules()
	{
        	return [
                        'comment' => 'required|string|max:800',
                        'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
                ];
	}

	public function messages()
	{
		return [
                        'comment.required' => 'コメントを入力してください',
                        'comment.string' =>     '文字列を入力してください',
                        'comment.max' => 'コメントは８００文字以内にしてください',
                        'image.file' => '画像のアップロードに失敗しました',
                        'image.image' => '画像ファイルではありません',
                        'image.mimes' => 'jpeg,png,jpg,gifのみ指定できます',
                        'image.max' => '画像ファイルは１０Ｍまでです',
                ];
	}
}
