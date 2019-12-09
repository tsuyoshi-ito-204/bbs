@extends('layouts.app')
@section('content')
	<div class="container">
		<div class="row justify-content-center">
			<div class="mt-5">{{ $articles->links() }}</div>
		</div>
	
		<div class="justify-content-center row mt-5 py-5" style="background-color:#ffffff">
			<main class="col-10">
				<div class="dropdown text-right">
					<button class="btn btn-secondary dropdown-toggle" type="button" id="sort" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						{{ $sort }}
					</button>
					<div class="dropdown-menu" aria-labelledby="sort">
						<a class="dropdown-item" href="{{ route('article.index') . '?keyword=' . $keyword}}">新着順</a>
						<a class="dropdown-item" href="{{ route('article.index') . '?keyword=' . $keyword . '&sort=favorite' }}">お気に入り順</a>
					</div>
				</div>
				@if($articles->count() > 0)
					@foreach($articles as $article)
						<a href="{{ route('profile',['name'=>$article->user->name]) }}" style="text-decoration:none">
							<img src="{{ asset('storage/' . $article->user->image) }}" class="rounded my-3" width="50px" height="50px">
						</a>
						
						<a href="{{ route('article.show',['id'=>$article->id]) }}" class="ml-3" style="font-size:15pt">{{ $article->title }}</a>
					
						<div class="my-2" style="word-break:break-all">{{ mb_strimwidth($article->content,0,250,'…') }}</div>
						
						<div class="text-right">
							<small class="text-muted mr-4">{{ $article->created_at }}</small>
							<p class="d-inline">コメント{{ $article->withCount('comments')->find($article->id)->comments_count }}</p>
						</div>
						<hr>
					@endforeach
				@else
					<div class="h3 text-center mt-5">{{ $message }}</div>
				@endif
			</main>
		</div>
	</div>
@endsection
