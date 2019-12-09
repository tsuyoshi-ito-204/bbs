@extends('layouts.profile')
@section('userContent')

<ul class="nav nav-tabs nav-fill">
	<li class="nav-item">
		<a class="nav-link" href="{{ route('profile',['name'=>$user->name]) }}">投稿記事</a>
	</li>
	<li class="nav-item">
		<a class="nav-link active" href="{{ route('profile.comment',['name'=>$user->name]) }}">コメント</a>
	</li>
	@if(Auth::id() === $user->id)
		<li class="nav-item">
			<a class="nav-link" href="{{ route('profile.favorite',['name'=>$user->name]) }}">お気に入りの記事</a>
		</li>
	@endif
</ul>

<div class="mx-3 my-5">
	@if($comments->count() > 0)
		@foreach($comments as $comment)
			<div class="my-4">
				<div>
					<a class="mr-3" href="{{ route('article.show',['id' => $comment->article->id]) }}">{{ $comment->article->title }}</a>
					<p class="text-muted d-inline">にコメント</p>
				</div>
				<p class="my-2" style="word-break:break-all">{{ newLine(mb_strimwidth($comment->comment,0,250,'…')) }}</p>
				<div class="text-right">
					<small class="text-muted">{{ $comment->created_at }}</small>
				</div>
				<hr>
			</div>
		@endforeach
		{{ $comments->links() }}
	@else
		<p>まだコメントはありません</p>
	@endif
</div>
@endsection