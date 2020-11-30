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
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" >
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

@include('frontend.includes.sidebar')

@include('layouts.front.partials.top-nav-bar')

@include('layouts.front.partials.header')

@yield('content')

@include('layouts.front.partials.footer')

<!-- Javascript File
   =============================================================================-->
<script src="{{ asset('js/frontend.js') }}"></script>
</body>
</html>
