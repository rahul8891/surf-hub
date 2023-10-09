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
                                <td>Surfer Name</td>
                                <td>:</td>
                                @if(!empty($userProfile['surfer_name']))
                                <td>{{ $userProfile['surfer_name'] }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td>Gender</td>
                                <td>:</td>
                                @if(!empty($userProfile['gender']))<td>{{ $userProfile['gender'] }}</td>@endif
                            </tr>
                            <tr>
                                <td>Country</td>
                                <td>:</td>
                                @if(!empty($userProfile['gender']))<td>{{ $userProfile['gender'] }}</td>@endif
                            </tr>
                            <tr>
                                <td>Preferred Board</td>
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
                                <td>Local Beach</td>
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
                    @if (!empty($postsList))
                    @foreach ($postsList as $key => $posts)
                    <div class="news-feed">
                        <div class="inner-news-feed">
                            <div class="user-details">
                                <div class="user-left">
                                    @if(asset('storage/'.$posts->profile_photo_path))
                                    <img src="{{ asset('storage/'.$posts->profile_photo_path) }}" class="profileImg" alt="">
                                    @else
                                    <img src="/img/user-img.png" alt="USer">
                                    @endif
                                    <div>
                                        <p class="name"><span>{{ ucfirst($posts->user->user_profiles->first_name) }} {{ ucfirst($posts->user->user_profiles->last_name) }} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</span>
                                        </p>
                                        <p class="discription">{{ $posts->post_text }}</p>
                                        <p class="address">{{ (isset($posts->beach_breaks->beach_name))?$posts->beach_breaks->beach_name:'' }} {{ (isset($posts->breakName->break_name))?$posts->breakName->break_name:'' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</p>
                                        <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p>
                                    </div>
                                </div>
                                <div class="user-right">
                                    <a class="btn grey-borderBtn me-3 accept" href="{{ route('acceptRejectRequest', [Crypt::encrypt($posts->request_id),'accept']) }}">
                                        <img src="/img/accept.png" class="me-1 align-middle" alt="ACCEPT">
                                        <span class="align-middle">ACCEPT</span>
                                    </a>
                                    <a class="btn grey-borderBtn reject" href="{{ route('acceptRejectRequest', [Crypt::encrypt($posts->request_id),'reject']) }}">
                                        <img src="/img/reject.png" class="me-1 align-middle" alt="REJECT">
                                        <span class="align-middle">REJECT</span>
                                    </a>
                                </div>
                            </div>
                            @if(!empty($posts->upload->image))
                                <div class="newsFeedImgVideo">
                                    <img src="{{ env('IMAGE_FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" id="myImage{{$posts->id}}" class="postImg">
                                </div>
                            @elseif(!empty($posts->upload->video))
                                <div class="newsFeedImgVideo jw-video-player" id="myVid{{$posts->id}}" data-id="{{$posts->id}}" data-src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.getName($posts->upload->video).'/'.getName($posts->upload->video).'.m3u8' }}">
                                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myVideoTag{{$posts->id}}"></video>
                                </div>
                            @endif
                            <div class="user-bottom-options">

                                    <div class="rating-flex">
                                <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}" data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">
                                <span class="avg-rating">{{ round(floatval($posts->averageRating)) }}/<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span></span>


                                    <div class="highlight">Highlights</div>
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
                                    @if(Auth::user() && $posts->user_id == Auth::user()->id)
                                    <a href="{{route('deleteUserPost', Crypt::encrypt($posts->id))}}"  onclick="return confirm('Do you really want to delete this footage?')"><img src="/img/delete.png" alt="Delete"></a>
                                    @endif
                                    <a href="javascript:void(0)" class="editBtn editBtnVideo" data-id="{{ $posts->id }}"><img src="/img/edit.png" alt="Edit"></a>
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
                                                return;
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
</script>
@endsection
