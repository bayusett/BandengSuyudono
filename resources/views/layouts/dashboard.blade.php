<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @stack('prepend-style')
    @include('includes.dashboard.style')
    @stack('addon-style')
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            @include('includes.dashboard.sidebar')

            <!-- Page Content -->
            <div id="page-content-wrapper">
                @include('includes.dashboard.navbar')

                <!-- content -->
                @yield('content')
            </div>
            <!-- /#page-content-wrapper -->
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    @include('includes.dashboard.script')
    @stack('addon-script')
</body>

</html>