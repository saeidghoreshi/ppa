<?php /* Smarty version Smarty-3.0.6, created on 2012-04-17 15:40:33
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/template.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6351368414f8dc731caa555-84998174%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '214bcb2c4b7ac5afb0d271a93b3dca2b4680faee' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/template.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6351368414f8dc731caa555-84998174',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!doctype html>
<html lang="en"> 
<!--HTMLHEADER-->
<?php $_template = new Smarty_Internal_Template("include/template_htmlheader.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<!--END HTMLHEADER-->
	<body class='mobile'>
		<div id='mainContent'>
<!--HEADER-->
<?php $_template = new Smarty_Internal_Template("include/template_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<!--END HEADER-->
<!--BODY-->
<?php $_template = new Smarty_Internal_Template(($_smarty_tpl->getVariable('template')->value).".tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<!--END BODY-->
		</div>
<!--FOOTER-->
<?php $_template = new Smarty_Internal_Template("include/template_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<!--END FOOTER-->
</body>
</html>
