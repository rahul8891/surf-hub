@extends( Auth::user() && Auth::user()->user_type == 'ADMIN'  ?  'layouts.admin.admin_layout' : 'layouts.user.new_layout' )
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>
            <div class="middle-content">
                <div class="profile-photo-edit">
                    <div class="profile-pic">
                        @if($userProfile['profile_photo_path'])
                        <img src="{{ asset('storage/'.$userProfile['profile_photo_path']) }}"
                             alt="" class="rounded-circle">
                        @endif
                    </div>
                    <div class="name">
                        <p>{{__(ucwords($userProfile['surfer_name']))}}</p>
                        <p class="mb-0">Surfhub <span class="blue-txt">$0</span> Earn</p>
                    </div>
                </div>
                <div class="edit-profile-box">
                    <!-- <a href="{{ url('user/edit-profile') }}" class="btn edit-btn"><img src="/img/new/edit.png" alt="edit" class="align-middle me-1"> <span class="align-middle">EDIT</span></a> -->
                    <table>
                        <tbody>
                            <tr>
                                <td>User Name</td>
                                <td>:</td>
                                <td>{{ __(ucwords($userProfile['surfer_name'])) }}</td>
                            </tr>
                            <!-- <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $userProfile['email'] }}</td>
                            </tr> -->
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                <td>{{ $userProfile['gender'] }}</td>
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>:</td>
                                <td>{{ $userProfile['country'] }}</td>
                            </tr>
                            <tr>
                                <td>Preferred Board</td>
                                <td>:</td>
                                <td>
                                    @if($userProfile['preferred_board'])
                                        {{ $userProfile['preferred_board'] }}
                                    @else
                                    -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Local Beach</td>
                                <td>:</td>
                                <td>
                                    @if($userProfile['beach_break'])
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
                                        <p class="address">
                                            {{ $posts->breakName->beach_name ?? ($posts->beach_breaks->beach_name ?? '') }}
                                            {{ $posts->breakName->break_name ?? ($posts->beach_breaks->beach_name ?? '') }},
                                            {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}
                                        </p>
                                        <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p>
                                    </div>
                                </div>
                                @if($posts->user_id != Auth::user()->id)
                                <div class="user-right">
                                    @if($request_type == 'follow')
                                        <div class="col-xl-6 text-xl-end">
                                            <div class="d-flex">
                                                <a class="btn grey-borderBtn me-3 accept" href="{{ route('acceptRejectFollowRequest', [Crypt::encrypt($posts->followRequest->id),'accept']) }}">
                                                    <img src="/img/accept.png" class="me-1 align-middle" alt="ACCEPT">
                                                    <span class="align-middle">ACCEPT</span>
                                                </a>
                                                <a class="btn grey-borderBtn reject" href="{{ route('acceptRejectFollowRequest', [Crypt::encrypt($posts->followRequest->id),'reject']) }}">
                                                    <img src="/img/reject.png" class="me-1 align-middle" alt="REJECT">
                                                    <span class="align-middle">REJECT</span>
                                                </a>
                                            </div>

                                        </div>
                                    @else
                                        <!-- <img src="/img/new/normal-user.png" alt="normal-user">

                                        <button class="follow-btn follow <?php echo (isset($posts->followPost->id) && !empty($posts->followPost->id)) ? ((($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0')) ? 'clicked' : 'clicked Follow') : 'followPost' ?>" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                                        <span class="follow-icon"></span> FOLLOW
                                        </button> -->

                                        <div class="user-right">
                                            <img src="/img/new/normal-user.png" alt="normal-user">
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
                                @endif
                            </div>
                            @if(!empty($posts->upload->image))
                                <div class="newsFeedImgVideo">
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->user_id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                </div>
                            @elseif(!empty($posts->upload->video))
                                @if (!File::exists($posts->upload->video))
                                    <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ config('config.file_path').'videos/'.$posts->user_id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                                    </div>
                                @else
                                    <div class="newsFeedImgVideo">
                                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >
                                        </video>
                                    </div>
                                @endif
                            @endif
                            <div class="user-bottom-options">
                                <div class="rating-flex">
                                    <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">
                                    <span class="avg-rating">{{ round(floatval($posts->averageRating)) }}/<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span></span>

                                </div>
                                <div class="right-options">
                                    @if(Auth::user()->id != $posts->user_id)
                                    <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}"><img src="/img/new/save.png" alt="Save"></a>
                                    @endif
                                    @if($posts['surfer'] == 'Unknown' && Auth::user()->id != $posts['user_id'])
                                    <a href="{{route('surferRequest', Crypt::encrypt($posts->id))}}"><img src="/img/new/small-logo.png" alt="Logo"></a>
                                    @endif
                                    <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                        <img src={{asset("/img/location.png")}} alt="Location"></a>
                                    <a onclick="openFullscreenSilder({{$posts->id}}, 'surfer-profile');"><img src={{asset("/img/expand.png")}} alt="Expand"></a>
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
                                    @if(Auth::user()->id != $posts->user_id)
                                    <div class="d-inline-block report dropdown" title="Report">
                                        <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <img src="/img/flag.png" alt="Report">
                                        </button>

                                        <div class="dropdown-menu">
                                            <form role="form" method="POST" name="report{{$posts->id}}" action="{{ route('report') }}">
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
                                                    <textarea class="form-control ps-2" name="comments" id="{{$posts->id}}"
                                                            placeholder="Additional Comments.."
                                                            style="height: 80px"></textarea>
                                                </div>
                                                <button type="submit" id="submitReport{{$posts->id}}" class="btn blue-btn w-100">REPORT</button>
                                            </form>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="comments-div">
                            <a class="" data-bs-toggle="collapse" href="#collapseExample{{$posts->id}}" role="button"
                            aria-expanded="false" aria-controls="collapseExample{{$posts->id}}">
                                Say Something <img src="/img/dropdwon.png" alt="dropdown" class="ms-1">
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
                                        <button type="submit" id="submitPost{{$posts->id}}" class="send-btn btn"><img src="/img/send.png"></button>
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
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="justify-content-center ajax-load" style="display:none;margin-left: 40%">
                    <img src="/images/spiner4.gif" alt="loading" height="90px;" width="170px;">
              </div>
            </div>

            <div class="right-advertisement">
                <img src="/img/new/advertisement1.png" alt="advertisement">
                <img src="/img/new/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>
