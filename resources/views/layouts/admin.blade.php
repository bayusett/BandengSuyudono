<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @include('includes.admin.style')
    @stack('addon-style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
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
        @if (Auth::user()->roles=='ADMIN')
        @include('includes.admin.sidebar')
        @else
        @include('includes.pemilik.sidebar')
        @endif
        @yield('content')
        @include('includes.admin.footer')
    </div>
    <!-- ./wrapper -->

    @stack('prepend-script')
    @include('includes.admin.script')
    @stack('addon-script')
    @include('sweetalert::alert')
</body>

</html>