<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 11:43:18
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web/system/application/views/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12137656864f85a696e65a16-91272566%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4334ce1fb81f269418875e4c3ba8459a715e9fae' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web/system/application/views/login.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12137656864f85a696e65a16-91272566',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('config')->value['index_page']=='messages'){?>
<?php $_template = new Smarty_Internal_Template('message/login.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php }else{ ?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/login.css" type="text/css" /> 

<div id="trans_wrap">

    <?php if (!$_smarty_tpl->getVariable('is_logged_in')->value){?>
        <?php if (empty($_smarty_tpl->getVariable('passphrase_question',null,true,false)->value)){?>
        	
        	<div class="login">
				<header role="banner">
					<img src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
images/logo_large.png" role="brand" alt="PayPhoneApp">
					<img src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
images/logo_small.png" role="brand" class="ie6-image" alt="PayPhoneApp">
				</header>
		
				<div id="main" role="main">
					<h1>Welcome to PayPhoneAPP!</h1>
					<h2>Please sign in.</h2>
					<form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/login" method="post" name="login_form">
                                            <?php if ($_smarty_tpl->getVariable('config')->value['index_page']=='merchant'){?>
						<input class="default-value" title="Phone Number" type="text" name="<?php echo @FORM_PHONE;?>
" placeholder="Phone Number">
                                            <?php }else{ ?>
						<input class="default-value" title="Email" type="text" name="<?php echo @FORM_EMAIL;?>
" placeholder="Email">
                                            <?php }?>
						<input class="default-value" title="Passcode" type="password" name="<?php echo @FORM_PASSCODE;?>
" placeholder="Passcode">
						<?php if ($_smarty_tpl->getVariable('errors')->value){?>
						    <div class="error">
						        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

						    </div>
						<?php }?>
						<input title="Sign In" type="submit" value="Sign In" class="submit">
                                            <?php if ($_smarty_tpl->getVariable('config')->value['index_page']!='merchant'){?>
						<a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/register" id="signup-link">Sign Up for the beta</a>
					    <?php }?>
					</form>
				</div>
			</div>
        <?php }else{ ?>
            <div class="login">
				<header role="banner">
					<img src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
images/logo_large.png" role="brand" alt="PayPhoneApp">
				</header>
				
				<div id="main" role="main">
                <h1>Verify your passphrase</h1>
	                <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/passphrase" method="post" name="passphrase_form">
	                    	<p><?php echo $_smarty_tpl->getVariable('passphrase_question')->value;?>
</p>
							<input class="default-value" title="Question" type="hidden" readonly="" name="<?php echo @FORM_PASSPHRASE_QUESTION;?>
" value="<?php echo $_smarty_tpl->getVariable('passphrase_question')->value;?>
" />
							<input class="default-value" title="Answer" type="password" name="<?php echo @FORM_PASSPHRASE_ANSWER;?>
" value="" autofocus />
							<input type="hidden" name="<?php echo @FORM_PASSPHRASE_SELECTED;?>
" value="<?php echo $_smarty_tpl->getVariable('selected_index')->value;?>
" />
							<input type="hidden" name="<?php echo @FORM_ENTITY_ID;?>
" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" />
							<?php if ($_smarty_tpl->getVariable('errors')->value){?>
							    <div class="error">
							        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

							    </div>
							<?php }?>
							<input title="confirm" type="submit" value="Confirm" />
	                </form>
                </div>
            </div>
        <?php }?>
    <?php }else{ ?>
        <h3>&nbsp;</h3>
        You are already logged in.

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user"
              method="post"
              name="profile_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Profile JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Profile"
                                   type="submit"
                                   value="Profile" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account"
              method="post"
              name="account_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Accounts JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Accounts"
                                   type="submit"
                                   value="Accounts" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/info/35"
              method="post"
              name="account_info_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Account Info JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Account Info"
                                   type="submit"
                                   value="Account Info" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/info/35"
              method="post"
              name="account_info_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Account Info JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Account Info"
                                   type="submit"
                                   value="Account Info" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/info"
              method="post"
              name="account_info_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Receipt Info JSON View</label>
                        </td>
                        <td>
                            <input title="Transaction"
                                   type="text"
                                   name="<?php echo @FORM_ENTITY_ID;?>
"
                                   value="" />
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Receipt Info"
                                   type="submit"
                                   value="Receipt Info" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction"
              method="post"
              name="transactions_form">
            <div id="profile-info">
                <table class="login">
                    <tr>
                        <td class="right">
                            <label for="login-1">Test Receipt List JSON View</label>
                        </td>
                        <td>
                            <input title="Ajax"
                                   type="hidden"
                                   name="json"
                                   value="1" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input title="View Receipts"
                                   type="submit"
                                   value="Receipts" />
                        </span>
                    </span>
                </div>
            </div>
        </form>

    <?php }?>
</div>

<div class="push"></div>

<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/v_center.js"></script>
<?php }?>

<?php $_template = new Smarty_Internal_Template('include/google_analytics.tpl', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
