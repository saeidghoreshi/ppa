// keypad is obj related to keypad on DOM
function Keypad() {
    this.numbers = '1234567890.';
    this.handlers = {};
    this.currentVal = '';
}

Keypad.prototype.press = function (key, params) {
    var fun = this.handlers[key],
        params = params || [];

    if (fun && typeof fun == 'function') fun.apply(this, params);
}

Keypad.prototype.handle = function (key, handler) {
    this.handlers[key] = handler;
    return this;
}

Keypad.prototype.reset = function () {
    this.handlers = {};
}

PPA.keypad = new Keypad();

// now to bind the keypad on the DOM to PPA.keypad
x$(document).on('DOMContentLoaded', function() {
    x$('.keypad a').on('click', function (e) {
        if (x$(this).hasClass('numbers')) {
            PPA.keypad.press('numbers', [this.name]);
        } else {
            PPA.keypad.press(this.name);
        }
    });

    x$('#payment-accounts a').on('click', function (e) {
        if (x$(this).hasClass('enabled')) {
            //alert(x$(this).attr('data-account-type'));
            //alert(this.attr('data-account-type'));
            PPA.keypad.press('account', [this.name,x$(this).attr('data-account-type')] );
        }
    });
});

function addAccountToDom (account, ele) {
    if( account.account_balance != '' && account.account_balance > 0 ) {
        ele.attr('name', account.account_id)
            .html(account.account_name+'<div class="accountBalance">$'+account.account_balance+'</div>');
    }
    else {
        ele.attr('name', account.account_id)
            .html(account.account_name);
    }
    if( account.merchant_id !== undefined && account.merchant_id != 0 ) {
        ele.attr('data-merchant-id', account.merchant_id );
    }
    else {
        ele.attr('data-merchant-id', 0 );
    }
    if( account.account_balance !== undefined && account.account_balance > 0 ) {
        ele.attr('data-account-balance', account.account_balance );
    }
    else {
        ele.attr('data-account_balance', 0 );
    }
    if( account.account_enabled == 1 && account.account_type < 11 ) ele.addClass('enabled');
    if( account.account_type > 0 ) ele.attr('data-account-type', account.account_type );
    ele.attr('href', '#' );
    //<a href="#accounts.detail" class="accountsListItem modal" data-account_id="54">
    //ele.attr('href', '#accounts.detail' );
    //ele.attr('data-account_id', account.account_id );
    //ele.className += 'accountsListItem modal';
}

preload = new Array(
    'assets/keypad/key_1.png',
    'assets/keypad/key_2.png',
    'assets/keypad/key_3.png',
    'assets/keypad/key_no.png',
    'assets/keypad/key_4.png',
    'assets/keypad/key_5.png',
    'assets/keypad/key_6.png',
    'assets/keypad/key_cancel.png',
    'assets/keypad/key_7.png',
    'assets/keypad/key_8.png',
    'assets/keypad/key_9.png',
    'assets/keypad/key_ok.png',
    'assets/keypad/key_corr.png',
    'assets/keypad/key_dot.png',
    'assets/keypad/key_0.png',
    'assets/keypad/button-bg-active.png',
    'assets/keypad/account-button-bg-active.png',
    'assets/keypad/info-button.png',
    'assets/keypad/bg_r.png',
    'assets/keypad/account-button-bg_r.png',
    'assets/keypad/key_1_r.png',
    'assets/keypad/key_2_r.png',
    'assets/keypad/key_3_r.png',
    'assets/keypad/key_no_r.png',
    'assets/keypad/key_4_r.png',
    'assets/keypad/key_5_r.png',
    'assets/keypad/key_6_r.png',
    'assets/keypad/key_cancel_r.png',
    'assets/keypad/key_7_r.png',
    'assets/keypad/key_8_r.png',
    'assets/keypad/key_9_r.png',
    'assets/keypad/key_ok_r.png',
    'assets/keypad/key_corr_r.png',
    'assets/keypad/key_dot_r.png',
    'assets/keypad/key_0_r.png',
    'assets/keypad/account-button-bg.png',
    'assets/keypad/lcd_r.png',
    'assets/keypad/bg.png',

    'assets/backspace.png',
    'assets/black_circle.png',
    'assets/in-app-logo.png',
    'assets/mb_center.png',
    'assets/mb_left.png',
    'assets/mb_right.png',
    'assets/mbb_left.png',
    'assets/native_stripe.png',
    'assets/ob_arrow.png'
);
for (i=0; i < preload.length; i++){
    prefetch_link_tag = document.createElement('img');
    prefetch_link_tag.setAttribute('style', 'display: none;');
    prefetch_link_tag.setAttribute('src', preload[i]);
    document.querySelector('body').appendChild(prefetch_link_tag);
}