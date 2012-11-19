    <!-- headerData = {"title": "{{ number }} of {{ count }}", "detail":"Annotate", "back":"Receipts" } -->
    
<div id='modalStage' class="detail">
    <div class='receiptDetail detail'>
        
        <div class="receiptText">
			<header>
				<span class="receipt-vendor">{{ merchant_name }}</span>
				<address>
					<span>{{ merchant_street }} {{ merchant_city }} {{ address_state }}</span>
					<span>{{ phone_number }}</span>
				</address>
				<time>{{ transaction_date_paid }} {{ transaction_time_paid }}</time>
			</header>
			
			<dl class="receipt-meta">
				<dt>Transaction #:</dt>
				<dd>{{ transaction_id }}</dd>
{{#account_name}}
				<dt>Paid:</dt> 
				<dd>{{ account_name }}</dd>
{{/account_name}}
{{#account_number}}
				<dt>ACCT:</dt>
				<dd>{{ account_number }}</dd>
{{/account_number}}
				<dt>Confirmation:</dt>
{{^account_type}}
				<dd><div style="color: red; display: inline;">Incomplete</div></dd>
{{/account_type}}
{{#account_type}}
				<dd>YES</dd>
{{/account_type}}
			</dl>
        
        <dl class="receipt-items">
        	{{#items}}
        	<dt>{{name}} </dt>
        	<dd>{{price}}</dd>
        	{{/items}}
        </dl>
			
			<dl class="receipt-cost">
				<!--dt>Sub Total</dt>
				<dd>{{ transaction_subtotal }}</dd>
				<dt>HST 12%</dt>
				<dd>{{ transaction_tax }}</dd-->
				<dt class="receipt-total">Total</dt>
				<dd class="receipt-total">${{ transaction_amount }}</dd>
			</dl>
		</div>

        <textarea id="annotation" name="annotation">{{ transaction_user_note }}</textarea>
        <button class="noteButton" style="color: #FFFFFF;" id="saveAnnotation">Save</button>
    </div>
</div>
<div class='receiptFooter footer'>
	<a class='footButton' id='export' href=''></a>
	<a class='footButton' id='previous'></a>
	<a class='footButton' id='next'></a>
	<a class='footButton' id='trash'></a>
</div>