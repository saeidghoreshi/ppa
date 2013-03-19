<?php /* Smarty version Smarty-3.0.6, created on 2012-04-17 15:40:33
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10408671814f8dc731d5c725-20999639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '879731f192eee234e2c51c37d0f285e076f3beb7' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/mobile/login.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10408671814f8dc731d5c725-20999639',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('errors')->value){?>
    <div class="error">
        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

    </div>
<?php }?>

<?php if (!$_smarty_tpl->getVariable('is_logged_in')->value){?>
<h2>Login</h2>
    <form action='<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/login' method='post' name="login_form">
        <input class='default-value' placeholder='Email' title='Email' type='email' name='email' value='' />
        <br />

        <input class='default-value' placeholder='Passcode' title='Passcode' type='password' name='passcode' value='' />
        <br />

        <input type='submit' class='button wideButton' value='Login' />
    </form>
    <br/>
    Not registered yet?
    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/register">Sign up!</a>
<?php }else{ ?>
    <h3>&nbsp;</h3>
    You are already logged in.
    <br/>
    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/">View your profile</a>
<?php }?>
