<?php
/**
 * SMS Gateway Library(Twilio)
 * 
 * Performs Twilio SMS API Calls
 *
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 * @filesource
 */

if( !defined('BASEPATH') )
    exit('No direct script access allowed');

require "twilio.php";
    
class Sms_gateway
{
    var $CI = null; 
    var $apiVersion;
    var $accountSid;
    var $authToken;
    var $senderPhone;

    function __construct()
    {
        $this->CI = & get_instance();
        // Load Twilio Config
        $config =& get_config();
	// Twilio REST API version
	$this->apiVersion = $config['twilio_api_version'];
	// Set our AccountSid
	$this->accountSid = $config['twilio_account_sid'];
	// Set our AuthToken
	$this->authToken = $config['twilio_ath_token'];
	// Sender Phone
	$this->senderPhone = $config['twilio_sender_phone'];
    }
    

    /**
     * Twilio Send SMS service call function
     *
     * @access	private
     * @param	array   $options
     * @param	string  $url
     * @return	associative response array from Twilio
     */
    public function send($receiver_phone, $message)
    {
	// Instantiate a new Twilio Rest Client
	$client = new TwilioRestClient($this->accountSid, $this->authToken);

	$response = $client->request("/".$this->apiVersion."/Accounts/".$this->accountSid."/SMS/Messages", 
		"POST", array(
		"To" => $receiver_phone,
		"From" => $this->senderPhone,
		"Body" => $message
		));
		
        return $response;
    }
} 
