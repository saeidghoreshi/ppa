<?php /* Smarty version Smarty-3.0.6, created on 2012-04-22 19:50:19
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/user/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3218622464f94993bcf8a08-76709053%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e48c1bed26e08d1b83fcc862e018ccafe33bdf7e' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/user/edit.tpl',
      1 => 1335138618,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3218622464f94993bcf8a08-76709053',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/libraries/smarty/libs/plugins/modifier.escape.php';
?><link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/profile-edit.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_profile">

<?php if ($_smarty_tpl->getVariable('errors')->value){?>
    <div class="error">
        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

    </div>
<?php }?>

<div id="trans_wrap">
	<div id="header-left">
        <h1>Edit Profile</h1>
	</div>
	<div id="header-right">
    <div class="custom_report clearfix">
            <span class="custom_button">
                <span>
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/edit_passcode">
                        Change Passcode
                    </a>
                </span>
            </span>
        </div>
    </div>
    <div class="profile_info">
        <form action="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/user/update"
              method="post" name="update_profile_form">
            <div id="profile-info">
                <table class="profile_info">
                    <tr>
                        <td class="right">
                            <label for="profile-1">First Name*:</label>
                        </td>
                        <td>
                            <input title="First Name"
                                   type="text"
                                   name="<?php echo @FORM_FIRSTNAME;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['firstname']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-2">Last Name*:</label>
                        </td>
                        <td>
                            <input title="Last Name"
                                   type="text"
                                   name="<?php echo @FORM_LASTNAME;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['lastname']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-3">Prefix:</label>
                        </td>
                        <td class="select">
                            <select title="Prefix"
                                    name="<?php echo @FORM_PREFIX;?>
">
                                <option value="Mr." <?php if ($_smarty_tpl->getVariable('user')->value['prefix']=='Mr.'){?>selected<?php }?>>Mr.</option>
                                <option value="Ms." <?php if ($_smarty_tpl->getVariable('user')->value['prefix']=='Ms.'){?>selected<?php }?>>Ms.</option>
                                <option value="Mrs." <?php if ($_smarty_tpl->getVariable('user')->value['prefix']=='Mrs.'){?>selected<?php }?>>Mrs.</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-4">Date of Birth:</label>
                        </td>
                        <td>
                            <input title="Date of Birth"
                                   type="text"
                                   name="<?php echo @FORM_DOB;?>
"
                                   value="<?php if ($_smarty_tpl->getVariable('user')->value['dob']!='0000-00-00'){?><?php echo smarty_modifier_escape((($tmp = @$_smarty_tpl->getVariable('user')->value['dob'])===null||$tmp==='' ? '' : $tmp));?>
<?php }?>" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-5">Street Address*:</label>
                        </td>
                        <td>
                            <input title="Street Address"
                                   type="text"
                                   name="<?php echo @FORM_ADDRESS_STREET;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['street']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-6">City*:</label>
                        </td>
                        <td>
                            <input title="City"
                                   type="text"
                                   name="<?php echo @FORM_ADDRESS_CITY;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['city']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-7">State/Province*:</label>
                        </td>
                        <td>
                            <input title="State or Province"
                                   type="text"
                                   name="<?php echo @FORM_ADDRESS_STATE;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['state']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Zip/Postal Code*:</label>
                        </td>
                        <td>
                            <input title="Zip or Postal Code"
                                   type="text"
                                   name="<?php echo @FORM_ADDRESS_ZIP;?>
"
                                   value="<?php echo $_smarty_tpl->getVariable('user')->value['zip'];?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-9">Country*:</label>
                        </td>
                        <td>
                            <input title="Country"
                                   type="text"
                                   name="<?php echo @FORM_ADDRESS_COUNTRY;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['country']);?>
" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-10">Email*:</label>
                        </td>
                        <td>
                            <input title="Email"
                                   type="text"
                                   name="<?php echo @FORM_EMAIL;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['email']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-11">Phone*:</label>
                        </td>
                        <td>
                            <input title="Phone"
                                   type="text"
                                   name="<?php echo @FORM_PHONE;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['phone']);?>
" />
                        </td>
                    </tr>
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-12">Security Question 1*:</label>
                        </td>
                        <td>
                            <input title="Security Question 1"
                                   type="text"
                                   name="<?php echo @FORM_PASSPHRASE_1_QUESTION;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['question1']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-13">Security Answer 1*:</label>
                        </td>
                        <td>
                            <input title="Security Answer 1"
                                   type="password"
                                   name="<?php echo @FORM_PASSPHRASE_1_ANSWER;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['answer1']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-14">Security Clue 1*:</label>
                        </td>
                        <td>
                            <input title="Security Clue 1"
                                   type="text"
                                   name="<?php echo @FORM_PASSPHRASE_1_CLUE;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['clue1']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-15">Security Question 2:</label>
                        </td>
                        <td>
                            <input title="Security Question 2"
                                   type="text"
                                   name="<?php echo @FORM_PASSPHRASE_2_QUESTION;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['question2']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-16">Security Answer 2:</label>
                        </td>
                        <td>
                            <input title="Security Answer 2"
                                   type="password"
                                   name="<?php echo @FORM_PASSPHRASE_2_ANSWER;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['answer2']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-17">Security Clue 2:</label>
                        </td>
                        <td>
                            <input title="Security Clue 2"
                                   type="text"
                                   name="<?php echo @FORM_PASSPHRASE_2_CLUE;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('user')->value['clue2']);?>
" />
                        </td>
                    </tr>
		    <tr><td>&nbsp;</td><td>
                    * Required
		    </td></tr>
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
    </div>
</div>
