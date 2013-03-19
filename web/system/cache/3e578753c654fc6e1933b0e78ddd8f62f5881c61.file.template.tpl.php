<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:12:54
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3964125344f85ad863b7294-05245905%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e578753c654fc6e1933b0e78ddd8f62f5881c61' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/template.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3964125344f85ad863b7294-05245905',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <!--HTMLHEADER-->
    <?php $_template = new Smarty_Internal_Template("include/template_htmlheader.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
    <!--END HTMLHEADER-->
    <body>
        <div id='wrap'>
            <div class='wrap'>
                <!--HEADER-->
                <?php $_template = new Smarty_Internal_Template("include/template_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                <!--END HEADER-->
                <!--BODY-->
                <?php if ($_smarty_tpl->getVariable('template')->value!='user/register'&&$_smarty_tpl->getVariable('template')->value!='user/create'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_email'&&$_smarty_tpl->getVariable('template')->value!='user/login'&&$_smarty_tpl->getVariable('template')->value!='login'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_passcode'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_token'){?><div id="bodyContent">
                <div id="white"></div><?php }?>
                <?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('template')->value).".tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
                <?php if ($_smarty_tpl->getVariable('template')->value!='user/register'&&$_smarty_tpl->getVariable('template')->value!='user/create'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_email'&&$_smarty_tpl->getVariable('template')->value!='user/login'&&$_smarty_tpl->getVariable('template')->value!='login'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_passcode'&&$_smarty_tpl->getVariable('template')->value!='user/confirm_token'){?></div><?php }?>
                <!--END BODY-->
            </div>
        </div>
        <div id="bg-layer"></div>
        <!--FOOTER-->
        <?php $_template = new Smarty_Internal_Template("include/template_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
        <!--END FOOTER-->
    </body>
</html>