PPA.templates = {};

/*
 * The improved showTemplate()
 * function (identifier, data)
 * data is optional
 * identifier can be "passcode:whatever" or "modal:whatever"
 * remote calls are handled inside
 * ajax for data and template happen in parallel
 *
 */

function handleKeypad(id) {
    var show = {display: 'block'},
        hide = {display: 'none'},
        keypad = x$('#paymentView'),
        main = x$('#mainContent');

    if (id == 'keypad') {
       main.css(hide);
       keypad.css(show);

       PPA.remote.apiCall('accounts.list', {}, {
           callback: function () {
		try {
		    var accountsArray = JSON.parse(this.responseText),
			enabledAccounts = arrayObjQuery(accountsArray, 'account_enabled', 1),
			disabledAccounts = arrayObjQuery(accountsArray, 'account_enabled', 0);
		}
		catch(e) {
		    PPA.alert('Connection error2');
		    PPA.handlers.logout();
		    return;
		}

                x$('a.accountName').each(function (l) {
                    var link = x$(l);

                    if (enabledAccounts.length) {
                        addAccountToDom(enabledAccounts.pop(), link);
                    } else if (disabledAccounts.length) {
                        addAccountToDom(disabledAccounts.pop(), link);
                    }
                });
           }
       });

PPA.payment.startPaymentLoop();

       return true;
    } else {
        keypad.css(hide);
        main.css(show);

        PPA.payment.stopPaymentLoop();
    }
}

function showTemplate(identifier, stage) {
    var tmpl, key, idFn;

    if( PPA.payment != undefined ) {
        if( PPA.payment.loop != undefined && PPA.payment.loop ) PPA.payment.stopPaymentLoop();
        if( PPA.payment.detailsLoop != undefined && PPA.payment.detailsLoop ) PPA.payment.stopPaymentDetailsLoop();
    }
    
    if (handleKeypad(identifier)) return;

    stage = stage || '#mainStage';

    if (idFn = PPA.metaTemplates[identifier])
        identifier = idFn();
    
    key = 'template.' + identifier;

    x$(stage).inner('');

    if (tmpl = window.localStorage.getItem(key)) {
        renderTemplate(tmpl, identifier);
    } else {
        x$().xhr('templates/' + identifier.replace('.','_') + '.tpl', function () {
            window.localStorage.setItem(key, this.responseText);
            renderTemplate(this.responseText, identifier);
        });
    }

    // defined here to close over the stage
    function renderTemplate(template, id) {
    
        var data;

        if (data = PPA.templateAssociations[id])
            template = Mustache.to_html(template, data);

        x$(stage).inner(template);
        
	//console.log('stage: '+stage);    	
	
    	if(stage == '#mainStage') {
	    	if(PPA.scrollers !== undefined) {
	    	    if( PPA.scrollers.main !== undefined) {
	    		//console.log('destroy PPA.scrollers.main1');
	    		PPA.scrollers.main.destroy();
	    	    }
	    	}
	    	else if( PPA.scrollers == undefined) {
	    		//console.log('new PPA.scrollers');
	    	    PPA.scrollers = {};
	    	}
	        PPA.scrollers.main = new iScroll('mainContent');
	} else {
	     	if(PPA.scrollers.modal!=undefined) PPA.scrollers.modal.destroy();
	        PPA.scrollers.modal = new iScroll('modalStage');
	}

        // handle context-specific rendering; i.e. title for modal view
        PPA.stageHandlers.attempt(stage, [template]);

        // bindings - forms, buttons, whatever
        if( PPA.bindings != null ) {
            PPA.bindings.global();
            PPA.bindings.attempt(id);
        }

        // save current state in memory
        PPA.templates.current = id;

	//console.log('main stage: '+PPA.scrollers.main);    	
        window.scrollTo(0,0);
	    setTimeout(function() {
	    	//PPA.scrollers.main.refresh();
	    	//PPA.scrollers.modal.refresh();
	    }, 100);
	    	    
	    x$('select, input[type="submit"]').on('touchstart', function(e){
	    	e.stopPropagation();
	    }, false);
    }
}

