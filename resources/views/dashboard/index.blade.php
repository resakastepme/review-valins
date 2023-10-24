@extends('layouts.admin.mainlayout')
@section('css')
@endsection
@section('content')
    <div class="container mt-2">
        <div class="row">
            <div class="col justify-content-center align-items-center d-flex">
                <img src="{{ asset('assets/img/itvisual.png') }}" id="itVisual">
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/main.js') }}"></script>
@endsection
