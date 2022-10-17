<div class="inner-my-details">
        <div class="my-profile text-center">
                <div class="profile-pic">
                        <img src="/img/new/profile-pic.png" alt="profile-pic">
                        <span class="notification">6</span>
                </div>
                <div class="my-name">{{ Auth::user()->user_profiles['first_name'] }} {{ Auth::user()->user_profiles['last_name'] }}</div>
                <div class="my-comp">{{ Auth::user()->user_name }} <span class="blue-txt">$0</span> Earn</div>
        </div>
        <div class="profile-menu">
                <div class="profile-row">
                        <img src="/img/new/hub.png" alt="User">
                        <span><a href="{{ route('profile') }}">My Profile</a></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/followers.png" alt="Followers">
                        <span>Followers - <span class="blue-txt num">0</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/following.png" alt="Following">
                        <span>Following - <span class="blue-txt num">0</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/posts.png" alt="posts">
                        <span>Posts - <span class="blue-txt num">0</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/upload.png" alt="Uploads">
                        <span>Uploads - <span class="blue-txt num">0</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/follow-request.png" alt="Follow Requests">
                        <span><a href="{{ route('followRequests') }}">Follow Requests</a> - <span class="notification">{{ (FollowNotification::instance()->getNotificationCount() > 0)?FollowNotification::instance()->getNotificationCount():0 }}</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/small-logo.png" alt="Surfer Requests">
                        <span>Surfer Requests - <span class="notification">6</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/notification.png" alt="Notifications" class="mr-2">
                        <span>Notifications - <span class="notification">6</span></span>
                </div>
                <div class="profile-row">
                        <img src="/img/new/logout.png" alt="Sign Out" class="mr-2">
                        <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="#{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();"><span>Sign Out</span></a>
                        </form>
                </div>
        </div>
</div>

<div class="left-advertisement">
        <img src="/img/new/advertisement1.png" alt="advertisement">
</div>