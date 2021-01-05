@extends('layouts.user.user')
@section('content')
@include('layouts/user/follow_menu')
<section class="followRequestMainWrap">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                @if (count($following) > 0)
                <div class="requests" id="allFollower">
                    @foreach ($following as $key => $followings)
                    <div class="" id="row-id{{$followings->id}}">
                        <div class="userInfo">
                            @if($followings->followed->profile_photo_path)
                            <div class="imgWrap">
                                <img src="{{ asset('storage/'.$followings->followed->profile_photo_path) }}" class="profileImg" alt="">
                            </div>
                            @else
                            <div class="imgWrap no-img">
                                {{ucwords(substr($followings->followed->user_profiles->first_name,0,1))}}{{ucwords(substr($followings->followed->user_profiles->last_name,0,1))}}
                            </div>
                            @endif
                            <div class="pl-3">
                                <h4>{{ucfirst($followings->followed->user_profiles->first_name)}} {{ucfirst($followings->followed->user_profiles->last_name)}}</h4>
                            </div>
                        </div>
                        <button class="acceptBtn unfollow ml-auto" data-id="{{$followings->id}}">UNFOLLOW</button>
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