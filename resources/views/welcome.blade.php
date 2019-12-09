@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="my-5">
			<h1>実装したもの</h1>
		</div>
	</div>
	<div class="row justify-content-around">
		<div class="border rounded bg-white col-md-4 p-4 my-3">
			<h3>記事</h3>
			<ul class="font-weight-bold">
				<li>検索</li>
				<li>ページネーション</li>
				<li>詳細表示</li>
				<li>新規投稿</li>
				<li>編集</li>
				<li>削除</li>
				<li>お気に入り登録</li>
			</ul>
		</div>
		
		<div class="border rounded bg-white col-md-4 p-4 my-3">
			<h3>記事コメント</h3>
			<ul class="font-weight-bold">
				<li>表示</li>
				<li>新規投稿</li>
				<li>編集</li>
				<li>削除</li>
			</ul>
		</div>
	</div>

	<div class="row justify-content-around">
		<div class="border rounded bg-white col-md-4 p-4 my-3">
			<h3>ユーザー</h3>
			<ul class="font-weight-bold">
				<li>新規登録</li>
				<li>ログイン、ログアウト</li>
				<li>アカウント削除</li>
				<li>プロフィール表示</li>
				<li>プロフィール編集</li>
			</ul>
		</div>
		
		<div class="border rounded bg-white col-md-4 p-4 my-3">
			<h3>テスト</h3>
			<p>各コントローラーのテスト</p>
				<ul class="font-weight-bold">
					<li>ステータスコードは正しいか</li>
					<li>DBに想定するデータがあるか</li>
				</ul>
		</div>
	</div>
</div>
@endsection