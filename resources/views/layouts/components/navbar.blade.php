<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark bg-{{ config('app.theme') }}-600">
		<a href="{{ url('/') }}" class="text-light" style="margin-top:10px;font-size:20px;margin-right:100px;">
			{{ config('app.name') }}
		</a>

		<div class="d-md-none">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
                <i class="icon-user-tie"></i>
            </button>
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>
			</ul>

			<ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown">
                        <i class="icon-bell2"></i>
                        <span class="d-md-none ml-2">Notifications</span>
                        <span class="badge badge-pill bg-warning-400 ml-auto ml-md-0" id="jumlah_notif"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                        <div class="dropdown-content-header" style="">
                            <span class="font-weight-semibold">Notifications</span>
                            <button  type="button" class="btn btn-mark-read  btn-link btn-sm align-self-start ml-3" style="margin-top:-10px;">Mark all as read </button>
                            <input  type="hidden" value="0" id="last_id" >
                        </div>
                        <div class="dropdown-content-body dropdown-scrollable" style="padding: 0px !important;">
                            <ul class="media-list" id="notification">
                                <li class="media py-3 px-3 ">
									<div class="media-body">
										<span class="text-muted"><i class="icon-spinner4 spinner"></i> Loading </span>
									</div>
								</li>
                            </ul>
                        </div>
                        <div class="dropdown-content-footer justify-content-center p-0">
                            <a href="{{ url('/notification') }}" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Lihat selengkapnya"><i class="icon-menu7 d-block top-0"></i></a>
                        </div>
                    </div>
                </li>
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('assets/avatar/'.Auth::user()->avatar)  }}" class="rounded-circle mr-2 border border-light" height="34" width="34" alt="">
                        <span>{{ Auth::user()->name }}</span>
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="{{ url('account') }}" class="dropdown-item"><i class="icon-user"></i> Your Profile</a>
						<a href="{{ url('account#password_change') }}" class="dropdown-item"><i class="icon-cog5"></i> Change Password</a>
						<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                    </div>
				</li>
			</ul>
		</div>
	</div>
<!-- /main navbar -->

<script>
    $(document).ready(function() {
        notification();
        setInterval(notification, 5000);
        var baseurl = "{{ url('') }}";
        $(".btn-mark-read").hide();
        $('#jumlah_notif').hide();

        function notification() {
            let last_id = $('#last_id').val();
            $.ajax({
                url: "{{ url('notification/get') }}/"+last_id,
                contentType: "application/json",
                cache: false,
                dataType: 'json',
                success: function(result) {
                    var notif = "";
                    if (result.status && result.all != 0) {
                        $.each(result.content, function(i, item) {
                            var trimmedString = item.message.length > 150 ?
                                item.message.substring(0, 150 - 3) + "..." :
                                item.message;
                            let status = ''
                            if (item.is_seen == "1") {
                                status = 'background-color:#efefef !important;'
                            }
                            let link = "{{ url('notification/view/') }}";
                            notif += `
                                <li class="media pb-1" style="margin-top:0px !important;padding: 0.625rem 1.25rem 0.625rem 1.25rem;${status}">
                                    <div class="mr-2 position-relative">
                                        <div  class="btn border-2 border-${item.type} alpha-${item.type} text-${item.type}-800 btn-icon rounded-round "><i class="icon-bell3"></i></div>
                                    </div>
                                    <div class="media-body">
                                        <a href="${link+'/'+item.id}" style="text-decoration:none;">
                                            <div class="media-title">
                                                    <span class="font-weight-semibold text-dark">${item.title}</span>
                                            </div>
                                            <span class="text-muted">${trimmedString}</span> <br/>
                                            <span class="text-info font-size-sm"><i class="icon-calendar icon-sm"></i>  ${item.date} WIB</span>
                                        </a>
                                    </div>
								</li>
                            `;
                        });
                        if (result.unseen >= 1) {
                            $(".btn-mark-read").show();
                            $("#jumlah_notif").show();
                            $('#jumlah_notif').text(result.unseen);
                        } else {
                            $(".btn-mark-read").hide();
                            $('#jumlah_notif').hide();
                        }
                        $('#notification').html(notif);
                    } else {
                        notif = '<li class="media">' +
                            '<div class="media-body px-3 pb-3">' +
                            '<div class="text-muted text-center">Tidak ada notifikasi</div>' +
                            '</div>' +
                            '</li>';
                        $('#notification').html(notif);
                    }
                    //last_id
                    $('#last_id').val(result.last_id);

                    // check new notif
                    if(result.new > 0){
                        let notif = result.new > 1 ? `You have ${result.new} new notifications` : `You have a new notification`;
                        new Noty({
                                    text: '<i class="icon-bell3"></i> '+notif,
                                    type: 'info',
                                    timeout: 3000,
                                }).show();
                        $('title').html(notif+' - ');
                        // titleMarquee();
                        document.getElementById('audio-notif').play();
                    }

                },
                error: function() {
                    console.warn('Notification interval has been fail!');
                }
            })
        }

        $('.btn-mark-read').click(() => {
            $('.btn-mark-read').prop('disabled', true).html('<i class="icon-spinner4 spinner"></i> Loading')
            $.ajax({
                url: "{{ url('notification/read-all/') }}",
                contentType: "application/json",
                cache: false,
                dataType: 'json',
                success: function(result) {
                    swalInit.fire("Success", result.message , "success").then((value) => {
                                        window.location.replace('');
                                    });
                    $('.btn-mark-read').prop('disabled', false).html('Mark all as read')
                },
                error: function(res){
                    $('.btn-mark-read').prop('disabled', false).html('Mark all as read')
                }
            });
        })
    });

    const titleMarquee = (status = true) => {
        if(status){
            var titleText = document.title;
            titleText = titleText.substring(1, titleText.length) + titleText.substring(0, 1);
            document.title = titleText;
            setTimeout("titleMarquee()", 450);
        }else{
            return false;
        }
    }

</script>
