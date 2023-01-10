@extends( Auth::user() && Auth::user()->user_type == 'ADMIN'  ?  'layouts.admin.admin_layout' : 'layouts.user.new_layout' )
@section('content')

<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.user.surfer_left_sidebar')
            <div class="middle-content">
                <div class="follow-wrap">
                    <div class="search-follower">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <label class="">Following <span class="blue-txt">{{ count($following) }}</span></label>
                            </div>
                            <div class="col-sm-7">
                                <input type="hidden" id="user_id" value="{{$userProfile['user_id']}}" >
                                <input type="text" id="searchFollowing" class="form-control ps-2 pe-5 mb-0"
                                       placeholder="Search followers">
                            </div>
                        </div>
                    </div>
                    <div class="list-followers">
                    @if (count($following) > 0)
                        @foreach ($following as $key => $followings)
                        <div class="row-listFollowers">
                            <div class="row align-items-center gap-2 gap-md-0">
                                <div class="col-md-6 follwer-name">
                                    @if($followings->follower->profile_photo_path)
                                    <img src="{{ asset('storage/'.$followings->followed->profile_photo_path) }}" alt=""
                                         class="align-middle bg-white">
                                    @else
                                    <img src="/img/follower-img.png" alt=""
                                         class="align-middle bg-white notification-img">
                                    @endif
                                    <span class="align-middle">{{ucfirst($followings->followed->user_profiles->first_name)}} {{ucfirst($followings->followed->user_profiles->last_name)}}</span>
                                </div>
                            </div>
                        </div>
                         @endforeach
                         @else
                    <div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">{{$common['NO_RECORDS']}}</div></div>
                    </div>
                @endif
                    </div>
                    
                </div>
            </div>
            <div class="right-advertisement">
                <img src="/img/advertisement1.png" alt="advertisement">
                <img src="/img/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>
@endsection