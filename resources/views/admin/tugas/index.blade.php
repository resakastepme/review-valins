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

    <!-- Modal List Lihat -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="kerjakanModal" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-body m-4">

                    <section id="loadLihat" style="display: block" class="mt-5 mb-5">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </section>

                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="acor1Btn">
                                <button class="accordion-button" type="button">
                                    Tabel data belum di review
                                </button>
                            </h2>
                            <div id="acor-content" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body">
                                    <strong>This is the first item's accordion body.</strong> It is shown by default, until
                                    the collapse plugin adds the appropriate classes that we use to style each element.
                                    These classes control the overall appearance, as well as the showing and hiding via CSS
                                    transitions. You can modify any of this with custom CSS or overriding our default
                                    variables. It's also worth noting that just about any HTML can go within the
                                    <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="">
                    <button type="button" class="btn btn-secondary" id="closeKerjakanModalBtn">Tutup</button>
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
