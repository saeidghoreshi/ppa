<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:14:51
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/payment/request_new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4391652644f85adfb37f561-63909176%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '05d61b3f81eb953acf052943924119309eb2f78e' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/payment/request_new.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4391652644f85adfb37f561-63909176',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/payment.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/payment-request.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/datepicker.css" /> 
<script type="text/javascript">var baseUrl = '';</script> 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery.periodicalupdater.js"></script> 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery.datepicker.js"></script> 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery.moneymask.js"></script> 
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/merchant.js"></script> 
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_request">
                        <div class="content clearfix">


		<div id="payment" class="payment"> 
		
			<div id="payment"> 
			<div class="status"> 
	<table id="payment-table" style="display: none;" border="0" class="status">
		<tbody>
		<tr><td colspan="2"><h1>Payment Request Status</h1></td></tr>
		<tr>
			<td class="right">Transaction #:</td><td id="payment-transaction">N/A</td>
		</tr>
		<tr>
			<td class="right">Customer:</td><td id="payment-customer">N/A</td>
		</tr>
		<tr>
			<td class="right">Total:</td><td id="payment-amount">N/A</td>
		</tr>
		<tr>
			<td class="right">+Tips:</td><td id="payment-tips">N/A</td>
		</tr>
		<tr>
			<td class="right">Location Status:</td><td id="payment-location">N/A</td>
		</tr>
		<tr>
			<td class="right">Payment Status:</td><td id="payment-paid">N/A</td>
		</tr>
	</tbody></table>
		</div> 

	<div id='instructions' class='instructions1'>
		<h1>Request A Payment</h1> 
		<p><strong>1.</strong> Enter the <strong>Customer's Phone Number</strong> and,</p> 
		<p><strong>2.</strong> Enter the <strong>Amount</strong> owed,</p> 
		<p><strong>3.</strong> Click on the <strong>'Send Bill'</strong> button, or hit return.</p> 
	</div> 
	
<?php if (empty($_SESSION['merchant_id'])){?>
		<div style="color:red">NO MERCHANT ASSOCIATED</div>
<?php }else{ ?>
	<form id='request' action='<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
queue2.php' method='get'> 
            <table class="payment" id="payment-request" border=0>
	    <input type='hidden' name='request_type' value='PR' /> 
                <tr>
                    <td><input class='input default-value' title='Customer Phone Number' type='text' name='phone' value='' id='input-phone' onblur="this.value=cleanString(this.value);" /></td>
                </tr>
                <tr>
                    <td><input class='input default-value dollars' title='Amount' type='text' name='amount' value='' id='input-amount'/></td>
                </tr>
                <tr id='tr-submit-request'>
                    <td><input type='submit' class='button' id='submit-request' value='Send Bill'/></td>
                </tr>
	    </table>
	</form> 
<?php }?>
	
            <table class="payment" id="payment-cancel" style="display: none;" border=0>
	    <input type='hidden' name='request_type' value='PR' />
                <tr><td>
                <input type='submit' class='button disabled' id='submit-request-disabled' value='Send Bill' disabled/>
                </td><td>
		<form id='cancel' action='<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
queue2.php' method='get'>
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
