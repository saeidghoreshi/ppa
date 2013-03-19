    <h2>Beanstream Demo</h2> 
    
{if $accounts}
    {foreach from=$accounts item=account}
    <a href="#" onclick="
    document.transaction.trnCustName.value='{$account.account_firstname|default:''} {$account.account_lastname|default:''}'; 
    document.transaction.trnAVstreet.value="{$account.address_street|default:''|escape}"; 
    document.transaction.trnCardNumber.value="{$account.account_number|default:''|escape}"; 
    document.transaction.cvv2.value="{$account.account_cvv|default:''|escape}"; 
    document.transaction.trnAVCity.value="{$account.address_city|default:''|escape}"; 
    document.transaction.trnAVState.value=''; 
    document.transaction.trnAVZip.value="{$account.address_zip|default:''|escape}"; 
    document.transaction.trnPhoneNumber.value="{$account.user_phone|default:''|escape}"; 
    document.transaction.trnAmount.value="{$account.trnAmount|default:rand(10,99)/100|escape}"; 
    document.transaction.trnEmail.value="{$account.user_email|default:''|escape}"; 
    document.transaction.trnOrderNumber.value="{$account.doesnotexist|default:rand(99,10000)|escape}"; 
    return false;">{$account.account_name}</a> ||
    {/foreach}
    <a href="#" onclick="
    document.transaction.trnCustName.value=''; 
    document.transaction.trnAVstreet.value=''; 
    document.transaction.trnCardNumber.value=''; 
    document.transaction.trnAVCity.value=''; 
    document.transaction.trnAVState.value=''; 
    document.transaction.trnAVZip.value=''; 
    document.transaction.trnPhoneNumber.value=''; 
    document.transaction.trnAmount.value=''; 
    document.transaction.trnOrderNumber.value=''; 
    return false;">Clear Fields</a>
<br>    <br>    
{/if}    
		<form action='{$site_url}/beanstream/push' method='post' name="transaction"> 

			    <table border="0">
							<tr>
								<td>Name:</td>
								<td><input size="20" maxlength="64" name="trnCustName" id="trnCustName" onchange="" tabindex="2" type="textbox" value="{$smarty.post.trnCustName|default:''|escape}"></td>
								<td rowspan="12" width="10"></td>
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
								<td>Transaction:</td>
								<td>
									<select name="trnType" id="trnType" onchange="OnChangeTrnType();ChangeAVType()" style="width: 144px;" width="144" tabindex="8">
									
										<option value="P">Purchase
										</option><option value="R">Return
										</option><option value="PA">Pre Authorization
										</option><option value="PAC">Pre-Auth Completion
										</option><option value="VP">Void Purchase
										</option><option value="VR">Void Return
									</option></select>

								</td>
							</tr><tr>
								<td>Sale Amount:</td>
								<td><input size="20" maxlength="13" name="trnAmount" id="trnAmount" tabindex="9" type="textbox" value="{$smarty.post.trnAmount|default:''|escape}"></td>
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
								<td>Receipt Language:</td>
								<td>
									<select name="trnLanguage" id="trnLanguage" tabindex="24" style="width: 167px;">
										<option value="eng" selected="selected">English
										</option><option value="fre">French
									</option></select>
								</td>

							</tr><tr>
								<td>Adjustment ID:</td>

								<td><input disabled="disabled" size="20" maxlength="15" name="trnTransId" id="trnTransId" onblur="CheckNumericValue(this)" tabindex="11" type="textbox" value="{$smarty.post.trnTransId|default:''|escape}"></td>
								
									<input name="trnIpAddr" id="trnIpAddr" value="" type="hidden" value="{$smarty.post|default:''|escape}">
								
							</tr><tr height="16">

								<td colspan="5"></td>
							</tr><tr>
								<td>Transaction Id:</td>
								<td><input style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" size="20" maxlength="8" id="rspTransId" name="rspTransId" readonly="readonly" type="textbox" value="{$response.trnId|default:''|escape}"></td>
							</tr><tr>
								<td rowspan="" valign="top">Response:</td>
						 		<td rowspan="">
									<textarea name="rspVerbiage" id="rspVerbiage" style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" cols="24" rows="5" readonly="readonly">{$response.messageText|default:''} {$response.avsMessage|default:''}</textarea>

								</td>
							</tr><tr>
								<td>Approval Code:</td>
								<td><input style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" size="20" maxlength="8" name="rspApprovalCode" id="rspApprovalCode" readonly="readonly" type="textbox" value="N/A"></td>
							</tr><tr>
								<td>Batch Number:</td>
								<td><input style="color: rgb(119, 119, 119); background: none repeat scroll 0% 0% rgb(229, 229, 229);" size="20" maxlength="8" name="rspBatchNumber" id="rspBatchNumber" readonly="readonly" type="textbox" value="N/A"></td>
							</tr><tr>

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

{*

			<font face="Helvetica" size="2" color="#959595"><b>Email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></font>
			<input class='default-value' title='Email' type='text' name='email' value='' /> 
			<br /> 
			<font face="Helvetica" size="2" color="#959595"><b>Phone&nbsp;&nbsp;&nbsp;&nbsp;</b>&nbsp;</font>
			<input class='default-value' title='Phone Number' type='text' name='phone' value='' /> 
			<br /> 
			<font face="Helvetica" size="2" color="#959595"><b>Passcode</b></font>
			<input class='default-value' title='Passcode' type='password' name='password' value='' /> 
			<br /> 
*}			
			<input type='submit' class='button' value='Push Request' /> 
		</form> 
