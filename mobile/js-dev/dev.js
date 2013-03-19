// This file should be removed in production builds!
window.DEVMODE = true;

function devStart(start) {
    if (!!start) {
        window.localStorage.setItem('dev.start', start);
    } else if (start === 0) {
        window.localStorage.removeItem('dev.start');
    } else {
        return window.localStorage.getItem('dev.start');
    }
}

function styleDiff(first, second) {
    var oneStyle = getComputedStyle(first),
        twoStyle = getComputedStyle(second),
        diff = [],
        i,
        prop;

    for (i = 0; i < oneStyle.length; i++) {
        prop = oneStyle[i];
        if (oneStyle[prop] != twoStyle[prop]) diff.push(prop);
    }

    return diff;
}

function clearLocalStore() {
    var key;

    for (var i=0; i < window.localStorage.length; i++) {
        key = window.localStorage.key(i);
        if (key.match('template')) window.localStorage.removeItem(key);
    }
}

x$(document).on('DOMContentLoaded', function () {
    clearLocalStore();
});

var oldInitial = showInitialPage,
    showInitialPage = function () {
        window.startPage = devStart() || window.startPage;

        oldInitial();
    };

window.devAccounts = {
    'andrew': '7788333573',
    'dmitry': '6044183222',
    'steve': '7782221111'
}

function useAccount(name) {
    PPA.store.set('phone', devAccounts[name]);
}
