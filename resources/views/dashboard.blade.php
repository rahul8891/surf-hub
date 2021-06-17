@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')

<script src="https://code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" type="text/javascript"></script>
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9" id="post-data">
                <!--include comman upload video and photo layout -->
                @include('layouts/user/upload_layout')
                @if (is_null($postsList[0]))
                    <div class="post alert text-center alert-dismissible py-5" role="alert" id="msg">
                        {{ ucWords('no post available') }}
                    </div>
                @elseif (!is_null($postsList[0]))
                    @foreach ($postsList as $key => $posts)
                <div class="post">
                    @if($key==0)
                    <h2>My Feed</h2>
                    @endif
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                @if($posts->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <div class="profileImg no-image">
                                    {{ucwords(substr($posts->user->user_profiles->first_name,0,1))}}{{ucwords(substr($posts->user->user_profiles->last_name,0,1))}}
                                </div>
                                @endif
                                <div class="pl-3">
                                    <h4>{{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}}</h4>
                                    <span>{{ postedDateTime($posts->created_at) }}</span>
                                </div>
                            </div>
                            @if($posts->user_id != Auth::user()->id)
                            <button class="followBtn follow clicked" data-id="{{$posts->user_id}}" data-post_id="{{$posts->id}}">
                                <img src="img/user.png" alt=""> FOLLOW
                            </button>
                            @endif
                        </div>
                        <p class="description">{{$posts->post_text}}</p>
                        <div class="imgRatingWrap">
                            @if(!empty($posts->upload->image))
                            <div class="pos-rel editBtnWrap">
                                <img src="/storage/images/{{ (isset($posts->upload->image) && !empty($posts->upload->image))?$posts->upload->image:'' }}" alt="" class=" img-fluid" id="myImage{{$posts->id}}">
                                
                            </div>                            
                            @endif
                            @if(!empty($posts->upload->video))
                            <br>
                            <div class="pos-rel editBtnWrap">
                                <video width="100%" controls class=" img-fluid" id="myImage{{$posts->id}}"><source src="{{ asset('storage/videos/'.$posts->upload->video) }}"></video>
                                
                            </div>                            
                            @endif
                            
                            <div class="ratingShareWrap">
                                <ul class="pl-0 mb-0 d-flex align-items-center">
                                    <li>
                                        <input id="rating{{$posts->id}}" name="rating" class="rating rating-loading" data-id="{{$posts->id}}"
                                        data-min="0" data-max="5" data-step="1" data-size="xs" value="{{$posts->userAverageRating}}">   
                                    </li>
                                    <li class="ratingCount">
                                        <span id="average-rating{{$posts->id}}">{{intval($posts->averageRating)}}</span>
                                        (<span id="users-rated{{$posts->id}}">{{intval($posts->usersRated())}}</span>)
                                        
                                    </li>
                                </ul>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <!-- <li>
                                            <a href="#"><img src={{asset("img/instagram.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li> -->
                                        <li>
                                           @if(!empty($posts->upload->image))
                                                <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($posts->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>&amp;p[image][0]=<?php echo (asset('storage/images/'.$posts->upload->image)); ?>,'sharer'">
                                                    <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                </a>
                                            @elseif(!empty($posts->upload->video))
                                                <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($posts->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>&amp;p[image][0]=<?php echo (asset('storage/images/'.$posts->upload->video)); ?>,'sharer'">
                                                    <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                </a>
                                            @else
                                                <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($posts->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>,'sharer'">
                                                    <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                </a>
                                            @endif
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>                                            
                                            <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude}}" data-long="{{$posts->beach_breaks->longitude}}" data-id="{{$posts->id}}" class="locationMap">
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
                                                                Username
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}}
                                                            </div>
                                                            <div class="col-5">
                                                                Beach/Break
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{$posts->beach_breaks->beach_name}}/{{$posts->beach_breaks->break_name}}
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
                                        @if(Auth::user()->id != $posts->user_id)
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}" class="">SAVE
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        Save this photo/video to your personal MyHub library
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

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">Comments</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        @foreach ($posts->comments as $comments)
                                        <p class="comment ">
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                        </p>
                                        @endforeach
                                      </div>

                                      <!-- Modal footer -->
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
                            <div class="WriteComment">
                                <form role="form" method="POST" name="comment{{$posts->id}}" action="{{ route('comment') }}">
                                @csrf
                                <input type="hidden" class="postID" name="post_id" value="{{$posts->id}}">
                                <input type="hidden" name="parent_user_id" value="{{$posts->user_id}}">
                                <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$posts->id}}" style="outline: none;"></textarea>
                                <button type="submit" class="btn btn-info postComment" id="submitPost{{$posts->id}}">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
                    @endif
                    
                    <div class="ajax-load" style="display:none">
                        <p>Loading More post</p>
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
</section>
@include('elements/location_popup_model')
@include('layouts/models/upload_video_photo')

<script src="https://code.jquery.com/jquery-1.12.4.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
	var page = 1;
        
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
	        page++;
	        loadMoreData(page);
	    }
	});

	function loadMoreData(page) {
            $.ajax({
                url: '?page=' + page,
                type: "get",
                beforeSend: function() {
                    $('.ajax-load').show();
                }
            })
            .done(function(data) {
                if(data.html == " ") {
                    $('.ajax-load').html("No more records found");
                    return;
                }
                
                $('.ajax-load').hide();
                $("#post-data").append(data.html);
            });
	}
</script>
@endsection