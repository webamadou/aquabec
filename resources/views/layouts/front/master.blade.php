<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <!-- Basic Page Needs =====================================-->
    <meta charset="utf-8">
    <!-- Mobile Specific Metas ================================-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Site Title- -->
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo/logo.png') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/frontend.css') }}" >
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body siteurl="{{ config('app.url') }}">

@include('frontend.includes.sidebar')

@include('layouts.front.partials.top-nav-bar')

@include('layouts.front.partials.header2')

@yield('content')

@include('layouts.front.partials.footer')

<noscript>
    <style>
        .wrapper{ display: none;}
    </style>
    <div>
        Vous avez désactivé Javascript sur votre navigateur. Un bon nombre de fonctionnalités sont exécutées avec Javascript.<br>Vous devez activer Javascript pour pouvoir utiliser le site.
    </div>
</noscript>
<!-- Javascript File
   =============================================================================-->
<script src="{{asset('dist/datepicker/bootstrap-datepicker.js')}}" defer></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}" defer></script>
<script src="{{asset('dist/moment.js')}}" defer></script>
<script src="{{ asset('js/frontend.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}" defer></script>
<script src="https://kit.fontawesome.com/9466c40bfd.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
