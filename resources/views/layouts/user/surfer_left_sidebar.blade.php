<style>
 .follow-btn.clicked {
    background: #325CFD !important;
    color: #fff;
    border: #fff;

}
</style>
<div class="my-details-div">
    <div class="inner-my-details">
        <div class="my-profile text-center">
            <div class="profile-pic">
                @if($userProfile['profile_photo_path'])
                <img src="{{ asset('storage/'.$userProfile['profile_photo_path']) }}"
                     alt="" class="rounded-circle">
                @else
                <div class="">
                    {{ucwords(substr($userProfile['surfer_name'],0,1))}}
                </div>
                @endif
                <span class="notification">0</span>
            </div>
            <div class="my-name">{{ ucwords($userProfile['surfer_name']) }}</div>
            <div class="my-comp">Surfhub <span class="blue-txt">$2540</span> Earn</div>
            @foreach ($postsList as $key => $posts)
            <button class="mx-0 greyBorder-btn mt-2 follow-btn follow <?php echo (isset($posts->followPost->id) && !empty($posts->followPost->id)) ? ((($posts->followPost->status == 'FOLLOW') && ($posts->followPost->follower_request_status == '0')) ? 'clicked' : 'clicked Follow') : 'followPost' ?>" data-id="{{ $posts->user_id }}" data-post_id="{{ $posts->id }}">
            <span class="follow-icon"></span> FOLLOW
            </button>
            @break
            @endforeach
        </div>
        <div class="profile-menu">
            <div class="profile-row {{ userActiveMenu('followers') }}">
                <img src="/img/followers.png" alt="Followers">
                <a class=""  href="{{ route('surferFollowers', Crypt::encrypt($userProfile['user_id'])) }}">Followers - <span class="blue-txt num" id="follwers">{{$fCounts['follwers']}} </span></a>
            </div>
            <div class="profile-row {{ userActiveMenu('following') }}">
                <img src="/img/following.png" alt="Following">
                <a class="" href="{{ route('surferFollowing', Crypt::encrypt($userProfile['user_id'])) }}">Following - <span class="blue-txt num" id="follwing"> {{$fCounts['follwing']}}</span></a>
            </div>
            <div class="profile-row {{ ((userActiveMenu('myhubs') == 'active') && ($post_type == 'posts'))?'active':'' }}">
                <img src="/img/posts.png" alt="posts">
                <a class="" href="{{ route('myhubs', 'posts') }}">Posts - <span class="blue-txt num" id="posts"> {{$fCounts['posts']}}</span></a>
            </div>
            <div class="profile-row {{ userActiveMenu('upload') }}">
                <img src="/img/upload.png" alt="Uploads">
                <a class="" href="{{ route('profile') }}">Uploads - <span class="blue-txt num" id="uploads">{{$fCounts['uploads']}} </span></a>
            </div>
        </div>

    </div>
    <div class="profile-left-nav">
        <div class="profile-menu text-center mt-0">
            <div class="profile-row pt-0">
                <label class="d-block">Gender</label>
                <span class="darkGrey-txt">{{ $userProfile['gender'] }}</span>
            </div>
            <div class="profile-row">
                <label class="d-block">DOB</label>
                <span class="darkGrey-txt">{{ $userProfile['dob'] }}</span>
            </div>
            <div class="profile-row pt-0">
                <label class="d-block">Email</label>
                <span class="darkGrey-txt">{{ $userProfile['email'] }}</span>
            </div>
            <div class="profile-row">
                <label class="d-block">Phone Number</label>
                <span class="darkGrey-txt">{{ $userProfile['phone'] }} </span>
            </div>
            <div class="profile-row pt-0">
                <label class="d-block">Postal Code</label>
                <span class="darkGrey-txt">{{ $userProfile['postal_code'] }}</span>
            </div>
            <div class="profile-row">
                <label class="d-block">Local Beach</label>
                <span class="darkGrey-txt">{{ $userProfile['beach_break'] }} </span>
            </div>
            <div class="profile-row pt-0">
                <label class="d-block">Preferred Board</label>
                <span class="darkGrey-txt">{{ $userProfile['preferred_board'] }}</span>
            </div>
            <div class="profile-row">
                <label class="d-block">Country</label>
                <span class="darkGrey-txt">{{ $userProfile['country'] }} </span>
            </div>
<!--            <div class="text-center">
                <a href="#" class="mx-0 w-150 greyBorder-btn mt-2">CONNECT</a>
            </div>
            <div class="text-center">
                <a href="#" class="mx-0 w-150 greyBorder-btn mt-2">BLOCK</a>
            </div>
            <div class="text-center">
                <a href="#" class="mx-0 w-150 greyBorder-btn mt-2">DELETE</a>
            </div>-->
        </div>
    </div>
</div>