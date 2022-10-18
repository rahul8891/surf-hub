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
	<link rel="stylesheet" type="text/css" href="{{ asset('css/new/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/new/media.css') }}">
	<script src="{{ asset('js/new/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('js/new/bootstrap.bundle.min.js') }}"></script>
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
    <script src="{{ asset("js/jquery.min.js")}}"></script>
    <script src="{{ asset("js/croppie.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"> </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5JiYXogWVNPfX_L4uA0oWb-qiNSfKfYk"
  type="text/javascript"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
    <script src="{{ asset('/js/bootstrap.js') }}"></script>
    <script src="{{ asset("js/jquery.validate.min.js") }}"></script>
    <script src="{{ asset("js/custom.js") }}"></script>
    @if (Auth::user())
    <script src="{{ asset("js/post.js")}}"></script>
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
                elem.webkitEnterFullscreen();
                elem.enterFullscreen();
            } else if (elem.webkitRequestFullScreen) { /* Safari */
                elem.webkitRequestFullScreen();
                elem.webkitEnterFullscreen();
                elem.enterFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
                elem.enterFullscreen();
            } else if (elem.msRequestFullScreen) { /* IE11 */
                elem.msRequestFullScreen();
                elem.enterFullscreen();
            }
        }    
    </script>
</body>

</html>