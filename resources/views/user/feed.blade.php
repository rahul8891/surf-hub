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
                                        @if(!empty($posts->upload->image))
                        <img src="{{ env('FILE_CLOUD_PATH').'images/'.$posts->user->id.'/'.$posts->upload->image }}" alt="Feed" class="w-100" id="myImage{{$posts->id}}">
                        @elseif(!empty($posts->upload->video))
                        @if (!File::exists($posts->upload->video))
                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>
                        @else
                        <video width="100%" preload="auto" data-setup="{}" controls autoplay playsinline muted class="video-js" id="myImage{{$posts->id}}">
                            <source src="{{ env('FILE_CLOUD_PATH').'videos/'.$posts->user->id.'/'.$posts->upload->video }}" >    
                        </video>
                        @endif
                        @endif
                                        <div class="user-bottom-options">
                                                <div class="rating">
                                                        <img src="/img/new/blue-star.png" alt="start" class="align-text-bottom">
                                                         <span>{{ round(floatval($posts->averageRating)) }} </span>
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
                                                        <a onclick="openFullscreen({{$posts->id}});"><img src={{asset("img/expand.png")}} alt="Expand"></a>
                                                        <a href="#"><img src="/img/new/warning.png" alt="Warning"></a>
                                                        <a href="#"><img src="/img/new/tag.png" alt="Tag"></a>
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