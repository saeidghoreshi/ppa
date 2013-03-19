    <h2>Beanstream Profile Demo</h2> 
    
{if $accounts}
    <script>
    function set_form(account_name, account_id, address_street, account_number, account_cvv, address_city, address_state, address_zip, user_phone, user_email, user_phone)
    {
    document.transaction.trnCustName.value=account_name; 
    document.transaction.customerCode.value=account_id; 
    document.transaction.trnAVstreet.value=address_street; 
    document.transaction.trnCardNumber.value=account_number; 
    document.transaction.cvv2.value=account_cvv; 
    document.transaction.trnAVCity.value=address_city; 
    document.transaction.trnAVState.value=address_state; 
    document.transaction.trnAVZip.value=address_zip; 
    document.transaction.trnPhoneNumber.value=user_phone; 
    document.transaction.trnEmail.value=user_email; 
    document.transaction.trnOrderNumber.value=user_phone; 
    }
    </script>
    {foreach from=$accounts item=account}
    <a href="#" onclick="set_form(
    '{$account.account_firstname|default:''} {$account.account_lastname|default:''}',
    '{$account.account_id|default:''}',
    '{$account.address_street|default:''}',
    '{$account.account_number|default:''}', 
    '{$account.account_cvv|default:''}',
    '{$account.address_city|default:''}',
    '',
    '{$account.address_zip|default:''}',
    '{$account.user_phone|default:''}',
    '{$account.user_email|default:''}', 
    '{$account.user_phone|default:rand(99,10000)}');
    document.transaction.action='{$site_url}/beanstream/profile/update/{$account.account_id}/'
    return false;">{$account.account_name}</a>
    {if $account.account_enabled eq '0'} - <a href="{$site_url}/beanstream/profile/save/{$account.account_id}/" onclick="
        set_form(
    '{$account.account_firstname|default:''} {$account.account_lastname|default:''}',
    '{$account.account_id|default:''}',
    '{$account.address_street|default:''}',
    '{$account.account_number|default:''}', 
    '{$account.account_cvv|default:''}',
    '{$account.address_city|default:''}',
    '',
    '{$account.address_zip|default:''}',
    '{$account.user_phone|default:''}',
    '{$account.user_email|default:''}', 
    '{$account.user_phone|default:rand(99,10000)}');
    document.transaction.action='{$site_url}/beanstream/profile/save/{$account.account_id}/';return false;">BS save</a>{else}<a href="{$site_url}/beanstream/profile/update/{$account.account_id}/"onclick="
        set_form(
    '{$account.account_firstname|default:''} {$account.account_lastname|default:''}',
    '{$account.account_id|default:''}',
    '{$account.address_street|default:''}',
    '{$account.account_number|default:''}', 
    '{$account.account_cvv|default:''}',
    '{$account.address_city|default:''}',
    '',
    '{$account.address_zip|default:''}',
    '{$account.user_phone|default:''}',
    '{$account.user_email|default:''}', 
    '{$account.user_phone|default:rand(99,10000)}');
    document.transaction.action='{$site_url}/beanstream/profile/update/{$account.account_id}/';return false;">BS update</a> or <a href="{$site_url}/beanstream/profile/delete/{$account.account_id}/"onclick="
        set_form(
    '{$account.account_firstname|default:''} {$account.account_lastname|default:''}',
    '{$account.account_id|default:''}',
    '{$account.address_street|default:''}',
    '{$account.account_number|default:''}', 
    '{$account.account_cvv|default:''}',
    '{$account.address_city|default:''}',
    '',
    '{$account.address_zip|default:''}',
    '{$account.user_phone|default:''}',
    '{$account.user_email|default:''}', 
    '{$account.user_phone|default:rand(99,10000)}');
    document.transaction.action='{$site_url}/beanstream/profile/delete/{$account.account_id}/';return false;">BS disable</a>{/if}<br>
    {/foreach}
    <a href="#" onclick="set_form('','','','','','','','','','','');return false;">Clear Fields</a>
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
								<td>Card Number:</td>
								<td><input size="20" name="trnCardNumber" id="trnCardNumber" onchange="CheckCardNumber(this)" tabindex="3" type="textbox" value="{$smarty.post.trnCardNumber|default:''|escape}"></td>
							</tr><tr>
								<td>Expiration Date:</td>

								<td style="font-size: 10px;">
									<select name="trnExpMonth" id="trnExpMonth" tabindex="4">
										<option value="01">01
										</option><option value="02">02
										</option><option value="03">03
										</option><option value="04">04
										</option><option value="05">05
										</option><option value="06">06
										</option><option value="07">07
										</option><option value="08">08
										</option><option value="09">09
										</option><option value="10">10
										</option><option value="11">11
										</option><option value="12">12
									</option></select>

									<select name="trnExpYear" id="trnExpYear" tabindex="5">
										
											<option value="11">11
											</option><option value="12">12
											</option><option value="13">13
											</option><option value="14">14
											</option><option value="15">15
											</option><option value="16">16
											</option><option value="17">17
											</option><option value="18">18
											</option><option value="19">19
											</option><option value="20">20
											</option><option value="21">21
											</option><option value="22">22
											</option><option value="23">23
									</option></select>

									(MM/YY)
								</td>
							</tr><tr>
								<td>CVV2/CVC2:</td>
								<td>
									<input size="20" maxlength="4" name="cvv2" id="cvv2" tabindex="7" type="textbox" value="{$smarty.post.cvv2|default:''|escape}">
								</td>
							</tr><tr>
								<td>Street Number/Name:</td>
								<td>
									<input size="20" maxlength="64" name="trnAVstreet" id="trnAVstreetNumber" tabindex="15" type="textbox" value="{$smarty.post.trnAVstreet|default:''|escape}">

								</td>								
							</tr><tr>
								<td>City:</td>
								<td><input size="24" maxlength="32" name="trnAVCity" id="trnAVCity" tabindex="17" type="textbox" value="{$smarty.post.trnAVCity|default:''|escape}"></td>
							</tr><tr>
								<td>Province/State:</td>
								<td>
									<select name="trnAVState" id="trnAvState" tabindex="18" style="width: 167px;">
									<option value="--">Outside U.S./Canada</option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AB">Alberta</option><option value="AS">American Samoa</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="AA">Armed Forces Americas</option><option value="AE">Armed Forces Europe</option><option value="AP">Armed Forces Pacific</option><option value="BC" selected="selected">British Columbia</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">District of Columbia</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="GU">Guam</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MB">Manitoba</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NB">New Brunswick</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NL">Newfoundland and Labrador</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="MP">Northern Marianas</option><option value="NT">Northwest Territories</option><option value="NS">Nova Scotia</option><option value="NU">Nunavut</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="ON">Ontario</option><option value="OR">Oregon</option><option value="PW">Palau</option><option value="PA">Pennsylvania</option><option value="PE">Prince Edward Island</option><option value="PR">Puerto Rico</option><option value="QC">Quebec</option><option value="RI">Rhode Island</option><option value="SK">Saskatchewan</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VI">Virgin Islands</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option><option value="YT">Yukon</option>

									</select>
								</td>
							</tr><tr>
								<td>Country:</td>

								<td>
									<select name="trnAVCountry" id="trnAVCountry" tabindex="19" style="width: 167px;">
								<option value="CA">Canada</option>
									</select>
								</td>
							</tr><tr>
								<td>Postal/Zip:</td>
								<td><input size="24" maxlength="16" name="trnAVZip" id="trnAVZip" tabindex="20" type="textbox" value="{$smarty.post.trnAVZip|default:''|escape}"></td>
							</tr><tr>
								<td>Phone:</td>

								<td><input size="24" maxlength="32" name="trnPhoneNumber" id="trnPhoneNumber" tabindex="21" type="textbox" value="{$smarty.post.trnPhoneNumber|default:''|escape}"></td>
							</tr><tr>
								<td>Order Number:</td>
								<td><input size="20" maxlength="30" name="trnOrderNumber" id="trnOrderNumber" onblur="" tabindex="10" type="textbox" value="{$smarty.post.trnOrderNumber|default:''|escape}"></td>
							</tr><tr>
								<td>Email:</td>
								<td><input size="24" maxlength="64" name="trnEmail" id="trnEmail" tabindex="22" type="textbox" value="{$smarty.post.trnEmail|default:''|escape}"></td>							
							</tr><tr>
								<td rowspan="" valign="top">Response:</td>
						 		<td rowspan="">
									<textarea name="rspVerbiage" id="rspVerbiage" style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" cols="24" rows="5" readonly="readonly">{$response.responseMessage|default:''} {$response.errorMessage|default:''}</textarea>

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
