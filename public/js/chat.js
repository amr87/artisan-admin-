
$(function () {
    $("body").delegate("span.chat-start", "click", function () {
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
        if ($(this).parent().parent().hasClass("yellowish")) {
            $(this).parent().parent().removeClass("yellowish");
        }
    });


});

