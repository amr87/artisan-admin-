socket.on('user-login', function (data) {
    if (data.multiple != "undefined" && data.multiple == true)
        window.location.href = "/logout";
    $.get('/admin/users/saveClient', data, function () {});

});

socket.on('user-update', function (data) {

    var data = JSON.parse(data);
    $('body').css('overflow', 'hidden');
    $('.overlay-update').fadeIn('slow');
    $.post('/admin/users/flushSession', data, function () {});

    window.setTimeout(function () {
        window.location.reload();
    }, 5000);

});

socket.on('user-ban', function (data) {

    var data = JSON.parse(data);
    $('body').css('overflow', 'hidden');
    $('.overlay-ban').fadeIn('slow');

    window.setTimeout(function () {
        window.location.href = "/logout";
    }, 5000);

});