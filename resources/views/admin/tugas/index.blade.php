@extends('layouts.admin.mainlayout')
@section('title')
    Tugas
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
    <script type="text/javascript">
        // IMAGE ZOOM ON HOVER BEGIN
        let images_to_zoom = document.querySelectorAll('.image-hover-zoom img')
        for (let item of images_to_zoom) {
            item.parentElement.style.height = item.height + 'px'
            item.parentElement.style.width = item.width + 'px'
            item.parentElement.style.overflow = 'hidden'
            item.addEventListener('mousemove', (e) => zoom_element(e, item.parentElement.offsetLeft, item
                .parentElement.offsetTop, item.parentElement.offsetWidth, item.parentElement
                .offsetHeight))
            item.addEventListener('mouseenter', function(e) {
                let item = e.currentTarget
                let scale = item.parentElement.getAttribute('scale')
                e.currentTarget.style.transform = scale ? 'scale(' + scale + ')' : 'scale(1.5)'
            })
            item.addEventListener('mouseleave', function(e) {
                e.currentTarget.style.transform = 'none'
            })
        }

        function zoom_element(e, start_x, start_y, width, height) {
            let p_x = (e.clientX - start_x) * 100 / width
            let p_y = (e.clientY - start_y) * 100 / height
            e.currentTarget.style.transformOrigin = p_x + "% " + p_y + "%"
        }
        // IMAGE ZOOM ON HOVER END
    </script>
@endsection
@section('content')
    <div class="container mb-3 mt-3">

        <button id="testBtn"> Click me! </button>

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

                    <section class="mt-3" id="reviewCard" style="display: none; height: 800px;">
                        <div class="row">
                            <div class="col">

                                <section id="loadReviewCard" style="display: none;">
                                    <div class="d-flex justify-content-center align-items-center 100vh">
                                        <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </section>

                                <section id="haventChooseData" style="display: block;">
                                    <div class="card shadow rounded border-0" style="height: 800px;">
                                        <div class="card-body d-flex justify-content-center align-items-center 100vh">

                                            <h1 class="text-center"> Silahkan pilih data </h1>

                                        </div>
                                    </div>
                                </section>

                                {{-- <a href="https://drive.google.com/open?id=1a9MfNNk8R2S2vC_VlD8YmRHCKUw27isC"
                                    target="blank">
                                    <div class="image-hover-zoom" scale="2.0">
                                        <img src="https://drive.google.com/uc?id=1a9MfNNk8R2S2vC_VlD8YmRHCKUw27isC"
                                            alt="Error/tidak ada image">
                                    </div>
                                </a> --}}

                                <section id="dataChoosed" style="display: none;">

                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-md-7 mb-2">
                                            <div class="card shadow rounded border-0" style="height: 800px;">
                                                {{-- 610px --}}
                                                <div class="card-body d-flex justify-content-center align-items-center 100vh"
                                                    id="imageViewer">

                                                    <section id="loadImage" style="display: none;">
                                                        <div
                                                            class="d-flex justify-content-center align-items-center 100vh">
                                                            <div class="spinner-border" style="width: 5rem; height: 5rem;"
                                                                role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </div>
                                                    </section>

                                                    <section id="imageViewer" style="display: block">
                                                        <p class="text-center"> Silahkan pilih eviden </p>
                                                    </section>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">

                                            <div class="card shadow rounded border-0 p-2">
                                                <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <h6> ID Valins: <br><span style="font-weight: 100;"
                                                                    id="reviewIdValins"> Script error
                                                                </span> </h6>
                                                            <h6> ID Valins Lama: <br><span style="font-weight: 100;"
                                                                    id="reviewIdValinsLama"> Script error
                                                                </span> </h6>
                                                            <h6> Approve ASO: <br><span style="font-weight: 100;"
                                                                    id="reviewApproveAso"> Script error
                                                                </span> </h6>
                                                            <h6> Keterangan ASO: <br><span style="font-weight: 100;"
                                                                    id="reviewKeteranganAso"> Script error
                                                                </span> </h6>
                                                            <h6> Rekon: <br><span style="font-weight: 100;"
                                                                    id="reviewRekon">
                                                                    Script error </span>
                                                            </h6>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6> RAM3: <br><span style="font-weight: 100;"
                                                                    id="reviewRam3">
                                                                    Script error </span>
                                                            </h6>
                                                            <h6> Keterangan RAM3: <br><span style="font-weight: 100;"
                                                                    id="reviewKeteranganRam3">
                                                                    Script error </span> </h6>
                                                        </div>
                                                    </div>


                                                    <hr>

                                                    <h5> Pilih eviden </h5>
                                                    <div class="row d-flex">
                                                        <div class="col" id="reviewEvidenButton">
                                                            Script error
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h5> Review </h5>
                                                    <form id="reviewForm">
                                                        <input type="hidden" id="hiddenIdData">
                                                        <input type="hidden" id="hiddenIdReviewer">
                                                        <label for="reviewFormRam3"> RAM3 </label>
                                                        <select name="reviewFormRam3" id="reviewFormRam3"
                                                            class="form-control mb-2">
                                                            <option value="null" id="selectDefault" default> -- Pilih --
                                                            </option>
                                                            <option value="OK" id="selectOK"> OK </option>
                                                            <option value="NOK" id="selectNOK"> NOK </option>
                                                        </select>
                                                        <label for="reviewFormKeteranganRam3"> Keterangan RAM3 </label>
                                                        <input type="text" class="form-control mb-2"
                                                            name="reviewFormKeteranganRam3" id="reviewFormKeteranganRam3">

                                                        @foreach ($values as $value)
                                                            <button type="button" class="btn btn-secondary mb-1"
                                                                style="height: 25px; font-size: 10px;"
                                                                data-value="{{ $value['keterangan_ram3'] }}"
                                                                id="reviewTemplateBtn"> {{ $value['keterangan_ram3'] }}
                                                            </button>
                                                        @endforeach

                                                        <button type="submit" class="btn btn-primary form-control mt-4"
                                                            id="submitBtn">
                                                            <i class="spinner-border spinner-border-sm me-1"
                                                                style="display: none;" id="loadSubmit"></i>
                                                            Submit
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </section>

                            </div>
                        </div>
                    </section>

                    <section id="sectionDataFinish" class="mt-3">

                        <div class="accordion" id="accordionPanelsStayOpenExample2">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="acor2customed">
                                    <button class="accordion-button" type="button">
                                        <h3> Selesai ✓ </h3>
                                    </button>
                                </h2>
                                <div id="acor-content2" class="accordion-collapse collapse"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">

                                        <div class="table-responsive-lg">
                                            <table class="table table-hover" border="2" id="tableDataFinish">
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

    {{-- TOAST --}}
    <div class="toast-container top-0 end-0 mt-2 me-2 position-fixed">
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successSubmit">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Selesai! </h6>
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
    {{-- <script type="text/javascript">
        $('#test').html('');
        $('#test').html('<a href="https://drive.google.com/open?id=1a9MfNNk8R2S2vC_VlD8YmRHCKUw27isC"\
                                                                                    target="blank">\
                                                                                    <div class="image-hover-zoom" scale="2.0">\
                                                                                        <img src="https://drive.google.com/uc?id=1a9MfNNk8R2S2vC_VlD8YmRHCKUw27isC"\
                                                                                            alt="Error/tidak ada image">\
                                                                                    </div>\
                                                                                </a>');
    </script> --}}
    <script type="text/javascript" src="{{ asset('assets/js/admin/tugas/main.js') }}"></script>
@endsection
