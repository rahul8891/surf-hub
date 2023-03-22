@if (!empty($postsList))
@foreach ($postsList as $key => $posts)
<div class="news-feed">
    <div class="inner-news-feed">
        <div class="user-details">
            <div class="user-left">
                @if(file_exists(storage_path('app/public/'.$posts->user->profile_photo_path)))
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
        @if(!empty($posts->upload->image))
        <div class="newsFeedImgVideo">
            <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
        </div>
        @elseif(!empty($posts->upload->video))
            @if (!File::exists($posts->upload->video))
                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                </div>
            @else
                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'m3u8' }}">
                    <video width="100%" preload="auto" data-setup="{}" controls playsinline muted class="video-js" id="myVideoTag{{$posts->id}}">
                    </video>
                </div>
            @endif
        @endif
        <div class="user-bottom-options">
            <div class="rating-flex rating-flex-child">
                <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">
                <span class="avg-rating">{{ round(floatval($posts->averageRating)) }}/<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span></span>

            </div>
            <div class="right-options">
                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                    <img src={{asset("/img/location.png")}} alt="Location"></a>
                <a onclick="openFullscreen({{$posts->id}});"><img src={{asset("/img/expand.png")}} alt="Expand"></a>
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
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
<script type="text/javascript">
    window.HELP_IMPROVE_VIDEOJS = false;

    jQuery( ".jw-video-player" ).each(function( i ) {
        var videoID = $(this).attr('data-id');
        var video = $(this).attr('data-src');
        // console.log("Data = myVideoTag"+videoID+"  --  "+video);
        var options = {};

        videojs('myVideoTag'+videoID).ready(function () {
            var myPlayer = this;
            myPlayer.qualityPickerPlugin();
            myPlayer.src({
                type: 'application/x-mpegURL',
                src: video
            });
        });
    });

    jQuery('.rating').rating({
        showClear:false,
        showCaption:false
    });

    jQuery('.pos-rel a').each(function(){
        jQuery(this).on('hover, mouseover, click', function() {
            jQuery(this).children('.userinfoModal').find('input[type="text"]').focus();
        });
    });

    jQuery('.right-options').on('click', '.editBtnVideo', function() {
        var id = jQuery(this).data('id');

        jQuery.ajax({
            url: '/getPostData/' + id,
            type: "get",
            async: false,
            success: function(data) {
                jQuery("#edit_image_upload_main").html("");
                jQuery("#edit_image_upload_main").append(data.html);
                jQuery("#edit_image_upload_main").modal('show');
            }
        });
    });

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
