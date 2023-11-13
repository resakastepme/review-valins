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
<?php if(empty($access)) return redirect()->to('/auth')->send() ?>
    <?php error_reporting(0); ?>
    <div class="container p-3">
        <div class="row">
            <div class="col-auto d-flex">

                <h2 class="me-2"> Preview: </h2>
                <div class="card bg-success p-2" id="pointer">
                    <div class="card-title text-white">
                        <i class="fa-solid fa-file-excel fa-lg me-1"></i>
                        {{Session('fileName')}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if ($previewNotValid[0]['id_valins'] != '')
        <section class="m-4" id="dataError" style="display: block">
            <h5 class="text-center" style="color: red"><span class="fa-solid fa-triangle-exclamation fa-fade"></span> DATA
                TIDAK
                VALID TERDETEKSI </h5>
            <div class="card bg-danger p-3 rounded shadow border-0">
                <div class="card-body">

                    <table id="tableDataPreviewError" style="width:100%"
                        class="table table-striped table-bordered table-hover" border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Timestamp</th>
                                <th>Witel</th>
                                <th>ID Valins</th>
                                <th>Rekon</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($previewNotValid as $notValid)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $notValid->timestamp_bawaan }}</td>
                                    <td>{{ $notValid->witel }}</td>
                                    <td>{{ $notValid->id_valins }}</td>
                                    <td>{{ $notValid->rekon }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    @endif
    @if ($previewValid[0]['id_valins'] != '')
        <section id="dataSuccess" class="m-4" id="dataSuccess" style="display:block">
            <h5 class="text-center" style="color: green"><span class="fa-solid fa-thumbs-up fa-fade"></span> DATA VALID
            </h5>
            <div class="card bg-success p-3 rounded shadow border-0">
                <div class="card-body">

                    <table id="tableDataPreviewSuccess" style="width:100%"
                        class="table table-striped table-bordered table-hover" border="1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Timestamp</th>
                                <th>Witel</th>
                                <th>ID Valins</th>
                                <th>Rekon</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($previewValid as $Valid)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $Valid->timestamp_bawaan }}</td>
                                    <td>{{ $Valid->witel }}</td>
                                    <td>{{ $Valid->id_valins }}</td>
                                    <td>{{ $Valid->rekon }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </section>
    @endif
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tableDataPreviewError').DataTable();
            $('#tableDataPreviewSuccess').DataTable();
        });
    </script>
@endsection
