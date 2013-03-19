$(document).ready( function() {
	$('.default-value').each(function() {
		var default_value = this.value;
		var prompt_value = $(this).attr('title');
		if(!default_value) {
			this.value = prompt_value;
			$(this).addClass('waiting-user-input');
		}
		$(this).focus(function() {
			if(this.value == prompt_value) {
				$(this).removeClass('waiting-user-input');
				this.value = '';
			}
		});
		$(this).blur(function() {
			if(this.value == '') {
				$(this).addClass('waiting-user-input');
				this.value = prompt_value;
			}
		});
	});

	if($('#payment-dialog').length) {
		var uri = '/payments/check-pending-payment';

		$.PeriodicalUpdater({
				url : baseUrl + uri
			},
			function(jsonString) {
				var json = eval('(' + jsonString + ')');
				if(json.status=='1') { // new payment request
					$.ajax({
						url: baseUrl + '/payments/ajax-payment-window/?billId=' + json.billId,
						success: function(paymentWindowHtml) {
							$('#payment-dialog').html(paymentWindowHtml);
						}
					});
				} else if($('#billid').val().length>0) {
					$.ajax({
						url: baseUrl + '/payments/check-bill-status/?id=' + $('#billid').val(),
						success: function(jsonString) {
							var json = eval('(' + jsonString + ')');
							if(json.status=='-1') {
								$('#payment-amount').html('');
								$('#payment-message').html(json.currentBillMessage);
								setTimeout(reset_keypad, 4000);
							}
						}
					});
				}
			}
		);
	}

	$('#sort-button').click( function() {
		$('#sort-dialog').show();
		return false;
	});
	$('#sort-close-button').click( function() {
		$('#sort-dialog').hide();
		return false;
	});
	$('#annotate-button, #annotate-dialog textarea').click( function() {
		$('#annotate-dialog').show();
		$('#annotate-dialog .buttons').show();
		$('#annotate-dialog textarea').focus();
		return false;
	});
	$('#annotate-close-button').click( function() {
		$('#annotate-dialog').hide();
		$('#annotate-dialog .buttons').hide();
		return false;
	});
	


	$('.keypad a').live('touchstart mousedown', function(event) {
		event.preventDefault();
		//console.log(event.originalEvent.touches.length);
		var value = $(this).attr('name'); // button values are given through the html name attr
		if(isNumeric(value)) {
			// no action
		} else if(value=='corr') {
			// no action
		} else if(value=='ok') {
			prompt_account();
		} else if(value=='no') {
			prompt_cancel();
		} else if(value=='cancel') {
			prompt_cancel();
		}
		
		$(this).addClass('active');
		return false;
	});
	
	$('.keypad a, #payment-accounts a').live('touchend mouseup', function(event) {
		event.preventDefault();
		//console.log(event.originalEvent.touches.length);
		$(this).removeClass('active');
		return false;
	});


	$(window).load(function(){
	});
});


var select_account_text = "Select Account";
var prompt_pin_text = "Enter PIN & Press OK";
var submitting_payment_text = "Processing Transaction...";
var checking_requests_text = "<strong>Checking for Payment Requests...</strong>";
var confirm_cancel_text = "Cancel Transaction?";
var canceling_text = "Cancelling Transaction...";

var default_handler = function(event) {
	event.preventDefault();
	//console.log(event.originalEvent.touches.length);
	$(this).addClass('active');
	return false;
}

function reset_key_binds(element) {
	element.unbind('touchstart mousedown');
	element.bind('touchstart mousedown', default_handler);
}

function reset_keypad() {
	reset_key_binds($('.keypad a, #payment-accounts a.enabled'));
	$('#payment-message').html('');
	$('#payment-amount').html('');
	$('#payment-description').html(checking_requests_text);
}

