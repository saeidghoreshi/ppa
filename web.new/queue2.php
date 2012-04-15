<?php
/*
todo: check input varaibles: transaction_id, user_enabled, logged_in
check access restrictions
*/

//error_reporting(0);

error_reporting(E_ERROR | E_PARSE);

date_default_timezone_set("America/Los_Angeles");
setlocale(LC_MONETARY, 'en_US');

session_start();
//setcookie("PHPSESSID",$_COOKIE['PHPSESSID'],time()+60*60*24, '/'); 

$action = '';
if( !empty($_GET['transaction_id'])  ) {
   if( empty($_GET['phone']) ) {
	$action = 'PSR';
	$request_id = $_GET['transaction_id'];
	$recepient_id = intval($_SESSION['user_phone']);
    }
    else {
	$action = 'PSS';
	$request_id = $_GET['transaction_id'];
	$recepient_id = intval($_GET['phone']);
    }
    //$sender_id = intval($_SESSION['user_id']);
}
elseif( !empty($_GET['request_type']) ) {
    $action = $_GET['request_type'];
    if( in_array( $action, array('PLR') ) ) {
	$recepient_id = intval($_SESSION['user_phone']);
    }
}
elseif( !empty($_POST['request_type']) ) {
    $action = $_POST['request_type'];
    if( in_array( $action, array('PR', 'PSS','PCS') ) ) {
	$request_id = $_POST['transaction_id'];
	$recepient_id = intval($_POST['phone']);
	$sender_id = intval($_SESSION['user_id']);
    }
    elseif( in_array( $action, array('PSR', 'PPR', 'PCR', 'PLR') ) ) {
	if( !empty($_POST['transaction_id']) ) $request_id = $_POST['transaction_id'];
	$recepient_id = intval($_SESSION['user_phone']);
    }
    else {json_response( $in, $status_code='512', $status_msg='Incomlete Request' ); exit;}

}

$server_name = 'ppa0';
//$request_id = '20110310131548264';
$user_phone = $_POST['phone'];
$request_amount = $_POST['amount'];
$request_location_verification = false;
$request_cancelled = false;
$request_paid = false;
$request_date_paid = false;


$in['recepient_id'] = $recepient_id;
if( !empty($sender_id) ) $in['sender_id'] = $sender_id;
$in['amount'] = money_format('%!i',floatval($request_amount));
if( isset($_POST['tips'])) $in['tips'] = round(floatval($_POST['tips']),2);
else $in['tips'] = round(floatval($in['tips'])/10,2);
if( !isset($_POST['tips'])) $in['tips'] = round(floatval($in['tips'])/10,2);
$in['parameters'] = $parameters;

// user GEO
if( isset($_POST['latitude'])) $in['latitude'] = $_POST['latitude'];
if( isset($_POST['longitude'])) $in['longitude'] = $_POST['longitude'];
if( isset($_POST['geots'])) $in['geots'] = $_POST['geots'];

// merchant GEO
if( isset($_SESSION['latitude'])) $in['latitude'] = $_SESSION['latitude'];
if( isset($_SESSION['longitude'])) $in['longitude'] = $_SESSION['longitude'];


$in['transaction_id'] = $request_id;


if( empty($_SESSION) || empty($_SESSION['user_id']) ) {json_response( $in, $status_code='401', $status_msg='Unauthorized' ); exit;}

