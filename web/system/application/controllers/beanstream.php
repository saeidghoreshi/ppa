<?php
/**
 * Beanstream Example Controller
 * 
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 * @filesource          system/application/controllers/beanstream.php
 */

//require_once(APPPATH . 'libraries/Ppa_controller.php');

class Beanstream extends Ppa_controller {
    
    var $json = false;

    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->check_login_redirect();
    }

    function Beanstream()
    {
        //$this->CI->load->model('account_model');
        //$this->CI->account_model->get_by_user($user[USER_ID]);
        //echo '123';
    }

    function index()
    {

        $this->load->model('user_model');
        $this->load->model('account_model');

        $this->cismarty->assign('accounts', $this->account_model->get_by_user_id());

        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'beanstream/transaction');
    }

    function profile($action='view', $id=null)
    {
        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->library('Ppa_gateway');
        $this->load->library('Beanstream_gateway');
        $accounts = $this->account_model->get_by_user_id($user_id = null, $account_enabled = array(0, 1));
        foreach ($accounts AS $account)
        {
            if ( intval($account['account_type']) == 2 )
            {
                $account['account_profile'] = $this->beanstream_gateway->profile_pull($customerCode = $account['account_id'], $trnOrderNumber = null);
            }
        }


        echo 'POST: <br/>';
        print_r($_POST);
        echo '<br/><br/>';

        switch ($action)
        {
            case 'view':
                break;
            case 'save':
                if (!empty($_POST) && !empty($id))
                {
                    $response = $this->beanstream_gateway->profile_push($customerCode = $_POST['customerCode'], $status = 'A', $operationType = 'N', $orderNumber = null, $cardOwner = $_POST['trnCustName'], $cardNumber = $_POST['trnCardNumber'], $expMonth = $_POST['trnExpMonth'], $expYear = $_POST['trnExpYear'], $bankAccountType = $_POST['bankAccountType'], $institutionID = $_POST['institutionID'], $branchNumber = $_POST['branchNumber'], $routingNumber = $_POST['routingNumber'], $accountNumber = $_POST['accountNumber'], $name = $_POST['trnCustName'], $address1 = $_POST['trnAVstreet'], $address2 = null, $city = $_POST['trnAVCity'], $provinceCode = $_POST['trnAVState'], $postalCode = $_POST['trnAVZip'], $countryCode = $_POST['trnAVCountry'], $phone = $_POST['trnPhoneNumber'], $email = $_POST['trnEmail'], $velocityIdentity = '1', $statusIdentity = null, $transitNumber = $_POST['transitNumber']);

                    if (!empty($response['responseCode']) && intval($response['responseCode']) == 16)
                    {
                        // If profile already exists update instead of saving
                        $response = $this->beanstream_gateway->profile_push($customerCode = $_POST['customerCode'], $status = 'A', $operationType = 'M', $orderNumber = null, $cardOwner = $_POST['trnCustName'], $cardNumber = $_POST['trnCardNumber'], $expMonth = $_POST['trnExpMonth'], $expYear = $_POST['trnExpYear'], 
                                $bankAccountType = $_POST['bankAccountType'], $institutionID = $_POST['institutionID'], $branchNumber = $_POST['branchNumber'], $routingNumber = $_POST['routingNumber'], $accountNumber = $_POST['accountNumber'], 
                                $name = $_POST['trnCustName'], $address1 = $_POST['trnAVstreet'], $address2 = null, $city = $_POST['trnAVCity'], $provinceCode = $_POST['trnAVState'], $postalCode = $_POST['trnAVZip'], $countryCode = $_POST['trnAVCountry'], $phone = $_POST['trnPhoneNumber'], $email = $_POST['trnEmail'], $velocityIdentity = '1', $statusIdentity = null,
                                $transitNumber = $_POST['transitNumber']);
                        $response['responseMessage'] .= ' Force Update on existing record.';
                    }
                    if (!empty($response['responseCode']) && intval($response['responseCode']) == 1)
                    {
                        // update database account_enabled field after successful Beanstream update
                        $this->account_model->enable($_POST['customerCode']);
                        $accounts = $this->account_model->get_by_user_id($user_id = null, $account_enabled = array(0, 1));
                    }

                    echo 'Response: <br/>';
                    print_r($response);
                    echo '<br/>';

                    $this->cismarty->assign('response', $response);
                }
                break;
            case 'update':
                if (!empty($_POST) && !empty($id))
                {
                    $response = $this->beanstream_gateway->profile_push($customerCode = $_POST['customerCode'], $status = 'A', $operationType = 'M', $orderNumber = null, $cardOwner = $_POST['trnCustName'], $cardNumber = $_POST['trnCardNumber'], $expMonth = $_POST['trnExpMonth'], $expYear = $_POST['trnExpYear'], $bankAccountType = $_POST['bankAccountType'], $institutionID = $_POST['institutionID'], $branchNumber = $_POST['branchNumber'], $routingNumber = $_POST['routingNumber'], $accountNumber = $_POST['accountNumber'], $name = $_POST['trnCustName'], $address1 = $_POST['trnAVstreet'], $address2 = null, $city = $_POST['trnAVCity'], $provinceCode = $_POST['trnAVState'], $postalCode = $_POST['trnAVZip'], $countryCode = $_POST['trnAVCountry'], $phone = $_POST['trnPhoneNumber'], $email = $_POST['trnEmail'], $velocityIdentity = '1', $statusIdentity = null, $transitNumber = $_POST['transitNumber']);
                    
                    if (!empty($response['responseCode']) && intval($response['responseCode']) == 15)
                    {
                        $response = $this->beanstream_gateway->profile_push($customerCode = $_POST['customerCode'], $status = 'A', $operationType = 'N', $orderNumber = null, $cardOwner = $_POST['trnCustName'], $cardNumber = $_POST['trnCardNumber'], $expMonth = $_POST['trnExpMonth'], $expYear = $_POST['trnExpYear'], $bankAccountType = $_POST['bankAccountType'], $institutionID = $_POST['institutionID'], $branchNumber = $_POST['branchNumber'], $routingNumber = $_POST['routingNumber'], $accountNumber = $_POST['accountNumber'], $name = $_POST['trnCustName'], $address1 = $_POST['trnAVstreet'], $address2 = null, $city = $_POST['trnAVCity'], $provinceCode = $_POST['trnAVState'], $postalCode = $_POST['trnAVZip'], $countryCode = $_POST['trnAVCountry'], $phone = $_POST['trnPhoneNumber'], $email = $_POST['trnEmail'], $velocityIdentity = '1', $statusIdentity = null, $transitNumber = $_POST['transitNumber']);
                    }

                    if (!empty($response['responseCode']) && intval($response['responseCode']) == 1)
                    {
                        // update database account_enabled field after successful Beanstream update
                        $this->account_model->enable($_POST['customerCode']);
                        $accounts = $this->account_model->get_by_user_id($user_id = null, $account_enabled = array(0, 1));
                    }

                    echo 'Response: <br/>';
                    print_r($response);
                    echo '<br/>';

                    $this->cismarty->assign('response', $response);
                }
                break;
            case 'delete':
                if (!empty($_POST) && !empty($id))
                {
                    $response = $this->beanstream_gateway->profile_push($customerCode = $_POST['customerCode'], $status = 'D', $operationType = 'M', $orderNumber = null, $cardOwner = $_POST['trnCustName'], $cardNumber = $_POST['trnCardNumber'], $expMonth = $_POST['trnExpMonth'], $expYear = $_POST['trnExpYear'], $bankAccountType = $_POST['bankAccountType'], $institutionID = $_POST['institutionID'], $branchNumber = $_POST['branchNumber'], $routingNumber = $_POST['routingNumber'], $accountNumber = $_POST['accountNumber'], $name = $_POST['trnCustName'], $address1 = $_POST['trnAVstreet'], $address2 = null, $city = $_POST['trnAVCity'], $provinceCode = $_POST['trnAVState'], $postalCode = $_POST['trnAVZip'], $countryCode = $_POST['trnAVCountry'], $phone = $_POST['trnPhoneNumber'], $email = $_POST['trnEmail'], $velocityIdentity = null, $statusIdentity = null, $transitNumber = $_POST['transitNumber']);
                    $this->cismarty->assign('response', $response);
                    if (!empty($response['responseCode']) && intval($response['responseCode']) == 1)
                    {
                        // update database account_enabled field after successful Beanstream update
                        $this->account_model->disable($_POST['customerCode']);
                        $accounts = $this->account_model->get_by_user_id($user_id = null, $account_enabled = array(0, 1));
                    }

                    echo 'Response: <br/>';
                    print_r($response);
                    echo '<br/>';

                    $this->cismarty->assign('response', $response);
                }
                break;
            default:
        }

        // assign Smarty variables
        $this->cismarty->assign('accounts', $accounts);
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'beanstream/profile');
    }

    function profile_transaction()
    {
        $this->smarty_common_assign();
        if (!empty($_POST))
        {
            $this->load->model('account_model');
            $this->load->library('Ppa_gateway');
            $this->load->library('Beanstream_gateway');
            $account = $this->account_model->get_by_id($_POST['customerCode']);
            if( intval($account['account_type']) == 2 )
            {
                // fake direct bank profile payment by placing a regular bank transaction request
                // pull bank account info from BS, 'ref1'=>$institutionID, 'ref2'=>$transitNumber, 'ref3'=>$accountNumber, 'ref4'=>$routingNumber
                // TODO: encrypt BS profile data
                $account = $this->beanstream_gateway->profile_pull($customerCode = $_POST['customerCode'], $trnOrderNumber = null);
                // construct $_POST with data from BS profile
                if( !empty($account['ref1']) ) $_POST['institutionID'] = $account['ref1'];
                if( !empty($account['ref']) ) $_POST['routingNumber'] = $account['ref4'];
                if( !empty($account['ref3']) ) $_POST['accountNumber'] = $account['ref3'];
                if( !empty($account['ref2']) ) $_POST['transitNumber'] = $account['ref2'];
                $_POST['trnType'] = 'D'; // D=Debit an outside bank account (receive money in your own account)
                $_POST['branchNumber'] = null; // TODO: check if it's needed
                // push as a regular bank transaction
                $this->push('transaction');
            }
            else
            {
                $this->push('profile');
            }
        }
        else
        {
            $this->load->model('user_model');
            $this->load->model('account_model');
            $this->load->library('Ppa_gateway');
            $this->load->library('Beanstream_gateway');
            //$accounts = $this->account_model->get_by_user_id($user_id = null, $account_enabled = array(0, 1));
            $this->cismarty->assign('accounts', $this->account_model->get_by_user_id());
            $this->cismarty->assign('template', 'beanstream/profile_transaction');
        }
    }

    function push($mode = 'transaction', $json = false )
    {
        
        if( $json ) $this->json = true;

        $this->load->model('user_model');
        $this->load->model('account_model');

        $this->cismarty->assign('accounts', $this->account_model->get_by_user_id());

        $this->load->library('Ppa_gateway');
        $this->load->library('Beanstream_gateway');

        switch ($mode)
        {
            case 'transaction':
                // regular transaction
                $response = @$this->beanstream_gateway->push($_POST['trnOrderNumber'], $_POST['trnAmount'], null, $_POST['trnCustName'], $_POST['trnCardNumber'], $_POST['trnExpMonth'], $_POST['trnExpYear'], $_POST['cvv2'], $_POST['trnEmail'], $_POST['trnCustName'], 
                        $_POST['trnPhoneNumber'], $_POST['trnAVstreet'], '', $_POST['trnAVCity'], $_POST['trnAVState'], $_POST['trnAVZip'], $_POST['trnAVCountry'],
                        $bankAccountType = $_POST['bankAccountType'], $institutionID = $_POST['institutionID'], $branchNumber = $_POST['branchNumber'], $routingNumber = $_POST['routingNumber'], $accountNumber = $_POST['accountNumber'], $trnType = $_POST['trnType'], $transitNumber = $_POST['transitNumber']);
                break;
            case 'profile':
                // profile transaction
                $response = $this->beanstream_gateway->push($_POST['trnOrderNumber'], $_POST['trnAmount'], $_POST['customerCode']);
                break;
            default:
        }

        $this->cismarty->assign('response', $response);


        $msg['cvd'] = array(1 => 'CVD Match', 4 => 'CVD Should have been present', 2 => 'CVD Mismatch', 5 => 'CVD Issuer unable to process request', 3 => 'CVD Not Verified 6=CVD Not Provided');

        $msg['avs'] = array(
            '0' => 'Address Verification not performed for this transaction.',
            '5' => 'Invalid AVS Response.',
            '9' => 'Address Verification Data contains edit error.',
            'A' => 'Street address matches, Postal/ZIP does not match.',
            'B' => 'Street address matches, Postal/ZIP not verified.',
            'C' => 'Street address and Postal/ZIP not verified.',
            'D' => 'Street address and Postal/ZIP match.',
            'E' => 'Transaction ineligible.',
            'G' => 'Non AVS participant. Information not verified.',
            'I' => 'Address information not verified for international transaction.',
            'M' => 'Street address and Postal/ZIP match.',
            'N' => 'Street address and Postal/ZIP do not match.',
            'P' => 'Postal/ZIP matches. Street address not verified.',
            'R' => 'System unavailable or timeout.',
            'S' => 'AVS not supported at this time.',
            'U' => 'Address information is unavailable.',
            'W' => 'Postal/ZIP matches, street address does not match.',
            'X' => 'Street address and Postal/ZIP match.',
            'Y' => 'Street address and Postal/ZIP match.',
            'Z' => 'Postal/ZIP matches, street address does not match.');

        $this->cismarty->assign('msg', $msg);

        // assign Smarty variables
        $this->smarty_common_assign();
        switch ($mode)
        {
            case 'transaction':
                // regular transaction
                $this->cismarty->assign('template', 'beanstream/transaction');
                break;
            case 'profile':
                // profile transaction
                $this->cismarty->assign('template', 'beanstream/profile_transaction');
                break;
            default:
        }
    }

    function _output($output)
    {
        if( $this->json ) 
        {
            //
            
        }
        else 
        {
            // display template
            $this->cismarty->view('template');
        }
    }

}

/* End of file beanstream.php */
/* Location: ./system/application/controllers/beanstream.php */
?>