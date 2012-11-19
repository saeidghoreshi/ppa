    <!-- headerData = {"title": "Profile", "detail":"Edit" } -->
<div id="modalStage">    
    <div class='profileDisplay'>
        <h3>Profile</h3>

        <div id='personDescription'>
            <span class="fullname">{{ firstname }} {{ lastname }}{{^lastname}}N/A{{/lastname}}</span><hr>
            <span class="address">{{ street }}{{^street}}N/A{{/street}}</span><hr>
            <span class="city">{{ city }}{{^city}}N/A{{/city}}, {{ country }}{{^country}}N/A{{/country}}</span><hr>
            <span class="phone">{{ phone }}{{^phone}}N/A{{/phone}}</span><hr>
            <span class="email">{{ email }}{{^email}}N/A{{/email}}</span>
        </div>
    </div>
</div>