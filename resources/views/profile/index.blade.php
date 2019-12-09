@extends('layouts.profile')
@section('userContent')
<ul class="nav nav-tabs nav-fill">
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('profile',['name'=>$user->name]) }}">投稿記事</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('profile.comment',['name'=>$user->name]) }}">コメント</a>
	</li>
	@if(Auth::id() === $user->id)
		<li class="nav-item">
			<a class="nav-link" href="{{ route('profile.favorite',['name'=>$user->name]) }}">お気に入りの記事</a>
		</li>
	@endif
</ul>
	
<div class="mx-3 my-5">
	@if($articles->count() > 0)
		@foreach($articles as $article)
			<div class="my-4">
				<a href="{{ route('article.show',['id'=>$article->id]) }}" style="font-size:15pt">{{ $article->title }}</a>			
				<p class="my-2" style="word-break:break-all">{{ newLine(mb_strimwidth($article->content,0,250,'…')) }}</p>
				<div class="text-right">
					<small class="text-muted">{{ $article->created_at }}</small>
				</div>
				<hr>
			</div>
		@endforeach
	{{ $articles->links() }}
	@else
		<p>まだ投稿はありません</p>
	@endif
</div>
@endsection