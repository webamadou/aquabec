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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FROALA -->
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_editor.min.css' rel='stylesheet' type='text/css' />
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/css/froala_style.min.css' rel='stylesheet' type='text/css' />
    
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- App script -->
    <script src="{{ asset('js/all.js') }}"></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>

    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js" defer></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script> -->
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" defer></script>

    @stack('scripts')

    <!-- Theme style -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{asset('dist/ckeditor5/build/styles.css')}}">
    <link rel="stylesheet" href="{{ asset('/dist/datepicker/combined.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <script defer>
       

    </script>
</head>
<body class="hold-transition layout-top-nav" siteurl="{{ config('app.url') }}">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
        <div class="container">
            <a href="{{ route('welcome') }}" class="navbar-brand">
                <img src="{{ asset('/images/logo/logo.png') }}" alt="{{ config('app.name') }}" class="brand-image">
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    @hasanyrole('banquier')
                    <li class="nav-item">
                        <a href="{{ route('banker.currencies.accounts') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}"><i class="fas fa-coins nav-icon pr-2"></i>Les Monnaies</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('banker.currencies.index') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}"><i class="fa fa-plus nav-icon pr-2"></i>Ajouter une monnaie</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.credits.logs') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}"><i class="fa fa-list nav-icon pr-2"></i>Historique des transferts</a>
                    </li>
                    @endrole
                    @hasanyrole('super-admin|admin|annonceur|vendeur')
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ side_nav_bar_menu_status('dashboard','active') }}"><i class="fa fa-user-cog"></i> Portrait</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.my_events') }}" class="nav-link {{ side_nav_bar_menu_status('events','active') }}"><i class="fas fa-calendar-check"></i> Mes événements</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('user.my_announcements')}}" class="nav-link"><i class="fa fa-bullhorn"></i> Mes annonces</a>
                    </li>
                    @endrole
                    @hasanyrole('chef-vendeur|vendeur')
                        <li class="nav-item"><a class="nav-link" href="{{route('vendeurs.my_team')}}"><i class="fa fa-user-friends"></i> Mon équipe</a></li>
                    @endrole
                    @auth
                    <li class="nav-item dropdown">
                        <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Mon Profil</a>
                        <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                            <li>
                                <a class="dropdown-item" href="{{route('user.infosperso')}}/account"><i class="fa fa-cogs"></i> Mon Compte</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{route('user.infosperso')}}/infos-perso"><i class="fa fa-user"></i> Infos personelles</a>
                            </li>
                            <li>
                                <a class="dropdown-item link-success" href="{{route('user.infosperso')}}/transactions" title="Lsite de mes transactions"><i class="fas fa-exchange-alt" aria-hidden="true"></i> Mes Transactions</a>
                            </li>
                            <li>
                                <a class="dropdown-item link-primary" href="{{route('user.infosperso')}}/wallet" title="Mon Portefeuille"><i class="fa fa-wallet" aria-hidden="true"></i> Mon Portefeuille </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item link-primary" href="{{route('user.infosperso')}}/security" title="Mon Portefeuille"><i class="fa fa-wallet" aria-hidden="true"></i> Sécurité </a>
                            </li>
                        </ul>
                    </li>
                    @endauth
                    @hasanyrole('super-admin|admin')
                        <li class="nav-item dropdown">
                            <a href="{{route('admin.dashboard')}}" class="btn btn-primary"><i class="fa fa-user-shield"></i> Tableau de bord</a>
                        </li>
                    @endrole
                    <li>
                        <a class="dropdown-item text-primary" href="{{ route('logout') }}"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off mr-2"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        @include('layouts.back.partials.user-breadcrumb')

        <!-- Main content -->
        <div class="content">
            <div class="container">

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<noscript>
    <style>
        .wrapper{ display: none;}
    </style>
    <div>
        Vous avez désactivé Javascript sur votre navigateur. Un bon nombre de fonctionnalités sont exécutées avec Javascript.<br>Vous devez activer Javascript pour pouvoir utiliser le site.
    </div>
</noscript>
<script src="{{asset('dist/datepicker/bootstrap-datepicker.js')}}" defer></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}" defer></script>

<!-- Froala 2.7.3 -->
<script type='text/javascript' src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/froala_editor.pkgd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/froala-editor@2.9.1/js/languages/fr.js"></script>
@include('layouts.back.alerts.sweetalerts')

<script src="{{asset('dist/ckeditor5/build/ckeditor.js')}}"></script>
<script>ClassicEditor
        .create( document.querySelector( '.editor, .ckeditor' ), {
            
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bold',
                    'italic',
                    'link',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'outdent',
                    'indent',
                    '|',
                    'imageUpload',
                    'blockQuote',
                    'insertTable',
                    'mediaEmbed',
                    'undo',
                    'redo',
                    'CKFinder',
                    'underline',
                    'fontColor',
                    'removeFormat',
                    'alignment'
                ]
            },
            language: 'fr',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:full',
                    'imageStyle:side'
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
            
            
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( error => {
            console.error( 'Oops, something went wrong!' );
            console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
            console.warn( 'Build id: qp877ojrkize-b9d1q6l02xnr' );
            console.error( error );
        } );
</script>
</body>
</html>
