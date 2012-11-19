<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:14:51
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/include_merchant/template_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14200795824f85adfb315287-63826440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ad1c317e4fff10893245f4b703969772baf9b51' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/include_merchant/template_header.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14200795824f85adfb315287-63826440',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/header.js"></script>

<div id="header" class="clearfix">
    <h1 id="logo_merch" class="linline">
        <a href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/payment/request_new" title="PayPhoneApp">Payphoneapp.com</a>
    </h1>
    <?php if ($_smarty_tpl->getVariable('is_logged_in')->value){?>
        <div class="panel_controls rinline_merch">
                <?php if (!empty($_SESSION['user_firstname'])){?>
                    Hello, <?php echo $_SESSION['user_firstname'];?>
!
		&nbsp;|&nbsp;
		<?php }?>
            <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/logout">Sign Out</a>
            &nbsp;|&nbsp;
            <a href="javascript:return false;">Manager</a>
            &nbsp;|&nbsp;
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
<div id="h_navigation" class="navigation_merch" style="margin: 0 0 0 160px;">
        <div class="inner">
                <ul class="clearfix">
                        <li><a id="h_invite" class="first" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/sms_twilio"><span><span class="i"><b>Invite</b></span></a></li>
                        <li><a id="h_request" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/payment/request_new"><span><span class="i"><b>Request Payment</b></span></span></a></li>
                        <li><a id="h_refill" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/payment/refill"><span><span class="i"><b>Refill GC</b></span></span></a></li>
                        <li class="last lower"><a id="h_receiptsmerch" class="last" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/transaction/recent"><span><span class="i"><b>Receipts</b></span></span></a></li>
                </ul>
        </div>
</div>
<?php }else{ ?>
<div id="loggedout-header">
        &nbsp;
</div>
<?php }?>