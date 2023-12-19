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
        // console.log(id);
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

});
