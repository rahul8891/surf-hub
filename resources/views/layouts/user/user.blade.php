<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo_small.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('customarray.siteTitle.user') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/fontawesome.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/style.css")}}">
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/owl.carousel.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/owl.theme.default.min.css")}}">
</head>

<body>
    <!-- Header -->
    @include('layouts/user/user_header')
    <main>
        <div id="loader"></div>
        <!-- user banner -->
        @include('layouts/user/user_banner')
        <!-- Page Content -->
        <!-- Loggedin user feed -->
        @include('layouts/user/user_feed_menu')
        @yield('content')
    </main>
    <footer>
        @include('layouts/user/user_footer')
    </footer>


    <script src="{{ asset("/js/jquery.min.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"> </script>
    <script src="{{ asset("/js/bootstrap.js")}}"></script>
    <script>
    $(document).ready(function() {
        $(" #My-Profile").click(function() {
            $(".profileChangePswd").toggleClass("show");
        });
        $(".nice-wrapper").niceScroll({
            cursorwidth: '10px',
            zindex: 999
        });
    });
    </script>
    < /body>

</html>