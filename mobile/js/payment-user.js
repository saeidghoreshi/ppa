
// payment flow:
// currently:
//  merchant processes payment for some number
//   - receives back a transaction id
//  user queries server by transaction id
//   - receives back transaction JSON
//  either
//    user confirms transaction
//      sends confirm request back to server
//    user cancels transaction
//      sends cancel request back to server
//  meanwhile
//    post loops for status
//    checks for cancellation on server
//

PPA.payment = (function () {
    var exp = {
        loop: false,
        detailsLoop: false,
        currentTransaction: null
    }, dom,
        descEle = x$('#payment-description'),
        messageEle = x$('#payment-message'),
        amountEle = x$('#payment-amount'),
        show = { display: 'block' },
        hide = { display: 'none' },
        DEFAULT_TIP = '0',
        DEFAULT_ACCOUNT = '42';

    // display functions
    dom = {
        defaultState: function () {
            //descEle.html('Checking for Payment Requests...');
            descEle.html('Location verified.');
            amountEle.css(hide);
            messageEle.css(hide);
        },
        geoCheck: function (id) {
            descEle.html('Determining GEO location...');
            amountEle.css(hide);
            messageEle.css(hide);
        },
        geoCheckFailed: function (merchant, amount, merchant_id, distance, accuracy) {
            //descEle.html('There is an unconfirmed request from Mercant '+merchant+' for '+amount+' located '+distance+' away');
	    descEle.html('Location Error, please relaunch PayPhoneAPP');
            amountEle.css(hide);
            messageEle.css(hide);
        },
        transactionDetails: function (merchant, amount, merchant_id) {
			   if( PPA.payment.detailsLoop ) {
            descEle.html(merchant);
            amountEle.html('$'+amount).css(show);
            x$('a.accountName').each(function (l) {
                var ele = x$(l);
                if( parseInt(ele.attr('data-merchant-id')) == merchant_id || (parseInt(ele.attr('data-merchant-id')) == 0 && parseInt(ele.attr('data-account-type')) > 10 ) ) {
                    if( parseFloat(amount) <= parseFloat(ele.attr('data-account-balance')) && !ele.hasClass('enabled') ) {
                        ele.addClass('enabled');
                    }
                }
                else if( ele.attr('data-merchant-id') !== undefined && parseInt(ele.attr('data-merchant-id')) != 0 && ele.hasClass('enabled') ) {
					//alert('account disabled because merchant is '+ele.attr('data-merchant-id'));
                    ele.removeClass('enabled');
                }
            });
            messageEle.css(hide);
			   }
        },
        selectAccount: function () {
            amountEle.css(hide);
            messageEle.html('Select Account').css(show);
        },
        enterPIN: function () {
            amountEle.css(hide);
            messageEle.html('Enter PIN & Press OK').css(show);
        },
        pinDisplay: function (current) {
            amountEle.css(hide);
            messageEle.html(current.replace(/\d/g, '*')).css(show);
        },
        pinError: function (current) {
            amountEle.css(hide);
            messageEle.html('PIN Incorrect. Retry?').css(show);
        },
        transactionProcessing: function () {
            amountEle.css(hide);
            messageEle.html('Processing Transaction...').css(show);
        },
        transactionComplete: function () {
            amountEle.css(hide);
            messageEle.html('Transaction Complete').css(show);
            checkAccounts();
        },
        transactionFailed: function (msg) {
            amountEle.css(hide);
            messageEle.html( 'Transaction Failed'+((msg==undefined)?'':': '+msg) ).css(show);
            checkAccounts();
        },
        cancelPrompt: function () {
            amountEle.css(hide);
            messageEle.html('Cancel transaction?').css(show);
        },
        transactionCancelled: function () {
            amountEle.css(hide);
            messageEle.html('Transaction cancelled').css(show);
            checkAccounts();
        }
    };

    function parseAndReport(responseText, cb) {
        var responseObj;

        try {
            responseObj = JSON.parse(responseText);
        } catch (e) {
            responseObj = {};
        }

        cb(responseObj);
    }

    function checkForPendingTransactions(callback) {
        PPA.remote.apiCall('payment', {
            request_type: 'PLR'
        }, {
            callback: function () {
                parseAndReport(this.responseText, callback);
           }
        });
    }

    function onPendingTransaction(response) {
        var transactionId;

        if (response.transactions && response.transactions.length > 0) {
            stopPaymentLoop();
            transactionId = response.transactions.pop();
            startPaymentDetailsLoop();
            requestTransactionDetails(transactionId, onTransactionDetails);
        } else {
            window.setTimeout(checkTransactionsLoop, 100);
        }
    }

    function checkAccounts() {
            x$('a.accountName').each(function (l) {
                var ele = x$(l);
                if( ele.attr('data-merchant-id') !== undefined && parseInt(ele.attr('data-merchant-id')) != 0 && ele.hasClass('enabled') ) {
                    ele.removeClass('enabled');
                }
            });
    }

    function isPendingTransactions(t) {
        // not receipient cancelled, not receipient paid, not sender cancelled
        return true;
    }

    function requestTransactionDetails(id, callback) {
        PPA.remote.apiCall('paymentDetails', {},
          {
            callback: function () {
                parseAndReport(this.responseText, callback);
           },
            urlData: {
                tid: id
             }
        });
    }

    function onTransactionDetails(response) {
			   
			var merchant = response.merchant_name + ", " + response.merchant_address,
			   amount = response.amount;
			   
		if( response.distance === undefined && isPhonegap() ) {
                dom.geoCheck(1);
        	//window.setTimeout(checkTransactionDetails, 1500);
                //return;
			   window.setTimeout(checkTransactionDetails, 1500);
		}
		else if( (response.distance !== undefined && response.merchant_accuracy !== undefined && response.distance > response.merchant_accuracy) && isPhonegap() ) {
                dom.geoCheckFailed(merchant, amount, response.merchant_id, response.distance, response.merchant_accuracy);
        	//window.setTimeout(checkTransactionDetails, 1500);
            //    return;
		}
		else {
			   if( !PPA.payment.detailsLoop ) return;
			   //if( response.distance !== undefined ) merchant += ' ('+response.distance+'m)';
			   stopGeo();
			   dom.transactionDetails(merchant, amount, response.merchant_id);
			   
		}
			   PPA.payment.currentTransaction = response.transaction_id;
            
	    if( response.sender_cancelled ) {
                stopPaymentDetailsLoop();
                dom.transactionCancelled();
                window.setTimeout(resetLoop, 5000);
	    }
	    else {
        	window.setTimeout(checkTransactionDetails, 1500);
	    }


        PPA.keypad.reset();
        PPA.keypad.handle('ok', function () {
            stopPaymentDetailsLoop();
            selectAccount();
        }).handle('cancel', function () {
            dom.cancelPrompt();
            stopPaymentDetailsLoop();
            PPA.keypad.handle('ok', function () {
            cancelTransaction(PPA.payment.currentTransaction, onTransactionCancelled);
            }).handle('no', function () {
                //startPaymentDetailsLoop();
                //stopPaymentDetailsLoop();
                selectAccount();
        });
        });
    }

    function selectAccount() {
        dom.selectAccount();
        PPA.keypad.handle('account', function (accountId, accountType) {
            PPA.payment.selectedAccount = accountId;
            PPA.payment.selectedAccountType = accountType;
            enterPIN();
        });
    }

    function enterPIN() {
        dom.enterPIN();
        PPA.keypad.currentVal = '';

        PPA.keypad.handle('numbers', function (num) {
            if (num != '.') {
                PPA.keypad.currentVal += num;
                dom.pinDisplay(PPA.keypad.currentVal);
            }

            if (PPA.keypad.currentVal.length == 4) {
                PPA.keypad.handle('ok', function (num) {
                verifyPIN(PPA.keypad.currentVal);
                });
            }
        }).handle('corr', function () {
            var currentPin = PPA.keypad.currentVal,
                trimmedLength = (currentPin.length - 1);

            PPA.keypad.currentVal = currentPin.substr(0, trimmedLength);
            dom.pinDisplay(PPA.keypad.currentVal);
        });
    }

    function verifyPIN(pinNumber) {
        if ( true ) {
            dom.transactionProcessing();
            confirmTransaction(PPA.payment.currentTransaction,
                DEFAULT_TIP, PPA.payment.selectedAccount, PPA.payment.selectedAccountType, md5(pinNumber), onTransactionConfirmed);
        } else {
            dom.pinError();
            window.setTimeout(function() {
            enterPIN();
            }, 1500);    
        }
    }

    function onTransactionCancelled() {
        dom.transactionCancelled();
        //window.setTimeout(resetLoop, 5000);
        window.setTimeout(function() {
            showTemplate('overview');
        }, 2000);    
    }

    function onTransactionConfirmed() {
        dom.transactionComplete();
        //window.setTimeout(resetLoop, 5000);
        window.setTimeout(function() {
            showTemplate('overview');
        }, 2000);    
    }

    function resetLoop() {
        PPA.keypad.reset();
        dom.defaultState();
        startPaymentLoop();
    }

    function cancelTransaction(id, callback) {
        stopPaymentDetailsLoop();
        PPA.remote.apiCall('paymentCancel', {
            request_type: 'PCR',
            transaction_id: id,
            'cancel-request': 'Cancel Transaction'
        }, {
            callback: function () {
                parseAndReport(this.responseText, callback);
           }
        });
    }

    function confirmTransaction(id, tips, accountId, accountType, pin, callback) {
        PPA.remote.apiCall('paymentConfirm', {
            request_type: 'PPR',
            transaction_id: id,
            tips: tips,
            pin: pin,
            account_type: accountType,
            account_id: accountId,
            'payment-submit': 'Confirm Transaction'
        }, {
            callback: function () {
                try {
                    responseObj = JSON.parse(this.responseText);
                    //alert("Payment Failed: "+responseObj.msg);
                } catch (e) {
                    responseObj = {};
                    //responseObj = 'Unknown Error: empty response';
                }
                if( responseObj.msg == 'OK' ) {
                    stopPaymentDetailsLoop();
                    parseAndReport(this.responseText, callback);
                }
                else {
                    stopPaymentDetailsLoop();
                    dom.transactionFailed(responseObj.msg);
                    window.setTimeout(resetLoop, 2000);
                }
           },
            errback: function () {
                try {
                    responseObj = JSON.parse(this.responseText);
                    dom.transactionFailed(responseObj.msg);
                    //PPA.alert("Payment Failed: "+responseObj.msg);
                } catch (e) {
                    responseObj = {};
                }
                stopPaymentDetailsLoop();
                //dom.transactionFailed();
                window.setTimeout(resetLoop, 2000);
                //PPA.alert('Error:'+this.responseText);
            }
        });
        /*
        //x$('#payment-description')
            x$('#receipts-link').bind('click', function() {
                window.setTimeout(function() {
                    window.location.href = this.href;
                }, 1000);    
            return false;
            });
        */
            x$('#logo-link').bind('click', function() {
                window.setTimeout(function() {
                   showTemplate('overview');
                    //window.location.href = this.href;
                }, 1000);    
            return false;
            });

       
       
    }

    function paymentLoop() {
        // while ongoing:
        //   every 100ms: checkForPendingTransactions
        //      if response.transactions not empty
        //          * get details for the last transaction
        //          * display merchant amount and cost
        //          * user presses OKAY
        //          * display "select account"
        //          * user selects accounts
        //          * display "enter pin and press okay"
        //          * user does so
        //          * display "processing transaction"
        //          * display "transaction complete"
        //          * go to receipts screen
        //
        //      if user presses cancel transaction:
        //          * display "Cancel transaction?"
        //          * user confirms action
        //          * display "Transaction Cancelled"
        //
    }

    function startPaymentLoop() {
        PPA.payment.loop = true;
        dom.defaultState();
        checkTransactionsLoop();
		startGeo();
    }
    exp.startPaymentLoop = startPaymentLoop;

    function stopPaymentLoop() {
        PPA.payment.loop = false;
		stopGeo();
    }
    exp.stopPaymentLoop = stopPaymentLoop;

    function startPaymentDetailsLoop() {
        PPA.payment.detailsLoop = true;
		startGeo();
    }
    
    function stopPaymentDetailsLoop() {
        PPA.payment.detailsLoop = false;
		stopGeo();
    }
    exp.stopPaymentDetailsLoop = stopPaymentDetailsLoop;
    
    function checkTransactionDetails() {
        //if (!PPA.payment.loop) return;
        //alert( !isNaN(PPA.payment.currentTransaction)+', id: '+ PPA.payment.currentTransaction);
        if ( PPA.geo === null && isPhonegap() ) {
            dom.geoCheck(2);
            return;
        }
        else {
            if( PPA.payment.currentTransaction != null && !isNaN(PPA.payment.currentTransaction) && PPA.payment.detailsLoop )
            requestTransactionDetails(PPA.payment.currentTransaction, onTransactionDetails);
        }
    }


    function checkTransactionsLoop() {
        
        if ( PPA.geo === null && isPhonegap() ) {
            //console.log('GEO check');
            dom.geoCheck(3);
            //return;
        }
        else {
            dom.defaultState();
        }
        
        if (!PPA.payment.loop) return;

        checkForPendingTransactions(onPendingTransaction);
    }
    exp.checkTransactionsLoop = checkTransactionsLoop;

    return exp;
})()


