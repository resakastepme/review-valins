@extends('layouts.admin.mainlayout')
@section('title')
    Tugas
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="row">
        <div class="col-auto">



        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/tugas/main.js') }}"></script>
@endsection