@include('elements/location_popup_model')
@include('layouts/models/full_screen_modal')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
	var page = 1;

    $(window).scroll(function() {
        let requestType = "{{ $request_type }}";
        console.log("sdfds = "+requestType);
        if((requestType == 'surfer-request') || (requestType == 'reject') || (requestType == 'accept') || (requestType == 'follow')) {
            console.log("sdfds");
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                page++;
                loadMoreData(page);
            }
        }
    });

    function loadMoreData(page) {
        var url = window.location.href;
        if(url.indexOf("?") !== -1) {
            var url = window.location.href + '&page=' + page;
        }else {
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
            if(data.html == "") {
                $('.ajax-load').addClass('requests');
                $('.ajax-load').html("No more records found");
                return;
            }

            $('.ajax-load').removeClass('requests');
            $('.ajax-load').hide();
//            $("#post-data").insertBefore(data.html);
            // $(data.html).insertBefore(".ajax-load");
        });
    }


        $('.pos-rel a').each(function(){
           $(this).on('hover, mouseover, click', function() {
                $(this).children('.userinfoModal').find('input[type="text"]').focus();
            });
        });

      function openFullscreenSilder(id) {
          $.ajax({
                url: '/getPostFullScreen/' + id,
                type: "get",
                async: false,
                success: function(data) {
                    // console.log(data.html);
                    $("#full_screen_modal").html("");
                    $("#full_screen_modal").append(data.html);
                    $("#full_screen_modal").modal('hide');
                    $("#full_screen_modal").modal('show');
                }
            });
      }

</script>
@endsection