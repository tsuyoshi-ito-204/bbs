<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		
		<title>{{ config('app.name', 'bbs') }}</title>
		
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	</head>
	<body>
		<div class="conteiner">
			<div class="row justify-content-center">
				<div class="col-md-8 mt-5">
					<h1 class="text-secondary text-center">退会しますか？</h1>
					<p class="text-center text-secondary mt-3">
						退会ボタンを押すとアカウントを削除します。<br>
						あなたが投稿した記事とコメントは削除されます。
					</p>
					<form action="{{ route('unsubscribe',['id' => $user->id]) }}" method="post">
						@csrf
						<div class="form-group">
							<div class="offset-4 mt-5">
								<a href="{{ route('profile',['name' => $user->name]) }}" class="btn btn-outline-primary btn-lg mr-5">キャンセル</a>
								<button type="submit" class="btn btn-outline-danger btn-lg">退会</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>