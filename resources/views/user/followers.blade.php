@extends('layouts.user.user')
@section('content')
@include('layouts/user/follow_menu')
<section class="followRequestMainWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @if (count($followers) > 0)
                <div class="requests" id="allFollower">
                    @foreach ($followers as $key => $follower)
                    <div class="" id="row-id{{$follower->id}}">
                        <div class="userInfo">
                            @if($follower->follower->profile_photo_path)
                            <div class="imgWrap">
                                <img src="{{ asset('storage/'.$follower->follower->profile_photo_path) }}" class="profileImg" alt="">
                            </div>
                            @else
                            <div class="imgWrap no-img">
                                {{ucwords(substr($follower->follower->user_profiles->first_name,0,1))}}{{ucwords(substr($follower->follower->user_profiles->last_name,0,1))}}
                            </div>
                            @endif
                            <div class="pl-3">
                                <h4>{{ucfirst($follower->follower->user_profiles->first_name)}} {{ucfirst($follower->follower->user_profiles->last_name)}}</h4>
                            </div>
                        </div>
                        <button class="rejectBtn remove mr-3 ml-auto" data-id="{{$follower->id}}">REMOVE</button>
                        <button class="acceptBtn follow" data-id="{{$follower->follower_user_id}}">FOLLOW</button>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="requests"><div class=""><div class="userInfo">{{$common['NO_RECORDS']}}</div></div>
                </div>
                @endif
                <div class="requests" id="followCount"><div class=""><div class="followCount">{{$common['NO_RECORDS']}}</div></div></div>
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
@endsection