function paramsToData(params) {
    var pString = [];

    for (var o in params) {
        if (params.hasOwnProperty(o))
            pString.push(o + '=' + encodeURIComponent(params[o]));
    }

    return pString.join('&');
}

function objectToString(o){
    
    var parse = function(_o){
    
        var a = [], t;
        
        for(var p in _o){
        
            if(_o.hasOwnProperty(p)){
            
                t = _o[p];
                
                if(t && typeof t == "object"){
                
                    a[a.length]= p + ":{ " + arguments.callee(t).join(", ") + "}";
                    
                }
                else {
                    
                    if(typeof t == "string"){
                    
                        a[a.length] = [ p+ ": \"" + t.toString() + "\"" ];
                    }
                    else{
                        a[a.length] = [ p+ ": " + t.toString()];
                    }
                    
                }
            }
        }
        
        return a;
        
    }
    
    return "{" + parse(o).join(", ") + "}";
    
}

PPA.remote = (function () {
    var domain = 'https://www.payphoneapp.com'
    var workDir = '';
    //var domain = 'http://test.payphoneapp.com'
    //var workDir = '/V2-dmitry';
    var basePath = domain+workDir+'/index.php/',
        postOpts = {
            async: true,
            method: 'POST'
        },
        postHeaders = [{
            name: 'Content-Type',
            value: 'application/x-www-form-urlencoded'
        }],
        endpoints = {
            logout: 'user/logout',
            login: 'user/login',                // email, passcode
            signup: 'user/create',              // email, phone
            verify: 'user/confirm',             // token
            newPasscode: 'user/new_passcode',   // passcode, confirmpasscode
            sms: 'sms_twilio/send',             // phone, message
            profileEdit: 'user/update',         // with appropriate data
            profile: 'user',                    // GET
            accounts: {
                list: 'account',                // GET
                detail: 'account/info/{account_id}',      // GET
                suspend: 'account/disable/{account_id}',   // GET
                update:    'account/update',         // with account_id param
                create:  'account/create'
            },
            messages: {
                list: 'message',
                detail: 'message/info'        // with id param
            },
            shops: {
                list: 'shops',
                detail: 'shops/get_details'        // with id param
            },
            receipts: {
                list: 'transaction',
                detail: 'transaction/info',        // with id param
                annotate: 'transaction/annotation', // with annotation + id
                flag:   'transaction/flag'          // with flagged + id
            },
            paymentRequest: 'payment',
            payment: domain+workDir+'/queue2.php',
            paymentDetails: domain+workDir+'/queue2.php?transaction_id={tid}&ajax=true',
            paymentConfirm: domain+workDir+'/queue2.php?ajax=true',
            paymentCancel: domain+workDir+'/queue2.php?ajax=true'
        },
        sansCookie = ['login', 'signup', 'logout', 'terms'],
        getToken = '!GET ',
        currentStatus = '';

    function defaultCallback() {
        //console.log('request successful');
    }

    function defaultError() {
        //PPA.alert('oops -- something went wrong');
        if( currentStatus != '' ) {
            PPA.alert(currentStatus);
            currentStatus = '';
        }
        //else PPA.alert('oops -- something went wrong');
    }

    function resolvePath(target) {
        var o = endpoints, a = target.split('.');

        while (a.length) {
            o = o[a.shift()];
        }

        if (o.match(/^http/)) return o;

        return basePath + o;
    }

    function apiCall(target, params, opt) {
        var path             = resolvePath(target),
            options          = clone(postOpts),
            params           = params || {},
            callback         = opt.callback || defaultCallback;
            errback          = opt.errback || defaultError;

        // hack until sms works from v2-steve
        if (target == 'sms') path = path.replace('steve', 'dmitry');

        options.headers  = clone(postHeaders);

        if (PPA.cookie() && !sansCookie.has(target)) {
            options.headers.push({
                name: 'Cookie',
                value: PPA.cookie()
            });
        }
        
        if( PPA.geo != null ) {
            params.latitude = PPA.geo.coords.latitude;
            params.longitude = PPA.geo.coords.longitude;
            params.geots = PPA.geo.timestamp;
            //alert(params.latitude+':'+params.longitude+':'+params.geots);
        }
        else {
            //params.latitude = 49.283316;
            //params.longitude = -123.103867;
            //params.geots = new Date();
            //alert('geo failed');
        }
        
        if( window.device ) params.uuid = window.device.uuid;
        else params.uuid = 'emulator';

        if (opt.urlData)
            path = nanoTemplate(path, opt.urlData);

        if (target == "receipts.detail")
            params.id = opt.urlData.receipt_id;
        
        if (target == "messages.detail")
            params.id = opt.urlData.message_id;

        if (target == "shops.detail")
            params.shop_id = opt.urlData.merchant_id;

        params = mixin(params, { json: 1 });
        options.data     = paramsToData(params);
        options.callback = function () {
            var ckie = this.getResponseHeader('Set-Cookie');

            if (ckie) PPA.cookie(ckie);

            var responseObj;

            try {
                responseObj = JSON.parse(this.responseText);
            } catch (e) {
                responseObj = {};
            }

            if( responseObj != null ) {
                if( responseObj != null && responseObj.status != null && responseObj.status != 'success' && responseObj.status != 'OK' && responseObj.status != 'sent' && responseObj.status != true ) {
                    PPA.alert(''+responseObj.status);
                }
                else {
                    callback.call(this);
                }
            }
	    else {
                    PPA.alert('Connection error1');
	    }

        }
        
        options.error    = errback;

        x$().xhr(path, options);
    }

    return {
        apiCall: apiCall,
        endpoints: endpoints
    }
})();

