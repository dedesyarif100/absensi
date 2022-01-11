<!DOCTYPE html>
<html>
<head>
    <title>Absensi Monstergroup</title>
    <link rel="stylesheet" href="{{ asset('style/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('style/assets/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.common.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.light.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <style>
        .page-wrapper {
            height: 720px;
        }

        /* <<<<<<<<<<<<<<<<<<<< MEDIA QUERY INI, UNTUK MENGATUR TINGGI AREA CHART APLIKASI DIAKSES MENGGUNAKAN MOBILE APPS >>>>>>>>>>>>>>>>>>>>>>>> */
        @media only screen and (min-width: 320px) and (max-width: 713px) {
            .page-wrapper {
                height: 860px;
            }
        }
        @media only screen and (min-width: 714px) and (max-width: 914px) {
            .page-wrapper {
                height: 750px;
            }
        }
        /* <<<<<<<<<<<<<<<<<<<< MEDIA QUERY INI, UNTUK MENGATUR TINGGI AREA CHART APLIKASI DIAKSES MENGGUNAKAN MOBILE APPS >>>>>>>>>>>>>>>>>>>>>>>> */
    </style>
    @yield('css')
</head>
<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <header class="topbar" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    {{-- LOGO MONSTER GROUP DI BAGIAN SIDEBAR POJOK KIRI ATAS --}}
                    <div class="navbar-brand">
                        <span class="logo-text ms-2">
                            <img src="{{ asset('style/assets/images/logo/monster-group.png') }}" width="90%" alt="homepage" class="light-logo" />
                        </span>
                    </div>
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    {{-- COLLAPSE FUNGSI SHOW HIDDEN SIDEBAR --}}
                    <ul class="navbar-nav float-start me-auto">
                        <li class="nav-item d-lg-block">
                            <a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="fas fa-bars"></i></a>
                        </li>
                    </ul>
                    <ul class="navbar-nav float-end">
                        <li class="nav-item dropdown">
                            {{-- INISIAL USER YANG LOGIN SAAT INI --}}
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="img-thumbnail rounded-circle" src="{{ 'https://ui-avatars.com/api/?name='.Crypt::decrypt(session('login')) }}" style="width: 50px;">
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end user-dd animated" aria-labelledby="navbarDropdown">
                                <div class="dropdown-divider"></div>
                                {{-- FUNGSI LOGOUT --}}
                                <button class="btn btn-danger btn-block" type="submit" form="exit">
                                    <i class="fa fa-power-off"></i> Logout
                                </button>
                                <form id="exit" action="{{ url('employee/logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< LIST MENU DI SIDEBAR >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
        <aside class="left-sidebar" data-sidebarbg="skin5">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="pt-4">
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('employee/chart') }}" aria-expanded="false"><i class="far fa-chart-bar"></i><span class="hide-menu">Chart</span></a>
                        </li>
                        @if (Crypt::decrypt(session('login')) === 'admin')
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('employee/employee') }}" aria-expanded="false"><i class="far fa-list-alt"></i><span class="hide-menu">List Employee</span></a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>
        {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< LIST MENU DI SIDEBAR >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}

        {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< CONTENT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
        <div class="page-wrapper">
            <div class="container-fluid">
                @yield('breadcrumbs')
                @yield('content')
                <div class="content mt-3">
                    <div class="animated fadeIn">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< CONTENT >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> --}}
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('style/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('style/assets/js/custom.min.js') }}"></script>
    <script src="{{ asset('style/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('style/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    @yield('js')
</body>
</html>
