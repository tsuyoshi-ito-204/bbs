@extends('layouts.app')
@section('content')
	@foreach($items as $item)
		<a href="{{ route('article.detail',['id'=>$item->id]) }}">{{ $item->title }}</a>
		<p>{{ $item->content }}</p>
	@endforeach
@endsection