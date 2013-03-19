<?php /* Smarty version Smarty-3.0.6, created on 2012-04-22 20:17:59
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/transaction/merchant.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8446965994f949fb7278ad6-52736599%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f5b25890c22ace4dba1c9d88bdbd5be50dedd08' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/transaction/merchant.tpl',
      1 => 1335139772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8446965994f949fb7278ad6-52736599',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/libraries/smarty/libs/plugins/modifier.escape.php';
?><link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/receipt.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/merchant-receipts.css" type="text/css" />
<!--<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/receipt.js" type="text/javascript"></script>-->
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/print-receipt.js" type="text/javascript"></script>
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/merch-receipt.js" type="text/javascript"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_receiptsmerch">
<style type="text/css" media="print">
	.hide-for-print {
	    display: none;
	}
</style>

<?php if ($_smarty_tpl->getVariable('transactions')->value){?>
    <div id="trans_wrap">
    	<div id="header-left-merch">
    		<h1>Receipts</h1>
    	</div>
    	<div id="header-right">
    		<div class="custom_report">
	            <a class="custom_button" href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">
	            <span>
	                Custom Report&nbsp;
	                <img src="images/icon_plus.png" height="11" width="11" alt="" />
	            </span>
	            </a>
	            <span class="custom_button"><span>
	            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Print</a>&nbsp;|&nbsp;
	            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Save</a>&nbsp;|&nbsp;
	            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Export</a>
	            </span>
	            </span>
	        </div>
    	</div>
        <table id="merchant_table" class="resizable">
            <tr>
            	<th class="amount<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_AMOUNT){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_AMOUNT;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                    Amount<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_AMOUNT){?><img src="images/arrow_sort.png" alt="" /><?php }?>
                    </a>
                </th>
                <th class="date<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_DATE){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_DATE;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                    Date<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_DATE){?><img src="images/arrow_sort.png" alt="" /><?php }?>
                    </a>
                </th>
                <th class="time<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_TIME){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_TIME;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                    Time<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_TIME){?>
                    <img src="images/arrow_sort.png" alt="" />
                    <?php }?>
                    </a>
                </th>
                <th class="merch<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_USER){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_USER;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                    User<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_USER){?>
                    <img src="images/arrow_sort.png" alt="" />
                    <?php }?>
                    </a>
                </th>
                <th class="trans<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_ID){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_ID;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                    Trans #<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_ID){?><img src="images/arrow_sort.png" alt="" /><?php }?>
                    </a>
                </th>
                <th class="status<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_STATUS){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_STATUS;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                    Status<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_STATUS){?>
                    <img src="images/arrow_sort.png" alt="" />
                    <?php }?>
                    </a>
                </th>
                <th class="flag<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_FLAG){?> sort<?php }?>">
                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/transaction/recent/<?php echo @TRANSACTION_ORDERBY_FLAG;?>
/100/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
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
                    <span class="data-7">$<?php echo number_format($_smarty_tpl->tpl_vars['t']->value['transaction_amount'],2,".",",");?>
</span>
                </td>
                <td>
                    <span class="data-1"><?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_date_paid'];?>
</span>
                </td>
                <td><span class="data-3"><?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_time_paid'];?>
</span></td>
                <td class="bold">
                    <span class="data-4">User #<?php echo $_smarty_tpl->tpl_vars['t']->value['tr_user_id'];?>
</span>
                </td>
                <td><span class="data-2"><?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_id'];?>
</span></td>
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
                    <?php if ($_smarty_tpl->tpl_vars['t']->value['transaction_flagged']){?>
                    <img src="images/icon_trans_flag.gif" alt="" />
                    <?php }?>
                    <input type="hidden" name="flag" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['t']->value['transaction_flagged']);?>
">
                    <input type="hidden" name="transId" value="<?php echo smarty_modifier_escape($_smarty_tpl->tpl_vars['t']->value['transaction_id']);?>
">
                    <input type="hidden" name="account_name" class="data-8" value="<?php echo smarty_modifier_escape((($tmp = @$_smarty_tpl->tpl_vars['t']->value['account_name'])===null||$tmp==='' ? '' : $tmp));?>
">
                    <input type="hidden" name="merchant_address" class="data-9" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['merchant_street'])===null||$tmp==='' ? 'n/a' : $tmp);?>
, <?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['merchant_city'])===null||$tmp==='' ? 'n/a' : $tmp);?>
">
                    <input type="hidden" name="transaction_account" class="data-10" value="<?php echo smarty_modifier_escape((($tmp = @$_smarty_tpl->tpl_vars['t']->value['account_number'])===null||$tmp==='' ? 'n/a' : $tmp));?>
">
                    <input type="hidden" name="transaction_paid" class="data-11" value="<?php echo smarty_modifier_escape((($tmp = @$_smarty_tpl->tpl_vars['t']->value['transaction_paid'])===null||$tmp==='' ? 'n/a' : $tmp));?>
">
                    <input type="hidden" name="transaction_location" class="data-12" value="<?php if ($_smarty_tpl->tpl_vars['t']->value['transaction_location']){?>Verified<?php }else{ ?>Failed<?php }?>">
                    <input type="hidden" name="transaction_subtotal" class="data-13" value="$<?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['transaction_subtotal'])===null||$tmp==='' ? 'n/a' : $tmp);?>
">
                    <input type="hidden" name="transaction_tax" class="data-14" value="$<?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['transaction_tax'])===null||$tmp==='' ? 'n/a' : $tmp);?>
">
                    <input type="hidden" name="transaction_tips" class="data-15" value="$<?php echo (($tmp = @$_smarty_tpl->tpl_vars['t']->value['transaction_tips'])===null||$tmp==='' ? 'n/a' : $tmp);?>
">
                </td>
                <td><a class="view_rec" href="index.htm" title="View Receipt">View Receipt</a></td>
            </tr>
            <?php }} ?>
            <tr id="trans-receipts-row" class="trans-receipts-row even">
                <td class="trans-col" colspan="10">
                    <div id="trans-receipts" class="trans-receipts">
                    	<div class='receiptDetail' style="background: #ffffff; padding: 2% 2% 0; font-size: 1; font-weight: normal; color: #666; width: 250px; border: 1px solid gray; overflow: auto;">       
					        <div id="receiptText" class="receiptText">
								<header style="text-align: center; margin-bottom: 25px; font-size: 220%;">
									<span class="receipt-vendor" style="font-size: 120%; font-family: 'courier new', courier, monospace;"><?php echo $_smarty_tpl->getVariable('t')->value['merchant_name'];?>
</span>
									<address>
										<span id="data-9" style="font-family: 'courier new', courier, monospace;"></span>
									</address>
									<div id="data-1" style="font-family: 'courier new', courier, monospace;"></div>
									<div id="data-3" style="font-family: 'courier new', courier, monospace;"></div>
								</header>
								
								<dl class="receipt-meta" style="margin-bottom: 15px; overflow: hidden; font-family: 'courier new', courier, monospace; font-size: 180%;">
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Transaction #:</dt>
									<dd id="data-2" style="display: block; overflow: hidden; float: right;"></dd>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Paid with:</dt> 
									<dd id="data-8" style="display: block; overflow: hidden; float: right;"></dd>      
									<dt style="display: block; overflow: hidden; float: left; clear: left;">ACCT:</dt>
									<dd id="data-10" style="display: block; overflow: hidden; float: right;"></dd>
									<!--<dt>Confirmation:</dt>
									<dd id="data-11"></dd>-->
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Location Status:</dt>
									<dd id="data-12" style="display: block; overflow: hidden; float: right;"></dd>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Payment Status:</dt>
									<dd id="data-6" style="display: block; overflow: hidden; float: right;"></dd>
								</dl>
					        
					        <dl class="receipt-items" style="margin-bottom: 15px; overflow: hidden;">
					        	
					        	<dt style="display: block; overflow: hidden; float: left; clear: left;"></dt>
					        	<dd style="display: block; overflow: hidden; float: right;"></dd>
					        	
					        </dl>
								
								<dl class="receipt-cost" style="margin-bottom: 15px; overflow: hidden; font-family: 'courier new', courier, monospace; font-size: 180%;">
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Sub Total</dt>
									<dd id="data-13" style="display: block; overflow: hidden; float: right;"></dd>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">HST 12%</dt>
									<dd id="data-14" style="display: block; overflow: hidden; float: right;"></dd>
									<dt style="display: block; overflow: hidden; float: left; clear: left;">Tips</dt>
									<dd id="data-15" style="display: block; overflow: hidden; float: right;"></dd>
									<dt class="receipt-total" style="display: block; overflow: hidden; float: left; clear: left;">Total</dt>
									<dd class="receipt-total" style="display: block; overflow: hidden; float: right;"><span id="data-7"></span></dd>
								</dl>
								<div class="clear"></div>
								<a href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/transaction/recent#trans-receipts-row" id="print-link" class="hide-for-print" onclick="window.print();" style="color: white; text-decoration: none; background-color: #666666; padding: 8px; -moz-border-radius: 10px; -webkit-border-radius: 10px; border-radius: 10px; font-family: 'courier new', courier, monospace; font-weight: bold;">Click to print receipt</a>
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
					    
					    <!--<a href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
merchant/transaction/recent#trans-receipts-row" id="open-link" onclick="javascript:void(openContent('receiptText'))">Click to open receipt</a>-->
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
                        <?php if (false){?>
                            <tr>
                                <td>Confirmation:</td>
                                <td id="data-11" class="right"></td>
                            </tr>
                        <?php }?>
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
                            <?php if (false){?>
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
                            <?php }?>
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
                            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Print</a>&nbsp;|&nbsp;
                            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Save</a>&nbsp;|&nbsp;
                            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Export</a>
                        </span>
                    </span>
                </td>
            </tr>-->
        </table>
    </div>
<?php }else{ ?>
    You currently have no receipts.
<?php }?>