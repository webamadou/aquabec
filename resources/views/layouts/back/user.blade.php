<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield(('title'))</title>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- App script -->
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>

    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" defer></script>

    @stack('scripts')

    <!-- Theme style -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <script defer>
       

    </script>
</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <img src="{{ asset('images/logo/logo.png') }}" alt="{{ config('app.name') }}" class="brand-image">
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}">Tableau de bord</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.events.index') }}" class="nav-link {{ side_nav_bar_menu_status('events','active') }}">Mes événements</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Mes annonces</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Mon Compte</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li><a href="{{route('user.infosperso')}}" class="dropdown-item">Informations personnelles </a></li>
                            <li><a href="#" class="dropdown-item">Mon équipe</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="#" class="dropdown-item">Mon Abonnements</a></li>
                            <li><a href="#" class="dropdown-item">Mes Monnaies</a></li>
                        </ul>
                    </li>
                    @hasanyrole('super-admin')
                        <li class="nav-item dropdown">
                            <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="fa fa-user-shield"></i> Tableau de bord</a>
                        </li>
                    @endrole
                </ul>
            </div>

            <!-- Right navbar links -->
            <!-- <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
                <!-- Notifications Dropdown Menu ->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-primary navbar-badge">0</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">0 Notification(s)</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>

                        <a href="#" class="dropdown-item dropdown-footer">Toutes les notifications</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user mr-2"></i> Mon Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-lock mr-2"></i> Securité
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off mr-2"></i> Se Déconnecter
                        </a>
                    </div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul> -->
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('layouts.back.partials.user-breadcrumb')

        <!-- Main content -->
        <div class="content">
            <div class="container">
                <div class="row">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif 
                </div>
                @yield('content')

            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
    </footer>
</div>
<!-- ./wrapper -->

<noscript>
    <style>
        .wrapper{ display: none;}
    </style>
    <div>
        Vous avez désactivé Javascript sur votre navigateur. Un bon nombre de fonctionnalités sont exécutées avec Javascript.<br>Vous devez activer Javascript pour pouvoir utiliser le site.
    </div>
</noscript>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
@include('layouts.back.alerts.sweetalerts')
</body>
</html>
