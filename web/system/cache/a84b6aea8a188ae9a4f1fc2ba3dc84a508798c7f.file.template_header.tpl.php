<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 11:43:18
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web/system/application/views/include/template_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2744887084f85a696df1ca4-15180488%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a84b6aea8a188ae9a4f1fc2ba3dc84a508798c7f' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web/system/application/views/include/template_header.tpl',
      1 => 1320956248,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2744887084f85a696df1ca4-15180488',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/header.js"></script>

<div id="header" class="clearfix">
    <h1 id="logo" class="linline">
        <a href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
" title="PayPhoneApp">Payphoneapp.com</a>
    </h1>
    <?php if ($_smarty_tpl->getVariable('is_logged_in')->value){?>
        <div class="panel_controls rinline">
                <?php if (!empty($_SESSION['user_firstname'])){?>
                    Hello, <?php echo $_SESSION['user_firstname'];?>
!
		&nbsp;|&nbsp;
		<?php }?>
            <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/logout">Sign Out</a>
            &nbsp;|&nbsp;
            <!--<a href="#">Settings</a>
            &nbsp;|&nbsp;-->
            <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/info/contact">Help</a>
        </div>
    <?php }else{ ?>
    	<div class="panel_controls rinline">
            <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/login">Sign In</a>
            &nbsp;|&nbsp;
            <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/register">Register</a>
            &nbsp;|&nbsp;
            <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/info/contact">Help</a>
        </div>
    <?php }?>
</div>

<?php if ($_smarty_tpl->getVariable('is_logged_in')->value){?>
<div id="h_navigation" class="navigation">
        <div class="inner">
                <ul class="clearfix">
                        <li><a id="h_overview" class="first" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/summary"><span><span class="i"><b>Overview</b></span></a></li>
                        <li><a id="h_transaction" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction"><span><span class="i"><b>Receipts</b></span></span></a></li>
                        <li><a id="h_account" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account"><span><span class="i"><b>Accounts</b></span></span></a></li>
                        <li><a id="h_profile" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user"><span><span class="i"><b>Profile</b></span></span></a></li>
                        <li class="last lower"><a id="h_shops" class="last" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/shops"><span><span class="i"><b>Shops &amp; Restaurants</b></span></span></a></li>
                </ul>
        </div>
</div>
<?php }else{ ?>
<div id="loggedout-header">
        &nbsp;
</div>
<?php }?>
