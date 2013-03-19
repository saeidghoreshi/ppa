<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:14:51
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/merchant.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6248087424f85adfb1ff583-68428894%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8fa10e3f6315d52d7c921ad75d9911e8f73ec591' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/merchant.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6248087424f85adfb1ff583-68428894',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--HTMLHEADER-->
    <?php $_template = new Smarty_Internal_Template("include_merchant/template_htmlheader.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
    <!--END HTMLHEADER-->
    <body>
        <div id='wrap_merch'>
            <div class='wrap'>
                <!--HEADER-->
                <?php $_template = new Smarty_Internal_Template("include_merchant/template_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                <!--END HEADER-->
                <!--BODY-->
                <?php if ($_smarty_tpl->getVariable('template')->value!='user/register'&&$_smarty_tpl->getVariable('template')->value!='user/create'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_email'&&$_smarty_tpl->getVariable('template')->value!='user/login'&&$_smarty_tpl->getVariable('template')->value!='login'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_passcode'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_token'){?><div id="bodyContent_merch">
                <div id="white_merch"></div><?php }?>
                <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('template')->value).".tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                <?php if ($_smarty_tpl->getVariable('template')->value!='user/register'&&$_smarty_tpl->getVariable('template')->value!='user/create'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_email'&&$_smarty_tpl->getVariable('template')->value!='user/login'&&$_smarty_tpl->getVariable('template')->value!='login'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_passcode'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_token'){?></div><?php }?>
                <!--END BODY-->
            </div>
        </div>
        <div id="bg-layer"></div>
        <!--FOOTER-->
        <?php $_template = new Smarty_Internal_Template("include_merchant/template_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
        <!--END FOOTER-->
    </body>
</html>
