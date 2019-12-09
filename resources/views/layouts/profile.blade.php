@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row my-5">
		<div class="col-lg-3">
			<img src="{{ asset('storage/' . $user->image) }}" class="d-block" width="200px" height="200px">
			
			@auth
				@if(Auth::user()->name === $user->name)
					<div class="mt-5">
						<a href="{{ route('profile.edit') }}" class="text-secondary">
							<p class="d-inline">プロフィールを編集する</p>
						</a>
						
						<hr>
							
						<a href="{{ route('confirm') }}" class="text-secondary">
							<p>アカウントを削除する</p>
						</a>
						<hr>
					</div>
				@endif
			@endauth
		</div>
		
		<div class="col-lg-9">
			<div>
				<h2 class="text-muted">{{ $user->name }}</h2>
			</div>
			
			<div class="mt-5">
				<p class="text-muted">自己紹介:</p>
				<p class="border border-white rounded bg-white p-3" style="word-break:break-all; height:130px">{{ isset($user->self_int) ? $user->self_int : '' }}</p>
			</div>
		</div>
	</div>

	@yield('userContent')
</div>	
@endsection