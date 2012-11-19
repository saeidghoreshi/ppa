<?php /* Smarty version Smarty-3.0.6, created on 2012-04-17 15:40:33
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/include/template_htmlheader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17214946574f8dc731d0a191-62319330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad62cea90ade69ed0059eba26b7162e9b41ff167' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/include/template_htmlheader.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17214946574f8dc731d0a191-62319330',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/libraries/smarty/libs/plugins/modifier.escape.php';
?><head>
    <meta http-equiv="Content-Type" content="<?php echo $_smarty_tpl->getVariable('config')->value['meta_cotent'];?>
" />
    <meta charset="utf-8" />
    <title><?php echo smarty_modifier_escape(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('config')->value['title']));?>
</title>
    <meta name="description" content="<?php echo smarty_modifier_escape(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('config')->value['description']));?>
" />
    <meta name="keywords" content="<?php echo smarty_modifier_escape(preg_replace('!<[^>]*?>!', ' ', $_smarty_tpl->getVariable('config')->value['keywords']));?>
" />
    <meta name="robots" content="<?php echo (($tmp = @$_smarty_tpl->getVariable('config')->value['meta_robots'])===null||$tmp==='' ? $_smarty_tpl->getVariable('config')->value['meta_defaultrobots'] : $tmp);?>
">
    <meta name="viewport" content="initial-scale=1.0; width=device-width; user-scalable=no">
    <base href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
">
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/mobile/mobile.css" type="text/css">
</head>
