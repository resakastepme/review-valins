const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
var appUrl = "{{ url('/') }}";
var page = window.location.hash.replace('#', '');
$('li[aria-label="pagination.previous"]').remove();
$('a[aria-label="pagination.next"]').parent('li').remove();
setTimeout(() => {
    $('.pagination li').find('span').parent('li').removeClass('active');
    $('.pagination li').find('span').remove().html(
        '<a class="page-link" href="' + appUrl + '/admin/beriTugas?page=1">1</a>');
    $('.pagination li:first').html(
        '<a class="page-link" href="' + appUrl + '/admin/beriTugas?page=1">1</a>');
    if (page == 1) {
        $('.pagination li:first').addClass('active');
    }
}, 500);

$(window).on('hashchange', function () {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getData(page);
        }
    }
});

$(document).on('click', '.pagination a', function (event) {
    event.preventDefault();
    $('li').removeClass('active');
    $(this).parent('li').addClass('active');
    var myurl = $(this).attr('href');
    var page = $(this).attr('href').split('page=')[1];
    getData(page);
});

function getData(page) {
    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
    })
        .done(function (data) {
            $("#paginationAjax").empty().html(data);
            location.hash = page;
        })
        .fail(function (jqXHR, ajaxOptions, thrownError) {
            alert('Tidak ada respon dari server');
        });
}
var countResult;
var unique_quick;
var timeoutGlobal = setTimeout(() => { }, 10000); // 10 seconds
var timeoutListEdit = setTimeout(() => { }, 10000); // 10 seconds
function quickResult(callback) {
    var quickTimestamp = $('#quickTimestamp').val();
    var quickWitel = $('#quickWitel').val();
    var quickRekon = $('#quickRekon').val();
    var quickAso = $('#quickAso').val();
    var quickKetASO = $('#quickKetASO').val();
    var quickRAM3 = $('#quickRAM3').val();
    var quickKetRAM3 = $('#quickKetRAM3').val();
    $.ajax({
        url: '/admin/beriTugas/quick',
        type: 'GET',
        data: {
            _token: $('input[name="_token"]').val(),
            quickTimestamp: quickTimestamp,
            quickWitel: quickWitel,
            quickRekon: quickRekon,
            quickAso: quickAso,
            quickKetASO: quickKetASO,
            quickRAM3: quickRAM3,
            quickKetRAM3: quickKetRAM3
        }, success: function (response) {
            console.log(response.status);
            if (response.status == 'query success') {
                if (response.count != 0) {
                    countResult = response.count;
                    unique_quick = response.unique;
                    $('#querySuccess').css('display', 'block');
                    $('#countData').html('');
                    $('#countData').html(response.count + ' TOTAL DATA');
                    $('#placeholderMax').attr('placeholder', 'max: ' + response.count);
                    $('#quickResultModal').removeClass('animate__slideOutDown animate__faster');
                    $('#quickResultModal').addClass('animate__slideInUp animate__faster');
                    $('#quickResultModal').modal('show');
                } else {
                    $('#queryZero').css('display', 'block');
                    $('#quickResultModal').removeClass('animate__slideOutDown animate__faster');
                    $('#quickResultModal').addClass('animate__slideInUp animate__faster');
                    $('#quickResultModal').modal('show');
                }
            } else {
                console.log(response.status)
            }
        }
    });
    setTimeout(function () {
        callback();
    }, 2000);
}
function quickResultSubmit(callback) {
    var jumlahData = $('#placeholderMax').val();
    var assign = $('#assignForm').val();
    var komentar = $('#komentarForm').val();
    setTimeout(function () {
        if (jumlahData <= 0 || !jumlahData) {
            const toast = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#placeholderMax').focus();
            $('#btnSubmitForm').prop('disabled', false);
            $('#submitSpinner').hide();
            return;
        }
        if (jumlahData > countResult) {
            $('#countCustomDiv').html('');
            $('#countCustomDiv').html('<h6> Maksimal jumlah data adalah ' + countResult + ' </h6>');
            const toast = document.getElementById('toast-warningLengkapiForm3');
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#placeholderMax').focus();
            $('#btnSubmitForm').prop('disabled', false);
            $('#submitSpinner').hide();
            return;
        }
        if (assign == 'null') {
            const toast = document.getElementById('toast-warningLengkapiForm2')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#assignForm').focus();
            $('#btnSubmitForm').prop('disabled', false);
            $('#submitSpinner').hide();
            return;
        }

        $.ajax({
            url: '/admin/beriTugas/quickAssign',
            type: 'GET',
            data: {
                _token: $('input[name="_token"]').val(),
                jumlahData: jumlahData,
                assign: assign,
                komentar: komentar,
                unique: unique_quick
            }, success: function (response) {
                clearTimeout(timeoutGlobal)
                console.log(response.status);
                if (response.status == 'ok') {
                    $('#quick_closeModalBtn').click();
                    let timerInterval;
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        timer: 3500,
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
                            console.log(response.unique + '✅');
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: 'Hubungi pengembang dan berikan error code ini: ' + response.status,
                        icon: "error"
                    });
                }
            },
            // error: function (error) {
            //     console.error('Error:', error);
            // }
        });

        callback();
    }, 1000);
}
function loadLists(callback) {
    var page = window.location.hash.replace('#', '');
    $('#loadTableLists').show();
    $('#paginationLinks').addClass('d-none');
    $('#paginationAjax').hide();
    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
    }).done(function (data) {
        setTimeout(function () {
            $('#loadTableLists').hide();
            $('#paginationLinks').removeClass('d-none');
            $('#paginationAjax').show();
            $("#paginationAjax").empty().html(data);
            callback();
        }, 2000);
        location.hash = page;
    }).fail(function (jqXHR, ajaxOptions, thrownError) {
        alert('Tidak ada respon dari server');
    });

}
function loadSelectiveTable(callback) {
    var timestamp = $('#selectiveTimestamp').val();
    var rekon = $('#selectiveRekon').val();
    var num = 0;

    var table = $('#tableSelective').DataTable({
        ajax: {
            url: '/admin/beriTugas/selectiveGet',
            type: 'GET',
            processing: true,
            serverSide: true,
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                timestamp: timestamp,
                rekon: rekon
            },
            dataSrc: function (response) {
                console.log(response.status);
                callback();
                return response.data;
            }
        },
        "columns": [
            {
                data: null,
                render: function () {
                    ++num;
                    return num;
                },
                title: "No"
            },
            {
                data: "id_valins",
                title: "ID Valins"
            }, {
                data: "id_valins_lama",
                title: "ID Valins Lama"
            }, {
                data: "keterangan_aso",
                title: "Keterangan ASO"
            }, {
                data: "approve_aso",
                title: "Approve ASO"
            }, {
                data: "keterangan_ram3",
                title: "Keterangan RAM3"
            }, {
                data: "ram3",
                title: "RAM3"
            }, {
                data: "rekon",
                title: "Rekon"
            },
            {
                data: null,
                render: function (row) {
                    return '<button class="btn btn-success add-btn ms-1" type="button" id="checkBtnSelective" \
                    data-hidden-idvalins="' + row.id_valins + '" \
                    data-hidden-timestamp="'+ row.updated_at + '" \
                    data-hidden-idvalinslama="'+ row.id_valins_lama + '" \
                    data-hidden-ketaso="'+ row.keterangan_aso + '" \
                    data-hidden-aso="'+ row.approve_aso + '" \
                    data-hidden-ketram3="'+ row.keterangan_ram3 + '" \
                    data-hidden-ram3="'+ row.ram3 + '" \
                    data-hidden-rekon="'+ row.rekon + '" \
                    data-hidden-rowid="'+ row.id + '"> \
                    <i class="fa-solid fa-circle-plus fa-lg"> </i> </button>'
                },
                title: "Tambah"
            }
        ]
    })

    table.on('init.dt', function (e) {
        table.page(0).draw(false);
    });

}

