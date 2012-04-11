<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_transaction">
<script src="https://maps.google.com/maps/api/js?sensor=true"></script>
<link type="text/css" href="{$config.base_url}css/jquery.jscrollpane.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="{$config.base_url}js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="{$config.base_url}js/jquery.jscrollpane.min.js" type="text/javascript"></script>
<script src="{$config.base_url}js/goodlist.js"
            type="text/javascript"></script>
            
<div id="mapDiv">
	<iframe width="960" height="250" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=gastown&amp;aq=&amp;sll=43.484812,-109.423828&amp;sspn=19.8209,46.538086&amp;ie=UTF8&amp;ll=49.284156,-123.098974&amp;spn=0.015677,0.082312&amp;z=14&amp;output=embed"></iframe>
</div>

<div id="utility" class="noSelect">
	<div id="date-picker" class="noSelect">
		<div class="arrows" id="arrow-left" class="noSelect"></div>
		<p href="#" id="nav0" class="noSelect">
		</p>
		<div class="arrows" id="arrow-right" class="noSelect"></div>
	</div>
</div>

<div id="list">
	<div id="nav">
		<a href="messages/#" id="nav1" class="nav foodanddrink">food+drink</a>
		<a href="messages/#" id="nav2" class="nav shopping">shopping</a>
		<a href="messages/#" id="nav3" class="nav events">events</a>
		<a href="messages/#" id="nav4" class="nav services">services</a>
		<a href="messages/#" id="nav5" class="nav viewall">view all</a>
		<!--<input type="text" id="search-field" value="Search">-->
		<div id="search-box">
			<form method="post" action="{$site_url}/shops/search">
	            <input id="search-field" type="text" name="search" placeholder="Search" />
	        </form>
        </div>
	</div>
	<div id="current_message">
		<img src="{$config.base_url}images/nouvelle.jpg" width="210" height="79">
		<p id="message-title"></p>
		<p id="message-text"></p>
		<p id="merchant-name"></p>
		<p id="date-start"></p>
		<p id="date-end"></p>
	</div>
	<div id="messages_wrap">
	<div id="messages">
		<!--<ul>
			{foreach from=$merchants item=m name=merchant}
			    <li><a id="shop-{$m.merchant_id}" href="#">{$m.merchant_name}</a></li>                                               
			{/foreach}
			<li><span class="merchant">Prado Cafe</span> - This is dummy copy. It is not meant to be read. It has been placed here solely to demonstrate the look and feel of finished, typeset text.</li>
			<li><span class="merchant">Nouvelle Nouvelle</span> - Only for show. He who searches for meaning here will be sorely disappointed.</li>
			<li><span class="merchant">Sea Monstr Sushi</span> - These words are here to provide the reader with a basic impression of how actual text will appear in its final presentation.</li>
			<li><span class="merchant">Meat and Bread</span> - Think of them merely as actors on a paper stage, in a performance devoid of content yet rich in form.</li>
			<li><span class="merchant">Sharks and Hammers</span> - That being the case, there is really no point in your continuing to read them.</li>
			<li><span class="merchant">Milano Coffee</span> - After all, you have many other things you should be doing.</li>
			<li><span class="merchant">Peckinpah</span> - Who's paying you to waste this time, anyway?</li>
			<li><span class="merchant">Vera's Burger Shack</span> - This is dummy copy. It's Greek to you. Unless, of course, you're Greek, in which case, it really makes no sense.</li>
			<li><span class="merchant">Prado Cafe</span> - Why, you can't even read it! It is strictly for mock-ups. You may mock it up as strictly as you wish.</li>
			<li><span class="merchant">Nouvelle Nouvelle</span> - Meaningless mock-up, mock turtle soup spilled on a mock turtle neck. Mach I Convertible copy.</li>
			<li><span class="merchant">Sea Monstr Sushi</span> - To kill a mockingbird, you need only force it to read this copy. This is meaningless filler.</li>
			<li><span class="merchant">Meat and Bread</span> - It is not meant to be a forum for value judgments nor a scholarly diatribe on how virtue should be measured.</li>
			<li><span class="merchant">Sharks and Hammers</span> - The whole point here (if such a claim can be made in an admittedly pointless paragraph) is that this is dummy copy.</li>
			<li><span class="merchant">Milano Coffee</span> - Real bullets explode with destructive intensity. Such is not the case with dummy bullets. In fact, they don't explode at all.</li>
			<li><span class="merchant">Peckinpah</span> - Duds. Dull thuds. Dudley do-wrongs. And do-wrongs don't make a right.</li>
			<li><span class="merchant">Vera's Burger Shack</span> - Why on earth are you still reading this?</li>
		</ul>-->
	</div>
	</div>
</div>