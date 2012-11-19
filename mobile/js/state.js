(function () {
    var status = window.localStorage.getItem('ppa.status'),
        templates = {
            'new':       'register',
            'awaiting':  'passcode:temporary',
            'newCode':   'passcode:newCode',
            'confirmed': 'passcode:standard'
        };

    status = status || 'new';
    window.startPage = templates[status];
})();

PPA.store = (function (scope, prefix) {
    var db = scope.localStorage;

    function get (key) { return db.getItem(prefix + key); }

    function set(key, val) { db.setItem(prefix + key, val); }

    function clear(key) { db.removeItem(prefix + key); }

    function makeGet(key) {
        return function() { return get(key); }
    }

    function makeSet(key) {
        return function(val) { return set(key, val); }
    }

    function makeClear(key) {
        return function() { return clear(key); }
    }

    return {
        get: get,
        makeGet: makeGet,
        set: set,
        makeSet: makeSet,
        clear: clear,
        makeClear: makeClear
    };
})(window, 'ppa.');

var setStatus     = PPA.store.makeSet('status'),
    clearStatus   = PPA.store.makeClear('status'),
    getStatus     = PPA.store.makeGet('status'),
    setCookie     = PPA.store.makeSet('cookie'),
    getCookie     = PPA.store.makeGet('cookie'),
    clearCookie   = PPA.store.makeClear('cookie');

PPA._cookie = null;
PPA.cookie = function (c) {
    var sess = "PHPSESSID",
        k, correct;

    if (!!c) {
        correct = sess + (c.split(sess).reverse()[0]);

        PPA._cookie = correct;
        setCookie(correct);
    } else {
        if (PPA._cookie) return PPA._cookie;
        k = getCookie();
        PPA._cookie = k;
        return k;
    }
}

function isPhonegap() { 
    if (window.Device !== undefined) { 
        return true; 
    } else { 
        return false; 
    } 
}
