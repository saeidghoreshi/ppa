    <!-- headerData = {"title": "Accounts", "detail":"Edit" } -->
<div id='modalStage'>   
    <div class='accountDetail'>
        <h3>Account Detail</h3>

        <dl id='accountDescription'>
            <dt>Nickname</dt>           <dd>{{ account_name }}</dd><hr>
{{#account_type_name}}            <dt>Type</dt>               <dd>{{ account_type_name }}</dd><hr>{{/account_type_name}}
{{#account_safenumber}}            <dt>Number</dt>             <dd>{{ account_safenumber }}</dd><hr>{{/account_safenumber}}
            <dt>Expiry</dt>             <dd>{{ account_expiry }}</dd><hr>
            <dt>Status</dt>             <dd>{{ status }}</dd><hr>
            <dt>Available:</dt>         <dd>${{ available }}</dd><hr>
            <dt>Last Transaction</dt>   <dd>${{#last_activity}}{{ cost }}{{/last_activity}}</dd>
        </dl>
    </div>
</div>