function prompt_account() {
	reset_key_binds($('.keypad a.ok, .keypad a.numbers'));
	$('#payment-message').html(select_account_text);
	$('#payment-amount').hide();
	$('#pin').val('');
	$('#payment-accounts a.enabled').bind('touchstart mousedown', function(event) {
		event.preventDefault();
		$(this).addClass('active');
		var accountid = $(this).attr('name');
		$('#accountid').val(accountid);
		prompt_pin(prompt_pin_text);
		return false;
	});
	$('#payment-accounts a.enabled').bind('touchend mouseup', function(event) {
		event.preventDefault();
		//console.log(event.originalEvent.touches.length);
		$(this).removeClass('active');
		return false;
	});
}


function prompt_pin(message) {
	$('#payment-accounts a.enabled').unbind('touchstart mousedown');
	$('#payment-message').html(message);
	$('#pin').val('');
	$('#pin-stars').html('');

	reset_key_binds($('.keypad a.ok, .keypad a.corr, .keypad a.numbers'));
	$('.keypad a.numbers').bind('touchstart mousedown', function(event) {
		var value = $(this).attr('name'); // button values are given through the html name attr
		$('#payment-message').html('');
		var pin_html = $('#pin-stars').html();
		$('#pin-stars').html(pin_html + ' *');
		var pin_val = $('#pin').val();
		$('#pin').val(pin_val + value);
	});

	$('.keypad a.corr').bind('touchstart mousedown', function(event) {
		$('#pin-stars').html('');
		$('#payment-message').html(prompt_pin_text);
		$('#pin').val('');
	});
	
	$('.keypad a.ok').bind('touchstart mousedown', function(event) {
		$('#modal-dialog').show(); // disable inputs
		$('#pin-stars').html('');
		$('#payment-message').html(submitting_payment_text);
		$.ajax({
			url: baseUrl + '/payments/json-submit-payment/',
			type: "POST",
			data: ({
				pin : $('#pin').val(),
				accountid : $('#accountid').val(),
				billid: $('#billid').val(),
			}),
			success: function(jsonString) {
				var json = eval('(' + jsonString + ')');
				$('#pin').val('');
				$('#modal-dialog').hide(); // disable inputs
				$('.keypad a.ok').removeClass('active');
				reset_key_binds($('.keypad a.ok, .keypad a.numbers'));
				if(json.status==0) {
					$('#payment-message').html(json.message);
					setTimeout(reset_keypad, 4000);
				} else if(json.status==-1) {
					prompt_pin(json.message);
				} else if(json.status==1) {
					$('#payment-message').html(json.message);
					// json.billid
					setTimeout(function() { window.location.replace(baseUrl+"/payments/receipts/") }, 2000);

				} else {
					$('#payment-message').html("Unknown result. Sad.");
				}
			}
		});
	});
}

function prompt_cancel() {
	reset_key_binds($('.keypad a.ok, .keypad a.no, .keypad a.numbers, #payment-accounts a.enabled'));
	$('#payment-message').html(confirm_cancel_text);
	$('#payment-amount').html('');
	$('#pin-stars').html('');
	$('.keypad a.no').bind('touchstart mousedown', function(event) {
		prompt_account();
	});
	$('.keypad a.ok').bind('touchstart mousedown', function(event) {
		$('#modal-dialog').show(); // disable inputs
		$('#payment-message').html(canceling_text);
		$.ajax({
			url: baseUrl + '/payments/json-cancel-payment/',
			type: "POST",
			data: ({
				billid: $('#billid').val(),
			}),
			success: function(jsonString) {
				var json = eval('(' + jsonString + ')');
				$('#modal-dialog').hide(); // enable inputs
				$('.keypad a.ok').removeClass('active');
				reset_key_binds($('.keypad a'));
				if(json.status==0) {
					$('#payment-message').html(json.message);
					$('.keypad a.ok').bind('touchstart mousedown', function(event) {
						prompt_account();
					});
				} else if(json.status==1) {
					$('#payment-message').html(json.message);
					setTimeout(reset_keypad, 4000);
				} else {
					$('#payment-message').html("Unknown result. Sad.");
				}
			}
		});
	});
}

function isNumeric(input)
{
   return (input - 0) == input && input.length > 0;
}
