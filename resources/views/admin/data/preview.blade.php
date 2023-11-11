@extends('layouts.admin.mainlayout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
    <style>
        #pointer {
            cursor: default
        }
    </style>
@endsection
@section('content')
    <div class="container p-3">
        <div class="row">
            <div class="col-auto d-flex">

                <h2 class="me-2"> Preview: </h2>
                <div class="card bg-success p-2" id="pointer">
                    <div class="card-title text-white">
                        <i class="fa-solid fa-file-excel fa-lg me-1"></i>
                        Data Template.xlsx
                    </div>
                </div>

            </div>
        </div>
    </div>

    <section class="m-4" id="dataError" style="display: block">
        <h5 class="text-center" style="color: red"><span class="fa-solid fa-triangle-exclamation fa-fade"></span> DATA TIDAK VALID TERDETEKSI </h5>
        <div class="card bg-danger p-3 rounded shadow border-0">
            <div class="card-body">
                TEST
            </div>
        </div>
    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
@endsection
