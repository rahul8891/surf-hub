<nav class="navbar navbar-expand p-0">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="/"><img src="/img/new/logo.png" alt="Logo"></a>
        <div class="navbar-nav middle-menu">
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
            @if (Auth::user())
            <div class="">
                <a class="nav-link" href="#">
                    <span class="header-icon upload"></span>
                    <span class="align-middle">UPLOAD</span>
                </a>
            </div>
            @endif
        </div>
        <div class="side-navbar">
            <div class="navbar-nav">
                @if (!Auth::user())
                    <a class="nav-link" href="{{ route('register') }}">Signup</a>
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                @endif
                <div class="dropdown">
                    <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a class="dropdown-item" href="{{ route('privacy') }}">Privacy Policy</a></li>
                        <li><a class="dropdown-item" href="{{ route('terms') }}">T&C's</a></li>
                        <li><a class="dropdown-item" href="{{ route('faq') }}">Help/FAQ's</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>