<link rel="stylesheet" type="text/css" href="{$config.base_url}css/shops.css" />
<script type="text/javascript" src="{$config.base_url}js/shops.js"></script>
<input type="hidden" id="currentPageTab" name="currentPageTab" value="h_shops">
<div class="wrap">
<input type="hidden" name="test" id="test" value="abc">
        <div id="trans_wrap">
        	<div id="header-left">
        		<h1>Shops In Your Area</h1>
        	</div>
			<div id="header-right">
                <div class="custom_report clearfix">
                        <div class="rinline">
                                <form method="post" action="{$site_url}/shops/search">
                            <input class="search_field" type="text" name="search" value="" placeholder="Search" />
                                </form>
                        </div>				
                </div>
            </div>

                <div class="shops_wrap">

                        <div class="content clearfix">

                                <div class="linline">
                                        <ul id="shops_list" class="shops_list clearfix">
{if $merchants}
{foreach from=$merchants item=m name=merchant}
    <li><a id="shop-{$m.merchant_id}" href="#">{$m.merchant_name}</a></li>                                               
{/foreach}
{else}
    No shops & restaurants are available.
{/if}
                                        </ul>
                                </div>
                                <div class="rinline">
                                        <div class="inner" id="shop_gMap">
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<style type="text/css">
  html { height: 100% }
  body { height: 100%; margin: 0px; padding: 0px }
  #map_canvas { height: 100% }
</style>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="{$config.base_url}js/shops-map.js"></script>
</head>
<body>
<input type="button" id="btnRefresh" value="Map Refresh" style="display:none">
<input type="hidden" id="merchant_id" value="">
<input type="hidden" id="search_condition" value="{$searchCondition}">
  <div id="map_canvas" style="width:100%; height:100%"></div>
</body>
</html>
                                        </div>
                                </div>
                                <div class="clr"></div>
                        </div>

                        <div id="info" class="info">
                        <div id="shop_info" class="shop_info"></div>
                        </div>

                </div>

        </div>
</div>