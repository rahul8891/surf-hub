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
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}">
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
    <link rel="stylesheet" href="{{ asset("/css/croppie.css") }}" />
    <!-- <link rel="stylesheet" href="{{ asset("/css/select2.css") }}" /> -->
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> -->

    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet">
    </link>


</head>

<body>
    <main class="pt-0 bg-blue">
        <!-- <div id="loader"></div> -->
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script src="{{ asset("/js/custom.js")}}"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>

    <!-- <script src="{{ asset("/js/select2.js")}}"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
    <script>
    // $('#local_beach_break_id').select2({
    //     placeholder: 'Select a month',
    //     selectOnClose: true,
    // });
    /*$('.local_beach_break_id').select2({
        closeOnSelect: true,
    });

    $('.language').select2({
        closeOnSelect: true,
    });

    $('.accountType').select2({
        closeOnSelect: true,
    });

    $('.local_beach_break').select2({
        closeOnSelect: true,
    });*/
    </script>
</body>

</html>