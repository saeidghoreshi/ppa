var prevent_submit_request = false;

function cancel_transaction() {
	$('#cancel-transaction-button').html("Cancelling Transaction...");
	$.ajax({
		url: baseUrl + '/payments/json-cancel-payment/',
		type: "POST",
		data: ({
			billid: $('#billid').val()
		}),
		success: function(jsonString) {
            // nothing to do
		}
	});
}

$(document).ready( function() {

	$('.print').live('click', function(event) {
		event.preventDefault();
		var id = 'printframe';
		var url = $(this).attr("href");
		var full_url = url; // 'http://'+document.domain+url
		$(document.body).append('<iframe id="'+id+'" src="'+full_url+'" style="height: 0px; width: 0px;"></iframe>');

		$('iframe#printframe').load(function() {
			var iframe = document.frames ? document.frames[id] : document.getElementById(id);
			var ifWin = iframe.contentWindow || iframe;
			iframe.focus();
			ifWin.printReceipt();
			window.location.replace(baseUrl+"/payments/request/");
		});
	});

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
 	if($('#payment-status').length) {
		$.PeriodicalUpdater({
				url : baseUrl + '/payments/payment-status/id/'+$('#billid').val()+'/?ajax'
			},
			function(data) {
				var html = data;
				$('#payment-status').html(html);
			}
		);
	}

	$('form#cancel').submit( function() {
		$('#payment-paid').html('cancelling...');
		var params = {};
		$(this)
		.find("input, option[@selected], textarea")
		.each(function() {
			params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value;
		});
		$.ajax({
			type: "POST",
			url: $(this).attr('action') + "?ajax=true",
			data: params,
			success: function(data) {
//			    alert('data:'+data);
			    var json_status = eval('(' + data + ')');
			    if( !json_status.status ) {
				$('#payment-paid').html(json_status.msg);
			    }
			    else {
				$('#cancel-request').attr('disabled', true);
			    setTimeout(function() {
			    //window.location.href=$url[0]+'?reload='+new Date().getTime();
			    $url = window.location.href.split('?');
			    window.location.href=$url[0];
			                 }, 5000);
			    }
			},
			error: function(data) {
			    //alert('error:'+data.responseText);
			    var json_status = eval('(' + data.responseText + ')');
			    $('#payment-paid').html(json_status.msg);
			    $('#cancel-request').attr('disabled', true);
			    $('#submit-request-disabled').removeAttr('disabled');
			    $('#submit-request-disabled').val(' Ok ');
			    $('#submit-request-disabled').removeClass('disabled');
			    $('#submit-request-disabled').click(function() {
				$url = window.location.href.split('?');
				window.location.href=$url[0];
			    });
			}
		});
		
		return false;
	});
	
	$('form#request').submit( function() {
		if(prevent_submit_request) return false;
		
		$('#instructions').hide();
		if(!$('#payment-status').length) $("<div id='payment-status'></div>").insertAfter($('#instructions'));
		$('#payment-status').html("Sending request...");
		$('#cancel-phone').val($('#input-phone').val());
		var params = {};
		$(this)
		.find("input, option[@selected], textarea")
		.each(function() {
//alert( (this.name || this.id || this.parentNode.name || this.parentNode.id ) +':'+ this.value)		;
			params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value;
		});
//alert('my action: ' + $('#request').attr('action'));
//alert('my type: ' + $('#request_type').val());
//alert(params);
		$.ajax({
			type: "POST",
			url: $(this).attr('action') + "?ajax=true",
			data: params,
			error: function(data) {
			    alert('error:'+data.responseText);
			},
			success: function(data) {
//		alert('data:'+data);
				//$('#payment-status').html(data);
				var json = eval('(' + data + ')');
//		alert('status:'+json.status);
				$('#payment-transaction').html(json.transaction_id);
				$('#transaction_id').val(json.transaction_id);
				$('#payment-amount').html(json.amount);
				$('#payment-tips').html(json.tips);
				$('#payment-customer').html(json.recepient_id);
				$('#payment-location').html('verifying...');
				//$('#payment-status').html('waiting...');
				$('#payment-paid').html('waiting...');
				$('#payment-table').show();
				$('#payment-status').hide();
				$('#input-phone').attr('disabled', true);
				$('#input-amount').attr('disabled', true);
				$('#submit-request').attr('disabled', true);
				$('#payment-request').hide();
				$('#payment-cancel').show();
				if( json.status ) {
//						url : baseUrl + '/payments/payment-status/id/'+$('#billid').val()+'/?ajax'

					$.PeriodicalUpdater({
						url: baseUrl + $('#request').attr('action') + "?transaction_id="+json.transaction_id+"&phone="+json.recepient_id+"&ajax=true"
						},
						function(data) {
							//alert('update1:'+data);
                                                        //console.log(data);
							var json_status = eval('(' + data + ')');
							
                                                        if( json_status.distance ) $('#payment-distance').html(json_status.distance+'m');
                                                        
							if( json_status.sender_location && json_status.distance > 0 ) {
                                                             if( json_status.distance <= 30 ) {
								$('#payment-location').html('verified');
								$('#payment-paid').html('processing...');
							     }
                                                             else $('#payment-location').html('distance calculated - '+json_status.distance+'m');
                                                        }

							if( json_status.tips > 0 && json_status.tips != $('#payment-tips').html() ) $('#payment-tips').html(json_status.tips);
							
							if( json_status.sender_cancelled ||json_status.recepient_cancelled ) {
							    $('#payment-paid').html('cancelled');
							    $('#cancel-request').attr('disabled', true);
							    setTimeout(function() {
                                                    		//window.location.href=$url[0]+'?reload='+new Date().getTime();
                        					$url = window.location.href.split('?');
                                                    		window.location.href=$url[0];
                                                                 }, 5000);
     							}
							else if( json_status.recepient_paid ) {
							    $('#payment-paid').html('paid');
							    $('#cancel-request').attr('disabled', true);
							    //setTimeout(function() {
							    $('#submit-request-disabled').removeAttr('disabled');
							    $('#submit-request-disabled').val(' Ok ');
							    $('#submit-request-disabled').removeClass('disabled');
							    $('#submit-request-disabled').click(function() {
								$url = window.location.href.split('?');
								window.location.href=$url[0];
							    });
                                                            //}, 5000);
							}
							else $('#payment-paid').html('waiting...');
							
							if( !json_status.status || json_status.msg != 'OK' ) { 
                                                            if( json_status.msg.match(/does not exist/i) ) {
                                                                $('#payment-paid').html('Payment Request Expired');
                                                            }
                                                            else {
                                                                $('#payment-paid').html(json_status.msg);
                                                            }
							    setTimeout(function() {
                                                    		//window.location.href=$url[0]+'?reload='+new Date().getTime();
                        					$url = window.location.href.split('?');
                                                    		window.location.href=$url[0];
                                                            }, 5000);
                                                        }
						}
					);
				}
				else {
				    $('#payment-paid').html('failed');
				}
			}
		});
		return false;
	});

	$('#cancel-transaction-button').live('click', function(e) {
		e.preventDefault();
		cancel_transaction();
		return false;
	});

	$('#print-button a').click( function() {
		$('#print-dialog').show();
		return false;
	});
	$('#print-close-button').click( function() {
		$('#print-dialog').hide();
		return false;
	});

	Date.format = 'mm/dd/yyyy';
	$('.date-pick').datePicker( {
		startDate: '01/01/1970',
		endDate: (new Date()).toString()
	}).bind(
		'focus',
		function()
		{
			$(this).dpDisplay();
		}
	).bind(
		'blur',
		function(event)
		{
			// works good in Firefox... But how to get it to work in IE?
			if ($.browser.mozilla) {

				var el = event.explicitOriginalTarget

				var cal = $('#dp-popup')[0];

				while (true){
					if (el == cal) {
						return false;
					} else if (el == document) {
						$(this).dpClose();
						return true;
					} else {
						el = $(el).parent()[0];
					}
				}
			}
		}
	);
	$('#start-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#end-date').dpSetStartDate(d.addDays(1).asString());
			}
		}
	);
	$('#end-date').bind(
		'dpClosed',
		function(e, selectedDates)
		{
			var d = selectedDates[0];
			if (d) {
				d = new Date(d);
				$('#start-date').dpSetEndDate(d.addDays(-1).asString());
			}
		}
	);
	
	$(".dollars").moneyMask();
});

function var_dump(obj) {
   if(typeof obj == "object") {
      return "Type: "+typeof(obj)+((obj.constructor) ? "\nConstructor: "+obj.constructor : "")+"\nValue: " + obj;
   } else {
      return "Type: "+typeof(obj)+"\nValue: "+obj;
   }
}

function removeSpaces(string) {
    return string.split(' ').join('');
}

function cleanString (str) {
    return str.replace(/[\(\)\.\-\s,]/g, "");
}