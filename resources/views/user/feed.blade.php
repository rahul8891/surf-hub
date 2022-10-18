@extends('layouts.user.new_layout')
@section('content')
<section class="home-section">
    <div class="container">
        <div class="home-row">
            <div class="my-details-div">
                @include('layouts.user.left_sidebar')
            </div>
                <div class="middle-content">
                    @include('layouts.user.content_menu')
                    
                        <div class="news-feed">
                             @if (!empty($postsList))
                                @foreach ($postsList as $key => $posts)
                                <div class="inner-news-feed">
                                        <div class="user-details">
                                                <div class="user-left">
                                                        @if(file_exists(asset('storage/'.$posts->user->profile_photo_path)))
                                                            <img src="{{ asset('storage/'.$posts->user->profile_photo_path) }}" class="profileImg" alt="">
                                                        @else
                                                            <img src="/img/logo_small.png" class="profileImg" alt="">
                                                        @endif
                                                        <div>                                                            
                                                            <p class="name"><span>{{ ucfirst($posts->user->user_profiles->first_name) }} {{ ucfirst($posts->user->user_profiles->last_name) }} ( {{ (isset($posts->user->user_name) && !empty($posts->user->user_name))?ucfirst($posts->user->user_name):"SurfHub" }} )</span> </p>
                                                            <p class="address">{{ $posts->beach_breaks->beach_name ?? '' }} {{ $posts->beach_breaks->break_name ?? '' }}, {{\Carbon\Carbon::parse($posts->surf_start_date)->format('d-m-Y') }}</p>
                                                            <p class="time-ago">{{ postedDateTime($posts->created_at) }}</p> 
                                                        </div>
                                                </div>
                                                @if($posts->user_id != Auth::user()->id)
                                                <div class="user-right"> 
                                                        <img src="/img/new/normal-user.png" alt="normal-user">
                                                        <a href="{{ route('login') }}" class="follow-btn"><img src="/img/new/follow-user.png">FOLLOW</a>
                                                </div>
                                                @endif
                                        </div>
                                        <img src="/img/new/feed-big-img.png" alt="Feed" class="w-100">
                                        <div class="user-bottom-options">
                                                <div class="rating">
                                                        <img src="/img/new/blue-star.png" alt="start" class="align-text-bottom">
                                                        <span>3/5</span>
                                                </div>
                                                <div class="right-options">
                                                        <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}"><img src="/img/new/save.png" alt="Save"></a>
<!--                                                        <a href="{{route('saveToMyHub', Crypt::encrypt($posts->id))}}" class="">
                                                <div class="saveInfo">
                                                    <div class="pos-rel">
                                                        <img src="img/new/save.png" alt="">
                                                        Save this photo/video to your personal MyHub library
                                                    </div>
                                                </div>
                                            </a>-->
                                                        <a href="{{route('surferRequest', Crypt::encrypt($posts->id))}}"><img src="/img/new/small-logo.png" alt="Logo"></a>
                                                        <a href="#" data-toggle="modal" data-target="#beachLocationModal" data-lat="{{$posts->beach_breaks->latitude ?? ''}}" data-long="{{$posts->beach_breaks->longitude ?? ''}}" data-id="{{$posts->id}}" class="locationMap">
                                <img src={{asset("img/location.png")}} alt="Location"></a>
                                                        <a onclick="openFullscreen({{ $posts->id }});" ><img src="/img/new/expand.png" alt="Expand"></a>
                                                        <a href="#"><img src="/img/new/warning.png" alt="Warning"></a>
                                                        <!--<a href="#"><img src="/img/new/tag.png" alt="Tag"></a>-->
                                                         
                                                    @if (count($posts->tags) >= 1)
                                                    <div class="modal" id="postTag{{$posts->id}}">
                                                      <div class="modal-dialog">
                                                        <div class="modal-content">

                                                          <!-- Modal Header -->
                                                          <div class="modal-header">
                                                            <h4 class="modal-title">Tagged Users</h4>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                          </div>

                                                          <!-- Modal body -->
                                                          <div class="modal-body">
                                                            @foreach ($posts->tags as $tags)
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
                                                    <!-- <a data-toggle="modal" data-target="#postTag{{$posts->id}}">TAG -->
                                                    <a href="javascript:void(0)">
                                                        <img src="/img/new/tag.png" alt="Tag">
                                                        <div class="saveInfo infoHover userinfoModal">
                                                            <div class="pos-rel">
                                                                <img src="../../../img/tooltipArrowDown.png" alt="">
                                                                <div class="scrollWrap">
                                                                    @foreach ($posts->tags->reverse() as $tags)
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
                                                                            <input type="text" autofocus value="{{ old('tag_user')}}" name="tag_user"
                                                                                placeholder="@ Search user" class="form-control tag_user" required data-post_id="{{$posts->id}}">
                                                                                <input type="hidden" value="{{ old('user_id')}}" name="user_id"
                                                                                id="user_id" class="form-control user_id">
                                                                            <div class="auto-search tagSearch" id="tag_user_list{{$posts->id}}"></div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            
                                                        </div>
                                                        
                                                    </a>
                                                
                                                        <a href="#"><img src="/img/new/flag.png" alt="Flag"></a>
                                                </div>
                                        </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                </div>
                <div class="right-advertisement">
                        <img src="/img/new/advertisement1.png" alt="advertisement">
                        <img src="/img/new/advertisement2.png" alt="advertisement">
                </div>
        </div>
    </div>
</section>
@include('elements/location_popup_model')

@endsection