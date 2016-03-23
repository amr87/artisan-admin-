/* 
 * @author: Amr Gamal <amr.gamal878@gmail.com>
 * @date: 03-03-2016
 * @dependencies: [Jquery , underscorejs]
 */

"use strict";

$ = jQuery.noConflict();

window.ArtisanChat = {};

ArtisanChat.holder = $(".chat-area");

ArtisanChat.count = 0;

ArtisanChat.position = 0;

ArtisanChat.chattingWith = "";

ArtisanChat.init = function (chat) {

    if (!_.isObject(chat)) {
        console.error('You must pass props as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    this.count = Artisan.filter(this.holder, ":visible").length;

    this.position = this.count * parseInt(this.holder.css('width'));

    $._widget = this.build(chat);

    this.count++;

    $._widget.attr("data-client", $(chat).data('client'));

    $._widget.attr("data-id", $(chat).data('id'));

    ArtisanChat.chattingWith = $(chat).get(0).nodeName == "SPAN" ? $(chat).prev().text() : $(chat).data("with");

    $._widget.find(".chat-with").text(this.chattingWith);

    var template = this.loadConversation(chat, null);
    if (template.length)
        $._widget.find(".direct-chat-messages").prepend($("<a class='prev-msg' href='#'><i class='fa fa-arrow-up'></i> Load More Messages<br/><span class='fa fa-spinner fa-spin'></span></a>"));

    $._widget.find(".direct-chat-messages").append(template);

    $._widget.show();

    $._widget.find('input#message').typing({
        start: function (event, $elem) {
            var client = $elem.parent().parent().parent().parent().data("client");
            socket.emit('typing', {client: client , senderClient: Artisan.filter($('span.chat-start'), "[data-id='" + $("input#myId").val() + "']").data("client")});
        },
        stop: function (event, $elem) {
            var client = $elem.parent().parent().parent().parent().data("client");
            socket.emit('untyping', {client: client,senderClient:Artisan.filter($('span.chat-start'), "[data-id='" + $("input#myId").val() + "']").data("client")});
        },
        delay: 400
    });

};


ArtisanChat.build = function (data) {

    if (!_.isObject(data)) {
        console.error('You must pass data as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    var key = _.isUndefined(data.selector) ? data.senderId : data.data('id');

    var Current = Artisan.filter(this.holder, "[data-id='" + key + "']");

    if (!Current.length) {

        $._widget = this.holder.clone();

        $._widget.css({right: this.position});

    } else {

        $._widget = Current;

        this.RePosition('re-appear', $._widget);
    }

    $._widget.appendTo($('body'));

    return $._widget;

}


ArtisanChat.loadConversation = function (chat, threshold) {

    var template = "";

    var id = _.isObject(chat) ? chat.data('id') : chat;
    var skip = threshold === null ? 0 : threshold;

    $.ajax({
        url: '/get-conversation',
        type: 'GET',
        data: {to: id, skip: skip},
        async: false,
        success: function (response) {

            if (response.length) {

                for (var i = 0; i < response.length; i++) {

                    if (response[i].mine) {
                        template += "<div data-mine='1' data-id='" + response[i].id + "' data-seen='" + response[i].seen + "' class='direct-chat-msg'>\n";
                        template += "<div class='direct-chat-info clearfix'>\n";
                        template += " <span class='direct-chat-name pull-left'>" + response[i].sender.display_name + "</span>\n";
                        template += "<span class='direct-chat-timestamp pull-right'>" + response[i].sent_at + "</span>\n";
                        template += "</div>\n";
                        template += "<img class='direct-chat-img' src='" + response[i].sender.avatar + "' alt='Message User Image'>\n";
                        template += "<div class='direct-chat-text'>\n";
                        template += response[i].text + "\n";
                        template += " </div>\n";
                        template += "</div>"

                    } else {
                        template += "<div data-mine='0' data-id='" + response[i].id + "' data-seen='" + response[i].seen + "' class='direct-chat-msg right'>\n";
                        template += "<div class='direct-chat-info clearfix'>\n";
                        template += " <span class='direct-chat-name pull-right'>" + response[i].sender.display_name + "</span>\n";
                        template += "<span class='direct-chat-timestamp pull-left'>" + response[i].sent_at + "</span>\n";
                        template += "</div>\n";
                        template += "<img class='direct-chat-img' src='" + response[i].sender.avatar + "' alt='Message User Image'>\n";
                        template += "<div class='direct-chat-text'>\n";
                        template += response[i].text + "\n";
                        template += " </div>\n";
                        template += "</div>"
                    }
                }
            }

        }});

    return template;

};



ArtisanChat.sendMessage = function (object) {

    if (!_.isObject(object)) {
        console.error('You must pass object as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    var message = $(object).parent().prev().val();

    if (message == "") {
        alert("You must type a message");
        return;
    }

    var _widget = $(object).parent().parent().parent().parent().parent();


    var id = _widget.data("id");
    var client = Artisan.filter($('span.chat-start'), "[data-id='" + id + "']").data("client");
    var name = _widget.data("name");
    var avatar = _widget.data("avatar");

    var senderId = $("input#myId").val();

    var senderClient = Artisan.filter($('span.chat-start'), "[data-id='" + senderId + "']").data("client");


    var template = "";
    template += "<div data-seen='1' data-mine='1' class='direct-chat-msg'>\n";
    template += "<div class='direct-chat-info clearfix'>\n";
    template += " <span class='direct-chat-name pull-left'>" + name + "</span>\n";
    template += "<span class='direct-chat-timestamp pull-left' data-timestamp='" + new Date().getTime() + "'>Now</span>\n";
    template += "</div>\n";
    template += "<img class='direct-chat-img' src='" + avatar + "' alt='Message User Image'>\n";
    template += "<div class='direct-chat-text'>\n";
    template += message + "\n";
    template += " </div>\n";
    template += "</div>"

    _widget.find(".direct-chat-messages").append(template);
    _widget.find(".direct-chat-messages").animate({'scrollTop': _widget.find(".direct-chat-messages").get(0).scrollHeight + "px"});

    _widget.find(".seen-mark").remove();
    // save message
    $.post('/post-message', {to: id, message: message}, function (response) {
        var data = JSON.parse(response);
        if (data.id != 0) {
            //emit message
            socket.emit('message', {message: message, client: client, user_id: id, name: name, avatar: avatar, senderId: senderId, sclient: senderClient, msg_id: data.id});
        }
    });

    // clear message input
    $(object).parent().prev().val("");

}



ArtisanChat.receiveMessage = function (data) {

    if (!_.isObject(data)) {
        console.error('You must pass data as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    /* 
     * increase message counter
     * @todo increase for differnet conversation only as facebook does
     */
    var elem = $("li.messages-menu").find("span");
    elem.removeClass('label-success').addClass("label-danger").text(parseInt(elem.text()) + 1);

    /*
     * @ show message if the chat head is opened
     * 
     */

    var key = _.isUndefined(data.selector) ? data.senderId : data.data('id');

    var Current = Artisan.filter(this.holder, "[data-id='" + key + "']");

    if (Current.length) {
        var template = "";

        $._widget = Current;

        $._widget.find('.box-header').addClass("redish");

        template += "<div data-seen='0'  data-mine='0' data-id='" + data.msg_id + "' class='direct-chat-msg right'>\n";
        template += "<div class='direct-chat-info clearfix'>\n";
        template += " <span class='direct-chat-name pull-right'>" + data.name + "</span>\n";
        template += "<span class='direct-chat-timestamp pull-left' data-timestamp='" + new Date().getTime() + "'>Now</span>\n";
        template += "</div>\n";
        template += "<img class='direct-chat-img' src='" + data.avatar + "' alt='Message User Image'>\n";
        template += "<div class='direct-chat-text' style='height:30px !important'>\n";
        template += data.message + "\n";
        template += " </div>\n";
        template += "</div>"
        if (!$._widget.find(".direct-chat-messages").find("a.prev-msg").length)
            $._widget.find(".direct-chat-messages").prepend($("<a class='prev-msg' href='#'><i class='fa fa-arrow-up'></i> Load More Messages<br/><span class='fa fa-spinner fa-spin'></span></a>"));

        var hasScroll = Artisan.hasScrollBar($._widget.find('.direct-chat-messages'));
        var scrolled = Artisan.scrolledDown($._widget.find('.direct-chat-messages'));
        if (hasScroll && !scrolled && !$._widget.find("span.new-messages").length) {
            var alert = $("span.new-messages").clone();
            alert.prependTo($._widget.find('.box-body'))
                    .fadeIn();

        }

        $._widget.find(".direct-chat-messages").append(template);
        $._widget.find(".seen-mark").remove();
    }

    Artisan.titleMarquee(data.name + ' Messaged you');

}

ArtisanChat.close = function (button) {

    if (!_.isObject(button)) {
        console.error('You must pass props as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    $(button).parent().parent().parent().parent().remove();

    this.RePosition('delete', {});

};


ArtisanChat.RePosition = function (action, widget) {

    if (!_.isString(action) || !_.isObject(widget)) {
        console.error('You must pass props as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    if (action == "delete") {

        Artisan.filter(this.holder, ':visible').each(function (i, elem) {
            $(elem).animate({right: i * parseInt($(elem).css('width')) + "px"}, 'slow');
        });

    } else if (action == "re-appear") {

        var thisPos = parseInt(widget.css('right'));

        var Visible = Artisan.filter(this.holder, ':visible');

        Visible.each(function (i, elem) {

            if (parseInt($(elem).css('right')) == thisPos && widget.css('style') != "block") {

                var newPos = this.count * parseInt(ArtisanChat.css('width'));

                $(elem).animate({right: newPos + "px"}, 'slow');
            }
        });

    }

}

var current;

ArtisanChat.setSeen = function (obj) {

    if (!_.isObject(obj)) {
        console.error('You must pass obj as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    current = $(obj);
    $(current).find('.box-header').removeClass('redish');
    Artisan.resetDocumentTitle();
    if (Artisan.scrolledDown($(current).find(".direct-chat-messages"))) {
        // find non seen messages
        var notSeen = $(current).find(".direct-chat-msg[data-seen='0']");
        if (notSeen.length) {
            var ids = [];
            for (var i = 0; i < notSeen.length; i++) {
                ids.push($(notSeen[i]).data("id"));
            }
            if (ids.length) {
                if (current.data('requestRunning')) {
                    return;
                }
                current.data('requestRunning', true);
                $.ajax({
                    type: "POST",
                    url: "/message-seen",
                    data: {id: ids},
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.length) {
                            for (var j = 0; j < data.length; j++) {
                                $(".direct-chat-msg[data-id = '" + data[j].id + "']").attr("data-seen", "1");
                            }
                            var senderClient = Artisan.filter($('span.chat-start'), "[data-id='" + $("input#myId").val() + "']").data("client");
                            socket.emit('seen', {client: $(current).data("client"), senderId: senderClient, msg_id: data[j - 1].id, msg_seen: data[j - 1].seen_at});
                        }
                    },
                    complete: function () {
                        current.data('requestRunning', false);
                    }
                });


            }
        }
    }
}

ArtisanChat.loadPreviousMessages = function (obj) {
    if (!_.isObject(obj)) {
        console.error('You must pass obj as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }
    $(obj).find('span').fadeIn();
    var box = $(obj).parent().parent().parent().parent();
    var id = box.data("id");
    var skip = $(obj).parent().find('.direct-chat-msg').length;
    var template = ArtisanChat.loadConversation(id, skip);
    $(obj).find('span').fadeOut();
    $(template).insertAfter($(obj));
    if (!template.length)
        $(obj).remove();
}


ArtisanChat.loadUserConversations = function () {

    $.get('/user-conversations', {}, function (response) {
        var data = JSON.parse(response);
        var output = "";
        if (data.length > 0) {

            output += "<li class='header'>You have " + data.length + " conversation(s)</li>";
            output += "<li><ul class='menu conversation-holder'>";
            for (var i = 0; i < data.length; i++) {

                if (data[i]['messages'][0]['mine']) {
                    var selector = $("span.chat-start[data-id='" + data[i]['messages'][0]['receiver']['id'] + "']");
                    var seen = data[i]['messages'][0]['seen'] == "1" ? '' : 'pale-red';
                    var client = selector.length ? selector.data('client') : null;
                    var seenIcon = data[i]['messages'][0]['seen'] == "1" ? "<i class='fa fa-eye'></i>" : "";
                    output += " <li data-with='" + data[i]['messages'][0]['receiver']['display_name'] + "' class='chat-start " + seen + "' data-id='" + data[i]['messages'][0]['receiver']['id'] + "' data-client='" + client + "'> <a href='#'><div class='pull-left'>";
                    output += " <img src='" + data[i]['messages'][0]['receiver']['avatar'] + "' class='img-circle' alt='User Image'></div> <h4>\n\
                                                             " + data[i]['messages'][0]['receiver']['display_name'] + " \n\
                                                                <small><i class='fa fa-clock-o'></i> \n\
                                                             " + data[i]['messages'][0]['sent_at'] + "</small></h4>\n\
                                                              <p>You: " + data[i]['messages'][0]['text'] + " " + seenIcon + "</p>";
                } else {
                    var selector = $("span.chat-start[data-id='" + data[i]['messages'][0]['sender']['id'] + "']");
                    var seen = data[i]['messages'][0]['seen'] == "1" ? '' : 'pale-red';
                    var client = selector.length ? selector.data('client') : null;
                    output += " <li data-with='" + data[i]['messages'][0]['sender']['display_name'] + "' class='chat-start " + seen + "' data-id='" + data[i]['messages'][0]['sender']['id'] + "' data-client='" + client + "'> <a href='#'><div class='pull-left'>";
                    output += " <img src='" + data[i]['messages'][0]['sender']['avatar'] + "' class='img-circle' alt='User Image'></div>\n\
                                  <h4>" + data[i]['messages'][0]['sender']['display_name'] + "   <small><i class='fa fa-clock-o'></i> \n\
                                                             " + data[i]['messages'][0]['sent_at'] + "</small></h4>\n\
                                                                <p>" + data[i]['messages'][0]['text'] + "</p>";
                }

                output += "</a></li>";
            }
            output += "</ul>";
            // output += " <li class='footer'> <a href='$' > See All Messages </a></li>";
        } else {
            output += "<h4>No Conversations yet</h4>";
            output += "</ul>";
        }

        $("li.messages-menu").find('ul.dropdown-menu').html(output);

    });
}
