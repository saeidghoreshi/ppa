<link rel="stylesheet"
      href="{$config.base_url}css/account-edit.css" type="text/css" />

<style TYPE="text/css">
td.right { color: #666; }
</style>


<script src="{$config.base_url}js/account/account-edit.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">


        

    <div id="account_info_update" class="account_info">
    	<div id="header-left" style="width: 100%;">
            <h1>Paypal Add Account Canceled</h1>
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

    <div class="clear"></div>
	
    <div class="account_info" style="height: 300px;">

	<p>Please relaunch PayPhoneAPP.</p>
        <!--<a title="O.K." class="ok_button"
           href="{$site_url}/account#">Ok</a>-->
    </div>

    </div>

</div>
