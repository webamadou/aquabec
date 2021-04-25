<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">

    <!-- App script -->
    <script src="{{ asset('js/all.js') }}"></script>
    <!-- DataTables -->
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js" defer></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js" defer></script>
    

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('dist/icons-picker/js/bootstrap-iconpicker.bundle.min.js')}}" defer></script>
    <!-- <script src="{ {asset('js/scripts.js')}}" defer></script> -->
    @stack('scripts')

    <!-- Theme style -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/fancyform.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/icons-picker/css/bootstrap-iconpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" siteurl="{{ config('app.url') }}">
    <div class="wrapper">

        @include('layouts.back.partials.admin-navbar')

        @include('layouts.back.partials.admin-side-navbar')



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @include('layouts.back.partials.admin-breadcrumb')

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- <strong>Copyright &copy; 2020 {{ config('app.name') }}.</strong> -->
            <strong>Copyright &copy; 2021 L'agenda du Quebec.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> {{ config('app.version') }}
            </div>
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
@include('layouts.back.alerts.sweetalerts')
<script src="{{asset('dist/datepicker/bootstrap-datepicker.js')}}" defer></script>
<script src="{{asset('js/bootstrap-datepicker.js')}}" defer></script>
<script src="{{asset('js/admin_scripts.js')}}" defer></script>
<script>
    const SITE_URLs = document.querySelector("body").getAttribute("siteurl");
    const autocomplete_field = document.querySelector('input[name="autocomplete_user"]');
    const user_id_field = document.getElementById("user_id");

    if (autocomplete_field !== null) {
        autocomplete_field.addEventListener('keyup', function (e) {
            $.ajax({
                url: `${SITE_URL}/admin/autocomplete_user`,
                type: "get",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "autocomplete_user": autocomplete_field.value,
                },
                beforeSend: function () {
                    console.log('loading users');
                }
            }).done(function (data) {
                console.log(data);
                let list = '';
                for (let item in data) {
                    const user = data[item];
                    list += `<li data-user_id="${user.id}" data-username="${user.username}" class="select-user">${user.id} ${user.username}</li>`;
                }
                autocompletes.innerHTML = `<div class="close-autocomplete">x</div> ${list}`;
                autocompletes.style.display = "block";

            }).fail(function (jqXHR, ajaxOptions, thrownError) {
                console.log('No response from server');
            });
        });

        const close_autocomplete = document.querySelector(".close-autocomplete");
        $('body').on('click', '.close-autocomplete', function (e) {
            autocompletes.style.display = "none";
        });
        //when clicking on one of the result on the autocompletion
        $('body').on('click', '.select-user', function (e) {
            const userid = $(this).data("user_id");
            const username = $(this).data("username");
            autocomplete_field.value = `${userid} ${username}`;

            if (user_id_field != null) {
                user_id_field.value = userid;
                if (document.getElementById('filter_form_announcement') != null)
                    filter_elements();//we execute filter announcements function in case we need to filter
                if (document.getElementById('filter_form_events') != null)
                    filter_events();//we execute filter events function in case we need to filter
            }
            autocompletes.style.display = "none";
        });
    }
</script>
</body>

</html>
