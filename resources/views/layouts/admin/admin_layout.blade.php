<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('customarray.siteTitle.admin') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/logo_small.png') }}">
        <!-- Font Awesome Icons -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/new/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset("/css/new/croppie.css") }}" />
        <link rel="stylesheet" href="{{ asset("/css/new/star-rating.min.css") }}" />
        <link rel="stylesheet" href="{{ asset("/css/new/slick.css") }}" />
        <link rel="stylesheet" href="{{ asset("/css/new/slick-theme.css") }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/new/style.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/new/media.css') }}">	
        <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}">
        <!-- script -->

        <script src="{{ asset('js/new/jquery-3.5.1.min.js') }}"></script>
        <script src="{{ asset('js/new/bootstrap.bundle.min.js') }}"></script>
        <link href="https://vjs.zencdn.net/5.19.2/video-js.css" rel="stylesheet">
        <style>
            .video-js {
                width: 100%;
                height: 100%;
            }
        </style>
    </head>

    <body class="login-body">
        <header>
            @include('layouts/admin/master_header_new')
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
            @include('layouts/admin/master_footer_new')
        </footer>
        <!-- ./wrapper -->
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        
        <script src="{{ asset("js/new/croppie.js")}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.5.1/jquery.nicescroll.min.js"></script>
        <!-- ddslick -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5JiYXogWVNPfX_L4uA0oWb-qiNSfKfYk"
        type="text/javascript"></script>
        <script src="https://vjs.zencdn.net/5.19.2/video.js"></script>
        <script src="{{ asset('/js/hls/hls.min.js?v=v0.9.1') }}"></script>
        <script src="{{ asset('/js/hls/videojs5-hlsjs-source-handler.min.js?v=0.3.1') }}"></script>
        <script src="{{ asset('/js/hls/vjs-quality-picker.js?v=v0.0.2') }}"></script>
        
        <!-- Bootstrap -->
        <script src="{{ asset('/js/new/bootstrap.js') }}"></script>
        <script src="{{ asset("js/new/jquery.validate.min.js") }}"></script>
        <script src="{{ asset("/js/new/admin_custom.js")}}"></script>
        <script src="{{ asset("js/new/post.js")}}"></script>
        <script src="{{ asset("js/new/script.js")}}"></script>
        <script src="{{ asset("js/new/star-rating.min.js")}}"></script>    
        <script src="{{ asset("js/new/slick.js")}}"></script>
        
        <script>
            
            window.HELP_IMPROVE_VIDEOJS = false;
            
            //$( ".video-js" ).each(function( i ) {
            $( ".hls-video-player" ).each(function( i ) {
                var videoID = $(this).attr('data-id');
                var video = $(this).attr('data-src');
                console.log("Data = myVideoTag"+videoID+"  --  "+video);
                var options = {};


                videojs('myVideoTag'+videoID).ready(function () {
                    var myPlayer = this;
                    myPlayer.qualityPickerPlugin();
                    myPlayer.src({
                        type: 'application/x-mpegURL', 
                        src: video
                    });
                });
            });
            $( ".jw-video-player" ).each(function( i ) {
                var videoID = $(this).attr('data-id');
                var video = $(this).attr('data-src');
                console.log("Data = myVideoTag"+videoID+"  --  "+video);
                var options = {};


                videojs('myVideoTag'+videoID).ready(function () {
                    var myPlayer = this;
                    myPlayer.qualityPickerPlugin();
                    myPlayer.src({
//                        type: 'application/x-mpegURL', 
                        src: video
                    });
                });
            });
            
        </script>
        <script>
    $(document).ready(function () {

        // input browser file
//        bsCustomFileInput.init();
        /*******************************************************************************
         *                   Image Show popup
         ********************************************************************************/
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

        /*******************************************************************************
         *                   Data Table 
         ********************************************************************************/
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
            "ordering": true,
        });

        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $('#example3').DataTable({
            'processing': true,
            'paging': false,
            'searching': true,
            "bInfo": false,
            "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
        })

        /*********************************************************************
         *         Bootstrap Switch box
         **********************************************************************/
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('#msg').delay(4000).fadeOut('slow');

        // Summernote
        $('.textarea').summernote();


    });
        </script>
    </body>

</html>