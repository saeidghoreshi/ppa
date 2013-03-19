var messages;
var map;
var currentdate = new Date();
var currentcategory = null;

$(document).ready(function() {
	init_map();
	$('#messages').jScrollPane();
	bind_categories();
	bind_arrows();
	update_date();
});

$(function(){
	$.extend($.fn.disableTextSelect = function() {
		return this.each(function(){
			if($.browser.mozilla){//Firefox
				$(this).css('MozUserSelect','none');
			}else if($.browser.msie){//IE
				$(this).bind('selectstart',function(){return false;});
			}else{//Opera, etc.
				$(this).mousedown(function(){return false;});
			}
		});
	});
	$('.noSelect').disableTextSelect();//No text selection on elements with a class of 'noSelect'
});

function init_map() {
    var point = new google.maps.LatLng(49.2827000,-123.09442520),
    
    myOptions = {
        zoom: 14,
        center: point,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: false,
        maxZoom: 14,
        minZoom: 14
    },
    
    mapDiv = document.getElementById("mapDiv"),
    map = new google.maps.Map(mapDiv, myOptions);
    
    /*marker = new google.maps.Marker({
        position: point,
        map: map,
        title: "You are here"
    });*/
//		url: 'https://www.payphoneapp.com/index.php/message',
    $.ajax({
		url: 'https://www.goodlist.ca/index.php/message',
		context: document.body,
		dataType: 'json',
		type: 'POST',
		data: { 
			'json': 1
		},
		success: function(data) {
			messages = data;
			/*var image = 'images/mapicons/inactive/clothing_female.png';*/
			/*var image = 'images/mapicons/hover/clothing_female.png';*/
			var fadimage = 'images/mapmarkers/marker_foodanddrink.png';
			var shpimage = 'images/mapmarkers/marker_shopping.png';
			var evnimage = 'images/mapmarkers/marker_events.png';
			var srvimage = 'images/mapmarkers/marker_services.png';
			
			sort_messages();
			for (i=0; i < messages.length; i++) {
				if (messages[i].message_category == 'foodanddrink') {
		        	marker = new google.maps.Marker({
		        		position: new google.maps.LatLng(messages[i].message_latitude , messages[i].message_longitude),
		        		map: map,
		        		icon: fadimage
		        	});
	        	} else if (messages[i].message_category == 'shopping') {
		        	marker = new google.maps.Marker({
		        		position: new google.maps.LatLng(messages[i].message_latitude , messages[i].message_longitude),
		        		map: map,
		        		icon: shpimage
		        	});
	        	} else if (messages[i].message_category == 'events') {
		        	marker = new google.maps.Marker({
		        		position: new google.maps.LatLng(messages[i].message_latitude , messages[i].message_longitude),
		        		map: map,
		        		icon: evnimage
		        	});
	        	} else if (messages[i].message_category == 'services') {
		        	marker = new google.maps.Marker({
		        		position: new google.maps.LatLng(messages[i].message_latitude , messages[i].message_longitude),
		        		map: map,
		        		icon: srvimage
		        	});
	        	}
	        }
		}
	});
}

function bind_messages() {
	$('.message-item').click(function() {
		show_message($(this).attr('id'));
		$('#messages').find('li').removeClass('selected_message');
		$(this).addClass('selected_message');
	});
}

function show_message(target) {
	target = parseInt(target.split('message').slice(1,2));

	if( messages[target].merchant_icon == "" || messages[target].merchant_icon == null )
	{
		$('#current_message img').attr('src',window.location.href+'../images/goodlist.jpg');  
	} else 
	{
		$('#current_message img').attr('src',messages[target].merchant_icon);
	}
	$('#message-title').text(messages[target].message_title);
	$('#message-text').text(messages[target].message_text);
	$('#date-start').text('Start: '+messages[target].date_start_formatted);
	$('#date-end').text('End: '+messages[target].date_end_formatted);
	$('#merchant-name').text(messages[target].merchant_name);
	// Merchant is not stored in the messages database.
	// An ajax call to the merchants DB will be required.
	// $('#merchant-address').text(messages[target].merchant_address);
}

function sort_messages(category) {
	currentcategory = category;
	$('#messages').html('<ul>');
	for (i = 0; i < messages.length; i++) {
		var start = new Date(messages[i].date_start.split('-').join('/')),
			end = new Date(messages[i].date_end.split('-').join('/'));
		if(!currentcategory || messages[i].message_category == currentcategory) {
			//if((currentdate - end) > 0 && (currentdate - start) < 86400000) {
			if((currentdate >= start) && (currentdate <= end)) {
				$('#messages').append('<li class="message-item ' + messages[i].message_category + '" id="message' + i + '"><span class="merchant">' + messages[i].merchant_name + '</span>' + ' - ' + messages[i].message_title + '<img class="message-arrows" src="images/arrow_inactive_grey.png">' + '</li>');
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(messages[i].latitude, messages[i].longitude),
					map: map
				});
				/*console.log(messages[i].latitude + ' ' + messages[i].longitude);*/
			}
		}
	}
	$('#messages').append('</ul>');
	bind_messages();
}

function bind_categories() {
	$('#nav1').click(function() {
		sort_messages('foodanddrink');
		$('.nav').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});
	$('#nav2').click(function() {
		sort_messages('shopping');
		$('.nav').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});
	$('#nav3').click(function() {
		sort_messages('events');
		$('.nav').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});
	$('#nav4').click(function() {
		sort_messages('services');
		$('.nav').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});
	$('#nav5').click(function() {
		sort_messages(null);
		$('.nav').removeClass('selected');
		$(this).addClass('selected');
		return false;
	});
}

function bind_arrows() {
	$('#arrow-right').click(function(){
		advance_date();
	});
	$('#arrow-left').click(function(){
		recede_date();
	});
}

function advance_date() {
	currentdate.setTime(currentdate.getTime()+86400000);
	update_date()
	sort_messages(currentcategory);
}

function recede_date() {
	currentdate.setTime(currentdate.getTime()-86400000);
	update_date()
	sort_messages(currentcategory);
}

function update_date() {
	var month = currentdate.getMonth() + 1;
	switch(month){
		case 1:
			month = "jan";
			break;
		case 2:
			month = "feb";
			break;
		case 3:
			month = "mar";
			break;
		case 4:
			month = "apr";
			break;
		case 5:
			month = "may";
			break;
		case 6:
			month = "jun";
			break;
		case 7:
			month = "jul";
			break;
		case 8:
			month = "aug";
			break;
		case 9:
			month = "sept";
			break;
		case 10:
			month = "oct";
			break;
		case 11:
			month = "nov";
			break;
		case 12:
			month = "dec";
			break;
	}
	date = month + ' ' + currentdate.getDate();
	$('#nav0').text('');
	$('#nav0').text(date);
}
