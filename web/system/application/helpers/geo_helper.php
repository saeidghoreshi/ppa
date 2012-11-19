<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function distance($lat1, $lon1, $lat2, $lon2, $unit = 'M') { 

  $theta = $lon1 - $lon2; 
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
  $dist = acos($dist); 
  $dist = rad2deg($dist); 
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344); 
  } else if ($unit == "M") {
    return round($miles * 1.609344*1000); 
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}  

function getLocation($ip=null) {
	$ret = null;
	if(empty($ip)) $ip = $_SERVER['REMOTE_ADDR'];
	try 
	{
		require_once('Net/GeoIP.php');
		$geoip = Net_GeoIP::getInstance('/usr/share/geoip/GeoLiteCity.dat', Net_GeoIP::SHARED_MEMORY);
		$ret = $geoip->lookupLocation($ip);
	}
	catch(Exception $e) {}
	return $ret;
}

?>
