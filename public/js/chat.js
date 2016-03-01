$(function () {
    $("body").delegate("span#chat-start", "click", function (e) {
       
        $("div#chat-area").attr("data-client",$(this).data('client')).show();
        
    });
});


