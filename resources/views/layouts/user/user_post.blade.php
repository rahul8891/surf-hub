<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/logo_small.png') }}">
    
    <meta property="og:locale" content="en_US" />
    <meta property="fb:app_id" content="911205526142894" />
    <meta property="og:type" content="post" />
    <meta property="og:description" content="{{ $postData->post_text }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:title" content="Surf Hub" />

    @if(!empty($postData->upload->image))
        <meta property="og:image" content="{{ url('/')."/storage/images/".$postData->upload->image }}" />
        <meta property="og:image:width" content="398" />
        <meta property="og:image:height" content="327" />
    @else@if(!empty($postData->upload->video))
        <meta property="og:video" content="{{ url('/')."/storage/fullVideos/".$postData->upload->video }}" />
        <meta property="og:video:width" content="398" />
        <meta property="og:video:height" content="327" />
    @endif

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('customarray.siteTitle.user') }}</title>
    
    <!-- <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet"> -->    
    
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/bootstrap.min.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/style.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
    <link rel="stylesheet" href="{{ asset("/css/croppie.css") }}" />
</head>

<body>

    <!-- Header -->

    @php
    $profileClass = (Auth::user() && Request::path() == 'user/profile') ? 'contactUsWrap profileWrap' : '';
    @endphp
    <main class="{{ $profileClass }}">
        <div class="loaderWrap">
            <div class="lds-hourglass"></div>
        </div>
        <!--<div id="loader"></div> -->
        @include('layouts/user/user_header')
        @include('layouts/user/user_banner')
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
        @include('layouts/user/user_footer')
    </footer>
    <script src="{{ asset("/js/jquery.min.js")}}"></script>
    <script src="{{ asset("/js/croppie.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"> </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5JiYXogWVNPfX_L4uA0oWb-qiNSfKfYk"
  type="text/javascript"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    <script src="{{ asset('/js/bootstrap.js') }}"></script>
    <script src="{{ asset("/js/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("/js/custom.js") }}"></script>
    @if (Auth::user())
    <script src="{{ asset("/js/post.js")}}"></script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    
    <script>

        $('.rating').rating({
            showClear:false, 
            showCaption:false
        });
        $(document).ready(function() {
            $("#My-Profile").click(function() {
                $(".profileChangePswd").toggleClass("show");
            });

            /* $(document).on('click.bs.dropdown.data-api', '.dropdown.keep-inside-clicks-open', function(e) {
                 e.stopPropagation();
             });*/

            $('.dropdown.keep-inside-clicks-open').on({
                "shown.bs.dropdown": function() {
                    this.closable = false;
                },
                "click": function() {
                    this.closable = false;
                },
                "hide.bs.dropdown": function() {
                    return this.closable;
                }
            });

            $(".nice-wrapper").niceScroll({
                cursorwidth: '10px',
                zindex: 999
            });

            $('#msg').delay(4000).fadeOut('slow');

            $('#msg').delay(4000).fadeOut('slow');


            $('.navbar-toggler-icon').click( function(event){
                event.stopPropagation();
                $('.navbar-collapse').toggle('fast');
            });

            $(document).click( function(){
                $('.navbar-collapse').slideUp('fast');
            });
        });

        function openFullscreen(id) {
            var elem = document.getElementById("myImage"+id);
            if (elem.requestFullScreen) {
              elem.requestFullScreen();
            } else if (elem.webkitRequestFullScreen) { /* Safari */
              elem.webkitRequestFullScreen();
            } else if (elem.mozRequestFullScreen) {
              elem.mozRequestFullScreen();
            } else if (elem.msRequestFullScreen) { /* IE11 */
              elem.msRequestFullScreen();
            }
        }    
    </script>
</body>
</html>