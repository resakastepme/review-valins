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

        var timestamp = $('#selectiveTimestamp').val();
        var rekon = $('#selectiveRekon').val();

        $.ajax({
            url: '/admin/beriTugas/selectiveGet',
            type: 'GET',
            data: {
                _token: $('meta[name="csrf_token"]').attr('content'),
                timestamp: timestamp,
                rekon: rekon
            }, success: function (response) {
                var count = 0;
                $.each(response.data, function (index, item) {
                    ++count;
                    var newRow = $('<tr>');
                    var buttonElement = $('<button class="btn btn-success add-btn ms-1" type="button" id="checkBtnSelective">')
                        .attr('data-hidden-value', item.id);
                    var iconElement = $('<i class="fa-solid fa-circle-plus fa-lg">');
                    buttonElement.append(iconElement);

                    var updatedAt = new Date(item.updated_at);
                    var formattedUpdatedAt = updatedAt.toISOString().replace('T', ' ').slice(0, -5);

                    // Create new td elements for count and item.id_valins
                    var countCell = $('<td>').text(count);
                    var timestamp = $('<td>').text(formattedUpdatedAt);
                    var idValins = $('<td>').text(item.id_valins);
                    var idValinsLama = $('<td>').text(item.id_valins_lama);
                    var ketAso = $('<td>').text(item.keterangan_aso);
                    var aso = $('<td>').text(item.approve_aso);
                    var ketRam3 = $('<td>').text(item.keterangan_ram3);
                    var ram3 = $('<td>').text(item.ram3);
                    var rekon = $('<td>').text(item.rekon);


                    // Append the button cell, count cell, and id_valins cell to the newRow
                    newRow.append($('<td>').append(buttonElement));
                    newRow.append(countCell);
                    newRow.append(timestamp);
                    newRow.append(idValins);
                    newRow.append(idValinsLama);
                    newRow.append(ketAso);
                    newRow.append(aso);
                    newRow.append(ketRam3);
                    newRow.append(ram3);
                    newRow.append(rekon);

                    // Append the new row to the table's tbody
                    $('#tableSelective').children('tbody').append(newRow);
                });


            }
        });

        // var currentPage = 1;
        // var perPage = 10;

        // function fetchData(page) {
        //     $.ajax({
        //         url: '/admin/beriTugas/selectiveGet',
        //         type: 'GET',
        //         data: {
        //             _token: $('meta[name="csrf_token"]').attr('content'),
        //             timestamp: timestamp,
        //             rekon: rekon,
        //             perPage: perPage,
        //             page: page
        //         },
        //         success: function (response) {
        //             updateTable(response.data);
        //             updatePagination(response);
        //         },
        //         error: function (error) {
        //             console.error('Error fetching data:', error);
        //         }
        //     });
        // }

        // function updateTable(data) {
        //     // Clear existing rows
        //     $('#selectiveTable tbody').empty();

        //     // Append new rows based on the current page data
        //     var count = 0;
        //     $.each(data, function (index, item) {
        //         ++count;
        //         var newRow = $('<tr>');
        //         var buttonElement = $('<button class="btn btn-success add-btn ms-1" type="button" id="checkBtnSelective">')
        //             .attr('data-hidden-value', item.id);
        //         var iconElement = $('<i class="fa-solid fa-circle-plus fa-lg">');
        //         buttonElement.append(iconElement);

        //         var updatedAt = new Date(item.updated_at);
        //         var formattedUpdatedAt = updatedAt.toISOString().replace('T', ' ').slice(0, -5);

        //         // Create new td elements for count and item.id_valins
        //         var countCell = $('<td>').text(count);
        //         var timestamp = $('<td>').text(formattedUpdatedAt);
        //         var idValins = $('<td>').text(item.id_valins);
        //         var idValinsLama = $('<td>').text(item.id_valins_lama);
        //         var ketAso = $('<td>').text(item.keterangan_aso);
        //         var aso = $('<td>').text(item.approve_aso);
        //         var ketRam3 = $('<td>').text(item.keterangan_ram3);
        //         var ram3 = $('<td>').text(item.ram3);
        //         var rekon = $('<td>').text(item.rekon);


        //         // Append the button cell, count cell, and id_valins cell to the newRow
        //         newRow.append($('<td>').append(buttonElement));
        //         newRow.append(countCell);
        //         newRow.append(timestamp);
        //         newRow.append(idValins);
        //         newRow.append(idValinsLama);
        //         newRow.append(ketAso);
        //         newRow.append(aso);
        //         newRow.append(ketRam3);
        //         newRow.append(ram3);
        //         newRow.append(rekon);

        //         // Append the new row to the table's tbody
        //         $('#tableSelective').children('tbody').append(newRow);
        //     });

        //     function updatePagination(response) {
        //         $('#pagination-sel').empty();

        //         for (var i = 1; i <= response.last_page; i++) {
        //             var pageLink = $('<a>').text(i);
        //             if (i == response.current_page) {
        //                 pageLink.addClass('active');
        //             }

        //             pageLink.on('click', function () {
        //                 var page = parseInt($(this).text());
        //                 currentPage = page;
        //                 fetchData(page);
        //             });

        //             $('#pagination-sel').append(pageLink);
        //         }
        //     }
        // }

        // fetchData(currentPage);

        $('#selectiveModal').removeClass('animate__slideOutDown animate__faster');
        $('#selectiveModal').addClass('animate__slideInUp animate__faster');
        $('#selectiveModal').modal('show');
    });
    $('#quick_closeSelectiveModalBtn').on('click', function () {
        $('#selectiveModal').removeClass('animate__slideInUp animate__faster');
        $('#selectiveModal').addClass('animate__slideOutDown animate__faster');
        setTimeout(() => {
            $('#selectiveModal').modal('hide');
        }, 500);
    });
});
tableSelective();
function tableSelective() {
    $(document).on('click', '#checkBtnSelective', function () {
        console.log(this.dataset.hiddenValue);
    });
}
