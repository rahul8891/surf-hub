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
    <link rel="stylesheet" type="text/css" href="{{ asset("/css/responsive.css")}}">
</head>

<body>
    <!-- Header -->
    @include('layouts/user/user_header')
    <main class="contactUsWrap">
        <div id="loader"></div>
        <!-- Page Content -->
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
    <script src="{{ asset("/js/jquery.validate.min.js")}}"></script>
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

        // no space allow in text box
        $.validator.addMethod(
            "noSpace",
            function (value, element) {
                return value == "" || value.trim().length != 0;
            },
            "No space please and don't leave it empty"
        );

        // valid email format
        $.validator.addMethod(
            "validEmailFormat",
            function (email) {
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                return testEmail.test(email);
            },
            "Please enter valid email with valid format"
        );
        //contact us
        $("form[name='contact_us']").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 5,
                    noSpace: true
                },

                email: {
                    required: true,
                    email: true,
                    validEmailFormat: true
                },

                subject: {
                    required: true,
                    minlength: 5,
                    noSpace: true
                },

                description: {
                    required: true
                }
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio")) {
                    error.insertAfter(element.parent().parent());
                } else {
                    // This is the default behavior of the script for all fields
                    error.insertAfter(element);
                }
            },
            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Your name must be at least 5 characters long."
                },

                email: {
                    required: "Please enter your email",
                    email: "Please enter valid email address"
                },

                subject: {
                    required: "Please enter your subject",
                    minlength: "Subject must be at least 5 characters long."
                },

                description: {
                    required: "Please enter your description"
                }
            },
            submitHandler: function (form) {
                form.submit();
                spinner.show();
            }
        });

    });
    </script>
</body>

</html>