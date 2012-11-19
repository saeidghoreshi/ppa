<?php /* Smarty version Smarty-3.0.6, created on 2012-04-17 22:48:11
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/account/paypal_step2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3652448114f8e2b6bf2dcf3-09455561%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a00156a4eb5cf63dfe9c8ea1e2362187809e2fd' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/account/paypal_step2.tpl',
      1 => 1334716857,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3652448114f8e2b6bf2dcf3-09455561',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/libraries/smarty/libs/plugins/modifier.date_format.php';
?><link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account-edit.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/general.css" type="text/css">
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/account/account-edit.js" type="text/javascript"></script>
<style TYPE="text/css">
label { display: block; }
.copyright a { color: #01B0EF; }
.actions { text-align: left; }
input[type="text"], input[type="password"] {
width: 80%;
max-width: 300px;
}
#header-left {
width: 100%;
max-width: 300px;
}
</style>

<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">

    <div id="account_info_update" class="account_info">
	
    	<div id="header-left">
            <h1>Confirm Paypal Account</h1>
        </div>
	<?php if (false&&!empty($_smarty_tpl->getVariable('createdAccount',null,true,false)->value)){?>
<table align="center" width="50%">
    <tr>
        <td class="thinfield">CorrelationId:</td>
        <td class="thinfield"><?php echo $_smarty_tpl->getVariable('createdAccount')->value->responseEnvelope->correlationId;?>
</td>
    </tr>
    <tr>
        <td class="thinfield">CreateAccountKey:</td>
        <td class="thinfield"><?php echo $_smarty_tpl->getVariable('createdAccount')->value->createAccountKey;?>
</td>
    </tr>
    <tr>
        <td class="thinfield">AccountId:</td>
        <td class="thinfield"><?php echo $_smarty_tpl->getVariable('createdAccount')->value->accountId;?>
</td>
    </tr>
    <tr>
        <td class="thinfield">Status:</td>
        <td class="thinfield"><?php echo $_smarty_tpl->getVariable('createdAccount')->value->execStatus;?>
</td>
    </tr>
</table>
    <?php }?>
    
    
        <div id="header-right">
        <div class="custom_report">
        <?php if (!empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])&&false){?>
        <a class="custom_button"
           href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/add">
        <span>
            <img src="images/icon_plus.png" height="11" width="11"
                 alt="" />
            &nbsp;
            Add Account
        </span>
        </a>
        <span class="custom_button">
            <span>
<?php if (false){?>
                        <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Delete</a>
                &nbsp;|&nbsp;
<?php }?>
                    <?php if ($_smarty_tpl->getVariable('account')->value['account_enabled']){?>
                        <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/suspend/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">Suspend</a>
                    <?php }else{ ?>
                        <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/enable/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">Enable</a>
                    <?php }?>
            </span>
        </span>
        <?php }?>
        </div>
        </div>

        <form action="<?php echo $_smarty_tpl->getVariable('actionUrl')->value;?>
" method="post" name="form">
            <?php if ($_smarty_tpl->getVariable('errors')->value){?>
			    <div class="error">
			        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

			    </div>
	    <?php }?>
            <div id="profile-info" style="display:inline">
                <table class="account_info" style="color: #666;">
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
            <?php if (!empty($_smarty_tpl->getVariable('paypal_error',null,true,false)->value)){?>
                    <tr>
                        <td class="r2" colspan="2">
			    <div class="error" style="text-align: center;">
			        <?php echo $_smarty_tpl->getVariable('paypal_error')->value;?>

			    </div>
                        </td>
                    </tr>
	    <?php }?>
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Paypal Email*</label>
                            <input title="Email"
                                   type="text" id="profile-8-1"
                                   name="email"
                                   value="<?php echo (($tmp = @(($tmp = @$_POST['email'])===null||$tmp==='' ? $_SESSION['paypal_email'] : $tmp))===null||$tmp==='' ? $_smarty_tpl->getVariable('user')->value['email'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Starting date*</label>
                            <input title="Starting date"
                                   type="text" id="profile-8-2"
                                   name="startingDate"
                                   value="<?php echo smarty_modifier_date_format((($tmp = @$_POST['startingDate'])===null||$tmp==='' ? time() : $tmp),"%Y-%m-%d");?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Ending date*</label>
                            <input title="Ending date"
                                   type="text" id="profile-8-3"
                                   name="endingDate"
                                   value="<?php echo smarty_modifier_date_format((($tmp = @$_POST['endingDate'])===null||$tmp==='' ? (time()+31556926) : $tmp),"%Y-%m-%d");?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Max Number of Payments</label>
                            <input title="Maximum Number of Payments"
                                   type="text" id="profile-8-4"
                                   name="maxNumberOfPayments"
                                   value="<?php echo (($tmp = @$_POST['maxNumberOfPayments'])===null||$tmp==='' ? 1000 : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Max Total Amount*</label>
                            <input title="Maximum Total Amount"
                                   type="text" id="profile-8-5"
                                   name="maxTotalAmountOfAllPayments"
                                   value="<?php echo (($tmp = @$_POST['maxTotalAmountOfAllPayments'])===null||$tmp==='' ? 2000 : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="payment-1-5">Security PIN*</label>
                            <input title="PIN"
                                   type="password" id="payment-1-5"
                                   name="<?php echo @FORM_ACCOUNT_SECURITY_PIN;?>
"
                                   value="<?php echo preg_replace("/./","*",$_smarty_tpl->getVariable('account')->value['securitypin']);?>
" onFocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <?php if (!empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])){?>
                                <input type="hidden"
                                       name="<?php echo @FORM_ENTITY_ID;?>
"
                                       value="<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
" />
                            <?php }?>
                            <table><tr><td>
                            <a title="Cancel" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/" style="font-weight: normal;">
                                Cancel
                            </a>
                            </td><td id="paypalSubmitForm">
                            &nbsp;| <input title="Confirm" type="submit"
                                   name="save" value="Confirm" />
                    	    </td></tr></table>
                        </span>
                    </span>
                </div>
            </div>
        </form>

    </div>

</div>
