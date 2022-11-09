@if((userActiveMenu('myhub') == 'active') || (userActiveMenu('myhubs') == 'active'))
<div class="hub-top-option">
    <div class="left-option">
        <div class="post">
            <a href="{{ url('/user/myhub', 'posts')}}">
                <img src="/img/new/post-white.png" class="align-middle" alt="Post">
                <span class="align-middle">Posts</span>
            </a>
        </div>
        <div class="tag">
            <a href="{{ url('/user/myhub', 'tags') }}">
                <img src="/img/new/tag-white.png" class="align-middle" alt="Tagged">
                <span class="align-middle">Tagged</span>
            </a>
        </div>
        <div class="saved">
            <a href="{{ url('/user/myhub', 'saved') }}">
                <img src="/img/new/save-white.png" class="align-middle" alt="Saved">
                <span class="align-middle">Saved</span>
            </a>
        </div>
        <div class="Reel">
            <a href="{{ url('/user/myhub', 'reels')}}">
                <img src="/img/new/reel-white.png" class="align-middle" alt="reel">
                <span class="align-middle">Reel</span>
            </a>
        </div>
        <div class="Reel">
            <a href="{{ url('/user/myhub', 'all')}}">
                <img src="/img/new/all-white.png" class="align-middle" alt="All">
                <span class="align-middle">All</span>
            </a>
        </div>

        @include('layouts.user.sort_filter')

    </div>
</div>
@else
@include('layouts.user.sort_filter')
@endif