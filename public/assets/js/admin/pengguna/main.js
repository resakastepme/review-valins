document.addEventListener('DOMContentLoaded', function () {

    $('#refresh').on('click', function () {
        $('#refresh').prop('disabled', true);
        $('#refreshIcon').addClass('fa-spin-pulse');

        setTimeout(function () {
            var table = $("#tablePengguna").load(window.location + " #tablePengguna");
            $('#tablePengguna').DataTable();

            // var table = $('#tablePengguna').DataTable({
            //     ajax: "/admin/pengguna/getUser",
            //     column: [
            //         {data: 'role'},
            //         {data: 'username'},
            //         {data: 'email'},
            //     ]
            // }).ajax.reload();

            if (table) {
                console.log('berhasil refresh');
            }
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
                        $('#tambahAkunModal').dispose();
                    }

                }, 2500);

            }
        })

    });

});
