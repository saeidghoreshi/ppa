<link rel="stylesheet"
      href="{$config.base_url}css/account-edit.css" type="text/css" />
<script src="{$config.base_url}js/account/account-edit.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">


        

    <div id="account_info_update" class="account_info">
    	<div id="header-left">
        {if empty($account.id)}
            <h1>Add an Account</h1>
        {else}
            <h1>Edit an Account</h1>
        {/if}
        </div>
        
        <div id="header-right">
        <div class="custom_report">
        {if !empty($account.id)}
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
            <table class="account_info">
                <tr>
                    <td class="right">
                        <label for="paymethod">Type of Account:</label>
                    </td>
                    <td>
                        <input type="hidden" name="cardType" value="{$account.accounttype_code|escape}">
                        <select id="paymethod"
                                name="{$smarty.const.FORM_ACCOUNT_TYPE}">
                            <option value="" selected>Select one</option>
                            <option value="1" {if $account.accounttype == 1}selected{/if}>VISA</option>
                            <option value="2" {if $account.accounttype == 2}selected{/if}>MC</option>
{if !empty($account.id)}
                            <option value="3" {if $account.accounttype == 3}selected{/if}>AMEX</option>
                            <option value="10" {if $account.accounttype == 10}selected{/if}>Bank Account</option>
                            <option value="11" {if $account.accounttype == 11}selected{/if}>Gift Card</option>
                            <option value="12" {if $account.accounttype == 12}selected{/if}>Gift Card</option>
                            <option value="9" {if $account.accounttype == 9}selected{/if}>Paypal</option>
{/if}			    
                        </select>
                    </td>
                </tr>
                <tr class="dotted_line">
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>

            {* Visa Account Section *}
            <div id="paymethod-1" class="paymethod" {if $account.accounttype != '' and $account.accounttype != 10}style="display:block"{/if}>
                <table class="account_info">
                    <tr>
                        <td class="right">
                            <label for="payment-1-1">Nickname for Account:</label>
                        </td>
                        <td>
                            <input title="Nickname for Account"
                                   type="text" id="payment-1-1"
                                   name="{$smarty.const.FORM_ACCOUNT_NICKNAME}"
                                   value="{$account.nickname|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-2">Account Number:</label>
                        </td>
                        <td>
                            <input title="Account Number"
                                   type="text" id="payment-1-2"
                                   name="{$smarty.const.FORM_ACCOUNT_CREDITCARDNUMBER}"
                                   value="{$account.creditcardnumber|escape}" onFocus="if(this.value.indexOf('X')!=-1) this.value='';"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            {* Expiry date gets rendered as two fields (month/year)
                               even though it is one single field in the DB *}
                            <label for="payment-1-3">Expiry:</label>
                        </td>
                        <td class="select">
                            <select id="payment-1-3" name="{$smarty.const.FORM_ACCOUNT_EXPIRY_MONTH}">
                                <option value="" selected>Select Month</option>
                                <option value="01" {if $account.month == '01'}selected{/if}>01</option>
                                <option value="02" {if $account.month == '02'}selected{/if}>02</option>
                                <option value="03" {if $account.month == '03'}selected{/if}>03</option>
                                <option value="04" {if $account.month == '04'}selected{/if}>04</option>
                                <option value="05" {if $account.month == '05'}selected{/if}>05</option>
                                <option value="06" {if $account.month == '06'}selected{/if}>06</option>
                                <option value="07" {if $account.month == '07'}selected{/if}>07</option>
                                <option value="08" {if $account.month == '08'}selected{/if}>08</option>
                                <option value="09" {if $account.month == '09'}selected{/if}>09</option>
                                <option value="10" {if $account.month == '10'}selected{/if}>10</option>
                                <option value="11" {if $account.month == '11'}selected{/if}>11</option>
                                <option value="12" {if $account.month == '12'}selected{/if}>12</option>
                            </select>

                            <select name="{$smarty.const.FORM_ACCOUNT_EXPIRY_YEAR}">
                                <option value="" selected>Select Year</option>
                                <option value="11" {if $account.year == '11'}selected{/if}>2011</option>
                                <option value="12" {if $account.year == '12'}selected{/if}>2012</option>
                                <option value="13" {if $account.year == '13'}selected{/if}>2013</option>
                                <option value="14" {if $account.year == '14'}selected{/if}>2014</option>
                                <option value="15" {if $account.year == '15'}selected{/if}>2015</option>
                                <option value="16" {if $account.year == '16'}selected{/if}>2016</option>
                                <option value="17" {if $account.year == '17'}selected{/if}>2017</option>
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
                                   name="{$smarty.const.FORM_ACCOUNT_SECURITY_NUMBER}"
                                   value="{"/./"|preg_replace:"*":$account.securitynumber|escape}" onFocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-5">PIN:</label>
                        </td>
                        <td>
                            <input title="PIN"
                                   type="password" id="payment-1-5"
                                   name="{$smarty.const.FORM_ACCOUNT_SECURITY_PIN}"
                                   value="{"/./"|preg_replace:"*":$account.securitypin|escape}" onFocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
                        </td>
                    </tr>
                </table>
            </div>

            {* Bank Account Section *}
            <div id="paymethod-2" class="paymethod" {if $account.accounttype == 10}style="display:block"{/if}>
            	<h2>Coming soon!</h2>
                <!--<table class="account_info">
                    <tr>
                        <td class="right">
                            <label for="payment-2-1">Bank Name:</label>
                        </td>
                        <td>
                            <input title="Bank Name"
                                   type="text" id="payment-2-1"
                                   name="{$smarty.const.FORM_ACCOUNT_BANKNAME}"
                                   value="{$account.bankname|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-2">Transit Number (5 Digits):</label>
                        </td>
                        <td>
                            <input title="Transit Number"
                                   type="text" id="payment-2-2"
                                   name="{$smarty.const.FORM_ACCOUNT_TRANSIT}"
                                   value="{$account.transit|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-3">Institution Number (3 Digits):</label>
                        </td>
                        <td>
                            <input title="Institution Number"
                                   type="text" id="payment-2-3"
                                   name="{$smarty.const.FORM_ACCOUNT_INSTITUTION}"
                                   value="{$account.institution|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-4">Account Number (1-12 Digits):</label>
                        </td>
                        <td>
                            <input title="Account Number"
                                   type="text" id="payment-2-4"
                                   name="{$smarty.const.FORM_ACCOUNT_BANKNUMBER}"
                                   value="{$account.banknumber|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-2-5">ReEnter Account Number:</label>
                        </td>
                        <td>
                            <input title="Reenter Account Number"
                                   type="text" id="payment-2-5"
                                   name="{$smarty.const.FORM_ACCOUNT_BANKNUMBERCONFIRM}"
                                   value="" />
                        </td>
                    </tr>
                </table>-->
            </div>
            
            {if $errors}
			    <div class="error">
			        {$errors}
			    </div>
			{/if}

            {* Personal Information Section*}
            <div id="profile-info" {if !empty($account.id)}style="display:block"{/if}>
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
                            <label for="profile-1">First Name:</label>
                        </td>
                        <td>
                            <input title="First Name"
                                   type="text" id="profile-1"
                                   name="{$smarty.const.FORM_FIRSTNAME}"
                                   value="{$account.firstname|escape}" />
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
                                   value="{$account.lastname|escape}" />
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
                            <label for="profile-4">Street Address:</label>
                        </td>
                        <td>
                            <input title="Street Address"
                                   type="text" id="profile-4"
                                   name="{$smarty.const.FORM_ADDRESS_STREET}"
                                   value="{$account.street|escape}" />
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
                                   value="{$account.city|escape}" />
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
                                   value="{$account.state|escape}" />
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
                                   value="{$account.zip|escape}" />
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
                                   value="{$account.country|escape}" />
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
                                       value="{$account.id|escape}" />
                            {/if}
                            <table><tr><td>
                            <a title="Cancel"
                               href="{$site_url}/account/">
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
