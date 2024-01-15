@extends('layouts.user.mainlayout')
@section('title')
    Data
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/admin/dataTables.bootstrap4.min.css') }}">
    <style>
        #uploadExcelQuestion {
            cursor: pointer
        }
    </style>
@endsection
@section('content')
    <div class="card bg-light m-4 rounded shadow border-0">
        @if (Session::get('role') == 1)
            <div class="card-header p-4 d-flex">
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#tambahDataModal"> <span
                        class="me-1">
                        <i class="fas fa-plus-circle fa-lg">
                        </i> </span> Tambah Data </button>
                <form id="excelForm" action="{{ url('/excelhandle') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="hiddenCsrfUpload" value="{{ csrf_token() }}">
                    <button type="button" class="btn btn-success" id="btnUploadExcelBtn"><i
                            class="fa-solid fa-file-excel fa-lg me-2"></i><span>Upload Excel</span></button>
                    <input type="file" name="file" id="file" accept=".xlsx" style="display: none;" />
                    <button type="submit" id="btnUploadSubmit" style="display:none"></button>
                </form>
                <span class="ms-2 mt-2" align="center" id="uploadExcelQuestion"> <i
                        class="fa-solid fa-circle-question fa-xl"></i> </span>
            </div>
        @endif
        {{-- <div class="card-header p-4">
            <h1> THIS SECTION IS FOR FILTERS </h1>
        </div> --}}
        <div class="card-body">
            <button type="button" class="btn btn-success mb-3" id="refresh"><i class="fa-solid fa-arrows-rotate me-1"
                    id="refreshIcon"></i> Refresh </button>
            {{-- <button type="button" class="btn btn-secondary mb-3" id="historyBtn"><i
                    class="fa-solid fa-clock-rotate-left"></i>
                History </button> --}}

            <section id="loadTableSection" style="display: block" class="mt-5 mb-5">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" style="width: 5rem; height: 5rem;" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </section>

            <section id="tableSection" style="display: none">
                <div class="table-responsive">
                    <table id="tableData" style="width:100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> Tambah Data </h2>
                </div>
                <div class="modal-body">

                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">

                                <form class="p-3" id="tambahDataForm">

                                    <input type="hidden" name="csrfHidden" id="csrfHidden" value="{{ csrf_token() }}" />

                                    <label for="formWitel"> Witel <span style="color:red"> * </span> </label>
                                    <select name="formWitel" id="formWitel" class="form-control mb-2">
                                        <option value="TIDAK MEMILIH WITEL" id="formWitel_default" default> Pilih
                                        </option>
                                        <option value="BANDUNG"> Bandung </option>
                                        <option value="BANDUNG BARAT"> Bandung Barat </option>
                                        <option value="CIREBON"> Cirebon </option>
                                        <option value="KARAWANG"> Karawang </option>
                                        <option value="SUKABUMI"> Sukabumi </option>
                                        <option value="TASIKMALAYA"> Tasikmalaya </option>
                                    </select>

                                    <label for="formIdValins"> ID Valins <span style="color:red"> * </span> </label>
                                    <input type="number" name="formIdValins" id="formIdValins" class="form-control mb-2" />

                                    <label for="formEviden1"> Eviden 1 <span style="color:red"> * </span> </label>
                                    <textarea name="formEviden1" id="formEviden1" cols="10" rows="2" class="form-control mb-2"></textarea>

                                    <label for="formEviden2"> Eviden 2 </label>
                                    <textarea name="formEviden2" id="formEviden2" cols="10" rows="2" class="form-control mb-2"></textarea>

                                    <label for="formEviden3"> Eviden 3 </label>
                                    <textarea name="formEviden3" id="formEviden3" cols="10" rows="2" class="form-control mb-2"></textarea>

                                    <label for="formIdValinsLama"> ID Valins Lama </label>
                                    <input type="number" name="formIdValinsLama" id="formIdValinsLama"
                                        class="form-control mb-2" />

                                    <label for="formRekon"> Rekon <span style="color:red"> * </span> </label>
                                    <select name="formRekon" id="formRekon" class="form-control mb-2">
                                        <option value="TIDAK MEMILIH REKON" id="formRekon_default" default> Pilih
                                        </option>
                                        <option value="JANUARI"> Januari </option>
                                        <option value="FEBRUARI"> Februari </option>
                                        <option value="MARET"> Maret </option>
                                        <option value="APRIL"> April </option>
                                        <option value="MEI"> Mei </option>
                                        <option value="JUNI"> Juni </option>
                                        <option value="JULI"> Juli </option>
                                        <option value="AGUSTUS"> Agustus </option>
                                        <option value="SEPTEMBER"> September </option>
                                        <option value="OKTOBER"> Oktober </option>
                                        <option value="NOVEMBER"> November </option>
                                        <option value="DESEMBER"> Desember </option>
                                    </Select>

                                    <small style="font-size: 10px;">Catatan: formulir dengan tanda <span
                                            style="color: red">*</span> wajib diisi <span class="ms-5"> <button
                                                type="button" id="clearBtn">clear</button> </span> </small>

                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/img/auth/telkom-mini-logo.png') }}"
                                    style="width: 100%; height: 80%;">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
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
    <div class="modal fade" id="editDataModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> Edit Data: <span id="idValins_here"></span> </h2>
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
                                        <input type="hidden" name="edit_dataId" id="edit_dataId">
                                        <input type="hidden" name="edit_hiddenIdValins" id="edit_hiddenIdValins">

                                        <label for="edit_formWitel"> Witel <span style="color:red"> * </span> </label>
                                        <select name="edit_formWitel" id="edit_formWitel" class="form-control mb-2">
                                            <option value="TIDAK MEMILIH WITEL" id="edit_formWitel_default" default> Pilih
                                            </option>
                                            <option value="BANDUNG" id="witel_BANDUNG"> Bandung </option>
                                            <option value="BANDUNG BARAT" id="witel_BANDUNGBARAT"> Bandung Barat
                                            </option>
                                            <option value="CIREBON" id="witel_CIREBON"> Cirebon </option>
                                            <option value="KARAWANG" id="witel_KARAWANG"> Karawang </option>
                                            <option value="SUKABUMI" id="witel_SUKABUMI"> Sukabumi </option>
                                            <option value="TASIKMALAYA" id="witel_TASIKMALAYA"> Tasikmalaya </option>
                                        </select>

                                        <label for="edit_formIdValins"> ID Valins <span style="color:red"> * </span>
                                        </label>
                                        <input type="number" name="edit_formIdValins" id="edit_formIdValins"
                                            class="form-control mb-2" />

                                        <label for="edit_formEviden1"> Eviden 1 <span style="color:red"> * </span>
                                        </label>
                                        <textarea name="edit_formEviden1" id="edit_formEviden1" cols="10" rows="2" class="form-control mb-2"></textarea>

                                        <label for="edit_formEviden2"> Eviden 2 </label>
                                        <textarea name="edit_formEviden2" id="edit_formEviden2" cols="10" rows="2" class="form-control mb-2"></textarea>

                                        <label for="edit_formEviden3"> Eviden 3 </label>
                                        <textarea name="edit_formEviden3" id="edit_formEviden3" cols="10" rows="2" class="form-control mb-2"></textarea>

                                        <label for="edit_formIdValinsLama"> ID Valins Lama </label>
                                        <input type="number" name="edit_formIdValinsLama" id="edit_formIdValinsLama"
                                            class="form-control mb-2" />

                                        <label for="edit_formRekon"> Rekon <span style="color:red"> * </span> </label>
                                        <select name="edit_formRekon" id="edit_formRekon" class="form-control mb-2">
                                            <option value="TIDAK MEMILIH REKON" id="edit_formRekon_default" default> Pilih
                                            </option>
                                            <option value="JANUARI" id="rekon_JANUARI"> Januari </option>
                                            <option value="FEBRUARI" id="rekon_FEBRUARI"> Februari </option>
                                            <option value="MARET" id="rekon_MARET"> Maret </option>
                                            <option value="APRIL" id="rekon_APRIL"> April </option>
                                            <option value="MEI" id="rekon_MEI"> Mei </option>
                                            <option value="JUNI" id="rekon_JUNI"> Juni </option>
                                            <option value="JULI" id="rekon_JULI"> Juli </option>
                                            <option value="AGUSTUS" id="rekon_AGUSTUS"> Agustus </option>
                                            <option value="SEPTEMBER" id="rekon_SEPTEMBER"> September </option>
                                            <option value="OKTOBER" id="rekon_OKTOBER"> Oktober </option>
                                            <option value="NOVEMBER" id="rekon_NOVEMBER"> November </option>
                                            <option value="DESEMBER" id="rekon_DESEMBER"> Desember </option>
                                        </Select>

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
                <div class="modal-footer">
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

    <!-- Modal Upload Excel Question -->
    <div class="modal fade" id="excelQuestionModal" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> Tutorial upload data Excel </h2>
                </div>
                <div class="modal-body m-4">

                    <ul>
                        <li> Tekan tombol <span style="color: green; font-weight: bold;"> Upload Excel </span> </li>
                        <li> Tipe file yang di upload harus ber-tipe <span style="font-weight: bold;"> .XLSX </span> </li>
                        <li> Pastikan file <span style="font-weight: bold;"> .XLSX </span> memiliki heading row dengan
                            kolom yang sesuai: </li>
                        <ul style="font-style: italic;">
                            <li>timestamp</li>
                            <li>witel</li>
                            <li>id_valins</li>
                            <li>eviden_1</li>
                            <li>eviden_2</li>
                            <li>id_valins_lama</li>
                            <li>eviden_3</li>
                            <li>approve_aso</li>
                            <li>ket_aso</li>
                            <li>ram3</li>
                            <li>rekon</li>
                            <li>ket_ram3</li>
                        </ul>
                        <img src="https://cdn.discordapp.com/attachments/758697084039462913/1174198887062438008/image.png?ex=6566b8ee&is=655443ee&hm=e7d2c089abb802bbf9ded6abbc804ef262c4eee0c91cfdf9fdb6f81797ecfb65&"
                            alt="Gagal memuat gambar" class="form-control mt-2">
                        <button class="btn btn-success mt-2" id="downloadBtn"><span><i
                                    class="fa-solid fa-download fa-fade me-2"></i></span> Download Template </button>
                        <li class="mt-2"> Jika upload file sukses dan sudah sesuai format, maka anda telah berhasil!
                        </li>
                    </ul>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        id="edit_closeModalBtn">Tutup</button>
                </div>
                </section>
            </div>
        </div>
    </div>

    <!-- Modal History -->
    <div class="modal animate__animated animate__slideInUp animate__faster" id="historyModal" data-bs-backdrop="static"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h2> <i class="fa-solid fa-clock-rotate-left ms-5"></i> History </h2>
                </div>
                <div class="modal-body m-4">

                    <ul>
                        <li> Tekan tombol <span style="color: green; font-weight: bold;"> Upload Excel </span> </li>
                        <li> Tipe file yang di upload harus ber-tipe <span style="font-weight: bold;"> .XLSX </span> </li>
                        <li> Pastikan file <span style="font-weight: bold;"> .XLSX </span> memiliki heading row dengan
                            kolom yang sesuai: </li>
                        <ul style="font-style: italic;">
                            <li>timestamp</li>
                            <li>witel</li>
                            <li>id_valins</li>
                            <li>eviden_1</li>
                            <li>eviden_2</li>
                            <li>id_valins_lama</li>
                            <li>eviden_3</li>
                            <li>approve_aso</li>
                            <li>ket_aso</li>
                            <li>ram3</li>
                            <li>rekon</li>
                            <li>ket_ram3</li>
                        </ul>
                        <img src="https://cdn.discordapp.com/attachments/758697084039462913/1174198887062438008/image.png?ex=6566b8ee&is=655443ee&hm=e7d2c089abb802bbf9ded6abbc804ef262c4eee0c91cfdf9fdb6f81797ecfb65&"
                            alt="Gagal memuat gambar" class="form-control mt-2">
                        <button class="btn btn-success mt-2" id="downloadBtn"><span><i
                                    class="fa-solid fa-download fa-fade me-2"></i></span> Download Template </button>
                        <li class="mt-2"> Jika upload file sukses dan sudah sesuai format, maka anda telah berhasil!
                        </li>
                    </ul>

                </div>
                <div class="modal-footer" style="margin-top: -3%;">
                    <button type="button" class="btn btn-secondary" id="history_closeModalBtn">Tutup</button>
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
                    <h6> Lengkapi form! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningIDValinsDuplikat">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> ID Valins terdeteksi duplikat! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-warning border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-warningURLTidakValid">
            <div class="d-flex">
                <i class="fa fa-circle-exclamation fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Format URL tidak valid! </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-dangerGagalCreate">
            <div class="d-flex">
                <i class="fa-solid fa-circle-xmark fa-fade fa-2xl"></i>
                <div class="toast-body">
                    <h6> Data gagal ditambahkan! coba lagi nanti </h6>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="toast-successCreate">
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
            aria-atomic="true" id="toast-successUpdate">
            <div class="d-flex">
                <i class="fa-solid fa-check fa-fade fa-2xl mt-2 ms-2"></i>
                <div class="toast-body">
                    <h6> Berhasil diupdate! </h6>
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
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/pengguna/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        var error = '{{ Session('excelNotValid') }}';
        var previewStatus = '{{ Session('batalkan_status') }}';
        var previewSubmit = '{{ Session('excelStatus') }}';
        var role = '{{ Session('role') }}';

        console.log(previewStatus);
        if (error) {
            console.log(error);
        }
        // if(previewStatus) return console.log(previewStatus);
        $('.evidenImg').on('error', function() {
            $(this).parent('a').removeAttr('href');
        });
        $(function() {
            $(document).ready(function() {
                $('#tableData').DataTable();
            });
        });

        function excelNotValid() {
            Swal.fire({
                title: "GAGAL",
                text: "File excel tidak sesuai dengan format sistem!",
                icon: "error",
                showCancelButton: true,
                confirmButtonColor: "#212529bf",
                cancelButtonColor: "#198754",
                confirmButtonText: "Lihat tutorial",
                cancelButtonText: "Tutup"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.DismissReason.cancel
                    setTimeout(() => {
                        $('#excelQuestionModal').modal('show');
                    }, 500);
                }
            });
        }

        function excelSubmit() {
            let timerInterval;
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("Ditutup");
                }
            });
        }
        (error ? excelNotValid() : '')
        (previewSubmit ? excelSubmit() : '')
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/admin/data/main.js') }}"></script>
@endsection
