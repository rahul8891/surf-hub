@extends('layouts.user.new_layout')
@section('content')

<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.user.left_sidebar')

            <div class="middle-content">
                <div class="follow-wrap">
                    <div class="search-follower">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <label class="">Following <span class="blue-txt">{{ count($followRequests) }}</span></label>
                            </div>
                            <div class="col-sm-7">
                                <input type="text" id="searchFollowRequest" class="form-control ps-2 pe-5 mb-0"
                                       placeholder="Search followers">
                            </div>
                        </div>
                    </div>
                    <div class="list-followers">
                        @if (count($followRequests) > 0)
                        @foreach ($followRequests as $key => $requests)
                        <div class="row-listFollowers">
                            <div class="row align-items-center gap-2 gap-md-0">
                                <div class="col-md-6 follwer-name">
                                    @if($requests->follower->profile_photo_path)
                                    <img src="{{ asset('storage/'.$requests->follower->profile_photo_path) }}" alt=""
                                         class="align-middle bg-white">
                                    @else
                                    <img src="/img/follower-img.png" alt=""
                                         class="align-middle bg-white notification-img">
                                    @endif
                                    <span class="align-middle">{{ucfirst($requests->follower->user_profiles->first_name)}} {{ucfirst($requests->follower->user_profiles->last_name)}}</span>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <button class="btn grey-borderBtn me-3 accept" data-id="{{$requests->id}}">
                                        <img src="/img/accept.png" class="me-1 align-middle" alt="ACCEPT">
                                        <span class="align-middle">ACCEPT</span>
                                    </button>
                                    <button class="btn grey-borderBtn reject" data-id="{{$requests->id}}">
                                        <img src="img/reject.png" class="me-1 align-middle" alt="REJECT">
                                        <span class="align-middle">REJECT</span>
                                    </button>
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
                <img src="img/advertisement1.png" alt="advertisement">
                <img src="img/advertisement2.png" alt="advertisement">
            </div>
        </div>
    </div>
</section>


@endsection