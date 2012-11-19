<link rel="stylesheet"
      href="{$config.base_url}css/receipt.css" type="text/css" />
<script src="{$config.base_url}js/receipt.js"
        type="text/javascript"></script>
<script src="{$config.base_url}js/print-receipt.js" type="text/javascript"></script>
<script src="{$config.base_url}js/merch-receipt.js" type="text/javascript"></script>
<script src="{$config.base_url}js/supersleight.plugin.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_transaction">

{if $transactions}
    <div id="trans_wrap">
    	<div id="header-left">
    		<h1>Receipts</h1>
    	</div>
    	<div id="header-right">
    		<div class="custom_report">
            <a class="custom_button" href="{$site_url}/transaction/#">
	            <span>
	                Custom Report&nbsp;
	                <img src="images/icon_plus.png" height="11" width="11" alt="" />
	            </span>
	            </a>
	            <span class="custom_button"><span>
	            <a href="{$site_url}/transaction/#">Print</a>&nbsp;|&nbsp;
	            <a href="{$site_url}/transaction/#">Save</a>&nbsp;|&nbsp;
	            <a href="{$site_url}/transaction/#">Export</a>
	            </span>
	            </span>
	        </div>
    	</div>
        <table id="transaction_list" class="resizable">
            <tr>
                <th class="date{if $column == $smarty.const.TRANSACTION_ORDERBY_DATE} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_DATE}/5/{$descend}">
                    <span class="tablehead">Date{if $column == $smarty.const.TRANSACTION_ORDERBY_DATE}</span><img src="images/arrow_down.png" class="arrow-down" alt="" />{/if}
                    </a>
                </th>
                <th class="trans{if $column == $smarty.const.TRANSACTION_ORDERBY_ID} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_ID}/5/{$descend}">
                    Trans #{if $column == $smarty.const.TRANSACTION_ORDERBY_ID}<img src="images/arrow_sort.png" alt="" />{/if}
                    </a>
                </th>
                <th class="time{if $column == $smarty.const.TRANSACTION_ORDERBY_TIME} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_TIME}/5/{$descend}">
                    Time{if $column == $smarty.const.TRANSACTION_ORDERBY_TIME}
                    <img src="images/arrow_sort.png" alt="" />
                    {/if}
                    </a>
                </th>
                <th class="merch{if $column == $smarty.const.TRANSACTION_ORDERBY_MERCHANT} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_MERCHANT}/5/{$descend}">
                    Merchant{if $column == $smarty.const.TRANSACTION_ORDERBY_MERCHANT}
                    <img src="images/arrow_sort.png" alt="" />
                    {/if}
                    </a>
                </th>
                <th class="ann{if $column == $smarty.const.TRANSACTION_ORDERBY_NOTE} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_NOTE}/5/{$descend}">
                    Annotation{if $column == $smarty.const.TRANSACTION_ORDERBY_NOTE}
                    <img src="images/arrow_sort.png" alt="" />
                    {/if}
                    </a>
                </th>
                <th class="status{if $column == $smarty.const.TRANSACTION_ORDERBY_STATUS} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_STATUS}/5/{$descend}">
                    Status{if $column == $smarty.const.TRANSACTION_ORDERBY_STATUS}
                    <img src="images/arrow_sort.png" alt="" />
                    {/if}
                    </a>
                </th>
                <th class="amount{if $column == $smarty.const.TRANSACTION_ORDERBY_AMOUNT} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_AMOUNT}/5/{$descend}">
                    Amount{if $column == $smarty.const.TRANSACTION_ORDERBY_AMOUNT}<img src="images/arrow_sort.png" alt="" />{/if}
                    </a>
                </th>
                <th class="account{if $column == $smarty.const.TRANSACTION_ORDERBY_ACCOUNT} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_ACCOUNT}/5/{$descend}">
                    Account{if $column == $smarty.const.TRANSACTION_ORDERBY_ACCOUNT}
                    <img src="images/arrow_sort.png" alt="" />
                    {/if}
                    </a>
                </th>
                <th class="flag{if $column == $smarty.const.TRANSACTION_ORDERBY_FLAG} sort{/if}">
                    <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_FLAG}/5/{$descend}">
                    <img id="flag-img" src="images/flag_white.png" alt="" />
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
                <td><span class="data-2">{$t.transaction_id}</span></td>
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
                    <input type="hidden" name="flag" class="data-flag data-16" value="{$t.transaction_flagged}">
                    <input type="hidden" name="transId" value="{$t.transaction_id}">
                    <input type="hidden" name="merchant_address" class="data-9" value="{$t.merchant_street|default:'n/a'}, {$t.merchant_city|default:'n/a'}">
                    <input type="hidden" name="transaction_account" class="data-10" value="{$t.account_number|default:'n/a'}">
                    <input type="hidden" name="transaction_paid" class="data-11" value="{$t.transaction_paid|default:'n/a'}">
                    <input type="hidden" name="transaction_location" class="data-12" value="{if $t.transaction_location}Verified{else}Failed{/if}">
                    <input type="hidden" name="transaction_subtotal" class="data-13" value="${$t.transaction_subtotal|default:'n/a'}">
                    <input type="hidden" name="transaction_tax" class="data-14" value="${$t.transaction_tax|default:'n/a'}">
                    <input type="hidden" name="transaction_tips" class="data-15" value="${$t.transaction_tips|default:'n/a'}">
                </td>
                <td><a class="view_rec" href="{$site_url}/transaction/#" title="View Receipt">View Receipt</a></td>
            </tr>
            {/foreach}
            <tr id="trans-receipts-row" class="trans-receipts-row even">
                <td class="trans-col" colspan="10">
                    <div id="trans-receipts" class="trans-receipts">
                    	<div class='receiptDetail' style="background: #ffffff; padding: 2% 2% 0; font-size: 1; font-weight: normal; color: #666; width: 250px; border: 1px solid gray; overflow: auto;">       
					        <div id="receiptText" class="receiptText">
								<header style="text-align: center; margin-bottom: 25px; font-size: 110%;">
									<span id="data-4" class="receipt-vendor" style="font-size: 120%; font-family: 'courier new', courier, monospace; margin: 12px 0;"></span>
									<address>
										<span id="data-9" style="font-family: 'courier new', courier, monospace;"></span>
									</address>
									<div id="data-1" style="font-family: 'courier new', courier, monospace;"></div>
									<div id="data-3" style="font-family: 'courier new', courier, monospace;"></div>
								</header>
								
								{if $t.transaction_flagged}
								<div class="receipt-flag" id="data-flag data-16" style="width: 16px; height: 13px; position: absolute; top: 10px; right: 20px; background-image: url('../images/icon_trans_flag.gif');">
					            </div>
					            {/if}
								
								<dl class="receipt-meta" style="overflow: hidden; font-family: 'courier new', courier, monospace; font-size: 90%; margin: 0 12px 15px;">
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Transaction #:</dt>
									<dd id="data-2" style="display: block; overflow: hidden; float: right;"></dd>
									<div class="clear"></div>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Paid with:</dt> 
									<dd id="data-8" style="display: block; overflow: hidden; float: right;"></dd>   
									<div class="clear"></div>   
									<dt style="display: block; overflow: hidden; float: left; clear: left;">ACCT:</dt>
									<dd id="data-10" style="display: block; overflow: hidden; float: right;"></dd>
									<div class="clear"></div>
									<!--<dt>Confirmation:</dt>
									<dd id="data-11"></dd>-->
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Location Status:</dt>
									<dd id="data-12" style="display: block; overflow: hidden; float: right;"></dd>
									<div class="clear"></div>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Payment Status:</dt>
									<dd id="data-6" style="display: block; overflow: hidden; float: right;"></dd>
									<div class="clear"></div>
								</dl>
					        
					        <dl class="receipt-items" style="margin: 0 12px 15px; overflow: hidden; font-size: 50%">
					        	
					        	<dt style="display: block; overflow: hidden; float: left; clear: left;"></dt>
					        	<dd style="display: block; overflow: hidden; float: right;"></dd>
					        	
					        </dl>
								
								<dl class="receipt-cost" style="margin: 0 12px 15px; overflow: hidden; font-family: 'courier new', courier, monospace; font-size: 90%;">
									{if false}
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Sub Total</dt>
									<dd id="data-13" style="display: block; overflow: hidden; float: right;"></dd>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">HST 12%</dt>
									<dd id="data-14" style="display: block; overflow: hidden; float: right;"></dd>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Tips</dt>
									<dd id="data-15" style="display: block; overflow: hidden; float: right;"></dd>
									{/if}
									<dt class="receipt-total" style="display: block; overflow: hidden; float: left; clear: left;">Total</dt>
									<dd class="receipt-total" style="display: block; overflow: hidden; float: right;"><span id="data-7"></span></dd>
								</dl>
							</div>
							<div class="clear"></div>
							<dl>
                                <dt class="recann" style="display: block; overflow: hidden; float: left; clear: left;">
                                    <span class="add_annotation ann_rec"
                                          title="Add Annotation">
                                        Add Annotation
                                    </span>
                                </dt>
                                <dt id="data-5" class="recann" style="display: block; overflow: hidden; float: left; clear: left;"></dt>
                            </dl>
					
					        <!--<textarea id="annotation"></textarea>
					        <button class="noteButton" id="saveAnnotation">Save</button>-->
					    </div>
					    
					    <!--<a href="{$config.base_url}merchant/transaction/recent#trans-receipts-row" id="open-link" onclick="javascript:void(openContent('receiptText'))">Click to open receipt</a>-->
                        <!--<table class="receipt_item" border="0">
                            <tr>
                                <td id="data-4" class="title" colspan="2"></td>
                            </tr>
                            <tr>
                                <td id="data-9" colspan="2"></td>
                            </tr>
                            <tr>
                                <td id="data-3" class="right"></td>
                                <td id="data-1" class="left"></td>
                            </tr>
                            <tr>
                                <td class="blank" colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Trans&nbsp;#</td>
                                <td id="data-2" class='align-right'></td>
                            </tr>
                            <tr>
                                <td>Paid with:</td>
                                <td id="data-8" class='align-right'></td>
                            </tr>
                            <tr>
                                <td>ACCT:</td>
                                <td id="data-10" class='align-right'></td>
                            </tr>
                        {if false}
                            <tr>
                                <td>Confirmation:</td>
                                <td id="data-11" class="right"></td>
                            </tr>
                        {/if}
                            <tr>
                                <td>Location status:</td>
                                <td id="data-12" class='align-right'></td>
                            </tr>
                            <tr>
                                <td>Paid:</td>
                                <td id="data-6" class='align-right'>
                                    <span class='cancelled'></span>
                                </td>
                            </tr>
                            <tr>
                                <td class="blank" colspan="2">&nbsp;</td>
                            </tr>
                            {if false}
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
                            {/if}
                            <tr>
                                <td class="right">Sub Total</td>
                                <td id="data-13" class="right"></td>
                            </tr>
                            <tr>
                                <td class="right">HST 12%</td>
                                <td id="data-14" class="right"></td>
                            </tr>
                            <tr>
                                <td class="right">Tips</td>
                                <td id="data-15" class="right"></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td class='align-right'></td>
                            </tr>
                            <tr style="font-weight: bold">
                                <td class="right">
                                    <strong>Total</strong>
                                </td>
                                <td id="data-7" class="right">
                                    <strong></strong>
                                </td>
                            </tr>
                            <tr>
                                <td class="recann">
                                    <span class="add_annotation ann_rec"
                                          title="Add Annotation">
                                        Add Annotation
                                    </span>
                                </td>
                                <td id="data-5" class="recann"></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>-->
                    </div>
                </td>
            </tr>
            <!--<tr>
                <td class="end" colspan="10">
                    <span class="custom_button custom_button_blue">
                        <span>
                            <a href="{$uri_string}#">Print</a>&nbsp;|&nbsp;
                            <a href="{$uri_string}#">Save</a>&nbsp;|&nbsp;
                    <a href="{$uri_string}#">Export</a>
                        </span>
                    </span>
                </td>
            </tr>-->
        </table>
    </div>
{else}
    You currently have no receipts.
{/if}