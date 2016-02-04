var socket = new io.connect('http://localhost:3000');

/*
 * @todo emit event on connection and send user ID to the socket
 */

socket.on('user-login', function (data) {
    $.get('/admin/users/saveClient', data, function (response) {
        console.log(response);
    });
});

socket.on('user-update', function (data) {
    $.get('/admin/users/flusSession', data, function (response) {
        console.log(response);
    })

});