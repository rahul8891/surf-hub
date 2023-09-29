@extends('layouts.user.new_layout')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />

<section class="home-section">

    <div class="container">
        <div class="home-row">
            @if (Auth::user())
            @include('layouts.user.left_sidebar')
            @else
            <div class="left-advertisement">
                        <img src="img/new/advertisement1.png" alt="advertisement">
                        <img src="img/new/advertisement2.png" alt="advertisement">
                </div>
            @endif
            <div class="middle-content" id="search-data">
                @include('layouts/user/content_menu')

                @if (is_null($postsList[0]))
                <div class="post alert text-center alert-dismissible py-5" role="alert">
                    {{ ucWords('no matches found') }}
                </div>
                @else
                @php ($c = 0)
                @php ($i = 0)
                @foreach ($postsList as $key => $posts)
                <div class="news-feed">
                    <div class="inner-news-feed">
                        <div class="user-details">
                            @if (isset($posts->parent_id) && ($posts->parent_id > 0))
                                <div class="user-left">
                                    @if(file_exists(storage_path('app/public/'.$posts->parentPost->profile_photo_path)))
                                        <a href="{{route('surfer-profile', Crypt::encrypt($posts->parent_id))}}"><img src="{{ asset('storage/'.$posts->parentPost->profile_photo_path) }}" class="profileImg" alt=""></a>
                                    @else
                                        <img src="/img/logo_small.png" class="profileImg" alt="">
                                    @endif

                                    <div>
                                        @if(Auth::user() && $posts->parent_id != Auth::user()->id)
                                            @if($posts->parentPost->user_type == 'USER' || $posts->parentPost->user_type !== 'SURFER CAMP')
                                                <p class="name"><span><a href="{{route('surfer-profile', Crypt::encrypt($posts->parent_id))}}">{{ ucfirst($posts->parentPost->user_profiles->first_name) }} {{ ucfirst($posts->parentPost->user_profiles->last_name) }} ( {{ (isset($posts->parentPost->user_name) && !empty($posts->parentPost->user_name))?ucfirst($posts->parentPost->user_name):"SurfHub" }} )</a></span> </p>
                                            @elseif($posts->parentPost->user_type == 'SURFER CAMP')
                                                <p class="name"><span><a href="{{route('resort-profile', Crypt::encrypt($posts->user_id))}}">{{ ucfirst($posts->parentPost->user_profiles->first_name) }} {{ ucfirst($posts->parentPost->user_profiles->last_name) }} ( {{ (isset($posts->parentPost->user_name) && !empty($posts->parentPost->user_name))?ucfirst($posts->parentPost->user_name):"SurfHub" }} )</a></span> </p>
                                            @endif
                                        @else
                                            <p class="name"><span>{{ucfirst($posts->parentPost->user_profiles->first_name)}} {{ucfirst($posts->parentPost->user_profiles->last_name)}} ( {{ (isset($posts->parentPost->user_name) && !empty($posts->parentPost->user_name))?ucfirst($posts->parentPost->user_name):"SurfHub" }} )</span></p>
                                        @endif
                                        <p class="address">{{ (isset($posts->beach_breaks->beach_name))?$posts->beach_breaks->beach_name:'' }} {{ (isset($posts->breakName->break_name))?$posts->breakName->break_name:'' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</p>
                                        <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="user-left">
                                    @if(file_exists(storage_path('app/public/'.$posts->user->profile_photo_path)))
                                        @if(Auth::user() && $posts->user_id != Auth::user()->id)
                                            @if($posts->user->user_type == 'USER' || $posts->user->user_type !== 'SURFER CAMP')
                                                <a href="{{route('surfer-profile', Crypt::encrypt($posts->user_id))}}"><img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt=""></a>
                                            @elseif($posts->user->user_type == 'SURFER CAMP')
                                                <a href="{{route('resort-profile', Crypt::encrypt($posts->user_id))}}"><img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt=""></a>
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                                        @endif
                                    @else
                                        <img src="/img/logo_small.png" class="profileImg" alt="">
                                    @endif
                                    <div>
                                        @if(Auth::user() && $posts->user_id != Auth::user()->id)
                                            @if($posts->user->user_type == 'USER' || $posts->user->user_type !== 'SURFER CAMP')
                                                <p class="name"><span><a href="{{route('surfer-profile', Crypt::encrypt($posts->user_id))}}">{{ ucfirst($posts->user->user_profiles->first_name) }} {{ ucfirst($posts->user->user_profiles->last_name) }} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</a></span> </p>
                                            @elseif($posts->user->user_type == 'SURFER CAMP')
                                                <p class="name"><span><a href="{{route('resort-profile', Crypt::encrypt($posts->user_id))}}">{{ ucfirst($posts->user->user_profiles->first_name) }} {{ ucfirst($posts->user->user_profiles->last_name) }} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</a></span> </p>
                                            @endif
                                        @else
                                            <p class="name"><span>{{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</span></p>
                                        @endif
                                        <p class="address">{{ (isset($posts->beach_breaks->beach_name))?$posts->beach_breaks->beach_name:'' }} {{ (isset($posts->breakName->break_name))?$posts->breakName->break_name:'' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</p>
                                        <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p>
                                    </div>
                                </div>
                            @endif
                            @if (isset(Auth::user()->id) && ($posts->user_id != Auth::user()->id))
                                <div class="user-right">
                                    <img src="/img/normal-user.png" alt="normal-user">
                                    @if(isset($posts->followPost->id) && !empty($posts->followPost->id))
                                        @if(($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0'))
                                            <button class="follow-btn follow clicked" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                                                <span class="follow-icon"></span> FOLLOWING
                                            </button>
                                        @else
                                            <button class="follow-btn follow clicked Follow" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                                                <span class="follow-icon"></span>  REQUEST SENT
                                            </button>
                                        @endif
                                    @else
                                        <button class="follow-btn follow followPost" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                                            <span class="follow-icon"></span> FOLLOW
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if (isset($posts->parent_id) && ($posts->parent_id > 0))
                            @if(!empty($posts->upload->image))
                                <div class="newsFeedImgVideo">
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->parent_id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                </div>
                            @elseif(!empty($posts->upload->video))
                                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ config('config.file_path').'videos/'.$posts->parent_id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                                </div>
                            @endif
                        @else
                            @if(!empty($posts->upload->image))
                                <div class="newsFeedImgVideo">
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                </div>
                            @elseif(!empty($posts->upload->video))
                                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ config('config.file_path').'videos/'.$posts->user->id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                                </div>
                            @endif
                        @endif
                        <div class="user-bottom-options">
                            <div class="rating-flex rating-flex-child">
                                <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">
                                <span class="avg-rating">{{ round(floatval($posts->averageRating)) }}/<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span></span>

                            </div>
                            <div class="right-options">
                                @if(Auth::user() && $posts->user_id != Auth::user()->id)
                                    <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}"><img src="/img/save.png" alt="Save"></a>
                                @endif

                                @if(isset(Auth::user()->id) && ($posts['surfer'] == 'Unknown') && (Auth::user()->id != $posts['user_id']) && empty($requestSurfer[$posts->id]))
                                    <a href="javascript:void(0);" class="surferRequestAjax" id="surferrequest_{{$posts->id}}" data-id="{{$posts->id}}"><img src="/img/new/small-logo.png" alt="Logo"></a>
                                @endif

                                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                    <img src={{asset("img/location.png")}} alt="Location"></a>
                                <a onclick="openFullscreenSilder({{$posts->id}}, 'search');"><img src={{asset("img/expand.png")}} alt="Expand"></a>
                                <div class="d-inline-block info dropdown" title="Info">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/warning.png" alt="Info">
                                    </button>
                                    <div class="dropdown-menu">
                                        <div class="row">
                                            <div class="col-5">Date</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{date('d-m-Y',strtotime($posts->surf_start_date))}}</div>
                                            <div class="col-5">Surfer</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->surfer}}</div>
                                            <div class="col-5">Posted By</div>
                                            <div class="col-2 text-center">:</div>
                                            @if (isset($posts->parent_id) && ($posts->parent_id > 0))
                                                <div class="col-5">{{ucfirst($posts->parentPost->user_name)}}</div>
                                            @else
                                                <div class="col-5">{{ucfirst($posts->user->user_name)}}</div>
                                            @endif
                                            <div class="col-5">Beach/Break</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->beach_breaks->beach_name}}/{{$posts->beach_breaks->break_name}}</div>
                                            <div class="col-5">Country</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->countries->name}}</div>
                                            <div class="col-5">State</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->states->name??""}}</div>
                                            <div class="col-5">Wave Size</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">@foreach($customArray['wave_size'] as $key => $value)
                                                @if($key == $posts->wave_size)
                                                {{$value}}
                                                @endif
                                                @endforeach</div>
                                            <div class="col-5">Board Type</div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">{{$posts->board_type}}</div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user() && $posts->user_id == Auth::user()->id)
                                <a href="{{route('deleteUserPost', Crypt::encrypt($posts->id))}}"  onclick="return confirm('Do you really want to delete this footage?')"><img src="/img/delete.png" alt="Delete"></a>
                                <a href="javascript:void(0)" class="editBtn editBtnVideo" data-id="{{ $posts->id }}"><img src="/img/edit.png" alt="Edit"></a>

                                @endif
                                <div class="d-inline-block tag dropdown" title="Tag">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/tag.png" alt="Tag">
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (count($posts->tags) >= 1)
                                        <div class="username-tag">
                                            @foreach ($posts->tags as $tags)
                                            <div class="">
                                                @if($tags->user->profile_photo_path)
                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="profileImg" alt="">
                                                @else
                                                <span class="initial-name">{{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}</span>
                                                @endif
                                                <span>{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                        <div>
                                            <input type="text" autofocus name="tag_user"
                                                   placeholder="@ Search user" class="form-control ps-2 tag_user" required data-post_id="{{$posts->id}}">
                                            <input type="hidden" value="{{ old('user_id')}}" name="user_id"
                                                   id="user_id" class="form-control user_id">
                                            <div class="auto-search tagSearch" id="tag_user_list{{$posts->id}}"></div>
                                        </div>
                                    </div>
                                </div>
                                @if(Auth::user() && $posts->user_id != Auth::user()->id)
                                <div class="d-inline-block report dropdown" title="Report">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/flag.png" alt="Report">
                                    </button>

                                    <div class="dropdown-menu">
                                        <form role="form" method="POST" name="report{{$posts->id}}" action="{{ route('report') }}" id="formReportSubmit">
                                            @csrf
                                            <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                                            <h6 class="text-center fw-bold">Report Content</h6>

                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="incorrectInfo{{$posts->id}}" name="incorrect" value="1">
                                                <label class="form-check-label" for="incorrectInfo{{$posts->id}}">Report Info as
                                                    incorrect</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="inappropriate" value="1"
                                                       id="incorrectContent{{$posts->id}}">
                                                <label class="form-check-label" for="incorrectContent{{$posts->id}}">Report
                                                    content as inappropriate</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" name="tolls" value="1" id="reportTrolls{{$posts->id}}">
                                                <label class="form-check-label" for="reportTrolls{{$posts->id}}">Report
                                                    tolls</label>
                                            </div>
                                            <div>
                                                <textarea class="form-control ps-2" name="comments" id="comments{{$posts->id}}"
                                                          placeholder="Additional Comments.."
                                                          style="height: 80px"></textarea>
                                            </div>
                                            <button type="button" id="submitReport{{$posts->id}}" class="btn blue-btn w-100" onclick="reportSubmit({{ $posts->id }})">REPORT</button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(Auth::user())
                    <div class="comments-div">
                        <a class="" data-bs-toggle="collapse" href="#collapseExample{{$posts->id}}" role="button"
                           aria-expanded="false" aria-controls="collapseExample{{$posts->id}}">
                            Say Something <img src="img/dropdwon.png" alt="dropdown" class="ms-1">
                        </a>
                        <div class="collapse" id="collapseExample{{$posts->id}}">
                            <form role="form" method="POST" name="comment{{$posts->id}}" action="{{ route('comment') }}">
                                @csrf
                                <div class="comment-box">
                                    <div class="form-group">
                                        <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                                        <input type="hidden" name="parent_user_id" value="{{$posts->user_id}}">
                                        <input type="text" name="comment" id="{{$posts->id}}" class="form-control ps-2 mb-0 h-100 commentOnPost">
                                    </div>
                                    <button type="submit" id="submitPost{{$posts->id}}" class="send-btn btn"><img src="img/send.png"></button>
                                </div>
                            </form>
                            @foreach ($posts->comments as $comments)
                            <div class="comment-row">
                                <span class="comment-name">{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :
                                </span>
                                {{$comments->value}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                @php ($c++)
                @if($c == 5 && showAdvertisment::instance()->getAdvertisment())
                @foreach (showAdvertisment::instance()->getAdvertisment() as $key => $requests)
                @if($i != $key)
                @continue
                @endif
                @if(!empty($requests['image']))
                <div class="news-feed">
                    <div class="inner-news-feed">
                        <img src="{{ env('FILE_CLOUD_PATH').'images/'.$requests['user_id'].'/'.$requests['image'] }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                    </div>
                </div>
                @elseif(!empty($requests['video']))
                    <div class="news-feed">
                        <div class="inner-news-feed">
                            <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                                <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$requests['user_id'].'/'.$requests['video'] }}" >
                            </video>
                        </div>
                    </div>
                @endif

                @php ($c = 0)
                @break
                @endforeach
                @php ($i++)
                @endif

                @endforeach
                @endif

                <div class="justify-content-center ajax-load" style="display:none;margin-left: 40%">
                    <img src="/images/spiner4.gif" alt="loading" height="90px;" width="170px;">
              </div>

            </div>

            <div class="right-advertisement">
                <img src="img/advertisement1.png" alt="advertisement">
                <img src="img/advertisement2.png" alt="advertisement">
            </div>

        </div>
    </div>
</section>

@include('elements/location_popup_model')
@include('layouts/models/upload_video_photo')
@include('layouts/models/edit_image_upload')
@include('layouts/models/full_screen_modal')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    var page = 1;

    jQuery(window).scroll(function() {
        if(jQuery(window).scrollTop() + $(window).height() >= (jQuery(document).height() - 10)) {
            page++;
            loadMoreData(page);
        }
    });

    function loadMoreData(page) {
        var url = window.location.href;
        if(url.indexOf("?") !== -1) {
            var url = window.location.href + '&page=' + page;
        }else {
            var url = window.location.href + '?page=' + page;
        }

        jQuery.ajax({
            url: url,
            type: "get",
            async: false,
            beforeSend: function() {
                $('.ajax-load').show();
            }
        })
        .done(function(data) {
            if(data.html == "") {
                jQuery('.ajax-load').addClass('requests');
                jQuery('.ajax-load').html("No more records found");
                return;
            }

            jQuery('.ajax-load').removeClass('requests');
            jQuery('.ajax-load').hide();
            jQuery(data.html).insertBefore(".ajax-load");
        });
    }

    //Auto play videos when view in scroll
    function isInView(el) {
        var rect = el.getBoundingClientRect();// absolute position of video element
        return !(rect.top > (jQuery(window).height() / 2) || rect.bottom < (jQuery(window).height() / 4));// visible?
    }

    jQuery(document).on("scroll", function () {
        jQuery("video").each(function () {
            // visible?
            if (isInView(jQuery(this).get(0))) {
                if (jQuery(this).get(0).paused) {
                    jQuery(this).get(0).play(true);// play if not playing
                }
            } else {
                if (!jQuery(this).get(0).paused) {
                    jQuery(this).get(0).pause();// pause if not paused
                }
           }
        });
    });
    //End auto play

    function reportSubmit(id) {
        var info = '';
        var content = '';
        var troll = '';

        if($("#incorrectInfo"+id).is(':checked')) {
            info = $("#incorrectInfo"+id).val();
        }

        if($("#incorrectContent"+id).is(':checked')) {
            content = $("#incorrectContent"+id).val();
        }

        if($("#reportTrolls"+id).is(':checked')) {
            troll = $("#reportTrolls"+id).val();
        }

        var formData = {
            post_id: id,
            incorrect: info,
            inappropriate: content,
            tolls: troll,
            comments: $("#comments"+id).val(),
        };

        jQuery.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'report',
            type: "post",
            data: formData,
            async: false,
            success: function(data) {
                data = $.parseJSON(data);

                if(data.status == 'success') {
                    jQuery("main").prepend('<div class="alert alert-success alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                }else {
                    jQuery("main").prepend('<div class="alert alert-danger alert-dismissible" role="alert" id="msg-alert"><button type="button" class="close btn-primary" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.message+'</div>');
                }
            }
        });

        return false;
    }


    // Surfer Request Sent Ajax
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
    });

</script>
@endsection
