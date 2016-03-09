
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


});

