<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>{{ config('app.name', 'Title') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
    @section('section_stylesheet')
        @includeIf('partials.main_stylesheet', array())
    @show
    @section('section_script_main')
        @includeIf('partials.main_script', array())
    @show
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  @section('main_header')
    @includeIf('partials.main_header', array())
  @show
  <!-- ./main-header -->
    
  <!-- Left side column. contains the logo and sidebar -->
    @section('left_side_column')
        @includeIf('partials.left_side_column', array())
    @show
  <!-- ./left-side-column. contains the logo and sidebar -->

  @section('content_wrapper')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @section('content_header')
    @show
    <!-- ./Content Header (Page header) -->
    <!-- Main content -->
    <section class="content container-fluid" id="container_fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        @yield('content')
        <!--------------------------
        | Your Page Content Here |
        -------------------------->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @show

  <!-- Main Footer -->
  @section('main_footer')
    @includeIf('partials.main_footer', array())
  @show
  <!-- ./main-footer -->

  <!-- Control Sidebar -->
  @section('control_sidebar')
  <!-- aside class="control-sidebar control-sidebar-dark">
  </aside -->
  @show
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
@section('section_script')
    <script src="{{ asset('node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>
@show
    
@if (notify()->ready())
    <script>
        swal({
            title: "{!! notify()->message() !!}",
            text: "{!! notify()->option('text') !!}",
            type: "{{ notify()->type() }}",
            @if (notify()->option('timer'))
                timer: {{ notify()->option('timer') }},
                showConfirmButton: false
            @endif
        });
    </script>
@endif
<!-- REQUIRED JS SCRIPTS -->


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>