var PPA = PPA || {};

PPA.passcode = {
    messages: {
        temporary:  'Please Enter your Temporary PayPhoneAPP Passcode',
        newCode:    'Please Enter your New PayPhoneAPP Passcode',
        confirm:    'Please Re-Enter your New PayPhoneAPP Passcode',
        standard:   'Please Enter your PayPhoneAPP Passcode'
    },
    currentCode: [],
    handlers: {
        temporary:  function (code) {
            PPA.remote.apiCall('verify', {
                token: code,
                phone: PPA.store.get('phone')
                //email: PPA.store.get('email')
            },
            {
                callback: function () {
                    // success
                    setStatus('newCode');
                    passcodePrompt('newCode');
                },
                errback: function () {
                    // error
                    PPA.alert('That was incorrect - please try again');
                    clearPasscode();
                }
            });
        },
        newCode:    function (code) {
            PPA.passcode.firstEntry = code;
            passcodePrompt('confirm');
        },
        confirm:    function (code) {
            // check against newCode, proceed or not
            if (code != PPA.passcode.firstEntry) {
                PPA.alert('The two passcodes do not match - please enter them again.');
                clearPasscode();
                passcodePrompt('newCode');
            } else {
                PPA.remote.apiCall('newPasscode', {
                    passcode: code,
                    confirmpasscode: code,
                    phone: PPA.store.get('phone')
                },
                {
                    callback: function () {
			window.startPage = 'passcode:standard';
                        setStatus('confirmed');
                        hidePasscodeModal();
                    },
                    errback: function () {
                        // error
                        PPA.alert('Oops, something went wrong - please try again.')
                        passcodePrompt('newCode');
                    }
                });
            }
        },
        standard:   function (code) {
            PPA.remote.apiCall('login', {
                passcode: code,
                phone: PPA.store.get('phone')
            },
            {
                callback: function () {
		    startPasscodeTimer();
                    hidePasscodeModal();
                },
                errback: function () {
                    PPA.alert('That was incorrect - please try again');
                    clearPasscode();
                }
            });
        }
    }
}

window.currentCode = [];

x$(document).on('DOMContentLoaded', function () {
    active(1);

    x$('#keypad > div').on('touchstart', function (e) {
        var entered = idToKey(e.currentTarget.id),
            current = PPA.passcode.currentCode;

        if (entered == 'BACKSPACE') {
            deselect(current.length);
            current.pop();
        } else {
            current.push(entered);
            select(current.length);
        }

        if (current.length == 4)
            PPA.passcode.currentHandler(current.join(''));
    });

    x$('#sideButton').on('touchstart', clearPasscode);
});

function idToKey(id) {
    var keyRegex = /^key-(\d)/,
        matches = id.match(keyRegex);

    if (matches)
        return matches[1];
    else if (id == 'backspace')
        return 'BACKSPACE';
    else
        return null;
}

function nthEntrySelector(index) {
    return '#codeEntry div:nth-child(' + index + ')';
}

function select(i) {
    x$(nthEntrySelector(i)).removeClass('current').addClass('entered');
    active(i+1);
}

function deselect(i) {
    x$(nthEntrySelector(i+1)).removeClass('current');
    x$(nthEntrySelector(i)).removeClass('entered');
    active(i);
}

function active(i) {
    if (i < 1) i = 1;
    x$(nthEntrySelector(i)).addClass('current');
}

function clearPasscode() {
    PPA.passcode.currentCode = [];
    x$('#codeEntry div').removeClass('entered').removeClass('current');
    active(1);
}

function passcodePrompt(which) {
    PPA.passcode.state = which;
    PPA.passcode.currentHandler = PPA.passcode.handlers[which];

    x$('#passcodeMsg').inner(PPA.passcode.messages[which]);
    clearPasscode();
    showPasscodeModal();
}

function showPasscodeModal() {
    x$("#passcodeView").css(PPA.modal.displayedStyle);
}

function hidePasscodeModal(forDisplay) {
    forDisplay = forDisplay || PPA.homepage;

    x$("#passcodeView").css(PPA.modal.hiddenStyle);
    showTemplate(forDisplay);
}
