
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
        ArtisanChat.setSeen($(this));
    });
    

    $("body").delegate("a.prev-msg", "click", function () {
        ArtisanChat.loadPreviousMessages($(this));
    });



    $("li.messages-menu ").on("click", function () {
        ArtisanChat.loadUserConversations();
    });


    $("li.messages-menu").on("click", function () {
        $(this).find("span").removeClass("label-danger").addClass("label-success").text(0);
        Artisan.resetDocumentTitle();
    });

   

});