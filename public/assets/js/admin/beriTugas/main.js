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
var dataReview;
var timeoutGlobal = setTimeout(() => { }, 10000); // 10 seconds
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
                    dataReview = response.data;
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
                dataQuery: dataReview
            }, success: function (response) {
                clearTimeout(timeoutGlobal)
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
                            console.log("Berhasil");
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: 'Hubungi pengembang dan berikan error code ini: ' + response.status,
                        icon: "error"
                    });
                }
            }, error: function (error) {
                console.error('Error:', error);
            }
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
});
