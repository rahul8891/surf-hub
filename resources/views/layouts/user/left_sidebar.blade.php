
<div class="my-details-div">
    <div class="inner-my-details">
        <div class="my-profile text-center">
            <div class="profile-pic">
            <div class="profile-pic" style="overflow:hidden;">
                @if(Auth::user()->profile_photo_path)
                <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}"
                    alt="profile-pic">
                @else
                <div class="">
                    {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}{{ucwords(substr(Auth::user()->user_profiles->last_name,0,1))}}
                </div>
                @endif
                
<!--                <img src="/img/profile-pic.png" alt="profile-pic">-->
            </div>
                <span class="notification">0</span>
            </div>
            <div class="my-name">{{ ucwords(Auth::user()->user_profiles->first_name .' '.Auth::user()->user_profiles->last_name) }}</div>
            <div class="my-comp">Surfhub <span class="blue-txt">$2540</span> Earn</div>
        </div>
        <div class="profile-menu">
            <div class="profile-row">
                <img src="/img/hub.png" alt="User">
                <!--<span>My Profile</span>-->
                <a href="{{ route('profile') }}">My Profile</a>
            </div>
            <div class="profile-row">
                <img src="/img/followers.png" alt="Followers">
                 <a class=""  href="{{ route('followers') }}">Followers - <span class="blue-txt num" id="follwers"> </span></a>
            </div>
            <div class="profile-row">
                <img src="/img/following.png" alt="Following">
                 <a class="" href="{{ route('following') }}">Following - <span class="blue-txt num" id="follwing"> </span></a>
            </div>
            <div class="profile-row">
                <img src="/img/posts.png" alt="posts">
                 <a class="" href="{{ route('profile') }}">Posts - <span class="blue-txt num" id="posts"> </span></a>
            </div>
            <div class="profile-row">
                <img src="/img/upload.png" alt="Uploads">
                 <a class="" href="{{ route('profile') }}">Uploads - <span class="blue-txt num" id="uploads"> </span></a>
            </div>
            <div class="profile-row">
                <img src="/img/follow-request.png" alt="Follow Requests">
                 <a class=""  href="{{ route('followRequests') }}">Follow Requests <span class="notification" id="followRequest"></span></a>
            </div>
            <div class="profile-row">
                <img src="/img/small-logo.png" alt="Surfer Requests">
                <a class="" href="{{ route('surferRequestList') }}">Surfer Requests <span class="notification" id="surferRequest"></span></a>
            </div>
            <div class="profile-row">
                <img src="/img/notification.png" alt="Notifications" class="mr-2">
                <a class="" href="{{ route('notifications') }}">Notifications <span class="notification" id="notification"></span></a>
            </div>
            <div class="profile-row">
                <form method="POST" action="{{ route('logout') }}">
                    
                    @csrf
                    <a href="#{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"><img src="/img/logout.png" alt="Sign Out" class="mr-2"><span>Sign Out</span></a>
                </form>
            </div>
        </div>

    </div>
    <div class="left-advertisement">
        <img src="/img/advertisement1.png" alt="advertisement">
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
                                    $(document).ready(function () {
                                        $.ajax({
                                            type: "GET",
                                            url: "/follow-counts",
                                            dataType: "json",
                                            success: function (jsonResponse) {
                                                $('#follwers').html(jsonResponse['follwers']);
                                                $('#follwing').html(jsonResponse['follwing']);
                                                $('#followRequest').html(jsonResponse['follwerRequest']);
                                                $('#posts').html(jsonResponse['posts']);
                                                $('#uploads').html(jsonResponse['uploads']);
                                                $('#surferRequest').html(jsonResponse['surferRequest']);
                                                $('.notification').html(jsonResponse['notification']);
//                setInterval(myTimerUserMessage, 4000);
                                            }
                                        });
                                    });
</script>