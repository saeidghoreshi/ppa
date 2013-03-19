<link rel="stylesheet" href="{$config.base_url}css/payment.css" type="text/css" />
<link rel="stylesheet" href="{$config.base_url}css/payment-request.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/datepicker.css" /> 
<script type="text/javascript">var baseUrl = '';</script> 
<script type="text/javascript" src="{$config.base_url}js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.periodicalupdater.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.datepicker.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.moneymask.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/merchant.js"></script> 
                        <div class="content clearfix">


		<div id="payment" class="payment"> 
		
			<div id="payment"> 
			<div class="status"> 
	<table id="payment-table" style="display: none;" border="0" class="status">
		<tbody>
		<tr><td colspan="2"><h3 class="small">Payment Request Status:</h3></td></tr>
		<tr>
			<td>Transaction #</td><td id="payment-transaction">N/A</td>
		</tr>
		<tr>
			<td>Customer:</td><td id="payment-customer">N/A</td>
		</tr>
		<tr>
			<td>Total:</td><td id="payment-amount">N/A</td>
		</tr>
		<tr>
			<td>+Tips:</td><td id="payment-tips">N/A</td>
		</tr>
		<tr>
			<td>Location Status:</td><td id="payment-location">N/A</td>
		</tr>
		<tr>
			<td>Buyer to Merchant Distance:</td><td id="payment-distance">calculating...</td>
		</tr>
		<tr>
			<td>Paid:</td><td id="payment-paid">N/A</td>
		</tr>
	</tbody></table>
		</div> 

	<div id='instructions' class='instructions1'> 
{*		<h2><a href='/merchant'>Merchant Payment Request Demo</a></h2> *}
		<h3 style="padding: 10px 0 10px 90px;">To request a payment:</h3> 
		<ol class="instructions"> 
			<li>Enter the <strong>Customer's Phone Number</strong> and,</li> 
			<li>Enter the <strong>Amount</strong> owed</li> 
			<li>Click on the <strong>'Send Bill'</strong> button, or hit return.</li> 
		</ol> 
	</div> 
	
	<form id='request' action='{$config.base_url}queue2.php' method='get'> 
            <table class="payment" id="payment-request" border=0>
	    <input type='hidden' name='request_type' value='PR' /> 
                <tr>
                    <td><input class='input default-value' title='Customer Phone Number' type='text' name='phone' value='' id='input-phone'/></td>
                </tr>
                <tr>
                    <td><input class='input default-value dollars' title='Amount' type='text' name='amount' value='' id='input-amount'/></td>
                </tr>
                <tr id='tr-submit-request'>
                    <td><input type='submit' class='button' id='submit-request' value='Send Bill'/></td>
                </tr>
	    </table>
	</form> 
	
            <table class="payment" id="payment-cancel" style="display: none;" border=0>
	    <input type='hidden' name='request_type' value='PR' /> 
                <tr><td>
                <input type='submit' class='button disabled' id='submit-request-disabled' value='Send Bill' disabled/>
                </td><td class="right">
		<form id='cancel' action='{$config.base_url}queue2.php' method='get'>
		    <input type='hidden' name='request_type' value='PCS' /> 
		    <input type='hidden' name='phone' id='cancel-phone' value='' /> 
		    <input type='submit' class='button cancel' id='cancel-request' value='Cancel Transaction'/>
		    <input id="transaction_id" name="transaction_id" value="" type="hidden">
		</form>
                </td></tr>
	    </table>
	
			</div> 
		</div> 
                        </div>
