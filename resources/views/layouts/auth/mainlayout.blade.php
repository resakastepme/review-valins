<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/auth/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/auth/telkom-mini-logo.png') }}" type="image/x-icon">
    <title> Sign In </title>
</head>

<body style="background-image: url('{{ asset('assets/img/auth/auth-bg.jpg') }}');">

    @yield('content')

</body>

<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/fontawesome/all.js') }}"></script>

    @yield('script')

</html>
