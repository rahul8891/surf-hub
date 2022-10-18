
<div class="my-details-div">
    <div class="inner-my-details">
        <div class="my-profile text-center">
            <div class="profile-pic">
                <img src="img/profile-pic.png" alt="profile-pic">
                <span class="notification">6</span>
            </div>
            <div class="my-name">{{ ucwords(Auth::user()->user_profiles->first_name .' '.Auth::user()->user_profiles->last_name) }}</div>
            <div class="my-comp">Surfhub <span class="blue-txt">$2540</span> Earn</div>
        </div>
        <div class="profile-menu">
            <div class="profile-row">
                <img src="img/hub.png" alt="User">
                <!--<span>My Profile</span>-->
                <a href="{{ route('profile') }}">My Profile</a>
            </div>
            <div class="profile-row">
                <img src="img/followers.png" alt="Followers">
                <span>Followers - <a class="blue-txt num" id="follwers" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/following.png" alt="Following">
                <span>Following - <a class="blue-txt num" id="follwing" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/posts.png" alt="posts">
                <span>Posts - <a class="blue-txt num" id="posts" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/upload.png" alt="Uploads">
                <span>Uploads - <a class="blue-txt num" id="uploads" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/follow-request.png" alt="Follow Requests">
                <span>Follow Requests <a class="notification" id="followRequest" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/small-logo.png" alt="Surfer Requests">
                <span>Surfer Requests <a class="notification" id="surferRequest" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/notification.png" alt="Notifications" class="mr-2">
                <span>Notifications <a class="notification" id="notification" href="{{ route('profile') }}"></a></span>
            </div>
            <div class="profile-row">
                <img src="img/logout.png" alt="Sign Out" class="mr-2">
                <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"><span>Sign Out</span></a>
                </form>
            </div>
        </div>

    </div>
    <div class="left-advertisement">
        <img src="img/advertisement1.png" alt="advertisement">
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
                    $('#notification').html(jsonResponse['notification']);
//                setInterval(myTimerUserMessage, 4000);
            }
        });
    });
</script>