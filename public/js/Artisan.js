/* 
 * @author: Amr Gamal
 * @date: 03-03-2016
 * @dependencies: [Jquery , underscorejs]
 */

"use strict";

$ = jQuery.noConflict();

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

    return $(elem).get(0).scrollHeight  > $(elem).get(0).clientHeight;
}

Artisan.scolledDown = function (elem) {
    if (!_.isObject(elem)) {
        console.error('You must pass elem as an object.');
        alert('Sorry, something went terribly wrong, please refresh the page and try again.');
        return;
    }

    return  $(elem).get(0).scrollHeight - $(elem).scrollTop() == $(elem).outerHeight() ;
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