<link rel="stylesheet"
      href="{$config.base_url}css/account.css" type="text/css" />
<script src="{$config.base_url}js/account/account.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">

<div id="trans_wrap">
	<div id="header-left">
		<h1>Accounts</h1>
	</div>
	<div id="header-right">
		{* ADD/PRINT/SAVE/EXPORT SECTION *}
		<div class="custom_report clearfix">
	        <div class="linline">
	            <!--<a class="custom_button"
	               href="{$site_url}/account/add">
	            <span>
	                <img src="images/icon_plus.png" height="11" width="11"
	                     alt="" />
	                &nbsp;
	                Add Account
	            </span>
	            </a>-->
	        </div>
	        <div class="rinline">
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
                    <a href="javascript:window.print();">Print</a>
{if false}
	                    &nbsp;|&nbsp;
                    <a href="{$uri_string}#">Save</a>
	                    &nbsp;|&nbsp;
                    <a href="{$uri_string}#">Export</a>
{/if}
	                </span>
	            </span>
	        </div>
	    </div>
	</div>

<table id="accounts_list" class="resizable">
        <tr>
            <th class="chbox">&nbsp;</th>
            <th class="nick sort">
                Nickname <a href="{$uri_string}#"><img src="images/arrow_sort.png" alt="" /></a>
            </th>
            <th class="acc">Account #</th>
            <th class="expiery">Expiry</th>
            <th class="status">Status</th>
            <th class="activity">Last activity</th>
            <th class="amount">Amount</th>
            <th class="funds">Available funds</th>
            <th class="flag"><img id="flag-img" src="images/flag_white.png" alt="" /></th>
            <th class="view">&nbsp;</th>
        </tr>

        {if !empty($accounts)}
            {foreach from=$accounts item=account}
                <tr>
                    <td>
                        {* <input type="checkbox" name="account" value="1" checked /> *}
                    </td>
                    <td class="bold">{$account.account_name}</td>
                    <td>{$account.account_safenumber|default:"XXXX XXXXXXXX XXXX"}</td>
                    <td>{$account.account_expiry|default:"N/A"}</td>
                    <td>
                        {if $account.account_enabled}
                            Active
                        {else}
                            Suspended
                            <!--<a href="{$site_url}/account/enable/{$account.account_id}">
                                Enable
                            </a>-->
                        {/if}
                    </td>
                    <td>--- -- ----</td>
                    <td>$-.--</td>
                    <td>$-.--</td>
                    <td>&nbsp;</td>
                    <td class="view">
                        <a class="view_rec" href="{$site_url}/account/info/{$account.account_id}"
                           title="View Account">
                            View Account
                        </a>
                    </td>
                </tr>
            {/foreach}
        {/if}
        {if false}
        <tr>
            <td>{*<input type="checkbox" name="account" value="1" disabled />*}</td>
            <td class="bold">Company Visa</td>
            <td>**********************</td>
            <td>**/**</td>
            <td>Pending</td>
            <td>Jan 01 2011</td>
            <td>$3.55</td>
            <td>$*****</td>
            <td>&nbsp;</td>
            <td class="view"><a class="view_rec view_rec_disabled" href="{$uri_string}#" title="View Receipt">View Receipt</a></td>
        </tr>
        {/if}
<!-- MERGING TODO -->
    </table>
    
</div>