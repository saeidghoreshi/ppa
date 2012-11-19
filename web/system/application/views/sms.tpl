<link rel="stylesheet" href="{$config.base_url}css/payment-status.css" type="text/css" />
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_invite">

{if $errors}
    <div class="error">
        {$errors}
    </div>
{/if}

{if empty($response->ResponseXml->RestException->Message) and !empty($response_msg)}
<h1>{$response_msg}</h1>
{else}
<h1>Invite</h1>
    <form action='{$site_url}/sms_twilio/send' method='post' name="sms_form">
        {if !empty($response->ResponseXml->RestException->Message)}
        <p style="color: red;">{$response->ResponseXml->RestException->Message}</p><br>
        {/if}
    	<p>To send an invitation to PayPhoneAPP:</p>
    	<p><strong>1. </strong>Enter the <strong>Customer's Phone Number</strong> and,</p>
    	<p><strong>2. </strong>Click on the <strong>'Send'</strong> button, or hit return.</p>
    	<br />
    	<table class="payment">
	        <tr>
		        <td>
		        	<input class='input default-value' title='Customer Phone Number' type='text' name='phone' value='' />
		        	<input type='hidden' name='message' value='PayPhoneAPP is a secure, convenient way to pay for stuff using your phone... Get it Now http://itunes.apple.com/ca/app/payphoneapp/id522231564?mt=8' />
		        </td>
	        </tr>
        </table>
        <!--<br />
        <font face="Helvetica" size="2" color="#959595"><b>Message</b></font><br>
        <textarea class='default-value' title='Message' name='message' value='' ></textarea>-->
        <input type='submit' class='button' id="submit-request" value='Send' />
    </form>
{/if}
