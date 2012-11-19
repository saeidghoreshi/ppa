$(document).ready(function(){
    var btnRefresh = $("#btnRefresh");
    var inputMerchantId = $("#merchant_id");
    var inputSearch = $("#search_condition");
    var search = "%%";
    if (inputSearch.val()) {
        search = inputSearch.val();
    }
    
    var latlng = new google.maps.LatLng('49.283553', '-123.106657');
    var myOptions = {
      zoom: 15,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"),
        myOptions);
        
    var markersArray = [];
    var myMarkersArray = [];
    var selectedMarker;
    
    $.post("index.php/shops/getMarkers", 
    { 
        'json': 1,
        'search': search 
    },
    function(data){
        if (data && data.length > 0) {
            var merchant = data[0];
            for (var i=0; i<merchant.length; i++) {
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(merchant[i].latitude, merchant[i].longitude),
                    map: map,
                    title: merchant[i].merchant_name
                });
                var info = "<b>" + merchant[i].merchant_name + "</b><br>" 
                    + "Type: " + merchant[i].type + "<br>"
                    /* + "Contact: " + merchant[i].contact + "<br>" */
                    + "Phone: " + merchant[i].phone_number + "<br>"
                    /* + "Email: " + merchant[i].email; */
                var infowindow = new google.maps.InfoWindow({ content: info });
                google.maps.event.addListener(marker, 'click', infoCallback(infowindow, marker));
                markersArray.push(marker);
                var myMarker = [merchant[i].merchant_id, marker];
                myMarkersArray.push(myMarker);
            }   
        }
        if (markersArray) {
          for (j in markersArray) {
            markersArray[j].setMap(map);
          }
        }
    }, "json");
    
    function infoCallback(infowindow, marker) { 
        return function() { 
            infowindow.open(map, marker); 
        }; 
    }

    btnRefresh.click(function() {
        if (selectedMarker) {
            selectedMarker.setAnimation(null);
        }      
        if (myMarkersArray && myMarkersArray.length > 0) {
            for (i in myMarkersArray) {
                if (myMarkersArray[i][0] == inputMerchantId.val()) {
                    selectedMarker = myMarkersArray[i][1];
                }
            }
        }
        if (selectedMarker) {
            selectedMarker.setAnimation(google.maps.Animation.BOUNCE);
            setTimeout(function() {
              selectedMarker.setAnimation(null);
    		}, 700);
                         
        }
    });
});

