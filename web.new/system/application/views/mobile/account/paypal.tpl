<link rel="stylesheet" href="{$config.base_url}css/account-edit.css" type="text/css" />
<link rel="stylesheet" href="{$config.base_url}css/general.css" type="text/css">
<script src="{$config.base_url}js/account/account-edit.js" type="text/javascript"></script>
<style TYPE="text/css">
label { display: block; }
.copyright a { color: #01B0EF; }
.actions { text-align: left; }
input[type="text"], input[type="password"] {
width: 80%;
max-width: 300px;
}
#header-left {
width: 100%;
max-width: 300px;
}
</style>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">


        

    <div id="account_info_update" class="account_info">
    	<div id="header-left">
            <h1>Assign Paypal Account</h1>
        </div>
        
        <div id="header-right">
        <div class="custom_report">
        {if !empty($account.id) && false}
        <a class="custom_button"
           href="{$site_url}/account/add">
        <span>
            <img src="images/icon_plus.png" height="11" width="11"
                 alt="" />
            &nbsp;
            Add Account
        </span>
        </a>
        <span class="custom_button">
            <span>
{if false}
                        <a href="{$uri_string}#">Delete</a>
                &nbsp;|&nbsp;
{/if}
                    {if $account.account_enabled}
                        <a href="{$site_url}/account/suspend/{$account.id}">Suspend</a>
                    {else}
                        <a href="{$site_url}/account/enable/{$account.id}">Enable</a>
                    {/if}
            </span>
        </span>
        {/if}
        </div>
        </div>

        <form action="{$actionUrl}" method="post" name="form">
         
            {if $errors}
			    <div class="error">
			        {$errors}
			    </div>
			{/if}

            {* Personal Information Section*}
            <div id="profile-info" style="display:inline">
                <table class="account_info">
                    <tr class="dotted_line">
                        <td colspan="2">&nbsp;</td>
                    </tr>
		    {if false}
                    <tr class="use_profile">
                        <td class="r2">
                            {* Does not work. Ajax service not implemented *}
                            <a title="Use my profile info"
                               id="use_profile"
                               class="custom_button"
                               href="#">
                                <span>Use My Profile Info</span>
                            </a>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
		    {/if}
            {if !empty($paypal_error)}
                    <tr>
                        <td class="r2" colspan="2">
			    <div class="error" style="text-align: center;">
			        {$paypal_error}
			    </div>
                        </td>
                    </tr>
	    {/if}
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Paypal Email*</label>
                            <input title="Email"
                                   type="text" id="profile-8-1"
                                   name="email"
                                   value="{$smarty.post.email|default:$smarty.session.paypal_email|default:$user.email}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-1">First Name</label>
                            <input title="First Name"
                                   type="text" id="profile-1"
                                   name="{$smarty.const.FORM_FIRSTNAME}"
                                   value="{$smarty.post.firstname|default:$account.firstname}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-2">Last Name</label>
                            <input title="Last Name"
                                   type="text" id="profile-2"
                                   name="{$smarty.const.FORM_LASTNAME}"
                                   value="{$smarty.post.lastname|default:$account.lastname}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-3">Prefix</label>
                            <select id="profile-3" title="Prefix"
                                    name="{$smarty.const.FORM_PREFIX}">
                                <option value="Mr." {if $account.prefix == 'Mr.'}selected{/if}>Mr.</option>
                                <option value="Ms." {if $account.prefix == 'Ms.'}selected{/if}>Ms.</option>
                                <option value="Mrs." {if $account.prefix == 'Mrs.'}selected{/if}>Mrs.</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-4">Date of Birth</label>
                            <input title="Date of Birth"
                                   type="text"
                                   name="{$smarty.const.FORM_DOB}"
                                   value="{if !empty($smarty.post.dob)}{$smarty.post.dob}{else}{if $user.dob ne '0000-00-00'}{$user.dob|default:''}{/if}{/if}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-11">Phone</label>
                            <input title="Phone"
                                   type="text"
                                   name="{$smarty.const.FORM_PHONE}"
                                   value="{$smarty.post.phone|default:$user.phone}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-4">Street Address</label>
                            <input title="Street Address"
                                   type="text" id="profile-4"
                                   name="{$smarty.const.FORM_ADDRESS_STREET}"
                                   value="{$smarty.post.street|default:$account.street}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-5">City</label>
                            <input title="City"
                                   type="text" id="profile-5"
                                   name="{$smarty.const.FORM_ADDRESS_CITY}"
                                   value="{$smarty.post.city|default:$account.city}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-6">State/Province</label>
                            <input title="State/Province"
                                   type="text" id="profile-6"
                                   name="{$smarty.const.FORM_ADDRESS_STATE}"
                                   value="{$smarty.post.state|default:$account.state}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-7">Zip/Postal Code</label>
                            <input title="Zip"
                                   type="text" id="profile-7"
                                   name="{$smarty.const.FORM_ADDRESS_ZIP}"
                                   value="{$smarty.post.zip|default:$account.zip}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="r2">
                            <label for="profile-8">Country</label>
                            <input title="Country"
                                   type="text" id="profile-8"
                                   name="{$smarty.const.FORM_ADDRESS_COUNTRY}"
                                   value="{$smarty.post.country|default:$account.country}" />
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
                            <input type="hidden"
                                   name="{$smarty.const.FORM_ADDRESS_TYPE}"
                                   value="billing" />
                            {* Below hidden field only needs to be rendered
                               for Edit Account *}
                            {if !empty($account.id)}
                                <input type="hidden"
                                       name="{$smarty.const.FORM_ENTITY_ID}"
                                       value="{$account.id}" />
                            {/if}
                            <table><tr><td>
                            <a title="Cancel" href="{$site_url}/account/" style="font-weight: normal;">
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
