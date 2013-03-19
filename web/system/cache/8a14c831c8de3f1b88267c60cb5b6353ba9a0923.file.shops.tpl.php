<?php /* Smarty version Smarty-3.0.6, created on 2012-04-12 11:42:23
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/shops.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19136841354f86f7dfc3b3f7-69601679%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a14c831c8de3f1b88267c60cb5b6353ba9a0923' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/shops.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19136841354f86f7dfc3b3f7-69601679',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/shops.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/shops.js"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_shops">
<div class="wrap">
<input type="hidden" name="test" id="test" value="abc">
        <div id="trans_wrap">
        	<div id="header-left">
        		<h1>Shops In Your Area</h1>
        	</div>
			<div id="header-right">
                <div class="custom_report clearfix">
                        <div class="rinline">
                                <form method="post" action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/shops/search">
                            <input class="search_field" type="text" name="search" value="" placeholder="Search" />
                                </form>
                        </div>				
                </div>
            </div>

                <div class="shops_wrap">

                        <div class="content clearfix">

                                <div class="linline">
                                        <ul id="shops_list" class="shops_list clearfix">
<?php if ($_smarty_tpl->getVariable('merchants')->value){?>
<?php  $_smarty_tpl->tpl_vars['m'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('merchants')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['m']->key => $_smarty_tpl->tpl_vars['m']->value){
?>
    <li><a id="shop-<?php echo $_smarty_tpl->tpl_vars['m']->value['merchant_id'];?>
" href="#"><?php echo $_smarty_tpl->tpl_vars['m']->value['merchant_name'];?>
</a></li>                                               
<?php }} ?>
<?php }else{ ?>
    No shops & restaurants are available.
<?php }?>
                                        </ul>
                                </div>
                                <div class="rinline">
                                        <div class="inner" id="shop_gMap">
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/shops-map.js"></script>
</head>
<body>
<input type="button" id="btnRefresh" value="Map Refresh" style="display:none">
<input type="hidden" id="merchant_id" value="">
<input type="hidden" id="search_condition" value="<?php echo $_smarty_tpl->getVariable('searchCondition')->value;?>
">
  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
                                        </div>
                                </div>
                                <div class="clr"></div>
                        </div>

                        <div id="info" class="info">
                        <div id="shop_info" class="shop_info"></div>
                        </div>

                </div>

        </div>
</div>