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
        <h5 class="text-center" style="color: red"><span class="fa-solid fa-triangle-exclamation fa-fade"></span> DATA TIDAK
            VALID TERDETEKSI </h5>
        <div class="card bg-danger p-3 rounded shadow border-0">
            <div class="card-body">

                <table id="tableDataPreviewError" style="width:100%" class="table table-striped table-bordered table-hover"
                    border="1">
                    <thead>
                        <tr>
                            <th>Row</th>
                            <th>Attribute</th>
                            <th>Error</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>NO DATA</td>
                            <td>NO DATA</td>
                            <td>NO DATA</td>
                            <td>NO DATA</td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
    </section>

    <section id="tableDataPreviewSuccess" class="m-4" id="dataSuccess" style="display:block">

    </section>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(document).ready(function() {
                $('#tableDataPreviewError').DataTable();
            });
        });
    </script>
@endsection
