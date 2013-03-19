    <h2>Beanstream Profile Transaction Demo</h2> 
    
{if $accounts}
    <script>
    function set_form(account_name, account_id, trnAmount, trnOrderNumber)
    {
    document.transaction.trnCustName.value=account_name; 
    document.transaction.customerCode.value=account_id;
    document.transaction.trnAmount.value=trnAmount;
    document.transaction.trnOrderNumber.value=trnOrderNumber; 
    }
    </script>
    {foreach from=$accounts item=account}
    <a href="#" onclick="set_form(
    '{$account.account_firstname|default:''} {$account.account_lastname|default:''}',
    '{$account.account_id|default:''}',
    '{$account.trnAmount|default:rand(10,99)/100}',
    '{$account.trnOrderNumber|default:rand(99,10000)}');
    return false;">{$account.account_name}</a><br>
    {/foreach}
    <a href="#" onclick="set_form('','','','');return false;">Clear Fields</a>
<br>    <br>    
{/if}    

		<form action='{$smarty.server.PHP_SELF}' method='post' name="transaction"> 

			    <table border="0">
							<tr>
								<td>Name:</td>
								<td><input size="20" maxlength="64" name="trnCustName" id="trnCustName" onchange="" tabindex="2" type="textbox" value="{$smarty.post.trnCustName|default:''|escape}"></td>
								<td rowspan="12" width="10"></td>
							</tr><tr>
								<td>Account ID:</td>
								<td><input size="20" name="customerCode" id="customerCode" tabindex="3" type="textbox" value="{$smarty.post.customerCode|default:''|escape}"></td>
							</tr><tr>
								<td>Sale Amount:</td>
								<td><input size="20" maxlength="13" name="trnAmount" id="trnAmount" tabindex="9" type="textbox" value="{$smarty.post.trnAmount|default:''|escape}"></td>
							</tr><tr>
								<td>Order Number:</td>
								<td><input size="20" maxlength="30" name="trnOrderNumber" id="trnOrderNumber" onblur="" tabindex="10" type="textbox" value="{$smarty.post.trnOrderNumber|default:''|escape}"></td>
							</tr><tr>
								<td rowspan="" valign="top">Response:</td>
						 		<td rowspan="">
									<textarea name="rspVerbiage" id="rspVerbiage" style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" cols="24" rows="5" readonly="readonly">{$response.messageText|default:''} {$response.errorMessage|default:''}</textarea>

								</td>
							</tr><tr>
								<td>CVD Result</td><td><input style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" size="20" maxlength="8" name="rspCvdResult" id="rspCvdResult" readonly="readonly" type="textbox" value="{$msg.cvd[$response.cvdId]|default:''|escape}"></td>
								
								<td></td>
								
							</tr><tr>
								<td>AVS Result</td>
								
								<td><input style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" size="24" maxlength="8" name="rspAvsCav" id="rspAvsCav" readonly="readonly" type="textbox" value="{$msg.avs[$response.avsId]|default:''|escape}"></td></tr>
							<tr height="8">
								<td colspan="5"></td>
							</tr>
			</table>
			<input type='submit' class='button' value='Push Request' /> 
		</form> 
