@if(userActiveMenu('myhub') == 'active')
<div class="hub-top-option">
    <div class="left-option">
        <div class="post">
            <img src="/img/new/post-white.png" alt="Post">
            <a href="{{ url('dashboard')}}"><span>Posts</span></a>
        </div>
        <div class="tag">
            <img src="/img/new/tag-white.png" alt="Tagged">
            <a href="{{ url('myhub') }}"><span>Tagged</span></a>
        </div>
        <div class="saved">
            <img src="/img/new/save-white.png" alt="Saved">
            <a href="{{ url('myhub') }}"><span>Saved</span></a>
        </div>
        <div class="Reel">
            <img src="/img/new/reel-white.png" alt="reel">
            <a href="{{ url('dashboard')}}"><span>Reel</span></a>
        </div>
        <div class="Reel">
            <img src="/img/new/all-white.png" alt="All">
            <span><a href="{{ url('dashboard')}}">All</a></span>
        </div>
        <div class="sort">
            <img src="/img/new/sort.png" alt="filter">
            <span>Sort</span>
        </div>
        <div class="filter">
            <img src="/img/new/filter.png" alt="filter">
            <span>Filter</span>
        </div>
    </div>
</div>
@else
<div class="filter-sort">
    <div class="sort">
        <img src="/img/new/sort.png" alt="filter">
        <span>Sort</span>
    </div>
    <div class="filter">
        <img src="/img/new/filter.png" alt="filter">
        <span>Filter</span>
    </div>
</div>
@endif
    