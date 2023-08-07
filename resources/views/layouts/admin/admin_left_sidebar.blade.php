
<div class="my-details-div">
    <div class="inner-my-details">
        <div class="my-profile text-center">
            <div class="profile-pic">
                @if(Auth::user()->profile_photo_path)
                <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}"
                    alt="" class="rounded-circle">
                @else
                <div class="">
                    {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}{{ucwords(substr(Auth::user()->user_profiles->last_name,0,1))}}
                </div>
                @endif
                <span class="notification">0</span>
            </div>
            <div class="my-name">{{ ucwords(Auth::user()->user_profiles->first_name .' '.Auth::user()->user_profiles->last_name) }}</div>
            <div class="my-comp">Surfhub <span class="blue-txt">$2540</span> Earn</div>
        </div>
        <div class="profile-menu">
            <div class="profile-row {{ ((userActiveMenu('myhubs') == 'active') && ($post_type == 'posts'))?'active':'' }}">
                <img src="/img/posts.png" alt="posts">
                 <a class="" href="{{ route('myhubs', 'posts') }}">Posts - <span class="blue-txt num" id="posts"> </span></a>
            </div>
            <div class="profile-row {{ userActiveMenu('upload') }}">
                <img src="/img/upload.png" alt="Uploads">
                 <a class="" href="{{ route('profile') }}">Uploads - <span class="blue-txt num" id="uploads"> </span></a>
            </div>
            <div class="profile-row {{ userActiveMenu('followRequests') }}">
                <img src="/img/comments.png" alt="Comments">
                 <a class=""  href="{{ route('followRequests') }}">Comments <span class="notification" id="comments"></span></a>
            </div>
            <div class="profile-row {{ userActiveMenu('surferRequestList') }}">
                <img src="/img/small-logo.png" alt="Surfer Requests">
                <a class="" href="{{ route('surferRequestList') }}">Surfer Requests <span class="notification" id="surferRequest"></span></a>
            </div>
            <div class="profile-row {{ userActiveMenu('reportIndex') }}">
                <img src="/img/flag.png" alt="Reports">
                <a class="" href="{{ route('reportIndex') }}">Reports <span class="notification" id="reports"></span></a>
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
    </div>
</div>
<script>
                                    $(document).ready(function () {
                                        $.ajax({
                                            type: "GET",
                                            url: "/admin/left-side-counts",
                                            dataType: "json",
                                            success: function (jsonResponse) {
                                                $('#reports').html(jsonResponse['reports']);
                                                $('#posts').html(jsonResponse['posts']);
                                                $('#uploads').html(jsonResponse['uploads']);
                                                $('#surferRequest').html(jsonResponse['surferRequest']);
                                                $('#comments').html(jsonResponse['comments']);
                                            }
                                        });
                                    });
</script>
