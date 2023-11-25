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
            if (response.count != 0) {
                $('#querySuccess').show();
                $('#queryZero').hide();
                $('#countData').html('');
                $('#countData').html(response.count + ' TOTAL DATA');
                $('#placeholderMax').attr('placeholder', 'max: ' + response.count);
                $('#placeholderMax').attr('max', response.count);
                $('#quickResultModal').removeClass('animate__slideOutDown animate__faster');
                $('#quickResultModal').addClass('animate__slideInUp animate__faster');
                $('#quickResultModal').modal('show');
            } else {
                $('#queryZero').show();
                $('#querySuccess').hide();
                $('#quickResultModal').removeClass('animate__slideOutDown animate__faster');
                $('#quickResultModal').addClass('animate__slideInUp animate__faster');
                $('#quickResultModal').modal('show');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('AJAX request failed:', textStatus, errorThrown);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        console.log('AJAX request failed:', textStatus, errorThrown);
    });
    setTimeout(function () {
        callback();
    }, 2000);
}
document.addEventListener('DOMContentLoaded', function () {
    $('#beriTugasQuickForm').on('submit', function (e) {
        e.preventDefault();
        $('#submitQuickBtn').prop('disabled', true);
        $('#submitQuickBtn').html('');
        $('#submitQuickBtn').append('<span class="spinner-border spinner-border-sm text-light me-2" role="status"></span> Get Data');
        quickResult(function () {
            $('#submitQuickBtn').prop('disabled', false);
            $('#submitQuickBtn').html('');
            $('#submitQuickBtn').append('<i class="fa-brands fa-get-pocket" id="getDataIcon"></i> Get Data');
        });
    });

    $('#quick_closeModalBtn').on('click', function () {
        $('#quickResultModal').removeClass('animate__slideInUp animate__faster');
        $('#quickResultModal').addClass('animate__slideOutDown animate__faster');
        setTimeout(function () {
            $('#quickResultModal').modal('hide');
        }, 500);
    });
});
