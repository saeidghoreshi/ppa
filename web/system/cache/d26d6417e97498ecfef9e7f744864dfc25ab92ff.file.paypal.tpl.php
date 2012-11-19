<?php /* Smarty version Smarty-3.0.6, created on 2012-04-16 17:26:19
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/paypal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13947884874f8c8e7b335134-93138706%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd26d6417e97498ecfef9e7f744864dfc25ab92ff' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/paypal.tpl',
      1 => 1334611578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13947884874f8c8e7b335134-93138706',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account-edit.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/account/account-edit.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">


        

    <div id="account_info_update" class="account_info">
    	<div id="header-left">
            <h1>Assign Paypal Account</h1>
        </div>
        
        <div id="header-right">
        <div class="custom_report">
        <?php if (!empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])&&false){?>
        <a class="custom_button"
           href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/add">
        <span>
            <img src="images/icon_plus.png" height="11" width="11"
                 alt="" />
            &nbsp;
            Add Account
        </span>
        </a>
        <span class="custom_button">
            <span>
<?php if (false){?>
                        <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Delete</a>
                &nbsp;|&nbsp;
<?php }?>
                    <?php if ($_smarty_tpl->getVariable('account')->value['account_enabled']){?>
                        <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/suspend/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">Suspend</a>
                    <?php }else{ ?>
                        <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/enable/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">Enable</a>
                    <?php }?>
            </span>
        </span>
        <?php }?>
        </div>
        </div>

        <form action="<?php echo $_smarty_tpl->getVariable('actionUrl')->value;?>
" method="post" name="form">
         
            <?php if ($_smarty_tpl->getVariable('errors')->value){?>
			    <div class="error">
			        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

			    </div>
			<?php }?>
            <div id="profile-info" style="display:inline">
                <table class="account_info">
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr class="use_profile">
                        <td class="right">
                            <a title="Use my profile info"
                               id="use_profile"
                               class="custom_button"
                               href="#">
                                <span>Use My Profile Info</span>
                            </a>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
            <?php if (!empty($_smarty_tpl->getVariable('paypal_error',null,true,false)->value)){?>
                    <tr>
                        <td class="right" colspan="2">
			    <div class="error" style="text-align: center;">
			        <?php echo $_smarty_tpl->getVariable('paypal_error')->value;?>

			    </div>
                        </td>
                    </tr>
	    <?php }?>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Paypal Email*:</label>
                        </td>
                        <td>
                            <input title="Email"
                                   type="text" id="profile-8-1"
                                   name="email"
                                   value="<?php echo (($tmp = @(($tmp = @$_POST['email'])===null||$tmp==='' ? $_SESSION['paypal_email'] : $tmp))===null||$tmp==='' ? $_smarty_tpl->getVariable('user')->value['email'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-1">First Name:</label>
                        </td>
                        <td>
                            <input title="First Name"
                                   type="text" id="profile-1"
                                   name="<?php echo @FORM_FIRSTNAME;?>
"
                                   value="<?php echo (($tmp = @$_POST['firstname'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['firstname'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-2">Last Name:</label>
                        </td>
                        <td>
                            <input title="Last Name"
                                   type="text" id="profile-2"
                                   name="<?php echo @FORM_LASTNAME;?>
"
                                   value="<?php echo (($tmp = @$_POST['lastname'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['lastname'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-3">Prefix:</label>
                        </td>
                        <td class="select">
                            <select id="profile-3" title="Prefix"
                                    name="<?php echo @FORM_PREFIX;?>
">
                                <option value="Mr." <?php if ($_smarty_tpl->getVariable('account')->value['prefix']=='Mr.'){?>selected<?php }?>>Mr.</option>
                                <option value="Ms." <?php if ($_smarty_tpl->getVariable('account')->value['prefix']=='Ms.'){?>selected<?php }?>>Ms.</option>
                                <option value="Mrs." <?php if ($_smarty_tpl->getVariable('account')->value['prefix']=='Mrs.'){?>selected<?php }?>>Mrs.</option>
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
                                   value="<?php if (!empty($_POST['dob'])){?><?php echo $_POST['dob'];?>
<?php }else{ ?><?php if ($_smarty_tpl->getVariable('user')->value['dob']!='0000-00-00'){?><?php echo (($tmp = @$_smarty_tpl->getVariable('user')->value['dob'])===null||$tmp==='' ? '' : $tmp);?>
<?php }?><?php }?>" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-11">Phone:</label>
                        </td>
                        <td>
                            <input title="Phone"
                                   type="text"
                                   name="<?php echo @FORM_PHONE;?>
"
                                   value="<?php echo (($tmp = @$_POST['phone'])===null||$tmp==='' ? $_smarty_tpl->getVariable('user')->value['phone'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-4">Street Address:</label>
                        </td>
                        <td>
                            <input title="Street Address"
                                   type="text" id="profile-4"
                                   name="<?php echo @FORM_ADDRESS_STREET;?>
"
                                   value="<?php echo (($tmp = @$_POST['street'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['street'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-5">City:</label>
                        </td>
                        <td>
                            <input title="City"
                                   type="text" id="profile-5"
                                   name="<?php echo @FORM_ADDRESS_CITY;?>
"
                                   value="<?php echo (($tmp = @$_POST['city'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['city'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-6">State/Province:</label>
                        </td>
                        <td>
                            <input title="State/Province"
                                   type="text" id="profile-6"
                                   name="<?php echo @FORM_ADDRESS_STATE;?>
"
                                   value="<?php echo (($tmp = @$_POST['state'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['state'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-7">Zip/Postal Code:</label>
                        </td>
                        <td>
                            <input title="Zip"
                                   type="text" id="profile-7"
                                   name="<?php echo @FORM_ADDRESS_ZIP;?>
"
                                   value="<?php echo (($tmp = @$_POST['zip'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['zip'] : $tmp);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Country:</label>
                        </td>
                        <td>
                            <input title="Country"
                                   type="text" id="profile-8"
                                   name="<?php echo @FORM_ADDRESS_COUNTRY;?>
"
                                   value="<?php echo (($tmp = @$_POST['country'])===null||$tmp==='' ? $_smarty_tpl->getVariable('account')->value['country'] : $tmp);?>
" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input type="hidden"
                                   name="<?php echo @FORM_ADDRESS_TYPE;?>
"
                                   value="billing" />
                            <?php if (!empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])){?>
                                <input type="hidden"
                                       name="<?php echo @FORM_ENTITY_ID;?>
"
                                       value="<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
" />
                            <?php }?>
                            <table><tr><td>
                            <a title="Cancel"
                               href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/">
                                Cancel
                            </a>
                            </td><td id="inputPaypalForm" >
                            &nbsp;| <input title="Save Data" type="submit"
                                   name="save" value="Save" />
                    	    </td></tr></table>
                        </span>
                    </span>
                </div>
            </div>
        </form>

    </div>

</div>
