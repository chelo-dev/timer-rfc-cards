<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GRC | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="..." name="description" />
    <meta content="Angel Paredes Torres" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- third party css -->
    <link href="{{ asset('assets/css/vendor/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- Datatables css -->
    <link href="{{ asset('assets/css/vendor/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/vendor/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('assets/css/app-modern-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" id="custom" />
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet" type="text/css" id="loader" />

    <!-- VueJs -->
    {{-- <link href="{{ mix('/css/app.css') }}" rel="stylesheet"> --}}

    @yield('css')

</head>

<body class="loading" data-layout="topnav">
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Nav Bar -->
                @include('layouts.includes-sections-master.nav-bar')

                <!-- Top Bar -->
                @include('layouts.includes-sections-master.top-bar')

                <!-- Start Content-->
                <div class="container-fluid">

                    @yield('container')

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer -->
            @include('layouts.includes-sections-master.footer')

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- bundle -->
    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    
    <!-- Datatables js -->
    <script src="{{ asset('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendor/responsive.bootstrap4.min.js') }}"></script>


    <!-- third party js -->
    {{-- <script src="{{ asset('assets/js/vendor/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/vendor/jquery-jvectormap-1.2.2.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/js/vendor/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
    <!-- third party js ends -->

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
    <!-- end -->

    {{-- Funcion global para realizar peticiones --}}
    <script src="{{ asset('js/http_request.js') }}"></script>

    <!-- demo app -->
    {{-- <script src="{{ asset('assets/js/pages/demo.dashboard.js') }}"></script> --}}
    <!-- end demo js-->

    <!-- VueJs -->
    <script src="{{ mix('/js/app.js') }}"></script>

    @yield('js')
</body>

</html>