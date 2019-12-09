<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'bbs') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<style>
		.content{
			display: -webkit-flex;
			display: flex;
			-webkit-justify-content: center;
			justify-content: center;
			-webkit-align-items: center;
			align-items: center;
		}
	</style>
</head>
<body>
	<nav class="navbar navbar-expand-md navbar-dark shadow-sm" style="background-color:#999999;">
		<div class="container">
			<a class="navbar-brand mx-5" href="{{ url('/') }}">
				{{ config('app.name', 'bbs') }}
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
				<span class="navbar-toggler-icon"></span>
			</button>
				
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<form class="form-inline my-2 my-lg-0" method="get" action="{{ route('article.index') }}">
						<div class="input-group">
							<input class="form-control" type="search" name="keyword" placeholder="キーワードを入力">
							<div class="input-group-append">
								<button class="btn btn-secondary" type="submit">検索</button>
							</div>
						</div>
					</form>
				</ul>
				@guest
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="{{ route('login') }}">{{ 'ログイン' }}</a>
						</li>
						@if (Route::has('register'))
							<li class="nav-item">
								<a class="nav-link" href="{{ route('register') }}">{{ '新規登録' }}</a>
							</li>
						@endif
					</ul>
				@else
					<a href="{{ route('article.create') }}" class="btn btn-outline-dark mx-xl-3 mx-lg-2 mx-sm-0">投稿する</a>
					
					<ul class="navbar-nav">
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
								<image src="{{ asset('storage/' . Auth::user()->image) }}" class="rounded" style="width:40px; height:40px; ">
								<span class="caret"></span>
							</a>

							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('profile',['name'=>Auth::user()->name]) }}">マイページ</a>
										
								<a class="dropdown-item" href="{{ route('logout') }}"
															onclick="event.preventDefault();
															document.getElementById('logout-form').submit();">
															ログアウト
								</a>

								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									@csrf
								</form>
							</div>
						</li>
					</ul>
				@endguest
			</div>
		</div>
	</nav>
		
	@yield('content')
	
</body>
</html>
