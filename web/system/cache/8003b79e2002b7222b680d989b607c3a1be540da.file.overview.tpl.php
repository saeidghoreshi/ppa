<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:20:13
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/overview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20322008824f85af3dd9f385-30746818%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8003b79e2002b7222b680d989b607c3a1be540da' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/overview.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20322008824f85af3dd9f385-30746818',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/account/account.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">
	<div id="header-left">
		<h1>Accounts</h1>
	</div>
	<div id="header-right">
		<div class="custom_report clearfix">
	        <div class="linline">
	            <!--<a class="custom_button"
	               href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/add">
	            <span>
	                <img src="images/icon_plus.png" height="11" width="11"
	                     alt="" />
	                &nbsp;
	                Add Account
	            </span>
	            </a>-->
	        </div>
	        <div class="rinline">
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
                    <a href="javascript:window.print();">Print</a>
<?php if (false){?>
	                    &nbsp;|&nbsp;
                    <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Save</a>
	                    &nbsp;|&nbsp;
                    <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Export</a>
<?php }?>
	                </span>
	            </span>
	        </div>
	    </div>
	</div>

<table id="accounts_list" class="resizable">
        <tr>
            <th class="chbox">&nbsp;</th>
            <th class="nick sort">
                Nickname <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#"><img src="images/arrow_sort.png" alt="" /></a>
            </th>
            <th class="acc">Account #</th>
            <th class="expiery">Expiry</th>
            <th class="status">Status</th>
            <th class="activity">Last activity</th>
            <th class="amount">Amount</th>
            <th class="funds">Available funds</th>
            <th class="flag"><img id="flag-img" src="images/flag_white.png" alt="" /></th>
            <th class="view">&nbsp;</th>
        </tr>

        <?php if (!empty($_smarty_tpl->getVariable('accounts',null,true,false)->value)){?>
            <?php  $_smarty_tpl->tpl_vars['account'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('accounts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['account']->key => $_smarty_tpl->tpl_vars['account']->value){
?>
                <tr>
                    <td>
                    </td>
                    <td class="bold"><?php echo $_smarty_tpl->tpl_vars['account']->value['account_name'];?>
</td>
                    <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['account']->value['account_safenumber'])===null||$tmp==='' ? "XXXX XXXXXXXX XXXX" : $tmp);?>
</td>
                    <td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['account']->value['account_expiry'])===null||$tmp==='' ? "N/A" : $tmp);?>
</td>
                    <td>
                        <?php if ($_smarty_tpl->tpl_vars['account']->value['account_enabled']){?>
                            Active
                        <?php }else{ ?>
                            Suspended
                            <!--<a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/enable/<?php echo $_smarty_tpl->tpl_vars['account']->value['account_id'];?>
">
                                Enable
                            </a>-->
                        <?php }?>
                    </td>
                    <td>--- -- ----</td>
                    <td>$-.--</td>
                    <td>$-.--</td>
                    <td>&nbsp;</td>
                    <td class="view">
                        <a class="view_rec" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/info/<?php echo $_smarty_tpl->tpl_vars['account']->value['account_id'];?>
"
                           title="View Account">
                            View Account
                        </a>
                    </td>
                </tr>
            <?php }} ?>
        <?php }?>
        <?php if (false){?>
        <tr>
            <td></td>
            <td class="bold">Company Visa</td>
            <td>**********************</td>
            <td>**/**</td>
            <td>Pending</td>
            <td>Jan 01 2011</td>
            <td>$3.55</td>
            <td>$*****</td>
            <td>&nbsp;</td>
            <td class="view"><a class="view_rec view_rec_disabled" href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#" title="View Receipt">View Receipt</a></td>
        </tr>
        <?php }?>
<!-- MERGING TODO -->
    </table>
    
</div>