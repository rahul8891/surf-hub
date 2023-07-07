@if((userActiveMenu('adminMyHub') == 'active') || (userActiveMenu('adminMyHub') == 'active'))
<div class="hub-top-option">
    <div class="left-option">
        <div class="post {{ ($post_type == 'posts')?'active':''  }}">
            <a href="{{ url('/admin/myhub', 'posts')}}">
                <img src="/img/new/post-white.png" alt="Post">
                <span>Posts</span>
            </a>
        </div>
        <div class="tag {{ ($post_type == 'tags')?'active':''  }}">
            <a href="{{ url('/admin/myhub', 'tags') }}">
                <img src="/img/new/tag-white.png" alt="Tagged">
                <span>Tagged</span>
            </a>
        </div>
        <div class="saved {{ ($post_type == 'saved')?'active':''  }}">
            <a href="{{ url('/admin/myhub', 'saved') }}">
                <img src="/img/new/save-white.png" alt="Saved">
                <span>Saved</span>
            </a>
        </div>
        <div class="Reel {{ ($post_type == 'reels')?'active':''  }}">
            <a href="{{ url('/admin/myhub', 'reels')}}">
                <img src="/img/new/reel-white.png" alt="reel">
                <span>Reel</span>
            </a>
        </div>
        <div class="all {{ ($post_type == 'all')?'active':''  }}">
            <a href="{{ url('/admin/myhub')}}">
                <img src="/img/new/all-white.png" alt="All">
                <span>All</span>
            </a>
        </div>

        @include('layouts.admin.admin_sort_filter')

    </div>
</div>
@else
@include('layouts.admin.admin_sort_filter')
@endif
