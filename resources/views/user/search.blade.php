@extends('layouts.user.user')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />
<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.user.left_user_detail_menu')    

            <div class="middle-content">
                @include('layouts/user/upload_layout')

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
                                <img src="img/user-img.png" alt="USer">
                                <div>
                                    <p class="name"><span>{{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</span> Shared by Upender (Upen001)
                                    </p>
                                    <p class="address">{{ $posts->beach_breaks->beach_name ?? '' }} {{ $posts->beach_breaks->break_name ?? '' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y')}}</p>
                                    <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p>
                                </div>
                            </div>
                            @if (isset(Auth::user()->id) && ($posts->user_id != Auth::user()->id))

                            <div class="user-right">
                                <img src="img/normal-user.png" alt="normal-user">
                                <a href="#" class="follow-btn <?php echo (isset($posts->followPost->id) && !empty($posts->followPost->id)) ? ((($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0')) ? 'clicked' : 'clicked Follow') : 'followPost' ?>" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}"><img src="img/follow-user.png">FOLLOW</a>
                            </div>
                            @endif
                        </div>
                        @if(!empty($posts->upload->image))
                        <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="Feed" class="w-100">
                        @elseif(!empty($posts->upload->video))
                        @if (!File::exists($posts->upload->video))
                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>
                        @else
                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>
                        @endif
                        @endif
                        <div class="user-bottom-options">
                            <div>
                                <div class="rating">
                                    <img src="img/blue-star.png" alt="start" class="align-text-bottom">
                                    <span>{{ round(floatval($posts->averageRating)) }} </span>
                                </div>
                                <div class="highlight">Highlights</div>
                            </div>
                            <div class="right-options">
                                <a href="#"><img src="img/small-logo.png" alt="Logo"></a>
                                <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                <img src={{asset("img/location.png")}} alt="Location">
                            </a>
                                <!--<a href="#"><img src="img/location.png" alt="Location"></a>-->
                                <a onclick="openFullscreen({{$posts->id}});"><img src={{asset("img/expand.png")}} alt="Expand"></a>
                                <!--<a href="#"><img src="img/expand.png" alt="Expand"></a>-->
                                <a href="#"><img src="img/edit.png" alt="Edit"></a>
                                <a href="#"><img src="img/warning.png" alt="Warning"></a>
                                <a href="#"><img src="img/delete.png" alt="Delete"></a>
                                <a href="#"><img src="img/tag.png" alt="Tag"></a>
                                <a href="#"><img src="img/flag.png" alt="Flag"></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--                <div class="news-feed">
                                    <div class="inner-news-feed">
                                        <div class="user-details">
                                            <div class="user-left">
                                                <img src="img/user-img.png" alt="USer">
                                                <div>
                                                    <p class="name"><span>John Ward ( Wardy )</span> Shared by Upender (Upen001)
                                                    </p>
                                                    <p class="address">Noosa Heads Main Beach , 03-01-2022</p>
                                                    <p class="time-ago">4 months ago</p>
                                                </div>
                                            </div>
                                            <div class="user-right">
                                                <img src="img/normal-user.png" alt="normal-user">
                                                <a href="#" class="follow-btn"><img src="img/follow-user.png">FOLLOW</a>
                                            </div>
                                        </div>
                                        <img src="img/feed-big-img.png" alt="Feed" class="w-100">
                                        <div class="user-bottom-options">
                                            <div>
                                                <div class="rating">
                                                    <img src="img/blue-star.png" alt="start" class="align-text-bottom">
                                                    <span>3/5</span>
                                                </div>
                                                <div class="highlight">Highlights</div>
                                            </div>
                                            <div class="right-options">
                                                <a href="#"><img src="img/small-logo.png" alt="Logo"></a>
                                                <a href="#"><img src="img/location.png" alt="Location"></a>
                                                <a href="#"><img src="img/expand.png" alt="Expand"></a>
                                                <a href="#"><img src="img/edit.png" alt="Edit"></a>
                                                <a href="#"><img src="img/warning.png" alt="Warning"></a>
                                                <a href="#"><img src="img/delete.png" alt="Delete"></a>
                                                <a href="#"><img src="img/tag.png" alt="Tag"></a>
                                                <a href="#"><img src="img/flag.png" alt="Flag"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comments-div">
                                        <a class="" data-bs-toggle="collapse" href="#collapseExample" role="button"
                                           aria-expanded="false" aria-controls="collapseExample">
                                            Say Something <img src="img/dropdwon.png" alt="dropdown" class="ms-1">
                                        </a>
                                        <div class="collapse" id="collapseExample">
                                            <form>
                                                <div class="comment-box">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control ps-2 mb-0 h-100">
                                                    </div>
                                                    <button class="send-btn btn"><img src="img/send.png"></button>
                                                </div>
                                            </form>
                                            <div class="comment-row">
                                                <span class="comment-name">Upender Rawat : </span>
                                                Nice Photogrph
                                            </div>
                                            <div class="comment-row">
                                                <span class="comment-name">Upender Rawat : </span>
                                                Nice Photogrph
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="news-feed">
                                    <div class="inner-news-feed">
                                        <img src="img/feed-big-img-2.png" alt="Feed" class="w-100">
                                    </div>
                                </div>
                                <div class="news-feed">
                                    <div class="inner-news-feed">
                                        <div class="user-details">
                                            <div class="user-left">
                                                <img src="img/user-img.png" alt="USer">
                                                <div>
                                                    <p class="name"><span>John Ward ( Wardy )</span> Shared by Upender (Upen001)
                                                    </p>
                                                    <p class="address">Noosa Heads Main Beach , 03-01-2022</p>
                                                    <p class="time-ago">4 months ago</p>
                                                </div>
                                            </div>
                                            <div class="user-right">
                                                <img src="img/photographer-user.png" alt="photographer-user">
                                                <a href="#" class="follow-btn"><img src="img/follow-user.png">FOLLOW</a>
                                            </div>
                                        </div>
                                        <img src="img/feed-big-img.png" alt="Feed" class="w-100">
                                        <div class="user-bottom-options">
                                            <div>
                                                <div class="rating">
                                                    <img src="img/blue-star.png" alt="start" class="align-text-bottom">
                                                    <span>3/5</span>
                                                </div>
                                                <div class="highlight">Highlights</div>
                                            </div>
                                            <div class="right-options">
                                                <a href="#"><img src="img/small-logo.png" alt="Logo"></a>
                                                <a href="#"><img src="img/location.png" alt="Location"></a>
                                                <a href="#"><img src="img/expand.png" alt="Expand"></a>
                                                <a href="#"><img src="img/edit.png" alt="Edit"></a>
                                                <a href="#"><img src="img/warning.png" alt="Warning"></a>
                                                <a href="#"><img src="img/delete.png" alt="Delete"></a>
                                                <a href="#"><img src="img/tag.png" alt="Tag"></a>
                                                <a href="#"><img src="img/flag.png" alt="Flag"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                @endforeach
                @endif
            </div>

            <div class="right-advertisement">
                <img src="img/advertisement1.png" alt="advertisement">
                <img src="img/advertisement2.png" alt="advertisement">
            </div>

        </div>
    </div>
</section>
<!--<section class="postsWrap a_searchPage">
<div class="container">
<div class="row">
<div class="col-lg-12" id="search-data-main">
<div class="col-lg-12" id="search-data">
include comman upload video and photo layout 
@include('layouts/user/upload_layout')
    @if (is_null($postsList[0]))
    <div class="post alert text-center alert-dismissible py-5" role="alert">
        {{ ucWords('no matches found') }}
    </div>
    @else
    @foreach ($postsList as $key => $posts)
<div class="post">
    @if($key==0)
    <h2>Search Feed</h2>
    @endif
    <div class="inner">
        <div class="post-head">
            <div class="userDetail">
                @if(file_exists(asset('storage/'.$posts->user->profile_photo_path)))
                    <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                @else
                    <img src="/img/logo_small.png" class="profileImg" alt="">
                @endif
                <div class="pl-3">
                    <h4>{{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</h4>
                    <span>{{ $posts->beach_breaks->beach_name ?? '' }} {{ $posts->beach_breaks->break_name ?? '' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y')}}</span><br>
                    <span>{{ postedDateTime($posts->created_at) }}</span>
                </div>
            </div>
            @if (isset(Auth::user()->id) && ($posts->user_id != Auth::user()->id))
                <button class="followBtn follow <?php echo (isset($posts->followPost->id) && !empty($posts->followPost->id)) ? ((($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0')) ? 'clicked' : 'clicked Follow') : 'followPost' ?>" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
                    <img src="img/user.png" alt=""> FOLLOW
                </button>
            @endif
        </div>
        <p class="description">{{$posts->post_text}}</p>
            @php 
                $url = Request::url();
            @endphp
        <div class="imgRatingWrap">
            @if(!empty($posts->upload->image))
                <div class="pos-rel editBtnWrap">
                    <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="" class=" img-fluid" id="myImage{{$posts->id}}">
                </div>
            @elseif(!empty($posts->upload->video))
                <div class="pos-rel editBtnWrap">
                    @if (!File::exists($posts->upload->video))
                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                        <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                    </video>
                    @else
                    <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                        <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                    </video>
                    @endif
                </div>
            @endif
            
            <div class="ratingShareWrap">
                <ul class="pl-0 mb-0 d-flex align-items-center">
                    <li>
                        <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}"
                        data-min="0" data-max="5" data-step="1" data-size="xs" value="{{ round($posts->averageRating) }}">   
                    </li>
                    <li class="ratingCount">
                        <span id="average-rating{{$posts->id}}">{{ round(floatval($posts->averageRating)) }}</span>
                        (<span id="users-rated{{$posts->id}}">{{ $posts->usersRated() }}</span>)
                    </li>
                </ul>
                <div>
                    <ul class="pl-0 mb-0 d-flex">
                         <li>
                            <a href="#"><img src={{asset("img/instagram.png")}} alt=""></a>
                        </li>
                        <li>
                            <span class="divider"></span>
                        </li> 
                        <li>
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ url('/')."/postData/".$posts->id }}">                                                
                                <img src="{{ asset("/img/facebook.png")}}" alt="">
                            </a> 
                        </li>
                        <li>
                            <span class="divider"></span>
                        </li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                <img src={{asset("img/maps-and-flags.png")}} alt="">
                            </a>
                        </li>
                        <li>
                            <span class="divider"></span>
                        </li>
                        <li>
                            <a onclick="openFullscreen({{$posts->id}});"><img src={{asset("img/full_screen.png")}} alt=""></a>
                        </li>
                        <li>
                            <span class="divider"></span>
                        </li>
                        <li class="pos-rel">
                            <a href="javascript:void(0)">INFO
                                <div class="saveInfo infoHover">
                                    <div class="pos-rel">
                                        <img src={{asset("img/tooltipArrowDown.png")}} alt="">
                                        <div class="row">
                                            <div class="col-5">
                                                Date
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{date('d-m-Y',strtotime($posts->surf_start_date))}}
                                            </div>
                                            <div class="col-5">
                                                Surfer
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{$posts->surfer}}
                                            </div>
                                            <div class="col-5">
                                                Posted By
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{ucfirst($posts->user->user_name)}}
                                            </div>
                                            <div class="col-5">
                                                Beach/Break
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{$posts->beach_breaks->beach_name ?? ''}}/{{$posts->beach_breaks->break_name ?? ''}}
                                            </div>
                                            <div class="col-5">
                                                Country
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{$posts->countries->name}}
                                            </div>
                                            <div class="col-5">
                                                State
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{$posts->states->name??""}}
                                            </div>
                                            <div class="col-5">
                                                Wave Size
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                @foreach($customArray['wave_size'] as $key => $value)
                                                    @if($key == $posts->wave_size)
                                                        {{$value}}
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="col-5">
                                                Board Type
                                            </div>
                                            <div class="col-2 text-center">:</div>
                                            <div class="col-5">
                                                {{$posts->board_type}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        @if(isset(Auth::user()->id) && (Auth::user()->id != $posts->user_id))
                        <li>
                            <span class="divider"></span>
                        </li>
                        <li class="pos-rel">
                            <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}" class="">SAVE
                                <div class="saveInfo">
                                    <div class="pos-rel">
                                        <img src={{asset("img/tooltipArrowDown.png")}} alt="">
                                        Save this video to your personal MyHub library
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <span class="divider"></span>
                        </li>
                        <li>
                            <a href="javascript:void(0)">REPORT
                                <form role="form" method="POST" name="report{{$posts->id}}" action="{{ route('report') }}">
                                    @csrf
                                    <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                                    <div class="saveInfo infoHover reasonHover">
                                        <div class="pos-rel">
                                            <img src={{asset("img/tooltipArrowDown.png")}} alt="">
                                            <div class="text-center reportContentTxt">Report Content</div>
                                            <div class="reason">
                                                <input type="checkbox" id="Report1" name="incorrect" value="1">
                                                <label for="Report1">Report Info as incorrect</label>
                                            </div>
                                            <div class="cstm-check pos-rel">
                                                <input type="checkbox" id="Report2" name="inappropriate" value="1">
                                                <label for="Report2">Report content as inappropriate</label>
                                            </div>
                                            <div class="cstm-check pos-rel">
                                                <input type="checkbox" id="Report3" name="tolls" value="1">
                                                <label for="Report3">Report tolls</label>
                                            </div>
                                            <div>
                                                Additional Comments:
                                                <textarea name="comments" class="reportOnPost" id="{{$posts->id}}"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-info postReport" id="submitReport{{$posts->id}}">REPORT</button>
                                        </div>
                                    </div>
                                </form>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            @if (count($posts->comments) > 0)
            <div class="viewAllComments">
                @if (count($posts->comments) > 5)
                <div class="modal" id="commentPopup">
                  <div class="modal-dialog">
                    <div class="modal-content">

                       Modal Header 
                      <div class="modal-header">
                        <h4 class="modal-title">Comments</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                       Modal body 
                      <div class="modal-body">
                        @foreach ($posts->comments as $comments)
                        <p class="comment ">
                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                        </p>
                        @endforeach
                      </div>

                       Modal footer 
                      <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                      </div>

                    </div>
                  </div>
                </div>
                <p class="viewCommentTxt" data-toggle="modal" data-target="#commentPopup">View all comments</p>
                @endif
                @foreach ($posts->comments->slice(0, 5) as $comments)
                <p class="comment ">
                    <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                </p>
                @endforeach
            </div>
            @endif
            @if(Auth::user())
            <div class="WriteComment">
                <form role="form" method="POST" name="comment{{$posts->id}}" action="{{ route('comment') }}">
                @csrf
                <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                <input type="hidden" name="parent_user_id" value="{{$posts->user_id}}">
                <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$posts->id}}" style="outline: none;"></textarea>
                <button type="submit" class="btn btn-info postComment" id="submitPost{{$posts->id}}">Submit</button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
