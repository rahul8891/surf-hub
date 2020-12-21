@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @include('layouts/user/upload_layout')
                    @if (!empty($myHubs))
                    @foreach ($myHubs as $key => $myHub)
                <div class="post">
                    @if($key==0)
                    <h2>My Hub</h2>
                    @endif
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                @if($myHub->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$myHub->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <div class="profileImg no-image">
                                    {{ucwords(substr($myHub->user->user_profiles->first_name,0,1))}}{{ucwords(substr($myHub->user->user_profiles->last_name,0,1))}}
                                </div>
                                @endif
                                <div class="pl-3">
                                    <h4>{{$myHub->user->user_profiles->first_name}} {{$myHub->user->user_profiles->last_name}}</h4>
                                    <span>{{ postedDateTime($myHub->created_at) }}</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="{{ asset("/img/user.png")}}"" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class=" description">{{$myHub->post_text}}</p>
                                <div class="imgRatingWrap">
                                    @if(!empty($myHub->upload->image))
                                    <img src="{{ asset('storage/images/'.$myHub->upload->image) }}" alt="" class=" img-fluid" id="myImage{{$myHub->id}}">
                                    @endif
                                    @if(!empty($myHub->upload->video))
                                    <br><video width="100%" controls class=" img-fluid" id="myImage{{$myHub->id}}"><source src="{{ asset('storage/videos/'.$myHub->upload->video) }}"></video>
                                    @endif
                                    <div class="ratingShareWrap">
                                        <div class="rating ">
                                            <ul class="pl-0 mb-0 d-flex align-items-center">
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/star-grey.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <span>4.0(90)</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div>
                                            <ul class="pl-0 mb-0 d-flex">
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/instagram.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset("/img/maps-and-flags.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a onclick="openFullscreen({{$myHub->id}});"><img src="{{ asset("/img/full_screen.png")}}"
                                                            alt=""></a>
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
                                                                        {{date('d-m-Y',strtotime($myHub->created_at))}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Surf
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->surfer}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Username
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->user->user_profiles->first_name}} {{$myHub->user->user_profiles->last_name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Beach/Break
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->beach_breaks->beach_name}}/{{$myHub->beach_breaks->break_name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Country
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->countries->name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        State
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->states->name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Wave Size
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->wave_size}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Board Type
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$myHub->board_type}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="{{route('deleteUserPost', Crypt::encrypt($myHub->id))}}">DELETE</a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#">TAG</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if (count($myHub->comments) > 0)
                                    <div class="viewAllComments">
                                        @if (count($myHub->comments) > 5)
                                        <p class="viewCommentTxt">View all comments</p>
                                        @endif
                                        @foreach ($myHub->comments as $comments)
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
                    @endforeach
                    @endif
                </div>
                <div class="col-lg-3">
                    <div class="adWrap">
                        <img src="{{ asset("/img/add1.png")}}" alt="" class="img-fluid">
                    </div>
                    <div class="adWrap">
                        <img src="{{ asset("/img/add2.png")}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
</section>
@include('layouts/models/upload_video_photo')
@endsection