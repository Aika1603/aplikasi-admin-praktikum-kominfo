<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title content="{{ $title ?? 'Landing' }} - {{ config('app.name', 'Laravel') }}">{{ $title ?? 'Landing' }} - {{ config('app.name', 'Laravel') }}</title>

    <link href="{{ asset('images/icon.png') }}" rel="shortcut icon"  />

    <link rel="manifest" href="{{ asset('manifest.json') }}">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/material/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('global_assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('assets/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/notifications/noty.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/validation/validate.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/ui/moment/moment.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/styling/switch.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/uploaders/fileinput/plugins/purify.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/uploaders/fileinput/plugins/sortable.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/uploaders/fileinput/fileinput.min.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/pickers/color/spectrum.js') }}"></script>
	<script src="{{ asset('global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/uploader_bootstrap.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/media/fancybox.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/plugins/forms/selects/bootstrap_multiselect.js') }}"></script>

	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('global_assets/js/demo_pages/form_select2.js') }}"></script>

    <style>
        .fc-event-time, .fc-event-title {
        padding: 0 1px;
        white-space: normal;
        }

        .note-group-select-from-files {
            display: none;
        }
        .table-nowrap { white-space: nowrap; }
        @media (max-width:768px){
            .icon-field {
                display:none;
            }
        }
        .tab-content>.tab-pane {
            display: block;
            height: 0;
            overflow: scroll;
        }
        .tab-content>.tab-pane.active {
            height: auto;
        }
        .dataTables_processing {
        top: 64px !important;
        z-index: 11000 !important;
    }
    </style>

    <script>
        const enableBtnSubmit = () => {
            $('input[type=submit]').prop('disabled', false).val('Resend');
            $('button[type=submit]').prop('disabled', false).html('Resend');
        }

        const swalInit = swal.mixin({
            buttonsStyling: true,
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-light'
        });

        const basicDT = () => {
            if (!$().DataTable) {
                console.warn('Warning - datatables.min.js is not loaded.');
                return;
            }

            const dtable = $('.datatable').DataTable({
                autoWidth: false,
                select: false,
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                },
                lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            // Setting datatable defaults
            $.extend( $.fn.dataTable.defaults, {
                autoWidth: false,
                select: true,
                dom: '<"datatable-header"fBl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                },
                lengthMenu : [[10, 25, 50, -1], [10, 25, 50, "All"]]
            });

            const table = $('.datatable-button-html5-columns').DataTable();

            table.on('click', '[data-toggle=confirm]', function() {
                address = $(this).attr('data-address');
                message = $(this).attr('data-message');
                swalInit.fire({
                    title: 'Are you sure?',
                    text: message,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    if(result.value) {
                        var notif = new Noty({
                                        text: '<i class="fa fa-spinner fa-spin"></i> Loading',
                                        type: 'info',
                                        timeout: false,
                                    }).show();
                        //add notify here
                        $.ajax({
                        type: "GET",
                        url: address,
                        success: function(data) {
                                // data = JSON.parse(data);
                                if(data.status == 1) {
                                    swalInit.fire("Success!", 'Process successful', "success").then((value) => {
                                        if(data.return_url != '#') {
                                            window.location.replace(data.return_url);
                                        }
                                    });
                                } else  {
                                    swalInit.fire("Failed", data.message, "error");
                                }
                                notif.close();
                            }
                        })
                    }
                });
            });

            table.on('click', '[data-toggle=confirm-remove]', function() {
                address = $(this).attr('data-address');
                swalInit.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    if(result.value) {
                        var notif = new Noty({
                                        text: '<i class="fa fa-spinner fa-spin"></i> Loading',
                                        type: 'info',
                                    }).show();
                        $.ajax({
                        type: "GET",
                        url: address,
                        success: function(data) {
                                // data = JSON.parse(data);
                                if(data.status == 1) {
                                    swalInit.fire("Deleted!", 'Your data has been removed.', "success").then((value) => {
                                        if(data.return_url != '#') {
                                            window.location.replace(data.return_url);
                                        }
                                    });
                                } else  {
                                    swalInit.fire("Failed", data.message, "error");
                                }
                                notif.close();
                            }
                        })
                    }
                });
            });

            table.on('click', '[data-toggle=confirm-recovery]', function() {
                address = $(this).attr('data-address');
                swalInit.fire({
                    title: 'Are you sure?',
                    text: "You will recovery this data!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    if(result.value) {
                        var notif = new Noty({
                                        text: '<i class="fa fa-spinner fa-spin"></i> Loading',
                                        type: 'info',
                                    }).show();
                        $.ajax({
                        type: "GET",
                        url: address,
                        success: function(data) {
                                // data = JSON.parse(data);
                                if(data.status == 1) {
                                    swalInit.fire("Recovered!", 'Your data has been recovered.', "success").then((value) => {
                                        if(data.return_url != '#') {
                                            window.location.replace(data.return_url);
                                        }
                                    });
                                } else  {
                                    swalInit.fire("Failed", data.message, "error");
                                }
                                notif.close();
                            }
                        })
                    }
                });
            });

            table.on('click', '[data-toggle=confirm-reset]', function() {
                address = $(this).attr('data-address');
                swalInit.fire({
                    title: 'Are you sure to reset password this account?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, reset it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    if(result.value) {
                        var notif = new Noty({
                                        text: '<i class="fa fa-spinner fa-spin"></i> Loading',
                                        type: 'info',
                                    }).show();
                        //add notify here
                        $.ajax({
                        type: "GET",
                        url: address,
                        success: function(data) {
                                // data = JSON.parse(data);
                                if(data.status == 1) {
                                    swalInit.fire("Updated!", 'The account password has been updated.', "success").then((value) => {
                                    });
                                } else  {
                                    swalInit.fire("Failed", data.message, "error");
                                }
                                notif.close();
                            }
                        })
                    }
                });
            });

        }

        var _componentSelect2 = function() {
            if (!$().select2) {
                console.warn('Warning - select2.min.js is not loaded.');
                return;
            }

            var $select = $('.select-search').select2({
                allowClear: true,
                escapeMarkup: function (markup) { return markup; },
                placeholder: "Choose One",
            });
        }

        // Switchery
        var _componentSwitchery = function() {
            if (typeof Switchery == 'undefined') {
                console.warn('Warning - switchery.min.js is not loaded.');
                return;
            }

            // Initialize single switch
            var elems = Array.prototype.slice.call(document.querySelectorAll('.form-input-switchery'));
            elems.forEach(function(html) {
                var switchery = new Switchery(html);
            });
        };

        // Noty.js examples
        var _componentNoty = function() {
            if (typeof Noty == 'undefined') {
                console.warn('Warning - noty.min.js is not loaded.');
                return;
            }

            // Override Noty defaults
            Noty.overrideDefaults({
                theme: 'limitless',
                layout: 'topRight',
                type: 'alert',
                timeout: 2500
            });
        };


        _componentNoty()
        $( document ).ready(function() {
            basicDT()
            _componentSelect2()
            _componentSwitchery()
            $('.form-input-styled').uniform({
                fileButtonClass: 'action btn bg-warning-400'
            });

            $('[data-toggle=confirm-remove]').click(function() {
                address = $(this).attr('data-address');
                swalInit.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, remove it!',
                    cancelButtonText: 'No, cancel!',
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false
                }).then(function(result) {
                    if(result.value) {
                        var notif = new Noty({
                                        text: '<i class="fa fa-spinner fa-spin"></i> Loading',
                                        type: 'info',
                                    }).show();
                        $.ajax({
                        type: "GET",
                        url: address,
                        success: function(data) {
                                if(data.status == 1) {
                                    swalInit.fire("Removed!", data.message, "success").then((value) => {
                                        if(data.return_url != '#') {
                                            window.location.replace(data.return_url);
                                        }
                                    });
                                } else  {
                                    swalInit.fire("Failed", data.message, "error");
                                }
                                notif.close();
                            }
                        })
                    }
                });
            });
        });
    </script>

    @yield('scriptjs')

