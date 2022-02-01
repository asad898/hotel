<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Google Font: Source Sans Pro -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"> --}}
    <!-- JQVMap -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}"> --}}
    <!-- Theme style -->
    <!-- Daterange picker -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}"> --}}
    @yield('head')

    <style>
        @media print {
            .unprint {
                display: none !important;
            }
        }

        @page {
            size: auto;
            margin: 0mm;
        }

    </style>

</head>

<body style="font-family: 'Cairo', sans-serif" class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            @auth
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('guests') }}" class="nav-link">النزلاء</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('rooms') }}" class="nav-link">الغرف</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('home') }}" class="nav-link">الرئيسية</a>
                    </li>
                    @if (auth()->user()->role == 'Admin' or auth()->user()->role == 'AManager')
                        <li class="nav-item d-none d-sm-inline-block">
                            <a href="{{ route('main.accounts') }}" class="nav-link">الحسابات</a>
                        </li>
                    @endif
                </ul>
            @endauth
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @auth
                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                            <i class="fas fa-th-large"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="d-flex">
                                <p>{{ auth()->user()->username }}<i class="fa fa-angle-down ml-1" aria-hidden="true"></i>
                                </p>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left text-right"
                            style="right: inherit; right: 0px;">
                            <a class="nav-link d-flex justify-content-between"
                                href="{{ route('users.show', auth()->user()->username) }}">
                                <i class="fas fa-user mr-3"></i>
                                <span class="float-right text-muted text-sm">حساب {{ auth()->user()->username }}</span>
                            </a>
                            @if (auth()->user()->role == 'Admin')
                                <div class="dropdown-divider"></div>
                                <a class="nav-link d-flex justify-content-between" href="{{ route('register') }}">
                                    <i class="fas fa-users mr-3"></i>
                                    <span class="float-right text-muted text-sm">إنشاء مسخدم جديد</span>
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="nav-link d-flex justify-content-between" href="{{ route('logout') }}" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-3"></i>
                                <span class="float-right text-muted text-sm">تسحيل خروج</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endauth

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                    </li>
                @endguest
            </ul>
        </nav>
        <!-- /.navbar -->

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/" class="brand-link text-center">
                <i class="brand-image img-circle elevation-3 fas fa-hotel mt-2" alt="Hotel"></i>
                {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
                <span class="brand-text font-weight-bold">Al-Faisal Hotel</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->

                <!-- Sidebar Menu -->
                @auth
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <!-- Add icons to the links using the .nav-icon class
                               with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-door-open mr-3"></i>
                                    <p>
                                        الاستقبال
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('rooms') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>عرض الغرف</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('bills') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>فواتير النزلاء الحاليين</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('trashedBills') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>فواتير النزلاء المغادريين</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('institutions') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>المؤسسات و الشركات</p>
                                        </a>
                                    </li>
                                    @if (auth()->user()->role == 'Admin' or auth()->user()->role == 'AManager')
                                        <li class="nav-item">
                                            <a href="{{ route('roomsprices') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>اسعار الغرف </p>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-hamburger mr-3" aria-hidden="true"></i>
                                    <p>
                                        المطعم
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('meals') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>الوجبات</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('restaurants') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>فواتير النزلاء الحاليين</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('restaurant.trashed') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>فواتير النزلاء المغادريين</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-tshirt mr-3" aria-hidden="true"></i>
                                    <p>
                                        المغسلة
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('clothes') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>انوع الملابس</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('laundries') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>فواتير النزلاء الحاليين</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('laundries.trashed') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>فواتير النزلاء المغادريين</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-store-alt mr-3" aria-hidden="true"></i>
                                    <p>
                                        المخزن
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('stores') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>عرض المخزن</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('store.bill.trashed') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>الفواتير المرحلة</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('store.bill.unsaved') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>الفواتير غير المرحلة</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @if (auth()->user()->role == 'Admin')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-cog mr-3" aria-hidden="true"></i>
                                        <p>
                                            إدارة النظام
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: none;">
                                        <li class="nav-item">
                                            <a href="{{ route('users') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>عرض المستخدمين</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            @if (auth()->user()->role == 'Admin' or auth()->user()->role == 'AManager')
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fa fa-calculator mr-3" aria-hidden="true"></i>
                                        <p>
                                            الحسابات
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview" style="display: none;">
                                        <li class="nav-item">
                                            <a href="{{ route('pay.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>إنشاء قيد

                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('main.accounts') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>الحسابات الرئيسية</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('journal.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>دفتر اليومية</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('journal.single') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>دفتر الاستاذ</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('journal.balance') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>ميزان المراجعة</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('journal.income') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>قائمة الدخل</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('statement.income') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>قائمة المركز المالي</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif

                        </ul>
                    </nav>
                @endauth
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper text-right pt-4" dir="rtl">
            @include('layouts.mess')
            @yield('content')
        </div>

        <footer class="main-footer unprint">
            <strong class="font-weight-bold">Copyright &copy; 2021-2022 Hotel System</strong>.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <!-- daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>

    @stack('scripts')

    <!-- prevint submitting tow record in form -->
    <script>
        $("body").on("submit", "form", function() {
            $(this).submit(function() {
                return false;
            });
            return true;
        });

    </script>
</body>

</html>