PPA.remote.jsonTransform = {
    naFields: function(obj, fields) {
        var i, field;

        for (i=0; i<fields.length; i++) {
            field = fields[i];
            obj[field] = obj[field] || "N/A";
        }

        return obj;
    },
    "accounts.add": function (arr) {
        hideModal();
        PPA.acctFormAction = 'add';
        showTemplate('account_type');
    },
    "accounts.list": function (arr) {
        var i=0, acct;
        if (!isArray(arr)) return {};

        for (i; i<arr.length; i++) {
            acct = arr[i];

            //acct = this.naFields(acct, ["available"]);
            //acct.available = PPA.templateAssociations['receipts.list'].receipts
            //acct.status = PPA.acctFormData.account_enabled;
            
            /*acct.last_activity = acct.last_activity || {
                cost: "N/A",
                date: "N/A"
            };*/
            
            if( acct.transaction_amount!=null ) {
            acct.last_activity = acct.last_activity || {
                cost: ((acct.transaction_amount!=null)?acct.transaction_amount:''),
                date: ((acct.transaction_datetime_paid!=null)?acct.transaction_datetime_paid:'')
            };
            }

            
        }

        return { accounts: arr };
    },
    "accounts.detail": function (obj) {
        var types = {
            "1": "Visa",
            "2": "Mastercard",
            "3": "American Express",
            "10": "Bank Account"
        }
        var status = {
            "0": "Pending",
            "1": "Active"
        }

        obj["last_activity"] = obj["last_activity"] || {
            cost: ((obj.transaction_amount!=null)?obj.transaction_amount:"N/A"),
            date: ((obj.transaction_datetime_paid!=null)?obj.transaction_datetime_paid:"N/A")
        }
        //obj = this.naFields(obj, ["available", "status"]);
        obj = this.naFields(obj, ["available"]);
        obj.account_type_name = types[obj.account_type];
        obj.status = status[obj.account_enabled];

        return obj;
    },
    "messages.list": function (arr) {
        if (!isArray(arr)) return {};
        return { messages: arr }
    },
    "messages.detail": function (obj) {
        var o = obj.result,
            messagesList = PPA.templateAssociations['messages.list'].messages,
            i;
            
        o.count = messagesList.length;

        for (i=0; i<messagesList.length; i++) {
            if (messagesList[i].message_id == o.message_id)
                o.number = i+1;
        }
        return o;
    },
    "shops.list": function (arr) {
        if (!isArray(arr)) return {};
        return { shops: arr }
    },
    "shops.detail": function (obj) {
        var o = obj.result,
            shopsList = PPA.templateAssociations['shops.list'].shops,
            i;
            
        o.count = shopsList.length;

        for (i=0; i<shopsList.length; i++) {
            if (shopsList[i].merchant_id == o.merchant_id)
                o.number = i+1;
        }
        return o;
    },
    "receipts.list": function (arr) {
        if (!isArray(arr)) return {};
        return { receipts: arr }
    },
    "receipts.detail": function (obj) {
        var o = obj.result,
            receiptsList = PPA.templateAssociations['receipts.list'].receipts,
            i;

        o.count = receiptsList.length;

        for (i=0; i<receiptsList.length; i++) {
            if (receiptsList[i].transaction_id == o.transaction_id)
                o.number = i+1;
        }

        o.vendor        = o.vendor || {};
        o.vendor = this.naFields(o.vendor, ["name", "address-one", "address-two", "phone"]);

        o.transaction   = o.transaction || {};
        o.transaction = this.naFields(o.transaction, ["number", "paytype", "account", "confirmation"]);

        o.transaction.items = o.transaction.items || [{
            name: "N/A",
            price: "N/A"
        }];
        o.items         = o.items || [];

        o.price         = o.price || {};
        o.price = this.naFields(o.price, ["subtotal", "hst", "total"]);

        return o;
    }
};
