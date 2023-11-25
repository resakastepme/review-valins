// console.log('TEST');
function refresh(callback) {
    var count = 0;
    var table = $('#tableData').DataTable({
        ajax: {
            url: '/admin/data/refresh',
            dataSrc: ''
        },
        "columns": [
            {
                data: null,
                render: function (row, data, dataIndex) {
                    var i = ++count;
                    return i;
                },
                title: "No"
            },
            {
                data: null,
                render: function (row, data, type) {
                    if (row.updated_at == '' || row.updated_at == 'null' || row.updated_at == 'NULL' || row.updated_at == 'Null' || row.updated_at == null) {
                        var formattedUpdatedAt = '';
                    } else {
                        var updatedAt = new Date(row.updated_at);
                        var formattedUpdatedAt = updatedAt.toISOString().replace('T', ' ').slice(0, -5);
                    }
                    return (formattedUpdatedAt != '' ? formattedUpdatedAt : row.timestamp_bawaan != null ? row.timestamp_bawaan : '<b style="color: red"> ANOMALY </b>');
                },
                title: "Timestamp"
            },
            {
                data: "witel",
                title: "Witel"
            },
            {
                data: "id_valins",
                title: "ID Valins"
            },
            {
                data: null,
                render: function (row) {
                    if (!row.id_eviden1) {
                        return '<td><a target="_blank"> <img src="" class="evidenImg"\
                        alt="Tidak ada Image/Error" style="width: 300px"> </a></td>';
                    } else {
                        return '<td><a href="https://drive.google.com/open?id=' + row.id_eviden1 + '" target="_blank"> <img\
                        src="https://drive.google.com/uc?id='+ row.id_eviden1 + '"\
                        class="evidenImg" alt="Tidak ada Image/Error" style="width: 300px"> </a>\
            </td>';
                    }
                },
                title: "Eviden 1"
            },
            {
                data: null,
                render: function (row) {
                    if (!row.id_eviden2) {
                        return '<td><a target="_blank"> <img src="" class="evidenImg"\
                        alt="Tidak ada Image/Error" style="width: 300px"> </a></td>';
                    } else {
                        return '<td><a href="https://drive.google.com/open?id=' + row.id_eviden2 + '" target="_blank"> <img\
                        src="https://drive.google.com/uc?id='+ row.id_eviden2 + '"\
                        class="evidenImg" alt="Tidak ada Image/Error" style="width: 300px"> </a>\
            </td>';
                    }
                },
                title: "Eviden 2"
            },
            {
                data: null,
                render: function (row) {
                    if (!row.id_eviden3) {
                        return '<td><a target="_blank"> <img src="" class="evidenImg"\
                        alt="Tidak ada Image/Error" style="width: 300px"> </a></td>';
                    } else {
                        return '<td><a href="https://drive.google.com/open?id=' + row.id_eviden3 + '" target="_blank"> <img\
                        src="https://drive.google.com/uc?id='+ row.id_eviden3 + '"\
                        class="evidenImg" alt="Tidak ada Image/Error" style="width: 300px"> </a>\
            </td>';
                    }
                },
                title: "Eviden 3"
            },
            {
                data: "id_valins_lama",
                title: "ID Valins Lama"
            },
            {
                data: null,
                render: function (row) {
                    return (row.approve_aso == 'null' ? '' : row.approve_aso)
                },
                title: "ASO"
            },
            {
                data: "keterangan_aso",
                title: "Ket. ASO"
            },
            {
                data: "ram3",
                title: "RAM3"
            },
            {
                data: "keterangan_ram3",
                title: "Ket. RAM3"
            },
            {
                data: "rekon",
                title: "Rekon"
            },
            {
                data: null,
                render: function (row) {
                    return '<div class="row d-flex align-items-center justify-content-center">\
                    <div class="col-auto mb-1">\
                        <button class="btn btn-warning" type="button" style="color: white;"\
                            data-data-id="'+ row.id + '"\
                            data-valins-id="'+ row.id_valins + '" id="btnEdit"> Edit\
                        </button>\
                    </div>\
                    <div class="col-auto">\
                        <button class="btn btn-danger" type="button"\
                            data-data-id="'+ row.id + '"\
                            data-valins-id="'+ row.id_valins + '" id="btnHapus"> Hapus\
                        </button>\
                    </div>\
                </div>'
                },
                title: "Aksi"
            }
        ]
    });
    console.log('berhasil load table!');
    setTimeout(function () {
        callback();
    }, 2000);
}

