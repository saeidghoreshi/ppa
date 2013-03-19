function backToOverview() {
    showTemplate('overview');
    return false;
}

PPA.form = {
    asObject: function (id) {
        var $form = x$('#' + id),
            $inputs = $form.find('input, select'),
            i = 0,
            obj = {},
            key;

        for (i; i<$inputs.length; i++) {
            key = $inputs[i].name;
            if (key)
                obj[key] = $inputs[i].value;
        }

        return obj;
    }
}

PPA.validate = {
    phone: function (num) {
        return num.length == 10 || num.length == 11;
   }
}

PPA.handlers = {
    input: function () {
        //passcodePrompt('temporary');
        //alert('input');
        return false;
    },
    signup: function () {
        var email    = x$('#signupForm input[name=email]')[0].value,
            number   = x$('#signupForm input[name=phone]')[0].value,
            checkbox = x$('#termsBox')[0];

        if ( !email || !number) {
            PPA.alert(PPA.strings.phoneEmailRequired);
            return false;
        }
	
        if (!checkbox.checked) {
            PPA.alert(PPA.strings.tosNotice);
            return false;
        }

        // TODO: validate fields

        PPA.remote.apiCall('signup', {
            email: email,
            phone: number
        }, {
            callback: function () {
		var response = JSON.parse(this.responseText);
		console.log(response);
	    
		if( response.status == 'OK' || response.status == 'success' ) {
		    PPA.store.set('phone', number);
		    PPA.store.set('email', email);
		    setStatus('awaiting');
		    showTemplate('activate');
		}
		else {
		    PPA.alert(response.status);
		}
            },
            errback: function () {
		try {
		    var response = JSON.parse(this.responseText);
		    PPA.alert(response.status);
		}
		catch(e) {
		    PPA.alert(this.responseText);
		}
            }
        });

        return false;
    },
    login: function () {
        var code     = x$('#loginForm input[name=passcode]')[0].value,
            number   = x$('#loginForm input[name=phone]')[0].value;

        PPA.remote.apiCall('login', {
            passcode: code,
            phone: number
        },
        {
            callback: function () {
                PPA.store.set('phone', number);
		window.startPage = 'passcode:standard';
		startPasscodeTimer();
                setStatus('confirmed');
                showTemplate('overview');
            },
            errback: function () {
                PPA.alert('That was incorrect - please try again');
            }
        });

        return false;
    },
    logout: function () {
	
	showInitialPage();

        PPA.remote.apiCall('logout', {
            phone: PPA.store.get('phone')
        },
        {
            callback: function () {
                //showInitialPage();
            },
            errback: function () {
                //showInitialPage();
            }
        });
	return false;
    },
    activate: function () {
        passcodePrompt('temporary');
        return false;
    },
    smsShare: function () {
        var $num = x$('#smsShare input[name=phone]'),
            number = $num[0].value;

        if (PPA.validate.phone(number)) {
            PPA.remote.apiCall('sms', {
                phone: number,
                message: PPA.strings.smsMsg
            }, {
                callback: function () {
                    $num[0].value = '';
                    PPA.alert(PPA.strings.smsSuccess);
                }
            });
        } else {
            PPA.alert(PPA.strings.invalidPhone);
        }

        return false;
    },
    profileForm: function () {
        // objectize form data
        PPA.profileFormData = PPA.form.asObject('profileForm');

        // assign profile form variables
        PPA.templateAssociations['security_form'] = PPA.templateAssociations['profile_form'];
        
        showTemplate('security_form');

        return false;
    },
    securityForm: function () {
        var formData = PPA.form.asObject('securityForm');

        mixin(formData, PPA.profileFormData);
        PPA.remote.apiCall('profileEdit', formData, {
            callback: function () {
                showTemplate('profile_submitted');
            }
        });

        return false;
    },
    accountSaved: function () {
        showTemplate(PPA.homepage);
        return false;
    },
    acceptProfile: backToOverview,
    bankStandby: backToOverview,
    accountType: function () {
        var rawType = x$('#accountTypeField')[0].value,
            typeArr,
            nextForm;

        if (rawType.match('pp')) {
	    match = PPA._cookie.match( new RegExp('[; ]*PHPSESSID=([^\\s;]*)') );
	    x$('#session').attr('value', match[1]);
	    x$('#accountTypeForm').attr('action', 'https://www.payphoneapp.com/account/paypal/session');
	    //x$('#accountTypeForm').attr('target', '_blank');
	    //x$('#accountTypeForm').submit();
	    PPA.timeout_enabled = false;
	    return false;
	}

	PPA.remote.apiCall('profile', {}, {
           callback: function () {
            var profile = JSON.parse(this.responseText);
            PPA.acctFormData.firstname = profile.firstname;
            PPA.acctFormData.lastname = profile.lastname;
            PPA.acctFormData.country = profile.country;
           }
       });

        if (!rawType.match('_')) return false;

        typeArr = rawType.split('_');

        if (typeArr[0] != '10') {
            nextForm = 'cc_details';
        } else {
            nextForm = 'bank_details';
        }
//alert('nextForm: '+nextForm);
        PPA.acctType = typeArr[1];
        PPA.acctFormData = {
            'accounttype': typeArr[0]
        }
//alert('typeArr[0]: '+typeArr[0]);
        showTemplate(nextForm);

        return false;
    },
    ccDetails: function () {
        if( PPA.acctFormData == null )PPA.acctFormData = PPA.templateAssociations['accounts.detail'];
        mixin(PPA.acctFormData, PPA.form.asObject('ccDetailsForm'));
        
    showTemplate('cc_name');

        return false;
    },
    bankDetails: function () {
        mixin(PPA.acctFormData, PPA.form.asObject('bankDetailsForm'));

        showTemplate('bank_name');
        return false;
    },
    ccName: function () {

        mixin(PPA.acctFormData, PPA.form.asObject('ccNameForm'));
        var formAction = PPA.acctFormAction || 'add',
            endpoint = (PPA.acctFormAction == 'add') ?
                        'accounts.create' : 'accounts.update';

        if (formAction != 'add') {
            try {
            PPA.acctFormData.accounttype = PPA.acctFormData.cardtype;
            //PPA.acctFormData.nickname = PPA.acctFormData.nickname;
            //
            PPA.acctFormData.firstname = PPA.acctFormData.account_firstname;
            PPA.acctFormData.lastname = PPA.acctFormData.account_lastname;
            PPA.acctFormData.country = PPA.acctFormData.address_country;
            
            //PPA.templateAssociations['accounts.detail'].month = PPA.acctFormData.month;
        
            } catch (e) {
                PPA.alert('Error: '+e);
            }
        }
        else {
            //PPA.acctFormData.nickname = PPA.acctFormData.cardname;
            PPA.acctFormData.accounttype = PPA.acctFormData.cardtype;
        }


//alert('post: '+objectToString(PPA.acctFormData));

        PPA.remote.apiCall(endpoint, PPA.acctFormData, {
            callback: function () {
                //PPA.alert('Account Saved!');
                showTemplate('account_saved');
                //showTemplate(PPA.homepage);
            }
        });

        return false;
    },
    bankName: function () {
        mixin(PPA.acctFormData, PPA.form.asObject('bankNameForm'));

        var formAction = PPA.acctFormAction || 'add',
            endpoint = (formAction == 'add') ?
                        'accounts.create' : 'accounts.update';

        if (formAction != 'add')
            PPA.acctFormData.id = PPA.templateAssociations['accounts.detail'].account_id;

        PPA.remote.apiCall(endpoint, PPA.acctFormData, {
            callback: function () {
                showTemplate('bank_pending');
            }
        });

        return false;
    },
    suspendAccount: function () {
        var accountId = PPA.templateAssociations['accounts.detail'].account_id,
            urlData = {account_id: accountId};

        PPA.remote.apiCall('accounts.suspend', {}, {
            urlData: urlData
        });

        PPA.modal.backModal();
        return false;
    },
    saveAnnotation: function () {
       var noteText = x$('textarea#annotation')[0].value,
           receiptId = PPA.templateAssociations['receipts.detail'].transaction_id;

       PPA.remote.apiCall('receipts.annotate', {
           annotation: noteText,
           id: receiptId
       }, {
           callback: function () {
                PPA.alert('Annotation Saved');
           }
       });

       return false;
    },
    newReceipt: function (id) {
        if (id)
            PPA.modal.loadNewReceipt(id);

        return false;
    },
    previousReceipt: function () {
       return PPA.handlers.newReceipt(PPA.modal.previousReceipt());
    },
    nextReceipt: function () {
       return PPA.handlers.newReceipt(PPA.modal.nextReceipt());
    },
    trashReceipt: function () {
       var currentId = PPA.templateAssociations['receipts.detail'].transaction_id;
       if ( PPA.confirm('Do you want to flag this transaction?') ) {
            PPA.remote.apiCall('receipts.flag', {
                id: currentId,
                flagged: 1
            }, {
                callback: function () {
                    PPA.alert('Transaction Flagged');
                }
            });
       }

       return false;
    }
}

