@extends('layouts.adminRules')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/auth/telkom-logo.png') }}" type="image/x-icon">
    <meta name="csrf_token" id="csrf_tokenGLobal" content="{{ csrf_token() }}">
    @yield('css')
    <title>Admin - Dashboard</title>
</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light bg-light" aria-label="Third navbar example">
        <div class="container-fluid">
            <img src="{{ asset('assets/img/auth/telkom-logo.png') }}" id="telkomLogo">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample03"
                aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-2" id="navbarsExample03">
                <ul class="navbar-nav me-auto mb-2 mb-sm-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('/' . (Session('role') === 1 ? 'admin' : 'user') . '/dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Beri tugas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" tabindex="-1" aria-disabled="true">Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/pengguna') ? 'active' : '' }}" href="{{ url('/' . (Session('role') === 1 ? 'admin' : 'user') . '/pengguna') }}"
                            tabindex="-1" aria-disabled="true">Pengguna</a>
                    </li>
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdown03" data-bs-toggle="dropdown"
                            aria-expanded="false">Pengguna</a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown03">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li> --}}
                </ul>

            </div>
        </div>

        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <span> <i class="fa-solid fa-user me-2"></i> </span> {{ Session('username') }}
                    </a>
                    <ul class="dropdown-menu form-control" aria-labelledby="navbarDarkDropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ url('/logout/normal') }}"><button
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
<script type="text/javascript">
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