var selectedSelective = [];
$(document).on('click', '#checkBtnSelective', function () {
    var table = $('#tableSelective').DataTable();
    var row = $(this).closest('tr');
    var currentPage = table.page();
    var info = table.row(row).index();
    var dataWithIndex = $.extend({}, table.row(row).data(), { index: info });

    // selectedSelective.push(dataWithIndex);
    console.log(selectedSelective);

    var id_valins = this.dataset.hiddenIdvalins;
    var rekon = this.dataset.hiddenRekon;

    var alreadyExists = selectedSelective.some(function (item) {
        return item.id_valins == id_valins && item.rekon == rekon;
    });

    if (!alreadyExists) {
        selectedSelective.push(dataWithIndex);
        $('#tableAddSelective').DataTable().clear().destroy();
        tableAddSelective();

        const toast_username = document.getElementById('toast-successAddSelective')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
        toastBootstrap.show();
        showAddedSelective();
        return;
    } else {
        const toast_username = document.getElementById('toast-warningSelectiveAlreadyExists')
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
        toastBootstrap.show();
        showAddedSelective();
        return;
    }

    // table.row(row).remove().draw(false);
    // table.page(currentPage).draw(false);

    // $(this).prop('disabled', true);
    // $(this).html('');
    // $(this).html('<i class="fa-solid fa-check fa-lg"></i>');
});

