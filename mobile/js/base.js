window.PPA = {};

PPA.alert = function (msg, title) {
    if (navigator.notification && navigator.notification.alert) {
            navigator.notification.alert(
                msg,  // message
                null,         // callback
                title,            // title
                'Ok'                  // buttonName
            );
    } else {
        alert(msg);
    }
}

PPA.confirm = function (msg) {
    if (navigator.notification && navigator.notification.confirm) {
            navigator.notification.confirm(
                msg,  // message
                null,         // callback
                null,            // title
                'OK,Cancel'                  // buttonName
            );
    } else {
        alert(msg);
    }
}

// TODO: change this to keypad
PPA.homepage = 'keypad';

// Geo Locaton Object
PPA.geo = null;

Array.prototype.has = function (element) {
    return (0 <= this.indexOf(element));
}

x$.fn.data = function () {
    var obj = {};

    this.each(function (el) {
        var i=0,
            atts = el.attributes,
            isData = /^data-(.*)$/,
            item,
            mtch;

        for (i; i<atts.length; i++) {
            item = atts.item(i);
            mtch = item.nodeName.match(isData);

            if (mtch) obj[mtch[1]] = item.value;
        }
    });

    return obj;
}

/* taken from thomas fuchs
 * http://mir.aculo.us/2011/03/09/little-helpers-a-tweet-sized-javascript-templating-engine/
 */
function nanoTemplate(string, data) {
    for (var p in data)
        string = string.replace(new RegExp('{'+p+'}', 'g'), data[p]);

    return string;
}

function mixin(source, includes) {
    source = source || {};

    for (var o in includes) {
        if (includes.hasOwnProperty(o)) source[o] = includes[o];
    }

    return source;
}

function clone(original) {
    if (isArray(original))
        return cloneArray(original);
    else
        return mixin({}, original);
}

function cloneArray(arr) {
    var newArray = [], i=0;

    for (i; i<arr.length; i++) newArray[i] = arr[i];

    return newArray;
}

// used to make code more readable - less conditions, more fun calls
function attempt(identifier, args) {
    if (this[identifier] && (typeof this[identifier] == "function"))
        return this[identifier].apply(this, args);
}

// taken from underscore.js
function isArray(obj) {
    return Object.prototype.toString.call(obj) === '[object Array]';
}

if (!Object.prototype.keys) {
    Object.prototype.keys = function () {
        var keys = [];
        for (var key in this)
            if (this.hasOwnProperty(key))
                keys[keys.length] = key;

        return keys;
    }
}

// taken from kris kowal: https://github.com/kriskowal/es5-shim/raw/master/es5-shim.js
if (!Array.prototype.map) {
    Array.prototype.map = function(fun /*, thisp*/) {
        var len = +this.length;
        if (typeof fun != "function")
          throw new TypeError();

        var res = new Array(len);
        var thisp = arguments[1];
        for (var i = 0; i < len; i++) {
            if (i in this)
                res[i] = fun.call(thisp, this[i], i, this);
        }

        return res;
    };
}

if (!Array.prototype.filter) {
    Array.prototype.filter = function filter(block /*, thisp */) {
        var values = [];
        var thisp = arguments[1];
        for (var i = 0; i < this.length; i++)
            if (block.call(thisp, this[i]))
                values.push(this[i]);
        return values;
    };
}

function arrayObjQuery(collection, property, value) {
    return collection.filter(function (obj) {
        return obj[property] == value;
    });
}


PPA.strings = {
    tosNotice: 'Please read and accept the terms of service',
    invalidPhone: 'That does not appear to be\na valid phone number!',
    phoneEmailRequired: 'Phone number and email are required!',
    smsSuccess: 'Message sent - thanks!',
    smsMsg: "PayPhoneAPP is a secure, convenient way to pay for stuff using your phone... Get it Now http://itunes.apple.com/ca/app/payphoneapp/id522231564?mt=8",
    accountForm: {
        add: 'Add <small>An</small><br> Account',
        edit: 'Edit <small>your</small><br> Account'
    },
    keypad: {
        select_account: 'Select Account',
        prompt_pin: 'Enter PIN & Press OK',
        submitting_payment: 'Processing Transaction...',
        checking_requests: '<strong>Checking for Payment Requests...</strong>',
        confirm_cancel: 'Cancel Transaction?',
        canceling: 'Cancelling Transaction...'
    }
}
