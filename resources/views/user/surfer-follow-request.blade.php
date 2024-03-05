@extends('layouts.user.new_layout')
@section('content')

<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.user.left_sidebar')
            <div class="middle-content">
                <div class="profile-photo-edit">
                    <div class="profile-pic">
                        @if(!empty($userProfile['profile_photo_path']))
                        <img src="{{ asset('storage/'.$userProfile['profile_photo_path']) }}"
                                alt="" class="rounded-circle">
                        @endif
                    </div>
                    <div class="name">
                        @if(!empty($userProfile['surfer_name']))
                        <p>{{__(ucwords($userProfile['surfer_name']))}}</p>
                        @endif
                        <p class="mb-0">Surfhub <span class="blue-txt">$0</span> Earn</p>
                    </div>
                </div>
                <div class="edit-profile-box">
                    <table>
                        <tbody>
                            <tr>
                                <td class="font_bold">Surfer Name</td>
                                <td>:</td>
                                @if(!empty($userProfile['surfer_name']))
                                <td>{{ $userProfile['surfer_name'] }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td class="font_bold">Gender</td>
                                <td>:</td>
                                @if(!empty($userProfile['gender']))<td>{{ $userProfile['gender'] }}</td>@endif
                            </tr>
                            <tr>
                                <td class="font_bold">Country</td>
                                <td>:</td>
                                @if(!empty($userProfile['country']))<td>{{ $userProfile['country'] }}</td>@endif
                            </tr>
                            <tr>
                                <td class="font_bold">Preferred Board</td>
                                <td>:</td>
                                <td>
                                    @if(!empty($userProfile['preferred_board']))
                                        {{ $userProfile['preferred_board'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font_bold">Local Beach</td>
                                <td>:</td>
                                <td>
                                    @if(!empty($userProfile['beach_break']))
                                        {{ $userProfile['beach_break'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
               
                <div id="post-data">
                    @if (!empty($reviewPost))
                        @foreach ($reviewPost as $key => $posts)
                            @include('elements.surferFollowRequestPost')
                        @endforeach
                    @endif

                    @if (!empty($postsList))
                        @foreach ($postsList as $key => $posts)
                            @include('elements.surferFollowRequest')
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="right-advertisement">
                <img src="/img/advertisement1.png" alt="advertisement">
                <img src="/img/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>
@include('elements/location_popup_model')
@include('layouts/models/edit_image_upload')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    var page = 1;
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        var url = window.location.href;

        if (url.indexOf("?") !== - 1) {
            var url = window.location.href + '&page=' + page;
        } else {
            var url = window.location.href + '?page=' + page;
        }

        $.ajax({
            url: url,
            type: "get",
            async: false,
            beforeSend: function() {
                $('.ajax-load').show();
            }
        })
        .done(function(data) {
            if (data.html == "") {
                $('.ajax-load').addClass('requests');
                $('.ajax-load').html("No more records found");
            }

            $('.ajax-load').removeClass('requests');
            $('.ajax-load').hide();
            $(data.html).insertBefore(".ajax-load");
        });
    }

    $(document).on('click', '.editBtnVideo', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '/getPostData/' + id,
            type: "get",
            async: false,
            success: function(data) {
                $("#edit_image_upload_main").html("");
                $("#edit_image_upload_main").append(data.html);
                $("#edit_image_upload_main").modal('show');
            }
        });
    });

    $('.pos-rel a').each(function(){
        $(this).on('hover, mouseover, click', function() {
            $(this).children('.userinfoModal').find('input[type="text"]').focus();
        });
    });

    jQuery(document).ready(function() {
        jQuery('.surferRequestAjax').on('click', function() {
            var surferrequestId = jQuery(this).attr('data-id');
            // AJAX Request
            jQuery.ajax({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                url: '/surfer-request-ajax',
                type: 'POST',
                data: { id:surferrequestId },
                success: function(responseData) {
                    // Removing icon from HTML Table
                    var result = JSON.parse(responseData);
                    if(result.status == "success") {
                        jQuery("#surferrequest_" + surferrequestId).fadeOut("normal");
                        jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+result.message+'</div>');
                    } else{
                        jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+result.message+'</div>');
                    }
                }
            });
        });
        return false;
    });
</script>
@endsection
