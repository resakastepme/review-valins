var timeoutGlobal = setTimeout(() => { }, 10000); // 10 seconds
// ACCORDION BEGIN

$(document).on('click', '#acor1Btn', function () {
    $('#acor-content').addClass('collapsing');
    setTimeout(() => {
        $('#acor-content').removeClass('show');
        $('#acor-content').removeClass('collapsing');
        $(this).attr('id', 'acor1customed');
    }, 500);
});

$(document).on('click', '#acor1customed', function () {
    $('#acor-content').addClass('collapsing');
    setTimeout(() => {
        $('#acor-content').addClass('show');
        $('#acor-content').removeClass('collapsing');
        $(this).attr('id', 'acor1Btn');
    }, 500);
});

// ACCORDION END

var appUrl = "{{ url('/') }}";
var page = window.location.hash.replace('#', '');
$('li[aria-label="pagination.previous"]').remove();
$('a[aria-label="pagination.next"]').parent('li').remove();
setTimeout(() => {
    $('.pagination li').find('span').parent('li').removeClass('active');
    $('.pagination li').find('span').remove().html(
        '<a class="page-link" href="' + appUrl + '/admin/tugas?page=1">1</a>');
    $('.pagination li:first').html(
        '<a class="page-link" href="' + appUrl + '/admin/tugas?page=1">1</a>');
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

// {{{{{{{{{{{{{{{{{{{{{{ DOM CONTENT LOADED }}}}}}}}}}}}}}}}}}}}}}}}}}}}}

$(document).ready(function () {
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

    $(document).on('click', '#kerjakanListsBtn', function () {
        var id = $(this).data('id');
        $('#kerjakanModal').removeClass('animate__slideOutDown animate__faster');
        $('#kerjakanModal').addClass('animate__slideInUp animate__faster');
        $('#kerjakanModal').modal('show');
    });

    $('#closeKerjakanModalBtn').on('click', function () {
        $('#kerjakanModal').removeClass('animate__slideInUp animate__faster');
        $('#kerjakanModal').addClass('animate__slideOutDown animate__faster');
        setTimeout(function () {
            $('#kerjakanModal').modal('hide');
        }, 500);
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

});
