x$(document).on('DOMContentLoaded', function () {

    showInitialPage();

    x$(document).on('click', linkDelegator);
    
    //x$('#modalBack').on('touchstart', PPA.modal.backModal);
    //x$('#modalDetail').on('touchstart', PPA.modal.modalDetail);
    x$('#modalBack').on('click', PPA.modal.backModal);
    x$('#modalDetail').on('click', PPA.modal.modalDetail);

    // iScroll initialization
    document.addEventListener('touchmove', function (e) { 
	PPA.timeout_start = new Date();
        e.preventDefault();  
    }, false);
    document.addEventListener('touchstart', function (e) { 
        PPA.timeout_start = new Date();
	//e.preventDefault();  
    }, false);
    PPA.scrollers = {};
    //PPA.scrollers.main = new iScroll('mainContent', { bounce: false });
    PPA.scrollers.modal;
    //PPA.scrollers.main;
    //PPA.scrollers.modal = new iScroll('modalStage');
    PPA.scrollers.main = new iScroll('mainContent');
    
    // 55 seconds Passcode Timeout
	PPA.timeout_enabled = true;
    PPA.timeout_start = new Date();
    PPA.timeout_increment = 55*1000;
	PPA.timeout_check = 5*1000;

    document.addEventListener("resume", onResume, false);
    document.addEventListener("pause", onResume, false);

    function onResume() {
        // Handle the pause event
	PPA.timeout_enabled = false;
	PPA.payment.stopPaymentLoop();
	PPA.payment.stopPaymentDetailsLoop();
	PPA.handlers.logout();
        //showInitialPage();
    }    
    
    //startPasscodeTimer();

});

    function startPasscodeTimer() {
	PPA.timeout_enabled = true;
	window.setInterval(function () {
	    if( PPA.timeout_enabled && PPA.timeout_start.getTime()+PPA.timeout_increment < new Date().getTime()) {
		PPA.timeout_enabled = false;
		PPA.payment.stopPaymentLoop();
		PPA.payment.stopPaymentDetailsLoop();
		//PPA.passcode.handlers.logout();
		PPA.handlers.logout();
	    }
	}, PPA.timeout_check);
    }

function linkDelegator(e) {
    var link, template, returnValue = true;
    //alert('click');
    PPA.timeout_start = new Date();
    //console.log('linkDelegator');
    
    if (e.target.nodeName === 'SELECT' || e.target.nodeName === 'TEXTAREA') {
	//e.stopPropagation();
        //e.target.focus();
        return true;
    }
    if (e.target.nodeName == 'INPUT') {
	//e.stopPropagation();
        //e.target.focus();
        return true;
    }
    // event delegation for links
    if (e.target.nodeName == 'A') {
        link = x$(e.target);
        if (link.hasClass('local')) {
            template = link.attr('href')[0].split('#')[1];
            showTemplate(template);

            returnValue = false;
        } else if (link.hasClass('modal')) {
        	
        	//if(document.activeElement) document.activeElement.blur();
        
            if (PPA.templates.current != 'overview' || modalShowing()) {
                //console.log('PPA.templates.current1:'+PPA.templates.current);
                PPA.modal.stackModal(PPA.templates.current);
            }
            else {
                //console.log('PPA.templates.current1 not included:'+PPA.templates.current);
            }

            template = link.attr('href')[0].split('#')[1];

            getAssociatedContent(template, function () {
                showTemplate(template, '#modalWrapper');
            }, {
                data: link.data()
            });

            returnValue = false;
        }
    }
	
    return returnValue;
}

function preventDefault(e) {
    e.preventDefault();
    return false;
}

function showInitialPage() {
    var page = window.startPage || 'register',
        identifier;

    if (page.match(':'))
        identifier = page.split(':')[1];
    if (page.match('passcode')) {
        passcodePrompt(identifier);
    } else if (page.match('modal')) {
        if (PPA.templates.current != 'overview' || modalShowing()) {
                //console.log('PPA.templates.current2:'+PPA.templates.current);
            PPA.modal.stackModal(PPA.templates.current);
        }
        else {
                //console.log('PPA.templates.current1 not included:'+PPA.templates.current);
        }

        getAssociatedContent(identifier, function () {
            showTemplate(identifier, '#modalWrapper');
        })
    } else {
        showTemplate(page);
    }
}
