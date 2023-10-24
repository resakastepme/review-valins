document.addEventListener("DOMContentLoaded", function () {
    $('#spinnerLogin').hide();

    $('#loginForm').on('submit', function (e) {

        e.preventDefault();

        $('#btnLogin').prop('disabled', true);
        $('#spinnerLogin').show();

        const username = $('#username').val();
        const password = $('#password').val();

        $.ajax({
            url: '/auth/check',
            type: 'GET',
            data: {
                "_token": "{{ csrf_token() }}",
                'username': username,
                'password': password
            },
            success: function (response) {

                setTimeout(function () {

                    if (response['trigger'] == 'BERHASIL LOGIN') {
                        const toast_success = document.getElementById('toast-successLogin')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_success);
                        toastBootstrap.show();
                        console.log(response['status']);
                    }
                    if (response['trigger'] == 'USERNAME/PASSWORD ERROR') {
                        const toast_fail = document.getElementById('toast-user/userpass')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_fail);
                        toastBootstrap.show();
                        $('#password').val('');
                        $('#username').focus();
                        $('#mainCard').addClass('animate__animated animate__headShake');
                        console.log(response['status']);
                    }
                    if (response['trigger'] == 'FORM TIDAK LENGKAP') {
                        const toast_fail = document.getElementById('toast-user/tidaklengkap')
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toast_fail);
                        toastBootstrap.show();
                        $('#password').val('');
                        $('#username').focus();
                        $('#mainCard').addClass('animate__animated animate__headShake');
                        console.log(response['status']);
                    }
                    $('#btnLogin').prop('disabled', false);
                    $('#spinnerLogin').hide();

                }, 3000);

                $('#mainCard').removeClass('animate__animated animate__headShake');

            }
        });

    });

});
