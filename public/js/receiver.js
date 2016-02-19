
socket.on('user-login', function (data) {

    $.get('/admin/users/saveClient', data, function () {});

});

socket.on('user-update', function (data) {

    var data = JSON.parse(data);
    $('body').css('overflow', 'hidden');
    $('.overlay-update').fadeIn('slow');
    $.post('/admin/users/flushSession', data, function () {});

    // toastr.info('Are you the 6 fingered man?')
    window.setTimeout(function () {
        window.location.reload();
    }, 5000);

});

socket.on('user-ban', function (data) {

    var data = JSON.parse(data);
    $('body').css('overflow', 'hidden');
    $('.overlay-ban').fadeIn('slow');

    // toastr.info('Are you the 6 fingered man?')
    window.setTimeout(function () {
        window.location.href="/logout";
    }, 5000);

});

