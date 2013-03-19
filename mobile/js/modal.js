PPA.modal = {
    headerRegex: /headerData = (\{.*\})/,
    displayedStyle: {
        "display":"inline", 
        "top":"0",
        "-webkit-transition-timing-function":"ease-in"
    },
    hiddenStyle: {
        "display":"none", 
        "top:":"460px",
        "-webkit-transition-timing-function":"ease-out"
    }
}

function showModal() {
    x$("#modalView").css(PPA.modal.displayedStyle);
    //console.log('modal refresh 1');
    //console.log(PPA.scrollers.modal);
    //console.log(PPA.scrollers.main);
    if( PPA.scrollers.modal !== undefined )PPA.scrollers.modal.refresh();
    //console.log('modal refresh 2');
}

function hideModal() {
    x$("#modalView").css(PPA.modal.hiddenStyle);
}

function populateModal(opt) {
    var xMod = x$('#modalDetail');
    opt.back = opt.back || 'Back';
    x$('#modalTitle').inner(opt.title);
    x$('#modalBack').inner(opt.back);

    if (opt.detail) {
        xMod.inner(opt.detail).css({display:'block'});
    } else {
        xMod.css({display:'none'});
    }
    //console.log('modal refresh 3');
    if( PPA.scrollers.modal !== undefined ) PPA.scrollers.modal.refresh();
    //console.log('modal refresh 4');
}

function modalShowing() {
    webkit_transform = (x$('#modalView')[0])['-webkit-transform'];
    if( webkit_transform == undefined ) return true;
    return !!(getComputedStyle(webkit_transform.match('6')));
}

var modalBack = (function (scope) {
    var stack = [];

    scope.stackModal = function (previous) {
        if( previous == 'cc_details' || previous == 'cc_name' || previous == 'account_type' || previous == 'profile_form1' || previous == 'security_form' ) {
            stack.pop(previous);
        }
        else if( previous == 'overview' && stack.length != 0 ) {
            stack.pop(previous);
        }
        else {
            stack.push(previous);
        }
        //console.log('stack.length:'+stack.length+', template: '+previous);
    }

    scope.backModal = function () {
        if (stack.length) {
            stack_template = stack.pop();
            //console.log('modal 1: '+stack_template);
            if( stack_template == 'overview' ) {
                hideModal();
                showTemplate('overview');
            }
            else {
                showTemplate(stack_template, '#modalWrapper');
            }
            //showTemplate(stack.pop());
        } else {
            //console.log('modal 2');
            hideModal();
            showTemplate('overview');
        }
    }
    
})(PPA.modal);

PPA.modal.modalDetail = function (e) {
    var deets = PPA.modal.details;

    if (deets[PPA.templates.current])
        deets[PPA.templates.current]();
}

PPA.modal.details = {
    'profile': function () {
        var templateData = PPA.templateAssociations;
        templateData.profile_form = templateData.profile;

        hideModal();
        showTemplate('profile_form');
    },
    'accounts.list': function () {
        hideModal();
        PPA.acctFormAction = 'add';
        showTemplate('account_type');
    },
    'accounts.detail': function () {
        var tmpl = PPA.templates.accountEdit(PPA.templateAssociations["accounts.detail"]);
        hideModal();

        PPA.acctFormAction = 'edit';
        showTemplate(tmpl);
    },
    'receipts.detail': function () {
        x$('textarea#annotation')[0].focus();
        return false;
    }
}

PPA.modal.receiptHelper = function (direction) {
    var currentReceipt = PPA.templateAssociations['receipts.detail'].transaction_id,
        receiptsIds = PPA.templateAssociations['receipts.list'].receipts.map(function (r) {
            return r.transaction_id;
        }),
        currentIndex = receiptsIds.indexOf(currentReceipt);

    if (direction == 'previous') {
        return (currentIndex == 0) ? false : receiptsIds[currentIndex - 1];
    } else if (direction == 'next') {
        return (currentIndex == (receiptsIds.length - 1)) ? false : receiptsIds[currentIndex + 1];
    }
}

PPA.modal.previousReceipt = function () {
    return this.receiptHelper('previous');
}

PPA.modal.nextReceipt = function () {
    return this.receiptHelper('next');
}

PPA.modal.loadNewReceipt = function (id) {
    getAssociatedContent('receipts.detail', function () {
        showTemplate('receipts.detail', '#modalWrapper');
    }, {
        data: {
            receipt_id: id
        }
    });
}
