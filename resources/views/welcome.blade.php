@extends('layouts.user.user')
@section('content')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                    @if (!empty($postsList))
                    @foreach ($postsList as $key => $posts)
                <div class="post">
                    @if($key==0)
                    <h2>SurfHub Feed</h2>
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
                            <a href="{{ route('login') }}" class="followBtn">
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
                                <ul class="pl-0 mb-0 d-flex align-items-center">
                                    <li>
                                        <input  name="rating" class="rating rating-loading" 
                                        data-min="0" data-max="5" data-step="1" data-size="xs" value="4" readonly="readonly" style="pointer-events: none; opacity: 0; cursor: pointer;">   
                                    </li>
                                    
                                </ul>
                                
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#">
                                                <img src="img/facebook.png" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude}}" data-long="{{$posts->beach_breaks->longitude}}" data-id="{{$posts->id}}" class="locationMap">
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
                                                                Surf
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
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="{{ route('login') }}">SAVE</a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="{{ route('login') }}">REPORT</a>
                                        </li>
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
                    <img src="img/add1.png" alt="" class="img-fluid">
                </div>
                <div class="adWrap">
                    <img src="img/add2.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@include('elements/location_popup_model')
@endsection