@php
$borderBtm = Auth::user() ? 'border-btm ' : '';
@endphp
<header class="{{ $borderBtm }}">
    <nav class="navbar navbar-expand-lg navbar-light bg-light container-1660">
        @auth
        <a class="navbar-brand" href="{{ url('/dashboard')}}"><img src="{{ asset("/img/logo.png")}}" alt=""></a>
        @else
        <a class="navbar-brand" href="{{ url('/')}}"><img src="{{ asset("/img/logo.png")}}" alt=""></a>
        @endif
        @auth
        <ul class="tab-dis-block">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <div class="userImg no-image">EN <span class="followCount">14</span></div>Upender
                    <span class="followCount">14</span>
                </a>
                <div class="dropdown-menu notificationWrap" aria-labelledby="navbarDropdown">
                    <h3>Notifications</h3>
                    <div class="setHeight nice-wrapper">
                        <a class="dropdown-item" href="#">
                            <div class="noti">
                                <div class="imgWrap no-img">
                                    EN
                                </div>
                                <div class="info">
                                    <p><span>Upender</span> Added a new photo </p>
                                    <p>10 min ago</p>
                                </div>
                            </div>
                        </a>
                        <a class="dropdown-item" href="#">
                            <div class="noti">
                                <div class="imgWrap ">
                                    <img src="{{ asset("/img/johan.png")}}" class="img-fluid" alt="">
                                </div>
                                <div class="info">
                                    <p><span>Upender</span> Added a new photo </p>
                                    <p>10 min ago</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </li>
        </ul>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="m-auto d-flex align-items-center">
                <a href="#">Search</a>
                <span>Search here for video and photos from any surf break around the world!!</span>
            </div>
            @auth
            <ul class="navbar-nav ml-auto tab-dis-none">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="userImg " id="head">
                            @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" class="img-fluid image"
                                alt="">
                            @else
                            <div class="imgWrap no-img">
                                {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}{{ucwords(substr(Auth::user()->user_profiles->last_name,0,1))}}
                            </div>
                            @endif
                            @if(getPostNotificationsCount() > 0)
                            <span class="followCountHead" id="followRequestCountHead">{{ getPostNotificationsCount() }}</span>
                            @endif
                        </div>
                        {{ucfirst(Auth::user()->user_profiles->first_name)}} {{ucfirst(Auth::user()->user_profiles->last_name)}}
                    </a>
                    @if(count(getPostNotifications()) > 0)
                    <div class="dropdown-menu notificationWrap" aria-labelledby="navbarDropdown">
                        <h3>Notifications</h3>
                        <div class="setHeight nice-wrapper">
                            @foreach (getPostNotifications() as $key => $requests)
                            @if($requests['notification_type'] == 'Follow')
                            <a class="dropdown-item" href="{{ route('followRequests')}}">
                            @elseif($requests['notification_type'] == 'Accept')
                            <a class="dropdown-item" href="{{ route('following')}}">
                            @elseif($requests['notification_type'] == 'Reject')
                            <a class="dropdown-item" href="{{ route('following')}}">
                            @else
                            <a class="dropdown-item" href="{{ route('posts',['post_id'=>$requests['post_id'],'notification_id'=>$requests['notification_id'],'notification_type'=>$requests['notification_type']])}}">
                            @endif
                                <div class="noti">
                                    @if($requests['image'])
                                    <div class="imgWrap ">
                                        <img src="{{ asset('storage/'.$requests['image']) }}" class="img-fluid" alt="">
                                    </div>
                                    @else
                                    <div class="imgWrap no-img">
                                        {{ucwords(substr($requests['first_name'],0,1))}}{{ucwords(substr($requests['last_name'],0,1))}}
                                    </div>
                                    @endif
                                    <div class="info">
                                        <p><span>{{ucfirst($requests['first_name'])}} {{ucfirst($requests['last_name'])}}
                                        @if($requests['notification_type'] == 'Post')
                                        </span> Added a new {{$requests['post_type']}} </p>
                                        @endif
                                        @if($requests['notification_type'] == 'Comment')
                                        </span> is commented on your {{$requests['post_type']}} </p>
                                        @endif
                                        @if($requests['notification_type'] == 'Follow')
                                        </span> sent you a follow request </p>
                                        @endif
                                        @if($requests['notification_type'] == 'Accept')
                                        </span> accept your following request </p>
                                        @endif
                                        @if($requests['notification_type'] == 'Reject')
                                        </span> reject your following request </p>
                                        @endif
                                        @if($requests['notification_type'] == 'Tag')
                                        </span> tagged you on a post </p>
                                        @endif
                                        <p>{{ postedDateTime($requests['created_at']) }}</p>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </li>
            </ul>
            @else
            <ul class="navbar-nav ml-auto">
                <li class="nav-item ">
                    <a class="nav-link auth-btn" href="{{ route('login') }}">Login </a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link auth-btn" href="{{ route('register') }}">Signup</a>
                </li>
                @endif
            </ul>
            @endif
        </div>
    </nav>
</header>