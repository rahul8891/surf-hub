<nav class="navbar navbar-expand p-0">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"><img src="/img/logo.png" alt="Logo"></a>
        <div class="navbar-nav middle-menu" style="<?php echo!Auth::user() ? 'width:400px !important;margin-right:220px;' : '' ?>">
            <div class="{{ userActiveMenu('dashboard') }}">
                <a class="nav-link" href="/">
                    <span class="header-icon feed"></span>
                    <span class="align-middle">FEED</span>
                </a>
            </div>
            @if (Auth::user())
            <div class="{{ userActiveMenu('myhub') }}">
                <a class="nav-link" href="{{ route('myhub') }}">
                    <span class="header-icon my-hub"></span>
                    <span class="align-middle">MY HUB</span>
                </a>
            </div>
            @endif
            <div class="{{ userActiveMenu('searchPosts') }}">
                <a class="nav-link" href="{{route('searchPosts')}}">
                    <span class="header-icon search"></span>
                    <span class="align-middle">SEARCH</span>
                </a>
            </div>
            @if (Auth::user() && Auth::user()->user_type == 'ADVERTISEMENT')
            <div class="{{ userActiveMenu('myAds') }}">
                <a class="nav-link" href="{{route('myAds')}}">
                    <span class="header-icon upload"></span>
                    <span class="align-middle">My Ads</span>
                </a>
            </div>
            @endif
            @if (Auth::user() && Auth::user()->user_type == 'ADVERTISEMENT')
            <div class="{{ userActiveMenu('uploadAdvertisment') }}">
                <a class="nav-link" href="{{route('uploadAdvertisment')}}">
                    <span class="header-icon upload"></span>
                    <span class="align-middle">UPLOAD</span>
                </a>
            </div>
            @else
            <div class="{{ userActiveMenu('upload') }}">
                <a class="nav-link" href="{{route('upload')}}">
                    <span class="header-icon upload"></span>
                    <span class="align-middle">UPLOAD</span>
                </a>
            </div>
            @endif
        </div>

        <div class="side-navbar">
            <div class="navbar-nav">
                @if(!Auth::user())
                <a class="nav-link" href="/register">Signup</a>
                <a class="nav-link" href="/login">Login</a>
                @endif
                <div class="dropdown">
                    <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/contact-us">Contact Us</a></li>
                        <li><a class="dropdown-item" href="/privacy-policy">Privacy Policy</a></li>
                        <li><a class="dropdown-item" href="terms-and-conditions">T&C's</a></li>
                        <li><a class="dropdown-item" href="/help-faqs">Help/FAQ's</a></li>
                        @if(Auth::user() && empty(SpotifyUserAuth::instance()->getSpotifyUser()))
                        <li><a class="dropdown-item" href="{{route('spotify-auth')}}">Spotify Login</a></li>
                        @endif
                    </ul>

                </div>
                @if(Auth::user())
                    <div class="left-navbar-toggler">
                        <div class="d-block d-lg-none profile-pic">
                            @if(isset(Auth::user()->profile_photo_path) && !empty(Auth::user()->profile_photo_path))
                            <img src="{{ asset('storage/'.Auth::user()->profile_photo_path) }}" class="rounded-circle">
                            @else
                            <div class="">
                                {{ucwords(substr(Auth::user()->user_profiles->first_name,0,1))}}{{ucwords(substr(Auth::user()->user_profiles->last_name,0,1))}}
                            </div>
                            @endif
                            <span class="notification notification-count">0</span>
                        </div>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</nav>
