<?php /* Smarty version Smarty-3.0.6, created on 2012-04-22 19:52:40
         compiled from "/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/info.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2868168564f9499c85e0c12-26387762%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1c471bc97d219ee4704f020e9b091d13c99be9b' => 
    array (
      0 => '/Users/mine/NetBeansProjects/PPA/FF/web.new/system/application/views/account/info.tpl',
      1 => 1334723258,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2868168564f9499c85e0c12-26387762',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet"
      href="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
css/account-info.css" type="text/css" />
<script src="<?php echo $_smarty_tpl->getVariable('config')->value['base_url'];?>
js/account/account-info.js" type="text/javascript"></script>
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
	               href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/add">
	            <span>
	                <img src="images/icon_plus.png" height="11" width="11"
	                     alt="" />
	                &nbsp;
	                Add Account
	            </span>
	            </a>
	            <span class="custom_button">
	                <span>
			    <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']!=9&&$_smarty_tpl->getVariable('account')->value['accounttype']!=12){?>
	                    <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/edit/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">
	                    Edit
	                    </a>
	                    &nbsp;|&nbsp;
			    <?php }?>
<?php if (false){?>
                    <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Delete</a>
                    &nbsp;|&nbsp;
<?php }?>
                    <?php if ($_smarty_tpl->getVariable('account')->value['account_enabled']){?>
                        <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/suspend/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">Suspend</a>
                    <?php }else{ ?>
                        <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/enable/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
">Activate</a>
                    <?php }?>
	                </span>
	            </span>
	    </div>
	</div>
   
    <div class="account_info">
        <table class="account_info">
            <?php if ($_smarty_tpl->getVariable('account')->value['accounttype']!=10){?>
                <tr>
                    <td class="right">Nickname:</td>
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['nickname'];?>
</td>
                </tr>
                <tr>
                    <td class="right">Status:</td>
                    <td>
                    	<?php if ($_smarty_tpl->getVariable('account')->value['account_enabled']){?>
                            Active
                        <?php }else{ ?>
                            Suspended
                            <!--<a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/enable/<?php echo $_smarty_tpl->getVariable('account')->value['account_id'];?>
">
                                Enable
                            </a>-->
                        <?php }?>
                    </td>
                </tr>
                <tr class="dotted_line">
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr>
                    <td class="right">Type of Account:</td>
                    <td><?php if ($_smarty_tpl->getVariable('account')->value['accounttype']==9){?>Paypal<?php }elseif($_smarty_tpl->getVariable('account')->value['accounttype']==12){?>Gift Card<?php }else{ ?>Credit Card<?php }?></td>
                </tr>
                <tr>
                    <td class="right">Account Number:</td>
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['creditcardnumber'];?>
</td>
                </tr>
                <tr>
                    <td class="right">Expiry:</td>
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['month'];?>
/<?php echo $_smarty_tpl->getVariable('account')->value['year'];?>
</td>
                </tr>
                <tr>
                    <td class="right">Security Number on Card:</td>
                    <td>***</td>
                </tr>
            <?php }elseif($_smarty_tpl->getVariable('account')->value['accounttype']==2){?>
                <tr>
                    <td class="right">Nickname:</td>
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['bankname'];?>
</td>
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
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['banknumber'];?>
</td>
                </tr>
                <tr>
                    <td class="right">Institution Number</td>
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['institution'];?>
</td>
                </tr>
                <tr>
                    <td class="right">Transit Number:</td>
                    <td><?php echo $_smarty_tpl->getVariable('account')->value['transit'];?>
</td>
                </tr>
            <?php }else{ ?>
                Unknown account type
            <?php }?>
            <tr class="dotted_line">
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
    </div>
    <!--<div class="button_above">
    <div class="custom_report">
        <a class="custom_button" href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">
        <span>
            Custom Report&nbsp;
            <img src="images/icon_plus.png" height="11" width="11" alt="" />
        </span>
        </a>
    </div>
    </div>-->
    <table id="transaction_list" class="resizable">
        <tr>
            <th class="date<?php if ($_smarty_tpl->getVariable('column')->value==@TRANSACTION_ORDERBY_DATE){?> sort<?php }?>">
                <a href="<?php echo $_smarty_tpl->getVariable('site_url')->value;?>
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_DATE;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_ID;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_TIME;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_MERCHANT;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_NOTE;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_STATUS;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_AMOUNT;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_ACCOUNT;?>
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
/account/info/<?php echo $_smarty_tpl->getVariable('account')->value['id'];?>
/<?php echo @TRANSACTION_ORDERBY_FLAG;?>
/5/<?php echo $_smarty_tpl->getVariable('descend')->value;?>
">
                <img src="images/flag_white.png" alt="" />
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
                    <input type="hidden" name="flag" value="<?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_flagged'];?>
">
                    <input type="hidden" name="transId" value="<?php echo $_smarty_tpl->tpl_vars['t']->value['transaction_id'];?>
">
                </td>
                <td><a class="view_rec" href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#" title="View Receipt">View Receipt</a></td>
            </tr>
        <?php }} ?>
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
                        <tr>
                            <td class="right">Sub Total</td>
                            <td class="right">e.g. $(4.35)</td>
                        </tr>
                        <tr>
                            <td class="right">HST 12%</td>
                            <td class="right">e.g. $(0.53)</td>
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
                                <?php echo $_smarty_tpl->getVariable('t')->value['transaction_user_note'];?>

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
<?php if (false){?>
            <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Save</a>&nbsp;|&nbsp;
                    <a href="<?php echo $_smarty_tpl->getVariable('uri_string')->value;?>
#">Export</a>
<?php }?>
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
