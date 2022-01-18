@if (session('status'))
    <script>
        $(document).ready(() => {
            swalInit.fire("Success", `{{ session('status') }}`, "success");
        })
    </script>
@endif

<script>
    var components = function () {
        var _componentValidation = function() {
            if (!$().validate) {
                console.warn('Warning - validate.min.js is not loaded.');
                return;
            }

            // Initialize
            var validator = $('.form-validate-ajax').validate({
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

                errorPlacement: function(error, element) {
                    // Unstyled checkboxes, radios
                    if (element.parents().hasClass('form-check')) {
                        error.appendTo( element.parents('.form-check').parent() );
                    }
                    if (element.parents().hasClass('custom-checkbox')) {
                        error.appendTo( element.parents('.custom-checkbox').parent() );
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
                    submitHandlerAjax(form);
                }
            });
            
            $('.form-control').on('change', function(){
                $('#not_saved_alert').slideDown();
            });
            
            // Initialize
            var validator = $('.form-validate-ajax-update').validate({
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
                    submitHandlerAjaxUpdate(form);
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

    function submitHandlerAjax(form)
    {
        var notif = new Noty({
                    text: '<i class="icon-spinner4 spinner"></i> Loading',
                    type: 'info',
                    timeout: false,
                }).show();
        $('.btn-submit').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
        $('.btn-submit-back').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
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
                $('.modal').modal('hide');
                $('#not_saved_alert').slideUp();
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
                $('.modal').modal('hide');
                $('#not_saved_alert').slideUp();
            },
            statusCode: {
                //to handle ci
                403: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                },
                //to handle laravel
                419: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                },
                422: function(response) {
                    let res = response.responseJSON.message;
                    if(typeof response.responseJSON.errors.username  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.username;
                    }
                    if(typeof response.responseJSON.errors.email  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.email;
                    }
                    if(typeof response.responseJSON.errors.name  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.name;
                    }
                    if(typeof response.responseJSON.errors.code  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.code;
                    }
                    swalInit.fire("Warning", res , "warning");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                }
            }
        });
    }

    function submitHandlerAjaxUpdate(form)
    {
        var notif = new Noty({
                    text: '<i class="icon-spinner4 spinner"></i> Loading',
                    type: 'info',
                    timeout: false,
                }).show();
        $('.btn-submit').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
        $('.btn-submit-back').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
        $.ajax({
            type: 'PATCH',
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
                $('.modal').modal('hide');
                $('#not_saved_alert').slideUp();
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
                $('.modal').modal('hide');
                $('#not_saved_alert').slideUp();
            },
            statusCode: {
                //to handle ci
                403: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                },
                //to handle laravel
                419: function() {
                    swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                },
                422: function(response) {
                    let res = response.responseJSON.message;
                    if(typeof response.responseJSON.errors.username  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.username;
                    }
                    if(typeof response.responseJSON.errors.email  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.email;
                    }
                    if(typeof response.responseJSON.errors.name  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.name;
                    }
                    if(typeof response.responseJSON.errors.code  !== 'undefined'){
                        res += `<br/>`+response.responseJSON.errors.code;
                    }
                    swalInit.fire("Warning", res , "warning");
                    $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                    $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                    notif.close();
                }
            }
        });
    }

    $('.form-ajax').submit(function(e) {
        var notif = new Noty({
                        text: '<i class="icon-spinner4 spinner"></i> Loading',
                        type: 'info',
                        timeout: false,
                    }).show();
            $('.btn-submit').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
            $('.btn-submit-back').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: new FormData($(this)[0]),
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
                    $('.modal').modal('hide');
                    $('#not_saved_alert').slideUp();
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
                    $('.modal').modal('hide');
                    $('#not_saved_alert').slideUp();
                },
                statusCode: {
                    //to handle ci
                    403: function() {
                        swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                        $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                        $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                        notif.close();
                    },
                    //to handle laravel
                    419: function() {
                        swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                        $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                        $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                        notif.close();
                    },
                    422: function(response) {
                        let res = response.responseJSON.message;
                        if(typeof response.responseJSON.errors.avatar  !== 'undefined'){
                            res += `<br/>`+response.responseJSON.errors.avatar;
                        }
                        swalInit.fire("Warning", res , "warning");
                        $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                        $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                        notif.close();
                    }
                }
            });
        e.preventDefault();
    });

    $('.form-ajax-update').submit(function(e) {
        var notif = new Noty({
                        text: '<i class="icon-spinner4 spinner"></i> Loading',
                        type: 'info',
                        timeout: false,
                    }).show();
            $('.btn-submit').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
            $('.btn-submit-back').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading');
            $.ajax({
                type: 'PATCH',
                url: $(this).attr('action'),
                data: new FormData($(this)[0]),
                success: function(data){
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
                    $('.modal').modal('hide');
                    $('#not_saved_alert').slideUp();
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
                    $('.modal').modal('hide');
                    $('#not_saved_alert').slideUp();
                },
                statusCode: {
                    //to handle ci
                    403: function() {
                        swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                        $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                        $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                        notif.close();
                    },
                    //to handle laravel
                    419: function() {
                        swalInit.fire("Info", "Page expired. Mohon refresh page terlebih dahulu", "info");
                        $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                        $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                        notif.close();
                    },
                    422: function(response) {
                        let res = response.responseJSON.message;
                        if(typeof response.responseJSON.errors.avatar  !== 'undefined'){
                            res += `<br/>`+response.responseJSON.errors.avatar;
                        }
                        swalInit.fire("Warning", res , "warning");
                        $('.btn-submit').prop('disabled', false).html('Submit <i class="icon-paperplane ml-2"></i>');
                        $('.btn-submit-back').prop('disabled', false).html('Submit & Back <i class="icon-paperplane ml-2"></i>');
                        notif.close();
                    }
                }
            });
        e.preventDefault();
    });
</script>
