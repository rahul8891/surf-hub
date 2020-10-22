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
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/owl.carousel.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/owl.theme.default.min.css")}}">
</head>

<body>
    <main class="pt-0 bg-blue">
        <div id="loader"></div>
        @yield('content')
    </main>
    <footer>
        @include('layouts/user/user_footer')
    </footer>
    <script src="{{ asset("/js/jquery.min.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="{{ asset("/js/bootstrap.js")}}"></script>
    <script src="{{ asset("/js/custom.js")}}"></script>
</body>

</html>