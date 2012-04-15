<link rel="stylesheet"
      href="{$config.base_url}css/account-edit.css" type="text/css" />
<script src="{$config.base_url}js/account/account-edit.js" type="text/javascript"></script>
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
                    <tr class="use_profile">
                        <td class="right">
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

                    <tr>
                        <td class="right">
                            <label for="profile-8">Paypal Email*:</label>
                        </td>
                        <td>
                            <input title="Email"
                                   type="text" id="profile-8-1"
                                   name="email"
                                   value="{$smarty.post.email|default:$smarty.session.paypal_email|default:$user.email}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-1">First Name:</label>
                        </td>
                        <td>
                            <input title="First Name"
                                   type="text" id="profile-1"
                                   name="{$smarty.const.FORM_FIRSTNAME}"
                                   value="{$account.firstname}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-2">Last Name:</label>
                        </td>
                        <td>
                            <input title="Last Name"
                                   type="text" id="profile-2"
                                   name="{$smarty.const.FORM_LASTNAME}"
                                   value="{$account.lastname}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-3">Prefix:</label>
                        </td>
                        <td class="select">
                            <select id="profile-3" title="Prefix"
                                    name="{$smarty.const.FORM_PREFIX}">
                                <option value="Mr." {if $account.prefix == 'Mr.'}selected{/if}>Mr.</option>
                                <option value="Ms." {if $account.prefix == 'Ms.'}selected{/if}>Ms.</option>
                                <option value="Mrs." {if $account.prefix == 'Mrs.'}selected{/if}>Mrs.</option>
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
                                   name="{$smarty.const.FORM_DOB}"
                                   value="{$user.dob}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-11">Phone:</label>
                        </td>
                        <td>
                            <input title="Phone"
                                   type="text"
                                   name="{$smarty.const.FORM_PHONE}"
                                   value="{$user.phone}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-4">Street Address:</label>
                        </td>
                        <td>
                            <input title="Street Address"
                                   type="text" id="profile-4"
                                   name="{$smarty.const.FORM_ADDRESS_STREET}"
                                   value="{$account.street}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-5">City:</label>
                        </td>
                        <td>
                            <input title="City"
                                   type="text" id="profile-5"
                                   name="{$smarty.const.FORM_ADDRESS_CITY}"
                                   value="{$account.city}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-6">State/Province:</label>
                        </td>
                        <td>
                            <input title="State/Province"
                                   type="text" id="profile-6"
                                   name="{$smarty.const.FORM_ADDRESS_STATE}"
                                   value="{$account.state}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-7">Zip/Postal Code:</label>
                        </td>
                        <td>
                            <input title="Zip"
                                   type="text" id="profile-7"
                                   name="{$smarty.const.FORM_ADDRESS_ZIP}"
                                   value="{$account.zip}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Country:</label>
                        </td>
                        <td>
                            <input title="Country"
                                   type="text" id="profile-8"
                                   name="{$smarty.const.FORM_ADDRESS_COUNTRY}"
                                   value="{$account.country}" />
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
                            <a title="Cancel"
                               href="{$site_url}/account/">
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
