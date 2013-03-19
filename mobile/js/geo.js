x$(document).on('DOMContentLoaded', function () {
    document.addEventListener("deviceready", onDeviceReady, false);
});

var watchID = null;
var locationDetermined = false;

// PhoneGap is ready
function onDeviceReady() {
    startGeo();
}

function startGeo() {
    // Update every 1.5 seconds
    if( watchID === null ) {
	var options = {
	    frequency: 5000, 
	    maximumAge: 10000, 
	    timeout: 10000, 
	    enableHighAccuracy: true
	};
	watchID = navigator.geolocation.watchPosition(onSuccess, onError, options);
    }
}

function stopGeo() {
    if( watchID !== null ) {
	navigator.geolocation.clearWatch(watchID);
	watchID = null;
    }
}

// onSuccess Geolocation
function onSuccess(position) {
    var geo_txt;
    geo_txt = 'Latitude: '  + position.coords.latitude      + '<br />' +
    'Longitude: ' + position.coords.longitude     + '<br />' +
    '<hr />'      ;
    if( locationDetermined ) {
	PPA.geo = position;
    }
    else {
	//alert('location identified');
	window.setTimeout(function() {
	    PPA.geo = position;
	}, 2000);    
	locationDetermined = true;
    }
}

// onError Callback receives a PositionError object
function onError(error) {
    //PPA.alert('Location Services: '    + error.code    + '\n' + 'message: ' + error.message + '\n');
    //PPA.alert('Please turn on Location services', error.message)
    //stopGeo();
}