if( !empty($action) ) {
//echo var_dump($_POST);

switch($action)
{
    case 'PR':
      // Payment Request - Sender
      //echo 'request:PR';
//echo $in['transaction_id'].'_';
      $in['merchant_name'] = $_SESSION['merchant_name'];
      $in['merchant_id'] = $_SESSION['merchant_id'];
      $in['merchant_address'] = $_SESSION['merchant_address'];
      $response = payment_request($in);
//echo $response['transaction_id'].'_';
      $in = array_merge($in,$response);
//echo $in['transaction_id'];
//echo var_dump($in);
      if( !$response['status'] ) {json_response( $response, $status_code='501', $status_msg=$response['msg'] ); exit;}
      else json_response( $in );
      //else json_response( array('status'=>$response['status'],'transaction_id'=>$response['transaction_id']), $status_code='200', $status_msg='OK' );
      //else json_response( array('status'=>'0','transaction_id'=>$response['transaction_id']), $status_code='500', $status_msg=$response['msg'] );
      //else json_encode( array('status'=>'0','transaction_id'=>$response['transaction_id']) );
      /*
      $request_id = $response['transaction_id'];
      json_response( array('status'=>'0','transaction_id'=>$response['transaction_id']), $status_code='200', $status_msg='OK' );
      header("Status: 500 Failed");
      json_encode( array('status'=>'0','transaction_id'=>$response['transaction_id']) )
      */
      break;  
    case 'PSR':
      // Payment Status - Recepient
      //echo 'request:PSR';
      $response = payment_status($in);
      if( !$response['status'] ) {json_response( $response, $status_code='502', $status_msg=$response['msg'] ); exit;}
      $in = array_merge($in,$response);
      $in['recepient_received'] = true;
      $response = payment_update($in,$mode='recepient');
      if( !$response['status'] ) {json_response( $response, $status_code='503', $status_msg=$response['msg'] ); exit;}
      else json_response( $in );
      break;  
    case 'PLR':
      // Payment List - Recepient
      $response = payment_list($in);
      if( !$response['status'] ) {json_response( $response, $status_code='525', $status_msg=$response['msg'] ); exit;}
      $in = array_merge($in,$response);
      json_response( $in );
      break;  
    case 'PSS':
      // Payment Status - Sender
      //echo 'request:PSS';
      $in = payment_status($in);
      //var_dump($in);
      if( !$in['status'] ) json_response( $in, $status_code='200', $status_msg=$in['msg'] );
      else json_response( $in );
      $in['sender_notified'] = true;
      $in = payment_update($in,$mode='sender');
      //if( !$in['status'] ) exit('ERROR:' . $in['msg']);
      break;  
    case 'PPR':
      // Payment Pay - Recepient
      $response = payment_status($in);
      if( !$response['status'] ) {json_response( $response, $status_code='505', $status_msg=$response['msg'].'1' ); exit;}
      $in = array_merge($in,$response);
      if( isset($_POST['tips']) ) $in['tips'] = round(floatval($_POST['tips']),2);
      if( isset($_POST['account_type']) ) $in['account_type'] = intval($_POST['account_type']);
      if( isset($_POST['recepient_latitude']) ) $in['recepient_latitude'] = $_POST['recepient_latitude'];
      if( isset($_POST['recepient_longitude']) ) $in['recepient_longitude'] = $_POST['recepient_longitude'];
      $in['account_id'] = $_POST['account_id'];
      if( $in['sender_cancelled'] && $in['recepient_cancelled'] ) {json_response( $response, $status_code='506', 'Transaction has been already cancelled' ); exit;}
      $in['recepient_received'] = true;
      $in['sender_notified'] = false;
      if( $in['recepient_paid'] ) {json_response( $response, $status_code='507', $status_msg = 'Transaction has been already approved' ); exit;}
      if( empty($in['account_id']) ) {json_response( $in, $status_code='200', $status_msg = 'Select Payment option' ); exit;}
      if( intval($in['distance']) > 300 )  {json_response( $in, $status_code='508', $status_msg = 'Merchant is too far form you - '.$in['distance'].'m' ); exit;}
      if( isset($_POST['pin']) ) $in['pin'] = $_POST['pin'];
      if( !payment_persist($in,$mode='pin_check') ) {json_response( $in, $status_code='200', $status_msg = 'PIN incorrect' ); exit;}
      // todo: set proper account_id
      $in['trnOrderNumber'] = intval($in['transaction_id']);
      $in['trnAmount'] = floatval($in['amount']);
      $in['customerCode'] = $in['account_id'];
      if( !empty($in['account_type']) && $in['account_type'] > 10 ) {
          // Gift Card Payment
          if( payment_persist($in,$mode='gc_update') ) {
            $ret['status'] = 'OK';
          }
          else {
            $ret = array('status'=>'Error', 'msg'=>'GC Payment did not go through');
          }
      }
      if( !empty($in['account_type']) && $in['account_type'] == 9 ) {
          // Paypal
			$ret = paypal_push($in);
            //$ret['status'] = 'OK';
      }
      else {
          // Regular CC Payment
          $ret = payment_push($in);
      }
      //echo print_r($ret);
      if( $ret['status'] != 'OK' ) {json_response( $response, $status_code='500', $status_msg = $ret['msg'] ); exit;}
      // todo: tips
      if( !payment_persist($in, $mode='pay') ) {json_response( $response, $status_code='515', $status_msg = 'Payment was not saved to database' ); exit;}
      $in['recepient_paid'] = true;
      $in['db_saved'] = true;
      $response = payment_update($in,$mode='recepient');
      if( !$response['status'] ) {json_response( $response, $status_code='508', $status_msg=$response['msg'] ); exit;}
      else json_response( $in );
      break;  
    case 'PCR':
      // Payment Cancel - Recepient
      $response = payment_status($in);
      if( !$response['status'] ) {json_response( $response, $status_code='509', $status_msg=$response['msg'] ); exit;}
      $in = array_merge($in,$response);
      if( $in['recepient_paid'] ) json_response( $response, $status_code='510', $status_msg = 'Transaction has been already approved' );
      $in['recepient_received'] = true;
      $in['sender_notified'] = false;
      $in['recepient_cancelled'] = true;
      $in['transaction_cancelled_reason'] = 'Recepient Cancelled';
      if( isset($_POST['recepient_latitude']) ) $in['recepient_latitude'] = $_POST['recepient_latitude'];
      if( isset($_POST['recepient_longitude']) ) $in['recepient_longitude'] = $_POST['recepient_longitude'];
      if( !payment_persist($in, $mode='cancel') ) {json_response( $response, $status_code='515', $status_msg = 'Payment was not saved to database' ); exit;}
      $in['db_saved'] = true;
      $response = payment_update($in,$mode='recepient');
      if( !$response['status'] ) {json_response( $response, $status_code='511', $status_msg=$response['msg'] ); exit;}
      else json_response( $in );
      break;  
    case 'PCS':
      // Payment Cancel - Sender
      $response = payment_status($in);
      if( !$response['status'] ) {json_response( $response, $status_code='512', $status_msg=$response['msg'] ); exit;}
      $in = array_merge($in,$response);
      if( $in['recepient_paid'] ) {json_response( $response, $status_code='513', $status_msg='Transaction has been already approved' ); exit;}
      $in['recepient_received'] = false;
      $in['sender_notified'] = true;
      $in['sender_cancelled'] = true;
      $in['transaction_cancelled_reason'] = 'Sender Cancelled';
      if( isset($_POST['recepient_latitude']) ) $in['recepient_latitude'] = $_POST['recepient_latitude'];
      if( isset($_POST['recepient_longitude']) ) $in['recepient_longitude'] = $_POST['recepient_longitude'];
      if( !payment_persist($in, $mode='cancel') ) {json_response( $response, $status_code='515', $status_msg = 'Payment was not saved to database' ); exit;}
      $in['db_saved'] = true;
      $response = payment_update($in,$mode='sender');
      if( !$response['status'] ) {json_response( $response, $status_code='514', $status_msg=$response['msg'] ); exit;}
      else json_response( $in );
      break;  
    default:
}

}
else {

//echo json_response( array('status'=>false), $status_code='500', $status_msg='empty request' );
//echo json_response( array('status'=>true) );
//echo var_dump($_POST);

}
exit;

