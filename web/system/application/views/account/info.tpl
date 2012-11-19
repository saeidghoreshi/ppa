<link rel="stylesheet"
      href="{$config.base_url}css/account-info.css" type="text/css" />
<script src="{$config.base_url}js/account/account-info.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_account">
	<div id="header-left">
		<h1>Account Info</h1>
	</div>
	<div id="header-right">
		 <div class="custom_report clearfix">
	            <a class="custom_button"
	               onclick="goBack();">
	            <span>
	                Back
	            </span>
	            </a>
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
			    {if $account.accounttype ne 9 and $account.accounttype ne 12}
	                    <a href="{$site_url}/account/edit/{$account.id}">
	                    Edit
	                    </a>
	                    &nbsp;|&nbsp;
			    {/if}
{if false}
                    <a href="{$uri_string}#">Delete</a>
                    &nbsp;|&nbsp;
{/if}
                    {if $account.account_enabled}
                        <a href="{$site_url}/account/suspend/{$account.id}">Suspend</a>
                    {else}
                        <a href="{$site_url}/account/enable/{$account.id}">Activate</a>
                    {/if}
	                </span>
	            </span>
	    </div>
	</div>
   

    {* INFO SECTION *}
    <div class="account_info">
        <table class="account_info">
            {if $account.accounttype != 10}
                <tr>
                    <td class="right">Nickname:</td>
                    <td>{$account.nickname}</td>
                </tr>
                <tr>
                    <td class="right">Status:</td>
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
                </tr>
                <tr class="dotted_line">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="right">Type of Account:</td>
                    <td>{if $account.accounttype eq 9}Paypal{elseif $account.accounttype eq 12}Gift Card{else}Credit Card{/if}</td>
                </tr>
                <tr>
                    <td class="right">Account Number:</td>
                    <td>{$account.creditcardnumber}</td>
                </tr>
                <tr>
                    <td class="right">Expiry:</td>
                    <td>{$account.month}/{$account.year}</td>
                </tr>
                <tr>
                    <td class="right">Security Number on Card:</td>
                    <td>***</td>
                </tr>
            {elseif $account.accounttype == 2}
                <tr>
                    <td class="right">Nickname:</td>
                    <td>{$account.bankname}</td>
                </tr>
                <tr class="dotted_line">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="right">Type of Account:</td>
                    <td>Bank Account</td>
                </tr>
                <tr>
                    <td class="right">Account Number:</td>
                    <td>{$account.banknumber}</td>
                </tr>
                <tr>
                    <td class="right">Institution Number</td>
                    <td>{$account.institution}</td>
                </tr>
                <tr>
                    <td class="right">Transit Number:</td>
                    <td>{$account.transit}</td>
                </tr>
            {else}
                Unknown account type
            {/if}
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
    </div>

    {* TRANSACTIONS SECTION *}
    <!--<div class="button_above">
    <div class="custom_report">
        <a class="custom_button" href="{$uri_string}#">
        <span>
            Custom Report&nbsp;
            <img src="images/icon_plus.png" height="11" width="11" alt="" />
        </span>
        </a>
    </div>
    </div>-->
    <table id="transaction_list" class="resizable">
        <tr>
            <th class="date{if $column == $smarty.const.TRANSACTION_ORDERBY_DATE} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_DATE}/5/{$descend}">
                Date
                {if $column == $smarty.const.TRANSACTION_ORDERBY_DATE}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="trans{if $column == $smarty.const.TRANSACTION_ORDERBY_ID} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_ID}/5/{$descend}">
                Trans #
                {if $column == $smarty.const.TRANSACTION_ORDERBY_ID}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="time{if $column == $smarty.const.TRANSACTION_ORDERBY_TIME} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_TIME}/5/{$descend}">
                Time
                {if $column == $smarty.const.TRANSACTION_ORDERBY_TIME}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="merch{if $column == $smarty.const.TRANSACTION_ORDERBY_MERCHANT} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_MERCHANT}/5/{$descend}">
                Merchant
                {if $column == $smarty.const.TRANSACTION_ORDERBY_MERCHANT}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="ann{if $column == $smarty.const.TRANSACTION_ORDERBY_NOTE} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_NOTE}/5/{$descend}">
                Annotation
                {if $column == $smarty.const.TRANSACTION_ORDERBY_NOTE}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="status{if $column == $smarty.const.TRANSACTION_ORDERBY_STATUS} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_STATUS}/5/{$descend}">
                Status
                {if $column == $smarty.const.TRANSACTION_ORDERBY_STATUS}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="amount{if $column == $smarty.const.TRANSACTION_ORDERBY_AMOUNT} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_AMOUNT}/5/{$descend}">
                Amount
                {if $column == $smarty.const.TRANSACTION_ORDERBY_AMOUNT}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="account{if $column == $smarty.const.TRANSACTION_ORDERBY_ACCOUNT} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_ACCOUNT}/5/{$descend}">
                Account
                {if $column == $smarty.const.TRANSACTION_ORDERBY_ACCOUNT}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="flag{if $column == $smarty.const.TRANSACTION_ORDERBY_FLAG} sort{/if}">
                <a href="{$site_url}/account/info/{$account.id}/{$smarty.const.TRANSACTION_ORDERBY_FLAG}/5/{$descend}">
                <img src="images/flag_white.png" alt="" />
                {if $column == $smarty.const.TRANSACTION_ORDERBY_FLAG}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="view">&nbsp;</th>
        </tr>
        {foreach from=$transactions item=t name=transaction}
            <tr id="trans-show-{$smarty.foreach.transaction.iteration}">
                <td>
                    {*<input type="checkbox" value="1" checked />*}
                    <span class="data-1">{$t.transaction_date_paid}</span>
                </td>
                <td><span class="data-2">PPA {$t.transaction_id}</span></td>
                <td><span class="data-3">{$t.transaction_time_paid}</span></td>
                <td class="bold">
                    <span class="data-4">{$t.merchant_name}</span>
                </td>
                <td class="ann">
                    <div class="annw">
                        <span class="data-5">{$t.transaction_user_note}</span>
                        <span id="ann-id-{$smarty.foreach.transaction.iteration}"
                              class="add_annotation" title="Add Annotation">
                            Add Annotation
                        </span>
                    </div>
                </td>
                <td class="bold">
                    <span class="data-6">
                        {if $t.transaction_paid}
                        PAID
                        {elseif $t.transaction_cancelled}
                        CANCELED
                        {/if}
                    </span>
                </td>
                <td>
                    <span class="data-7">${$t.transaction_amount|number_format:2:".":","}</span>
                </td>
                <td><span class="data-8">{$t.account_name}</span></td>
                <td>
                    {if $t.transaction_flagged}
                    <img src="images/icon_trans_flag.gif" alt="" />
                    {/if}
                    <input type="hidden" name="flag" value="{$t.transaction_flagged}">
                    <input type="hidden" name="transId" value="{$t.transaction_id}">
                </td>
                <td><a class="view_rec" href="{$uri_string}#" title="View Receipt">View Receipt</a></td>
            </tr>
        {/foreach}
        <tr class="trans-receipts-row">
            <td class="trans-col" colspan="10">
                <div id="trans-receipts" class="trans-receipts">
                    <table class="receipt_item">
                        <tr>
                            <td id="data-4" class="title" colspan="2">
                                Prado Cafe
                            </td>
                        </tr>
                        <tr>
                            <td class="title" colspan="2">
                                e.g. (1931 Commercial Dr Vancouver V5N 4A8 604 255 5527)
                            </td>
                        </tr>
                        <tr>
                            <td id="data-3" class="right">
                                9:53 am
                            </td>
                            <td id="data-1" class="left">
                                01-12-11
                            </td>
                        </tr>
                        <tr>
                            <td class="blank" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Transaction #</td>
                            <td id="data-2" class='align-right'>PPA #</td>
                        </tr>
                        <tr>
                            <td>Paid with:</td>
                            <td id="data-8" class='align-right'>N/A</td>
                        </tr>
                        <tr>
                            <td>ACCT:</td>
                            <td id="" class='align-right'>
                                e.g. (4517*******9787)
                            </td>
                        </tr>
                        <tr>
                            <td>Confirmation:</td>
                            <td class="right">
                                e.g. (896889)
                            </td>
                        </tr>
                        <tr>
                            <td>Location status:</td>
                            <td class='align-right'>e.g. (verified)</td>
                        </tr>
                        <tr>
                            <td>Paid:</td>
                            <td id="data-6" class='align-right'>
                                <span class='cancelled'>Cancelled</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="blank" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td>Americano 8oz</td>
                            <td class="right">
                                e.g. $(2.10)
                            </td>
                        </tr>
                        <tr>
                            <td>Cream Muffin</td>
                            <td class="right">
                                e.g. $(2.25)
                            </td>
                        </tr>
                        <tr>
                            <td class="blank" colspan="2">&nbsp;</td>
                        </tr>
			{if false}
                        <tr>
                            <td class="right">Sub Total</td>
                            <td class="right">e.g. $(4.35)</td>
                        </tr>
                        <tr>
                            <td class="right">HST 12%</td>
                            <td class="right">e.g. $(0.53)</td>
                        </tr>
			{/if}
                        <tr>
                            <td>&nbsp;</td>
                            <td class='align-right'></td>
                        </tr>
                        <tr style="font-weight: bold">
                            <td class="right">
                                <strong>Total</strong>
                            </td>
                            <td id="data-7" class="right">
                                <strong>$0.00</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="recann">
                                <span class="add_annotation ann_rec"
                                      title="Add Annotation">
                                    Add Annotation
                                </span>
                            </td>
                            <td id="data-5" class="recann">
                                {$t.transaction_user_note}
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
    <!--<div class="button_below">
    <span class="custom_button">
        <span>
            <a href="javascript:window.print();">Print</a>&nbsp;|&nbsp;
{if false}
            <a href="{$uri_string}#">Save</a>&nbsp;|&nbsp;
                    <a href="{$uri_string}#">Export</a>
{/if}
        </span>
    </span>
    </div>-->
    <div class="clear"></div>
    <div id="annotation_field">
        <input type="text" value="" />
    </div>
<div id="annotation_field">
    <input type="text" value="" />
</div>
