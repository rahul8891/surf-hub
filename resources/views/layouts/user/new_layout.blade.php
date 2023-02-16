<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('customarray.siteTitle.user') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&display=swap"
              rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/new/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/new/croppie.css') }}" />
        <link rel="stylesheet" href="{{ asset('/css/new/star-rating.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('/css/new/slick.css') }}" />
        <link rel="stylesheet" href="{{ asset('/css/new/slick-theme.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/new/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/new/media.css') }}">	
        

    </head>

    <body class="login-body">
        <header>
            @include('layouts/header')
        </header>

        <main>
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" id="msg" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                @foreach ($errors->all() as $error)
                <li>{{ ucfirst($error) }}</li>
                @endforeach
            </div>
            @endif
            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible" role="alert" id="msg">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ ucfirst($message) }}
            </div>
            @elseif ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert" id="msg">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                {{ ucfirst($message) }}
            </div>
            @endif

            @yield('content')
        </main>
        <footer>
            @include('layouts/user/footer')
        </footer>

        
    </body>

</html>