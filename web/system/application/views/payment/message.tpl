<link rel="stylesheet" href="{$config.base_url}css/payment.css" type="text/css" />
<link rel="stylesheet" href="{$config.base_url}css/payment-request.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/datepicker.css" /> 
<script type="text/javascript">var baseUrl = '';</script> 
<script type="text/javascript" src="{$config.base_url}js/jquery-1.4.2.min.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.periodicalupdater.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.datepicker.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/jquery.moneymask.js"></script> 
<script type="text/javascript" src="{$config.base_url}js/merchant.js"></script> 
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_request">
                        <div class="content clearfix">

<h1>Messages</h1>

<table>
	<tr>
		<td>
			<input class='input default-value' title='Message Headline' type='text' maxlength="30" name='message-headline' value='' id='message-headline' />
		</td>
	</tr>
	<tr>
		<td>
			<input class='input default-value' title='Message Title' type='text' maxlength="50" name='message-title' value='' id='message-title' />
		</td>
	</tr>
	<tr>
		<td>
			<input class='input default-value' title='Message Text' type='text' maxlength="100" name='message-text' value='' id='message-text' />
		</td>
	</tr>
	<tr>
		<td>
			<select id="date-start">
				<option value="today">Today</option>
				<option value="tomorrow">Tomorrow</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<select id="date-end">
				<option value="today">Today</option>
				<option value="tomorrow">Tomorrow</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>
			<input type='submit' class='button' id='submit-button' value='Send Message'/>
		</td>
	</tr>
</table>