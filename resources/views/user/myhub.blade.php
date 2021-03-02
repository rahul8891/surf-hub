@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')

<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @include('layouts/user/upload_layout')
                @if (is_null($myHubs[0]))
                <div class="post alert text-center alert-dismissible py-5" role="alert" id="msg">
                    {{ ucWords('no post found') }}
                </div>
                @elseif (!is_null($myHubs[0]))
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
                                    <h4>{{ucfirst($myHub->user->user_profiles->first_name)}} {{ucfirst($myHub->user->user_profiles->last_name)}}</h4>
                                    <span>{{ $myHub->beach_breaks->beach_name ?? '' }}, {{\Carbon\Carbon::parse($myHub->created_at)->format('d-m-Y')}}</span><br>
                                    <span>{{ postedDateTime($myHub->created_at) }}</span>
                                </div>
                            </div>

                            <form role="form" method="POST" name="follow{{$myHub->id}}" action="{{ route('follow') }}">
                            @csrf
                            <input type="hidden" class="userID" name="followed_user_id" value="{{$myHub->user_id}}">
                            <button href="#" class="followBtn">
                                <img src="/img/user.png" alt=""> FOLLOW
                            </button>
                            </form>
                        </div>
                        <p class=" description">{{$myHub->post_text}}</p>
                                <div class="imgRatingWrap">
                                    @if(!empty($myHub->upload->image))
                                    <img src="{{ asset('storage/images/'.$myHub->upload->image) }}" alt="" width="100%" class="img-fluid" id="myImage{{$myHub->id}}">
                                    @endif
                                    @if(!empty($myHub->upload->video))
                                    <br>
                                    <video width="100%" controls id="myImage{{$myHub->id}}">
                                        <source src="{{ asset('storage/videos/'.$myHub->upload->video) }}" >    
                                    </video>
                                    @endif

                                    <div class="ratingShareWrap">
                                        <ul class="pl-0 mb-0 d-flex align-items-center">
                                            <li>
                                                <input id="rating{{$myHub->id}}" name="rating" class="rating rating-loading" data-id="{{$myHub->id}}"
                                                data-min="0" data-max="5" data-step="1" data-size="xs" value="{{$myHub->userAverageRating}}">   
                                            </li>
                                            <li class="ratingCount">
                                                <span id="average-rating{{$myHub->id}}">{{intval($myHub->usersRated())}}</span>
                                                (<span id="users-rated{{$myHub->id}}">{{intval($myHub->averageRating)}}</span>)
                                                
                                            </li>
                                        </ul>
                                        <div>
                                            <ul class="pl-0 mb-0 d-flex">
                                                <li>
                                                    <a href="#"><img src="{{ asset("/img/instagram.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    @if(!empty($myHub->upload->image))
                                                    <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($myHub->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>&amp;p[image][0]=<?php echo (asset('storage/images/'.$myHub->upload->image)); ?>,'sharer'">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                    @elseif(!empty($myHub->upload->video))
                                                    <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($myHub->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>&amp;p[image][0]=<?php echo (asset('storage/images/'.$myHub->upload->video)); ?>,'sharer'">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                    @else
                                                    <a target="_blank" href="http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo ($myHub->post_text); ?>&amp;p[url]=<?php echo (asset('')); ?>,'sharer'">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                    @endif
                                                </li>
                                                <!-- <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$myHub->beach_breaks->latitude}}" data-long="{{$myHub->beach_breaks->longitude}}" data-id="{{$myHub->id}}" class="locationMap">
                                                        <img src="{{ asset("/img/maps-and-flags.png")}}" alt="">
                                                    </a>
                                                </li> -->
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
                                                                <img src="{{ asset("img/tooltipArrowDown.png")}}" alt="">
                                                                <div class="row">
                                                                    <div class="col-5">
                                                                        Date
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{date('d-m-Y',strtotime($myHub->created_at))}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Surfer
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
                                                                        {{ucfirst($myHub->user->user_profiles->first_name)}} {{ucfirst($myHub->user->user_profiles->last_name)}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Beach/Break
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{ $myHub->beach_breaks->beach_name ?? '' }}/{{ $myHub->beach_breaks->break_name ?? '' }}
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
                                                                        {{$myHub->states->name??""}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Wave Size
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        @foreach($customArray['wave_size'] as $key => $value)
                                                                            @if($key == $myHub->wave_size)
                                                                                {{$value}}
                                                                            @endif
                                                                        @endforeach
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
                                                <li class="pos-rel">
                                                    @if (count($myHub->tags) >= 1)
                                                    <div class="modal" id="postTag{{$myHub->id}}">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">

                                                          <!-- Modal Header -->
                                                          <div class="modal-header">
                                                            <h4 class="modal-title">Tagged Users</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          </div>

                                                          <!-- Modal body -->
                                                          <div class="modal-body">
                                                            @foreach ($myHub->tags as $tags)
                                                            <p class="comment ">
                                                                <div class="post-head">
                                                                <div class="userDetail">
                                                                @if($tags->user->profile_photo_path)
                                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="profileImg" alt="">
                                                                @else
                                                                <div class="profileImg no-image">
                                                                    {{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}
                                                                </div>
                                                                @endif
                                                                <span>{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>
                                                                </div>
                                                            </div>
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
                                                    @endif
                                                    <!-- <a data-toggle="modal" data-target="#postTag{{$myHub->id}}">TAG -->
                                                    <a href="javascript:void(0)">TAG
                                                        
                                                        <div class="saveInfo infoHover userinfoModal">
                                                            <div class="pos-rel">
                                                                <img src="../../../img/tooltipArrowDown.png" alt="">
                                                                <div class="scrollWrap">
                                                                    
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                                <img src="../../../img/johan.png" class="" alt="">   
                                                                                <!-- <div class="taggedUserImg no-image">
                                                                                  
                                                                                </div> -->
                                                                            </div>
                                                                            <span class="userName">Rafi Raza</span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                                <!-- <img src="../../../img/johan.png" class="" alt="">    -->
                                                                                <div class="taggedUserImg no-image">
                                                                                  RR
                                                                                </div>
                                                                            </div>
                                                                            <span class="userName">Rafi Raza</span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                                <img src="../../../img/johan.png" class="" alt="">   
                                                                                <!-- <div class="taggedUserImg no-image">
                                                                                  
                                                                                </div> -->
                                                                            </div>
                                                                            <span class="userName">Rafi Raza</span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                                <!-- <img src="../../../img/johan.png" class="" alt="">    -->
                                                                                <div class="taggedUserImg no-image">
                                                                                  RR
                                                                                </div>
                                                                            </div>
                                                                            <span class="userName">Rafi Raza</span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                                <img src="../../../img/johan.png" class="" alt="">   
                                                                                <!-- <div class="taggedUserImg no-image">
                                                                                  
                                                                                </div> -->
                                                                            </div>
                                                                            <span class="userName">Rafi Raza</span>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    @if (count($myHub->comments) > 0)
                                    <div class="viewAllComments">
                                        @if (count($myHub->comments) > 5)
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
                                                @foreach ($myHub->comments as $comments)
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
                                        @foreach ($myHub->comments->slice(0, 5) as $comments)
                                        <p class="comment ">
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                        </p>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="WriteComment">
                                        <form role="form" method="POST" name="comment{{$myHub->id}}" action="{{ route('comment') }}">
                                        @csrf
                                        <input type="hidden" class="postID" name="post_id" value="{{$myHub->id}}">
                                        <input type="hidden" name="parent_user_id" value="{{$myHub->user_id}}">
                                        <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$myHub->id}}" style="outline: none;"></textarea>
                                        <button type="submit" class="btn btn-info postComment" id="submitPost{{$myHub->id}}">Submit</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    <div class="">{{ $myHubs->links()}}</div>
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
@include('elements/location_popup_model')
@include('layouts/models/upload_video_photo')
@endsection
