<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:15:33
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/payment/refill.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16235421244f85ae2563a094-13478957%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b120986690a364466e18631785cdf563c3afb154' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/payment/refill.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16235421244f85ae2563a094-13478957',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/libraries/smarty/libs/plugins/modifier.escape.php';
?><link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/payment.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/payment-request.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/datepicker.css" /> 
<script type="text/javascript">var baseUrl = '';</script> 
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_refill">
        <div class="content clearfix">
		<div id="payment" class="payment"> 
			<div id="payment"> 
	<div id='instructions' class='instructions1'>
		<h1>Refill Gift Card</h1> 
		<p><strong>1.</strong> Enter the <strong>Customer's Phone Number</strong> and,</p> 
		<p><strong>2.</strong> Enter Refill <strong>Amount</strong>,</p> 
		<p><strong>3.</strong> Click on the <strong>'Refill'</strong> button.</p> 
	</div> 
<?php if ($_POST){?>
	<div class="error" id="error">
	Please check Refill Form below.
	</div> 
<?php }?>	
<?php if (empty($_SESSION['merchant_id'])){?>
		<div style="color:red">NO MERCHANT ASSOCIATED</div>
<?php }else{ ?>
	<form id='request' action='<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/payment/refill' method='post'> 
            <table class="payment" id="payment-request" border=0>
                <tr>
                    <td><input class='input default-value' title='Customer Phone Number' type='text' name='phone' value="<?php echo smarty_modifier_escape((($tmp = @$_POST['phone'])===null||$tmp==='' ? '' : $tmp));?>
" id='input-phone' onblur="this.value=cleanString(this.value);" /></td>
                </tr>
                <tr>
                    <td><input class='input default-value dollars' title='Amount' type='text' name='amount' value="<?php echo smarty_modifier_escape((($tmp = @$_POST['amount'])===null||$tmp==='' ? '' : $tmp));?>
" id='input-amount'/></td>
                </tr>
                <tr id='tr-submit-request'>
                    <td><input type='submit' class='button' id='submit-request' value='Refill'/></td>
                </tr>
	    </table>
	</form> 
<?php }?>
			</div> 
		</div> 
        </div>
