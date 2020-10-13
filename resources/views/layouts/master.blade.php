<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | Dashboard 2</title>

  <!-- Font Awesome Icons -->
  <link  href="{{ asset("/AdminLTE/plugins/fontawesome-free/css/all.min.css")}}" rel="stylesheet" >
  <!-- overlayScrollbars -->
  <link  href="{{ asset("/AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}" rel="stylesheet" >
  <!-- Theme style -->
  <link  href="{{ asset("/AdminLTE/dist/css/adminlte.min.css")}}" rel="stylesheet" >
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('layouts/master_sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard v2</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!-- Main Footer -->
  @include('layouts/master_footer')
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset("/AdminLTE/plugins/jquery/jquery.min.js")}}"></script>
<!-- Bootstrap -->
<script src="{{ asset("/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset("/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset("/AdminLTE/dist/js/adminlte.js")}}"></script>
<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>
<!-- ChartJS -->
<script src="{{ asset("/AdminLTE/plugins/chart.js/Chart.min.js")}}"></script>
<!-- PAGE SCRIPTS -->
<script src="{{ asset("/AdminLTE/dist/js/pages/dashboard2.js")}}"></script>
</body>
</html>
