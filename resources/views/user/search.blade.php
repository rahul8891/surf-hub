@extends('layouts.user.user')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<link href="https://vjs.zencdn.net/7.11.4/video-js.css" rel="stylesheet" />

<section class="home-section">
    
    <div class="container">
        <div class="show-vid">
    
</div>
        <div class="home-row">
            
            @include('layouts.user.left_sidebar')    

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
                        <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="Feed" class="w-100" id="myImage{{$posts->id}}">
                        @elseif(!empty($posts->upload->video))
                        @if (!File::exists($posts->upload->video))
                        <!-- Carousel wrapper -->
                        <div id="carouselVideoExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
<!--                             Indicators 
                            <div class="carousel-indicators">
<button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide-to="2" aria-label="Slide 3"></button>
                            </div>-->

                            <!-- Inner -->
                            <div class="carousel-inner">
                                <!-- Single item -->
                                <div class="carousel-item active">
                                    <video width="100%" preload="auto" data-setup="{}" controls controlsList="nofullscreen nodownload" autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                                        <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" />
                                    </video>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>First slide label</h5>
                                        <p>
                                            Nulla vitae elit libero, a pharetra augue mollis interdum.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- Inner -->

                            <!-- Controls -->
                            <button class="carousel-control-prev" type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-mdb-target="#carouselVideoExample" data-mdb-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
<!-- Carousel wrapper -->
<!--                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>-->
                        @else
<!--                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>-->
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
                                <img src={{asset("img/location.png")}} alt="Location"></a>
                                <!--<a href="#"><img src="img/location.png" alt="Location"></a>-->
                                @if(!empty($posts->upload->video))
                                <a onclick="openFullscreen('{{env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video}}');"><img src={{asset("img/expand.png")}} alt="Expand"></a>
                                @endif
                                <!--<a href="#"><img src="img/expand.png" alt="Expand"></a>-->
                                <!--<a href="#"><img src="img/edit.png" alt="Edit"></a>-->
                                <a href="javascript:void(0)"><img src="img/warning.png" alt="Warning">
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
                                <!--<a href="#"><img src="img/warning.png" alt="Warning"></a>-->
                                <!--<a href="#"><img src="img/delete.png" alt="Delete"></a>-->
                                <a href="#"><img src="img/tag.png" alt="Tag"></a>
                                <a href="#"><img src="img/flag.png" alt="Flag"></a>
                            </div>
                        </div>
                    </div>
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
                </div>

<!--                                <div class="news-feed">
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