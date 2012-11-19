<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:15:27
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/sms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5701133094f85ae1f0774e3-74207937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '60af5572fe8ed36daf1dee0177d4354f9e723c5b' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/sms.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5701133094f85ae1f0774e3-74207937',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/payment-status.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_invite">

<?php if ($_smarty_tpl->getVariable('errors')->value){?>
    <div class="error">
        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

    </div>
<?php }?>

<?php if (empty($_smarty_tpl->getVariable('response',null,true,false)->value->ResponseXml->RestException->Message)&&!empty($_smarty_tpl->getVariable('response_msg',null,true,false)->value)){?>
<h1><?php echo $_smarty_tpl->getVariable('response_msg')->value;?>
</h1>
<?php }else{ ?>
<h1>Invite</h1>
    <form action='<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/sms_twilio/send' method='post' name="sms_form">
        <?php if (!empty($_smarty_tpl->getVariable('response',null,true,false)->value->ResponseXml->RestException->Message)){?>
        <p style="color: red;"><?php echo $_smarty_tpl->getVariable('response')->value->ResponseXml->RestException->Message;?>
</p><br>
        <?php }?>
    	<p>To send an invitation to PayPhoneAPP:</p>
    	<p><strong>1. </strong>Enter the <strong>Customer's Phone Number</strong> and,</p>
    	<p><strong>2. </strong>Click on the <strong>'Send'</strong> button, or hit return.</p>
    	<br />
    	<table class="payment">
	        <tr>
		        <td>
		        	<input class='input default-value' title='Customer Phone Number' type='text' name='phone' value='' />
		        	<input type='hidden' name='message' value='PayPhoneAPP is a secure, convenient way to pay for stuff using your phone... Come see us at www.payphoneapp.com/user/register to learn more.' />
		        </td>
	        </tr>
        </table>
        <!--<br />
        <font face="Helvetica" size="2" color="#959595"><b>Message</b></font><br>
        <textarea class='default-value' title='Message' name='message' value='' ></textarea>-->
        <input type='submit' class='button' id="submit-request" value='Send' />
    </form>
<?php }?>