PPA.bindings = {
    attempt: attempt,
    'global': function () {
    },
    'register': function () {
        x$('#signupForm').on('submit', PPA.handlers.signup);
    },
    'login': function () {
        x$('#loginForm').on('submit', PPA.handlers.login);
    },
    'activate': function () {
        x$('#activateButton').on('touchstart', PPA.handlers.activate);
    },
    'overview': function () {
        x$('#smsShare').on('submit', PPA.handlers.smsShare);
    },
    'profile_form': function () {
        x$('#profileForm').on('submit', PPA.handlers.profileForm);
    },
    'security_form': function () {
        x$('#securityForm').on('submit', PPA.handlers.securityForm);
    },
    'profile_submitted': function () {
        x$('#acceptProfile').on('touchstart', PPA.handlers.acceptProfile);
    },
    'account_saved': function () {
        x$('#accountSaved').on('touchstart', PPA.handlers.accountSaved);
    },
    'bank_pending': function () {
        x$('#bankStandby').on('touchstart', PPA.handlers.bankStandby);
    },
    'account_type': function () {
        x$('#accountTypeForm').on('change', PPA.handlers.accountType);
        x$('#accountTypeForm').on('submit', function () {
		var rawType = x$('#accountTypeField')[0].value;
		if (!rawType.match('pp')) {
		    getAssociatedContent('accounts.list', function () {
			showTemplate('accounts.list', '#modalWrapper');
		    });
		    return false;
		}
		else return true;
            }
        );
    },
    'cc_details': function () {
        var formAction = PPA.acctFormAction || 'add',
            title = PPA.strings.accountForm[formAction],
            currentData;

        x$('h2').inner(title);

        if (formAction == 'edit') {
            currentData = PPA.templateAssociations['accounts.detail'];
            PPA.templates.populateForm(PPA.accounts.fieldMap.cc.details, currentData);
        }

        if (PPA.acctType)
            x$('#cardTypeField')[0].value = PPA.acctType;

        x$('#ccDetailsForm').on('submit', PPA.handlers.ccDetails);

    },
    'bank_details': function () {
        var formAction = PPA.acctFormAction || 'add',
            title = PPA.strings.accountForm[formAction];

        x$('h2').inner(title);

        if (PPA.acctType)
            x$('#bankTypeField')[0].value = PPA.acctType;
        x$('#bankDetailsForm').on('submit', PPA.handlers.bankDetails);
    },
    'cc_name': function () {
        var currentData,
            formAction = PPA.acctFormAction || 'add';

        if (formAction == 'add') PPA.form.populateFromProfile()

        if (formAction == 'edit') {
            currentData = PPA.templateAssociations['accounts.detail'];
            PPA.templates.populateForm(PPA.accounts.fieldMap.cc.name, currentData);
        }

        x$('#ccNameForm').on('submit', PPA.handlers.ccName);
    },
    'bank_name': function () {
        var currentData,
            formAction = PPA.acctFormAction || 'add';

        if (formAction == 'add') PPA.form.populateFromProfile()

        if (formAction == 'edit') {
            currentData = PPA.templateAssociations['accounts.detail'];
            PPA.templates.populateForm(PPA.accounts.fieldMap.cc.name, currentData);
        }

        x$('#bankNameForm').on('submit', PPA.handlers.bankName);
    },
    'accounts.detail': function () {
        x$('#suspendButton').on('touchstart', PPA.handlers.suspendAccount);
    },
    'receipts.detail': function () {
        // setting up email link
        // get trimmed contents of pre.receiptText
        var mailtoLink = 'mailto:?subject={transaction_id}&body={receipt_text}',
            text = encodeURIComponent( x$('.receiptText')[0].innerText.trim() ),
            id = PPA.templateAssociations['receipts.detail'].transaction_id;

        mailtoLink = nanoTemplate(mailtoLink, {transaction_id: id, receipt_text: text});
        x$('a.footButton#export').attr('href', mailtoLink);
        x$('a.footButton#export').attr('target', '_blank');
        //x$('a.footButton#export').attr('href', '#');
		//x$('a.footButton#export').attr('onClick', 'console.log("' + mailtoLink + '");');
		
        x$('#saveAnnotation').on('touchstart', PPA.handlers.saveAnnotation);
        x$('.footButton#previous').on('touchstart', PPA.handlers.previousReceipt);
        x$('.footButton#next').on('touchstart', PPA.handlers.nextReceipt);
        x$('.footButton#trash').on('touchstart', PPA.handlers.trashReceipt);
    }
}

PPA.form.populateFromProfile = function () {

    function setFieldValue(name, val) {
        var selection = x$('input[name=' + name + ']');

        if (selection.length == 1)
            selection[0].value = val;
    }

    var profile = PPA.templateAssociations['profile'];
    if (!profile) return;

    setFieldValue('cardname', profile.firstname + ' ' + profile.lastname);
    setFieldValue('street', profile.street);
    setFieldValue('city', profile.city);
    setFieldValue('state', profile.state);
    setFieldValue('zip', profile.zip);
}
