<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 17:17:31
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/paypal_success.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16791891584f85f4ebdda425-07931524%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73d0372cbf0e94bca022262c26b2070d2f7c8a62' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/paypal_success.tpl',
      1 => 1334179050,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16791891584f85f4ebdda425-07931524',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account-edit.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/account/account-edit.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">

    <div id="account_info_update" class="account_info">
	
    	<div id="header-left">
            <h1>Paypal Acction Succeeded</h1>
        </div>
<br>
<br>
<br>
<br>
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
	    <a href="<?php echo $_smarty_tpl->getVariable('actionUrl')->value;?>
">Go Back To Accounts</a>

    </div>

</div>