?>



<?php

  function paypal_push($in,$mode='')
  {
      if(empty($in['trnOrderNumber']) || empty($in['trnAmount']) || empty($in['customerCode']))
      {
            return array('status'=>'Error','msg'=>'Make sure all payment transaction parameters(trnOrderNumber, trnAmount, customerCode) provided');
      }
	  
	  require_once 'system/application/libraries/paypal/AdaptiveAccounts.php';
	  require_once 'system/application/libraries/paypal/Stub/AA/AdaptiveAccountsProxy.php';
	  require_once 'system/application/libraries/paypal/AdaptivePayments.php';
	  
			try {
		           $returnURL = "http://www.payphoneapp.com/PaymentDetails.php";
		           $cancelURL = "http://www.payphoneapp.com/SetPay.php";
		           $currencyCode='CAD';
		           $email='ddvinyaninov2@gmail.com';
				   $preapprovalKey = 'PA-0K511738XC6922641';	
		           $receiverEmail='noah2@payphoneapp.com';
		           $amount=$in['trnAmount'];
				   
		            $payRequest = new PayRequest();
		            $payRequest->actionType = "PAY";
					$payRequest->cancelUrl = $cancelURL ;
					$payRequest->returnUrl = $returnURL;
					$payRequest->clientDetails = new ClientDetailsType();
					$payRequest->clientDetails->applicationId ="APP-1JE4291016473214C";
		           	$payRequest->clientDetails->deviceId = DEVICE_ID;
		           	$payRequest->clientDetails->ipAddress = "127.0.0.1";
		           	$payRequest->currencyCode = $currencyCode;
		           	$payRequest->senderEmail = $email;
		           	$payRequest->requestEnvelope = new RequestEnvelope();
		           	$payRequest->requestEnvelope->errorLanguage = "en_US";
		           	if($preapprovalKey != "")
		           	{
		           		$payRequest->preapprovalKey = $preapprovalKey ;
		           	}          	
		           	$receiver1 = new receiver();
		           	$receiver1->email = $receiverEmail;
		           	$receiver1->amount = $amount;

					$payRequest->receiverList = new ReceiverList();
		           	$payRequest->receiverList = array($receiver1);
		           	
		           $ap = new AdaptivePayments();
		           $response=$ap->Pay($payRequest);
		           
		           if(strtoupper($ap->isSuccess) == 'FAILURE')
					{
						$_SESSION['FAULTMSG']=$ap->getLastError();
						$location = "APIError.php";
						//header("Location: $location");
						return array('status'=>'Error','msg'=>$ap->getLastError()->error->message);
					}
					else
					{
						$_SESSION['payKey'] = $response->payKey;
						if($response->paymentExecStatus == "COMPLETED")
						{
							$location = "PaymentDetails.php";
							//header("Location: $location");
							return array('status'=>'OK');
						}
						else
						{
							$token = $response->payKey;
							$payPalURL = PAYPAL_REDIRECT_URL.'_ap-payment&paykey='.$token;
		                    //header("Location: ".$payPalURL);
							return array('status'=>'Error','msg'=>'paymentExecStatus is not COMPLETED');
						}
					}
			}
			catch(Exception $ex) {
				
				$fault = new FaultMessage();
				$errorData = new ErrorData();
				$errorData->errorId = $ex->getFile() ;
  				$errorData->message = $ex->getMessage();
		  		$fault->error = $errorData;
				$_SESSION['FAULTMSG']=$fault;
				$location = "APIError.php";
				//header("Location: $location");
				return array('status'=>'Error','msg'=>'paypal error2');
			}
  }

  function payment_push($in,$mode='')
  {
      if(empty($in['trnOrderNumber']) || empty($in['trnAmount']) || empty($in['customerCode']))
      {
            return array('status'=>'Error','msg'=>'Make sure all payment transaction parameters(trnOrderNumber, trnAmount, customerCode) provided');
      }
      define('BASEPATH','1');
      require_once 'system/application/libraries/Ppa_gateway.php';
      require_once 'system/application/libraries/Beanstream_gateway.php';
      $beanstream_gateway = new Beanstream_gateway();
      $response = $beanstream_gateway->push($in['trnOrderNumber'], $in['trnAmount'], $in['customerCode']);
      //echo var_dump($response);
      if( !empty($response) && isset($response['trnApproved'])  )
      {
        if( $response['trnApproved'] == 1  )
        {
            return array('status'=>'OK');
        }
        else 
        {
            return array('status'=>'Error','msg'=>strip_tags($response['messageText']));
        }
      }
      else
      {
        return array('status'=>'Error','msg'=>'Payment Gateway response is empty');
      }
      
  }

  function json_response($data, $status_code='200', $status_msg='OK')
  {
      $data['msg'] = $status_msg;
      header($_SERVER["SERVER_PROTOCOL"]." $status_code $status_msg");
      header("Status: $status_code $status_msg");
      echo json_encode( $data );
  }

  function payment_persist($in,$mode='')
  {
    switch($mode)
    {
	case 'pin_check':
            // TODO: add user check
            $sql = "SELECT account_id FROM account WHERE account_id = '".intval($in['account_id'])."' AND account_enabled = 1 AND account_security_pin = '".mysql_real_escape_string($in['pin'])."' LIMIT 1";
            //echo $sql;
            break;
	case 'gc_update':
	    if( !empty($in['transaction_id']) && !empty($in['recepient_id']) && !empty($in['sender_id']) 
	    && !empty($in['account_id']) && !empty($in['transaction_datetime_requested']) )
	    {
                
$sql = "UPDATE  user sender 
INNER JOIN user recepient ON ( sender.user_id = '".intval($in['sender_id'])."' AND recepient.user_phone = '".intval($in['recepient_id'])."')
INNER JOIN account ON (recepient.user_id = account.user_id)
INNER JOIN accounttype ON account.account_type = accounttype.accounttype_id
SET account.account_balance = (account.account_balance - '".(floatval($in['amount'])+floatval($in['tips']))."')
WHERE 1 AND account.account_id = '".intval($in['account_id'])."'
AND accounttype.merchant_id = '".intval($in['merchant_id'])."' AND account.account_balance >= '".(floatval($in['amount'])+floatval($in['tips']))."'";
//echo $sql;
	    }
	    break;
	case 'pay':
	    if( !empty($in['transaction_id']) && !empty($in['recepient_id']) && !empty($in['sender_id']) 
	    && !empty($in['account_id']) && !empty($in['transaction_datetime_requested']) )
	    {
$sql = "INSERT INTO transaction
(transaction_id, merchant_id, user_id, account_id, transaction_amount, transaction_tips,
transaction_merchant_note, transaction_user_note, transaction_paid, transaction_cancelled, transaction_flagged,
transaction_cancelled_reason, transaction_deleted, transaction_datetime_requested, transaction_datetime_paid, transaction_location, transaction_latitude, transaction_longitude)
SELECT '".intval($in['transaction_id'])."' AS transaction_id, sender.merchant_id AS merchant_id, recepient.user_id AS user_id, account.account_id AS account_id, '".(floatval($in['amount'])+floatval($in['tips']))."' AS transaction_amount, '".floatval($in['tips'])."' AS transaction_tips,
'' AS transaction_merchant_note, '' AS transaction_user_note, '1' AS transaction_paid, '0' AS transaction_cancelled, '0' AS transaction_flagged,
'' AS transaction_cancelled_reason, '0' AS transaction_deleted, '".mysql_real_escape_string($in['transaction_datetime_requested'])."' AS transaction_datetime_requested, NOW() AS transaction_datetime_paid, '".intval($in['recepient_location'])."' AS transaction_location,
'".floatval($in['recepient_latitude'])."' AS recepient_latitude, '".floatval($in['recepient_longitude'])."' AS recepient_longitude
FROM user sender 
INNER JOIN user recepient ON ( sender.user_id = '".intval($in['sender_id'])."' AND recepient.user_phone = '".intval($in['recepient_id'])."')
INNER JOIN account ON (recepient.user_id = account.user_id)
WHERE 1 AND account.account_id = '".intval($in['account_id'])."' LIMIT 1";
//echo $sql;
	    }
	    break;
	case 'cancel':
	    if( !empty($in['transaction_id']) && !empty($in['recepient_id']) && !empty($in['sender_id']) 
	    && !empty($in['transaction_datetime_requested']) )
	    {
$sql = "REPLACE INTO request
(transaction_id, merchant_id, user_id, account_id, transaction_amount, transaction_tips,
transaction_merchant_note, transaction_user_note, transaction_paid, transaction_cancelled, transaction_flagged,
transaction_cancelled_reason, transaction_deleted, transaction_datetime_requested, transaction_datetime_paid, transaction_location, transaction_latitude, transaction_longitude)
SELECT '".intval($in['transaction_id'])."' AS transaction_id, sender.merchant_id AS merchant_id, recepient.user_id AS user_id, '".intval($in['account_id'])."' AS account_id, '".(floatval($in['amount'])+floatval($in['tips']))."' AS transaction_amount, '".floatval($in['tips'])."' AS transaction_tips,
'' AS transaction_merchant_note, '' AS transaction_user_note, '0' AS transaction_paid, '1' AS transaction_cancelled, '0' AS transaction_flagged,
'".$in['transaction_cancelled_reason']."' AS transaction_cancelled_reason, '0' AS transaction_deleted, '".mysql_real_escape_string($in['transaction_datetime_requested'])."' AS transaction_datetime_requested, NOW() AS transaction_datetime_paid, '".intval($in['recepient_location'])."' AS transaction_location,
'".floatval($in['recepient_latitude'])."' AS recepient_latitude, '".floatval($in['recepient_longitude'])."' AS recepient_longitude
FROM user sender 
INNER JOIN user recepient ON ( sender.user_id = '".intval($in['sender_id'])."' AND recepient.user_phone = '".intval($in['recepient_id'])."')
WHERE 1  LIMIT 1";
//echo $sql;
	    break;
	    }
    }

    if( !empty($sql) ) 
    {
	define('BASEPATH','1');
	require_once('system/application/config/database.php');
	
	$db['default']['hostname'] = "localhost";

	$db['default']['username'] = "v2";                                                                                              
	$db['default']['password'] = "v2_goifjielg943";                                                                                 
	$db['default']['database'] = "v2";
	
	//$db['default']['username'] = "ppatestv2";
	//$db['default']['password'] = "ppatestv2_H54f3j";
	//$db['default']['database'] = "ppatestv2";

	$link = mysql_connect($db['default']['hostname'], $db['default']['username'], $db['default']['password']);
	if (!$link)
	{
	    echo('Could not connect: ' . mysql_error());
	    return false;
	}
	if (!mysql_select_db($db['default']['database']))
	{
    	    echo('Could not select database: ' . mysql_error());
	    return false;
        }
        $result = mysql_query($sql);
        if (!$result)
        {
            echo('Could not query:' . mysql_error());
            mysql_close($link);
	    return false;
	}
	if( ($mode == 'pin_check' && mysql_num_rows($result) == 1)  || (( $mode == 'gc_update' || mysql_insert_id($link) > 0) && mysql_affected_rows($link) == 1 ) )
	{
	    //todo: check number of rows
            mysql_close($link);
	    return true;
	}
        mysql_close($link);
	return false;
    }
    
    return false;
  }

  function fetch($key) 
  {
    global $server_name;
    return apc_fetch($server_name.'_'.$key);
  }
  
  function store($key,$data,$ttl=300) 
  {
    global $server_name;
    return apc_store($server_name.'_'.$key,$data,$ttl);
  }

  function delete($key) 
  {
    global $server_name;
    return apc_delete($server_name.'_'.$key);
  }

  function clear($key) 
  {
    global $server_name;
    return apc_clear_cache($server_name.'_'.$key);
  }

  function generateTransactionId()
  {
    // todo - uniq id check
    //$ret = (string)intval(date('YmdHis')*1000+rand(100,900));
    //$ret = round(microtime()/1000)*1000+rand(100,700);
    //2147483647
    //1300300259.5972
    $ret = round(microtime(true));
    //$ret = microtime(true);
    return $ret;
  }

  function payment_status($in)
  {
    $recepient_id = $in['recepient_id'];
    $sender_id = $in['sender_id'];
    $transaction_id = $in['transaction_id'];
    $msg = fetch($recepient_id);
    // todo: sender_id check
    if( empty($msg) || empty($msg[$transaction_id]) || $msg[$transaction_id]['msg_type'] != 'PR')
    {
        return array('status'=>false,'msg'=>'Payment Request Queue Message #'.$transaction_id.' for User '.$recepient_id.' Does not Exist');
    }
    return array_merge($msg[$transaction_id], array('status'=>true));
  }
  
  function payment_list($in)
  {
    $recepient_id = $in['recepient_id'];
    $msg = fetch($recepient_id);
    if( !empty($msg) && count($msg) > 0 )
    {
	foreach($msg AS $request)
	{
	    if( !$request['sender_cancelled'] && !$request['recepient_cancelled'] && !$request['recepient_paid']
	    && !empty($request['transaction_id']) 
	    && !empty($request['sender_id']) 
	    && !empty($request['transaction_datetime_requested']) )
	    {
		$transactions[] = $request['transaction_id'];
	    }
//	    echo $request['transaction_id'];
	}
	return array('status'=>true,'transactions'=>$transactions);
    }
    return array('status'=>true,'transactions'=>array());
  }
  
  function payment_update($in,$mode='unknown')
  {
    $recepient_id = $in['recepient_id'];
    $sender_id = $in['sender_id'];
    $transaction_id = $in['transaction_id'];
    //echo $transaction_id.'_1_';
    $msg = fetch($recepient_id);
    //20110316111928326
    //2147483647
    //20110123
    //echo var_dump($msg[$transaction_id]);
    if( empty($msg) || empty($msg[$transaction_id]) || ($msg[$transaction_id]['msg_type'] != 'PR') )
    {
        return array('status'=>false,'msg'=>'Payment Request Queue Message Does not Exist');
    }
    switch($mode) {
      case 'sender':
        if( isset($in['sender_notified']) ) $msg[$transaction_id]['sender_notified'] = $in['sender_notified'];
        if( isset($in['sender_cancelled']) ) $msg[$transaction_id]['sender_cancelled'] = $in['sender_cancelled'];
        if( isset($in['recepient_received']) ) $msg[$transaction_id]['recepient_received'] = $in['recepient_received'];
        break;
      case 'recepient':
        if( isset($in['recepient_received']) ) $msg[$transaction_id]['recepient_received'] = $in['recepient_received'];
        if( isset($in['recepient_paid']) ) $msg[$transaction_id]['recepient_paid'] = $in['recepient_paid'];
        if( isset($in['recepient_cancelled']) ) $msg[$transaction_id]['recepient_cancelled'] = $in['recepient_cancelled'];
        if( isset($in['tips']) ) $msg[$transaction_id]['tips'] = $in['tips'];
        if( isset($in['sender_notified']) ) $msg[$transaction_id]['sender_notified'] = $in['sender_notified'];
        if( isset($in['latitude']) ) $msg[$transaction_id]['recepient_latitude'] = $in['latitude'];
        if( isset($in['longitude']) ) $msg[$transaction_id]['recepient_longitude'] = $in['longitude'];
        if( isset($in['geots']) ) $msg[$transaction_id]['recepient_geots'] = $in['geots'];
        if( !empty($msg[$transaction_id]['recepient_latitude']) && !empty($msg[$transaction_id]['recepient_longitude']) && !empty($msg[$transaction_id]['sender_latitude']) && !empty($msg[$transaction_id]['sender_longitude']) ) {
            $msg[$transaction_id]['distance'] = distance($msg[$transaction_id]['recepient_latitude'], $msg[$transaction_id]['recepient_longitude'], $msg[$transaction_id]['sender_latitude'], $msg[$transaction_id]['sender_longitude']);
        }
        break;
      default:
    }
    //
    if( !store( $key = $recepient_id, $data = $msg, $ttl = 300) )
    {
      // try saving again
      if( !store( $key = $recepient_id, $data = $msg, $ttl = 300) )
      {
        return array('status'=>false,'msg'=>'Payment Queue Message Saving Failed');
      }
    }
    return array('status'=>true,'msg'=>'Payment Status Updated');
  }

  function payment_request($in)
  {
    $recepient_id = $in['recepient_id'];
    $sender_id = $in['sender_id'];
    $amount = money_format('%!i',doubleval($in['amount']));
    $tips = round($in['tips'],2);
    $parameters = $in['parameters'];
    $merchant_name = $in['merchant_name'];
    $merchant_id = $in['merchant_id'];
    $merchant_address = $in['merchant_address'];
    $transaction_id = generateTransactionId();
    $msg = fetch($recepient_id);
    if( empty($msg) )
    {
      $msg = array();
    }
	else 
	{
		// cancel pending transactions
		foreach( $msg AS $msg_id=>$msg_request )
		{
			if( !$msg_request['sender_cancelled'] )
			{
				$msg_request['sender_cancelled'] = true;
				$msg[$msg_id] = $msg_request;
			}
		}
	}
    while( !empty($msg[$transaction_id]) )
    {
      // todo: transaction_id unique check
      $transaction_id++;
    }
    // PR = Payment Request
    $msg[$transaction_id] = array('transaction_id'=>$transaction_id,'sender_id'=>$sender_id, 'recepient_received'=>false, 'sender_notified'=>true, 
	    'recepient_cancelled'=>false, 'sender_cancelled'=>false, 'db_saved'=>false, 'msg_type'=>'PR', 
	    'recepient_paid'=>false, 'amount'=>$amount, 'tips'=>doubleval($tips), 'sender_location'=>true, 'recepient_location'=>true, 
            'merchant_name'=>$merchant_name, 'merchant_address'=>$merchant_address, 'merchant_id'=>$merchant_id,
	    'parameters' => $parameters, 'transaction_datetime_requested' => date("Y-m-d H:i:s"));
    if( isset($in['latitude']) ) $msg[$transaction_id]['sender_latitude'] = $in['latitude'];
    if( isset($in['longitude']) ) $msg[$transaction_id]['sender_longitude'] = $in['longitude'];
    if( !store( $key = $recepient_id, $data = $msg, $ttl = 300) )
    {
      // try saving again
      if( !store( $key = $recepient_id, $data = $msg, $ttl = 300) )
      {
        return array('status'=>false,'msg'=>'Payment Queue Message Saving Failed');
      }
    }
//echo 'transaction_id3:'.$transaction_id;
//    $msg = fetch($recepient_id);
    return array('status'=>true,'transaction_id'=>$transaction_id);
  }

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
  

?>
