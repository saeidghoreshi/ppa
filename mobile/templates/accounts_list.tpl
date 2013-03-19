    <!-- headerData = {"title": "Accounts", "detail":"Add New" } -->
<div id='modalStage'>
    <div id="accountsList">
            {{#accounts}}
        <div class="listView" id="accountsListList">
            <a href='#accounts.detail' class='accountsListItem modal' data-account_id='{{ account_id }}'>
                <span class='nickname'>{{ account_name }}</span><br>
                <span class='activity'>Account: {{ account_safenumber }}</span><br>
                <span class='activity'>{{#last_activity}}
                    Last Activity: <span class="lastCost">${{ cost }}</span><span class="lastDate">{{ date }}</span>
                {{/last_activity}}{{^last_activity}}Last Activity: N/A{{/last_activity}}
                </span><br>
                <span class='available'>Available Funds: {{#account_balance}}${{ account_balance }}{{/account_balance}}{{^account_balance}}N/A{{/account_balance}}</span>
            </a>
        </div>
            {{/accounts}}
            {{^accounts}}
        <div class="accountsMsg">
Touch the Add An Account button to add a credit card to your PayPhoneAPP!
(Account information is stored by a PCI compliant third party)
No Account information is transmitted during the payment process.
<a class="local button" href="javascript:hideModal();PPA.acctFormAction = 'add';showTemplate('account_type');">Add An Account</a>

        </div>
            {{/accounts}}
    </div>
</div>