function tableAddSelective() {
    var i = 0;
    $('#tableAddSelective').DataTable({
        data: selectedSelective,
        width: 200,
        columns: [
            // {
            //     data: null,
            //     render: function (data) {
            //         return (data.index + 1);
            //     },
            //     title: "No"
            // },
            {
                data: null,
                render: function () {
                    ++i;
                    return i;
                },
                title: "No"
            }
            ,
            {
                data: null,
                render: function (data) {
                    return data.id_valins;
                },
                title: "ID Valins"
            },
            {
                data: null,
                render: function (data) {
                    return data.rekon;
                },
                title: "Rekon"
            },
            {
                data: null,
                render: function (data) {
                    return '<button class="btn btn-danger add-btn ms-1" type="button" id="removeBtnSelective" \
                    data-hidden-idvalins="' + data.id_valins + '" \
                    data-hidden-timestamp="'+ data.updated_at + '" \
                    data-hidden-idvalinslama="'+ data.id_valins_lama + '" \
                    data-hidden-ketaso="'+ data.keterangan_aso + '" \
                    data-hidden-aso="'+ data.approve_aso + '" \
                    data-hidden-ketram3="'+ data.keterangan_ram3 + '" \
                    data-hidden-ram3="'+ data.ram3 + '" \
                    data-hidden-rekon="'+ data.rekon + '" \
                    data-hidden-rowid="'+ data.id + '" \
                    data-hidden-index="'+ data.index + '">\
                    <i class="fa-solid fa-square-minus fa-lg"></i> </button>'
                },
                title: "Kurangi"
            }
        ]
    });
}

$(document).on('click', '#removeBtnSelective', function () {

    // let id_valinsToRemove = 2;
    // selectedSelective = selectedSelective.filter(item => item.id_valins !== id_valinsToRemove);

    var id_valinsToRemove = this.dataset.hiddenIdvalins;
    var rekonToRemove = this.dataset.hiddenRekon;

    selectedSelective = selectedSelective.filter(function (item) {
        if (item.id_valins == id_valinsToRemove && item.rekon == rekonToRemove) {
            return false;
        } else {
            return true;
        }
    });

    showAddedSelective();
    $('#tableAddSelective').DataTable().clear().destroy();
    tableAddSelective();

});

function showAddedSelective() {
    if (selectedSelective.length == 0) {
        $('#selectiveSelectedExists').hide();
    } else {
        $('#selectiveSelectedExists').show();
        $('#countDataSelective').html('');
        $('#countDataSelective').html(selectedSelective.length + ' TOTAL DATA');
        $('#placeholderMaxSelective').attr('placeholder', 'max: ' + selectedSelective.length);
    }
    // console.log(selectedSelective.length);
}

