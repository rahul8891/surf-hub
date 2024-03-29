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
    <link href="{{ asset("/AdminLTE/plugins/fontawesome-free/css/all.min.css")}}" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset("/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet"
        href="{{ asset("/AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset("/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
    <!-- overlayScrollbars -->
    <link href="{{ asset("/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}" rel="stylesheet">
    <!-- Theme style -->
    <link href="{{ asset("/AdminLTE/dist/css/adminlte.min.css")}}" rel="stylesheet">
    <!-- Google Font: Source Sans Pro -->
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset("/AdminLTE/plugins/summernote/summernote-bs4.css")}}">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset("/css/loader.css")}}">
    <link rel="stylesheet" href="{{ asset("/css/croppie.css") }}" />
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    
    
    <!-- script -->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <div class="loaderWrap">
            <div class="lds-hourglass"></div>
        </div>
        <!-- Navbar -->
        @include('layouts/admin/master_header')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('layouts/admin/master_sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <!-- <h1 class="m-0 text-dark">Admin Dashboard</h1> -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="alert alert-dismissible" id="errorSuccessmsg" role="alert"></div>
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
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        @include('layouts/admin/master_footer')
    </div>
    <!-- ./wrapper -->
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset("/AdminLTE/plugins/jquery/jquery.min.js")}}"></script>

    <!-- ddslick -->
    <script type="text/javascript" src="https://cdn.rawgit.com/prashantchaudhary/ddslick/master/jquery.ddslick.min.js" ></script>
    <!-- Bootstrap -->
    <script src="{{ asset("/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset("/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
    <script src="{{ asset("/AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js")}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset("/AdminLTE/dist/js/adminlte.js")}}"></script>
    <!-- PAGE SCRIPTS 
    <script src="{{ asset("/AdminLTE/dist/js/pages/dashboard2.js")}}"></script>-->
    <script src="{{ asset("/AdminLTE/plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{ asset("/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}"></script>
    <script src="{{ asset("/AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}"></script>
    <script src="{{ asset("/AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}"></script>
    <!-- Ekko Lightbox -->
    <script src="{{ asset("/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js")}}"></script>
    <script src="{{ asset("/AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js")}}"></script>
    <!-- Summernote -->
    <script src="{{ asset("/AdminLTE/plugins/summernote/summernote-bs4.min.js")}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script src="{{ asset("/js/admin_custom.js")}}"></script>
    <script src="{{ asset("/js/croppie.js")}}"></script>
    <script src="{{ asset("/js/custom.js")}}"></script>
    <script src="{{ asset("/js/post.js")}}"></script>
    <script>
    $(document).ready(function() {

        // input browser file
        bsCustomFileInput.init();
        /*******************************************************************************
         *                   Image Show popup
         ********************************************************************************/
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
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
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });

        $('#msg').delay(4000).fadeOut('slow');

        // Summernote
        $('.textarea').summernote()


    });
    </script>
</body>

</html>