$(document).ready(function () {
    $('#tableDataPreviewError').DataTable();
    $('#tableDataPreviewSuccess').DataTable();
});

$('#batalkan').on('click', function () {
    Swal.fire({
        title: "Batalkan proses?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Kembali"
    }).then((result) => {
        if (result.isConfirmed) {
            $.get('/getRole', function (response) {
                location.href = '/' + response.role + '/data/preview/batal'
            });
        }
    });
});

$('#submitValid').on('click', function () {
    Swal.fire({
        title: "Anda yakin?",
        text: "Sistem hanya akan memproses data valid, lanjutkan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Lanjutkan",
        cancelButtonText: "Batalkan"
    }).then((result) => {
        if (result.isConfirmed) {
            $.get('/getRole', function (response) {
                location.href = '/' + response.role + '/data/preview/submit'
            });
        }
    });
});