function loadTable(){
    $('#refresh').prop('disabled', true);
    $('#refreshIcon').addClass('fa-spin-pulse');
    $('#loadTableSection').show();
    $('#tableSection').hide();
    $('#tableData').DataTable().clear().destroy();
    refresh(function () {
        $('#loadTableSection').hide();
        $('#tableSection').show();
        $('#refresh').prop('disabled', false);
        $('#refreshIcon').removeClass('fa-spin-pulse');
    });
}

document.addEventListener('DOMContentLoaded', function () {

    $('#refresh').prop('disabled', true);
    $('#refreshIcon').addClass('fa-spin-pulse');
    $('#loadTableSection').show();
    $('#tableSection').hide();
    refresh(function () {
        $('#loadTableSection').hide();
        $('#tableSection').show();
        $('#refresh').prop('disabled', false);
        $('#refreshIcon').removeClass('fa-spin-pulse');
    });

    $('#edit_clearBtn').on('click', function () {
        $('#edit_formWitel_default').prop('selected', true);
        $('#edit_formIdValins').val('');
        $('#edit_formEviden1').val('');
        $('#edit_formEviden2').val('');
        $('#edit_formEviden3').val('');
        $('#edit_formIdValinsLama').val('');
        $('#edit_formRekon_default').prop('selected', true);
        $('#edit_formWitel').focus();
    });

    $('#refresh').on('click', function () {
        loadTable();
    });


    $('#uploadExcelQuestion').on('click', function () {

        console.log('BERHASIL');
        $('#excelQuestionModal').modal('show');

    });

    $('#tambahDataForm').on('submit', function (e) {

        e.preventDefault();

        var witel = $('#formWitel').val();
        var idValins = $('#formIdValins').val();
        var eviden1 = $('#formEviden1').val();
        var eviden2 = $('#formEviden2').val();
        var eviden3 = $('#formEviden3').val();
        var idValinsLama = $('#formIdValinsLama').val();
        var rekon = $('#formRekon').val();

        if (witel == "TIDAK MEMILIH WITEL") {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#formWitel').focus();
            exit();
        }
        if (!idValins) {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#formIdValins').focus();
            exit();
        }
        if (!eviden1) {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#formEviden1').focus();
            exit();
        }
        if (rekon == "TIDAK MEMILIH REKON") {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#formRekon').focus();
            exit();
        }

        $('#submitBtn').prop('disabled', true);
        $('#submitSpinner').show();

        setTimeout(function () {
            $.get('/getRole', function (data) {
                var role = data.role;
                // console.log(role);
                $.ajax({
                    url: '/' + role + '/data/create',
                    type: 'POST',
                    data: {
                        _token: $('#csrfHidden').val(),
                        witel: witel,
                        id_valins: idValins,
                        eviden1: eviden1,
                        eviden2: eviden2,
                        eviden3: eviden3,
                        id_valins_lama: idValinsLama,
                        rekon: rekon
                    }, success: (response) => {
                        console.log(response.status);
                        if (response.trigger == 'ID VALINS DUPLIKAT') {
                            const toast = document.getElementById('toast-warningIDValinsDuplikat')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#formIdValins').focus();
                            $('#submitBtn').prop('disabled', false);
                            $('#submitSpinner').hide();
                            exit();
                        }
                        if (response.trigger == 'GAGAL') {
                            const toast = document.getElementById('toast-dangerGagalCreate')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#submitBtn').prop('disabled', false);
                            $('#submitSpinner').hide();
                            exit();
                        }
                        if (response.trigger == 'URL TIDAK VALID') {
                            const toast = document.getElementById('toast-warningURLTidakValid')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#submitBtn').prop('disabled', false);
                            $('#submitSpinner').hide();
                            $('#' + response.eviden).focus();
                            exit();
                        }
                        if (response.trigger == 'BERHASIL') {
                            const toast = document.getElementById('toast-successCreate')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#submitBtn').prop('disabled', false);
                            $('#submitSpinner').hide();
                            $('#formWitel_default').prop('selected', true);
                            $('#formIdValins').val('');
                            $('#formEviden1').val('');
                            $('#formEviden2').val('');
                            $('#formEviden3').val('');
                            $('#formIdValinsLama').val('');
                            $('#formRekon_default').prop('selected', true);
                            $('#closeModalBtn').click();
                            $('#tableData').DataTable().clear().destroy();
                            loadTable();
                        }
                    }
                });
            });

        }, 2000);

    });

    $(document).on('click', '#btnEdit', function () {
        $('#editDataModal').modal('show');
        var dataId = $(this).data('data-id');
        var dataValins = $(this).data('valins-id');
        // console.log(dataId);
        $.get('/getRole', function (data) {
            var role = data.role;
            $.ajax({
                url: '/' + role + '/data/editIndex',
                type: 'GET',
                data: {
                    id: dataId
                }, success: function (response) {
                    console.log(response.status);
                    if (response.status == 'GAGAL') {
                        if (dataValins != null) {
                            $('#idValins_here').html(dataValins);
                        } else {
                            $('#idValins_here').html('?');
                        }
                        $('#serverSuccess').hide();
                        $('#serverError').show();
                        setTimeout(function () {
                            $('#edit_closeModalBtn').click();
                        }, 4000);
                    }
                    if (response.status == 'BERHASIL') {
                        if (dataValins != '') {
                            $('#idValins_here').append(dataValins);
                        } else {
                            $('#idValins_here').append('?');
                        }
                        $('#edit_dataId').val(dataId);
                        $('#edit_hiddenIdValins').val(response.data.id_valins);
                        console.log(dataValins);
                        $('#witel_' + response.data.witel.replace(/\s/g, '')).prop('selected', true);
                        $('#edit_formIdValins').val(response.data.id_valins);
                        $('#edit_formEviden1').val(response.data.eviden1);
                        $('#edit_formEviden2').val(response.data.eviden2);
                        $('#edit_formEviden3').val(response.data.eviden3);
                        $('#edit_formIdValinsLama').val(response.data.id_valins_lama);
                        $('#rekon_' + response.data.rekon).prop('selected', true);
                    }
                }
            });
        });
    });

    $(document).on('click', '#edit_closeModalBtn', function () {
        $('#editDataModal').modal('hide');
        setTimeout(function () {
            $('#edit_formWitel_default').prop('selected', true);
            $('#edit_formIdValins').val('');
            $('#edit_formEviden1').val('');
            $('#edit_formEviden2').val('');
            $('#edit_formEviden3').val('');
            $('#edit_formIdValinsLama').val('');
            $('#edit_formRekon_default').prop('selected', true);
            $('#idValins_here').html('');
        }, 1000);
    });

    $('#editDataForm').on('submit', function (e) {
        e.preventDefault();
        var witel = $('#edit_formWitel').val();
        var idValins = $('#edit_formIdValins').val();
        var eviden1 = $('#edit_formEviden1').val();
        var eviden2 = $('#edit_formEviden2').val();
        var eviden3 = $('#edit_formEviden3').val();
        var idValinsLama = $('#edit_formIdValinsLama').val();
        var rekon = $('#edit_formRekon').val();
        var id = $('#edit_dataId').val();
        var hiddenIdValins = $('#edit_hiddenIdValins').val();

        if (witel == "TIDAK MEMILIH WITEL") {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#edit_formWitel').focus();
            exit();
        }
        if (!idValins) {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#edit_formIdValins').focus();
            exit();
        }
        if (!eviden1) {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#edit_formEviden1').focus();
            exit();
        }
        if (rekon == "TIDAK MEMILIH REKON") {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#edit_formRekon').focus();
            exit();
        }

        $('#edit_submitBtn').prop('disabled', true);
        $('#edit_submitSpinner').show();

        setTimeout(function () {
            $.get('/getRole', function (data) {
                var role = data.role;
                // console.log(role);
                $.ajax({
                    url: '/' + role + '/data/update',
                    type: 'POST',
                    data: {
                        _token: $('#edit_csrfHidden').val(),
                        witel: witel,
                        id_valins: idValins,
                        eviden1: eviden1,
                        eviden2: eviden2,
                        eviden3: eviden3,
                        id_valins_lama: idValinsLama,
                        rekon: rekon,
                        id: id,
                        hiddenIdValins: hiddenIdValins
                    }, success: (response) => {
                        console.log(response.status);
                        console.log(response.trigger);
                        if (response.trigger == 'ID VALINS DUPLIKAT') {
                            const toast = document.getElementById('toast-warningIDValinsDuplikat')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#edit_formIdValins').focus();
                            $('#edit_submitBtn').prop('disabled', false);
                            $('#edit_submitSpinner').hide();
                            exit();
                        }
                        if (response.trigger == 'GAGAL') {
                            const toast = document.getElementById('toast-dangerGagalCreate')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#edit_submitBtn').prop('disabled', false);
                            $('#edit_submitSpinner').hide();
                            exit();
                        }
                        if (response.trigger == 'URL TIDAK VALID') {
                            const toast = document.getElementById('toast-warningURLTidakValid')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#edit_submitBtn').prop('disabled', false);
                            $('#edit_submitSpinner').hide();
                            $('#edit_' + response.eviden).focus();
                            exit();
                        }
                        if (response.trigger == 'BERHASIL') {
                            const toast = document.getElementById('toast-successUpdate')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#edit_submitBtn').prop('disabled', false);
                            $('#edit_submitSpinner').hide();
                            $('#edit_formWitel_default').prop('selected', true);
                            $('#edit_formIdValins').val('');
                            $('#edit_formEviden1').val('');
                            $('#edit_formEviden2').val('');
                            $('#edit_formEviden3').val('');
                            $('#edit_formIdValinsLama').val('');
                            $('#edit_formRekon_default').prop('selected', true);
                            $('#edit_closeModalBtn').click();
                            $('#tableData').DataTable().clear().destroy();
                            loadTable();
                        }
                    }
                });
            });

        }, 2000);
    });

    $(document).on('click', '#btnHapus', function () {
        var userId = $(this).data('data-id');
        var idValins = $(this).data('valins-id');
        var csrfToken = $("meta[name='csrf_token']").attr("content");

        Swal.fire({
            title: 'Anda yakin?',
            text: "Proses menghapus data dengan id valins: " + idValins,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batalkan'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/data/destroy',
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        userId: userId
                    }, success: function (response) {
                        console.log(response.status);
                        if (response.status == 'BERHASIL') {
                            const toast_berhasil = document.getElementById('toast-successDelete')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_berhasil);
                            toastBootstrap.show();
                            $('#tableData').DataTable().clear().destroy();
                            loadTable();
                        } else {
                            const toast_gagalTambah = document.getElementById('toast-dangerGagalHapus')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_gagalTambah);
                            toastBootstrap.show();
                            $('#tableData').DataTable().clear().destroy();
                            loadTable();
                        }
                    }
                });
            } else {
                console.log('Proses dibatalkan!');
            }
        })
    });

    $('#downloadBtn').on('click', function () {
        var parameter = 'DataTemplate'
        location.href = '/download/' + parameter;
    });

    $('#btnUploadExcelBtn').on('click', function () {
        $('#file').click();
    });

    $('#file').on('change', function () {

        $('#btnUploadExcelBtn').prop('disabled', true);
        $('#btnUploadExcelBtn').html('');
        $('#btnUploadExcelBtn').append('<span class="spinner-border spinner-border-sm text-light me-2" role="status"></span> Proses...');
        setTimeout(function () {
            $('#btnUploadSubmit').click();
        }, 1000);
    });

    $('#historyBtn').on('click', function () {
        $('#historyModal').removeClass('animate__animated animate__slideOutDown animate__faster');
        $('#historyModal').addClass('animate__animated animate__slideInUp animate__faster');
        $('#historyModal').modal('show');
    });

    $('#history_closeModalBtn').on('click', function () {
        $('#historyModal').removeClass('animate__animated animate__slideInUp animate__faster');
        $('#historyModal').addClass('animate__animated animate__slideOutDown animate__faster');
        setTimeout(function () {
            $('#historyModal').modal('hide');
        }, 500);
    });

});
