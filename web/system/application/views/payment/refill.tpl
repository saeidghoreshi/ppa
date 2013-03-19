<link rel="stylesheet" href="{$config.base_url}css/payment.css" type="text/css" />
<link rel="stylesheet" href="{$config.base_url}css/payment-request.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/datepicker.css" /> 
<script type="text/javascript">var baseUrl = '';</script> 
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_refill">
        <div class="content clearfix">
		<div id="payment" class="payment"> 
			<div id="payment"> 
	<div id='instructions' class='instructions1'> 
{*		<h2><a href='/merchant'>Merchant Payment Request Demo</a></h2> *}
		<h1>Refill Gift Card</h1> 
		<p><strong>1.</strong> Enter the <strong>Customer's Phone Number</strong> and,</p> 
		<p><strong>2.</strong> Enter Refill <strong>Amount</strong>,</p> 
		<p><strong>3.</strong> Click on the <strong>'Refill'</strong> button.</p> 
	</div> 
{if $smarty.post}
	<div class="error" id="error">
	Please check Refill Form below.
	</div> 
{/if}	
{if empty($smarty.session.merchant_id)}
		<div style="color:red">NO MERCHANT ASSOCIATED</div>
{else}
	<form id='request' action='{$site_url}/payment/refill' method='post'> 
            <table class="payment" id="payment-request" border=0>
                <tr>
                    <td><input class='input default-value' title='Customer Phone Number' type='text' name='phone' value="{$smarty.post.phone|default:''|escape}" id='input-phone' onblur="this.value=cleanString(this.value);" /></td>
                </tr>
                <tr>
                    <td><input class='input default-value dollars' title='Amount' type='text' name='amount' value="{$smarty.post.amount|default:''|escape}" id='input-amount'/></td>
                </tr>
                <tr id='tr-submit-request'>
                    <td><input type='submit' class='button' id='submit-request' value='Refill'/></td>
                </tr>
	    </table>
	</form> 
{/if}
			</div> 
		</div> 
        </div>
