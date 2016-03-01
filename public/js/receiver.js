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

socket.on('connectedUser', function (json) {
    $(".users-online").find(".box-title").html("Users Online <strong>" + json.users.length + "</strong>");
    var output = "";
    output += "<ul id='online-users'>";

    for (var i = 0; i < json.users.length; i++) {

        output += "<li><img class='img-circle' src='" + json.users[i].avatar + "' width='60'/>\n\
                        <a  target='_blank' href='/admin/users/" + getKey(json.users[i]) + "'>" + json.users[i].name + "</a><li>";
         
         //          </li>";

    }

    output += "</ul>";
    $(".users-online").find(".overlay").remove();
    $(".users-online").find(".box-body").html(output);
});


function getKey(data) {
    for (var prop in data)
        if (data.propertyIsEnumerable(prop))
            return prop;
}
