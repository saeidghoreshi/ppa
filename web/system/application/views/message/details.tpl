<link rel="stylesheet" href="{$config.base_url}css/message.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{$config.base_url}css/datepicker.css" />
<script type="text/javascript">var baseUrl = '';</script>
<script type="text/javascript" src="{$config.base_url}js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="{$config.base_url}js/jquery.periodicalupdater.js"></script>
<script type="text/javascript" src="{$config.base_url}js/jquery.datepicker.js"></script>
<script type="text/javascript" src="{$config.base_url}js/jquery.moneymask.js"></script>
<script type="text/javascript" src="{$config.base_url}js/jquery.textareaCounter.plugin.js"></script>
<script type="text/javascript" src="{$config.base_url}js/merchant.js"></script>
<!--<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_request">-->

<style>
	.charleft {
		line-height: 18px;
	}
	
	.warningDisplayInfo {
		color: #FF0000;
	}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		var optionsheadline = {
		    'maxCharacterSize': 30,
		    'originalStyle': 'originalDisplayInfo',
		    'warningStyle': 'warningDisplayInfo',
		    'warningNumber': 15,
		    'displayFormat': '#left Characters Left'
		};
		
		$('#message-headline').textareaCount(optionsheadline);
		
		var optionstitle = {
		    'maxCharacterSize': 50,
		    'originalStyle': 'originalDisplayInfo',
		    'warningStyle': 'warningDisplayInfo',
		    'warningNumber': 20,
		    'displayFormat': '#left Characters Left'
		};
		
		$('#message-title').textareaCount(optionstitle);
		
		var optionstext = {
		    'maxCharacterSize': 140,
		    'originalStyle': 'originalDisplayInfo',
		    'warningStyle': 'warningDisplayInfo',
		    'warningNumber': 20,
		    'displayFormat': '#left Characters Left'
		};
		
		$('#message-text').textareaCount(optionstext);
	});
</script>

<div class="content clearfix">

{if !empty($msg)}
<h1>{$msg}</h1>
{else}
<h1>Create Message</h1>
<form method="post">
<table class="merch_message">
	<tr>
		<td class="right">
			Message Headline
		</td>
		<td>
			<input class='input default-value' title='' type='text' name='message_headline' value='' id='message-headline' placeholder="30 Characters Max." />
		</td>
	</tr>
	<tr>
		<td class="right">
			Message Title
		</td>
		<td>
			<input class='input default-value' title='' type='text' name='message_title' value='' id='message-title2' placeholder="50 Characters Max." />
		</td>
	</tr>
	<tr>
		<td class="right">
			Message Text
		</td>
		<td>
			<textarea class='default-value' title='' type='text' name='message_text' value='' id='message-text' placeholder="140 Characters Max."></textarea>
		</td>
	</tr>
	<tr>
		<td class="right">
			Start Date
		</td>
		<td>
			<select id="date-start" name="date_start">
				<option value="today">Today</option>
				<option value="tomorrow">Tomorrow</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="right">
			Start Time
		</td>
		<td>
			<select id="start-time" name="time_start">
				<option value="1:00">1:00</option>
				<option value="2:00">2:00</option>
				<option value="3:00">3:00</option>
				<option value="4:00">4:00</option>
				<option value="5:00">5:00</option>
				<option value="6:00">6:00</option>
				<option value="7:00">7:00</option>
				<option value="8:00">8:00</option>
				<option value="9:00">9:00</option>
				<option value="10:00">10:00</option>
				<option value="11:00">11:00</option>
				<option value="12:00">12:00</option>
			</select>
			<select id="start-time-ampm" name="ampm_start">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="right">
			End Date
		</td>
		<td>
			<select id="date-end" name="date_end">
				<option value="today">Today</option>
				<option value="tomorrow">Tomorrow</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="right">
			End Time
		</td>
		<td>
			<select id="end-time" name="time_end">
				<option value="1:00">1:00</option>
				<option value="2:00">2:00</option>
				<option value="3:00">3:00</option>
				<option value="4:00">4:00</option>
				<option value="5:00">5:00</option>
				<option value="6:00">6:00</option>
				<option value="7:00">7:00</option>
				<option value="8:00">8:00</option>
				<option value="9:00">9:00</option>
				<option value="10:00">10:00</option>
				<option value="11:00">11:00</option>
				<option value="12:00">12:00</option>
			</select>
			<select id="end-time-ampm" name="ampm_end">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			</select>
		</td>
	</tr>
	<tr id="select-category">
		<td class="right">
			Tags
		</td>
		<td>
			<p><input type="checkbox" name="category" class="message-checkbox" value="foodanddrink">Food and Drink</p>
			<p><input type="checkbox" name="category" class="message-checkbox" value="shopping">Shopping</p>
			<p><input type="checkbox" name="category" class="message-checkbox" value="events">Events</p>
			<p><input type="checkbox" name="category" class="message-checkbox" value="services">Services</p>
		</td>
	</tr>
    <tr><td colspan="2" style="text-align: right">
    <input type='submit' class='button blue_btn_new' style="float:right;" id='submit-button' value='Create Message'/>
	<input type='submit' class='button' style="margin-right: 15px; float:right;" id='submit-button' value='Cancel'/>
	</td></tr>
</table>

<!--<div class="clear"></div>
<br />
<input type='submit' class='button blue_btn' style="float:right;" id='submit-button' value='Create Message'/>
<input type='submit' class='button btn_new' style="margin-right: 15px; float:right;" id='submit-button' value='Cancel'/>-->
</form>
{/if}