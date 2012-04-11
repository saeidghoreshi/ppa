<?php
/**
 * Beanstream Payment Gateway Library
 * 
 * Performs Beanstream Payment Transaction API and User Profile API Calls
 *
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 * @filesource
 */

if( !defined('BASEPATH') )
    exit('No direct script access allowed');
    
class Beanstream_gateway extends Ppa_gateway
{
    var $CI = null; 
    var $merchant_id;
    var $api_url;
    var $profile_passcode;
    var $profile_url;
    var $hashValue;
    var $transaction_user;
    var $transaction_pwd;

    function __construct()
    {
        if (function_exists('get_instance'))
        {
            $this->CI = & get_instance();
            $config =& get_config();
        }
        else
        {
            require_once('system/application/config/config.php');
        }
        // Load Beanstream Config
        $this->merchant_id = $config['beanstream_merchant_id'];
        $this->api_url = $config['beanstream_api_url'];
        $this->profile_passcode = $config['beanstream_profile_passcode'];
        $this->profile_url = $config['beanstream_profile_url'];
        $this->hash_value = $config['beanstream_hash_value'];
        $this->transaction_user = $config['beanstream_transaction_user'];
        $this->transaction_pwd = $config['beanstream_transaction_pwd'];
    }

    /**
     * Beanstream CC and Direct Payment/ACH Transaction Push Call
     *
     * @access	public
     * @param   string $orderNumber
     * @param   string $amount
     * @param   string $customerCode
     * @param   string $cardOwner
     * @param   string $cardNumber
     * @param   string $expMonth
     * @param   string $expYear
     * @param   string $cardCVV
     * @param   string $email
     * @param   string $name
     * @param   string $phone
     * @param   string $address1
     * @param   string $address2
     * @param   string $city
     * @param   string $provinceCode
     * @param   string $postalCode
     * @param   string $countryCode
     * @return	associative response array from Beanstream
     */
    public function push($orderNumber, $amount, $customerCode = null, $cardOwner = null, $cardNumber = null, 
            $expMonth = null, $expYear = null, $cardCVV = null, $email = null, $name = null, $phone = null,
            $address1 = null, $address2 = null, $city = null, $provinceCode = null, $postalCode = null, $countryCode = null,
            $bankAccountType = null, $institutionID = null, $branchNumber = null, $routingNumber = null, $accountNumber = null, $trnType = null, $transitNumber = null)
    {

        if( !empty($customerCode) )
        {
        
        $options = array(
            'requestType'=>'BACKEND',
            'merchant_id'=>$this->merchant_id,
    
            'trnOrderNumber'=>intval($orderNumber),
            'trnAmount'=>$amount,
            'customerCode'=>$customerCode,
            
            'username'=>$this->transaction_user,
            'password'=>$this->transaction_pwd

        );
            
        }
        else 
        {
        
        $options = array(
            'requestType'=>'BACKEND',
            'merchant_id'=>$this->merchant_id,
    
            'trnOrderNumber'=>intval($orderNumber),
            'trnAmount'=>$amount,
            'trnCardOwner'=>$cardOwner,
            'trnCardNumber'=>$cardNumber,
            'trnExpMonth'=>$expMonth,
            'trnExpYear'=>$expYear,
            'trnCardCvd'=>$cardCVV,
            
            'bankAccountType'=>$bankAccountType, //For EBP/ACH
            'institutionID'=>$institutionID, //For EBP Only
            'branchNumber'=>$branchNumber, //For EBP Only
            'routingNumber'=>$routingNumber, //For ACH Only
            'accountNumber'=>$accountNumber, //For EBP/ACH Only
            'transitNumber'=>$transitNumber, //
            'trnType'=>$trnType, // D=Debit an outside bank account (receive money in your own account) C=Credit an outside bank account (pay from your own account) VD=Void Debit VC=Void Credit
            
            'ordEmailAddress'=>(empty($email)?intval($customerCode).'@payphoneapp.com':$email),
            'ordName'=>$name,
            'ordPhoneNumber'=>$phone,
            'ordAddress1'=>$address1,
            'ordAddress2'=>$address2,
            'ordCity'=>$city,
            'ordProvince'=>$provinceCode,
            'ordPostalCode'=>$postalCode,
            'ordCountry'=>$countryCode,
            
            'username'=>$this->transaction_user,
            'password'=>$this->transaction_pwd
        );
        }
        
        return $this->__process($options);
    }
    
