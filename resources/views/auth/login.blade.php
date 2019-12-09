@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card m-5">
				<div class="card-body p-5">
					<h3 class="card-title text-secondary">ログイン</h3>
						
					<form method="post" action="{{ route('login') }}">
						@csrf

						<div class="form-group">
							<label for="email" class="col-form-label">メールアドレス</label>
							<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

							@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<label for="password" class="col-form-label">パスワード</label>
							<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

							@error('password')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
						</div>

						<div class="form-group">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
								<label class="form-check-label" for="remember">次回から自動でログイン</label>
							</div>
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-primary">
								ログイン
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </div>
</div>
@endsection
