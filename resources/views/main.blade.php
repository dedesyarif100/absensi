<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sufee Admin - HTML5 Admin Template</title>
    <meta name="description" content="Sufee Admin - HTML5 Admin Template">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('css')
        <link rel="apple-touch-icon" href="{{ asset('style/apple-icon.png') }}">
        <link rel="shortcut icon" href="{{ asset('style/favicon.ico') }}">
        <link rel="stylesheet" href="{{ asset('style/assets/css/normalize.css') }}">
        <link rel="stylesheet" href="{{ asset('style/assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('style/assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('style/assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('style/assets/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('style/assets/css/cs-skin-elastic.css') }}">
        <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
        <link rel="stylesheet" href="{{ asset('style/assets/scss/style.css') }}">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
        <style>
            /* @media only screen and (max-width: 600px) {
                .open {
                    overflow: hidden;
                }
            } */
        </style>
</head>
<body class="{{ Agent::isDesktop() ? 'open' : '' }}">
        <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button id="navbar-toggle" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="d-block">
                    <a class="navbar-brand" href="#">Absensi</a>
                    <a class="navbar-brand hidden" href="#">A</a>
                </div>
                <span id="version" class="text-muted small d-none">v 1.0 | 17-09-2021</span>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ url('employee/chart') }}"> <i class="menu-icon fa fa-dashboard"></i>Chart </a>
                    </li>
                    @if (Crypt::decrypt(session('login')) === 'admin')
                        <li>
                            <a href="{{ url('employee/employee') }}"> <i class="menu-icon fa fa-list"></i>List Employee </a>
                        </li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-thumbnail rounded-circle" src="{{ 'https://ui-avatars.com/api/?name='.Crypt::decrypt(session('login')) }}" style="width: 50px;">
                        </a>
                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>
                            <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>
                            <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>
                            {{--  <a class="nav-link" href="#" on><i class="fa fa-power -off"></i>Logout</a>  --}}
                            <button class="btn btn-block text-danger" type="submit" form="logout">
                                <i class="fa fa-power-off"></i> Logout
                            </button>
                            <form id="logout" action="{{ url('employee/logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        @yield('breadcrumbs')
        @yield('content')
        <div class="content mt-3">
            <div class="animated fadeIn">
                <div class="row">

                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

    @yield('js')
    <script src="{{ asset('style/assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('style/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('style/assets/js/main.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('body').on('click', '#menuToggle', function () {
                $('#version').toggleClass('d-none');
            });
        });

        function myFunction(x) {
            if (x.matches) { // If media query matches
                $('body').on('click', function () {
                    $('body').removeClass('open');
                })
            }
        }

        var x = window.matchMedia("(max-width: 500px)");
        myFunction(x);
        x.addListener(myFunction);
    </script>
</body>
</html>
