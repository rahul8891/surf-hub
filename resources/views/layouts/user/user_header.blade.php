<header class="border-btm">
    <nav class="navbar navbar-expand-lg navbar-light bg-light container-1660">
        @auth
        <a class="navbar-brand" href="{{ url('/dashboard')}}"><img src="{{ asset("/img/logo.png")}}" alt=""></a>
        @else
        <a class="navbar-brand" href="{{ url('/')}}"><img src="{{ asset("/img/logo.png")}}" alt=""></a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="m-auto d-flex align-items-center">
                <a href="#">Search</a>
                <span>Search here for videos and photos from any surf break around the world!!</span>
            </div>
            <ul class="navbar-nav ml-auto tab-dis-none">
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="userImg ">
                            @if(Auth::user()->profile_photo_path)
                            <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" class="img-fluid image"
                                alt="">
                            @else
                            <div class="imgWrap no-img">
                                {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}
                            </div>
                            @endif
                            <span class="followCount">14</span>
                        </div>
                        {{ucwords(Auth::user()->user_profiles->first_name)}}
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
                @else
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route('login') }}">Login </a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Signup</a>
                </li>
                @endif
                @endif
            </ul>
        </div>
    </nav>
</header>