    <!-- headerData = {"title": "{{ number }} of {{ count }}", "detail":"", "back":"Messages" } -->
<div id='modalStage' class="detail">
{{#message_image}}
    <div class='messageImageDetail' style="{{#message_height}}min-height: {{message_height}}px;{{/message_height}}">
{{#message_link}}
	<a href="{{message_link}}" target="_blank">
{{/message_link}}
	    <img src="{{ message_image }}" width="100%" />
{{#message_link}}
	</a>
{{/message_link}}
    </div>
{{/message_image}}
{{^message_image}}
{{#merchant_name}}	
    <div class='messageDetail'>
        <span class='merchantName'>{{ merchant_name }}</span><br><br>
{{/merchant_name}}	
{{#message_headline}}
        <span class='messageHeadline'>{{ message_headline }}</span><br>
{{/message_headline}}
{{#message_title}}
        <span class='messageTitle'>{{ message_title }}</span><br><br>
{{/message_title}}	
{{#message_text}}
        <pre class='messageText'>{{ message_text }}</pre><br>
{{/message_text}}
{{#message_date}}
        <span class='messageDate'>{{ message_date }}</span><br><br>
{{/message_date}}
{{#address_city}}
        <span class='merchantLocation'>
            {{ address_street }}<br>
            {{ address_city }} {{ address_state }} {{ phone_number }}<br>
        </span>
{{/address_city}}
    </div>
{{/message_image}}
</div>   
<div class='receiptFooter' style="min-height: 38px;" >
&nbsp;
	<!--a class='footButton' id='export' href=''></a>
	<a class='footButton' id='previous'></a>
	<a class='footButton' id='next'></a>
	<a class='footButton' id='trash'></a-->
</div>

