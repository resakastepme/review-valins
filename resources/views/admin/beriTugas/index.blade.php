@extends('layouts.admin.mainlayout')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
@endsection
@section('title')
    Beri Tugas
@endsection
@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-6">

                <div class="card bg-light m-2 rounded shadow border-0">
                    <div class="card-header p-4">
                        <h4> Beri tugas (Quick) </h4>
                    </div>
                    <div class="card-body m-4">
                        <form id="beriTugasQuickForm" method="GET">

                            @csrf

                            <label for="quickTimestamp">Timestamp <span style="font-weight: bold">(tahun)</span></label>
                            <select class="form-control" name="quickTimestamp" id="quickTimestamp">
                                <option value="null" default>Semua</option>
                                @foreach ($updated_at as $data)
                                    @if ($data['year'] != null)
                                        <option value="{{ $data['year'] }}"> {{ $data['year'] }} </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickWitel"> Witel </label>
                            <select class="form-control" name="quickWitel" id="quickWitel">
                                <option value="null" default>Semua</option>
                                @foreach ($witel as $data)
                                    @if ($data['witel'] != null)
                                        <option value="{{ $data['witel'] }}"> {{ $data['witel'] }} </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickRekon"> Rekon </label>
                            <select class="form-control" name="quickRekon" id="quickRekon">
                                <option value="null" default>Semua</option>
                                @foreach ($rekon as $data)
                                    @if ($data['rekon'] != null)
                                        <option value="{{ $data['rekon'] }}"> {{ $data['rekon'] }} </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickAso"> Approve ASO </label>
                            <select class="form-control" name="quickAso" id="quickAso">
                                <option value="semua" default>Semua</option>
                                <option value="kosong"> Kosong </option>
                                <option value="OK"> OK </option>
                                <option value="NOK"> NOK </option>
                            </select>

                            <label class="mt-2" for="quickKetASO"> Keterangan ASO </label>
                            <select class="form-control" name="quickKetASO" id="quickKetASO">
                                <option value="semua" default>Semua</option>
                                <option value="kosong">Kosong</option>
                                @foreach ($keterangan_aso as $data)
                                    @if ($data['keterangan_aso'] != null && $data['keterangan_aso'] != '-')
                                        <option value="{{ $data['keterangan_aso'] }}"> {{ $data['keterangan_aso'] }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickRAM3"> RAM3 </label>
                            <select class="form-control" name="quickRAM3" id="quickRAM3">
                                <option value="semua" default>Semua</option>
                                <option value="kosong"> Kosong </option>
                                <option value="OK"> OK </option>
                                <option value="NOK"> NOK </option>
                            </select>

                            <label class="mt-2" for="quickKetRAM3"> Keterangan RAM3 </label>
                            <select class="form-control" name="quickKetRAM3" id="quickKetRAM3">
                                <option value="semua" default>Semua</option>
                                <option value="kosong">Kosong</option>
                                @foreach ($keterangan_ram3 as $data)
                                    @if ($data['keterangan_ram3'] != null && $data['keterangan_ram3'] != '-')
                                        <option value="{{ $data['keterangan_ram3'] }}"> {{ $data['keterangan_ram3'] }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            <div class="row d-flex mt-4">
                                <div class="col-auto">
                                    <button class="btn btn-success" type="submit" id="submitQuickBtn"> <i
                                            class="fa-brands fa-get-pocket" id="getDataIcon"></i> Filter </button>
                                    <button type="reset" class="btn btn-secondary" id="clearQuickFromBtn"> Clear </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="row-auto">
                    <div class="card bg-light m-2 rounded shadow border-0">
                        <div class="card-header p-4">
                            <h4> Beri tugas (Selective) </h4>
                        </div>
                        <div class="card-body m-4">

                            <form id="beriTugasSelectiveForm">
                                @csrf
                                <label for="selectiveTimestamp">Timestamp <span
                                        style="font-weight: bold">(tahun)</span></label>
                                <select class="form-control" name="selectiveTimestamp" id="selectiveTimestamp">
                                    <option value="null" default>Semua</option>
                                    @foreach ($updated_at as $data)
                                        @if ($data['year'] != null)
                                            <option value="{{ $data['year'] }}"> {{ $data['year'] }} </option>
                                        @endif
                                    @endforeach
                                </select>

                                <label class="mt-2" for="selectiveRekon"> Rekon </label>
                                <select class="form-control" name="selectiveRekon" id="selectiveRekon">
                                    <option value="null" default>Semua</option>
                                    @foreach ($rekon as $data)
                                        @if ($data['rekon'] != null)
                                            <option value="{{ $data['rekon'] }}"> {{ $data['rekon'] }} </option>
                                        @endif
                                    @endforeach
                                </select>

                                <div class="row d-flex mt-4">
                                    <div class="col-auto">
                                        <button class="btn btn-success" type="submit" id="submitSelectiveBtn"> <i
                                                class="fa-brands fa-get-pocket" id="getDataIcon"></i> Filter </button>
                                        <button type="reset" class="btn btn-secondary" id="clearSelectiveFromBtn">
                                            Clear
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="row-auto d-none d-md-block" align="center">
                    <div class="card m-2 bg-light rounded shadow border-0 ">
                        <div class="card-body p-4">
                            <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                style="width: 57%; height: 50%;">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <hr>

    <div class="container mb-3">
        <div class="row-auto">
            <div class="card rounded shadow">
                <div class="card-body">

                    <div class="col-auto">

                        <div class="row">
                            <div class="col-auto d-flex justify-content-start align-items-start">
                                <h4 class="ms-5"> <i class="fa-solid fa-list fa-lg me-2"></i> LIST TUGAS </h4>
                            </div>
                            <div class="col-auto d-flex justify-content-end align-items-right d-none d-md-block">
                                <button type="button" class="btn btn-success" id="listsRefresh"> <i
                                        class="fa-solid fa-arrows-rotate me-1" id="refreshIcon"></i> Refresh </button>
                            </div>
                            <div class="col-auto d-flex justify-content-end align-items-right d-md-none">
                                <button type="button" class="btn btn-success" id="listsRefresh1"> <i
                                        class="fa-solid fa-arrows-rotate me-1" id="refreshIcon1"></i></button>
                            </div>
                        </div>

                        <section id="loadTableLists" style="display: block" class="mt-5 mb-5">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </section>
                        @csrf
                        <section id="paginationAjax" style="display: none">

                        </section>
                        <div class="d-flex justify-content-center align-items-center d-none" id="paginationLinks">
                            {!! $post->links() !!}
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Modal Quick Result -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="quickResultModal"
        data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> <i class="fa-brands fa-get-pocket"></i></i> Quick </h2>
                </div>
                <div class="modal-body m-4">

                    <div class="container">
                        <div class="row flex justify-content-center align-items-center">
                            <div class="col-md-6">

                                <section id="querySuccess" style="display: none">
                                    <p style="color: green; font-weight: bold; font-size: 40px;" id="countData">unlimited
                                        data lmao</p>
                                    <h4 style="margin-top: -7%"> Belum ter-assign </h4>

                                    <form id="quickResultForm" method="POST">
                                        @csrf
                                        <label class="mt-2" for="placeholderMax">Masukan jumlah data <span
                                                style="color: red">* </span></label>
                                        <input type="number" class="form-control" name="placeholderMax"
                                            id="placeholderMax" placeholder="max: literally no max lmao">
                                        <label class="mt-2" for="assignForm">Assign data kepada <span
                                                style="color: red">* </span></label>
                                        <select class="form-control" name="assignForm" id="assignForm">
                                            <option value="null" default>-- Pilih --</option>
                                            <option value="{{ Session::get('username') }}"> Saya
                                                ({{ Session::get('role') == 1 ? 'Admin' : 'User' }}) </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->username }}">{{ $user->username }}
                                                    ({{ $user->role == 1 ? 'Admin' : 'User' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <label class="mt-2" for="komentarForm"> Komentar </label>
                                        <textarea name="komentarForm" id="komentarForm" cols="3" rows="3" class="form-control"
                                            placeholder="Tolong kerjakan ini ya~"></textarea>
                                        <small style="font-size: 10px;">Catatan: formulir dengan tanda <span
                                                style="color: red">*</span> wajib diisi </small>
                                        <button type="submit" id="btnSubmitForm"
                                            class="form-control btn btn-success mt-3"> <span
                                                class="spinner-border spinner-border-sm me-1" id="submitSpinner"
                                                style="display: none;"></span> Assign
                                            Tugas
                                        </button>
                                    </form>
                                </section>
                                <section id="queryZero" style="display: none">
                                    <h4> Total data dari query </h4>
                                    <p style="color: red; font-weight: bold; font-size: 40px;"> 0 DATA </p>
                                    <h4> Periksa kembali filter anda! </h4>
                                </section>

                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                    style="width: 100%; height: 80%;">
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer" style="">
                    <button type="button" class="btn btn-secondary" id="quick_closeModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal Selective -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="selectiveModal" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> <i class="fa-brands fa-get-pocket"></i></i> Selective </h2>
                </div>
                <div class="modal-body m-4">

                    <div class="table-responsive-lg">
                        <table class="table table-hover" border="2" id="tableSelective">
                            <thead>
                                <tr>
                                    <th scope="col">Tambah</th>
                                    <th scope="col">No</th>
                                    <th scope="col">Timestamp</th>
                                    <th scope="col">ID Valins</th>
                                    <th scope="col">ID Valins Lama</th>
                                    <th scope="col">Keterangan ASO</th>
                                    <th scope="col">Approve ASO</th>
                                    <th scope="col">Keterangan RAM3</th>
                                    <th scope="col">RAM3</th>
                                    <th scope="col">Rekon</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- <tr>
                                    <td> <button class="btn btn-success add-btn ms-1" type="button"
                                            data-hidden-value="10" id="checkBtnSelective"> <i class="fa-solid fa-circle-plus fa-lg"></i>
                                        </button> </td>
                                    <td> 1 </td>
                                    <td> 2023 </td>
                                    <td> 1283784342 </td>
                                    <td> 1435435345 </td>
                                    <td> BT >= 50% </td>
                                    <td> NOK </td>
                                    <td> BT >= 50% </td>
                                    <td> NOK </td>
                                    <td> SEPTEMBER </td>
                                </tr>
                                <tr>
                                    <td> <button class="btn btn-success add-btn ms-1" type="button"
                                            data-hidden-value="20" id="checkBtnSelective"> <i class="fa-solid fa-circle-plus fa-lg"></i>
                                        </button> </td>
                                    <td> 2 </td>
                                    <td> 2023 </td>
                                    <td> 28378324 </td>
                                    <td> 324234324 </td>
                                    <td> BT >= 50% </td>
                                    <td> NOK </td>
                                    <td> BT >= 50% </td>
                                    <td> NOK </td>
                                    <td> SEPTEMBER </td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <div class="pagination-sel" id="pagination-sel"></div>
                    </div>
                </div>
                <div class="modal-footer" style="">
                    <button type="button" class="btn btn-secondary" id="quick_closeSelectiveModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>

    {{-- TOAST --}}
    <div class="toast-container top-0 end-0 mt-2 me-2 position-fixed">
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningLengkapiForm">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Jumlah data tidak bisa zero! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningLengkapiForm2">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Silahkan lengkapi form! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningLengkapiForm3">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body" id="countCustomDiv">
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/beriTugas/main.js') }}"></script>
@endsection
