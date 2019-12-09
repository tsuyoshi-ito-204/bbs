<?php
use Illuminate\Support\HtmlString;

if(!function_exists('newLine')){
	function newLine(string $str): HtmlString
	{
		return new HtmlString(nl2br(e($str)));
	}
}
