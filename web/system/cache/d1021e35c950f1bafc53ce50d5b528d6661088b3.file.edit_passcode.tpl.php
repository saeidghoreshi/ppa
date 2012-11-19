<?php /* Smarty version Smarty-3.0.6, created on 2012-04-22 19:40:59
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/user/edit_passcode.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21256203774f94970b10c4c5-53026275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1021e35c950f1bafc53ce50d5b528d6661088b3' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/user/edit_passcode.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21256203774f94970b10c4c5-53026275',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/profile-edit-passcode.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_profile">

<?php if ($_smarty_tpl->getVariable('errors')->value){?>
    <div class="error">
        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

    </div>
<?php }?>

<div id="trans_wrap">
	<div id="header-left">
		<h1>Change Passcode</h1>
	</div>
    <div class="custom_report clearfix">
        <span class="custom_button">
            <span>
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/edit">
                    Edit
                </a>
            </span>
        </span>
    </div>
    <p>Please <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/info/contact">contact us</a> to change your password.</p>
    <div class="passcode_info">
        <?php if (true){?>
        <!--<h2>Please change Passcode from your phone</h2>-->
        <?php }else{ ?>
        <h3>Change <small>your</small><br />Passcode</h3>

        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/update_passcode"
              method="post" name="change_passcode_form">
            <div id="passcode-info">
                <table class="passcode_info">
                    <tr>
                        <td class="right">
                            <label for="passcode-1">Old Passcode:</label>
                        </td>
                        <td>
                            <input title="Old Passcode"
                                   type="password"
                                   name="<?php echo @FORM_OLD_PASSCODE;?>
"
                                   value="" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="passcode-2">New Passcode:</label>
                        </td>
                        <td>
                            <input title="New Passcode"
                                   type="password"
                                   name="<?php echo @FORM_PASSCODE;?>
"
                                   value="" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="passcode-3">Confirm New Passcode:</label>
                        </td>
                        <td>
                            <input title="Confirm New Passcode"
                                   type="password"
                                   name="<?php echo @FORM_CONFIRM_PASSCODE;?>
"
                                   value="" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <a title="Cancel"
                               href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/">
                                Cancel
                            </a>
                            &nbsp;|&nbsp;
                            <input title="Save" type="submit"
                                   name="save" value="Save" />
                        </span>
                    </span>
                </div>
            </div>
        </form>
    <?php }?>
    </div>
</div>
