@extends('layouts.userRules')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="google-site-verification" content="0iPe0prctv_NK0MZ7eO3wazEXkB5ABvQzMmsN7Y_v4Q" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/auth/telkom-logo.png') }}" type="image/x-icon">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    @yield('css')
    <title> {{ Session::get('role') == 1 ? 'Admin' : (Session::get('role') == 2 ? 'Aso' : 'User') }} - @yield('title')
    </title>

    <style>
        /* CSS */
        :root {
            --background-color: #fff;
            /* Light mode background color */
            --text-color: #333;
            /* Light mode text color */
            --icon-color: #333;
            /* Light mode icon color */
            --modal-background: #fff;
            /* Light mode modal background color */
            --modal-text: #333;
            /* Light mode modal text color */
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .card {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .card .card-title {
            color: var(--text-color);
        }

        .navbar-toggler-icon {
            background-color: var(--icon-color);
        }

        /* Additional styles for other elements in light mode */

        /* Navbar styles */
        .navbar {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .navbar-dark .navbar-toggler-icon {
            background-color: var(--icon-color);
        }

        .navbar-dark .navbar-nav .nav-link {
            color: var(--text-color);
        }

        /* Modal styles */
        .modal-content {
            background-color: var(--modal-background);
            color: var(--modal-text);
        }

        .modal-header {
            background-color: var(--modal-background);
            color: var(--modal-text);
        }

        /* Dark mode styles */
        .dark-mode {
            --background-color: #333;
            /* Dark mode background color */
            --text-color: #fff;
            /* Dark mode text color */
            --icon-color: #fff;
            /* Dark mode icon color */
            --modal-background: #333;
            /* Dark mode modal background color */
            --modal-text: #fff;
            /* Dark mode modal text color */
        }

        .dark-mode body {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .dark-mode .card,
        .dark-mode .bg-dark {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .dark-mode .navbar {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .dark-mode .navbar-toggler-icon {
            background-color: var(--icon-color);
        }

        .dark-mode .navbar-nav .nav-link {
            color: var(--text-color);
        }

        /* Dark mode modal styles */
        .dark-mode .modal-content {
            background-color: var(--modal-background);
            color: var(--modal-text);
        }

        .dark-mode .modal-header {
            background-color: var(--modal-background);
            color: var(--modal-text);
        }

        body.dark-mode #example_wrapper {
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableData th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableData td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableDataPreviewError th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableDataPreviewError td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableDataPreviewSuccess th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableDataPreviewSuccess td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tablePengguna th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tablePengguna td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableSelective th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableSelective td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableAddSelective th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableAddSelective td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableLihat th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableLihat td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableLihat th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableLihat td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableEdit th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableEdit td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableKerjakanData th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableKerjakanData td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode #tableDataFinish th {
            /* border-color: #555; */
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #tableDataFinish td {
            /* border-color: #555; */
            background-color: #333;
            color: #fff;
        }

        body.dark-mode {
            background-color: #333;
            color: #fff;
        }

        body.dark-mode .accordion-button {
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #acor-content {
            background-color: #555;
            color: #fff;
        }

        body.dark-mode .accordion-button2 {
            background-color: #555;
            color: #fff;
        }

        body.dark-mode #acor-content2 {
            background-color: #555;
            color: #fff;
        }

        /* Define styles for light mode (default) */
        body.light-mode {
            background-color: #fff;
            color: #333;
        }

        body.light-mode .accordion-button {
            background-color: #f8f9fa;
            color: #000;
        }

        body.light-mode #acor-content {
            background-color: #f8f9fa;
            color: #000;
        }

        body.light-mode .accordion-button2 {
            background-color: #f8f9fa;
            color: #000;
        }

        body.light-mode #acor-content2 {
            background-color: #f8f9fa;
            color: #000;
        }

        /* Add more styles for other elements in dark mode */
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light" aria-label="Third navbar example" id="navbarExample">
        <div class="container-fluid">
            <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}" id="telkomLogo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03"
                aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-2" id="navbarsExample03">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') || request()->is('user/dashboard') ? 'active' : '' }}"
                            aria-current="page"
                            href="{{ url('/' . (Session::get('role') == 1 ? 'admin' : 'user') . '/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/tugas') || request()->is('user/tugas') ? 'active' : '' }}"
                            href="{{ url('/' . (Session::get('role') == 1 ? 'admin' : 'user') . '/tugas') }}">Tugas</a>
                    </li>
                    @if (Session::get('role') == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/beriTugas') || request()->is('user/beriTugas') ? 'active' : '' }}"
                                href="{{ url('/' . (Session::get('role') == 1 ? 'admin' : 'user') . '/beriTugas') }}">Beri
                                tugas</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/data') || request()->is('user/data') || request()->is('admin/data/preview') ? 'active' : '' }}"
                            href="{{ url('/' . (Session::get('role') == 1 ? 'admin' : 'user') . '/data') }}"
                            tabindex="-1" aria-disabled="true">Data</a>
                    </li>
                    @if (Session::get('role') == 1)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/pengguna') || request()->is('user/pengguna') ? 'active' : '' }}"
                                href="{{ url('/' . (Session::get('role') == 1 ? 'admin' : 'user') . '/pengguna') }}"
                                tabindex="-1" aria-disabled="true">Pengguna</a>
                        </li>
                    @endif
                    {{-- <li class"nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Pengguna</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>= --}}
                </ul>

            </div>
        </div>
        <div class="collapse navbar-collapse me-4" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span> <i class="fa-solid fa-user me-2"></i> </span> {{ Session('username') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li>
                            <button id="theme-toggle" class="btn btn-primary ms-3">Toggle Theme</button>

                        </li>
                        <li><a class="dropdown-item" href="{{ url('/logout/bye-bye') }}"><button
                                    class="btn btn-danger form-control"> <span><i
                                            class="fa fa-right-from-bracket"></i></span> Logout </button></a></li>
                    </ul>
                </li>
            </ul>
        </div>

    </nav>

    @yield('content')

</body>

<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/fontawesome/all.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/autologout.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
<script type="text/javascript">
    // JavaScript with jQuery
    $(document).ready(function() {
        const themeToggle = $('#theme-toggle');
        const body = $('body');
        const exampleCard = $('.card.bg-light'); // Select only cards with bg-light class
        const navbar = $('#navbarExample');
        const modalContent = $('.modal-content'); // Update with the actual class for your modal content

        // Check user's preference from local storage
        if (localStorage.getItem('theme') == 'dark') {
            body.addClass('dark-mode');
            exampleCard.removeClass('bg-light').addClass('bg-dark');
            navbar.removeClass('bg-light').addClass('bg-dark');
            modalContent.removeClass('bg-light').addClass('bg-dark');
        }

        // Toggle between light and dark modes
        themeToggle.on('click', function() {
            body.toggleClass('dark-mode');
            const isDarkMode = body.hasClass('dark-mode');

            // Update card background class based on dark mode
            exampleCard.each(function() {
                const card = $(this);
                card.removeClass(isDarkMode ? 'bg-light' : 'bg-dark').addClass(isDarkMode ?
                    'bg-dark' : 'bg-light');
            });

            // Update navbar background class based on dark mode
            navbar.removeClass(isDarkMode ? 'bg-light' : 'bg-dark').addClass(isDarkMode ? 'bg-dark' :
                'bg-light');

            // Update modal content background class based on dark mode
            modalContent.removeClass(isDarkMode ? 'bg-light' : 'bg-dark').addClass(isDarkMode ?
                'bg-dark' : 'bg-light');

            // Save user's preference to local storage
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        });
    });



    function logoResizer() {
        if (window.innerWidth < 576) {
            document.getElementById('telkomLogo').style.width = "20%";
            document.getElementById('telkomLogo').style.height = "20%";
        } else {

            document.getElementById('telkomLogo').style.width = "5%";
            document.getElementById('telkomLogo').style.height = "5%";
        }
    }
    logoResizer();
    window.addEventListener('resize', logoResizer);

    function itVisual() {
        if (window.innerWidth < 576) {
            document.getElementById('itVisual').style.width = "100%";
            document.getElementById('itVisual').classList.add('mt-5');
            // document.getElementById('itVisual').style.height = "20%";
        } else {
            document.getElementById('itVisual').style.width = "";
            document.getElementById('itVisual').classList.remove('mt-5');
        }
    }

    itVisual();
    window.addEventListener('resize', itVisual);
</script>

@yield('script')

</html>
