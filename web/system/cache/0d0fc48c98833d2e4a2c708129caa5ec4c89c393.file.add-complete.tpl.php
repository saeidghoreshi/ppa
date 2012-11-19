<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:40:44
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/add-complete.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1565669924f85b40ce11957-78636298%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d0fc48c98833d2e4a2c708129caa5ec4c89c393' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/add-complete.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1565669924f85b40ce11957-78636298',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account-complete.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">
<div id="trans_wrap">
	<div id="header-left">
		<h1>Account Created</h1>
	</div>
	<div id="header-right">
		&nbsp;
	</div>
	<div class="clear"></div>
	
    <div class="account_info">
		<p>You have successfully added an account!</p>
<?php if (false){?>
        <h2>Testing Bean Stream Response</h2>
        <br/>
        <?php if (!empty($_smarty_tpl->getVariable('response',null,true,false)->value)){?>
            Response
            <ul>
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('response')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
                <li><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
: <?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</li>
            <?php }} ?>
            </ul>
        <?php }else{ ?>
            Bean Stream response not found.
        <?php }?>
<?php }?>
		
        <!--<a title="O.K." class="ok_button"
           href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account#">Ok</a>-->
    </div>
    <br />
    <a class='button ok_button' id='submit-request' href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account">OK</a>
</div>
