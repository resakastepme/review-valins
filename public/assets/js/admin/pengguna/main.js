document.addEventListener('DOMContentLoaded', function () {

    function loadTable() {
        $.ajax({
            url: '/admin/pengguna/getUser',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // console.log(response.data)
                $('tbody').html('');
                var count = 0;
                $.each(response.data, function (key, item) {
                    var i = ++count;
                    if (item.role == 1) {
                        var roleConvert = 'Admin';
                    } else {
                        var roleConvert = 'User';
                    }
                    $('tbody').append(" <tr>\
                                <td>"+ i + "</td>\
                                <td>"+ roleConvert + "</td>\
                                <td>"+ item.username + "</td>\
                                <td>"+ item.email + "</td>\
                                <td align='center'> <div class='row'>\
                                <div class='col-md-3'></div>\
                                <div class='col-md-2'>\
                                    <button class='btn btn-warning' type='button'\
                                        style='color: white;' data-user-id=" + item.id + " id='btnEdit'> Edit\
                                    </button>\
                                </div>\
                                <div class='col-md-6'>\
                                    <button class='btn btn-danger' type='button' data-user-id=" + item.id + " id='btnHapus'> Hapus\
                                    </button>\
                                </div>\
                            </div> </td>\
                                ");
                });
                console.log('berhasil refresh table!');
            }
        })
    }

    $('#refresh').on('click', function () {
        $('#refresh').prop('disabled', true);
        $('#refreshIcon').addClass('fa-spin-pulse');

        setTimeout(function () {

            loadTable();

            $('#refresh').prop('disabled', false);
            $('#refreshIcon').removeClass('fa-spin-pulse');
        }, 2000);

    });

    $('#clearBtn').on('click', function () {
        $('#username').val('');
        $('#email').val('');
        $('#password').val('');
        $('#konfirmasiPassword').val('');
        $('#roleDefault').prop('selected', true);
        $('#username').focus();
    });

    $('#edit_clearBtn').on('click', function () {
        $('#edit_username').val('');
        $('#edit_email').val('');
        $('#edit_password').val('');
        $('#edit_konfirmasiPassword').val('');
        $('#edit_roleDefault').prop('selected', true);
        $('#edit_username').focus();
    });

    $('#tambahDataForm').on('submit', function (e) {

        e.preventDefault();

        const username = $('#username').val();
        const email = $('#email').val();
        const password = $('#password').val();
        const konfirmasiPassword = $('#konfirmasiPassword').val();
        const role = $('#role').val();

        if (!username) {
            const toast_username = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_username);
            toastBootstrap.show();
            $('#username').focus();
            exit();
        }
        if (!email) {
            const toast_email = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_email);
            toastBootstrap.show();
            $('#email').focus();
            exit();
        }
        if (!password) {
            const toast_password = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_password);
            toastBootstrap.show();
            $('#password').focus();
            exit();
        }
        if (!konfirmasiPassword) {
            const toast_konfirmasiPassword = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_konfirmasiPassword);
            toastBootstrap.show();
            $('#konfirmasiPassword').focus();
            exit();
        }
        if (role == 'TIDAK MEMILIH ROLE') {
            const toast_role = document.getElementById('toast-warningLengkapiForm')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_role);
            toastBootstrap.show();
            $('#role').focus();
            exit();
        }

        if (password != konfirmasiPassword) {
            const toast_gagalKonfirmasiPassword = document.getElementById('toast-warningKonfirmasiPassword')
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_gagalKonfirmasiPassword);
            toastBootstrap.show();
            $('#password').val('');
            $('#konfirmasiPassword').val('');
            $('#password').focus();
            exit();
        }

        $('#submitBtn').prop('disabled', true);
        $('#submitSpinner').show();

        $.ajax({
            url: '/admin/pengguna/create',
            type: 'GET',
            data: {
                _token: $('#csrfHidden').val(),
                username: username,
                email: email,
                password: password,
                role: role
            }, success: function (response) {

                console.log(response['status']);

                setTimeout(function () {

                    if (response['trigger'] == 'USERNAME SUDAH ADA') {
                        const toast_usernameSudahAda = document.getElementById('toast-warningUsernameSudahAda')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_usernameSudahAda);
                        toastBootstrap.show();
                        $('#username').focus();
                        $('#submitBtn').prop('disabled', false);
                        $('#submitSpinner').hide();
                    }
                    if (response['trigger'] == 'EMAIL SUDAH ADA') {
                        const toast_emailTerdaftar = document.getElementById('toast-warningEmailTerdaftar')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_emailTerdaftar);
                        toastBootstrap.show();
                        $('#email').focus();
                        $('#submitBtn').prop('disabled', false);
                        $('#submitSpinner').hide();
                    }
                    if (response['trigger'] == 'GAGAL') {
                        const toast_gagalTambah = document.getElementById('toast-dangerGagal')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_gagalTambah);
                        toastBootstrap.show();
                        $('#submitBtn').prop('disabled', false);
                        $('#submitSpinner').hide();
                    }
                    if (response['trigger'] == 'BERHASIL') {
                        const toast_berhasil = document.getElementById('toast-success')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_berhasil);
                        toastBootstrap.show();
                        $('#submitBtn').prop('disabled', false);
                        $('#submitSpinner').hide();
                        $("#tablePengguna").load(window.location + " #tablePengguna");
                        $('#tablePengguna').DataTable();
                        $('#closeModalBtn').click();
                        $('#username').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#konfirmasiPassword').val('');
                        $('#roleDefault').prop('selected', true);
                        loadTable();
                    }

                }, 2500);

            }
        })

    });

    $(document).on('click', '#btnEdit', function () {
        $('#editAkunModal').modal('show');
        var userId = $(this).data('user-id');

        $.ajax({
            url: '/admin/pengguna/editIndex',
            type: 'GET',
            data: {
                _token: $('#edit_csrfHidden').val(),
                id: userId
            }, success: function (response) {

                if (response['status'] == 'GAGAL') {
                    $('#serverError').show();
                    $('#serverSuccess').hide();
                    $('#edit_submitBtn').prop('disabled', true);
                    setTimeout(function () {
                        $('#edit_closeModalBtn').click();
                        $('#edit_submitBtn').prop('disabled', false);
                    }, 4000);
                } else {
                    $('#serverError').hide();
                    $('#serverSuccess').show();
                    $('#edit_username').val(response['data']['username']);
                    $('#edit_email').val(response['data']['email']);
                    if (response['data']['role'] == 1) {
                        $('#edit_role').prop('selected', false);
                        $('#edit_role_admin').prop('selected', true);
                    } else {
                        $('#edit_role').prop('selected', false);
                        $('#edit_role_user').prop('selected', true);
                    }
                }

            }
        })

    })

    $('#ubahPasswordBtn').on('click', function () {
        $(this).hide();
        $('#newPassword').show();
    });

    $(document).on('click', '#edit_closeModalBtn', function () {
        $('#editAkunModal').modal('hide');
        setTimeout(function () {
            $('#ubahPasswordBtn').show();
            $('#newPassword').hide();
        }, 1000);
    });

});
