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
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}"> -->
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
</head>

<body>
    <!-- Header -->
    @include('layouts/user/user_header')
    <main>
        <div id="loader"></div>
        @include('layouts/user/user_banner')
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible" id="error" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            @foreach ($errors->all() as $error)
            <li>{{ ucfirst($error) }}</li>
            @endforeach
        </div>
        @endif
        @yield('content')
    </main>
    <footer>
        @include('layouts/user/user_footer')
    </footer>
    <script src="{{ asset("/js/jquery.min.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"> </script>
    <script src="{{ asset("/js/bootstrap.js")}}"></script>
    @if (Auth::user() && Request::path() == 'dashboard')
    <script src="{{ asset("/js/post.js")}}"></script>
    @endif
    <script>
    $(document).ready(function() {
        $(" #My-Profile").click(function() {
            $(".profileChangePswd").toggleClass("show");
        });
        $(".nice-wrapper").niceScroll({
            cursorwidth: '10px',
            zindex: 999
        });

        $('#error').delay(4000).fadeOut('slow');

    });
    </script>
</body>

</html>