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
                                    <span>{{ postedDateTime($myHub->created_at) }}</span>
                                </div>
                            </div>
                            <form role="form" method="POST" name="follow{{$myHub->id}}" action="{{ route('follow') }}">
                            @csrf
                            <input type="hidden" class="userID" name="followed_user_id" value="{{$myHub->user_id}}">
                            <button href="#" class="followBtn">
                                <img src="img/user.png" alt=""> FOLLOW
                            </button>
                            </form>
                        </div>
                        <p class=" description">{{$myHub->post_text}}</p>
                                <div class="imgRatingWrap">

                                    @php
                                        $postMedia=$myHub->upload->select('*')->where('post_id',$myHub->id)->get();
                                    @endphp
                                    @if (!empty($postMedia))   
                                    @foreach ($postMedia as $media)  
                                            @if (!is_null($media->image))
                                            <img src="{{ asset('storage/images/'.$media->image) }}"alt="" width="100%" class="img-fluid img-thumbnail" id="myImage{{$myHub->id}}">
                                            @endif
                                
                                            @if (!is_null($media->video))
                                            <video width="100%" controls id="myImage{{$myHub->id}}">
                                                <source src="{{ asset('storage/videos/'.$media->video) }}" >    
                                            </video>
                                            @endif
                                    @endforeach
                                    @endif
                                            
                                    {{-- @if(!empty($myHub->upload->image))
                                    <img src="{{ asset('storage/images/'.$myHub->upload->image) }}" alt="" width="100%" class="img-fluid" id="myImage{{$myHub->id}}">
                                    @endif
                                    @if(!empty($myHub->upload->video))
                                    <br>
                                    <video width="100%" controls id="myImage{{$myHub->id}}">
                                        <source src="{{ asset('storage/videos/'.$myHub->upload->video) }}" >    
                                    </video>
                                    @endif --}}
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
                                                        @if(count($myHub->tags) >= 1)
                                                        <div class="saveInfo infoHover">
                                                            <div class="pos-rel">
                                                                <img src="img/tooltipArrowDown.png" alt="">
                                                                <div class="row">
                                                                    @foreach ($myHub->tags as $tags)
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="col-5">
                                                                                @if($tags->user->profile_photo_path)
                                                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="taggedUserImg" alt="">
                                                                                @else
                                                                                <div class="taggedUserImg no-image">
                                                                                    {{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                            <div class="col-5">
                                                                                <span class="userName">{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
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
                                        <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$myHub->id}}"></textarea>
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
@include('layouts/models/upload_video_photo')
@endsection