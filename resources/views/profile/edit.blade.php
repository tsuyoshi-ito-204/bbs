@extends('layouts.app')
@section('content')
<div class="container">
		<div class="justify-content-center row mt-5 py-5" style="background-color:#ffffff">
			<main class="col-10">
		<form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
			@csrf
			
			<div class="form-group">
				<img src="{{ asset('storage/' . $user->image) }}" width="200px" height="200px">
				<div class="my-2">
					<input class="form-control-file" id="image" type="file" name="image" style="width:300px">
				</div>
			</div>

			<div class="form-group">
				<label for="name" class="col-form-label">名前</label>
				<input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{ $user->name }}" style="width:300px">
				
				@error('name')
					<strong class="invalid-feedback">
						{{ $message }}
					</strong>
				@enderror
			</div>
			
			<div class="form-group">
				<label for="self_int">自己紹介</label>
				<textarea class="form-control @error('self_int') is-invalid @enderror" id="self_int" name="self_int" cols="50" rows="10" placeholder="200字以内">{{ $user->self_int }}</textarea>
				
				@error('self_int')
					<strong class="invalid-feedback">
						{{ $message }}
					</strong>
				@enderror
			</div>
			
			<div>
				<input class="btn btn-secondary" type="submit" value="更新する">
			</div>
		</main>
	</div>
</div>
@endsection