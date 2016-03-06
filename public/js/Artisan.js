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
    
    return $(selector.selector+filter);
}