@endif
</div>
<div class=""></div>
<div class="ajax-load ajax-loadBtm" style="display:none">
    <div class="letter-holder">
        <div class="load-6">
            <div class="letter-holder">
            <div class="l-1 letter">L</div>
            <div class="l-2 letter">o</div>
            <div class="l-3 letter">a</div>
            <div class="l-4 letter">d</div>
            <div class="l-5 letter">i</div>
            <div class="l-6 letter">n</div>
            <div class="l-7 letter">g</div>
            <div class="l-8 letter">.</div>
            <div class="l-9 letter">.</div>
            <div class="l-10 letter">.</div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="col-lg-3">
<div class="adWrap">
    <img src={{asset("img/add1.png")}} alt="" class="img-fluid">
</div>
<div class="adWrap">
    <img src={{asset("img/add2.png")}} alt="" class="img-fluid">
</div>
</div>
</div>
</div>
</section>-->
@include('elements/location_popup_model')
@include('layouts/models/upload_video_photo')

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" type="text/javascript"></script>
<script type="text/javascript">
var page = 1;

$(window).scroll(function () {
    if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        loadMoreData(page);
    }
});

function loadMoreData(page) {
    var url = window.location.href;
    if (url.indexOf("?") !== -1) {
        var url = window.location.href + '&page=' + page;
    } else {
        var url = window.location.href + '?page=' + page;
    }

    $.ajax({
        url: url,
        type: "get",
        async: false,
        beforeSend: function () {
            $('.ajax-load').show();
        }
    })
            .done(function (data) {
                if (data.html == "") {
                    $('.ajax-load').addClass('requests');
                    $('.ajax-load').html("No more records found");
                    return;
                }

                $('.ajax-load').removeClass('requests');
                $('.ajax-load').hide();
                $("#search-data").append(data.html);
            });
}
</script>
@endsection