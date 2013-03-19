<link rel="stylesheet" href="{$config.base_url}css/payment.css" type="text/css" />
<link rel="stylesheet" href="{$config.base_url}css/payment-status.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/datepicker.css" /> 
<script type="text/javascript">var baseUrl = '';</script> 
<script type="text/javascript" src="{$config.base_url}js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.periodicalupdater.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.datepicker.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.moneymask.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/user.js"></script> 
            <div class="content clearfix">

	<h1>Waiting for a payment request....</h1> 

		<div id="payment" class="payment"> 
		
			<div id="payment"> 
			

	<div id='instructions' class='instructions'> 
		<ol> 
			<li>Wait for payment request and,</li> 
			<li>Verify <strong>Merchant</strong> and,</li> 
			<li>Verify Transaction <strong>Amount</strong> and,</li> 
			<li>Enter <strong>Tips</strong> and,</li> 
			<li>Confirm Payment.</li> 
		</ol> 
	</div> 

	<table id="payment-table" style="display: none;" border="0" class="payment">
		<tbody>
		<tr>
			<td colspan="2"><h3>Confirm Payment Request</h3></td>
		</tr>
		<tr>
			<td class="right">Transaction #</td><td id="payment-transaction">N/A</td>
		</tr>
		<tr>
			<td class="right">Merchant:</td><td id="payment-user">N/A</td>
		</tr>
		<tr>
			<td class="right">Total:</td><td id="payment-amount">N/A</td>
		</tr>
		<tr>
			<td class="right">+Tips:</td><td id="payment-tips"><input id='tips' name='tips' value='' class='input' ></td>
		</tr>
		<tr>
			<td class="right">Payment Method:</td>
			<td id="payment-method">
			{if $accounts}
			    <select name="account_id" id="account_id">
			    <option value="">Select Account</option>
			    {foreach from=$accounts item=account}
				<option value="{$account.account_id}">{$account.account_name}</option>
			    {/foreach}
			    </select>
			{else}
			no accounts configured
			{/if}
			</td>
		</tr>
		<tr>
			<td class="right">Location Status:</td><td id="payment-location">N/A</td>
		</tr>
		<tr>
			<td class="right">Payment Status:</td><td id="payment-paid">N/A</td>
		</tr>
	</tbody></table>

<table border="0" class="payment">
<tr><td valign="top">	
	<form id='payment-status' action='queue2.php' method='get'>
		<input type='hidden' id='request_type' name='request_type' value='PSR' /> 
		<input id="transaction_id" class='input' name="transaction_id" value="" type="text">
		<input type='submit' class='button' id='payment-submit' value='Check Transaction'/> 
	</form> 
<div id="transaction_list"></div>
</td><td valign="top">	
	<form id='payment-cancel' action='queue2.php' method='get'  style="display: none;" >
		<input type='hidden' name='request_type' value='PCR' /> 
		<input type='submit' class='button cancel' id='cancel-request' value='Cancel Transaction'/> 
		<input id="cancel_transaction_id" name="transaction_id" value="" type="hidden">
	</form> 
</td></tr>	
</table>

</div>
	
			</div> 
		</div> 
            </div>
<input type="hidden" id="payment-list" name="payment-list" value="queue2.php">
