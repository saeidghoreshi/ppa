<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 11:43:18
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web/system/application/views/include/template_htmlheader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14305601604f85a696d7f8d1-62627552%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4981c611b9f617e22b87daffd1117acade9cb2e3' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web/system/application/views/include/template_htmlheader.tpl',
      1 => 1320956248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14305601604f85a696d7f8d1-62627552',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/mine/NetBeansProjects/PPA/FF/web/system/application/libraries/smarty/libs/plugins/modifier.escape.php';
?><!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="<?php echo $_smarty_tpl->getVariable('config')->value['meta_cotent'];?>
" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
    <title><?php echo smarty_modifier_escape(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('config')->value['title']));?>
</title>
    <meta name="description"
          content="<?php echo smarty_modifier_escape(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('config')->value['description']));?>
" />
    <meta name="keywords" content="<?php echo smarty_modifier_escape(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('config')->value['keywords']));?>
" />
    <meta name="robots"
          content="<?php echo (($tmp = @$_smarty_tpl->getVariable('config')->value['meta_robots'])===null||$tmp==='' ? $_smarty_tpl->getVariable('config')->value['meta_defaultrobots'] : $tmp);?>
">
    <base href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
">
    <link rel="stylesheet"
          href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/general.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"
            type="text/javascript"></script>
    <script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery.ezmark.min.js"
            type="text/javascript"></script>
    <script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/resizable-tables.js"
            type="text/javascript"></script>
    <script language="javascript" type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery-1.4.4.min.js"></script>
    <!--[if IE 6]>
	<script type="text/javascript" src="js/belatedpng.js"></script>
	<link rel="stylesheet" href="css/ie6.css" type="text/css" />
	<script type="text/javascript" src="js/ie6.js"></script>
	<script type="text/javascript">
		DD_belatedPNG.fix('a.view_rec, span.add_annotation, img, h1#logo_merch, th.flag');
	</script>
    <![endif]-->
    <!--[if IE 7]>
	<link rel="stylesheet" href="css/ie6.css" type="text/css" />
	<script type="text/javascript" src="js/ie6.js"></script>
    <![endif]-->
</head>