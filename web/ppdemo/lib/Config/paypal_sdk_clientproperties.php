<?php

#############################################################################################
# This file is used mainly to specify the API crendentials to be used for every API call.
# Make sure reading the property files containing the credentials are secure and files are 
# not accessible by the hackers. Change the source code supplied with SDK to implement your
# own reading logic if and when needed.
#############################################################################################

/****************************************************
paypal_sdk_clientproperties.php

This is the configuration file for the samples.This file
defines the parameters needed to make an API call.

****************************************************/

/**
# Endpoint: this is the server URL which you have to connect for submitting your API request.
Chanege to https://svcs.paypal.com/  to go live */

define('API_BASE_ENDPOINT', 'https://svcs.sandbox.paypal.com/');

/**
USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
like define('USE_PROXY',TRUE);

*/
define('USE_PROXY',FALSE);
/**
PROXY_HOST: Set the host name or the IP address of proxy server.
PROXY_PORT: Set proxy port.

PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
*/
define('PROXY_HOST', '127.0.0.1');
define('PROXY_PORT', '808');


/**
# API user: The user that is identified as making the call. you can
# also use your own API username that you created on PayPal�s sandbox
# or the PayPal live site
*/


//define('API_AUTHENTICATION_MODE','ssl');
//define('API_USERNAME', 'platfo_1255170694_biz_api1.gmail.com');
//define('API_PASSWORD', '2DPPKUPKB7DQLXNR');
//define('SSL_CERTIFICATE_PATH','../Certs/sandbox_cert_key_pem.txt');


/**
# API_password: The password associated with the API user
# If you are using your own API username, enter the API password that
# was generated by PayPal below
# IMPORTANT - HAVING YOUR API PASSWORD INCLUDED IN THE MANNER IS NOT
# SECURE, AND ITS ONLY BEING SHOWN THIS WAY FOR TESTING PURPOSES
*/

/***** 3token API credentials *****************/
define('API_AUTHENTICATION_MODE','3token');
define('API_USERNAME', 'dmitry_1332209159_biz_api1.payphoneapp.com');
define('API_PASSWORD', '1332209183');
define('API_SIGNATURE', 'AQhA29Kkbz-0rO-OBadtiTmcdJDKAnKyWmMu6KUI4UEld8fiTACFAr7N');

/**
 * specifies the Log file path.
 * 
 */
define('LOGFILENAME','logs/paypal_platform.log');

/**
 * Use the following setting (false) if you are testing or using SDK against live PayPal's production server
 * 
 */
define('TRUST_ALL_CONNECTION',false);

/**
 * 
 * Defines the SDK Version, Request and Response message formats.
 */
define('SDK_VERSION','PHP_SOAP_SDK_V1.4');
define('X_PAYPAL_APPLICATION_ID','APP-80W284485P519543T');
//Binding options -> SOAP11,XML,JSON
define('X_PAYPAL_REQUEST_DATA_FORMAT','SOAP11');
define('X_PAYPAL_RESPONSE_DATA_FORMAT','SOAP11');

/*
 * IP Address of the device
 */
define('X_PAYPAL_DEVICE_IPADDRESS','127.0.0.1');
?>