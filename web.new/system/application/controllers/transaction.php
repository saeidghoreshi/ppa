<?php

require_once(APPPATH.'libraries/Ppa_controller.php');

/**
 * Controller for Transaction related actions.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Transaction extends Ppa_controller
{
    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->load->model('transaction_model');
        $this->load->model('request_model');
        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->library('Ppa_gateway');
        $this->load->library('Beanstream_gateway');
    }

    function Transaction()
    {

    }

    /**
     * Default controller action, displays Transaction records for the given
     * user.
     *
     * @access public
     * @param  string, $order_by, represents column to sort transactions by
     * @param  int, $limit, represents number of transactions to show
     * @param  boolean, $descend, represents transaction sort order, descending
     *         if true
     * @return void
     */
    public function index($order_by = null, $limit = 10, $descend = true)
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $user_email = $this->authentication->get_user_email();


        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'transaction/overview');

        // Retrieve transactions to display for user
        $transactions = array();

        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        if (!empty($order_by))
        {
            if ($order_by == TRANSACTION_ORDERBY_DATE)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_DATE_PAID), $descend, $limit);
                //echo "Sort by DATE<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_ID)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_ID), $descend, $limit);
                //echo "Sort by TRANS ID<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_TIME)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_TIME_PAID), $descend, $limit);
                //echo "Sort by TIME<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_MERCHANT)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => MERCHANT_NAME), $descend, $limit);
                //echo "Sort by MERCHANT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_NOTE)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_MERCHANT_NOTE), $descend, $limit);
                //echo "Sort by MERCHANT USER NOTE<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_STATUS)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_PAID), $descend, $limit);
                //echo "Sort by PAID<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_AMOUNT)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_AMOUNT), $descend, $limit);
                //echo "Sort by AMOUNT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_ACCOUNT)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => ACCOUNT_NAME), $descend, $limit);
                //echo "Sort by ACCOUNT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_FLAG)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_FLAGGED), $descend, $limit);
                //echo "Sort by FLAG<br/>";
            }
        }
        else
        {
            if( $user_email = $this->authentication->get_user_email() )
            {
                $transactions = $this->transaction_model->get_order_by($user_email);
            }
            elseif( $user_phone = $this->authentication->get_user_phone() )
            {
                $transactions = $this->transaction_model->get_by_phone_order_by($user_phone);
            }
            else
            {
                $transactions = array();
            }
            $order_by = TRANSACTION_ORDERBY_DATE;
        }

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
//echo var_dump($transactions);
        if ($is_ajax)
        {
            // Get all transactions and order by default column (created date)
            //echo var_dump($transactions);
            $this->handle_ajax_request(AJAX_HTTP_200, array_slice($transactions,0,20));
//            exit();
        }
        else
	{
    	    $this->cismarty->assign('transactions', $transactions);
    	    $this->cismarty->assign('descend', $descend ? "0" : "1");
    	    $this->cismarty->assign('column', $order_by);
        }
    }

    public function recent($order_by = null, $limit = 10, $descend = true)
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $user_email = $this->authentication->get_user_email();


        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'transaction/merchant');

        // Retrieve transactions to display for user
        $transactions = array();

        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        if (!empty($order_by))
        {
            if ($order_by == TRANSACTION_ORDERBY_DATE)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => TRANSACTION_DATE_PAID), $descend, $limit);
                //echo "Sort by DATE<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_ID)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => TRANSACTION_ID), $descend, $limit);
                //echo "Sort by TRANS ID<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_TIME)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => TRANSACTION_TIME_PAID), $descend, $limit);
                //echo "Sort by TIME<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_USER)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => 'tr_'.USER_ID), $descend, $limit);
                //echo "Sort by MERCHANT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_NOTE)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => TRANSACTION_MERCHANT_NOTE), $descend, $limit);
                //echo "Sort by MERCHANT USER NOTE<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_STATUS)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => TRANSACTION_PAID), $descend, $limit);
                //echo "Sort by PAID<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_AMOUNT)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => 'tr_'.TRANSACTION_AMOUNT), $descend, $limit);
                //echo "Sort by AMOUNT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_ACCOUNT)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => ACCOUNT_NAME), $descend, $limit);
                //echo "Sort by ACCOUNT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_FLAG)
            {
                $transactions =
                    $this->transaction_model->get_merchant_order_by($user_email, null,
                        array(1 => TRANSACTION_FLAGGED), $descend, $limit);
                //echo "Sort by FLAG<br/>";
            }
        }
        else
        {
            $transactions = $this->transaction_model->get_merchant_order_by($user_email);
            $order_by = TRANSACTION_ORDERBY_DATE;
        }

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
//echo var_dump($transactions);
        if ($is_ajax)
        {
            // Get all transactions and order by default column (created date)
            $this->handle_ajax_request(AJAX_HTTP_200, $transactions);
//            exit();
        }
        else
	{
    	    $this->cismarty->assign('transactions', $transactions);
    	    $this->cismarty->assign('descend', $descend ? "0" : "1");
    	    $this->cismarty->assign('column', $order_by);
        }
    }

    /**
     * Controller action to retrieve the details for a specific Transaction
     * record given its Id value.
     *
     * @access public
     * @param  string, $_POST parameter, represents database Id for the
     *         Transcation record
     * @return void
     */
    public function info()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);
        

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        // Type of Account validation rules
        $this->form_validation->set_rules(FORM_ENTITY_ID, 'Transaction Id',
            'trim|xss_clean|required');

        if ($is_ajax)
        {
            // Validate the account id field
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500);
            }
            else
            {
                $transaction =
                    $this->transaction_model->get_by_id($_POST[FORM_ENTITY_ID], $this->authentication->get_user_email());
/*
		$transaction = array_merge( array( 'transaction_tax'=>round((1-1/1.12)*($transaction['transaction_amount']-$transaction['transaction_tips']),2),
		    'transaction_subtotal'=>$transaction['transaction_amount']-(round((1-1/1.12)*($transaction['transaction_amount']-$transaction['transaction_tips']),2))-$transaction['transaction_tips'],
		    'merchant_name'=>'N/A', 'merchant_address'=>'N/A', 'merchant_phone'=>'N/A', 'transaction_payment_type'=>'N/A', 'transaction_account'=>'N/A', ), $transaction );
*/			
                $data = array('result' => $transaction);
                $this->handle_ajax_request(AJAX_HTTP_200, $data);
            }
        }
        else
        {
            $this->handle_ajax_request(AJAX_HTTP_500);
        }
    }

    /**
     * Controller action to update the annotation field for a particular
     * Transaction record for the user.
     *
     * @access public
     * @param  string, $_POST parameter, represents annotation value
     * @param  string, $_POST parameter, represents database Id for the
     *         Transcation record
     * @return void
     */
    public function annotation()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        // Type of Account validation rules
        $this->form_validation->set_rules(FORM_ENTITY_ID, 'Transaction Id',
            'trim|xss_clean|required');

        if ($is_ajax)
        {
            // Validate the account id field
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500);
            }
            else
            {
                $this->transaction_model->update(
                    $_POST[FORM_ENTITY_ID], $_POST);

                $data = array('result' => $_POST[FORM_TRANS_ANNOTATION]);
                $this->handle_ajax_request(AJAX_HTTP_200, $data);
            }
        }
        else
        {
            $this->handle_ajax_request(AJAX_HTTP_500);
        }
    }

    /**
     * Controller action to update the flagged field for a particular
     * Transaction record for the user.
     *
     * @access public
     * @param  string, $_POST parameter, represents flagged value
     * @param  string, $_POST parameter, represents database Id for the
     *         Transcation record
     * @return void
     */
    public function flag()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        // Type of Account validation rules
        $this->form_validation->set_rules(FORM_ENTITY_ID, 'Transaction Id',
            'trim|xss_clean|required');

        if ($is_ajax)
        {
            // Validate the account id field
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500);
            }
            else
            {
                $flag_value = $_POST[FORM_TRANS_FLAGGED];

                if ($flag_value == 1) {
                    $_POST[FORM_TRANS_FLAGGED] = "0";
                }
                else {
                    $_POST[FORM_TRANS_FLAGGED] = "1";
                }

                $this->transaction_model->update(
                    $_POST[FORM_ENTITY_ID], $_POST);

                $data = array('result' => $_POST[FORM_TRANS_FLAGGED]);
                $this->handle_ajax_request(AJAX_HTTP_200, $data);
            }
        }
        else
        {
            $this->handle_ajax_request(AJAX_HTTP_500);
        }
    }
}

/* End of file transaction.php */
/* Location: ./system/application/models/transaction.php */