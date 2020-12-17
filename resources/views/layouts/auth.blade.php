<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Basic Page Needs
    ================================================== -->
    <title>{{ config('app.name') }} - @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Simplest is - Professional A unique and beautiful collection of UI elements">
    <link rel="icon" href="{{ asset('images/logo/logo.png') }}">
    <!-- CSS
    ================================================== -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <!-- icons
    ================================================== -->
    <script src="https://kit.fontawesome.com/815e388c50.js" crossorigin="anonymous"></script>
    <!-- Google font
    ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
</head>
<body class="bg-white">
<!-- Content
================================================== -->
<div uk-height-viewport class="uk-flex uk-flex-middle">
    <div class="uk-width-2-3@m uk-width-1-2@s m-auto rounded uk-overflow-hidden shadow-lg">
        <div class="uk-child-width-1-2@m uk-grid-collapse bg-gradient-primary" uk-grid>

            <!-- column one -->
            <div class="uk-margin-auto-vertical uk-text-center uk-animation-scale-up p-3 uk-light">
                <img src="{{ asset('images/logo/logo_white.png') }}" alt="">
                <h3 class="mb-3 mt-lg-4 font-weight-lighter text-uppercase">
                    L'Agenda du Québec <br>vous ouvre les portes vers l'aventure!
                </h3>
            </div>

            <!-- column two -->
            <div class="uk-card-default px-5 py-8">
                <div class="mb-4 uk-text-center">
                    <h2 class="mb-0">@yield('title')</h2>
                    <p class="my-2">@yield('sub-title')</p>
                </div>

                @yield('content')

            </div><!--  End column two -->

        </div>
    </div>
</div>

<!-- javaScripts
================================================== -->
<script src="{{ asset('js/auth.js') }}"></script>
</body>
</html>
