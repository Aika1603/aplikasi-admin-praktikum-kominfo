@extends('layouts.auth')

@section('content')
<div class="row bg-white animation-medium animated fadeIn">
    <div class="col-lg-6 p-3 mr-5" id="illustration" style="position:relative;width: 450px">
        <div class="text-teal p-3">
            <h1 class="" style="font-size:50px;margin-bottom:-15px;">
                <b>KERAH</b> <small style="font-size:25px;font-weight:lighter;">Administrator</small>  
            </h1>
            <small style="font-weight:lighter;font-size:25px;">(Kejar Reward AKHLAK)</small>
        </div>
        <img src="{{ asset('images/people.png') }}" style="width:100%;height:220px;position:absolute;bottom:-10px;" class="ml-3" >
    </div>
    <div class="col-lg-4 p-3 bg-white">
        <form method="POST" action="{{ route('login') }}" class="login-form form-validate-jquery">
            @csrf
            <div class="text-center mb-3">
                <img id="img-bg" src="{{ asset('images/icon-app.png') }}" style="max-height:150px;max-width:150px;" class="animation-medium  fadeIn  " >
                <br/>
                <h5 class="mb-0 mt-2  fadeIn animation-fast animation-delay-fast"><b>{{ config('app.name') }}</b></h5>
                <span class="d-block text-muted  fadeIn animation-fast animation-delay-medium">Please enter your account below</span>
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left  @error('username') bounceIn @else a @enderror   animation-fast animation-delay-fast">
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username/Email"  name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                <div class="form-control-feedback">
                    <i class="icon-user text-muted"></i>
                </div>
                @error('username')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group form-group-feedback form-group-feedback-left     animation-fast animation-delay-fast">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password"  name="password" required autocomplete="current-password">
                <div class="form-control-feedback">
                    <i class="icon-lock2 text-muted"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group  fadeIn animation-fast animation-delay-medium">
                <div class="form-check form-check-switchery mb-2">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input-switchery"  name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} data-fouc>
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <input type="submit" class="btn  bg-{{ config('app.theme') }} btn-block  " value="Sign in">
            </div>
        </form>
    </div>
</div>

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
                //     label.addClass('validation-valid-label').text(''); // remove to hide Success message
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
                    }
                },
                messages: {
                    username: "Enter your username",
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
                _componentSwitchery();
                _componentValidation();
            }
        }
    }();

    $(document).ready(() => {
        components.initComponents();
    })

</script>
@endsection
