<link rel="stylesheet"
      href="{$config.base_url}css/account-edit.css" type="text/css" />
<script src="{$config.base_url}js/account/account-edit.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">

    <div id="account_info_update" class="account_info">
	
    	<div id="header-left">
            <h1>Confirm Paypal Account</h1>
        </div>
	{if false && !empty($createdAccount)}
<table align="center" width="50%">
    <tr>
        <td class="thinfield">CorrelationId:</td>
        <td class="thinfield">{$createdAccount->responseEnvelope->correlationId}</td>
    </tr>
    <tr>
        <td class="thinfield">CreateAccountKey:</td>
        <td class="thinfield">{$createdAccount->createAccountKey}</td>
    </tr>
    <tr>
        <td class="thinfield">AccountId:</td>
        <td class="thinfield">{$createdAccount->accountId}</td>
    </tr>
    <tr>
        <td class="thinfield">Status:</td>
        <td class="thinfield">{$createdAccount->execStatus}</td>
    </tr>
</table>
    {/if}
    
    
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
            {if !empty($paypal_error)}
                    <tr>
                        <td class="right" colspan="2">
			    <div class="error" style="text-align: center;">
			        {$paypal_error}
			    </div>
                        </td>
                    </tr>
	    {/if}
                    <tr>
                        <td class="right">
                            <label for="profile-8">Paypal Email*:</label>
                        </td>
                        <td>
                            <input title="Email"
                                   type="email" id="profile-8-1"
                                   name="email"
                                   value="{$smarty.post.email|default:$smarty.session.paypal_email|default:$user.email|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Starting date*:</label>
                        </td>
                        <td>
                            <input title="Starting date"
                                   type="date" id="profile-8-2"
                                   name="startingDate"
                                   value="{$smarty.post.startingDate|default:$smarty.now|date_format:"%Y-%m-%d"|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Ending date*:</label>
                        </td>
                        <td>
                            <input title="Ending date"
                                   type="date" id="profile-8-3"
                                   name="endingDate"
                                   value="{$smarty.post.endingDate|default:($smarty.now+30672000)|date_format:"%Y-%m-%d"|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Maximum Number of Payments:</label>
                        </td>
                        <td>
                            <input title="Maximum Number of Payments"
                                   type="tel" id="profile-8-4"
                                   name="maxNumberOfPayments"
                                   value="{$smarty.post.maxNumberOfPayments|default:1000|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="profile-8">Maximum Total Amount*:</label>
                        </td>
                        <td>
                            <input title="Maximum Total Amount"
                                   type="tel" id="profile-8-5"
                                   name="maxTotalAmountOfAllPayments"
                                   value="{$smarty.post.maxTotalAmountOfAllPayments|default:2000|escape}" />
                        </td>
                    </tr>
                    <tr>
                        <td class="right">
                            <label for="payment-1-5">Security PIN*:</label>
                        </td>
                        <td>
                            <input title="PIN"
                                   type="tel" id="payment-1-5"
                                   name="{$smarty.const.FORM_ACCOUNT_SECURITY_PIN}"
                                   value="{"/./"|preg_replace:"*":$account.securitypin|escape}" onFocus="if(this.value.indexOf('*')!=-1) this.value='';"/>
                        </td>
                    </tr>
                </table>
                <div class="actions">
                    <span class="custom_button">
                        <span>
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
                            </td><td id="paypalSubmitForm">
                            &nbsp;| <input title="Confirm" type="submit"
                                   name="save" value="Confirm" />
                    	    </td></tr></table>
                        </span>
                    </span>
                </div>
            </div>
        </form>

    </div>

</div>
