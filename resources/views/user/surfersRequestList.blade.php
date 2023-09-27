@extends('layouts.user.new_layout')
@section('content')

<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.user.left_sidebar')
            <div class="middle-content">
                <div class="surfer-wrap">
                    <div class="surfer-header">
                        <h2>Surfer Requests <span class="blue-txt">{{count($surferRequest)}}</span></h2>
                    </div>
                    <div class="surfer-body">
                        @if (count($surferRequest) > 0)
                        @foreach ($surferRequest as $key => $val)
                        <div class="surfer-request">
                            <div class="row align-items-center gap-2 gap-xl-0">
                                <div class="col-xl-6">
                                    @if(!empty($val->user->profile_photo_path))
                                    <img src="{{ asset('storage/'.$val->user->profile_photo_path) }}" alt=""
                                         class="align-middle bg-white notification-img">
                                    @else
                                    <img src="/img/follower-img.png" alt=""
                                         class="align-middle bg-white notification-img">
                                    @endif

                                    <div class="d-inline-block align-middle">
                                        <p class="name mb-0">{{$val->first_name.' '.$val->last_name }}</p>
                                        <p class="time mb-0">{{ postedDateTime($val->created_at) }}</p>
                                    </div>
                                </div>
                                <div class="col-xl-6 text-xl-end">
                                    <a class="btn grey-borderBtn me-3 review" href="{{ route('surferFollowRequest', [Crypt::encrypt($val->post_id)]) }}" >
                                        <img src="/img/review.png" class="me-1 align-middle" alt="REVIEW">
                                        <span class="align-middle">REVIEW</span>
                                    </a>
                                    <a class="btn grey-borderBtn me-3 accept" href="{{ route('acceptRejectRequest', [Crypt::encrypt($val->id),'accept']) }}">
                                        <img src="/img/accept.png" class="me-1 align-middle" alt="ACCEPT">
                                        <span class="align-middle">ACCEPT</span>
                                    </a>
                                    <a class="btn grey-borderBtn reject" href="{{ route('acceptRejectRequest', [Crypt::encrypt($val->id),'reject']) }}">
                                        <img src="/img/reject.png" class="me-1 align-middle" alt="REJECT">
                                        <span class="align-middle">REJECT</span>
                                    </a>
                                    <!-- <a class="btn grey-borderBtn me-3 accept" href="{{ route('acceptRejectRequest', [Crypt::encrypt($val->receiver_id),'accept']) }}">
                                        <img src="/img/accept.png" class="me-1 align-middle" alt="ACCEPT">
                                        <span class="align-middle">ACCEPT</span>
                                    </a>
                                    <a class="btn grey-borderBtn reject" href="{{ route('acceptRejectRequest', [Crypt::encrypt($val->receiver_id),'reject']) }}">
                                        <img src="/img/reject.png" class="me-1 align-middle" alt="REJECT">
                                        <span class="align-middle">REJECT</span>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="requests"><div class=""><div class="userInfo mt-2 mb-2 text-center">No record found!</div></div>
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
