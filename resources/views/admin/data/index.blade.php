@extends('layouts.admin.mainlayout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
    <style>
        #uploadExcelQuestion{
            cursor: pointer
        }
    </style>
@endsection
@section('content')
    <div class="card bg-light m-4 rounded shadow border-0">
        <div class="card-header p-4 d-flex">
            <button class="btn btn-primary me-2"> <span class="me-1"> <i class="fas fa-plus-circle fa-lg">
                    </i> </span> Tambah Data </button>
            <button class="btn btn-success"> <span class="me-1"> <i class="fa-solid fa-file-excel fa-lg"></i> </span> Upload
                Excel </button>
            <span class="ms-2 mt-2" align="center" id="uploadExcelQuestion"> <i class="fa-solid fa-circle-question fa-xl"></i> </span>
        </div>
        <div class="card-header p-4">
            <h1> THIS IS FILTER 2 </h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablePengguna" style="width:100%" class="table table-striped table-bordered table-hover"
                    border="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Timestamp</th>
                            <th>Witel</th>
                            <th>ID Valins</th>
                            <th>Eviden 1</th>
                            <th>Eviden 2</th>
                            <th>Eviden 3</th>
                            <th>ID Valins lama</th>
                            <th>ASO</th>
                            <th>Ket. ASO</th>
                            <th>RAM3</th>
                            <th>Ket. RAM3</th>
                            <th>Rekon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->timestamp_bawaan }}</td>
                                <td> {{ $data->witel }} </td>
                                <td> {{ $data->id_valins }} </td>
                                <td> {{ $data->eviden1 }} </td>
                                <td> {{ $data->eviden2 }} </td>
                                <td> {{ $data->eviden3 }} </td>
                                <td> {{ $data->id_valins_lama }} </td>
                                <td> {{ $data->approve_aso }} </td>
                                <td> {{ $data->keterangan_aso }} </td>
                                <td> {{ $data->ram3 }} </td>
                                <td> {{ $data->keterangan_ram3 }} </td>
                                <td> {{ $data->rekon }} </td>
                                <td align="center">
                                    <div class="row d-flex align-items-center justify-content-center">
                                        <div class="col-auto mb-1">
                                            <button class="btn btn-warning" type="button" style="color: white;"
                                                data-user-id="{{ $data['id'] }}" id="btnEdit"> Edit
                                            </button>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-danger" type="button"
                                                data-user-id="{{ $data['id'] }}"
                                                data-username="{{ $data['id_valins'] }}" id="btnHapus"> Hapus
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(document).ready(function() {
                $('#tablePengguna').DataTable();
            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/data/main.js') }}"></script>
@endsection
