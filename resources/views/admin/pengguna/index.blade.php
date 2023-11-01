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
                        <button class="ms-4 btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahAkunModal"
                            type="button" id="tambahDataBtn"> <span class="me-2"> <i class="fas fa-plus-circle fa-lg">
                                </i> </span> Tambah akun </button>
                    </div>
                    <div class="card-body p-4 bg-white rounded">
                        <button type="button" class="btn btn-success mb-3" id="refresh"><i
                            class="fa-solid fa-arrows-rotate me-1" id="refreshIcon"></i> Refresh </button>
                        <div class="table-responsive">
                            <table id="tablePengguna" style="width:100%"
                                class="table table-striped table-bordered table-hover" border="1">
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
                                                    <div class="col-md-2">
                                                        <button class="btn btn-warning" type="button" style="color: white;"
                                                            data-user-id="{{ $user['id'] }}" id="btnEdit"> Edit
                                                        </button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button class="btn btn-danger" type="button"
                                                            data-user-id="{{ $user['id'] }}" data-username="{{ $user['username'] }}" id="btnHapus"> Hapus
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

    {{-- TOASTS --}}
    <div class="toast-container top-0 end-0 mt-2 me-2">
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningLengkapiForm">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Lengkapi form! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningUsernameSudahAda">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Username tidak tersedia! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningEmailTerdaftar">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Email sudah terdaftar! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningKonfirmasiPassword">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Gagal konfirmasi password! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-dangerGagal">
            <div class="d-flex">
                <i class="fa-solid fa-circle-xmark fa-fade fa-2xl"></i>
                <div class="toast-body">
                    <h6> Gagal menambahkan! coba lagi nanti </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-dangerGagalHapus">
            <div class="d-flex">
                <i class="fa-solid fa-circle-xmark fa-fade fa-2xl"></i>
                <div class="toast-body">
                    <h6> Akun gagal dihapus! coba lagi nanti </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-success">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil ditambahkan! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>

        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successDelete">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil dihapus! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahAkunModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> Tambah Akun </h2>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                                <form class="p-3" id="tambahDataForm">

                                    <input type="hidden" name="csrfHidden" id="csrfHidden"
                                        value="{{ csrf_token() }}" />

                                    <label for="username"> Username <span style="color:red">*</span> </label>
                                    <input type="text" class="form-control mb-2" name="username" id="username" />

                                    <label for="email"> Email <span style="color:red">*</span> </label>
                                    <input type="email" name="email" id="email" class="form-control mb-2" />

                                    <label for="password"> Password <span style="color:red">*</span> </label>
                                    <input type="password" name="password" id="password" class="form-control mb-2" />

                                    <label for="konfirmasiPassword"> Konfirmasi password <span style="color:red">*</span>
                                    </label>
                                    <input type="password" name="konfirmasiPassword" id="konfirmasiPassword"
                                        class="form-control mb-2" />

                                    <label for="role"> Role <span style="color:red">*</span> </label>
                                    <select class="form-select mb-3" aria-label="Default select example" name="role"
                                        id="role">
                                        <option id="roleDefault" value="TIDAK MEMILIH ROLE" selected>Pilih</option>
                                        <option value="1">Admin</option>
                                        <option value="0">User</option>
                                    </select>

                                    <small style="font-size: 10px;">Catatan: formulir dengan tanda <span
                                            style="color: red">*</span> wajib diisi <span class="ms-5"> <button
                                                type="button" id="clearBtn">clear</button> </span> </small>

                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                    style="width: 100%; height: 100%;">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="closeModalBtn">Batalkan</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary"> <span
                            class="spinner-border spinner-border-sm me-1" id="submitSpinner"
                            style="display: none;"></span> Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editAkunModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> Edit Akun </h2>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                                <section id="serverError" style="display: none;">
                                    <h2 class="p-5" style="color: red;"> SERVER ERROR </h2>
                                </section>

                                <section id="serverSuccess">
                                    <form class="p-3" id="editDataForm">

                                        <input type="hidden" name="edit_csrfHidden" id="edit_csrfHidden"
                                            value="{{ csrf_token() }}" />

                                        <input type="hidden" name="edit_hiddenId" id="edit_hiddenId">

                                        <label for="edit_username"> Username <span style="color:red">*</span> </label>
                                        <input type="text" class="form-control mb-2" name="edit_username"
                                            id="edit_username" />

                                        <label for="edit_email"> Email <span style="color:red">*</span> </label>
                                        <input type="email" name="edit_email" id="edit_email"
                                            class="form-control mb-2" />

                                        <button type="button" class="btn btn-primary form-control mb-2"
                                            id="ubahPasswordBtn"> Ubah password? </button>
                                        <section id="newPassword" style="display:none;">
                                            <label for="edit_password"> Password <span style="color:red">*</span> </label>
                                            <input type="password" name="edit_password" id="edit_password"
                                                class="form-control mb-2" />

                                            <label for="edit_konfirmasiPassword"> Konfirmasi password <span
                                                    style="color:red">*</span>
                                            </label>
                                            <input type="password" name="edit_konfirmasiPassword"
                                                id="edit_konfirmasiPassword" class="form-control mb-2" />
                                        </section>

                                        <label for="edit_role"> Role <span style="color:red">*</span> </label>
                                        <select class="form-select mb-3" aria-label="Default select example"
                                            name="edit_role" id="edit_role">
                                            <option id="edit_roleDefault" value="TIDAK MEMILIH ROLE" selected>Pilih
                                            </option>
                                            <option value="1" id="edit_role_admin">Admin</option>
                                            <option value="0" id="edit_role_user">User</option>
                                        </select>

                                        <small style="font-size: 10px;">Catatan: formulir dengan tanda <span
                                                style="color: red">*</span> wajib diisi <span class="ms-5"> <button
                                                    type="button" id="edit_clearBtn">clear</button> </span> </small>

                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                    style="width: 100%; height: 100%;">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" id="edit_closeModalBtn">Batalkan</button>
                    <button type="submit" id="edit_submitBtn" class="btn btn-primary"> <span
                            class="spinner-border spinner-border-sm me-1" id="edit_submitSpinner"
                            style="display: none;"></span> Submit</button>
                </div>
                </form>
                </section>
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
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/main.js') }}"></script>
@endsection
