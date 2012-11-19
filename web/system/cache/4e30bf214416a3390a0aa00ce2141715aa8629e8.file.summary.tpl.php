<?php /* Smarty version Smarty-3.0.6, created on 2012-04-11 12:20:11
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/summary.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16761063884f85af3b967ba1-21044513%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4e30bf214416a3390a0aa00ce2141715aa8629e8' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/summary.tpl',
      1 => 1320956249,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16761063884f85af3b967ba1-21044513',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/summary.css" />
<?php if (true){?>
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/receipt.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/jquery.jqplot.css" />
<?php }?>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_overview">

<!--[if IE]><script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/excanvas.js"></script><![endif]-->
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/jquery.jqplot.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.categoryAxisRenderer.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.barRenderer.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.canvasTextRenderer.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.canvasAxisTickRenderer.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.pieRenderer.js"></script>
<!--<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.highlighter.min.js"></script>-->
<!--<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/plugins/jqplot.cursor.min.js"></script>-->

<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/summary.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/util.js"></script>

<h1>Overview</h1>

<!-- <table>
<?php if ($_smarty_tpl->getVariable('user_info')->value){?>
<tr><td>
<?php echo $_smarty_tpl->getVariable('user_info')->value['user_firstname'];?>

<td></tr>
<?php }?>
<?php if ($_smarty_tpl->getVariable('address_info')->value){?>
<tr><td>
<?php echo $_smarty_tpl->getVariable('address_info')->value['address_city'];?>
/<?php echo $_smarty_tpl->getVariable('address_info')->value['address_country'];?>

</td></tr>
<?php }?>
</table> -->

<div id="summaryPieChart">
	<h2>SPENDING</h2>
	<img src="images/piechart_new.png" alt="Pie Chart">
</div>

<!--
<div id="summaryPieChart">
	<h2>SPENDING</h2>
	<?php if ($_smarty_tpl->getVariable('summary_timeofday')->value||$_smarty_tpl->getVariable('summary_account')->value||$_smarty_tpl->getVariable('summary_merchant')->value){?>
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
			
			
			<script language="javascript">
			$j.jqplot.config.enablePlugins = true;
			var timedata = new Array();
			
			<?php  $_smarty_tpl->tpl_vars['it'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('summary_timeofday')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['it']->key => $_smarty_tpl->tpl_vars['it']->value){
?>
			    var elem = new Array();
			    elem[0] = '<?php echo $_smarty_tpl->tpl_vars['it']->value['timeofday'];?>
';
			    elem[1] = <?php echo $_smarty_tpl->tpl_vars['it']->value['amount'];?>
;
			    
			    timedata.push(elem);
			    
			<?php }} ?>
			
			
			</script>
			
			
			<table id="timeTabChartPieTable">
			<tr><td>
			<div id="timeChartdiv_pie" style="height:300px;width:250px; "></div>
			
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
			
			</td></tr>
			</table>
			
			<table id="timeTabChartBarTable">
			<tr><td>
			<div id="timeChartdiv_bar" style="height:300px;width:250px; "></div>
			
			
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
			
			</td></tr>
			</table>
			
			
			</td>
		</tr>
	</table>
	
	<table id="accountTabTable" class="summary_chart_table" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td>
	
	<script language="javascript">
	$j.jqplot.config.enablePlugins = true;
	var accountdata = new Array();
	
	<?php  $_smarty_tpl->tpl_vars['it'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('summary_account')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['it']->key => $_smarty_tpl->tpl_vars['it']->value){
?>
	    var elem = new Array();
	    elem[0] = '<?php echo $_smarty_tpl->tpl_vars['it']->value['account_name'];?>
';
	    elem[1] = <?php echo $_smarty_tpl->tpl_vars['it']->value['amount'];?>
;
	    
	    accountdata.push(elem);
	    
	<?php }} ?>
	
	</script>
	
	
	<table id="accountTabChartPieTable">
	<tr><td>
	<div id="accountChartdiv_pie" style="height:300px;width:250px; "></div>
	
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
	
	</td></tr>
	</table>
	
	<table id="accountTabChartBarTable">
	<tr><td>
	<div id="accountChartdiv_bar" style="height:300px;width:250px; "></div>
	
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
	
	</td></tr>
	</table>
	
	
	</td>
	</tr>
	</table>
	
	<table id="merchantTabTable" class="summary_chart_table" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
	<td>
	
	<script language="javascript">
	$j.jqplot.config.enablePlugins = true;
	var merchantdata = new Array();
	
	<?php  $_smarty_tpl->tpl_vars['it'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('summary_merchant')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['it']->key => $_smarty_tpl->tpl_vars['it']->value){
?>
	    var elem = new Array();
	    elem[0] = '<?php echo $_smarty_tpl->tpl_vars['it']->value['merchant_name'];?>
';
	    elem[1] = <?php echo $_smarty_tpl->tpl_vars['it']->value['amount'];?>
;
	    
	    merchantdata.push(elem);
	    
	<?php }} ?>
	
	</script>
	
	
	<table id="merchantTabChartPieTable">
	<tr><td>
	
	<div id="merchantTabChartdiv_pie" style="height:300px;width:250px; "></div>
	
	
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
	
	
	</td></tr>
	</table>
	
	
	<table id="merchantTabChartBarTable">
	<tr><td>
	<div id="merchantTabChartdiv_bar" style="height:300px;width:250px; "></div>
	
	
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
	<?php }else{ ?>
	    No transaction happened within past 30 days.
	<?php }?>
</div>
-->

<div id="summaryAccountTable">
	<h2>ACCOUNTS</h2>
	<div id="trans_wrap">
		<table id="accounts_list" class="resizable">
	        <tr>
	            <th class="nick sort">
	                Account <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#"><img src="images/arrow_sort.png" alt="" /></a>
	            </th>
	            <th class="activity">Last activity</th>
	            <th class="amount">Amount</th>
	            <th class="funds">Avail. funds</th>
	            <th class="status">Status</th>
	            <th class="flag"><img src="images/flag_white.png" alt="" /></th>
	            <th class="view">&nbsp;</th>
	        </tr>
	
	        <?php if (!empty($_smarty_tpl->getVariable('accounts',null,true,false)->value)){?>
	            <?php  $_smarty_tpl->tpl_vars['account'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('accounts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['account']->key => $_smarty_tpl->tpl_vars['account']->value){
?>
	                <tr>
	                    <td class="bold"><?php echo $_smarty_tpl->tpl_vars['account']->value['account_name'];?>
</td>
	                    <td>--- -- ----</td>
	                    <td>$-.--</td>
	                    <td>$-.--</td>
	                    <td>
	                        <?php if ($_smarty_tpl->tpl_vars['account']->value['account_enabled']){?>
	                            Active
	                        <?php }else{ ?>
	                            Suspended
	                            <!--<a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/enable/<?php echo $_smarty_tpl->tpl_vars['account']->value['account_id'];?>
">
	                                Enable
	                            </a>-->
	                        <?php }?>
	                    </td>
	                    <td>&nbsp;</td>
	                    <td class="view">
	                        <a class="view_rec" href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/info/<?php echo $_smarty_tpl->tpl_vars['account']->value['account_id'];?>
"
	                           title="View Account">
	                            View Account
	                        </a>
	                    </td>
	                </tr>
	            <?php }} ?>
	        <?php }?>
	        <?php if (false){?>
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
	            <td class="view"><a class="view_rec view_rec_disabled" href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#" title="View Receipt">View Receipt</a></td>
	        </tr>
	        <?php }?>
	    </table>
	</div>
</div>

<div id="summaryTransactionTable">
	<h2>RECEIPTS</h2>
	<?php if ($_smarty_tpl->getVariable('transactions')->value){?>
	<div id="trans_wrap">
	<table id="transaction_list" class="resizable">
        <tr>
            <th class="date<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_DATE){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_DATE;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Date
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_DATE){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="trans<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_ID){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_ID;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Trans #
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_ID){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="time<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_TIME){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_TIME;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Time
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_TIME){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="merch<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_MERCHANT){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_MERCHANT;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Merchant
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_MERCHANT){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="ann<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_NOTE){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_NOTE;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Annotation
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_NOTE){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="status<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_STATUS){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_STATUS;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Status
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_STATUS){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="amount<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_AMOUNT){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_AMOUNT;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Amount
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_AMOUNT){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="account<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_ACCOUNT){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_ACCOUNT;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                Account
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_ACCOUNT){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="flag<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_FLAG){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/index/<?php echo @TRANSACTION_ORDERBY_FLAG;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                <img id="flag-img" src="images/flag_white.png" alt="" />
                <?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_FLAG){?>
                <img src="images/arrow_sort.png" alt="" />
                <?php }?>
                </a>
            </th>
            <th class="view">&nbsp;</th>
        </tr>
        <?php  $_smarty_tpl->tpl_vars['t'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('transactions')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['transaction']['iteration']=0;
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['t']->key => $_smarty_tpl->tpl_vars['t']->value){
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['transaction']['iteration']++;
?>
        <tr id="trans-show-<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['transaction']['iteration'];?>
">
            <td>
                    <input type="checkbox" value="1" checked />
                <span class="data-1"><?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_date_paid'];?>
</span>
            </td>
            <td><span class="data-2">PPA <?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_id'];?>
</span></td>
            <td><span class="data-3"><?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_time_paid'];?>
</span></td>
            <td class="bold">
                <span class="data-4"><?php echo $_smarty_tpl->tpl_vars['t']->value['merchant_name'];?>
</span>
            </td>
            <td class="ann">
                <div class="annw">
                    <span class="data-5"><?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_user_note'];?>
</span>
                    <span id="ann-id-<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['transaction']['iteration'];?>
"
                          class="add_annotation" title="Add Annotation">
                        Add Annotation
                    </span>
                </div>
            </td>
            <td class="bold">
                <span class="data-6">
                    <?php if ($_smarty_tpl->tpl_vars['t']->value['transaction_paid']){?>
                    PAID
                    <?php }elseif($_smarty_tpl->tpl_vars['t']->value['transaction_cancelled']){?>
                    CANCELED
                    <?php }?>
                </span>
            </td>
            <td>
                <span class="data-7">$<?php echo number_format($_smarty_tpl->tpl_vars['t']->value['transaction_amount'],2,".",",");?>
</span>
            </td>
            <td><span class="data-8"><?php echo $_smarty_tpl->tpl_vars['t']->value['account_name'];?>
</span></td>
            <td>
                <?php if ($_smarty_tpl->tpl_vars['t']->value['transaction_flagged']){?>
                <img src="images/icon_trans_flag.gif" alt="" />
                <?php }?>
            </td>
            <td><a class="view_rec" href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#" title="View Receipt">View Receipt</a></td>
        </tr>
        <?php }} ?>
	</div>
	<?php }else{ ?>
	    You currently have no receipts.
	<?php }?>
	</td>
	</tr>
	</table>
	
	</td>
	</tr>
	</table>
	</div>
</div>