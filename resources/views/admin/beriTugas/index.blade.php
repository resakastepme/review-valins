@extends('layouts.admin.mainlayout')
@section('css')
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
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h2> <i class="fa-brands fa-get-pocket"></i></i> Quick </h2>
                </div>
                <div class="modal-body m-4">

                    <h1 id="test"> </h1>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" id="quick_closeModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/beriTugas/main.js') }}"></script>
@endsection
