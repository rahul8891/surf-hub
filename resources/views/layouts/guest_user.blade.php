<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo_small.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('customarray.siteTitle.user') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/style.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/media.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
    <link rel="stylesheet" href="{{ asset("/css/croppie.css") }}" />
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet">
    </link>
</head>

<body class="login-body">
    <header>
        <nav class="navbar navbar-expand p-0">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"><img src="img/logo.png" alt="Logo"></a>
                <div class="navbar-nav middle-menu">
                    <a class="nav-link" href="/"><img src="{{ asset("/img/home.png")}}" alt="Feed" class="align-middle"> <span class="align-middle">FEED</span></a>
                    <a class="nav-link" href="/search"><img src="{{ asset("/img/search.png")}}" alt="Search" class="align-middle"> <span class="align-middle">SEARCH</span></a>
                </div>
                <div class="side-navbar">
                    <div class="navbar-nav">
                        <a class="nav-link" href="/register">Signup</a>
                        <a class="nav-link" href="/login">Login</a>
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/contact-us">Contact Us</a></li>
                                <li><a class="dropdown-item" href="/privacy-policy">Privacy Policy</a></li>
                                <li><a class="dropdown-item" href="terms-and-conditions">T&C`s</a></li>
                                <li><a class="dropdown-item" href="/help-faq">Help/FAQ's</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="pt-0">
         <div id="loader"></div>
        <div class="loaderWrap">
            <div class="lds-hourglass"></div>
        </div>
        @yield('content')
    </main>
    <footer>
        @include('layouts/user/user_footer')
    </footer>
    <script src="{{ asset("/js/jquery.min.js")}}"></script>
    <script src="{{ asset("/js/croppie.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="{{ asset("/js/bootstrap.js")}}"></script>
    <script src="{{ asset("/js/jquery.validate.min.js")}}"></script>
    <script src="{{ asset("/js/custom.js")}}"></script>
    <script src="{{ asset("/js/bootstrap.bundle.min.js")}}"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
</body>

</html>
