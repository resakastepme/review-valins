@extends('layouts.auth.mainlayout')
@section('content')
    <div class="container py-5 h-100 vh-100">

        <div class="row d-flex justify-content-center align-items-center h-100">

            <div class="col-md-3">
                {{-- KOSONG --}}
            </div>
            <div class="col-md-6">

                @if (Session('session-timeout'))
                    <div class="card bg-warning mb-2">
                        <div class="card-title" align="center">
                            <h4 class="mt-3 me-3"> <span> <i class="fas fa-exclamation-circle fa-lg"></i> </span> Session
                                habis! </h4>
                        </div>
                    </div>
                @endif

                <div class="card" id="mainCard">
                    <div class="card-header text-center">
                        <h3> LOGIN </h3>
                    </div>
                    <div class="card-body m-3">

                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ asset('assets/img/auth/telkom-logo.png') }}"
                                    style="width: 100%; height: 100%; min-height: 100%;">
                            </div>
                            <div class="col-md-8">

                                <form id="loginForm">

                                    <label for="email"> email </label>
                                    <input type="email" name="email" id="email" class="form-control mb-2" />

                                    <label for="password"> password </label>
                                    <input type="password" name="password" id="password" class="form-control mb-3" />

                                    <button type="submit" class="btn btn-primary form-control" id="btnLogin"> LOGIN <span
                                            class="spinner-border spinner-border-sm ms-1" id="spinnerLogin"></span>
                                    </button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                {{-- KOSONG --}}
            </div>
        </div>

    </div>

    <div class="toast-container top-0 end-0 mt-2 me-2">
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successLogin">
            <div class="d-flex">
                <i class="fa fa-circle-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil login! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-user/tidaklengkap">
            <div class="d-flex">
                <i class="fa fa-2xl fa-circle-exclamation fa-fade mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Silahkan lengkapi form! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-user/userpass">
            <div class="d-flex">
                <i class="fa fa-2xl fa-circle-exclamation fa-fade mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Email/password tidak ditemukan! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/auth/main.js') }}"></script>
@endsection