function selectiveResultSubmit(callback) {
    var jumlahData = $('#placeholderMaxSelective').val();
    var assign = $('#assignFormSelective').val();
    var komentar = $('#komentarFormSelective').val();
    setTimeout(function () {
        if (jumlahData <= 0 || !jumlahData) {
            const toast = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#placeholderMaxSelective').focus();
            $('#btnSubmitFormSelective').prop('disabled', false);
            $('#submitSpinnerSelective').hide();
            return;
        }
        if (jumlahData > selectedSelective.length) {
            $('#countCustomDiv').html('');
            $('#countCustomDiv').html('<h6> Maksimal jumlah data adalah ' + selectedSelective.length + ' </h6>');
            const toast = document.getElementById('toast-warningLengkapiForm3');
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#placeholderMaxSelective').focus();
            $('#btnSubmitFormSelective').prop('disabled', false);
            $('#submitSpinnerSelective').hide();
            return;
        }
        if (assign == 'null') {
            const toast = document.getElementById('toast-warningLengkapiForm2')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#assignFormSelective').focus();
            $('#btnSubmitFormSelective').prop('disabled', false);
            $('#submitSpinnerSelective').hide();
            return;
        }

        $.ajax({
            url: '/admin/beriTugas/selectiveAssign',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                jumlahData: selectedSelective.length,
                assign: assign,
                komentar: komentar,
                datas: selectedSelective
            }, success: function (response) {
                clearTimeout(timeoutGlobal)
                console.log(response.status);
                if (response.status == 'ok') {
                    $('#quick_closeSelectiveModalBtn').click();
                    let timerInterval;
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil!",
                        timer: 3500,
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
                            console.log('✅');
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: 'Hubungi pengembang dan berikan error code ini: ' + response.status,
                        icon: "error"
                    });
                }
            },
            // error: function (error) {
            //     console.error('Error:', error);
            // }
        });

        callback();
    }, 1000);
}

function tableLihat(id, callback) {
    var num = 0;
    var table = $('#tableLihat').DataTable({
        ajax: {
            url: '/admin/beriTugas/lihat',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                id: id
            },
            dataSrc: function (response) {
                console.log(response.status);


                $('#lihatTotalData').html('');
                $('#lihatTotalData').html(response.datas.length + ' TOTAL DATA');

                $('#lihatTotalSelesai').html('');
                $('#lihatTotalSelesai').html(response.selesai + ' Data selesai');

                $('#lihatTotalBelumSelesai').html('');
                $('#lihatTotalBelumSelesai').html(response.belum + ' Data belum selesai');

                $('#tugasDari').html('');
                $('#tugasDari').html(response.assignment.get_users.username);
                $('#reviewer').html('');
                $('#reviewer').html(response.assignment.get_reviewer.username);

                let date = new Date(response.assignment.updated_at);
                let formattedDate = date.toISOString().split('T')[0];
                $('#tanggal').html('');
                $('#tanggal').html(formattedDate);

                $('#komentar_lihat').val('');
                $('#komentar_lihat').val(response.assignment.komentar);

                callback();
                // console.log(response.datas[0].get_data);
                return response.datas;
            }
        },
        "columns": [
            {
                data: null,
                render: function () {
                    ++num;
                    return num;
                },
                title: "No"
            },
            {
                data: null,
                render: function (item) {
                    return item.get_data.id_valins;
                },
                title: "ID Valins"
            },
            {
                data: null,
                render: function (item) {
                    return item.get_data.id_valins_lama;
                },
                title: "ID Valins Lama"
            }, {
                data: null,
                render: function (item) {
                    return item.get_data.keterangan_aso;
                },
                title: "Keterangan ASO"
            }, {
                data: null,
                render: function (item) {
                    return item.get_data.approve_aso;
                },
                title: "Approve ASO"
            }, {
                data: null,
                render: function (item) {
                    return item.get_data.keterangan_ram3;
                },
                title: "Keterangan RAM3"
            }, {
                data: null,
                render: function (item) {
                    return item.get_data.ram3;
                },
                title: "RAM3"
            }, {
                data: null,
                render: function (item) {
                    return item.get_data.rekon;
                },
                title: "Rekon"
            }, {
                data: null,
                render: function (item) {
                    if (item.finish == 0) {
                        return '<div class="row d-flex justify-content-center align-items-center"><i class="fa-solid fa-xmark" title="Belum selesai"></i></div>';
                    } else {
                        return '<div class="row d-flex justify-content-center align-items-center"><i class="fa-solid fa-check" title="Selesai"></i></div>';
                    }
                },
                title: "Selesai"
            }
        ]
    });
}

