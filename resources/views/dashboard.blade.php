@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <!--include comman upload video and photo layout -->
                @include('layouts/user/upload_layout')
                    @if (!empty($postsList))
                    @foreach ($postsList as $key => $posts)
                    @if($posts->parent_id == 0)
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
                                    <h4>{{$posts->user->user_profiles->first_name}} {{$posts->user->user_profiles->last_name}}</h4>
                                    <span>{{ postedDateTime($posts->created_at) }}</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="img/user.png" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class="description">{{$posts->post_text}}</p>
                        <div class="imgRatingWrap">
                            @if(!empty($posts->upload->image))
                            <img src="{{ asset('storage/images/'.$posts->upload->image) }}" alt="" class=" img-fluid" id="myImage{{$posts->id}}">
                            @endif
                            @if(!empty($posts->upload->video))
                            <br><video width="100%" controls class=" img-fluid" id="myImage{{$posts->id}}"><source src="{{ asset('storage/videos/'.$posts->upload->video) }}"></video>
                            @endif
                            <div class="ratingShareWrap">
                                <div class="rating ">
                                    <ul class="pl-0 mb-0 d-flex align-items-center">
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star.png" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/star-grey.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span>4.0(90)</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#"><img src="img/instagram.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/facebook.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src="img/maps-and-flags.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a onclick="openFullscreen({{$posts->id}});"><img src="img/full_screen.png" alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li class="pos-rel">
                                            <a href="javascript:void(0)">INFO
                                                <div class="saveInfo infoHover">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="row">
                                                            <div class="col-5">
                                                                Date
                                                            </div>
                                                            <div class="col-2 text-center">:</div>
                                                            <div class="col-5">
                                                                {{date('d-m-Y',strtotime($posts->created_at))}}
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
                                                                {{$posts->user->user_profiles->first_name}} {{$posts->user->user_profiles->last_name}}
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
                                                                {{$posts->wave_size}}
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
                                                <div class="saveInfo infoHover reasonHover">
                                                    <div class="pos-rel">
                                                        <img src="img/tooltipArrowDown.png" alt="">
                                                        <div class="text-center reportContentTxt">Report Content</div>
                                                        <div class="reason">
                                                            <input type="checkbox" id="Report1" name="Report1"
                                                                value="Report">
                                                            <label for="Report1">Report Info as incorrect</label>
                                                        </div>
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="Report3">
                                                            <label for="Report3">Report content as inappropriate</label>
                                                        </div>
                                                        <div class="cstm-check pos-rel">
                                                            <input type="checkbox" id="Report4">
                                                            <label for="Report4">Report tolls</label>
                                                        </div>
                                                        <div>
                                                            Additional Comments:
                                                            <textarea></textarea>
                                                        </div>
                                                        <button>REPORT</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            @if (count($posts->comments) > 0)
                            <div class="viewAllComments">
                                @if (count($posts->comments) > 1)
                                <div class="modal" id="myModal">
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
                                            <span>{{$comments->user->user_profiles->first_name}} {{$comments->user->user_profiles->first_name}} :</span> {{$comments->value}}
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
                                <p class="viewCommentTxt" data-toggle="modal" data-target="#myModal">View all comments</p>
                                @endif
                                @foreach ($posts->comments as $comments)
                                <p class="comment ">
                                    <span>{{$comments->user->user_profiles->first_name}} {{$comments->user->user_profiles->first_name}} :</span> {{$comments->value}}
                                </p>
                                @endforeach
                            </div>
                            @endif
                            <div class="WriteComment">
                                <textarea placeholder="Write a comment.."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
                    @endforeach
                    @endif
            </div>
            <div class="col-lg-3">
                <div class="adWrap">
                    <img src="img/add1.png" alt="" class="img-fluid">
                </div>
                <div class="adWrap">
                    <img src="img/add2.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts/models/upload_video_photo')
@endsection