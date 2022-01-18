@extends('layouts.auth')

@section('content')
<form action="{{ route('password.confirm') }}" method="POST" class="flex-fill ">
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="card mb-0">
				<div class="card-body">
                    @csrf

					<div class="text-center mb-3">
						<!-- <i class="icon-user-plus  icon-2x text-{{ config('app.theme') }} border-{{ config('app.theme') }} border-3 rounded-round p-3 mb-3 mt-1"></i> -->
						<h5 class="mb-0">{{ __('Confirm Password') }}</h5>
						<span class="d-block text-muted">{{ __('Please confirm your password before continuing.') }}</span>
					</div>
					<div class="row">
                        <div class="form-group">
                            <label for="password">Enter  Password  <button id="tips-tool" type="button" class="btn btn-icon rounded-round tips-tool-pass" data-popup="popover" data-placement="top" title="Tips for a good password" data-trigger="hover" data-content="Use both upper and lowercase characters. Include at least one symbol (# $ ! % & etc...). Don't use dictionary words"><i class="icon-help"></i></button></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid bounceIn @enderror" name="password" placeholder="Enter your password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
					</div>

					<div class="form-group">
						<input type="submit" class="btn  bg-{{ config('app.theme') }} btn-block" value="Confirm Password">
					</div>

					<div class="text-center">
						@if (Route::has('password.request'))
                            <a class="text-default" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection
