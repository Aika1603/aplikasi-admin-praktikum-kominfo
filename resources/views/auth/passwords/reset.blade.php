@extends('layouts.auth')

@section('content')
<form action="{{ route('password.update') }}" method="POST" class="flex-fill ">
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="card mb-0">
				<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <input type="hidden" name="token" value="{{ $token }}">

                    @csrf
					<div class="text-center mb-3">
						<i class="icon-spinner11  icon-2x text-{{ config('app.theme') }} border-{{ config('app.theme') }} border-3 rounded-round p-3 mb-3 mt-1"></i>
						<h5 class="mb-0">{{ __('Reset Password') }}</h5>
					</div>
                    <div class="form-group">
                        <label for="password">E-Mail Address </label>
                        <input id="email" type="email" placeholder="Enter email address" value="{{ $email ?? old('email') }}" class="form-control @error('email') is-invalid bounceIn @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Enter  Password  <button id="tips-tool" type="button" class="btn btn-icon rounded-round tips-tool-pass" data-popup="popover" data-placement="top" title="Tips for a good password" data-trigger="hover" data-content="Use both upper and lowercase characters. Include at least one symbol (# $ ! % & etc...). Don't use dictionary words"><i class="icon-help"></i></button></label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid bounceIn @enderror" name="password" placeholder="Enter your password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Re-enter  Password </label>
                        <input id="password-confirm" type="password" onkeyup="check_pass(this.value);" class="form-control" name="password_confirmation" placeholder="Re-enter your password" required autocomplete="new-password">
                        <span class="invalid-feedback" style="color:red;display:none;" id="alert-check-pass">Kedua password baru belum sama</span>
                    </div>

					<div class="form-group">
						<input type="submit" class="btn  bg-{{ config('app.theme') }} btn-block" value="Send Password Reset Link">
					</div>


					<div class="text-center">
						<a class="text-default" href="{{ route('login') }}"> <i class="icon-reply"></i> Back to Sign Page</a>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>
<script>
	const check_pass = (param) => {
		let pass = $('#password').val();
		if(pass != ""){
			$("#password-confirm").prop('required',true);
			$('.tips-tool-pass').popover('hide');
		}

		if (pass == param){
			$('#alert-check-pass').slideUp();
			$('.btn-submit').prop('disabled', false);
		} else {
			$('#alert-check-pass').slideDown();
			$('.btn-submit').prop('disabled', true);
		}
	}
</script>
@endsection
