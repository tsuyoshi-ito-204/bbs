<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateArticle extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'title' => 'required|string|max:20',
			'content' => 'required|string|max:800',
			'category' => 'required|string',
			'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:10240'
		];
	}

	public function messages()
	{
		return [
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
	}

	public function withValidator($validator)
	{
		$requestAll = $validator->getData();
        	$categories = mb_convert_kana($requestAll['category'],'s');
                $categories_in_array = array_unique(preg_split('/[\s]+/',$categories,-1,PREG_SPLIT_NO_EMPTY));

                $addValidateData = array('array_categories' => $categories_in_array);
                $addValidateRule = array('array_categories' => 'max:5');
		foreach($categories_in_array as $key => $category){
                        $addValidateData += array_merge($addValidateData,array($key => $category));
			$addValidateRule += array_merge($addValidateRule,array($key => 'max:10'));
		}
                $validator->setData(array_merge($requestAll,$addValidateData));
		$validator->addRules($addValidateRule);

		$validator->after(function($validator) use ($categories_in_array){
			if(array_key_exists('array_categories',$validator->failed())){
				$validator->errors()->add('category','カテゴリーの数を減らしてください');
			}
			foreach($categories_in_array as $category){
				if(mb_strlen($category) >= 10){
					$validator->errors()->add('category','各カテゴリーは１０文字以下にしてください');
					break;
				}
			}
		});
       }

}
