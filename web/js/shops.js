$(document).ready(function(){
    
    var googMapDiv = $("#shop_gMap");
    var googMapMerchantId = $("#merchant_id", googMapDiv);
    var googMapRefreshBtn = $("#btnRefresh", googMapDiv);
    
	
	/* mouseover and click events */
	
	var shops_list = $('#shops_list');
	var shop_info = $('#shop_info');
	
	$('#shops_list a').bind({
		click: function() {
			if( ! $(this).hasClass('active-shop') ) {
				
				$('#shops_list a').removeClass('active-shop');
				$(this).addClass('active-shop');
				//shops_list.addClass('disabled');
				
       var shop_id;
       var s;
       (s = $(this).attr('id').match("shop-([\\d]+)") ) ? shop_id = s[1] : shop_id = 0;				
       $.post("index.php/shops/getDetail", 
       { 
            'json_web': 1,
            'shopId': shop_id 
       },
       function(data){
            $('#shop_info').html(data.htmlresponse);
            googMapMerchantId.val(data.shopId);
            googMapRefreshBtn.trigger('click'); 
            return false;
       }, "json"); 
            
				if( shop_info.is(":visible") && ! $(this).hasClass('hovered') ) {
					shop_info.hide();
				}
				shop_info.stop(true,true).show();
				
			} else {
				
				$(this).removeClass('active-shop');
				shops_list.removeClass('disabled');
				shop_info.stop(true,true).hide();
				
			}
			return false;
		},
		mouseover: function() {
			if( ! shops_list.hasClass('disabled') ) {
				$(this).addClass('hovered');
                             
       var shop_id;
       var s;
       (s = $(this).attr('id').match("shop-([\\d]+)") ) ? shop_id = s[1] : shop_id = 0;
       $.post("index.php/shops/getDetail", 
       { 
            'json_web': 1,
            'shopId': shop_id 
       },
       function(data){
           $('#shop_info').html(data.htmlresponse);
       }, "json");
                               
				shop_info.stop(true,true).show();
				
			}
		},
		mouseout: function() {
			if( ! shops_list.hasClass('disabled') ) {
				$(this).removeClass('hovered');
				//shop_info.stop(true,true).hide();
				//shop_info.stop(true,true);
				//shop_info.hide();
				//shop_info.stop(true,true).html('');
				
			}
		}
	});
        
});

