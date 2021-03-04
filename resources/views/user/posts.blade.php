@extends('layouts.user.user')
@section('content')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="post">
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                @if($detail->post->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$detail->post->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <div class="profileImg no-image">
                                    {{ucwords(substr($detail->post->user->user_profiles->first_name,0,1))}}{{ucwords(substr($detail->post->user->user_profiles->last_name,0,1))}}
                                </div>
                                @endif
                                <div class="pl-3">
                                    <h4>{{ucfirst($detail->post->user->user_profiles->first_name)}} {{ucfirst($detail->post->user->user_profiles->last_name)}}</h4>
                                    <span>{{ postedDateTime($detail->created_at) }}</span>
                                </div>
                            </div>
                            
                        </div>
                        <p class=" description">{{$detail->post->post_text}}</p>
                                <div class="imgRatingWrap">
                                                                                
                                    @if(!empty($detail->post->upload->image))
                                    <img src="{{ asset('storage/images/'.$detail->post->upload->image) }}" alt="" width="100%" class="img-fluid" id="myImage{{$detail->post->id}}">
                                    @endif
                                    @if(!empty($detail->post->upload->video))
                                    <br>
                                    <video width="100%" controls id="myImage{{$detail->post->id}}">
                                        <source src="{{ asset('storage/videos/'.$detail->post->upload->video) }}" >    
                                    </video>
                                    @endif
                                    <div class="ratingShareWrap">
                                        <ul class="pl-0 mb-0 d-flex align-items-center">
                                            <li>
                                                <input id="rating{{$detail->post->id}}" name="rating" class="rating rating-loading" data-id="{{$detail->post->id}}"
                                                data-min="0" data-max="5" data-step="1" data-size="xs" value="{{$detail->post->userAverageRating}}">   
                                            </li>
                                            <li class="ratingCount">
                                                <span id="average-rating{{$detail->post->id}}">{{intval($detail->post->averageRating)}}</span>
                                                (<span id="users-rated{{$detail->post->id}}">{{intval($detail->post->usersRated())}}</span>)
                                                
                                            </li>
                                        </ul>
                                        <div>
                                            <ul class="pl-0 mb-0 d-flex">
                                                <!-- <li>
                                                    <a href="#"><img src="{{ asset("/img/instagram.png")}}" alt=""></a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li> -->
                                                <li>
                                                    <a href="#">
                                                        <img src="{{ asset("/img/facebook.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$detail->post->beach_breaks->latitude}}" data-long="{{$detail->post->beach_breaks->longitude}}" data-id="{{$detail->post->id}}" class="locationMap">
                                                        <img src="{{ asset("/img/maps-and-flags.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a onclick="openFullscreen({{$detail->post_id}});"><img src="{{ asset("/img/full_screen.png")}}"
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
                                                                        {{date('d-m-Y',strtotime($detail->created_at))}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Surfer
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$detail->post->surfer}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Username
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{ucfirst($detail->post->user->user_profiles->first_name)}} {{ucfirst($detail->post->user->user_profiles->last_name)}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Beach/Break
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$detail->post->beach_breaks->beach_name}}/{{$detail->post->beach_breaks->break_name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Country
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$detail->post->countries->name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        State
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$detail->post->states->name??""}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Wave Size
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        @foreach($customArray['wave_size'] as $key => $value)
                                                                            @if($key == $detail->post->wave_size)
                                                                                {{$value}}
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Board Type
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$detail->post->board_type}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <!-- <li>
                                                    <a href="{{route('deleteUserPost', Crypt::encrypt($detail->id))}}">DELETE</a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li> -->
                                                <li class="pos-rel">
                                                    <a href="javascript:void(0)">TAG
                                                        @if(count($detail->post->tags) >= 1)
                                                        <div class="saveInfo infoHover">
                                                            <div class="pos-rel">
                                                                <img src="img/tooltipArrowDown.png" alt="">
                                                                <div class="row">
                                                                    @foreach ($detail->post->tags->reverse() as $tags)
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
                                    @if (count($detail->post->comments) > 0)
                                    <div class="viewAllComments" id="Comment">
                                        @if (count($detail->post->comments) > 5)
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
                                                @foreach ($detail->post->comments as $comments)
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
                                        @foreach ($detail->post->comments->slice(0, 5) as $comments)
                                        <p class="comment">
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                        </p>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="WriteComment">
                                        <form role="form" method="POST" name="comment{{$detail->post_id}}" action="{{ route('comment') }}">
                                        @csrf
                                        <input type="hidden" class="postID" name="post_id" value="{{$detail->post_id}}">
                                        <input type="hidden" name="parent_user_id" value="{{$detail->receiver_id}}">
                                        <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$detail->post_id}}" style="outline: none;"></textarea>
                                        <button type="submit" class="btn btn-info postComment" id="submitPost{{$detail->post_id}}">Submit</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
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