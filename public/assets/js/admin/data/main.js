document.addEventListener('DOMContentLoaded', function () {

    function loadTable() {
        $.ajax({
            url: '/admin/data/getData',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // console.log(response.data)
                $('tbody').html('');
                var count = 0;
                $.each(response.data, function (key, item) {
                    var i = ++count;
                    $('tbody').append(" <tr>\
                                <td>"+ i + "</td>\
                                <td>"+ item.updated_at + "</td>\
                                <td>"+ item.witel + "</td>\
                                <td>"+ item.id_valins + "</td>\
                                <td><a href='"+item.eviden1+"' target='_blank'> <img\
                                            src='https://drive.google.com/uc?id="+item.id_eviden1+"' id='evidenImg1'\
                                            alt='Image'  style='width: 200px'> </a></td>\
                                <td><a href='"+item.eviden2+"' target='_blank'> <img\
                                            src='https://drive.google.com/uc?id="+item.id_eviden2+"' id='evidenImg1'\
                                            alt='Image'  style='width: 200px'> </a></td>\
                                <td><a href='"+item.eviden3+"' target='_blank'> <img\
                                            src='https://drive.google.com/uc?id="+item.id_eviden3+"' id='evidenImg1'\
                                            alt='Image'  style='width: 200px'> </a></td>\
                                <td>"+item.id_valins_lama+"</td>\
                                <td>"+item.approve_aso+"</td>\
                                <td>"+item.keterangan_aso+"</td>\
                                <td>"+item.ram3+"</td>\
                                <td>"+item.keterangan_ram3+"</td>\
                                <td>"+item.rekon+"</td>\
                                <td align='center'> <div class='row'>\
                                <div class='col-md-3'></div>\
                                <div class='col-md-2'>\
                                    <button class='btn btn-warning' type='button'\
                                        style='color: white;' data-data-id=" + item.id + " id='btnEdit'> Edit\
                                    </button>\
                                </div>\
                                <div class='col-md-6'>\
                                    <button class='btn btn-danger' type='button' data-data-id=" + item.id + " data-username=" + item.username + " id='btnHapus'> Hapus\
                                    </button>\
                                </div>\
                            </div> </td>\
                                ");
                });
                console.log('berhasil refresh table!');
            }
        })
    }


    $('#uploadExcelQuestion').on('click', function () {

        console.log('BERHASIL');
        //lakukan sesuatu

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
                        if (response.trigger == 'BERHASIL') {
                            const toast = document.getElementById('toast-successCreate')
                            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast);
                            toastBootstrap.show();
                            $('#submitBtn').prop('disabled', false);
                            $('#submitSpinner').hide();
                            $('#formWitel_default').prop('default', true);
                            $('#formIdValins').val('');
                            $('#formEviden1').val('');
                            $('#formEviden2').val('');
                            $('#formEviden3').val('');
                            $('#formIdValinsLama').val('');
                            $('#formRekon_default').prop('default', true);
                            $('#closeModalBtn').click();
                            loadTable();
                            $('#tableData').DataTable();
                            exit();
                        }
                    }
                });
            });

        }, 2000);

    });

});
