<?php /* Smarty version Smarty-3.0.6, created on 2012-04-22 19:59:37
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5987903924f949b691b0808-87744654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de85ac7b8e166140d65f635d366fee4f707c4b5b' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/edit.tpl',
      1 => 1335139123,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5987903924f949b691b0808-87744654',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/libraries/smarty/libs/plugins/modifier.escape.php';
?><link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account-edit.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/account/account-edit.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">


        

    <div id="account_info_update" class="account_info">
    	<div id="header-left">
        <?php if (empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])){?>
            <h1>Add an Account</h1>
        <?php }else{ ?>
            <h1>Edit an Account</h1>
        <?php }?>
        </div>
        
        <div id="header-right">
        <div class="custom_report">
        <?php if (!empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])){?>
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
            <table class="account_info">
                <tr>
                    <td class="right">
                        <label for="paymethod">Type of Account:</label>
                    </td>
                    <td>
                        <input type="hidden" name="cardType" value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['accounttype_code']);?>
">
                        <select id="paymethod"
                                name="<?php echo @FORM_ACCOUNT_TYPE;?>
">
                            <option value="" selected>Select one</option>
                            <option value="1" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==1){?>selected<?php }?>>VISA</option>
                            <option value="2" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==2){?>selected<?php }?>>MC</option>
                            <option value="3" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==3){?>selected<?php }?>>AMEX</option>
                            <option value="10" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==10){?>selected<?php }?>>Bank Account</option>
                            <option value="12" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==12){?>selected<?php }?>>Prado GC</option>
                            <option value="9" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==9){?>selected<?php }?>>Paypal</option>
                        </select>
                    </td>
                </tr>
                <tr class="dotted_line">
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>
            <div id="paymethod-1" class="paymethod" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']!=''&&$_smarty_tpl->getVariable('account')->value['accounttype']!=10){?>style="display:block"<?php }?>>
                <table class="account_info">
                    <tr>
                        <td class="right">
                            <label for="payment-1-1">Nickname for Account:</label>
                        </td>
                        <td>
                            <input title="Nickname for Account"
                                   type="text" id="payment-1-1"
                                   name="<?php echo @FORM_ACCOUNT_NICKNAME;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['nickname']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-2">Account Number:</label>
                        </td>
                        <td>
                            <input title="Account Number"
                                   type="text" id="payment-1-2"
                                   name="<?php echo @FORM_ACCOUNT_CREDITCARDNUMBER;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['creditcardnumber']);?>
" onFocus="if(this.value.indexOf('X')!=-1) this.value='';"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-3">Expiry:</label>
                        </td>
                        <td class="select">
                            <select id="payment-1-3" name="<?php echo @FORM_ACCOUNT_EXPIRY_MONTH;?>
">
                                <option value="" selected>Select Month</option>
                                <option value="01" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='01'){?>selected<?php }?>>01</option>
                                <option value="02" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='02'){?>selected<?php }?>>02</option>
                                <option value="03" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='03'){?>selected<?php }?>>03</option>
                                <option value="04" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='04'){?>selected<?php }?>>04</option>
                                <option value="05" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='05'){?>selected<?php }?>>05</option>
                                <option value="06" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='06'){?>selected<?php }?>>06</option>
                                <option value="07" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='07'){?>selected<?php }?>>07</option>
                                <option value="08" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='08'){?>selected<?php }?>>08</option>
                                <option value="09" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='09'){?>selected<?php }?>>09</option>
                                <option value="10" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='10'){?>selected<?php }?>>10</option>
                                <option value="11" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='11'){?>selected<?php }?>>11</option>
                                <option value="12" <?php if ($_smarty_tpl->getVariable('account')->value['month']=='12'){?>selected<?php }?>>12</option>
                            </select>

                            <select name="<?php echo @FORM_ACCOUNT_EXPIRY_YEAR;?>
">
                                <option value="" selected>Select Year</option>
                                <option value="11" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='11'){?>selected<?php }?>>2011</option>
                                <option value="12" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='12'){?>selected<?php }?>>2012</option>
                                <option value="13" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='13'){?>selected<?php }?>>2013</option>
                                <option value="14" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='14'){?>selected<?php }?>>2014</option>
                                <option value="15" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='15'){?>selected<?php }?>>2015</option>
                                <option value="16" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='16'){?>selected<?php }?>>2016</option>
                                <option value="17" <?php if ($_smarty_tpl->getVariable('account')->value['year']=='17'){?>selected<?php }?>>2017</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-4">Security Number on Card:</label>
                        </td>
                        <td>
                            <input title="Security Number on Card"
                                   type="password" id="payment-1-4"
                                   name="<?php echo @FORM_ACCOUNT_SECURITY_NUMBER;?>
"
                                   value="<?php echo smarty_modifier_escape(preg_replace("/./","*",$_smarty_tpl->getVariable('account')->value['securitynumber']));?>
" onFocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-5">PIN:</label>
                        </td>
                        <td>
                            <input title="PIN"
                                   type="password" id="payment-1-5"
                                   name="<?php echo @FORM_ACCOUNT_SECURITY_PIN;?>
"
                                   value="<?php echo smarty_modifier_escape(preg_replace("/./","*",$_smarty_tpl->getVariable('account')->value['securitypin']));?>
" onFocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="paymethod-2" class="paymethod" <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==10){?>style="display:block"<?php }?>>
            	<h2>Coming soon!</h2>
                <!--<table class="account_info">
                    <tr>
                        <td class="right">
                            <label for="payment-2-1">Bank Name:</label>
                        </td>
                        <td>
                            <input title="Bank Name"
                                   type="text" id="payment-2-1"
                                   name="<?php echo @FORM_ACCOUNT_BANKNAME;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['bankname']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-2">Transit Number (5 Digits):</label>
                        </td>
                        <td>
                            <input title="Transit Number"
                                   type="text" id="payment-2-2"
                                   name="<?php echo @FORM_ACCOUNT_TRANSIT;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['transit']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-3">Institution Number (3 Digits):</label>
                        </td>
                        <td>
                            <input title="Institution Number"
                                   type="text" id="payment-2-3"
                                   name="<?php echo @FORM_ACCOUNT_INSTITUTION;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['institution']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-4">Account Number (1-12 Digits):</label>
                        </td>
                        <td>
                            <input title="Account Number"
                                   type="text" id="payment-2-4"
                                   name="<?php echo @FORM_ACCOUNT_BANKNUMBER;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['banknumber']);?>
" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-5">ReEnter Account Number:</label>
                        </td>
                        <td>
                            <input title="Reenter Account Number"
                                   type="text" id="payment-2-5"
                                   name="<?php echo @FORM_ACCOUNT_BANKNUMBERCONFIRM;?>
"
                                   value="" />
                        </td>
                    </tr>
                </table>-->
            </div>
            
            <?php if ($_smarty_tpl->getVariable('errors')->value){?>
			    <div class="error">
			        <?php echo $_smarty_tpl->getVariable('errors')->value;?>

			    </div>
			<?php }?>
            <div id="profile-info" <?php if (!empty($_smarty_tpl->getVariable('account',null,true,false)->value['id'])){?>style="display:block"<?php }?>>
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

                    <tr>
                        <td class="right">
                            <label for="profile-1">First Name:</label>
                        </td>
                        <td>
                            <input title="First Name"
                                   type="text" id="profile-1"
                                   name="<?php echo @FORM_FIRSTNAME;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['firstname']);?>
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
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['lastname']);?>
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
                            <label for="profile-4">Street Address:</label>
                        </td>
                        <td>
                            <input title="Street Address"
                                   type="text" id="profile-4"
                                   name="<?php echo @FORM_ADDRESS_STREET;?>
"
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['street']);?>
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
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['city']);?>
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
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['state']);?>
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
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['zip']);?>
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
                                   value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['country']);?>
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
                                       value="<?php echo smarty_modifier_escape($_smarty_tpl->getVariable('account')->value['id']);?>
" />
                            <?php }?>
                            <table><tr><td>
                            <a title="Cancel"
                               href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/">
                                Cancel
                            </a>
                            </td><td id="inputSubmitForm" >
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
