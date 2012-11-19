    <!-- headerData = {"title": "Receipts", "detail":"" } -->
<div id='modalStage' class="list">
    <div id="receiptsList" class="list">
        <div class="listView" id="receiptsListList">
            {{#receipts}}
            <a href='#receipts.detail' class='receiptsListItem modal' data-receipt_id='{{ transaction_id }}'>
                <span class='cost'{{^account_id}} style="color: red;"{{/account_id}}>${{ transaction_amount }}</span><br>
                <span class='time'>{{ transaction_date_paid }} {{ transaction_time_paid }}</span><br>
                <span class='vendor'>{{ merchant_name }} {{ address_street }}</span>
            </a>
            {{/receipts}}
        </div>
    </div>
</div>