</head>
<body>
        @include('layouts.components.navbar')

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-dark sidebar-main sidebar-expand-md bg-{{ config('app.theme') }}-800">

                <!-- Sidebar mobile toggler -->
                <div class="sidebar-mobile-toggler text-center bg-{{ config('app.theme') }}-800">
                    <a href="#" class="sidebar-mobile-main-toggle">
                        <i class="icon-arrow-left8"></i>
                    </a>
                    Navigation
                    <a href="#" class="sidebar-mobile-expand">
                        <i class="icon-screen-full"></i>
                        <i class="icon-screen-normal"></i>
                    </a>
                </div>
                <!-- /sidebar mobile toggler -->


                <!-- Sidebar content -->
                <div class="sidebar-content">

                    <!-- User menu -->
                    <div class="sidebar-user">
                        <div class="card-body">
                            <div class="media">
                                <div class="mr-3">
                                    <a href="{{ url('account') }}"><img src="{{ asset('assets/avatar/'.Auth::user()->avatar) }}" width="38" height="38" class="rounded-circle" alt=""></a>
                                </div>

                                <div class="media-body">
                                    <div class="media-title font-weight-semibold"> {{ Auth::user()->name }} </div>
                                    <div class="font-size-xs opacity-50">
                                        <i class="icon-user-tie font-size-sm"></i> Online
                                    </div>
                                </div>

                                <div class="ml-3 align-self-center">
                                    <a href="{{ route('logout') }}" title="logout" class="text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-switch2"></i></a>
                                </div>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /user menu -->

                    <!-- Main navigation -->
                    <div class="card card-sidebar-mobile">
                        <ul class="nav nav-sidebar" data-nav-type="accordion">

                        @include('layouts.components.sidebar')
                        </ul>
                    </div>
                    <!-- /main navigation -->

                </div>
                <!-- /sidebar content -->

            </div>
            <!-- /main sidebar -->

            <!-- Main content -->
            <div class="content-wrapper">
                
                <div class="page-header page-header-light">
                    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                        <div class="d-flex">
                            <div class="breadcrumb">
                                <a href="{{ @$link_menu == '' ? '' : route($link_menu.'.index') }}" class="breadcrumb-item"><i class="{{ $icon_menu ?? '' }} mr-2"></i> {{ $menu ?? '' }}</a>
                                @if( @$submenu != "" )
                                    @if( @$link_submenu == "" )
                                        <span class="breadcrumb-item active"><i class="{{ $icon_submenu ?? '' }}"></i> {{ $submenu ?? '' }}</span>
                                    @else
                                        <a href="{{ route($link_submenu.'.index') }} " class="breadcrumb-item"><i class="{{ $icon_submenu ?? '' }}"></i>  {{ $submenu ?? '' }}</a>
                                    @endif
                                @endif
                                @if( @$subsubmenu != "" )
                                    <span class="breadcrumb-item active"><i class="{{ $icon_subsubmenu ?? '' }}"></i> {{ $subsubmenu ?? ''}}</span>
                                @endif

                                @if( @$subtitle != "")
                                    @if( @$subtitle == "Create Data" || @$subtitle == "Edit Data")
                                    <span class="breadcrumb-item active">{{ $subtitle ?? ''}}</span>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Content area -->
                @yield('content')
                <!-- /content area -->

                <!-- Footer -->
                <div class="navbar navbar-expand-lg navbar-light">
                    <span class="navbar-text">
                        &copy; {{ date('Y') }}. <a href="https://saepulasep.my.id/" target="_blank">All right reserved</a>
                    </span>
                </div>
                <!-- /footer -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->
    @include('layouts.components.footer')

    <audio src="{{ asset('assets/mp3/notif.mp3') }}" id="audio-notif" controls style="display:none" ></audio>
</body>
</html>
