<link rel="stylesheet" type="text/css" href="{$config.base_url}css/summary.css" />
{if true}
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/account.css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/receipt.css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/jquery.jqplot.css" />
{/if}
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_overview">

<!--[if IE]><script type="text/javascript" src="{$config.base_url}js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="{$config.base_url}js/jquery.jqplot.js"></script>
<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.barRenderer.js"></script>
<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.canvasAxisTickRenderer.js"></script>
<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.pieRenderer.js"></script>
<!--<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.highlighter.min.js"></script>-->
<!--<script type="text/javascript" src="{$config.base_url}js/plugins/jqplot.cursor.min.js"></script>-->

<script type="text/javascript" src="{$config.base_url}js/summary.js"></script>
<script type="text/javascript" src="{$config.base_url}js/util.js"></script>

<h1>Overview</h1>

<!-- <table>
{if $user_info}
<tr><td>
{$user_info.user_firstname}
<td></tr>
{/if}
{if $address_info}
<tr><td>
{$address_info.address_city}/{$address_info.address_country}
</td></tr>
{/if}
</table> -->

<div id="summaryPieChart">
	<h2>SPENDING</h2>
	<img src="images/piechart_new.png" alt="Pie Chart">
</div>

<!--
<div id="summaryPieChart">
	<h2>SPENDING</h2>
	{if $summary_timeofday || $summary_account || $summary_merchant}
	<table id="summaryChartTab" class="summary_chart_header" border="0" cellspacing="0" cellpadding="0" align="center"
		style="margin-bottom: 0; background-color: #CCD5D9; margin-left: auto; margin-right: auto; width: 100%; padding: 0px">
	        <tr>
			<td colspan="4">
			<div align="center"
				style="margin-left: auto; margin-right: auto; margin-top: 0; border: 0; padding: 0"
				id="tabs" class="popup_details tabsJ">
			<ul>
				<li><a href="#" id="timeTab" class="current"><span>By Time-of-Day</span></a></li>
				<li><a href="#" id="accountTab" class="normal"><span>By Account</span></a></li>
				<li><a href="#" id="merchantTab" class="normal"><span>By Merchant</span></a></li>
			</ul>
			</div>
			</td>
		</tr>
	</table>
	
	<table id="timeTabTable" class="summary_chart_table" border="0" cellspacing="0" cellpadding="0" align="center">
		<tr>
			<td>
			
			{literal}
			<script language="javascript">
			$j.jqplot.config.enablePlugins = true;
			var timedata = new Array();
			{/literal}
			{foreach from=$summary_timeofday item=it name=sm}
			    var elem = new Array();
			    elem[0] = '{$it.timeofday}';
			    elem[1] = {$it.amount};
			    {literal}
			    timedata.push(elem);
			    {/literal}
			{/foreach}
			
			{literal}
			</script>
			{/literal}
			
			<table id="timeTabChartPieTable">
			<tr><td>
			<div id="timeChartdiv_pie" style="height:300px;width:250px; "></div>
			{literal}
			<script language="javascript">
			var time_pie_option = {
			   title: 'Pie Chart by time of day',
			   seriesColors: ["#40af49", "#ff0099", "#fef200", "#00adef", "#23408e", "#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12"],
			   grid: {
			        drawBorder: false, 
			        drawGridlines: false,
			        background: '#ffffff',
			        shadow:false
			    },
			    axesDefaults: {
			
			    },
			    seriesDefaults:{
			        renderer:$j.jqplot.PieRenderer,
			        rendererOptions: {
			            showDataLabels: true
			        }
			    },
			    legend: {
			        show: true,
			        rendererOptions: {
			            numberRows: 1
			        },
			        location: 's'
			    }
			
			};
			var time_pie = $j.jqplot('timeChartdiv_pie', [timedata], time_pie_option);
			</script>
			{/literal}
			</td></tr>
			</table>
			
			<table id="timeTabChartBarTable">
			<tr><td>
			<div id="timeChartdiv_bar" style="height:300px;width:250px; "></div>
			
			{literal}
			<script language="javascript">
			var plot1b = $j.jqplot('timeChartdiv_bar', [timedata], {
			  title: 'Bar Chart by time of day',
			  series:[{renderer:$j.jqplot.BarRenderer}],
			  axesDefaults: {
			      tickRenderer: $j.jqplot.CanvasAxisTickRenderer ,
			      tickOptions: {
			        enableFontSupport: true,
			        fontFamily: 'Georgia',
			        fontSize: '10pt',
			        angle: -30
			      }
			  },
			  axes: {
			    xaxis: {
			      renderer: $j.jqplot.CategoryAxisRenderer
			    },
			    yaxis: {
			      autoscale:true
			    }
			  }
			});
			</script>
			{/literal}
			</td></tr>
			</table>
			
			
			</td>
		</tr>
	</table>
	
	<table id="accountTabTable" class="summary_chart_table" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td>
	{literal}
	<script language="javascript">
	$j.jqplot.config.enablePlugins = true;
	var accountdata = new Array();
	{/literal}
	{foreach from=$summary_account item=it name=sm}
	    var elem = new Array();
	    elem[0] = '{$it.account_name}';
	    elem[1] = {$it.amount};
	    {literal}
	    accountdata.push(elem);
	    {/literal}
	{/foreach}
	{literal}
	</script>
	{/literal}
	
	<table id="accountTabChartPieTable">
	<tr><td>
	<div id="accountChartdiv_pie" style="height:300px;width:250px; "></div>
	{literal}
	<script language="javascript">
	var account_pie_option = {
	   title: 'Pie Chart by account',
	   seriesColors: ["#40af49", "#ff0099", "#fef200", "#00adef", "#23408e", "#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12"],
	   grid: {
	        drawBorder: false, 
	        drawGridlines: false,
	        background: '#ffffff',
	        shadow:false
	    },
	    axesDefaults: {
	
	    },
	    seriesDefaults:{
	        renderer:$j.jqplot.PieRenderer,
	        rendererOptions: {
	            showDataLabels: true
	        }
	    },
	    legend: {
	        show: true,
	        rendererOptions: {
	            numberRows: 1
	        },
	        location: 's'
	    }
	
	};
	var account_pie = $j.jqplot('accountChartdiv_pie', [accountdata], account_pie_option);
	</script>
	{/literal}
	</td></tr>
	</table>
	
	<table id="accountTabChartBarTable">
	<tr><td>
	<div id="accountChartdiv_bar" style="height:300px;width:250px; "></div>
	{literal}
	<script language="javascript">
	var plot1b = $j.jqplot('accountChartdiv_bar', [accountdata], {
	  title: 'Bar Chart by account',
	  series:[{renderer:$j.jqplot.BarRenderer}],
	  axesDefaults: {
	      tickRenderer: $j.jqplot.CanvasAxisTickRenderer ,
	      tickOptions: {
	        enableFontSupport: true,
	        fontFamily: 'Georgia',
	        fontSize: '10pt',
	        angle: -30
	      }
	  },
	  axes: {
	    xaxis: {
	      renderer: $j.jqplot.CategoryAxisRenderer
	    },
	    yaxis: {
	      autoscale:true
	    }
	  }
	});
	</script>
	{/literal}
	</td></tr>
	</table>
	
	
	</td>
	</tr>
	</table>
	
	<table id="merchantTabTable" class="summary_chart_table" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td>
	{literal}
	<script language="javascript">
	$j.jqplot.config.enablePlugins = true;
	var merchantdata = new Array();
	{/literal}
	{foreach from=$summary_merchant item=it name=sm}
	    var elem = new Array();
	    elem[0] = '{$it.merchant_name}';
	    elem[1] = {$it.amount};
	    {literal}
	    merchantdata.push(elem);
	    {/literal}
	{/foreach}
	{literal}
	</script>
	{/literal}
	
	<table id="merchantTabChartPieTable">
	<tr><td>
	
	<div id="merchantTabChartdiv_pie" style="height:300px;width:250px; "></div>
	
	{literal}
	<script language="javascript">
	var merchant_pie_option = {
	 title: 'Pie Chart by merchant',
	   seriesColors: ["#40af49", "#ff0099", "#fef200", "#00adef", "#23408e", "#4bb2c5", "#c5b47f", "#EAA228", "#579575", "#839557", "#958c12"],
	   grid: {
	        drawBorder: false, 
	        drawGridlines: false,
	        background: '#ffffff',
	        shadow:false
	    },
	    axesDefaults: {
	
	    },
	    seriesDefaults:{
	        renderer:$j.jqplot.PieRenderer,
	        rendererOptions: {
	            showDataLabels: true
	        }
	    },
	    legend: {
	        show: true,
	        rendererOptions: {
	            numberRows: 1
	        },
	        location: 's'
	    }
	
	};
	var merchant_pie = $j.jqplot('merchantTabChartdiv_pie', [merchantdata], merchant_pie_option);
	</script>
	{/literal}
	
	</td></tr>
	</table>
	
	
	<table id="merchantTabChartBarTable">
	<tr><td>
	<div id="merchantTabChartdiv_bar" style="height:300px;width:250px; "></div>
	
	{literal}
	<script language="javascript">
	var plot1b = $j.jqplot('merchantTabChartdiv_bar', [merchantdata], {
	  title: 'Bar Chart by merchant',
	  series:[{renderer:$j.jqplot.BarRenderer}],
	  axesDefaults: {
	      tickRenderer: $j.jqplot.CanvasAxisTickRenderer ,
	      tickOptions: {
	        enableFontSupport: true,
	        fontFamily: 'Georgia',
	        fontSize: '10pt',
	        angle: -30
	      }
	  },
	  axes: {
	    xaxis: {
	      renderer: $j.jqplot.CategoryAxisRenderer
	    },
	    yaxis: {
	      autoscale:true
	    }
	  }
	});
	</script>
	{/literal}
	
	
	</td></tr>
	</table>
	
	<td>
	</tr>
	</table>
	
	<table id="summaryButtonTable" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td>
	<input id="summaryButtonPie" type="button" value="PIE">
	<input id="summaryButtonBar" type="button" value="BAR">
	</td>
	</tr>
	</table>
	{else}
	    No transaction happened within past 30 days.
	{/if}
