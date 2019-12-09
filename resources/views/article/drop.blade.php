@extends('layouts.app')
@section('content')
<p>{{ $article->title }}</p>
<p>{{ $article->content }}</p>
<form action="{{ route('article.destroy') }}" method="post">
	@csrf
	<input type="hidden" name="id" value="{{ $article->id }}">
	<input type="submit" value="削除">
</form>
@endsection