@extends('layouts.admin.mainlayout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-lg-10 mx-auto">
                <div class="card rounded shadow border-0">
                    <div class="card-header p-3">
                        <button class="ms-5 btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" id="tambahDataBtn"> <span class="me-2"> <i
                                    class="fas fa-plus-circle fa-lg"> </i> </span> Tambah akun </button>
                    </div>
                    <div class="card-body p-5 bg-white rounded">
                        <div class="table-responsive">
                            <table id="example" style="width:100%" class="table table-striped table-bordered table-hover"
                                border="1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Role</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user['role'] == 1 ? 'Admin' : 'User' }}</td>
                                            <td>{{ $user['username'] }}</td>
                                            <td>{{ $user['email'] }}</td>
                                            <td align="center">
                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-1">
                                                        <button class="btn btn-warning" type="button"
                                                            style="color: white;"> Edit
                                                        </button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="btn btn-danger" type="button"> Hapus
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
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-12">

                                <form id="tambahDataForm" method="POST">

                                    @csrf

                                    <label for="username"> Username </label>
                                    <input type="text" class="form-control" name="username" id="username" />

                                    <label for="email"> Email </label>
                                    <input type="email" name="email" id="email" class="form-control" />

                                    <label for="password"> Password </label>
                                    <input type="password" name="password" id="password" class="form-control" />

                                    <label for="passwordConfirm"> Confirm password </label>
                                    <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control" />

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
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
                $('#example').DataTable();
            });
        });
    </script>
@endsection
