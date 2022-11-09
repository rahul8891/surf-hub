@if((userActiveMenu('myhub') == 'active') || (userActiveMenu('myhubs') == 'active'))
<div class="hub-top-option">
    <div class="left-option">
        <div class="post">
            <img src="/img/new/post-white.png" alt="Post">
            <a href="{{ url('/user/myhub', 'posts')}}"><span>Posts</span></a>
        </div>
        <div class="tag">
            <img src="/img/new/tag-white.png" alt="Tagged">
            <a href="{{ url('/user/myhub', 'tags') }}"><span>Tagged</span></a>
        </div>
        <div class="saved">
            <img src="/img/new/save-white.png" alt="Saved">
            <a href="{{ url('/user/myhub', 'saved') }}"><span>Saved</span></a>
        </div>
        <div class="Reel">
            <img src="/img/new/reel-white.png" alt="reel">
            <a href="{{ url('/user/myhub', 'reels')}}"><span>Reel</span></a>
        </div>
        <div class="Reel">
            <img src="/img/new/all-white.png" alt="All">
            <span><a href="{{ url('/user/myhub', 'all')}}">All</a></span>
        </div>

        @include('layouts.user.sort_filter')

    </div>
</div>
@else
@include('layouts.user.sort_filter')
@endif
