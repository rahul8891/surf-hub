@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="left-advertisement">
                <img src="img/new/advertisement1.png" alt="advertisement">
                <img src="img/new/advertisement2.png" alt="advertisement">
            </div>
            <div class="middle-content">
                @include('layouts/user/content_menu')
                @if (is_null($postsList[0]))
                <div class="post alert text-center alert-dismissible py-5" role="alert">
                    {{ ucWords('no matches found') }}
                </div>
                @else
                @foreach ($postsList as $key => $posts)
                <div class="news-feed">
                    <div class="inner-news-feed">
                        <div class="user-details">
                            <div class="user-left">
                                @if(file_exists(asset('storage/'.$posts->user->profile_photo_path)))
                                <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <img src="/img/logo_small.png" class="profileImg" alt="">
                                @endif
                                <div>
                                    <p class="name"><span>{{ ucfirst($posts->user->user_profiles->first_name) }} {{ ucfirst($posts->user->user_profiles->last_name) }} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</span> </p>
                                    <p class="address">{{ (isset($posts->beach_breaks->beach_name))?$posts->beach_breaks->beach_name:'' }} {{ (isset($posts->breakName->break_name))?$posts->breakName->break_name:'' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</p>
                                    <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p>
                                </div>
                            </div>
                        </div>
                        @if (isset($posts->parent_id) && ($posts->parent_id > 0))
                            @if(!empty($posts->upload->image))
                                <div class="newsFeedImgVideo">
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->parent_id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                </div>
                            @elseif(!empty($posts->upload->video))
                                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->parent_id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                                    <video width="100%" preload="auto" data-setup="{}" controls muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                                </div>
                            @endif
                        @else
                            @if(!empty($posts->upload->image))
                                <div class="newsFeedImgVideo">
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                </div>
                            @elseif(!empty($posts->upload->video))
                                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                                </div>
                            @endif
                        @endif

                        <div class="user-bottom-options">
                            <div class="rating-flex">
                                <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">
                                <span class="avg-rating">{{ round(floatval($posts->averageRating)) }}/<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span></span>

                            </div>
                            <div class="right-options">
                                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                    <img src={{asset("/img/location.png")}} alt="Location"></a>
                                <a onclick="openFullscreenSilder({{$posts->id}}, 'home');"><img src={{asset("/img/expand.png")}} alt="Expand"></a>
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
                                            <div class="col-5">{{ucfirst($posts->user->user_name)}}</div>
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
                                <div class="d-inline-block tag dropdown" title="Tag">
                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <img src="/img/tag.png" alt="Tag">
                                    </button>
                                    <div class="dropdown-menu">
                                        @if (count($posts->tags) >= 1)
                                        <div class="username-tag">
                                            @foreach ($posts->tags as $tags)
                                            <div class="tag-user-photo">
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
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <div class="justify-content-center ajax-load" style="display:none;margin-left: 40%">
                    <img src="/images/spiner4.gif" alt="loading" height="90px;" width="170px;">
                </div>
            </div>
            <div class="right-advertisement">
                <img src="img/new/advertisement1.png" alt="advertisement">
                <img src="img/new/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>
@include('elements/location_popup_model')
@include('layouts/models/full_screen_modal')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    var page = 1;
    jQuery(window).scroll(function() {
        if (jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height()) {
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

        jQuery.ajax({
            url: url,
            type: "get",
            async: false,
            beforeSend: function() {
                jQuery('.ajax-load').show();
            }
        }).done(function(data) {
            if (data.html == "") {
                jQuery('.ajax-load').addClass('requests');
                jQuery('.ajax-load').html("No more records found");
                return;
            }

            jQuery('.ajax-load').removeClass('requests');
            jQuery('.ajax-load').hide();
//            $("#search-data").append(data.html);
            jQuery(data.html).insertBefore(".ajax-load");
        });
    }

    //Auto play videos when view in scroll
    function isInView(el) {
        var rect = el.getBoundingClientRect();// absolute position of video element
        return !(rect.top > (jQuery(window).height() / 2) || rect.bottom < (jQuery(window).height() / 4));// visible?
    }

    jQuery(document).on("scroll", function () {
        jQuery("video").each(function () { //console.log('aa');
            // jQuery("video").get(0).pause();
            // visible?
            if (isInView(jQuery(this).get(0))) { // console.log('video = '+ jQuery.parseJSON(jQuery(this).get(0).paused));
                if (jQuery(this).get(0).paused) { //console.log('1111');
                    jQuery(this).get(0).play(true);// play if not playing
                }
            } else {
                if (!jQuery(this).get(0).paused) { //console.log('2222');
                    jQuery(this).get(0).pause();// pause if not paused
                }
           }
        });
    });
    //End auto play
</script>
@endsection
