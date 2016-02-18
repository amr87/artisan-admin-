
socket.on('user-login', function (data) {
    $.get('/admin/users/saveClient', data, function (response) {

    });
});

socket.on('user-update', function (data) {
    var data = JSON.parse(data);
    var success = false;
    $.post('/admin/users/flushSession', data, function () {});
    
         window.location.reload();

});