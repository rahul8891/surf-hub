@if((userActiveMenu('myhub') == 'active') || (userActiveMenu('myhubs') == 'active'))
<div class="hub-top-option">
    <div class="left-option">
        <div class="post">
            <img src="/img/new/post-white.png" class="align-middle" alt="Post">
            <a href="{{ url('/user/myhub', 'posts')}}"><span class="align-middle">Posts</span></a>
        </div>
        <div class="tag">
            <img src="/img/new/tag-white.png" class="align-middle" alt="Tagged">
            <a href="{{ url('/user/myhub', 'tags') }}"><span class="align-middle">Tagged</span></a>
        </div>
        <div class="saved">
            <img src="/img/new/save-white.png" class="align-middle" alt="Saved">
            <a href="{{ url('/user/myhub', 'saved') }}"><span class="align-middle">Saved</span></a>
        </div>
        <div class="Reel">
            <img src="/img/new/reel-white.png" class="align-middle" alt="reel">
            <a href="{{ url('/user/myhub', 'reels')}}"><span class="align-middle">Reel</span></a>
        </div>
        <div class="Reel">
            <img src="/img/new/all-white.png" class="align-middle" alt="All">
            <a href="{{ url('/user/myhub', 'all')}}"><span class="align-middle">All</span></a>
        </div>

        @include('layouts.user.sort_filter')

    </div>
</div>
@else
@include('layouts.user.sort_filter')
@endif
