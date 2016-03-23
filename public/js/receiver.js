socket.on('user-login', function (data) {

    $.get('/admin/users/saveClient', data, function () {});

});

socket.on('user-update', function (data) {

    var data = JSON.parse(data);
    $('body').css('overflow', 'hidden');
    $('.overlay-update').fadeIn('slow');

    // Artisan.Notification({
    //     text : 'User Updated ',
    //     type :'warning',
    //     animation:{
    //         open:'zoomIn',
    //         close:'zoomOut'
    //     }
    // });
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

socket.on('seen', function (data) {

//alert('okay seen');

});


socket.on('connectedUser', function (json) {

    $("div.users-online").find(".control-sidebar-heading").html(" Online Users <strong style='color:yellow'>( " + json.users.length + " )</strong>");

    var output = "";

    output += "<ul id='online-users'>";

    for (var i = 0; i < json.users.length; i++) {

        var k = Artisan.getKey(json.users[i]);

        output += "<li><img class='img-circle' src='" + json.users[i].avatar + "' width='50'/>\n\
                        <a>" + json.users[i].name + "</a>\n\
                        <span title='Chat with " + json.users[i].name + "' data-id='" + k + "'  data-client='" + json.users[i][k] + "' class='fa fa-lg fa-comment chat-start'></span>\n\
                        \n\<div style='clear:both'></div>\n\
                   </li>";
        if ($("ul.conversation-holder li[data-id='" + k + "']").length) {
            $("ul.conversation-holder li[data-id='" + k + "']").attr("data-client", json.users[i][k]);
        }

    }

    output += "</ul>";

    $(".users-online").find(".overlay").remove();
    $(".users-online").find(".box-body").html(output);


});