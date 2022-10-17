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
                                                        <a href="#"><img src="/img/new/save.png" alt="Save"></a>
                                                        <a href="#"><img src="/img/new/small-logo.png" alt="Logo"></a>
                                                        <a href="#"><img src="/img/new/location.png" alt="Location"></a>
                                                        <a href="#"><img src="/img/new/expand.png" alt="Expand"></a>
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

@endsection