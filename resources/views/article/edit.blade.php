@extends('layouts.app')
@section('content')
<div class="container">
		<div class="justify-content-center row mt-5 py-5" style="background-color:#ffffff">
			<main class="col-10">
				<form action="{{ route('article.update',['id'=>$article->id]) }}" method="post" enctype="multipart/form-data">
					@csrf
					@method('put')
					
					<div class="form-group">
						<input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $article->title }}" placeholder="タイトル" style="width:500px">
						
						@error('title')
							<strong class="invalid-feedback">
								{{ $message }}
							</strong>
						@enderror
					</div>

					<div class="form-group">
						<input type="text" name="category" class="form-control @error('category') is-invalid @enderror" value="{{ $categoryNames }}" placeholder="カテゴリ　スペースで区切って５つまで登録できます" style="width:500px">
						
						@error('category')
							<strong class="invalid-feedback">
								{{ $message }}
							</strong>
						@enderror
					</div>
					
					<div class="form-group">	
						<textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" cols="75" rows="13" placeholder="投稿記事">{{ $article->content }}</textarea>
						
						@error('content')
							<strong class="invalid-feedback">
								{{ $message }}
							</strong>
						@enderror
					</div>
					
					<div class="form-group">
						<input type="file" class="form-control-file @error('image') is-invalid @enderror" name="image">
						
						@error('image')
							<strong class="invalid-feedback">
								{{ $message }}
							</strong>
						@enderror
					</div>
					
					<button type="submit" class="btn btn-secondary">
						投稿する
					</button>
				</form>
			</main>
		</div>
	</div>
@endsection