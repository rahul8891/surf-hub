
    
        <nav class="navbar navbar-expand p-0">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="/img/logo.png" alt="Logo"></a>
                <div class="navbar-nav middle-menu" style="<?php echo !Auth::user()?'width:250px !important;margin-right:220px;':'' ?>">
                    <a class="nav-link" href="/dashboard"><img src="{{ asset("/img/home.png")}}" alt="Feed" class="align-middle"> <span class="align-middle">FEED</span></a>
                    @if(Auth::user()) 
                    <a class="nav-link" href="{{ route('myhub') }}"><img src="{{ asset("/img/hub.png")}}" alt="Hub" class="align-middle"> <span class="align-middle">MY HUB</span></a>
                    @endif
                    <a class="nav-link" href="/search"><img src="{{ asset("/img/search.png")}}" alt="Search" class="align-middle"> <span class="align-middle">SEARCH</span></a>
                   @if(Auth::user()) 
                    <a class="nav-link" href="/upload"><img src="{{ asset("/img/upload.png")}}" alt="Upload" class="align-middle"> <span class="align-middle">UPLOAD</span></a>
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
                                <li><a class="dropdown-item" href="{{route('spotify-auth')}}">Spotify Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    
