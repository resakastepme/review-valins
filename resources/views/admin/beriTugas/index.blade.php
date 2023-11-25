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
                                <option value="null" default>-</option>
                                @foreach ($updated_at as $data)
                                    @if ($data['year'] != null)
                                        <option value="{{ $data['year'] }}"> {{ $data['year'] }} </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickWitel"> Witel </label>
                            <select class="form-control" name="quickWitel" id="quickWitel">
                                <option value="null" default>-</option>
                                @foreach ($witel as $data)
                                    @if ($data['witel'] != null)
                                        <option value="{{ $data['witel'] }}"> {{ $data['witel'] }} </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickRekon"> Rekon </label>
                            <select class="form-control" name="quickRekon" id="quickRekon">
                                <option value="null" default>-</option>
                                @foreach ($rekon as $data)
                                    @if ($data['rekon'] != null)
                                        <option value="{{ $data['rekon'] }}"> {{ $data['rekon'] }} </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickAso"> Approve ASO </label>
                            <select class="form-control" name="quickAso" id="quickAso">
                                <option value="null" default>-</option>
                                <option value="OK"> OK </option>
                                <option value="NOK"> NOK </option>
                            </select>

                            <label class="mt-2" for="quickKetASO"> Keterangan ASO </label>
                            <select class="form-control" name="quickKetASO" id="quickKetASO">
                                <option value="null" default>-</option>
                                @foreach ($keterangan_aso as $data)
                                    @if ($data['keterangan_aso'] != null && $data['keterangan_aso'] != '-')
                                        <option value="{{ $data['keterangan_aso'] }}"> {{ $data['keterangan_aso'] }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>

                            <label class="mt-2" for="quickRAM3"> RAM3 </label>
                            <select class="form-control" name="quickRAM3" id="quickRAM3">
                                <option value="null" default>-</option>
                                <option value="OK"> OK </option>
                                <option value="NOK"> NOK </option>
                            </select>

                            <label class="mt-2" for="quickKetRAM3"> Keterangan RAM3 </label>
                            <select class="form-control" name="quickKetRAM3" id="quickKetRAM3">
                                <option value="null" default>-</option>
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
                                            class="fa-brands fa-get-pocket" id="getDataIcon"></i> Get Data </button>
                                    <button type="reset" class="btn btn-secondary" id="clearQuickFromBtn"> Clear </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
            <div class="col-md-6">

                <div class="card bg-light m-2 rounded shadow border-0">
                    <div class="card-header p-4">
                        <h4> Beri tugas (Selective) </h4>
                    </div>
                    <div class="card-body m-4">

                        <h6> TEST </h6>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row-auto">
        <div class="col-auto">
            <div class="card bg-light m-4 rounded shadow border-0">
                <div class="card-header p-4">
                    <h4> List tugas </h4>
                </div>
                <div class="card-body m-4">
                    <h1> TEST </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Quick Result -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="quickResultModal" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> <i class="fa-brands fa-get-pocket"></i></i> Quick </h2>
                </div>
                <div class="modal-body m-4">

                    <div class="container">
                        <div class="row flex justify-content-center align-items-center">
                            <div class="col-md-6">

                                <section id="querySuccess">
                                    <p style="color: green; font-weight: bold; font-size: 40px;" id="countData">unlimited
                                        data lmao</p>
                                        <h4 style="margin-top: -7%"> Belum ter-assign </h4>

                                    <form>
                                        <label class="mt-2" for="">Masukan jumlah data</label>
                                        <input type="number" class="form-control" id="placeholderMax"
                                            placeholder="max: literally no max lmao" max="1000000000000" required>
                                        <label class="mt-2" for="">Assign data kepada</label>
                                        <select class="form-control">
                                            <option value="null" default>-- Pilih --</option>
                                            <option value="{{ Session::get('username') }}"> Saya
                                                ({{ Session::get('role') == 1 ? 'Admin' : 'User' }}) </option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->username }}">{{ $user->username }}
                                                    ({{ $user->role == 1 ? 'Admin' : 'User' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="form-control btn btn-success mt-4"> Assign Tugas
                                        </button>
                                    </form>
                                </section>
                                <section id="queryZero">
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
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/beriTugas/main.js') }}"></script>
@endsection
