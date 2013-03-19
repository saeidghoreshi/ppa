    <!-- headerData = {"title": "Shops", "detail":"" } -->
<div id='modalStage'>    
    <div id="shopsList">
        <div class="listView" id="shopsListList">
            {{#shops}}
            <a href='#shops.detail' class='shopsListItem modal' data-merchant_id='{{ merchant_id }}'>
                <span class='name'>{{ merchant_name }}</span><br>
                {{#merchant_description1 }}<span class='desc'>{{ merchant_description }}</span><br>{{/merchant_description1 }}
                <span class='address'>{{ address_street }} {{ address_city }} {{ address_state }}</span>
            </a>
            {{/shops}}
        </div>
    </div>
</div>