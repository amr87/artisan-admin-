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

    ArtisanChat.chattingWith = $(chat).prev().text();

    $._widget.find(".chat-with").text(this.chattingWith);

    var template = this.loadConversation(chat, null);
    if (template.length)
        $._widget.find(".direct-chat-messages").prepend($("<a class='prev-msg' href='#'><i class='fa fa-arrow-up'></i> Load More Messages<br/><span class='fa fa-spinner fa-spin'></span></a>"));

    $._widget.find(".direct-chat-messages").append(template);

    $._widget.show();

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


ArtisanChat.loadConversation = function (chat, skip) {

    var template = "";

    var id = _.isObject(chat) ? chat.data('id') : chat;
    var skip = skip === null ? 0 : skip;

    $.ajax({
        url: '/get-conversation',
        type: 'GET',
        data: {to: id, skip: skip},
        async: false,
        success: function (response) {

            if (response.length) {

                for (var i = 0; i < response.length; i++) {

                    if (response[i].mine) {
                        template += "<div class='direct-chat-msg'>\n";
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
                        template += "<div class='direct-chat-msg right'>\n";
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
    template += "<div class='direct-chat-msg'>\n";
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

    //emit message
    socket.emit('message', {message: message, client: client, user_id: id, name: name, avatar: avatar, senderId: senderId, sclient: senderClient});



    // save message
    $.post('/post-message', {to: id, message: message}, function () {});

    // clear message input
    $(object).parent().prev().val("");

}



ArtisanChat.receiveMessage = function (data) {

    if (!_.isObject(data)) {
        console.error('You must pass data as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    var key = _.isUndefined(data.selector) ? data.senderId : data.data('id');

    var Current = Artisan.filter(this.holder, "[data-id='" + key + "']");

    var pos = $('.chat-area').length > 1 ? (($('.chat-area').length - 1) * parseInt($('.chat-area').width()) + 20) + "px" : '0px';

    if (!Current.length) {

        $._widget = this.holder.clone();


        $._widget.css({right: pos});

        $._widget.appendTo($('body'));

        $._widget.find(".direct-chat-messages").append(template);
        $._widget.find(".chat-with").text(data.name);
        $._widget.attr("data-client", data.sclient);
        $._widget.attr("data-id", data.senderId);
        var template = "";

        template += "<div class='direct-chat-msg right'>\n";
        template += "<div class='direct-chat-info clearfix'>\n";
        template += " <span class='direct-chat-name pull-right'>" + data.name + "</span>\n";
        template += "<span class='direct-chat-timestamp pull-left' data-timestamp='" + new Date().getTime() + "'>Now</span>\n";
        template += "</div>\n";
        template += "<img class='direct-chat-img' src='" + data.avatar + "' alt='Message User Image'>\n";
        template += "<div class='direct-chat-text'>\n";
        template += data.message + "\n";
        template += " </div>\n";
        template += "</div>"

        $._widget.find(".direct-chat-messages").prepend($("<a class='prev-msg' href='#'><i class='fa fa-arrow-up'></i> Load More Messages<br/><span class='fa fa-spinner fa-spin'></span></a>"));
        $._widget.find(".direct-chat-messages").append(template);
        $._widget.show();

    } else {

        $._widget = Current;


        $._widget.find('.box-header').addClass("redish");

        var template = "";

        template += "<div class='direct-chat-msg right'>\n";
        template += "<div class='direct-chat-info clearfix'>\n";
        template += " <span class='direct-chat-name pull-right'>" + data.name + "</span>\n";
        template += "<span class='direct-chat-timestamp pull-left' data-timestamp='" + new Date().getTime() + "'>Now</span>\n";
        template += "</div>\n";
        template += "<img class='direct-chat-img' src='" + data.avatar + "' alt='Message User Image'>\n";
        template += "<div class='direct-chat-text'>\n";
        template += data.message + "\n";
        template += " </div>\n";
        template += "</div>"
        if (!$._widget.find(".direct-chat-messages").find("a.prev-msg").length)
            $._widget.find(".direct-chat-messages").prepend($("<a class='prev-msg' href='#'><i class='fa fa-arrow-up'></i> Load More Messages<br/><span class='fa fa-spinner fa-spin'></span></a>"));

        var hasScroll = Artisan.hasScrollBar($._widget.find('.direct-chat-messages'));
        var scrolled = Artisan.scolledDown($._widget.find('.direct-chat-messages'));
        if (hasScroll && !scrolled) {
            var alert = $("span.new-messages").clone();
            alert.prependTo($._widget.find('.box-body'))
                    .fadeIn();

        }

        $._widget.find(".direct-chat-messages").append(template);

    }

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