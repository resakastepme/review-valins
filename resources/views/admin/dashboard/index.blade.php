@extends('layouts.admin.mainlayout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/main.css') }}">
@endsection
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container mt-2">

        <div class="row">

            <div class="col-md-5 align-items-center" style="margin-top: 100px;" align="center">

                <div class="card text-white bg-light mb-3" style="max-width: 18rem;" id="tugasBtn">
                    <div class="card-body mt-3 mb-3">
                        <h3 class="card-title"><span class="me-4"><i class="fas fa-tasks fa-lg">
                                </i></span> TUGAS</h3>
                    </div>
                </div>

                <div class="card text-white bg-light mb-3" style="max-width: 18rem;" id="beriTugasBtn">
                    <div class="card-body mt-3 mb-3">
                        <h3 class="card-title"><span class="me-3"><i class="fas fa-plus fa-lg">
                                </i></span> BERI TUGAS</h3>
                    </div>
                </div>

                <div class="card text-white bg-light mb-3" style="max-width: 18rem;" id="dataBtn">
                    <div class="card-body mt-3 mb-3">
                        <h3 class="card-title"><span class="me-4"> <i
                                    class="fas fa-database fa-lg"> </i> </span> DATA</h3>
                    </div>
                </div>

                <div class="card text-white bg-light mb-3" style="max-width: 18rem;" id="penggunaBtn">
                    <div class="card-body mt-3 mb-3">
                        <h3 class="card-title"> <span class="me-3"> <i class="fas fa-users fa-lg">
                                </i> </span> PENGGUNA</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-7 justify-content-center align-items-center d-flex">
                <img src="{{ asset('assets/img/itvisual.png') }}" id="itVisual">
            </div>

        </div>

    </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/dashboard/main.js') }}"></script>
    <script type="text/javascript">
        $('#penggunaBtn').on('click', function() {

            var role = '{{ Session('role') }}';
            var link = null;
            if (role == 1) {
                var link = 'admin'
            } else {
                var link = 'user'
            };
            window.location.href = '/' + link + '/pengguna';

        });
        $('#penggunaBtn').on('click', function() {

            var role = '{{ Session('role') }}';
            var link = null;
            if (role == 1) {
                var link = 'admin'
            } else {
                var link = 'user'
            };
            window.location.href = '/' + link + '/pengguna';

        });
        $('#dataBtn').on('click', function() {

            var role = '{{ Session('role') }}';
            var link = null;
            if (role == 1) {
                var link = 'admin'
            } else {
                var link = 'user'
            };
            window.location.href = '/' + link + '/data';

        });
        $('#beriTugasBtn').on('click', function() {

            var role = '{{ Session('role') }}';
            var link = null;
            if (role == 1) {
                var link = 'admin'
            } else {
                var link = 'user'
            };
            window.location.href = '/' + link + '/beriTugas';

        });
    </script>
@endsection
