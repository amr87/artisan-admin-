
$(function () {

    $("body").delegate(".chat-start", "click", function () {
        ArtisanChat.init($(this));
    });

    $("body").delegate("button.send-message", "click", function () {
        ArtisanChat.sendMessage($(this));
    });

    $("body").delegate("button.btn-close-chat", "click", function () {
        ArtisanChat.close($(this));
    });

    socket.on('message', function (data) {
        ArtisanChat.receiveMessage(data);
    });

    $("body").delegate("button[data-widget='collapse']", "click", function () {
        if ($(this).parent().parent().hasClass("redish")) {
            $(this).parent().parent().removeClass("redish");
        }
    });

    $("body").delegate("span.new-messages", "click", function () {

        $(this).parent().find('.direct-chat-messages')
                .animate({
                    scrollTop: $(this).parent().find('.direct-chat-messages').get(0).scrollHeight + "px"
                }, 'slow');
        $(this).parent().prev().removeClass('redish');
        $(this).remove();
    });


    $("body").delegate(".chat-area", "mouseover", function () {

        $(this).find('.box-header').removeClass('redish');
    });


    $("body").delegate("a.prev-msg", "click", function () {
        $(this).find('span').fadeIn();
        var box = $(this).parent().parent().parent().parent();
        var id = box.data("id");
        var skip = $(this).parent().find('.direct-chat-msg').length;
        var template = ArtisanChat.loadConversation(id, skip);
        $(this).find('span').fadeOut();
        $(template).insertAfter($(this));
        if (!template.length)
            $(this).remove();
    });



    $("li.messages-menu ").on("click", function () {
        $.get('/user-conversations', {}, function (response) {
            var data = JSON.parse(response);
            var output = "";
            if (data.length > 0) {

                output += "<li class='header'>You have " + data.length + " conversation(s)</li>";
                output += "<li><ul class='menu conversation-holder'>";
                for (var i = 0; i < data.length; i++) {

                    if (data[i]['messages'][0]['mine']) {
                        var selector = $("span.chat-start[data-id='" + data[i]['messages'][0]['receiver']['id'] + "']");
                        var client = selector.length ? selector.data('client') : null;
                        output += " <li data-with='" + data[i]['messages'][0]['receiver']['display_name'] + "' class='chat-start' data-id='" + data[i]['messages'][0]['receiver']['id'] + "' data-client='" + client + "'> <a href='#'><div class='pull-left'>";
                        output += " <img src='" + data[i]['messages'][0]['receiver']['avatar'] + "' class='img-circle' alt='User Image'></div> <h4>\n\
                                                             " + data[i]['messages'][0]['receiver']['display_name'] + " \n\
                                                                <small><i class='fa fa-clock-o'></i> \n\
                                                             " + data[i]['messages'][0]['sent_at'] + "</small></h4>\n\
                                                              <p>You: " + data[i]['messages'][0]['text'] + "</p>";
                    } else {
                        var selector = $("span.chat-start[data-id='" + data[i]['messages'][0]['sender']['id'] + "']");
                        var client = selector.length ? selector.data('client') : null;
                        output += " <li data-with='" + data[i]['messages'][0]['sender']['display_name'] + "' class='chat-start' data-id='" + data[i]['messages'][0]['sender']['id'] + "' data-client='" + client + "'> <a href='#'><div class='pull-left'>";
                        output += " <img src='" + data[i]['messages'][0]['sender']['avatar'] + "' class='img-circle' alt='User Image'></div>\n\
                                  <h4>" + data[i]['messages'][0]['sender']['display_name'] + "   <small><i class='fa fa-clock-o'></i> \n\
                                                             " + data[i]['messages'][0]['sent_at'] + "</small></h4>\n\
                                                                <p>" + data[i]['messages'][0]['text'] + "</p>";
                    }

                    output += "</a></li>";
                }
                output += "</ul>";
                output += " <li class='footer'> <a href='$' > See All Messages </a></li>";
            } else {
                output += "<h4>No Conversations yet</h4>";
                output += "</ul>";
            }

            $("li.messages-menu").find('ul.dropdown-menu').html(output);

        });
    });


});


function liveScrollListener() {
    var all = document.querySelectorAll(".direct-chat-messages");
    for (i = 0; i < all.length; i++) {
        all[i].onscroll = function (evt) {
            $(evt.target).find('.direct-chat-msg').each(function () {
                if ($(this).visible(false, true)) {
                    if ($(this).data("mine") == 0 && $(this).data("seen") == 0) {
                        // emit seen event

//                        $.ajax({
//                            url: '/message-seen',
//                            type: 'POST',
//                            data: {id: $(this).data("id")},
//                            async: false,
//                            success: function (response) {
//                                var res = JSON.parse(response);
//                                if (res.id != 0) {
//                                    socket.emit('seen', {client: $(this).parent().parent().parent().parent().data("client"), msg_id: res.id, msg_seen: res.seen_at});
//                                }
//                            }});
                    }
                }
            });

        };
    }
}

