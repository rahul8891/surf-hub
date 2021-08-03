@extends('layouts.user.user')
@section('content')
@include('layouts/user/user_feed_menu')

<style>
    .imageWrap {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .imageWrap .overlay {   
        position: absolute;
        right: 0;
        z-index: 5;
        background-color: lightgrey;
        border-radius: 5px; 
    }
</style>

<section class="postsWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 pos-rel" id="myhub-data">
                
                <div class="post">
                    <div class="inner">
                        <div class="post-head">
                            <div class="userDetail">
                                @if($postData->user->profile_photo_path)
                                <img src="{{ asset('storage/'.$postData->user->profile_photo_path) }}" class="profileImg" alt="">
                                @else
                                <div class="profileImg no-image">
                                    {{ucwords(substr($postData->user->user_profiles->first_name,0,1))}}{{ucwords(substr($postData->user->user_profiles->last_name,0,1))}}
                                </div>
                                @endif
                                <div class="pl-3">
                                    <h4>{{ucfirst($postData->user->user_profiles->first_name)}} {{ucfirst($postData->user->user_profiles->last_name)}}</h4>
                                    <span>{{ $postData->beach_breaks->beach_name ?? '' }}, {{\Carbon\Carbon::parse($postData->surf_start_date)->format('d-m-Y')}}</span><br>
                                    <span>{{ postedDateTime($postData->surf_start_date) }}</span>
                                </div>
                            </div>                            
                        </div>
                        <p class=" description">{{$postData->post_text}}</p>
                                <div class="imgRatingWrap">
                                    @if(!empty($postData->upload->image))
                                    @php 
                                        $type = 'image';
                                        $file = $postData->upload->image;
                                    @phpend
                                    <div class="pos-rel editBtnWrap">
                                            <img src="{{ asset('storage/images/'.$postData->upload->image) }}" alt="" width="100%" class="img-fluid" id="myImage{{$postData->id}}">
                                    </div>
                                    @endif
                                    @if(!empty($postData->upload->video))
                                    @php 
                                        $type = 'video';
                                        $file = $postData->upload->video;
                                    @phpend
                                    <br>
                                    <div class="pos-rel editBtnWrap">
                                        <video width="100%" preload="auto" data-setup="{}" controls class="video-js" id="myImage{{$postData->id}} video-js">
                                            <source src="{{ asset('storage/fullVideos/'.$postData->upload->video) }}" >    
                                        </video>
                                        
                                    </div>
                                    @endif

                                    <div class="ratingShareWrap">
                                        <ul class="pl-0 mb-0 d-flex align-items-center">
                                            <li>
                                                <input id="rating{{$postData->id}}" name="rating" class="rating rating-loading" data-id="{{$postData->id}}"
                                                data-min="0" data-max="5" data-step="1" data-size="xs" value="{{$postData->userAverageRating}}">   
                                            </li>
                                            <li class="ratingCount">
                                                <span id="average-rating{{$postData->id}}">{{intval($postData->averageRating)}}</span>
                                                (<span id="users-rated{{$postData->id}}">{{intval($postData->usersRated())}}</span>)
                                                
                                            </li>
                                        </ul>
                                        <div>
                                            <ul class="pl-0 mb-0 d-flex">
                                                <li>
                                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}"><img src="{{ asset("/img/facebook.png")}}" alt=""></a>         
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$postData->beach_breaks->latitude ?? ''}}" data-long="{{$postData->beach_breaks->longitude ?? ''}}" data-id="{{$postData->id}}" class="locationMap">
                                                        <img src="{{ asset("/img/maps-and-flags.png")}}" alt="">
                                                    </a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li>
                                                    <a onclick="openFullscreen({{$postData->id}});"><img src="{{ asset("/img/full_screen.png")}}"
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
                                                                        {{date('d-m-Y',strtotime($postData->surf_start_date))}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Surfer
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$postData->surfer}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Username
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{ucfirst($postData->user->user_profiles->first_name)}} {{ucfirst($postData->user->user_profiles->last_name)}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Beach/Break
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{ $postData->beach_breaks->beach_name ?? '' }}/{{ $postData->beach_breaks->break_name ?? '' }}
                                                                    </div> 
                                                                    <div class="col-5">
                                                                        Country
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$postData->countries->name}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        State
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$postData->states->name??""}}
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Wave Size
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        @foreach($customArray['wave_size'] as $key => $value)
                                                                            @if($key == $postData->wave_size)
                                                                                {{$value}}
                                                                            @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-5">
                                                                        Board Type
                                                                    </div>
                                                                    <div class="col-2 text-center">:</div>
                                                                    <div class="col-5">
                                                                        {{$postData->board_type}}
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
                                                    <a href="{{route('deleteUserPost', Crypt::encrypt($postData->id))}}"  onclick="return confirm('Do you really want to delete this footage?')">DELETE</a>
                                                </li>
                                                <li>
                                                    <span class="divider"></span>
                                                </li>
                                                <li class="pos-rel">
                                                    @if (count($postData->tags) >= 1)
                                                    <div class="modal" id="postTag{{$postData->id}}">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">

                                                          <!-- Modal Header -->
                                                          <div class="modal-header">
                                                            <h4 class="modal-title">Tagged Users</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          </div>

                                                          <!-- Modal body -->
                                                          <div class="modal-body">
                                                            @foreach ($postData->tags as $tags)
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
                                                    <!-- <a data-toggle="modal" data-target="#postTag{{$postData->id}}">TAG -->
                                                    <a href="javascript:void(0)">TAG
                                                        
                                                        <div class="saveInfo infoHover userinfoModal">
                                                            <div class="pos-rel">
                                                                <img src="../../../img/tooltipArrowDown.png" alt="">
                                                                <div class="scrollWrap">
                                                                    @foreach ($postData->tags->reverse() as $tags)
                                                                    <div class="post-head">
                                                                        <div class="userDetail">
                                                                            <div class="imgWrap">
                                                                            @if($tags->user->profile_photo_path)
                                                                                <img src="{{ asset('storage/'.$tags->user->profile_photo_path) }}" class="taggedUserImg" alt="">
                                                                                
                                                                            @else
                                                                                <div class="taggedUserImg no-image">
                                                                                    {{ucwords(substr($tags->user->user_profiles->first_name,0,1))}}{{ucwords(substr($tags->user->user_profiles->last_name,0,1))}}
                                                                                </div>
                                                                            @endif
                                                                            </div>
                                                                            <span class="userName">{{ucfirst($tags->user->user_profiles->first_name)}} {{ucfirst($tags->user->user_profiles->last_name)}}</span>                                                                         
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-12 col-sm-4" id="tagUser">
                                                                    <div class="selectWrap pos-rel">
                                                                        <div class="selectWrap pos-rel">
                                                                            <input type="text" value="{{ old('tag_user')}}" name="tag_user"
                                                                                placeholder="@ Search user" class="form-control tag_user" required data-post_id="{{$postData->id}}">
                                                                                <input type="hidden" value="{{ old('user_id')}}" name="user_id"
                                                                                id="user_id" class="form-control user_id">
                                                                            <div class="auto-search tagSearch" id="tag_user_list{{$postData->id}}"></div>
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
                                    @if (count($postData->comments) > 0)
                                    <div class="viewAllComments">
                                        @if (count($postData->comments) > 5)
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
                                                @foreach ($postData->comments as $comments)
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
                                        @foreach ($postData->comments->slice(0, 5) as $comments)
                                        <p class="comment ">
                                            <span>{{ucfirst($comments->user->user_profiles->first_name)}} {{ucfirst($comments->user->user_profiles->last_name)}} :</span> {{$comments->value}}
                                        </p>
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="WriteComment">
                                        <form role="form" method="POST" name="comment{{$postData->id}}" action="{{ route('comment') }}">
                                        @csrf
                                        <input type="hidden" class="postID" name="post_id" value="{{$postData->id}}">
                                        <input type="hidden" name="parent_user_id" value="{{$postData->user_id}}">
                                        <textarea placeholder="Write a comment.." name="comment" class="commentOnPost" id="{{$postData->id}}" style="outline: none;"></textarea>
                                        <button type="submit" class="btn btn-info postComment" id="submitPost{{$postData->id}}">Submit</button>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    
                    
                    
                    <div class=""></div>
                    
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

<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://vjs.zencdn.net/7.11.4/video.min.js"></script>
<script type="text/javascript">
	
</script>
@endsection