function getAssociatedContent(identifier, callback, opt) {
    var data = (opt && opt.data) || {};
//alert(identifier);
    if (PPA.checkRemoteFor.has(identifier)) {
        if (!window.DEVLOCAL) {
            PPA.remote.apiCall(identifier, {},
            {
                callback: function () {
                    var responseObj,
                        responseText = this.responseText;

                    try {
                        responseObj = JSON.parse(responseText);
                    } catch (e) {
                        responseObj = {};
                    }

                    if (identifier == 'accounts.detail' && !responseObj.keys().length) {
                        //PPA.templateAssociations['cc_details'] = responseObj;
                        //PPA.templateAssociations['bank_details'] = responseObj;
                    }
                    if (identifier == 'profile' && !responseObj.keys().length) {
                        // assign profile form variables
                        PPA.templateAssociations['profile_form'] = responseObj;
                        return showTemplate('profile_form');
                    }

                    if (PPA.remote.jsonTransform[identifier]) {
                        responseObj = PPA.remote.jsonTransform[identifier](responseObj);
                    }

                    PPA.templateAssociations[identifier] = responseObj;

                    callback();
                },
                urlData: data
            });
        } else {
            x$().xhr(localTemplatePath(identifier), function () {
                PPA.templateAssociations[identifier] = JSON.parse(this.responseText);
                callback();
            });
        };
    } else {
        callback();
    }
}

function localTemplatePath(id) {
    return 'remote/' + (id.replace('.','_')) + '.json';
}

PPA.templateAssociations = {};

PPA.checkRemoteFor = [
    'messages.list', 'messages.detail', 'receipts.list', 'receipts.detail', 'accounts.list', 'accounts.detail', 'profile',
    'shops.list', 'shops.detail'
]

PPA.metaTemplates = {
    'signout': function () {
        setStatus('logged-out');
        return 'login';
    },
    'logout': function () {
        //showInitialPage();
        //setStatus('logged-out');
        return 'logout';
    }
}

PPA.stageHandlers = {
    attempt: attempt,
    '#mainStage': function (template) {
        setTimeout(function () {
            if (PPA.scrollers.main !== undefined ) PPA.scrollers.main.refresh();
        }, 100);

        x$('input').on('touchmove', preventDefault);
    },
    '#modalWrapper': function (template) {
        var headerData, matches;
        if (matches = template.match(PPA.modal.headerRegex)) {
            headerData = JSON.parse(matches[1]);
            populateModal(headerData);
        }

        showModal();
    }
}

PPA.templates.accountEdit = function (accountObj) {

    if (accountObj.account_type == "10") {
        return "bank_details";
    } else {
        return "cc_details";
    }
}

PPA.templates.populateForm = function (associations, dataObject) {
    var key, input;

    for (key in associations) {
        //alert('populating variable '+key);
        input = x$('input[name=' + key + ']')[0];
        //input = x$('input[name=' + key + '], select[name= '  + key + ']')[0];
        if( input != null ) {
            input.value = dataObject[associations[key]];
            //alert('variable '+key+' populated with '+dataObject[associations[key]]);
        }
        else {
            //alert('input variable '+key+' does not exist, looking for select-option, value: '+associations[key]+':'+dataObject[associations[key]]);
            $selection = x$('#'+key).find('option');
            for (i=0; i<$selection.length; i++) {
                if( $selection[i].value == dataObject[associations[key]]  ) {
                    $selection[i].selected = true;
                }
            }
        }
    }
};

PPA.accounts = {
    fieldMap: {
        cc: {
            details: {
                id: 'account_id',
                creditcardnumber: 'account_safenumber',
                cardtype: 'account_type',
                month: 'account_expiry_month',
                year: 'account_expiry_year'
            },
            name: {
                cardname:'account_name',
                prefix: 'user_prefix',
                street: 'address_street',
                nickname: 'account_name',
                firstname: 'account_firstname',
                lastname: 'account_lastname',
                city: 'address_city',
                state: 'address_state',
                zip: 'address_zip',
                securitynumber: 'account_security_number',
                securitypin: 'account_security_pin'
            }
        }
    }
};
