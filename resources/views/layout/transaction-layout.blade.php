<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>App | @yield('title')</title>
    <link rel="icon" href="/img/rs.ico" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css" />
    <link rel="stylesheet" href="/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css" />
    <script src="/js/plotly-latest.min.js"></script>
    <script src="/plugins/jquery/jquery.min.js"></script>
    {{-- DUALIS --}}
    <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    {{-- TEST --}}
    <style>
        u {
            border-bottom: 2px solid black;
            text-decoration: none;
            display: inline-block;
            position: relative;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link text-lg" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" tabindex="-1" href="#">Action</a>
                        <a class="dropdown-item" tabindex="-1" href="#">Another action</a>
                        <a class="dropdown-item" tabindex="-1" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" tabindex="-1" href="{{ route('logout') }}">
                            <i class='fas fa-sign-out-alt'></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ url('/') }}" class="brand-link">
                <span class="brand-text font-weight-light">OnlineShop</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/user.jpg" class="img-circle elevation-2" alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{ Auth::user()->name }}
                        </a>
                    </div>
                </div>
                <nav class="mt-2 sidebar-nav">
                    <ul id="sidebarnav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('admin') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-header user-panel"></li>
                        <li class="nav-header">Transaction</li>
                        @if (in_array(Auth::user()->role, ['admin']))
                            <li class="nav-item">
                                <a href="{{ route('products.control') }}" class="nav-link">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>
                                        Products Control
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array(Auth::user()->role, ['admin', 'cslayer1']))
                            <li class="nav-item">
                                <a href="{{ route('products.cslayer1') }}" class="nav-link">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>
                                        Orders (Cs Layer 1)
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (in_array(Auth::user()->role, ['admin', 'cslayer2']))
                            <li class="nav-item">
                                <a href="{{ route('products.cslayer2') }}" class="nav-link">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>
                                        Orders (Cs Layer 2)
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>

                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-0">
                        <div class="col-sm-6">
                            <h3 class="m-0">@yield('title')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">@yield('title')</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @stack('scripts')
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/plugins/chart.js/Chart.min.js"></script>
    <script src="/plugins/sparklines/sparkline.js"></script>
    <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/dist/js/adminlte.js"></script>
    <script src="/dist/js/pages/dashboard.js"></script>
    <script src="/js/sidebarmenu.js"></script>
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
</body>

</html>