</div>
-->

<div id="summaryAccountTable">
	<h2>ACCOUNTS</h2>
	<div id="trans_wrap">
		<table id="accounts_list" class="resizable">
	        <tr>
	            <th class="nick sort">
	                Account <a href="{$uri_string}#"><img src="images/arrow_sort.png" alt="" /></a>
	            </th>
	            <th class="activity">Last activity</th>
	            <th class="amount">Amount</th>
	            <th class="funds">Avail. funds</th>
	            <th class="status">Status</th>
	            <th class="flag"><img src="images/flag_white.png" alt="" /></th>
	            <th class="view">&nbsp;</th>
	        </tr>
	
	        {if !empty($accounts)}
	            {foreach from=$accounts item=account}
	                <tr>
	                    <td class="bold">{$account.account_name}</td>
	                    <td>--- -- ----</td>
	                    <td>$-.--</td>
	                    <td>$-.--</td>
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
	        <tr class="disabled">
	            <td colspan="10">&nbsp;</td>
	        </tr>
	        <tr>
	            <td><input type="checkbox" name="account" value="1" disabled /></td>
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
	    </table>
	</div>
</div>

<div id="summaryTransactionTable">
	<h2>RECEIPTS</h2>
	{if $transactions}
	<div id="trans_wrap">
	<table id="transaction_list" class="resizable">
        <tr>
            <th class="date{if $column == $smarty.const.TRANSACTION_ORDERBY_DATE} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_DATE}/5/{$descend}">
                Date
                {if $column == $smarty.const.TRANSACTION_ORDERBY_DATE}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="trans{if $column == $smarty.const.TRANSACTION_ORDERBY_ID} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_ID}/5/{$descend}">
                Trans #
                {if $column == $smarty.const.TRANSACTION_ORDERBY_ID}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="time{if $column == $smarty.const.TRANSACTION_ORDERBY_TIME} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_TIME}/5/{$descend}">
                Time
                {if $column == $smarty.const.TRANSACTION_ORDERBY_TIME}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="merch{if $column == $smarty.const.TRANSACTION_ORDERBY_MERCHANT} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_MERCHANT}/5/{$descend}">
                Merchant
                {if $column == $smarty.const.TRANSACTION_ORDERBY_MERCHANT}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="ann{if $column == $smarty.const.TRANSACTION_ORDERBY_NOTE} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_NOTE}/5/{$descend}">
                Annotation
                {if $column == $smarty.const.TRANSACTION_ORDERBY_NOTE}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="status{if $column == $smarty.const.TRANSACTION_ORDERBY_STATUS} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_STATUS}/5/{$descend}">
                Status
                {if $column == $smarty.const.TRANSACTION_ORDERBY_STATUS}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="amount{if $column == $smarty.const.TRANSACTION_ORDERBY_AMOUNT} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_AMOUNT}/5/{$descend}">
                Amount
                {if $column == $smarty.const.TRANSACTION_ORDERBY_AMOUNT}
                <img src="images/arrow_sort.png" alt="" />
                {/if}
                </a>
            </th>
            <th class="account{if $column == $smarty.const.TRANSACTION_ORDERBY_ACCOUNT} sort{/if}">
                <a href="{$site_url}/transaction/index/{$smarty.const.TRANSACTION_ORDERBY_ACCOUNT}/5/{$descend}">
                Account
                {if $column == $smarty.const.TRANSACTION_ORDERBY_ACCOUNT}
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
                    <input type="checkbox" value="1" checked />
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
            </td>
            <td><a class="view_rec" href="{$uri_string}#" title="View Receipt">View Receipt</a></td>
        </tr>
        {/foreach}
	</div>
	{else}
	    You currently have no receipts.
	{/if}
	</td>
	</tr>
	</table>
	
	</td>
	</tr>
	</table>
	</div>
</div>