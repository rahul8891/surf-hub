@extends('layouts.user.new_layout')
@section('content')

<section class="home-section">
    <div class="container">
        <div class="home-row">
            @include('layouts.user.left_sidebar')
            <div class="middle-content">
                <div class="notification-wrap">
                    <div class="notification-header">
                        <h2>Notification</h2>
                        <button type="button" class="btn-default btnClearNotification" onclick="updateAllNotification()">Clear All</button>
                    </div>
                    <div class="notification-body">
                        @if(count(FollowNotification::instance()->getPostNotifications()) > 0)
                            @foreach (FollowNotification::instance()->getPostNotifications() as $key => $requests)
                                <div class="notification-list">
                                    <div class="row align-items-center gap-2 gap-md-0">
                                        <div class="col-md-6 follwer-name">
                                            @if($requests['image'])
                                            <img src="{{ asset('storage/'.$requests['image']) }}" alt=""
                                                class="align-middle bg-white">
                                            @else
                                            <img src="/img/follower-img.png" alt=""
                                                class="align-middle bg-white notification-img">
                                            @endif
                                            <div class="d-inline-block align-middle">
                                                @if($requests['notification_type'] == 'Post')
                                                    <a href="{{ route('surfer-request', ['post', Crypt::encrypt($requests['sender_id']), $requests['post_id']]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        Added a new {{$requests['post_type']}}
                                                    </a>
                                                @endif
                                                @if($requests['notification_type'] == 'Comment')
                                                    <a href="{{ route('surfer-request', ['comment', Crypt::encrypt($requests['sender_id']), $requests['post_id']]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        is commented on your {{$requests['post_type']}}
                                                    </a>
                                                @endif
                                                @if($requests['notification_type'] == 'Follow')
                                                    <a href="{{ route('surfer-request', ['follow', Crypt::encrypt($requests['sender_id'])]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        sent you a follow request
                                                    </a>
                                                @endif
                                                @if($requests['notification_type'] == 'Accept')
                                                    <a href="{{ route('surfer-request', ['accept', Crypt::encrypt($requests['sender_id'])]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        accept your following request
                                                    </a>
                                                @endif
                                                @if($requests['notification_type'] == 'Reject')
                                                    <a href="{{ route('surfer-request', ['reject', Crypt::encrypt($requests['sender_id'])]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        reject your following request </a>
                                                @endif
                                                @if($requests['notification_type'] == 'Tag')
                                                    <a href="{{ route('surfer-request', ['tag', Crypt::encrypt($requests['sender_id']), $requests['post_id']]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        tagged you on a post
                                                    </a>
                                                @endif
                                                @if($requests['notification_type'] == 'Surfer Request')
                                                    <a href="{{ route('surfer-request', ['surfer-request', Crypt::encrypt($requests['sender_id'])]) }}" class="mb-0" onclick="updateNotificationCount({{ $requests['notification_id'] }})">
                                                        <span class="blue-txt">{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}</span>
                                                        surfer has nominated himself the post.
                                                    </a>
                                                @endif
                                                <p class="time mb-0">{{ postedDateTime($requests['created_at']) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
<script>
    function updateNotificationCount(id) {
        $.ajax({
            type: "POST",
            url: "updateNotificationCount",
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    $('.followCountHead').hide();
                }
            }
        });

        return false;
    }

    function updateAllNotification() {
        $.ajax({
            type: "GET",
            url: "/user/updateAllNotification",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: "json",
            success: function (jsonResponse) {
                if (jsonResponse.status == "success") {
                    $('.followCountHead').hide();
                }
            }
        });

        location.reload(true);
    }
</script>
@endsection
