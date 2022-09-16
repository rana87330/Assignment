<!doctype html >
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
        <title>Assignment (Computan)</title>
        @include('layouts.head')
    </head>
    <body> 
    @show
        <!-- Begin page -->
        <div class="container-scroller">
            @include('layouts.sidebar')
            <div class="container-fluid page-body-wrapper">
                @include('layouts.topbar')
                <!-- ============================================================== -->
                <!-- Start right Content here -->
                <!-- ============================================================== -->
                <div class="main-panel">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                    <!-- End Page-content -->
                    @include('layouts.footer')
                </div>
                <!-- end main content-->
            </div>
        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        @include('layouts.vendor-scripts')

    </body>
</html>
