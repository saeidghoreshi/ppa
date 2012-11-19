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

	

	$('form#payment-status').submit( function() {
//	alert('payment status');
		var params = {};
		$('#payment-paid').html('waiting for confirmation...');
		$('#payment-submit').val('Confirm Transaction');
		$('#payment-table').show();
		$('#transaction_id').hide();
		$('#cancel_transaction_id').val($('#transaction_id').val());
		$('#payment-cancel').show();
		$('#instructions').hide();
	  if( $('#request_type').val() == 'PSR' ) {
		$('#request_type').val('PPR');
		$.PeriodicalUpdater({
			    url: $('#payment-status').attr('action') + '?transaction_id=' + $('#transaction_id').val() + "&ajax=true",
			    data: params
			},
			function(data) {
				//$('#payment-status').html(html);
//			    alert('data:'+data);
			    var json = eval('(' + data + ')');
			    
				$('#payment-transaction').html(json.transaction_id);
				$('#transaction_id').val(json.transaction_id);
				$('#payment-amount').html(json.amount);
				$('#tips').val(json.tips);
				$('#payment-customer').html(json.recepient_id);
				$('#payment-user').html(json.sender_id);
				$('#payment-table').show();
				$('#input-phone').attr('disabled', true);
				if( json.sender_location ) $('#payment-location').html('verified');
				else $('#payment-location').html('verifying...');
				
				if( json.sender_cancelled || json.recepient_cancelled ) {
				    $('#payment-submit').attr('disabled', true);
				    $('#cancel-request').attr('disabled', true);
				    $('#payment-paid').html('cancelled');
				    
			    setTimeout(function() {
			    $url = window.location.href.split('?');
			    //window.location.href=$url[0]+'?reload='+new Date().getTime();
			    window.location.href=$url[0];
			                 }, 5000);
			    
				}
				else if( json.recepient_paid ) {
				    $('#payment-paid').html('paid');
				    $('#payment-submit').attr('disabled', true);
				    $('#cancel-request').attr('disabled', true);
				}
				else if ( json.msg != 'OK' ) {
				    $('#payment-paid').html(json.msg);
				}
				else {
				    $('#payment-paid').html('waiting for confirmation...');
				}
				if( !json.status ) $('#payment-paid').html(json.msg);
				$('#cancel-request').show();
			    
			}
		);
	  }
	  else {
		//$('#payment-status').id = 'payment-confirm';
//		alert('payment confrim');
		$('#payment-paid').html('processing transaction...');
		$('#payment-submit').attr('disabled', true);
		$('#cancel-request').attr('disabled', true);
		var params = {};
		$(this)
		.find("input, option[@selected], textarea")
		.each(function() {
			params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value;
		});
		params['account_id'] = $('#account_id').val();
		params['tips'] = $('#tips').val();
//		alert('tips: ' + $('#tips').val());
//		alert('account_id: ' + $('#account_id').val());
//		alert('account_id: ' + params['account_id']);
//		alert('request_type: ' + params['request_type']);
		$.ajax({
			type: "POST",
			url: $(this).attr('action') + "?ajax=true",
			data: params,
			success: function(data) {
			  //alert(data.length);
			  if( data.length > 0 ) {
//			    alert('data:'+data);
			    var json_status = eval('(' + data + ')');
			    if( !json_status.status || json_status.msg != 'OK' ) {
				$('#payment-paid').html(json_status.msg);
				$('#payment-submit').attr('disabled', false);
				$('#cancel-request').attr('disabled', false);
			    }
			    else {
				$('#cancel-request').attr('disabled', true);
				setTimeout(function() {
				    $url = window.location.href.split('?');
//				    window.location.href=$url[0]+'?reload='+new Date().getTime();
			    window.location.href=$url[0];
			            }, 5000);
				$('#payment-paid').html('paid');
			    }
			  }
			  else {
			    //alert('error: empty response');
			    $('#payment-paid').html(json_status.msg);
			  }
			},
			error: function(data) {
			    alert('error: '+data.responseText);
			    var json_status = eval('(' + data + ')');
			    $('#payment-paid').html(json_status.msg);
			}
		});
	    
	  }
		return false;
	});

	$('form#payment-cancel').submit( function() {
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
			  //alert(data.length);
			  if( data.length > 0 ) {
			    //alert('data:'+data);
			    var json_status = eval('(' + data + ')');
			    if( !json_status.status ) {
				$('#payment-paid').html(json_status.msg);
			    }
			    else {
				$('#cancel-request').attr('disabled', true);
			    setTimeout(function() {
			    $url = window.location.href.split('?');
//			    window.location.href=$url[0]+'?reload='+new Date().getTime();
			    window.location.href=$url[0];
			                 }, 5000);
			    }
			  }
			},
			error: function(data) {
			    //alert('data:'+data);
			    alert('data:'+data+'\nerror:'+data.responseText);
			}
		});
		
		return false;
	});

	$('form#payment-confirm').submit( function() {
		$('#payment-paid').html('processing transaction...');
		$('#payment-submit').attr('disabled', true);
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
			  //alert(data.length);
			  if( data.length > 0 ) {
			    var json_status = eval('(' + data + ')');
			    //alert('data:'+data);
			    if( !json_status.status ) {
				$('#payment-paid').html(json_status.msg);
			    }
			    else {
				$('#cancel-request').attr('disabled', true);
			    setTimeout(function() {
			    $url = window.location.href.split('?');
//			    window.location.href=$url[0]+'?reload='+new Date().getTime();
			    window.location.href=$url[0];
			                 }, 5000);
			    }
			  }
			},
			error: function(data) {
			    //alert('error:'+data.responseText);
			}
		});
		
		return false;
	});

	
	$('form#request').submit( function() {
		if(prevent_submit_request) return false;
		
		$('#instructions').hide();
		if(!$('#payment-status').length) $("<div id='payment-status'></div>").insertAfter($('#instructions'));
		$('#payment-status').html("Sending request...");
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
			error: function(data) {
			    //alert('error:'+data.responseText);
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
				$('#cancel-request').show();
				if( json.status ) {
//						url : baseUrl + '/payments/payment-status/id/'+$('#billid').val()+'/?ajax'
					$.PeriodicalUpdater({
						url: baseUrl + $('#request').attr('action') + "?&transaction_id="+json.transaction_id+"&ajax=true"
						},
						function(data) {
							//alert('update:'+data);
						
							var json_status = eval('(' + data + ')');
							
							if( json_status.sender_location ) $('#payment-location').html('verified');

							if( json_status.tips > 0 && json_status.tips != $('#payment-tips').html() ) $('#payment-tips').html(json_status.tips);
							
							if( json_status.sender_cancelled ||json_status.recepient_cancelled ) $('#payment-paid').html('cancelled');
							else $('#payment-paid').html('processing...');
							
							if( !json_status.status ) $('#payment-paid').html(json_status.msg);
							
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

		$.PeriodicalUpdater({
			    url: $('#payment-list').val() + '?request_type=PLR'
			},
			function(data) {
				//$('#payment-status').html(html);
//			    alert('data:'+data);
			    var json = eval('(' + data + ')');
			    if( json.transactions && json.transactions.length > 0) {
				//alert( json.transactions[json.transactions.length-1] );
				$('#transaction_id').val( json.transactions[json.transactions.length-1] );
				$('#transaction_list').html( "Pending Transaction List:<br>"+json.transactions.toString()+"<br>" );
			    }
			    else {
				$('#transaction_list').html( 'No Pending Transactions' );
			    }
/*			    
			    var json = eval('(' + data + ')');
			    
				$('#payment-transaction').html(json.transaction_id);
				$('#transaction_id').val(json.transaction_id);
				$('#payment-amount').html(json.amount);
				$('#tips').val(json.tips);
				$('#payment-customer').html(json.recepient_id);
				$('#payment-user').html(json.sender_id);
				$('#payment-table').show();
				$('#input-phone').attr('disabled', true);
				if( json.sender_location ) $('#payment-location').html('verified');
				else $('#payment-location').html('verifying...');
*/				
			    
			}
		);
	
	
	
});

function var_dump(obj) {
   if(typeof obj == "object") {
      return "Type: "+typeof(obj)+((obj.constructor) ? "\nConstructor: "+obj.constructor : "")+"\nValue: " + obj;
   } else {
      return "Type: "+typeof(obj)+"\nValue: "+obj;
   }
}


