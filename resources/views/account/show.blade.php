@extends('layouts.app')

@section('content')
<!-- Content area -->
<div class="content">
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar-light bg-transparent ">
                <div class="sidebar-content">
                    <div class="card">

                        <div class="card-body bg-{{ config('app.theme') }}-600 text-center card-img-top"
                            style="background-image: url({{ asset('global_assets/images/backgrounds/panel_bg.png') }}); background-size: contain;">
                            <div class="card-img-actions d-inline-block mb-1"   >
                                <div class="card-img-actions d-inline-block mb-3">
                                    <img class="img-fluid rounded-circle" src="{{ asset('assets/avatar/'.Auth::user()->avatar) }}" style="width:150px;height:150px;" alt="Not Found">
                                </div>
                            </div>
                            <h6 class="font-weight-semibold mb-0">{{ Auth::user()->name }} </h6>
                            <span class="d-block opacity-75">{{ Auth::user()->email }} </span>
                            <span class="d-block opacity-75">{{ Auth::user()->phone_number == '' ? 'Phone number not available' : Auth::user()->phone_number }} </span><br/>
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#modal_image_change">Change Photo Profile <i class="icon-pencil7"></i></button>
                        </div>

                        <div class="card-body p-4">
                            <b>Your Roles : </b>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <span class="badge bg-{{ config('app.theme') }} badge-lg ml-2">{{ strtoupper($v) }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title ">Update Profile</h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('account.update') }}" class="form-validate-ajax">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Name :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="form-control" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Username :</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="old-username" id="old-username" value="{{ Auth::user()->username }}" >
                                        <input type="text" name="username" id="username" value="{{ Auth::user()->username }}" class="form-control" autofocus readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Email :</label>
                                    <div class="col-lg-10">
                                        <input type="hidden" name="old-email" id="old-email" value="{{ Auth::user()->email }}" >
                                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="form-control" autofocus readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Phone Number :</label>
                                    <div class="col-lg-10">
                                        <input type="text" name="phone_number" id="phone_number" value="{{ Auth::user()->phone_number == '' ? '+62' : Auth::user()->phone_number }}" class="form-control" autofocus required>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn bg-{{ config('app.theme') }}-400 btn-submit">Submit <i class="icon-paperplane ml-2"></i></button>
                                    <button type="reset" class="btn btn-light ml-2">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title ">Change Password  <button id="tips-tool" type="button" class="btn btn-icon rounded-round tips-tool-pass" data-popup="popover" data-placement="top" title="Tips for a good password" data-trigger="hover" data-content="Use both upper and lowercase characters. Include at least one symbol (# $ ! % & etc...). Don't use dictionary words"><i class="icon-help"></i></button></h5>
                            <div class="header-elements">
                                <div class="list-icons">
                                    <a class="list-icons-item" data-action="collapse"></a>
                                    <a class="list-icons-item" data-action="remove"></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body" id="password_change">
                            <form method="POST" action="{{ route('account.pass') }}" class="form-validate-ajax-password">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Old Password :</label>
                                    <div class="col-lg-10">
                                        <input type="password" name="old_password" id="old_password" value="" class="form-control" autofocus required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">New Password : </label>
                                    <div class="col-lg-10">
                                        <input type="password" name="password" id="password" value="" class="form-control"  required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-form-label col-lg-2">Re-enter New Password :</label>
                                    <div class="col-lg-10">
                                        <input type="password" name="password_confirmation" id="password_confirmation" value="" class="form-control"  required>
                                    </div>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn bg-{{ config('app.theme') }}-400 btn-submit">Submit <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<form method="POST" action="{{ route('account.avatar') }}" class="form-ajax" enctype="multipart/form-data" >
@csrf
    <div id="modal_image_change" class="modal fade" tabindex="-1">
        <!-- enctype="multipart/form-data" -->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Photo Profile</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-semibold">Choose Image</label>
                        @if(!empty(Auth::user()->avatar))
                            <!-- edit -->
                            <input type="file" name="avatar" id="avatar" class="file-input-overwrite" url_file="{{ !empty(Auth::user()->avatar) ? asset('/assets/avatar/'.Auth::user()->avatar) : '' }}" caption="{{ !empty(Auth::user()->avatar) ? Auth::user()->avatar : '' }}" data-show-caption="false" data-show-upload="false"   data-fouc  />
                            <span class="form-text text-muted"> Only file <code>jpg</code>, <code>png</code> and <code>jpeg</code> extensions are allowed. Max size file 1MB</span>
                        @else
                            <!-- insert -->
                            <input type="file" name="avatar" id="avatar" class="file-input-extensions" data-show-caption="false" data-show-upload="false"  data-fouc  >
                            <span class="form-text text-muted"> Only file <code>jpg</code>, <code>png</code> and <code>jpeg</code> extensions are allowed. Max size file 1MB</span>
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-{{ config('app.theme') }}-400 btn-submit">Submit <i class="icon-paperplane ml-2"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scriptjs')
    <script>
    $(document).ready(() => {
       var validator = $('.form-validate-ajax-password').validate({
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
                phone_number: {
                    minlength: 10 //idn standart
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
            submitHandler: function(form) {
                submitHandlerAjaxPassword(form);
            }
        });
    })
    function submitHandlerAjaxPassword(form)
    {
        var notif = new Noty({
                    text: '<i class="fa fa-spinner fa-spin"></i> Loading',
                    type: 'info',
                    timeout: false,
                }).show();
        $('.btn-submit').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading');
        $('.btn-submit-back').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading');
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: new FormData($(form)[0]),
            success: function(data){
                // data = JSON.parse(data);
                $('meta[name="csrf-token"]').attr('content', data._token);
                $('input[name="_token"]').val(data._token);
                if(data.status == true) {
                    swalInit.fire("Success", data.message, "success").then((value) => {
                        if(data.return_url != '#') {
                            document.location.href=data.return_url
                        }
                        if(data.return_url == '#reset') {
                            $('.form-control').val('');
                        }
                    });
                } else  {
                    swalInit.fire("Failed", data.message, "error");
                }
                $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                notif.close();
                $('.modal').modal('hide')
            },
            cache: false,
            contentType: false,
            processData: false,
            error: function(data) {
                if(data == "" || data == null){
                }else{
                    swalInit.fire("Failed", data, "error");
                }
                $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                notif.close();
                $('.modal').modal('hide')
            },
            statusCode: {
                //to handle ci
                403: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                    $('.modal').modal('hide')
                },
                //to handle laravel
                419: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                    $('.modal').modal('hide')
                },
                422: function(response) {
                    let res = response.responseJSON.message;
                    swalInit.fire("Warning", res , "warning");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                    $('.modal').modal('hide')
                }
            }
        });
    }
    </script>
@endsection