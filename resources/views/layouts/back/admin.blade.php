<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- App script -->
    <script src="{{ asset('js/all.js') }}"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    @stack('scripts')

    <!-- Theme style -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/fancyform.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        @include('layouts.back.partials.admin-navbar')

        @include('layouts.back.partials.admin-side-navbar')



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('layouts.back.partials.admin-breadcrumb')

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2020 {{ config('app.name') }}.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> {{ config('app.version') }}
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->
@include('layouts.back.alerts.sweetalerts')
</body>

</html>