document.addEventListener('DOMContentLoaded', function () {

    $('#listsRefresh').prop('disabled', true);
    $('#refreshIcon').addClass('fa-spin-pulse');
    $('#listsRefresh1').prop('disabled', true);
    $('#refreshIcon1').addClass('fa-spin-pulse');
    loadLists(function () {
        $('#listsRefresh').prop('disabled', false);
        $('#refreshIcon').removeClass('fa-spin-pulse');
        $('#listsRefresh1').prop('disabled', false);
        $('#refreshIcon1').removeClass('fa-spin-pulse');
    });

    $('#beriTugasQuickForm').on('submit', function (e) {
        e.preventDefault();
        $('#submitQuickBtn').prop('disabled', true);
        $('#submitQuickBtn').html('');
        $('#submitQuickBtn').append('<span class="spinner-border spinner-border-sm text-light me-2" role="status"></span> Filter');
        quickResult(function () {
            $('#submitQuickBtn').prop('disabled', false);
            $('#submitQuickBtn').html('');
            $('#submitQuickBtn').append('<i class="fa-brands fa-get-pocket" id="getDataIcon"></i> Filter');
        });
    });

    $('#quick_closeModalBtn').on('click', function () {
        $('#quickResultModal').removeClass('animate__slideInUp animate__faster');
        $('#quickResultModal').addClass('animate__slideOutDown animate__faster');
        $.ajax({
            url: '/admin/beriTugas/yeet',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                unique: unique_quick
            }, success: function (response) {
                if (response.status == 'ok') {
                    console.log("Session YEET");
                } else {
                    console.log('Session not yeet');
                }
            }
        })
        setTimeout(function () {
            $('#quickResultModal').modal('hide');
            $('#querySuccess').css('display', 'none');
            $('#queryZero').css('display', 'none');
            $('#quickResultForm')[0].reset();
            $('#btnSubmitForm').prop('disabled', false);
            $('#submitSpinner').hide();
        }, 500);
    });

    $('#quickResultForm').on('submit', function (e) {
        e.preventDefault();

        $('#btnSubmitForm').prop('disabled', true);
        $('#submitSpinner').show();

        quickResultSubmit(function () {
            $('#btnSubmitForm').prop('disabled', false);
            $('#submitSpinner').hide();
            $('#listsRefresh').prop('disabled', true);
            $('#refreshIcon').addClass('fa-spin-pulse');
            $('#listsRefresh1').prop('disabled', true);
            $('#refreshIcon1').addClass('fa-spin-pulse');
            loadLists(function () {
                $('#listsRefresh').prop('disabled', false);
                $('#refreshIcon').removeClass('fa-spin-pulse');
                $('#listsRefresh1').prop('disabled', false);
                $('#refreshIcon1').removeClass('fa-spin-pulse');
            });
        });

    });
    $(document).on('click', '#listsRefresh', function () {
        $('#listsRefresh').prop('disabled', true);
        $('#refreshIcon').addClass('fa-spin-pulse');
        loadLists(function () {
            $('#listsRefresh').prop('disabled', false);
            $('#refreshIcon').removeClass('fa-spin-pulse');
        });
    });
    $(document).on('click', '#listsRefresh1', function () {
        $('#listsRefresh1').prop('disabled', true);
        $('#refreshIcon1').addClass('fa-spin-pulse');
        loadLists(function () {
            $('#listsRefresh1').prop('disabled', false);
            $('#refreshIcon1').removeClass('fa-spin-pulse');
        });
    });
    $('#beriTugasSelectiveForm').on('submit', function (e) {
        e.preventDefault();

        $('#submitSelectiveBtn').prop('disabled', true);
        $('#submitSelectiveBtn').html('');
        $('#submitSelectiveBtn').append('<span class="spinner-border spinner-border-sm text-light me-2" role="status"></span> Filter');

        loadSelectiveTable(function () {
            clearTimeout(timeoutGlobal);
            $('#selectiveModal').removeClass('animate__slideOutDown animate__faster');
            $('#selectiveModal').addClass('animate__slideInUp animate__faster');
            $('#selectiveModal').modal('show');
            $('#submitSelectiveBtn').prop('disabled', false);
            $('#submitSelectiveBtn').html('');
            $('#submitSelectiveBtn').append('<i class="fa-brands fa-get-pocket" id="selectiveIcon"></i> Filter');
        });
        showAddedSelective();
        tableAddSelective();

    });

    $('#quick_closeSelectiveModalBtn').on('click', function () {
        $('#selectiveModal').removeClass('animate__slideInUp animate__faster');
        $('#selectiveModal').addClass('animate__slideOutDown animate__faster');
        selectedSelective.length = 0;
        // console.log($('#tableSelective').DataTable().page());
        setTimeout(() => {
            $('#tableAddSelective').DataTable().clear().destroy();
            $('#tableSelective').DataTable().clear().destroy();
            $('#selectiveModal').modal('hide');
            $('#selectiveResultForm')[0].reset();
        }, 500);
    });

    $('#selectiveResultForm').on('submit', function (e) {
        e.preventDefault();

        $('#btnSubmitFormSelective').prop('disabled', true);
        $('#submitSpinnerSelective').show();

        selectiveResultSubmit(function () {
            $('#btnSubmitFormSelective').prop('disabled', false);
            $('#submitSpinnerSelective').hide();
            $('#listsRefresh').prop('disabled', true);
            $('#refreshIcon').addClass('fa-spin-pulse');
            $('#listsRefresh1').prop('disabled', true);
            $('#refreshIcon1').addClass('fa-spin-pulse');
            loadLists(function () {
                $('#listsRefresh').prop('disabled', false);
                $('#refreshIcon').removeClass('fa-spin-pulse');
                $('#listsRefresh1').prop('disabled', false);
                $('#refreshIcon1').removeClass('fa-spin-pulse');
            });
        });

    });

    $(document).on('click', '#lihatListsBtn', function () {
        var id = $(this).data('id');
        $('#lihatModal').removeClass('animate__slideOutDown animate__faster');
        $('#lihatModal').addClass('animate__slideInUp animate__faster');
        $('#lihatLoaded').hide();
        $('#loadLihat').show();
        $('#lihatModal').modal('show');
        tableLihat(id, function () {
            clearTimeout(timeoutGlobal);
            $('#lihatLoaded').show();
            $('#loadLihat').hide();
        });
    });

    $('#closeLihatModalBtn').on('click', function () {
        $('#lihatModal').removeClass('animate__slideInUp animate__faster');
        $('#lihatModal').addClass('animate__slideOutDown animate__faster');
        setTimeout(() => {
            $('#tableLihat').DataTable().clear().destroy();
            $('#lihatModal').modal('hide');
        }, 500);
    });

    function tableEdit(id, access, callback) {
        var num = 0;
        var table = $('#tableEdit').DataTable({
            ajax: {
                url: '/admin/beriTugas/edit',
                type: 'GET',
                data: {
                    _token: $('meta[name="csrf_token"]').attr('content'),
                    id: id
                },
                dataSrc: function (response) {
                    console.log(response.status);

                    $.get('/getUsername', function (getUsername) {
                        // console.log(getUsername.username);

                        $('#editTotalData').html('');
                        $('#editTotalData').html(response.datas.length + ' TOTAL DATA');

                        $('#editTotalSelesai').html('');
                        $('#editTotalSelesai').html(response.selesai + ' Data selesai');

                        $('#editTotalBelumSelesai').html('');
                        $('#editTotalBelumSelesai').html(response.belum + ' Data belum selesai');

                        $('#edit_tugasDari').val('');
                        $('#edit_tugasDari').val(response.assignment.get_users.username);

                        if (access == 'granted') {
                            $('#edit_reviewer').prop('disabled', false);
                            $('#edit_komentar').prop('readonly', false);
                            $('#submitEditLists').prop('disabled', false);
                            $('#hiddenInputEdit').val('');
                            $('#hiddenInputEdit').val(id);
                        } else {
                            $('#edit_reviewer').prop('disabled', true);
                            $('#edit_komentar').prop('readonly', true);
                            $('#submitEditLists').prop('disabled', true);
                            $('#hiddenInputEdit').val('');
                        }

                        $('#reviewer' + response.assignment.get_reviewer.id).prop('selected', true);

                        let date = new Date(response.assignment.updated_at);
                        let formattedDate = date.toISOString().split('T')[0];
                        $('#edit_tanggal').val('');
                        $('#edit_tanggal').val(formattedDate);

                        $('#edit_komentar').val('');
                        $('#edit_komentar').val(response.assignment.komentar);

                    });

                    callback();
                    // console.log(response.datas[0].get_data);
                    return response.datas;
                }
            },
            "columns": [
                {
                    data: null,
                    render: function () {
                        ++num;
                        return num;
                    },
                    title: "No"
                },
                {
                    data: null,
                    render: function (item) {
                        return item.get_data.id_valins;
                    },
                    title: "ID Valins"
                },
                {
                    data: null,
                    render: function (item) {
                        return item.get_data.id_valins_lama;
                    },
                    title: "ID Valins Lama"
                }, {
                    data: null,
                    render: function (item) {
                        return item.get_data.keterangan_aso;
                    },
                    title: "Keterangan ASO"
                }, {
                    data: null,
                    render: function (item) {
                        return item.get_data.approve_aso;
                    },
                    title: "Approve ASO"
                }, {
                    data: null,
                    render: function (item) {
                        return item.get_data.keterangan_ram3;
                    },
                    title: "Keterangan RAM3"
                }, {
                    data: null,
                    render: function (item) {
                        return item.get_data.ram3;
                    },
                    title: "RAM3"
                }, {
                    data: null,
                    render: function (item) {
                        return item.get_data.rekon;
                    },
                    title: "Rekon"
                }, {
                    data: null,
                    render: function (item) {
                        if (item.finish == 0) {
                            return '<div class="row d-flex justify-content-center align-items-center"><i class="fa-solid fa-xmark" title="Belum selesai"></i></div>';
                        } else {
                            return '<div class="row d-flex justify-content-center align-items-center"><i class="fa-solid fa-check" title="Selesai"></i></div>';
                        }
                    },
                    title: "Selesai"
                }
            ]
        });
    }

    $(document).on('click', '#editListsBtn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/admin/beriTugas/editValidation',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                id: id
            }, success: function (response) {
                // console.log(response.access);
                clearTimeout(timeoutListEdit);
                if (response.access == 'granted') {
                    $('#editModal').removeClass('animate__slideOutDown animate__faster');
                    $('#editModal').addClass('animate__slideInUp animate__faster');
                    $('#editLoaded').hide();
                    $('#loadEdit').show();
                    $('#editModal').modal('show');
                    tableEdit(id, response.access, function () {
                        clearTimeout(timeoutGlobal);
                        $('#editLoaded').show();
                        $('#loadEdit').hide();
                    });
                } else {
                    $('#editModal').removeClass('animate__slideOutDown animate__faster');
                    $('#editModal').addClass('animate__slideInUp animate__faster');
                    $('#editLoaded').hide();
                    $('#usernameNotMatch').show();
                    $('#editModal').modal('show');
                    tableEdit(id, response.access, function () {
                        clearTimeout(timeoutGlobal);
                        $('#editLoaded').show();
                        $('#loadEdit').hide();
                    });
                }

            }
        })
    });

    $('#closeEditModalBtn').on('click', function () {
        $('#editModal').removeClass('animate__slideInUp animate__faster');
        $('#editModal').addClass('animate__slideOutDown animate__faster');
        setTimeout(() => {
            $('#usernameNotMatch').hide();
            $('#editModal').modal('hide');
            $('#tableEdit').DataTable().clear().destroy();
        }, 500);
    });

    $('#listEditForm').on('submit', function (e) {
        e.preventDefault();
        var id = $('#hiddenInputEdit').val();
        var reviewer = $('#edit_reviewer').val();
        var komentar = $('#edit_komentar').val();

        $('#submitEditLists').prop('disabled', true);
        $('#submitEditLists').html('');
        $('#submitEditLists').append('<span class="spinner-border spinner-border-sm text-light me-2" role="status"></span> Update');

        if (reviewer == 'null') {
            const toast = document.getElementById('toast-warningLengkapiForm2')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
            toastBootstrap.show();
            $('#edit_reviewer').focus();
            $('#submitEditLists').prop('disabled', false);
            $('#submitEditLists').html('');
            $('#submitEditLists').append('<i class="fa-solid fa-pen-to-square" id="selectiveIcon"></i> Update');
            return;
        }

        Swal.fire({
            title: "Lanjutkan proses?",
            icon: 'question',
            showDenyButton: true,
            confirmButtonText: "Ya",
            denyButtonText: `Batalkan`
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/beriTugas/updateList',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf_token"]').attr('content'),
                        id: id,
                        reviewer: reviewer,
                        komentar: komentar
                    }, success: function (response) {
                        console.log(response.status);

                        clearTimeout(timeoutGlobal);

                        let timerInterval;
                        Swal.fire({
                            title: "Berhasil update!",
                            timer: 2500,
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
                            if (result.dismiss == Swal.DismissReason.timer) {
                                console.log("I was closed by the timer");
                            }
                        });

                        $('#listsRefresh').click();
                        $('#listsRefresh1').click();

                        $('#submitEditLists').prop('disabled', false);
                        $('#submitEditLists').html('');
                        $('#submitEditLists').append('<i class="fa-solid fa-pen-to-square" id="selectiveIcon"></i> Update');
                        $('#closeEditModalBtn').click();
                    }
                });
            } else if (result.isDenied) {
                console.log("Changes are not saved");
                $('#submitEditLists').prop('disabled', false);
                $('#submitEditLists').html('');
                $('#submitEditLists').append('<i class="fa-solid fa-pen-to-square" id="selectiveIcon"></i> Update');
            }
        });

    });

    $(document).on('click', '#hapusListsBtn', function () {
        var id = $(this).data('id');

        $.get('/admin/beriTugas/editValidation', {
            _token: $('meta[name="csrf_token"]').attr('content'),
            id: id
        }, function (response) {
            console.log(response.access);
            if (response.access == 'granted') {
                Swal.fire({
                    title: "Anda yakin akan menghapus tugas ini?",
                    text: "Anda tidak bisa memulihkan tugas ini lagi!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batalkan"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '/admin/beriTugas/hapusList',
                            type: 'GET',
                            data: {
                                _token: $('meta[name="csrf_token"]').attr('content'),
                                id: id
                            }, success: function (response) {
                                console.log(response.status);

                                clearTimeout(timeoutGlobal);

                                if (response.status == 'ok') {
                                    let timerInterval;
                                    Swal.fire({
                                        title: "Berhasil dihapus!",
                                        icon: 'success',
                                        timer: 2500,
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
                                        if (result.dismiss == Swal.DismissReason.timer) {
                                            console.log("I was closed by the timer");
                                        }
                                    });

                                    $('#listsRefresh').click();
                                    $('#listsRefresh1').click();
                                } else {
                                    Swal.fire({
                                        title: "Error || Hubungi pengembang!",
                                        text: response.status,
                                        icon: "error"
                                    });
                                }

                            }
                        });

                    }
                });
            } else {
                Swal.fire({
                    title: "Akses ditolak!",
                    text: "Anda tidak dapat menghapus tugas yang bukan anda buat!",
                    icon: "error"
                });
            }
        });

    });

});

// tableSelective();
// function tableSelective() {
//     $(document).on('click', '#checkBtnSelective', function () {
//         console.log(this.dataset.hiddenValue);
//     });
// }
