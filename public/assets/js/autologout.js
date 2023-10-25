$(document).ready(function () {
    const timeout = 5400000;  // 5400000 ms = 90 minutes
    // const timeout = 60000;  // 60000 ms = 1 minutes
    var idleTimer = null;
    $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
        clearTimeout(idleTimer);

        idleTimer = setTimeout(function () {
            // document.getElementById('logout-form').submit();
            window.location.href = '/logout/session-timeout';
        }, timeout);
    });
    $("body").trigger("mousemove");
});
