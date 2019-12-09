<script src="{{ asset('js\show.js') }}"></script>
@extends('layouts.app')
@section('content')
<div class="container">
		<div class="justify-content-center row mt-5 py-5" style="background-color:#ffffff">
			<main class="col-10">
				@if(count($errors) > 0)
					@foreach($errors->all() as $error)
						<p style="color:red;">{{ $error }}</p>
					@endforeach
				@endif

				<a href="{{ route('profile',['name'=>$article->user->name]) }}" style="text-decoration:none">
					<image src="{{ asset('storage/' . $article->user->image) }}" class="rounded" height="50px" width="50px">
					<span>{{ $article->user->name }}</span>
				</a>
				
				<p class="text-muted" style="float:right">{{ $article->created_at }}に投稿</p>
				
				<h2 class="my-4">{{ $article->title }}</h2>

				<div style="display:inline-block;">
					@foreach($categories as $category)
						<a href="{{ route('article.index') . '?keyword=' . $category->name }}" class="mr-3 p-2 rounded"style="background-color:#dcdcdc;">{{ $category->name }}</a>
					@endforeach
				</div>
					
				<div class="my-5" style="word-wrap:break-word">{{ newLine($article->content) }}</div>
				
				@isset($article->image)
					<image src="{{ asset('storage/' . $article->image) }}" class="d-block mx-auto" width="auto" height="300px">
				@endisset
				
				<div class="text-right my-5">
					@auth
						<form action="{{ action('FavoriteController') }}" method="post" class="d-inline">
							@csrf
							<input type="hidden" name="article_id" value="{{ $article->id }}">
							{!! $favorite !!}
						</form>
					@endauth
					@if($article->user_id === Auth::id())
					
						<a href="{{ route('article.edit',['id'=>$article->id]) }}" class="btn btn-info text-white mx-2">編集</a>
								
						<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteArticle">削除</button>
					
						<div class="modal fade" id="deleteArticle">
							<div class="modal-dialog modal-dialog-centered" role="document">
								<div class="modal-content">
									<div class="modal-body">
										この記事を削除しますか？
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" onclick="document.getElementById('destroyForm').submit();">はい</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>	
										<form id="destroyForm" action="{{ route('article.destroy',['id'=>$article->id]) }}" method="post" class="d-none">
											@csrf
											@method('delete')
										</form>
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
				<h3>コメント一覧</h3>

				@if($comment_count > 0)
					@foreach($article->comments as $comment)
						<div class="my-4">
							<a href="{{ route('profile',['name'=>$comment->user->name]) }}" style="text-decoration:none">
								<img src="{{ asset('storage/' . $comment->user->image) }}" class="rounded" height="50px" width="50px">
								<span>{{ $comment->user->name }}</span>
							</a>
							
							<small class="text-muted" style="float:right">{{ $comment->created_at }}</small>
						
							<div style="display:block">
								<div class="border rounded bg-white my-3">
									<div class="p-3" style="word-wrap:break-word">{{ newLine($comment->comment) }}</div>
									
									@isset($comment->image)
										<img src="{{ asset('storage/' . $comment->image) }}" class="m-3" width="auto" height="200px">
									@endisset
								</div>
				
								@if($comment->user->id === Auth::id())
									<button class="btn btn-secondary mr-3" type="button" onclick="change(this,true);">編集</button>
									<button class="btn btn-secondary" type="button" data-toggle="modal" data-target="#deleteComment">削除</button>
								@endif
							</div>
								
							<div style="display:none">				
								<form action="{{ route('comment.update',['id' => $comment->id]) }}" method="post" enctype="multipart/form-data">
									@csrf
									@method('put')
									<div class="form-group">
										<textarea class="form-control my-3" name="comment" cols="50" rows="4" placeholder="コメントを入力してください">{{ $comment->comment }}</textarea>
									</div>
									
									<div class="form-group">
										<input type="file" class="form-control-file" name="image">
									</div>
									
									<button class="btn btn-secondary mr-3" type="submit">更新</button>
									<button class="btn btn-secondary" type="button" onclick="change(this,false);">キャンセル</button>	
								</form>
							</div>
							
							<div class="modal fade" id="deleteComment">
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-body">
											削除しますか？
										</div>
										
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" onclick="this.parentElement.nextElementSibling.submit();">はい</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">いいえ</button>
										</div>
										
										<form action="{{ route('comment.destroy',['id' => $comment->id]) }}" method="post" style="display:none">
											@csrf
											@method('delete');
										</form>
									</div>
								</div>
							</div>
						</div>				
					@endforeach
				@else
					<p>コメントがありません</p>
				@endif

				<div class="my-5">
					@auth
						<h3>コメントを投稿する</h3>
							
						<a href="{{ route('profile',['name' => Auth::user()->name]) }}" style="text-decoration:none">
							<img src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded" height="50px" width="50px">
							<span>{{ Auth::user()->name }}</span>
						</a>
							
						<form action="{{ route('comment.store') }}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group mt-3">
								<textarea class="form-control" name="comment" cols="50" rows="4" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
							</div>
							
							<div class="form-group">
								<input type="file" class="form-control-file" name="image">
							<div>
							
							<input type="hidden" name="article_id" value="{{ $article->id }}">
							
							<button class="btn btn-secondary my-3" type="submit">投稿</button>
						</form>			
					@else
						<p style="font-size:20px">コメントしますか？</p>
						<a class="mr-3" href="{{ route('login') }}">ログイン</a>
						<a href="{{ route('register') }}">新規登録</a>
					@endauth
				</div>
			</main>
		</div>
	</div>
@endsection
