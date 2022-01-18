@extends('layouts.auth')

@section('content')
<form action="{{ route('password.email') }}" method="POST" class="flex-fill form-validate-jquery ">
	<div class="row">
		<div class="col-lg-6 offset-lg-3">
			<div class="card mb-0">
				<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @csrf
					<div class="text-center mb-3">
						<i class="icon-spinner11  icon-2x text-{{ config('app.theme') }} border-{{ config('app.theme') }} border-3 rounded-round p-3 mb-3 mt-1"></i>
						<h5 class="mb-0">{{ __('Reset Password') }}</h5>
					</div>
                    <div class="form-group">
                        <label for="password">E-Mail Address </label>
                        <input id="email" type="email" placeholder="Enter email address" class="form-control @error('email') is-invalid bounceIn @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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