    /**
     * Beanstream User Profile Pull Call
     *
     * @access	public
     * @param	string $customerCode
     * @param	string $trnOrderNumber
     * @return	associative User Profile array from Beanstream
     */
    // Beanstream Profile Push Call
    public function profile_pull($customerCode,$trnOrderNumber = null)
    {
        $options = array(
            'serviceVersion'=>'1',
            'merchantId'=>$this->merchant_id,
            'operationType'=>'Q',
            'customerCode'=>$customerCode,
            'responseFormat'=>'QS',
            'passCode'=>$this->profile_passcode,
            'trnOrderNumber'=>$trnOrderNumber
        );
        
        return $this->__process($options,$this->profile_url);
        
        
    }
    
    /**
     * Beanstream User Profile Push Call
     *
     * @access	public
     * @param	string $email
     * @param	string $password
     * @param	string $customerCode
     * @param	string $status
     * @param	string $operationType
     * @param	string $orderNumber
     * @param	string $cardOwner
     * @param	string $cardNumber
     * @param	string $expMonth
     * @param	string $expYear
     * @param	string $bankAccountType
     * @param	string $institutionID
     * @param	string $branchNumber
     * @param	string $routingNumber
     * @param	string $accountNumber
     * @param	string $name
     * @param	string $address1
     * @param	string $address2
     * @param	string $city
     * @param	string $provinceCode
     * @param	string $postalCode
     * @param	string $countryCode
     * @param	string $phone
     * @param	string $email
     * @param	string $velocityIdentity
     * @param	string $statusIdentity = null
     * @return	associative response array from Beanstream
     */
    public function profile_push($customerCode = null, $status = null,
            $operationType = null, $orderNumber = null, $cardOwner = null, $cardNumber = null, $expMonth = null, $expYear = null,
            $bankAccountType = null, $institutionID = null, $branchNumber = null, $routingNumber = null, $accountNumber = null,
            $name = null, $address1 = null, $address2 = null, $city = null, $provinceCode = null, $postalCode = null, $countryCode = null,
            $phone = null, $email = null, $velocityIdentity = '1', $statusIdentity = null, $transitNumber = null)
    {
        $options = array(
            
            'serviceVersion'=>'1',
            'merchantId'=>$this->merchant_id,
            'passCode'=>$this->profile_passcode,
            'responseFormat'=>'QS',
            'trnLanguage'=>'ENG',
            
            'operationType'=>$operationType, //N_ew,M_odify
            
            'status'=>$status, // A_ctive,D_isabled,C_losed
            'customerCode'=>$customerCode,
            'trnOrderNumber'=>$orderNumber,
            'trnCardOwner'=>$cardOwner,
            'trnCardNumber'=>$cardNumber,
            'trnExpMonth'=>$expMonth,
            'trnExpYear'=>$expYear,
            
            /*'bankAccountType'=>$bankAccountType, //For EBP/ACH
              'branchNumber'=>$branchNumber, //For EBP Only*/
            'ref1'=>$institutionID, //For EBP Only
            'ref2'=>$transitNumber, //For EBP/ACH Only
            'ref3'=>$accountNumber, //For EBP/ACH Only
            'ref4'=>$routingNumber, //For ACH Only
            
            'ordName'=>$name,
            'ordAddress1'=>$address1,
            'ordAddress2'=>$address2,
            'ordCity'=>$city,
            'ordProvince'=>$provinceCode,
            'ordPostalCode'=>$postalCode,
            'ordCountry'=>$countryCode,
            'ordEmailAddress'=>(empty($email)?intval($customerCode).'@payphoneapp.com':$email),
            'ordPhoneNumber'=>$phone,
            'velocityIdentity'=>$velocityIdentity,
            'statusIdentity'=>$statusIdentity
            
        );
        
        return $this->__process($options,$this->profile_url);
    }
    
    /**
     * Generic Beanstream service call function
     *
     * @access	private
     * @param	array   $options
     * @param	string  $url
     * @return	associative response array from Beanstream
     */
    protected function __process($options, $url=null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // Transaction API service url by default
        curl_setopt($ch, CURLOPT_URL, empty($url)?$this->api_url:$url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $options ));
        //echo http_build_query( $options );// post debug
	//curl_setopt($ch, CURLOPT_HEADER, true); // DEBUG Display headers
	//curl_setopt($ch, CURLOPT_VERBOSE, true); // DEBUG Display communication with server
        
        $txResult = curl_exec($ch);
        curl_close($ch); 
        $response = array();
        // prepare call response array
        parse_str($txResult, $response);
        //echo var_dump($response);// response debug

        return $response;
    }
} 
