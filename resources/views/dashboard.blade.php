@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')
<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <!--include comman upload video and photo layout -->
                @include('layouts/user/upload_layout')
                @if (is_null($postsList[0]))
                <div class="alert alert-warning text-center alert-dismissible" role="alert" id="msg">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    {{ ucWords('no data found') }}
                </div>
                @elseif (!is_null($postsList[0]))
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
                                    <h4>{{ucfirst($posts->user->user_profiles->first_name)}} {{ucfirst($posts->user->user_profiles->last_name)}}</h4>
                                    <span>{{ postedDateTime($posts->created_at) }}</span>
                                </div>
                            </div>
                            <a href="#" class="followBtn">
                                <img src="img/user.png" alt=""> FOLLOW
                            </a>
                        </div>
                        <p class="description">{{$posts->post_text}}</p>
                        <div class="imgRatingWrap">
                                    @php
                                        $postMedia=$posts->upload->select('*')->where('post_id',$posts->id)->get();
                                    @endphp
                                    @if (!empty($postMedia))   
                                    @foreach ($postMedia as $media)  
                                            @if (!is_null($media->image))
                                            <img src="{{ asset('storage/images/'.$media->image) }}"alt="" class="img-fluid img-thumbnail" id="myImage{{$posts->id}}">
                                            @endif
                                
                                            @if (!is_null($media->video))
                                            <video width="100%" controls id="myImage{{$posts->id}}">
                                                <source src="{{ asset('storage/videos/'.$media->video) }}" >    
                                            </video>
                                            @endif
                                    @endforeach
                                    @endif
                            {{-- @if(!empty($posts->upload->image))
                            <img src="{{ asset('storage/images/'.$posts->upload->image) }}" alt="" class=" img-fluid" id="myImage{{$posts->id}}">
                            @endif
                            @if(!empty($posts->upload->video))
                            <br><video width="100%" controls class=" img-fluid" id="myImage{{$posts->id}}"><source src="{{ asset('storage/videos/'.$posts->upload->video) }}"></video>
                            @endif --}}
                            <div class="ratingShareWrap">
                                <div class="rating ">
                                    <ul class="pl-0 mb-0 d-flex align-items-center">
                                        <li>
                                            <a href="#"><img src="{{asset('img/star.png')}}" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src={{asset("img/star.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src={{asset("img/star.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src={{asset("img/star.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src={{asset("img/star-grey.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <span>4.0(90)</span>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul class="pl-0 mb-0 d-flex">
                                        <li>
                                            <a href="#"><img src={{asset("img/instagram.png")}} alt=""></a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <img src={{asset("img/facebook.png")}} alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <span class="divider"></span>
                                        </li>
                                        <li>
                                            <a href="#">
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
                                                <div class="saveInfo infoHover reasonHover">
                                                    <div class="pos-rel">
                                                        <img src={{asset("img/tooltipArrowDown.png")}} alt="">
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
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->first_name)}} :</span> {{$comments->value}}
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
                                @foreach ($posts->comments as $comments)
                                <p class="comment ">
                                    <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->first_name)}} :</span> {{$comments->value}}
                                </p>
                                @endforeach
                            </div>
                            @endif
                            <div class="WriteComment">
                                <form role="form" method="POST" name="comment{{$posts->id}}" action="{{ route('comment') }}">
                                <input type="hidden" name="post_id" value="{{$posts->id}}">
                                <textarea placeholder="Write a comment.." name="comment"></textarea>
                                <!-- <button type="submit" id="next1" class="btn btn-info float-right">Submit</button> -->
                                </form>
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
                    <img src={{asset("img/add1.png")}} alt="" class="img-fluid">
                </div>
                <div class="adWrap">
                    <img src={{asset("img/add2.png")}} alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@include('layouts/models/upload_video_photo')
@endsection