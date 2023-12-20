@extends('layouts.admin.mainlayout')
@section('title')
    Tugas
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="container mb-3 mt-3">
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

    <!-- Modal Kerjakan -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="kerjakanModal" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body m-4">

                    <section id="loadKerjakan" style="display: block" class="mt-5 mb-5">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </section>

                    <section id="loadedCard" style="display: none;">
                        <div class="row d-flex justify-content-center mb-3">
                            <div class="col-md-4">

                                <div class="card rounded shadow border-0 mb-2">
                                    <div class="card-body">

                                        <h1 class="mb-3" id="lihatTotalDataKerjakan"
                                            style="color: green; font-weight: bold;"></h1>
                                        <h6 id="lihatTotalSelesaiKerjakan" style="font-style: italic;"></h6>
                                        <h6 id="lihatTotalBelumSelesaiKerjakan" style="font-style: italic;"></h6>

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-8">

                                <div class="card rounded shadow border-0">
                                    <div class="card-body">

                                        <div class="row d-flex">
                                            <div class="col-md-4">
                                                <p> <span style="font-weight: bold;"> Tugas Dari: </span> <span
                                                        id="tugasDariKerjakan" style="font-style: italic;"> Script error
                                                    </span>
                                                </p>
                                                <p> <span style="font-weight: bold;"> Reviewer: </span> <span
                                                        id="reviewerKerjakan" style="font-style: italic;">Script
                                                        error</span>
                                                </p>
                                                <p> <span style="font-weight: bold;"> Tanggal: </span> <span
                                                        id="tanggalKerjakan" style="font-style: italic;">Script error</span>
                                                </p>
                                            </div>
                                            <div class="col-md-8">
                                                <h6> <span style="font-weight: bold;"> Komentar: </span> </h6>
                                                <textarea name="komentar_lihatKerjakan" id="komentar_lihatKerjakan" class="form-control" rows="3" readonly>Script error</textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                    <section id="loadedKerjakan" style="display: none;">
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="acor1Btn">
                                    <button class="accordion-button" type="button">
                                        <h3> Data </h3>
                                    </button>
                                </h2>
                                <div id="acor-content" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">

                                        <div class="table-responsive-lg">
                                            <table class="table table-hover" border="2" id="tableKerjakanData">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mt-3" id="reviewCard">
                        <div class="row">
                            <div class="col">

                                <div class="card shadow rounded border-0">
                                    <div class="card-body">

                                        <h1 class="text-center"> Silahkan pilih data </h1>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
                <div class="modal-footer" style="">
                    <button type="button" class="btn btn-secondary" id="closeKerjakanModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal List Lihat -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="lihatModal" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> <i class="fa-solid fa-eye"></i> Lihat </h2>
                </div>
                <div class="modal-body m-4">

                    {{-- <h1 id="testo"> TEST </h1> --}}

                    <section id="loadLihat" style="display: block" class="mt-5 mb-5">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </section>

                    <section id="lihatLoaded" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card shadow rounded border-0 mb-3">
                                    <div class="card-body">
                                        <div class="table-responsive-lg">
                                            <table class="table table-hover" border="2" id="tableLihat">
                                                <thead>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">

                                <div class="card rounded shadow border-0 mb-2">
                                    <div class="card-body">

                                        <h3 id="lihatTotalData" style="color: green; font-weight: bold;"></h3>
                                        <h6 id="lihatTotalSelesai" style="font-style: italic;"></h6>
                                        <h6 id="lihatTotalBelumSelesai" style="font-style: italic;"></h6>

                                    </div>
                                </div>

                                <div class="card rounded shadow border-0">
                                    <div class="card-body">

                                        <p> <span style="font-weight: bold;"> Tugas Dari: </span> <span id="tugasDari"
                                                style="font-style: italic;"> Script error </span> </p>
                                        <p> <span style="font-weight: bold;"> Reviewer: </span> <span id="reviewer"
                                                style="font-style: italic;">Script error</span> </p>
                                        <p> <span style="font-weight: bold;"> Tanggal: </span> <span id="tanggal"
                                                style="font-style: italic;">Script error</span> </p>
                                        <h6> <span style="font-weight: bold;"> Komentar: </span> </h6>
                                        <textarea name="komentar_lihat" id="komentar_lihat" class="form-control" rows="3" readonly>Script error</textarea>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </section>

                </div>
                <div class="modal-footer" style="">
                    <button type="button" class="btn btn-secondary" id="closeLihatModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/tugas/main.js') }}"></script>
@endsection
