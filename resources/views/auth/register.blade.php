@extends('layouts.auth')

@section('content')

<form action="{{ route('register') }}" method="POST" class="flex-fill form-validate-jquery ">
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="card mb-0">
				<div class="card-body">
                    @csrf

					<div class="text-center mb-3">
						<i class="icon-user-plus  icon-2x text-{{ config('app.theme') }} border-{{ config('app.theme') }} border-3 rounded-round p-3 mb-3 mt-1"></i>
						<h5 class="mb-0">Create New Account</h5>
						<span class="d-block text-muted">Mohon lengkapi semua isian dibawah</span>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group form-group-feedback form-group-feedback-right">
								<label for="">Email Address <button type="button" class="btn btn-icon rounded-round" data-popup="popover" data-placement="top" title="Petunjuk" data-trigger="hover" data-content="Masukan alamat email aktif yang sering Kamu gunakan. Kami akan mengirimkan verifikasi ke alamat email tersebut"><i class="icon-help"></i></button></label>
								<input id="email" type="email" class="form-control @error('email') is-invalid bounceIn @enderror" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

                            <div class="form-group">
								<label for="">Username </label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid bounceIn @enderror" name="username" placeholder="Enter your username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group">
								<label for="">Full Name </label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid bounceIn @enderror" name="name" placeholder="Enter your full name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>
						</div>
						<div class="col-sm-6">
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
						</div>
					</div>

					<div class="form-group">
						<input type="submit" class="btn  bg-{{ config('app.theme') }} btn-block" value="Create account">
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
		return true;
	}
</script>
@endsection

@section('scriptjs')
<script>
    var components = function () {
        var _componentValidation = function() {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }

            // Initialize
            var validator = $('.form-validate-jquery').validate({
                ignore: 'input[type=hidden], .select2-search__field', // ignore hidden fields
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                // success: function(label) {
                //     label.addClass('validation-valid-label').text('Valid'); // remove to hide Success message
                // },

                // Different components require proper error label placement
                errorPlacement: function(error, element) {
                    // Unstyled checkboxes, radios
                    if (element.parents().hasClass('form-check')) {
                        error.appendTo( element.parents('.form-check').parent() );
                    }
                    // Input with icons and Select2
                    else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                        error.appendTo( element.parent() );
                    }
                    // Input group, styled file input
                    else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                        error.appendTo( element.parent().parent() );
                    }
                    // Other elements
                    else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    password: {
                        minlength: 8
                    },
                    password_confirmation: {
                        equalTo: '#password'
                    },
                    email: {
                        email: true
                    },
                },
                messages: {
                    password: {
                        required: "Enter your password",
                        minlength: jQuery.validator.format("At least {0} characters required")
                    }
                },
                invalidHandler: function(form, validator) {
                    setTimeout(function(){ enableBtnSubmit(); }, 10);
                }
            });

            // Reset form
            $('#reset').on('click', function() {
                validator.resetForm();
            });
        };

        return {
            initComponents: function() {
                _componentValidation();
            }
        }
    }();

    $(document).ready(() => {
        components.initComponents();
    })

</script>
@endsection
