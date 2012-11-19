    <!-- headerData = {"title": "Shops" } -->
<div id='modalStage'>
    <div class='shopDisplay'>
        <h3>Shop</h3>

        <div id='shopDescription'>
            <span class="name">{{ merchant_name }}</span><hr>
            <span class="address-one">{{ address_street }}</span><hr>
            <span class="address-two">{{ address_city }} {{ address_state }}</span><hr>
            <span class="phone">{{ phone_number }}</span><hr>
            {{#email2}}
            <span class="website">{{ email }}</span><hr>
            {{/email2}}
            {{#hours1}}
            <span class="hours">Hours: {{ hour }}</span><hr>
            {{/hours1}}
	    {{#merchant_description3 }}
            <span class="description">{{ merchant_description }}</span>
	    {{/merchant_description3 }}
        </div>

        <img src="http://maps.google.com/maps/api/staticmap?center={{ address_street }},{{ address_city }},{{ address_state }}&zoom=16&size=254x230&maptype=roadmap&markers=color:red|label:S|{{ latitude }},{{ longitude }}&sensor=false" width="254" height="230" border="0">
        <!--a href="http://maps.google.ca/maps?f=q&source=s_q&hl=en&q={{ address_street }},{{ address_city }},{{ address_state }}" onclick="Device.exec('openmap:q={{ address_street }},{{ address_city }},{{ address_state }}');return false;" target="_blank"><img src="http://maps.google.com/maps/api/staticmap?center={{ address_street }},{{ address_city }},{{ address_state }}&zoom=14&size=260x230&maptype=roadmap&markers=color:red|label:S|{{ latitude }},{{ longitude }}&sensor=false" border="0"></a-->

    </div>
</div>    
