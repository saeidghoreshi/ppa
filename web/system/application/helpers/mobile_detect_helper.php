<?php

/**
 * Generic base model for all model classes within PPA. Provides all data access
 * to the a given DB table as specified by $table.
 *
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
function is_mobile()
{
	$regex_match="/(nokia|iphone|android|motorola|^mot-|softbank|foma|docomo|kddi|up.browser|up.link|";
	$regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";
	$regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";	
	$regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte-|longcos|pantech|gionee|^sie-|portalmmm|";
	$regex_match.="jigs browser|hiptop|^ucweb|^benq|haier|^lct|operas*mobi|opera*mini|320x320|240x320|176x220";
	$regex_match.=")/i";
        
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}


?>
