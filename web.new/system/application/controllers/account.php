<?php

require_once(APPPATH.'libraries/Ppa_controller.php');

/**
 * Controller for Account related actions.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Account extends Ppa_controller
{

    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->model('address_model');
        $this->load->library('Ppa_gateway');
        $this->load->library('Beanstream_gateway');
    }

    function Account()
    {

    }

    /**
     * Default controller action to display accounts for a user profile.
     *
     * @access public
     * @return
     */
    public function index()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        if ($is_ajax)
        {
            $params = array();
            if( !empty($_POST['latitude']) && !empty($_POST['longitude']) )
            {
                $params['latitude'] = $_POST['latitude'];
                $params['longitude'] = $_POST['longitude'];
            }
            $this->load->helper('geo');
            if( $this->authentication->get_user_email() )
            {
                $user_accounts = $this->account_model->get_all_by_email(
                            $this->authentication->get_user_email(), $params);
            }
            elseif( $this->authentication->get_user_phone() )
            {
                $user_accounts = $this->account_model->get_all_by_phone(
                            $this->authentication->get_user_phone(), $params);
            }
            
            $this->handle_ajax_request(AJAX_HTTP_200, $user_accounts);
        }
        else 
        {
            $user_accounts = $this->account_model->get_all_by_email(
                $this->authentication->get_user_email());
        }

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'account/overview');
        $this->cismarty->assign('accounts', $user_accounts);
    }

    /**
     * Controller action to display form for adding a new account.
     *
     * @access public
     * @return
     */
    public function add()
    {
        $this->check_login_redirect();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'account/edit');
        $this->cismarty->assign('account',
            $this->get_account_data($this->get_user()));
        $this->cismarty->assign('actionUrl', $this->config->site_url().'/account/create');
    }

    /**
     * Controller action to add a new account.
     *
     * @access public
     * @param  string from POST request (email), represents email address
     * @return
     */
    public function create()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        $this->cismarty->assign('actionUrl', $this->config->site_url().'/account/create');
        $this->cismarty->assign('template', 'account/edit');

        // Type of Account validation rules
        $this->form_validation->set_rules(FORM_ACCOUNT_TYPE, 'Type of Account',
            'trim|xss_clean|required');

        // Validate the Type of Account field by itself, need to ensure it has
        // valid value before proceeding with anything else
        if ($this->form_validation->run() == FALSE)
        {
            // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
            if ($is_ajax)
            {
                $this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
            }

            $this->errors .= $this->form_validation->error_string();

            $this->smarty_common_assign();
            // Retrieve values from POST to re-populate the form
            $this->cismarty->assign('account',
                $this->get_account_data($_POST));
            $this->cismarty->view('template');
            die();
        }
        // Validate all other fields
        else
        {
            // First name validation rules
            $this->form_validation->set_rules(FORM_FIRSTNAME, 'First Name',
                'trim|xss_clean|required');

            // Last name validation rules
            $this->form_validation->set_rules(FORM_LASTNAME, 'Last Name',
                'trim|xss_clean|required');

            // Prefix validation rules
            $this->form_validation->set_rules(FORM_PREFIX, 'Prefix',
                'trim|xss_clean');

            // Street Address validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_STREET,
                'Street Address', 'trim|xss_clean|required');

            // City validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_CITY,
                'City', 'trim|xss_clean|required');

            // State validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_STATE,
                'State/Province', 'trim|xss_clean|required');

            // Zip validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_ZIP,
                'Zip/Postal Code', 'trim|xss_clean|required');

            // Country validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_COUNTRY,
                'Country', 'trim|xss_clean|required');

            // If account is a Bank Account
            if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK)
            {
                $this->form_validation->set_rules(FORM_ACCOUNT_BANKNAME,
                    'Bank Name', 'trim|xss_clean|required');

                $this->form_validation->set_rules(FORM_ACCOUNT_TRANSIT,
                    'Transit Number',
                    'trim|xss_clean|required|min_length[5]|max_length[5]');

                $this->form_validation->set_rules(FORM_ACCOUNT_INSTITUTION,
                    'Institution Number',
                    'trim|xss_clean|required|min_length[3]|max_length[3]');

                $this->form_validation->set_rules(FORM_ACCOUNT_BANKNUMBER,
                    'Bank Number',
                    'trim|xss_clean|required|min_length[1]|max_length[12]');

                $this->form_validation->set_rules(
                    FORM_ACCOUNT_BANKNUMBERCONFIRM,
                    'Reenter Bank Number', 'trim|xss_clean|required');
            }
            // If account is a Credit Card Account
            else if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_VISA)
            {
                $this->form_validation->set_rules(FORM_ACCOUNT_NICKNAME,
                    'Nickname for Account', 'trim|xss_clean|required|min_length[2]|max_length[15]');

                $this->form_validation->set_rules(FORM_ACCOUNT_CREDITCARDNUMBER,
                    'Credit Card Number',
                    'trim|xss_clean|required|min_length[15]|max_length[16]');

                $this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_MONTH,
                    'Expiry Month', 'trim|xss_clean|required');

                $this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_YEAR,
                    'Expiry Year', 'trim|xss_clean|required');

                $this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_NUMBER,
                    'Security Number on Card',
                    'trim|xss_clean|required|min_length[3]|max_length[3]');

                $this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_PIN,
                    'Security PIN',
                    'trim|xss_clean|required|min_length[4]|max_length[4]');
            }

            // Validate input fields
            if ($this->form_validation->run() == FALSE)
            {
                // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                if ($is_ajax)
                {
                    $this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
                }

                $this->errors .= $this->form_validation->error_string();

                $this->smarty_common_assign();
                // Retrieve values from POST to re-populate the form
                $this->cismarty->assign('account',
                    $this->get_account_data($_POST));
                $this->cismarty->view('template');
                die();
            }
            // If this is of Type Bank Account, ensure bank number fields match
            else if($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK &&
                $_POST[FORM_ACCOUNT_BANKNUMBER] !=
                $_POST[FORM_ACCOUNT_BANKNUMBERCONFIRM])
            {
                // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                if ($is_ajax)
                {
                    $this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
                }

                $this->errors .= "<p>Bank Numbers must match</p>";

                $this->smarty_common_assign();
                // Retrieve values from POST to re-populate the form
                $this->cismarty->assign('account',
                    $this->get_account_data($_POST));
                $this->cismarty->view('template');
                die();

            }
            // Otherwise, create new account in DB
            else
            {
                // Retrieve user
                $user = $this->get_user();

                // Create the address for the account in PPA
                $address_id =
                    $this->address_model->create($user[USER_ID], $_POST);

                // Create the account in PPA
                $account_id =
                    $this->account_model->create($address_id, $user[USER_ID],
                        $_POST);

                // --------------- BEGIN Bean Stream Integration ---------------
                $response = $this->beanstream_profile_push($_POST, $user,
                    $account_id, 'A', 'N', '1');

                // If profile already exists update instead of saving
                /*if(!empty($response[BEANSTREAM_RESPONSE_CODE]) &&
                    intval($response[BEANSTREAM_RESPONSE_CODE]) == 16)
                {
                    $response = $this->beanstream_profile_push($_POST, $user,
                        'A', 'M', '1');

                    $response['responseMessage'] .=
                        ' Force Update on existing record.';
                }*/

                // Update database account_enabled field after successful
                // Beanstream update
                if(!empty($response[BEANSTREAM_RESPONSE_CODE])
                    && intval($response[BEANSTREAM_RESPONSE_CODE]) == 1)
                {
                    $this->account_model->enable($account_id);

                    // Change the account number to safe version, i.e.
                    // containing XXX to hide number
                    /*if (array_key_exists(BEANSTREAM_CARD_NUMBER, $response))
                    {
                        if (!empty($response[BEANSTREAM_CARD_NUMBER]))
                        {
                            // TODO: Not sure if BEANSTREAM_CARD_NUMBER is the
                            // same parameter for both bank accounts and credit
                            // card accounts
                            // Set both bank name and credit card name
                            $_POST[FORM_ACCOUNT_BANKNUMBER] =
                                $response[BEANSTREAM_CARD_NUMBER];
                            $_POST[FORM_ACCOUNT_CREDITCARDNUMBER] =
                                $response[BEANSTREAM_CARD_NUMBER];
                        }
                    }
                    $this->account_model->update($account_id, $_POST);
                     */

                    //$accounts =
                     //   $this->account_model->get_by_user_id($user_id = null,
                       //     $account_enabled = array(0,1));

                    // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                    if ($is_ajax)
                    {
                        $this->handle_ajax_request(AJAX_HTTP_200);
                    }
                }
                else
                {
                    // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                    if ($is_ajax)
                    {
                        // TODO: Handle BS response
                        $this->handle_ajax_request(AJAX_HTTP_500, null, implode('; ', $response));
                        //$this->handle_ajax_request(AJAX_HTTP_200);
                    }
                }

                $this->smarty_common_assign();
                $this->cismarty->assign('template', 'account/add-complete');
                $this->cismarty->assign('response', $response);
                $this->cismarty->view('template');
                die();
                // ---------------- END Bean Stream Integration ----------------

                // redirect to account overview page
                //redirect($this->config->site_url() . '/account/', 'refresh');
            }
        }
    }

    /**
     * Controller action to enable an existing account.
     *
     * @access public
     * @return
     */
    public function enable($account_id = null)
    {
        $this->check_login_redirect();

        $status = $this->account_model->enable($account_id);
        redirect($this->config->site_url() . '/account/', 'refresh');
        die();
        $account = $this->account_model->get_by_id($account_id);
        $status = 0;

        // First check if account exists
        if (!empty($account))
        {
            // Next, check if account is already enabled
            if ($account[ACCOUNT_ENABLED])
            {
                $status = 2;
            }
            // Otherwise, account is not enabled, so attempt to enable it
            else
            {
                // --------------- BEGIN Bean Stream Integration ---------------
                $user = $this->get_user();
                $account_data = $this->get_account_data($account);

                $response = $this->beanstream_profile_push($account_data, $user,
                    $account_id, 'A', 'M', '1');
                // ---------------- END Bean Stream Integration ----------------

                // If Bean Stream call was successful
                if (!empty($response[BEANSTREAM_RESPONSE_CODE]) &&
                    intval($response[BEANSTREAM_RESPONSE_CODE]) == 1)
                {
                    // Status will be either 1 (success) or 0 (fail)
                    $status = $this->account_model->enable($account_id);
                }

                $this->cismarty->assign('response', $response);
            }
        }
        else
        {
            $status = -1;
        }

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'account/enable');
        $this->cismarty->assign('id', $account_id);
        $this->cismarty->assign('enabled', $status);
    }


    /**
     * Controller action to disable an existing account.
     *
     * @access public
     * @return
     */
    public function suspend($account_id = null)
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        $account = $this->account_model->get_by_id($account_id);
        
        // First, check if the account exists
        if (!empty($account))
        {
                $status = $this->account_model->disable($account_id);
        }
        redirect('account');
    }
    
    /**
     * Controller action to disable an existing account.
     *
     * @access public
     * @return
     */
    public function disable($account_id = null)
    {
        $this->suspend($account_id);
        //
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $account = $this->account_model->get_by_id($account_id);
        $status = 0;

        // First, check if the account exists
        if (!empty($account))
        {
            // Next, check if the account is already disabled
            if (!$account[ACCOUNT_ENABLED])
            {
                // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                if ($is_ajax)
                {
                    $this->handle_ajax_request(AJAX_HTTP_500, null, 'Account not Enabled');
                }
                $status = 2;
            }
            // Otherwise, account is not disabled, so attempt to disable it
            else
            {
                // --------------- BEGIN Bean Stream Integration ---------------
                $user = $this->get_user();
                $account_data = $this->get_account_data($account);

                $response = $this->beanstream_profile_push($account_data, $user,
                    $account_id, 'D', 'M');
                // ---------------- END Bean Stream Integration ----------------

                // If Bean Stream call was successful
                if (!empty($response[BEANSTREAM_RESPONSE_CODE]) &&
                    intval($response[BEANSTREAM_RESPONSE_CODE]) == 1)
                {
                    // Status will be either 1 (success) or 0 (fail)
                    $status = $this->account_model->disable($account_id);

                    // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                    if ($is_ajax)
                    {
                        $this->handle_ajax_request(AJAX_HTTP_200);
                    }
                }
                else
                {
                    // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                    if ($is_ajax)
                    {
                        // TODO: Handle BS response
                        //$this->handle_ajax_request(AJAX_HTTP_500, null, implode('; ', $response));
                        $this->handle_ajax_request(AJAX_HTTP_200);
                    }
                }

                $this->cismarty->assign('response', $response);
            }
        }
        else
        {
            // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
            if ($is_ajax)
            {
                $this->handle_ajax_request(AJAX_HTTP_500, null, 'Account Empty');
            }
            $status = -1;
        }

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'account/disable');
        $this->cismarty->assign('id', $account_id);
        $this->cismarty->assign('disabled', $status);
    }

    /**
     * Controller action to display info for an existing account.
     *
     * @access public
     * @return
     */
    public function info($account_id = null, $order_by = null, $limit = 10,
        $descend = true)
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        // Retrieve user email in order to query for transactions
        $user_email = $this->authentication->get_user_email();

        // Retrieve account info
        $account_data =
            $this->account_model->get_by_id($account_id,
                array(ACCOUNT_ENABLED => TRUE));

        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        if ($is_ajax)
        {
            $this->handle_ajax_request(AJAX_HTTP_200, $account_data);
        }


        $this->load->model('transaction_model');

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'account/info');

        // Get account data
        $this->cismarty->assign('account',
            $this->get_account_data($account_data));

        // Get transaction data for this account
        $transactions = array();

        if (!empty($order_by))
        {
            if ($order_by == TRANSACTION_ORDERBY_DATE)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_DATE_PAID),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_ID)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_ID),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_TIME)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_TIME_PAID),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_MERCHANT)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => MERCHANT_NAME),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_NOTE)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_MERCHANT_NOTE),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_STATUS)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_PAID),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_AMOUNT)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_AMOUNT),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_ACCOUNT)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => ACCOUNT_NAME),
                        $descend, $limit);
            }
            else if ($order_by == TRANSACTION_ORDERBY_FLAG)
            {
                $transactions =
                    $this->transaction_model->get_order_by($user_email,
                        $account_id, array(1 => TRANSACTION_FLAGGED),
                        $descend, $limit);
            }
        }
        else
        {
            $transactions = $this->transaction_model->get_order_by($user_email,
                $account_id);
            $order_by = TRANSACTION_ORDERBY_DATE;
        }

        $this->cismarty->assign('transactions', $transactions);
        $this->cismarty->assign('descend', $descend ? "0" : "1");
        $this->cismarty->assign('column', $order_by);
    }

    /**
     * Default controller action to display accounts for a user profile.
     *
     * @access public
     * @return
     */
    public function edit($account_id = null)
    {
        $this->check_login_redirect();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('actionUrl', $this->config->site_url().'/account/update');
        $this->cismarty->assign('template', 'account/edit');
        $this->cismarty->assign('account',
            $this->get_account_data(
                $this->account_model->get_by_id($account_id,
                    array(ACCOUNT_ENABLED => TRUE))));
    }

    /**
     * Controller action to update an existing account.
     *
     * @access public
     * @return
     */
    public function update()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        $this->cismarty->assign('actionUrl', $this->config->site_url().'/account/update');
        $this->cismarty->assign('template', 'account/edit');

        // Type of Account validation rules
        $this->form_validation->set_rules(FORM_ACCOUNT_TYPE, 'Type of Account',
            'trim|xss_clean|required');

        $account_id = $_POST[FORM_ENTITY_ID];

        // Validate the Type of Account field by itself, need to ensure it has
        // valid value before proceeding with anything else
        if ($this->form_validation->run() == FALSE)
        {
            // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
            if ($is_ajax)
            {
                $this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
            }

            $this->errors .= $this->form_validation->error_string();
            $this->smarty_common_assign();
            // Retrieve values from POST to re-populate the form
            $this->cismarty->assign('account',
                $this->get_account_data($_POST));
            $this->cismarty->view('template');
            die();
        }
        // Validate all other fields
        else
        {
            // First name validation rules
            $this->form_validation->set_rules(FORM_FIRSTNAME, 'First Name',
                'trim|xss_clean|required');

            // Last name validation rules
            $this->form_validation->set_rules(FORM_LASTNAME, 'Last Name',
                'trim|xss_clean|required');

            // Prefix validation rules
            $this->form_validation->set_rules(FORM_PREFIX, 'Prefix',
                'trim|xss_clean');

            // Street Address validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_STREET,
                'Street Address', 'trim|xss_clean|required');

            // City validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_CITY,
                'City', 'trim|xss_clean|required');

            // State validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_STATE,
                'State/Province', 'trim|xss_clean|required');

            // Zip validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_ZIP,
                'Zip/Postal Code', 'trim|xss_clean|required');

            // Country validation rules
            $this->form_validation->set_rules(FORM_ADDRESS_COUNTRY,
                'Country', 'trim|xss_clean|required');

            // If account is a Bank Account
            if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK)
            {
                $this->form_validation->set_rules(FORM_ACCOUNT_BANKNAME,
                    'Bank Name', 'trim|xss_clean|required');

                $this->form_validation->set_rules(FORM_ACCOUNT_TRANSIT,
                    'Transit Number',
                    'trim|xss_clean|required|min_length[5]|max_length[5]');

                $this->form_validation->set_rules(FORM_ACCOUNT_INSTITUTION,
                    'Institution Number',
                    'trim|xss_clean|required|min_length[3]|max_length[3]');

                $this->form_validation->set_rules(FORM_ACCOUNT_BANKNUMBER,
                    'Bank Number',
                    'trim|xss_clean|required|min_length[1]|max_length[12]');

                $this->form_validation->set_rules(
                    FORM_ACCOUNT_BANKNUMBERCONFIRM,
                    'Reenter Bank Number', 'trim|xss_clean|required');
            }
            // If account is a Credit Card Account
            else if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_VISA)
            {
                $this->form_validation->set_rules(FORM_ACCOUNT_NICKNAME,
                    'Nickname for Account', 'trim|xss_clean|required|min_length[2]|max_length[15]');
                
                // Do not verify CC number if it has X - not going to be updated with BS
                if( !preg_match('/x/ims',$_POST[FORM_ACCOUNT_CREDITCARDNUMBER]) )
                {
                    $this->form_validation->set_rules(FORM_ACCOUNT_CREDITCARDNUMBER,
                    'Credit Card Number',
                    'trim|xss_clean|required|min_length[15]|max_length[16]');
                }
                
                $this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_MONTH,
                    'Expiry Month', 'trim|xss_clean|required');

                $this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_YEAR,
                    'Expiry Year', 'trim|xss_clean|required');

                $this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_NUMBER,
                    'Security Number on Card',
                    'trim|xss_clean|required|min_length[3]|max_length[3]');

                $this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_PIN,
                    'Security PIN',
                    'trim|xss_clean|required|min_length[4]|max_length[4]');
            }

            // Validate input fields
            if ($this->form_validation->run() == FALSE)
            {
                // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                if ($is_ajax)
                {
                    $this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
                }

                $this->errors .= $this->form_validation->error_string();
                $this->smarty_common_assign();
                // Retrieve values from POST to re-populate the form
                $this->cismarty->assign('account',
                    $this->get_account_data($_POST));
                $this->cismarty->view('template');
                die();
            }
            // If this is of Type Bank Account, ensure bank number fields match
            else if($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK &&
                $_POST[FORM_ACCOUNT_BANKNUMBER] !=
                $_POST[FORM_ACCOUNT_BANKNUMBERCONFIRM])
            {
                // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                if ($is_ajax)
                {
                    $this->handle_ajax_request(AJAX_HTTP_500, null, 'Bank  Numbers does not match ');
                }

                $this->errors .= "<p>Bank Numbers must match</p>";
                $this->smarty_common_assign();
                // Retrieve values from POST to re-populate the form
                $this->cismarty->assign('account',
                    $this->get_account_data($_POST));
                $this->cismarty->view('template');
                die();

            }
            // Otherwise, update existing account in DB
            else
            {
                // Retrieve user
                $user = $this->get_user();

                // Retrieve existing address record for this account, based on
                // account Id value
                $account = $this->account_model->get_by_id($account_id,
                    array(ACCOUNT_ENABLED => TRUE));

                // --------------- BEGIN Bean Stream Integration ---------------
                if( !preg_match('/x/ims',$_POST[FORM_ACCOUNT_CREDITCARDNUMBER]) )
                {
                    $response = $this->beanstream_profile_push($_POST, $user, $account_id, 'A', 'M', '1');
                }
                // Update database account_enabled field after successful
                // Beanstream update
                if ( preg_match('/x/ims',$_POST[FORM_ACCOUNT_CREDITCARDNUMBER]) || (!empty($response[BEANSTREAM_RESPONSE_CODE]) && intval($response[BEANSTREAM_RESPONSE_CODE]) == 1) )
                {
                    // Update the existing address for this account
                    $this->address_model->update($account[ADDRESS_ID], $_POST);
                    // Update the account
                    $this->account_model->update($account_id, $_POST);
                    // Enable the account, do we need it?
                    $this->account_model->enable($account_id);
                    //$accounts = $this->account_model->get_by_user_id(
                        //$user_id = null, $account_enabled = array(0, 1));
                    // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                    if ($is_ajax)
                    {
                        $this->handle_ajax_request(AJAX_HTTP_200);
                    }
                    else
                    {
                        redirect($this->config->site_url() . '/account/', 'refresh');
                        die();
                    }
                }
                else
                {
                    // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
                    if ($is_ajax)
                    {
                        // Handle BS response
                        //$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
                        //$this->handle_ajax_request(AJAX_HTTP_500, null, implode('; ', $this->form_validation->error_string(' ',' ')));
                        //$this->handle_ajax_request(AJAX_HTTP_200);
                        $this->handle_ajax_request(AJAX_HTTP_500, null, empty($response['errorMessage'])?implode($response):$response['errorMessage'] );
                    }
                    else
                    {
                        //echo var_dump($response);
                        $this->errors .= implode('; ', $response);
                        $this->smarty_common_assign();
                        $this->cismarty->assign('response', $response);
                        // Retrieve values from POST to re-populate the form
                        $this->cismarty->assign('account', $this->get_account_data($_POST));
                        $this->cismarty->view('template');
                        die();
                    }
                }

                //$this->smarty_common_assign();
                //$this->cismarty->assign('template', 'account/test');
                //$this->cismarty->assign('response', $response);
                //$this->cismarty->view('template');
                //die();
                //
                // ---------------- END Bean Stream Integration ----------------

                // redirect to account overview page
                //redirect($this->config->site_url() . '/account/', 'refresh');
            }
        }
    }

    /**
     * Helper function to construct an array filled with user data, to be used
     * to pre-populate forms related to accounts (e.g. add or edit account).
     *
     * @access public
     * @return  array
     */
    protected function get_account_data($data = array())
    {
        $account_array = array();

        /*
        echo 'Check Data: <br/> </br/> ';
        print_r($data);
        echo '<br/><br/>';
         */

        $account_array[FORM_ENTITY_ID] =
            $this->get_form_data($data, array(ACCOUNT_ID, FORM_ENTITY_ID));

        // ------------------------------------------
        // User fields
        // ------------------------------------------
        $account_array[FORM_FIRSTNAME] =
            $this->get_form_data($data, array(ACCOUNT_FIRSTNAME,
                USER_FIRSTNAME, FORM_FIRSTNAME));

        $account_array[FORM_LASTNAME] =
            $this->get_form_data($data, array(ACCOUNT_LASTNAME,
                USER_LASTNAME, FORM_LASTNAME));

        $account_array[FORM_PREFIX] =
            $this->get_form_data($data, array(ACCOUNT_PREFIX,
                USER_PREFIX, FORM_PREFIX));

        // ------------------------------------------
        // Account fields
        // ------------------------------------------
        $account_array[FORM_ACCOUNT_TYPE] =
                $this->get_form_data($data, array(ACCOUNT_TYPE,
                    FORM_ACCOUNT_TYPE));

        $account_array[ACCOUNT_ENABLED] =
                $this->get_form_data($data, array(ACCOUNT_ENABLED,
                    ACCOUNT_ENABLED));

        // Bank Account
        $account_array[FORM_ACCOUNT_BANKNAME] =
            $this->get_form_data($data, array(ACCOUNT_NAME,
                FORM_ACCOUNT_BANKNAME));

        $account_array[FORM_ACCOUNT_BANKNUMBER] =
            $this->get_form_data($data, array(ACCOUNT_NUMBER,
                FORM_ACCOUNT_BANKNUMBER));

        $account_array[FORM_ACCOUNT_TRANSIT] =
            $this->get_form_data($data, array(ACCOUNT_TRANSIT,
                FORM_ACCOUNT_TRANSIT));

        $account_array[FORM_ACCOUNT_INSTITUTION] =
            $this->get_form_data($data, array(ACCOUNT_INSTITUTION,
                FORM_ACCOUNT_INSTITUTION));

        // Credit Card Account
        $account_array['accounttype_code'] = $this->get_form_data($data, array('accounttype_code'));

        $account_array[FORM_ACCOUNT_NICKNAME] =
            $this->get_form_data($data, array(ACCOUNT_NAME,
                FORM_ACCOUNT_NICKNAME));

        $account_array[FORM_ACCOUNT_CREDITCARDNUMBER] =
            $this->get_form_data($data, array(ACCOUNT_NUMBER,
                FORM_ACCOUNT_CREDITCARDNUMBER));

        $account_array[FORM_ACCOUNT_EXPIRY] =
            $this->get_form_data($data, array(ACCOUNT_EXPIRY,
                FORM_ACCOUNT_EXPIRY));

        $month = $this->get_form_data($data, array(ACCOUNT_EXPIRY_MONTH,
                FORM_ACCOUNT_EXPIRY_MONTH));

        $account_array[FORM_ACCOUNT_EXPIRY_MONTH] = str_pad(intval($month), 2, "0", STR_PAD_LEFT);

        $year = $this->get_form_data($data, array(ACCOUNT_EXPIRY_YEAR,
                FORM_ACCOUNT_EXPIRY_YEAR));

        $account_array[FORM_ACCOUNT_EXPIRY_YEAR] = str_pad(intval($year), 2, "0", STR_PAD_LEFT);;

        $account_array[FORM_ACCOUNT_SECURITY_NUMBER] =
            $this->get_form_data($data, array(ACCOUNT_SECURITY_NUMBER,
                FORM_ACCOUNT_SECURITY_NUMBER));

        $account_array[FORM_ACCOUNT_SECURITY_PIN] =
            $this->get_form_data($data, array(ACCOUNT_SECURITY_PIN,
                FORM_ACCOUNT_SECURITY_PIN));
        
        // ------------------------------------------
        // Address fields
        // ------------------------------------------
        $address_array =
            empty($data[ADDRESS_TABLE]) ? $data : $data[ADDRESS_TABLE];

        $account_array[FORM_ADDRESS_STREET] =
            $this->get_form_data($address_array, array(ADDRESS_STREET,
                FORM_ADDRESS_STREET));

        $account_array[FORM_ADDRESS_CITY] =
            $this->get_form_data($address_array, array(ADDRESS_CITY,
                FORM_ADDRESS_CITY));

        $account_array[FORM_ADDRESS_STATE] =
            $this->get_form_data($address_array, array(ADDRESS_STATE,
                FORM_ADDRESS_STATE));

        $account_array[FORM_ADDRESS_ZIP] =
            $this->get_form_data($address_array, array(ADDRESS_ZIP,
                FORM_ADDRESS_ZIP));

        $account_array[FORM_ADDRESS_COUNTRY] =
            $this->get_form_data($address_array, array(ADDRESS_COUNTRY,
                FORM_ADDRESS_COUNTRY));

        /*
        echo 'Works: <br/>';
        print_r($account_array);
        echo '<br/><br/>';
        die();
         */

        return $account_array;
    }

    /**
     * Calls Bean Stream to push profile data.
     *
     * @return    array, response from call to Bean Stream
     */
    protected function beanstream_profile_push($data = null, $user = null,
        $account_id = null, $status = 'A', $operation_type = 'M',
        $velocity_identity = null)
    {
        $response = array();
        
        if( preg_match('/canada/ims',$data[FORM_ADDRESS_COUNTRY]) )
        {
            $data[FORM_ADDRESS_COUNTRY] = 'CA';
        }
        elseif( preg_match('/usa|united\s+states/ims',$data[FORM_ADDRESS_COUNTRY]) )
        {
            $data[FORM_ADDRESS_COUNTRY] = 'US';
        }

        /*print_r($data);
        echo "<br/><br/><br/>";
        //print_r($user);
        // */

        if (array_key_exists(FORM_ACCOUNT_TYPE, $data))
        {
            // For Bank Account records
            if ($data[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK)
            {
                // TODO: Missing data field for
                // ACCOUNT_NAME => $data[FORM_ACCOUNT_BANKNAME],
                $response = $this->beanstream_gateway->profile_push(
                    $account_id, //$data['customerCode'],
                    $status, // status
                    $operation_type, // operation type
                    null, // order number
                    null, // card owner
                    null, // cardNumber
                    null, // expMonth
                    null, // expYear
                    null, // bankAccountType
                    $data[FORM_ACCOUNT_INSTITUTION], // institutionID
                    $data[FORM_ACCOUNT_TRANSIT], // branchNumber
                    null, // routingNumber
                    $data[FORM_ACCOUNT_BANKNUMBER], // accountNumber
                    $data[FORM_FIRSTNAME] . ' ' . $data[FORM_LASTNAME], // name
                    $data[FORM_ADDRESS_STREET], // address1
                    null, // address2
                    $data[FORM_ADDRESS_CITY], // city
                    $data[FORM_ADDRESS_STATE], // provinceCode
                    $data[FORM_ADDRESS_ZIP], // postalCode
                    $data[FORM_ADDRESS_COUNTRY], // countryCode
                    $user[USER_PHONE], // phone
                    $user[USER_EMAIL], // email
                    $velocity_identity, // velocityIdentity
                    null); // statusIdentity
            }
            // Otherwise, Type of Account is Visa (for now only two types)
            else
            {
                // TODO: Missing field for
                // ACCOUNT_NAME => $data[FORM_ACCOUNT_NICKNAME],
                // ACCOUNT_SECURITY_NUMBER => $data[FORM_ACCOUNT_SECURITY_NUMBER]
                $response = $this->beanstream_gateway->profile_push(
                    $account_id, //$data['customerCode'],
                    $status, // status
                    $operation_type, // operation type
                    null, // order number
                    $data[FORM_FIRSTNAME] . ' ' . $data[FORM_LASTNAME], // card owner
                    $data[FORM_ACCOUNT_CREDITCARDNUMBER], // cardNumber
                    $data[FORM_ACCOUNT_EXPIRY_MONTH], // expMonth
                    $data[FORM_ACCOUNT_EXPIRY_YEAR], // expYear
                    null, // bankAccountType
                    null, // institutionID
                    null, // branchNumber
                    null, // routingNumber
                    null, // accountNumber
                    $data[FORM_FIRSTNAME] . ' ' . $data[FORM_LASTNAME], // name
                    $data[FORM_ADDRESS_STREET], // address1
                    null, // address2
                    $data[FORM_ADDRESS_CITY], // city
                    $data[FORM_ADDRESS_STATE], // provinceCode
                    $data[FORM_ADDRESS_ZIP], // postalCode
                    $data[FORM_ADDRESS_COUNTRY], // countryCode
                    $user[USER_PHONE], // phone
                    $user[USER_EMAIL], // email
                    $velocity_identity, // velocityIdentity
                    null); // statusIdentity
            }

            return $response;
        }

    }
}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */