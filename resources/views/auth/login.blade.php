@extends('layouts.auth')

@section('content')
<form method="POST" action="{{ route('login') }}" class="login-form form-validate-jquery">
	<div class="card mb-0">
		<div class="card-body mb-0">
            @csrf
			<div class="text-center mb-3">
				<img id="img-bg" src="{{ asset('images/icon-app.png') }}" style="max-height:150px;max-width:150px;" class="animation-medium animated fadeIn  " >
				<br/>
				<h5 class="mb-0 animated fadeIn animation-fast animation-delay-fast"><b>{{ config('app.name') }}</b></h5>
				<span class="d-block text-muted animated fadeIn animation-fast animation-delay-medium">Please enter your account below</span>
			</div>

			<div class="form-group animated @error('username') bounceIn @else a @enderror   animation-fast animation-delay-fast">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username"  name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>

			<div class="form-group  animated   animation-fast animation-delay-fast">
				<div class="input-group">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"  name="password" required autocomplete="current-password">
                    <span class="input-group-append">
                        <button class="btn btn-light" id="btnEye" type="button" title="Tekan untuk melihat password" value="0"><i class="icon-eye-blocked"></i></button>
                    </span>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
			</div>

			<div class="form-group animated fadeIn animation-fast animation-delay-medium">
                <div class="form-check form-check-switchery mb-2">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input-switchery"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} data-fouc>
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <input type="submit" class="btn  bg-{{ config('app.theme') }} btn-block  " value="Sign in">
			</div>
		</div>
	</div>
</form>
@endsection
@section('scriptjs')
<script>
    var components = function () {
        var _componentSwitchery = function() {
            if (typeof Switchery == 'undefined') {
                console.warn('Warning - switchery.min.js is not loaded.');
                return;
            }
            var elems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));
            elems.forEach(function(html) {
            var switchery = new Switchery(html);
            });
        };

        var _componentValidation = function() {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }

            var validator = $('.form-validate-jquery').validate({
                ignore: 'input[type=hidden], .select2-search__field',
                errorClass: 'validation-invalid-label',
                successClass: 'validation-valid-label',
                validClass: 'validation-valid-label',
                highlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                unhighlight: function(element, errorClass) {
                    $(element).removeClass(errorClass);
                },
                errorPlacement: function(error, element) {
                    if (element.parents().hasClass('form-check')) {
                        error.appendTo( element.parents('.form-check').parent() );
                    }
                    else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                        error.appendTo( element.parent() );
                    }
                    else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                        error.appendTo( element.parent().parent() );
                    }
                    else {
                        error.insertAfter(element);
                    }
                },
                rules: {
                    password: {
                        minlength: 8
                    }
                },
                messages: {
                    username: "Enter your username",
                    password: {
                        required: "Enter your password",
                    }
                },
                invalidHandler: function(form, validator) {
                    setTimeout(function(){ enableBtnSubmit(); }, 10);
                }
            });
            $('#reset').on('click', function() {
                validator.resetForm();
            });
        };

        return {
            initComponents: function() {
                _componentSwitchery();
                _componentValidation();
            }
        }
    }();

    $(document).ready(() => {
        components.initComponents();

        $('#btnEye').click(function() {
            let val = $(this).val();
            if(val == 0){
                $(this).val(1).html('<i class="icon-eye"></i>');
                $('#password').prop('type', 'text');
            }else{
                $(this).val(0).html('<i class="icon-eye-blocked"></i>');
                $('#password').prop('type', 'password');
            }
        });
    })

</script>
@endsection
