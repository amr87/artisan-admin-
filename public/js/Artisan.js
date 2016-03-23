/* 
 * @author: Amr Gamal
 * @date: 03-03-2016
 * @dependencies: [Jquery , underscorejs]
 */

"use strict";

$ = jQuery.noConflict();

var marqueeTitle, originalTitle = "Dashboard";

window.Artisan = {};

Artisan.getKey = function (props) {

    if (!_.isObject(props)) {
        console.error('You must pass props as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    for (var prop in props)
        if (props.propertyIsEnumerable(prop))
            return prop;
}

Artisan.filter = function (selector, filter) {

    if (!_.isObject(selector)) {
        console.error('You must pass selector as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    if (!_.isString(filter)) {
        console.error('You must pass filter as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    return $(selector.selector + filter);
}


Artisan.hasScrollBar = function (elem) {
    if (!_.isObject(elem)) {
        console.error('You must pass elem as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    return $(elem).get(0).scrollHeight > $(elem).get(0).clientHeight;
}

Artisan.scrolledDown = function (elem) {
    if (!_.isObject(elem)) {
        console.error('You must pass elem as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    return  $(elem).get(0).scrollHeight - $(elem).scrollTop() == $(elem).outerHeight();
}


Artisan.Notification = function (props) {

    if (!_.isObject(props)) {
        console.error('You must pass props as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    noty({
        text: props.text,
        type: props.type,
        dismissQueue: true,
        layout: 'bottomRight',
        closeWith: ['click'],
        theme: 'relax',
        maxVisible: 10,
        animation: {
            open: 'animated ' + props.animation.open,
            close: 'animated ' + props.animation.close,
            easing: 'swing',
            speed: 500
        }
    });
}

Artisan.titleMarquee = function (text) {

    if (!_.isString(text)) {
        console.error('You must pass text as an string.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }
    originalTitle = document.title;
    document.title = text;
    var documentTitle = document.title + " - ";

    (function titleMarquee() {
        document.title = documentTitle = documentTitle.substring(1) + documentTitle.substring(0, 1);
        marqueeTitle = setTimeout(titleMarquee, 200);
    })();
}

Artisan.resetDocumentTitle = function () {

    window.clearTimeout(marqueeTitle);
    document.title = originalTitle;
    if (parseInt($("li.messages-menu").find("span").text()) > 0)
        $("li.messages-menu").find("span").text(parseInt($("li.messages-menu").find("span").text()) - 1);
}