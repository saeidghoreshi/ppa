<?php

//require_once(APPPATH.'libraries/Ppa_controller.php');

/**
 * Controller for User related actions.
 *
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class User extends Ppa_controller
{
    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->model('address_model');
    }

    function User()
    {

    }

    /**
     * Default controller action to display user profile.
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

        // Extract user data from DB
        $user_data = $this->get_user_for_form();

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
        if ($is_ajax)
        {
            foreach($user_data AS $key=>$item)
            {
                //if( empty($user_data[$key]) )$user_data[$key] = $key;
            }
            $this->handle_ajax_request(AJAX_HTTP_200, $user_data);
        }
        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        else
        {
            // init
            $this->smarty_common_assign();
            $this->cismarty->assign('template', 'user/overview');
            $this->cismarty->assign('user', $user_data);
        }
    }

    /**
     * Controller action to log a user into the system.
     *
     * @access public
     * @param  string from POST request (email), represents email address
     * @param  string from POST request (phone), represents phone number
     * @param  string from POST request (password), represents password
     * @return
     */
    public function login()
    {
        // Ensure user is not already logged in
        $this->check_anonymous_redirect();

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'email'));

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        // Passcode is required regardless of WEB or PHONEGAP client
        $this->form_validation->set_rules(FORM_PASSCODE, 'Passcode',
            'trim|required');

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
        if ($is_ajax)
        {
            // Logging in with phone number
            $this->form_validation->set_rules(FORM_PHONE, 'Phone',
            'trim|required|valid_phone|xss_clean');

            // If login values failed validation return unauthorized status
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_401);
            }
            else
            {
                // Try to login, if unsuccessful set error message
                $user =
                    $this->authentication->login(null, $_POST[FORM_PHONE],
                        $_POST[FORM_PASSCODE]);
                if (empty($user))
                {
                    $this->handle_ajax_request(AJAX_HTTP_401);
                }

                $this->handle_ajax_request(AJAX_HTTP_200);
            }
        }
        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        else
        {
            if( $this->config->item('index_page') == 'merchant' )
            {
                // Logging in with phone number
                $this->form_validation->set_rules(FORM_PHONE, 'Phone',
                                'trim|required|valid_phone|xss_clean');
            }
            else
            {
                // Logging in with email address
                $this->form_validation->set_rules(FORM_EMAIL, 'Email',
                                'trim|required|valid_email|xss_clean');
            }

            // If login values failed validation, reload page with errors
            if ($this->form_validation->run() == FALSE)
            {
                $this->errors .= $this->form_validation->error_string();

                $this->cismarty->assign('template', 'login');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            else
            {
                if( $this->config->item('index_page') == 'merchant' )
                {
                    // Try to login, if unsuccessful set error message
                    $user = $this->authentication->login(null, $_POST[FORM_PHONE],
                                        $_POST[FORM_PASSCODE]);
                }
                else
                {
                    // Try to login, if unsuccessful set error message
                    $user = $this->authentication->login($_POST[FORM_EMAIL], null,
                                        $_POST[FORM_PASSCODE], FALSE);
                }
                
                
                if (empty($user))
                {
                    $this->errors .=
                        '<p>Invalid credentials, please try again.</p>';

                    $this->cismarty->assign('template', 'login');
                    $this->smarty_common_assign();
                    $this->cismarty->view('template');
                    die();
                }
                else if( $this->config->item('index_page') == 'merchant' )
                {
                    // redirect to default merchant page
                    redirect($this->config->site_url(), 'refresh');
                }

                // If user authenticated successfully, check for passphrases
                $this->load->model('passphrase_model');
                $passphrases =
                    $this->passphrase_model->get_by_user($user[USER_ID]);

                $num_passphrases = count($passphrases);

                if ($num_passphrases > 0)
                {
                    $selected_index = rand(0,$num_passphrases - 1);

                    $this->cismarty->assign('template', 'login');
                    $this->smarty_common_assign();
                    $this->cismarty->assign('passphrase_question',
                        $passphrases[$selected_index][PASSPHRASE_QUESTION]);
                    $this->cismarty->assign('selected_index',
                        $selected_index);
                    $this->cismarty->assign("id",
                        $user[USER_ID]);
                    $this->cismarty->assign('email', $user[USER_EMAIL]);
                    $this->cismarty->view('template');
                    die();
                }

                $this->authentication->set_session($user);

                // redirect to default user page
                redirect($this->config->site_url(), 'refresh');
            }
        }
    }

    /**
     * Controller action to verify user's passphrase answer.
     *
     * @access public
     * @param  string from POST request (answer), represents passphrase answer
     * @return
     */
    public function passphrase()
    {
        // Ensure user is not already logged in
        $this->check_anonymous_redirect();

        $this->load->model('passphrase_model');
        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        // Passphrase answer is required
        $this->form_validation->set_rules(FORM_PASSPHRASE_ANSWER, 'Answer',
            'trim|required');

        $user = $this->user_model->get_user_by_id($_POST[FORM_ENTITY_ID]);
        $passphrases =
            $this->passphrase_model->get_by_user($user[USER_ID]);
        $selected_index = $_POST[FORM_PASSPHRASE_SELECTED];

        // If verification value failed validation, reload page with errors
        if ($this->form_validation->run() == FALSE)
        {
            $this->errors .= $this->form_validation->error_string();

            $this->cismarty->assign('template', 'login');
            $this->smarty_common_assign();
            $this->cismarty->assign('passphrase_question',
                $_POST[FORM_PASSPHRASE_QUESTION]);
            $this->cismarty->assign("id", $user[USER_ID]);
            $this->cismarty->assign('selected_index',
                $selected_index);
            $this->cismarty->view('template');
            die();
        }
        else if (strtolower($_POST[FORM_PASSPHRASE_ANSWER]) !=
            strtolower($passphrases[$selected_index][PASSPHRASE_ANSWER]))
        {
            $this->errors .=
                '<p>Passphrase answer was incorrect, please try again.</p>';

            $this->cismarty->assign('template', 'login');
            $this->smarty_common_assign();
            $this->cismarty->assign('passphrase_question',
                $_POST[FORM_PASSPHRASE_QUESTION]);
            $this->cismarty->assign("id", $user[USER_ID]);
            $this->cismarty->assign('selected_index',
                $selected_index);
            $this->cismarty->view('template');
            die();
        }
        $this->authentication->set_session($user);

        // redirect to default user page
        redirect($this->config->site_url(), 'refresh');
    }

    /**
     * Controller action to logout a user from the system.
     *
     * @access public
     * @return
     */
    public function logout()
    {
        $this->authentication->logout();

        // redirect to index page
        redirect($this->config->site_url(), 'refresh');
    }

    /**
     * Controller action to render registration view.
     *
     * @access public
     * @return
     */
    public function register()
    {
        // Ensure user is not already logged in
        $this->check_anonymous_redirect();

        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'user/register');
    }

    // TODO: THIS IS A TEST FUNCTION TO TEST PHONEGAP FORMS, REMOVE LATER
    public function jsonregister()
    {
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'user/jsonregister');
    }

    /**
     * Controller action to create a user account.
     *
     * @access public
     * @param  string from POST request (email), represents email address
     * @return
     */
    public function create()
    {
        // Ensure user is not already logged in
        $this->check_anonymous_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'email', 'date'));
        
        if( !empty($_POST[FORM_PHONE]) ) $_POST[FORM_PHONE] = preg_replace('/^\+1?/','',$_POST[FORM_PHONE]);

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
        if ($is_ajax)
        {
            $this->form_validation->set_rules(FORM_PHONE, 'Phone Number',
                'trim|required|xss_clean|callback_phone_check_on_create');

            // If validation errors occurred, reload page
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500,
                    '{"status":' .
                        $this->form_validation->error_string('"', '"') .
                    '}');
            }
            // Otherwise, create user in DB
            else
            {
                $this->load->library('Sms_gateway');
                $user_phone = $_POST[FORM_PHONE];
                $user_email = $_POST[FORM_EMAIL];

                // 1. Create user account (initially disabled)
                $user_id = $this->user_model->create($user_email, $user_phone);
                // 1.1 Create empty address
                $address_array[FORM_ADDRESS_STREET] = '';
                $address_array[FORM_ADDRESS_CITY] = '';
                $address_array[FORM_ADDRESS_STATE] = '';
                $address_array[FORM_ADDRESS_ZIP] = '';
                $address_array[FORM_ADDRESS_COUNTRY] = '';
                $address_id = $this->address_model->create($user_id, $address_array);
                // 1.2 Add a Gift Card
                $account_array[USER_ID] = $user_id;
                $account_array[ADDRESS_ID] = $address_id;
                $account_array[ACCOUNT_ENABLED] = 1;
                $account_array[ACCOUNT_TYPE] = 12;
                $account_array[ACCOUNT_NAME] = 'Prado GC';
                $account_array[ACCOUNT_BALANCE] = '10.00';
                $account_array[ACCOUNT_SECURITY_NUMBER] = md5('123');
                $account_array[ACCOUNT_SECURITY_PIN] = md5('1111');
                $this->account_model->insert($account_array);
                //exit;
                // 2. Generate confirmation token
                $token = $this->authentication->
                        create_numerictoken($user_id);

                // 3. Generate a URL
                $confirmation_link =
                    $this->config->site_url() . "/user/confirm/";

                // 4. Generate email message
                $confirmation_msg =
                    "PayPhoneApp Confirmation. \n" .
                    "Please enter the following code into PayPhoneApp.\n"
                    . $token . "\n" .
                    "If you did not register, please ignore this message\n";

                // 5. Set email class parameters and send email
                $response = $this->sms_gateway->send($_POST['phone'],
                    $confirmation_msg);
                    
                $this->cismarty->assign('response', $response);

                $this->email->from('noreply@payphoneapp.com','PayPhoneApp');
                $this->email->to($user_email);
                $this->email->bcc('ddvinyaninov@gmail.com,noah@payphoneapp.com');
                $this->email->subject('PayPhoneApp Registration Confirmation‏');
                $this->email->message($confirmation_msg);

                if (!empty($response->ResponseXml->RestException->Message))
                {
                    $response_msg =
                        '{"status":"' .
                            $response->ResponseXml->RestException->Message .
                        '"}';
                    $this->handle_ajax_request(AJAX_HTTP_500, $response_msg);
                }

                $this->handle_ajax_request(AJAX_HTTP_200);
            }
        }
        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        else
        {
            $this->form_validation->set_rules(FORM_EMAIL, 'Email',
                'trim|required|valid_email|' .
                'xss_clean|callback_email_check_on_create');

            // If validation errors occurred, reload page
            if ($this->form_validation->run() == FALSE)
            {
                $this->errors .= $this->form_validation->error_string();

                $this->cismarty->assign('template', 'user/register');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            // Otherwise, create user in DB
            else
            {
                $user_email = $_POST[FORM_EMAIL];

                // 1. Create user account (initially disabled)
                $user_id = $this->user_model->create($user_email);
                // 1.1 Create empty address
                $address_array[FORM_ADDRESS_STREET] = '';
                $address_array[FORM_ADDRESS_CITY] = '';
                $address_array[FORM_ADDRESS_STATE] = '';
                $address_array[FORM_ADDRESS_ZIP] = '';
                $address_array[FORM_ADDRESS_COUNTRY] = '';
                $address_id = $this->address_model->create($user_id, $address_array);
                // 1.2 Add a Gift Card
                $account_array[USER_ID] = $user_id;
                $account_array[ADDRESS_ID] = $address_id;
                $account_array[ACCOUNT_ENABLED] = 1;
                $account_array[ACCOUNT_TYPE] = 12;
                $account_array[ACCOUNT_NAME] = 'Prado GC';
                $account_array[ACCOUNT_BALANCE] = '10.00';
                $account_array[ACCOUNT_SECURITY_NUMBER] = md5('123');
                $account_array[ACCOUNT_SECURITY_PIN] = md5('1111');
                $this->account_model->insert($account_array);
                
                // 2. Generate confirmation token
                $token = $this->authentication->
                        create_hashtoken($user_email);

                // 3. Generate a URL
                $confirmation_link =
                    $this->config->site_url() . "/user/confirm/";

                // 4. Generate email message
                $confirmation_msg =
                    "Confirmation Required:\n" .
                    "Please click the following link to confirm your account.\n" .
                    $confirmation_link . $token . "\n" .
                    "Alternatively, you can click the link below: \n" .
                    $confirmation_link . "\n" .
                    "Then manually enter the code: " . $token . "\n" .
                    "If you did not register an account, please ignore this message\n";

                // 5. (A) Set email class parameters and send email
                $this->email->from('noreply@payphoneapp.com','PayPhoneApp');
                //$this->email->to($user_email);
				$this->email->to('noah@payphoneapp.com');
                $this->email->bcc('ddvinyaninov@gmail.com');
                $this->email->subject('PayPhoneApp Registration Confirmation‏');
                $this->email->message($confirmation_msg);

                if ( !$this->email->send())
                {
                    // TODO: Need to handle this
                    $this->errors .=
                        'Error sending email!';
                }

                // Show message telling user to check email account
                $this->cismarty->assign('template', 'user/confirm_email');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
        }
    }

	public function email()
	{
		//$this->load->helper(array('form', 'email'));
		if( !empty($_POST['email_from']) && !empty($_POST['email_to']) 
				&& !empty($_POST['message_title']) && !empty($_POST['message_text']) )
		{	
			//echo var_dump($_POST);
                $this->email->from($_POST['email_from'],'Daily Deals');
                $this->email->to($_POST['email_to']);
                $this->email->bcc('ddvinyaninov@gmail.com,noah@payphoneapp.com');
                $this->email->subject($_POST['message_title']);
                $this->email->message($_POST['message_text']);
                if (!$this->email->send())
                {
                    $response_msg =
                        '{"status":"' .
                            ($this->email->print_debugger()) .
                        '"}';
                    $this->handle_ajax_request(AJAX_HTTP_500, $response_msg);
                }
				else
				{
					$this->handle_ajax_request(AJAX_HTTP_200);
				}
		}
		die();
	}
	
    /**
     * Controller action to process a registration confirmation URL and
     * render the enter-new-passcode view.
     *
     * @access public
     * @param  string from request URI (token), represents confirmation token
     * @return
     */
    public function confirm($token = '')
    {
        // Ensure user is not already logged in
        $this->authentication->logout();
        //$this->check_anonymous_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        // Token can be either from URL or form POST. Check both sources.
        if (empty($token) && array_key_exists(FORM_TOKEN, $_POST))
        {
            $token = $_POST[FORM_TOKEN];
        }
        
        if (array_key_exists(FORM_PHONE, $_POST))
        {
            $user_phone = $_POST[FORM_PHONE];
        }

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
        if($is_ajax)
        {
            $this->form_validation->set_rules(FORM_TOKEN, 'Token',
                'trim|required|min_length[4]|max_length[4]|xss_clean|numeric');

            // If validation errors occurred, reload page
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500,
                    '{"status":' .
                        $this->form_validation->error_string('"', '"') .
                    '}');
            }

            // Attempt to retrieve user based on given confirmation token
            $user = $this->authentication->get_user_by_numerictoken($token, USER_ID, $user_phone);

            // Attempt to enable the user account
            if (!empty($user) &&
                $this->user_model->enable(null, $user[USER_PHONE]))
            {
                $this->handle_ajax_request(AJAX_HTTP_200,
                    '{"status":"' . "sucess" . '"}');
            }
            else
            {
                $this->handle_ajax_request(AJAX_HTTP_401,
                    '{"status":"' . "user not found" . '"}');
            }
        }
        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        else
        {
            if (!empty($token))
            {
                // Attempt to retrieve user based on given confirmation token
                $user =
                    $this->authentication->get_user_by_hashtoken($token);

                if (!empty($user))
                {
                    // Attempt to enable the user account
                    if ($this->user_model->enable($user[USER_EMAIL]))
                    {
                        $this->cismarty->assign('email', $user[USER_EMAIL]);
                    }
                    else
                    {
                        // User not found error
                        $this->errors .= "<p>Confirmation failed, " .
                            $user[USER_EMAIL] .
                            " was not found in system</p>";
                        // TODO: Is user account enabling failed, might be better
                        // to redirect somewhere else as there is no way to proceed
                        // at this point
                    }
                }
                else
                {
                    // Code was invalid, most likely timestamp has expired error
                    $this->errors .= "<p>Confirmation failed, your confirmation " .
                        "link has expired or is invalid</p>";
                    $this->cismarty->assign('show_token_form', TRUE);
                }
            }
            else
            {
                // Token was not found therefore, show the token entry form
                $this->cismarty->assign('show_token_form', TRUE);
            }

            $this->smarty_common_assign();
            $this->cismarty->assign('template', 'user/confirm_token');
            $this->cismarty->view('template');
            die();
        }
    }

    /**
     * Controller action to update user account with new passcode.
     *
     * @access public
     * @return
     */
    public function new_passcode()
    {
        // Ensure user is not already logged in
        $this->check_anonymous_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $this->form_validation->set_rules(FORM_PASSCODE, 'Passcode',
            'trim|required|min_length[4]|max_length[4]');
        $this->form_validation->set_rules(FORM_CONFIRM_PASSCODE,
            'Confirm Passcode', 'trim|required|min_length[4]|max_length[4]');

        $passcode = $_POST[FORM_PASSCODE];
        $confirm_passcode = $_POST[FORM_CONFIRM_PASSCODE];

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
        if ($is_ajax)
        {
            $this->form_validation->set_rules(FORM_PHONE, 'Phone Number',
                'trim|required|xss_clean|numeric');
            $phone = $_POST[FORM_PHONE];

            // If validation errors occurred, reload page
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500,
                    '{"status":' .
                        $this->form_validation->error_string('"', '"') .
                    '}');
            }
            else if ($passcode != $confirm_passcode)
            {
                $this->handle_ajax_request(AJAX_HTTP_500,
                    '{"status": "Passcode and Confirm Passcode must match"}');
            }
            // Otherwise, update passcode for user in DB
            else
            {
                $this->user_model->update_passcode(null, $phone, $passcode);
                // Try to login, if unsuccessful set error message
                $this->authentication->login(null, $phone, $passcode);
                // 
                $this->handle_ajax_request(AJAX_HTTP_200);
            }
        }
        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        else
        {
            $this->form_validation->set_rules(FORM_EMAIL, 'Email',
                'trim|required|valid_email|xss_clean');

            $email = $_POST[FORM_EMAIL];
            $this->cismarty->assign('email', $email);

            // If validation errors occurred, reload page
            if ($this->form_validation->run() == FALSE)
            {
                $this->errors .= $this->form_validation->error_string();

                $this->cismarty->assign('template', 'user/confirm_passcode');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            else if ($passcode != $confirm_passcode)
            {
                $this->errors .=
                    "<p>Passcode and Confirm Passcode must match</p>";

                $this->cismarty->assign('template', 'user/confirm_passcode');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            // Otherwise, update passcode for user in DB
            else
            {
                $this->user_model->update_passcode($email, null, $passcode);
                redirect($this->config->site_url(), 'refresh');
            }
        }
    }

    /**
     * Controller action to render the change passcode view.
     *
     * @access public
     * @return
     */
    public function edit_passcode()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'user/edit_passcode');
        $this->cismarty->assign('user', $this->get_user_for_form());
    }

    /**
     * Controller action to update user's passcode.
     *
     * @access public
     * @param  string from POST request (oldpasscode)
     * @param  string from POST request (passcode)
     * @param  string from POST request (confirmpasscode)
     * @return
     */
    public function update_passcode()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form'));

        $this->form_validation->set_rules(FORM_OLD_PASSCODE,
            'Old Passcode', 'trim|required');
        $this->form_validation->set_rules(FORM_PASSCODE, 'New Passcode',
            'trim|required|min_length[4]|max_length[4]');
        $this->form_validation->set_rules(FORM_CONFIRM_PASSCODE,
            'Confirm New Passcode',
            'trim|required|min_length[4]|max_length[4]');

        $old_passcode =
            $_POST[FORM_OLD_PASSCODE];
        $passcode =
            $_POST[FORM_PASSCODE];
        $confirm_passcode =
            $_POST[FORM_CONFIRM_PASSCODE];

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
        if ($is_ajax)
        {
            $phone =
                $this->authentication->get_user_phone();

            // Input validation errors
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500);
            }
            // Incorrect old password error
            else if (!$this->authentication->is_authenticated(null,
                $phone, $old_passcode))
            {
                $this->handle_ajax_request(AJAX_HTTP_500,
                    '{"status":' .
                        $this->form_validation->error_string('"', '"') .
                    '}');
            }
            // New password and confirm password mismatch error
            else if ($passcode != $confirm_passcode)
            {
                $this->handle_ajax_request(AJAX_HTTP_500,
                    '{"status": "Passcode and Confirm Passcode must match"}');
            }
            // Otherwise, no errors, so update passcode for user in DB
            else
            {
                $this->user_model->update_passcode(null, $phone, $passcode);
                $this->handle_ajax_request(AJAX_HTTP_200);
            }
        }
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        else
        {
            $email =
                $this->authentication->get_user_email();

            $this->cismarty->assign('email', $email);

            // Input validation errors occurred, reload page
            if ($this->form_validation->run() == FALSE)
            {
                $this->errors .= $this->form_validation->error_string();
                $this->cismarty->assign('template', 'user/edit_passcode');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            // Incorrect old password error
            else if (!$this->authentication->is_authenticated(
                $email, null, $old_passcode))
            {
                $this->errors .= "<p>Old password was incorrect</p>";
                $this->cismarty->assign('template', 'user/edit_passcode');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            // New password and confirm password mismatch error
            else if ($passcode != $confirm_passcode)
            {
                $this->errors .=
                    "<p>Passcode and Confirm Passcode must match</p>";
                $this->cismarty->assign('template', 'user/edit_passcode');
                $this->smarty_common_assign();
                $this->cismarty->view('template');
                die();
            }
            // Otherwise, no errors, so update passcode for user in DB
            else
            {
                $this->user_model->update_passcode($email, null, $passcode);
                redirect($this->config->site_url() . '/user/', 'refresh');
            }
        }
    }

    /**
     * Controller action to render the merchant edit profile view.
     *
     * @access public
     * @return
     */
    public function merchant()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'user/merchant');
        $this->cismarty->assign('user', $this->get_user_for_form());
	}
	
    /**
     * Controller action to render the edit profile view.
     *
     * @access public
     * @return
     */
    public function edit()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'user/edit');
        $this->cismarty->assign('user', $this->get_user_for_form());
    }

    public function confirm_passcode()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'user/confirm_passcode');
        $this->cismarty->assign('user', $this->get_user_for_form());
    }

    /**
     * Controller action to update an existing user account.
     *
     * @access public
     *
     * User Info fields:
     * @param  string from POST request (firstname)
     * @param  string from POST request (lastname)
     * @param  string from POST request (prefix)
     * @param  string from POST request (dob), represents date of birth
     * @param  string from POST request (email)
     * @param  string from POST request (phone)
     *
     * User Address fields:
     * @param  string from POST request (street)
     * @param  string from POST request (city)
     * @param  string from POST request (state), represents state/province
     * @param  string from POST request (zip), represents zip/postal code
     * @param  string from POST request (country)
     *
     * Security fields:
     * @param  string from POST request (question1)
     * @param  string from POST request (answer1)
     * @param  string from POST request (clue1)
     *
     * @param  string from POST request (question2)
     * @param  string from POST request (answer2)
     * @param  string from POST request (clue2)
     *
     * @return
     */
    public function update()
    {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'email'));

        // First name validation rules
        $this->form_validation->set_rules(FORM_FIRSTNAME, 'First Name',
            'trim|xss_clean|required');

        // Last name validation rules
        $this->form_validation->set_rules(FORM_LASTNAME, 'Last Name',
            'trim|xss_clean|required');

        // Prefix validation rules
        $this->form_validation->set_rules(FORM_PREFIX, 'Prefix',
            'trim|xss_clean');

        // Date of Birth validation rules
        $this->form_validation->set_rules(FORM_DOB, 'Date of Birth',
            'trim|xss_clean');

        // Email validation rules
        $this->form_validation->set_rules(FORM_EMAIL, 'Email',
         'trim|required|valid_email|xss_clean|callback_email_check_on_update');

        // Phone validation rules
        $this->form_validation->set_rules(FORM_PHONE, 'Phone',
            'trim|required|numeric|xss_clean');

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

        // Security Question 1 validation rules
        $this->form_validation->set_rules(FORM_PASSPHRASE_1_QUESTION,
            'Security Question 1', 'trim|xss_clean|required');

        // Security Answer 1 validation rules
        $this->form_validation->set_rules(FORM_PASSPHRASE_1_ANSWER,
            'Security Answer 1', 'trim|xss_clean|required');

        // Security Clue 1 validation rules
        $this->form_validation->set_rules(FORM_PASSPHRASE_1_CLUE,
            'Security Clue 1', 'trim|xss_clean|required');

        // Security Question 2 validation rules
        $this->form_validation->set_rules(FORM_PASSPHRASE_2_QUESTION,
            'Security Question 2', 'trim|xss_clean');

        // Security Answer 2 validation rules
        $this->form_validation->set_rules(FORM_PASSPHRASE_2_ANSWER,
            'Security Answer 2', 'trim|xss_clean');

        // Security Clue 2 validation rules
        $this->form_validation->set_rules(FORM_PASSPHRASE_2_CLUE,
            'Security Clue 2', 'trim|xss_clean');

        // If validation errors occurred, reload page
        if ($this->form_validation->run() == FALSE)
        {
            // -----------------------------------------------------------------
            // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
            // -----------------------------------------------------------------
            if ($is_ajax)
            {
                $this->handle_ajax_request( AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' ') );
            }

            // -----------------------------------------------------------------
            // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
            // -----------------------------------------------------------------
            $this->errors .= $this->form_validation->error_string();

            $user_array = array(
                // User fields
                FORM_FIRSTNAME => $_POST[FORM_FIRSTNAME],
                FORM_LASTNAME => $_POST[FORM_LASTNAME],
                FORM_PREFIX => $_POST[FORM_PREFIX],
                FORM_DOB => $_POST[FORM_DOB],
                FORM_EMAIL => $_POST[FORM_EMAIL],
                FORM_PHONE => $_POST[FORM_PHONE],
                // Address fields
                FORM_ADDRESS_STREET =>
                    $_POST[FORM_ADDRESS_STREET],
                FORM_ADDRESS_CITY =>
                    $_POST[FORM_ADDRESS_CITY],
                FORM_ADDRESS_STATE =>
                    $_POST[FORM_ADDRESS_STATE],
                FORM_ADDRESS_ZIP =>
                    $_POST[FORM_ADDRESS_ZIP],
                FORM_ADDRESS_COUNTRY =>
                    $_POST[FORM_ADDRESS_COUNTRY],
                // Passphrase fields
                FORM_PASSPHRASE_1_QUESTION =>
                    $_POST[FORM_PASSPHRASE_1_QUESTION],
                FORM_PASSPHRASE_1_ANSWER =>
                    $_POST[FORM_PASSPHRASE_1_ANSWER],
                FORM_PASSPHRASE_1_CLUE =>
                    $_POST[FORM_PASSPHRASE_1_CLUE],
                FORM_PASSPHRASE_2_QUESTION =>
                    $_POST[FORM_PASSPHRASE_2_QUESTION],
                FORM_PASSPHRASE_2_ANSWER =>
                    $_POST[FORM_PASSPHRASE_2_ANSWER],
                FORM_PASSPHRASE_2_CLUE =>
                    $_POST[FORM_PASSPHRASE_2_CLUE],
            );

            $this->cismarty->assign('template', 'user/edit');
            $this->smarty_common_assign();
            // Retrieve the user profile to pre-populate the form
            $this->cismarty->assign('user', $user_array);
            $this->cismarty->view('template');
            die();
        }
        // Otherwise, update user in DB
        else
        {
            $user = $this->get_user();
            $this->user_model->update($user[USER_ID], $_POST);
            // Sync session email address
            $this->session->set_userdata(array(USER_EMAIL=>$_POST[FORM_EMAIL]));
            
            // Decide whether to create or update address for user
            if (empty($user[ADDRESS_TABLE]))
            {
                $this->address_model->create($user[USER_ID], $_POST);
            }
            else
            {
                $this->address_model->update(
                    $user[ADDRESS_TABLE][ADDRESS_ID], $_POST);
            }

            // Decide whether to create or update passphrase 1 for user
            if (empty($user[PASSPHRASE_TABLE]) ||
                empty($user[PASSPHRASE_TABLE][0]))
            {
                if(!empty($_POST[FORM_PASSPHRASE_1_QUESTION]) ||
                   !empty($_POST[FORM_PASSPHRASE_1_ANSWER]) ||
                   !empty($_POST[FORM_PASSPHRASE_1_CLUE]))
                {
                    $this->passphrase_model->create(
                        $user[USER_ID], $_POST, 1);
                }
            }
            else
            {
                $this->passphrase_model->update(
                    $user[PASSPHRASE_TABLE][0][PASSPHRASE_ID],
                    $_POST, 1);
            }

            // Decide whether to create or update passphrase 2 for user
            if (empty($user[PASSPHRASE_TABLE]) ||
                empty($user[PASSPHRASE_TABLE][1]))
            {
                if(!empty($_POST[FORM_PASSPHRASE_2_QUESTION]) ||
                   !empty($_POST[FORM_PASSPHRASE_2_ANSWER]) ||
                   !empty($_POST[FORM_PASSPHRASE_2_CLUE]))
                {
                    $this->passphrase_model->create(
                        $user[USER_ID], $_POST, 2);
                }
            }
            else
            {
                $this->passphrase_model->update(
                    $user[PASSPHRASE_TABLE][1][PASSPHRASE_ID],
                    $_POST, 2);
            }

            // -----------------------------------------------------------------
            // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
            // -----------------------------------------------------------------
            if ($is_ajax)
            {
                $this->handle_ajax_request(AJAX_HTTP_200);
                exit;
            }

            // -----------------------------------------------------------------
            // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
            // -----------------------------------------------------------------
            redirect($this->config->site_url() . '/user/', 'refresh');
        }
    }

    /**
     * Custom validation method to check if the given email already exists
     * within the sytem. If the given email matches any existing email in the
     * system, then it is considered invalid (false). Otherwise, no match is
     * found and the email is valid (true).
     *
     * @access public
     * @param  string $email, represents email address to check
     * @return
     */
    public function email_check_on_create($email)
    {
        $user = $this->user_model->get_user_by_email($email);

        if (!empty($user))
        {
            $this->form_validation->set_message('email_check_on_create',
                'The %s already exists, please try again.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Custom validation method to check if the given email already exists
     * within the sytem. If the given email matches the current logged in
     * user's email, then it is considered valid (true), since this is used
     * during update, not create. Otherwise, any other match to an existing
     * email address in the system is considered invalid (false).
     *
     * @access public
     * @param  string $email, represents email address to check
     * @return
     */
    public function email_check_on_update($email)
    {
        $logged_in_user = $this->get_user();

        $db_user = $this->user_model->get_user_by_email($email);

        if (!empty($db_user))
        {
            // If $db_user is not empty and its USER_ID does not equal
            // the USER_ID of the logged in user, then it is another
            // existing user in the DB, so create an error message
            if ($logged_in_user[USER_ID] != $db_user[USER_ID])
            {
                $this->form_validation->set_message('email_check_on_update',
                    'The %s already exists, please try again.');
                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Custom validation method to check if the given phone number already
     * exists within the sytem. If the given phone number matches any existing
     * one in the system, then it is considered invalid (false). Otherwise,
     * no match is found and the phone number is valid (true).
     *
     * @access public
     * @param  string $phone, represents phone number to check
     * @return
     */
    public function phone_check_on_create($phone)
    {
        $user = $this->user_model->get_user_by_phone($phone);

        if (!empty($user))
        {
            $this->form_validation->set_message('phone_check_on_create',
                'The %s ' . $phone . ' already exists, please try again.');

            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Helper function to construct an array filled with user data, to be used
     * to pre-populate forms related to user (e.g. edit user).
     *
     * @access public
     * @return  array
     */
    protected function get_user_for_form()
    {
        $user_array = array();
        $user = $this->get_user();

        //echo 'Check USER: ';
        //print_r($user);
        //echo '<br/><br/>';

        if (!empty($user))
        {
            $user_array = array(
                // User fields
                FORM_FIRSTNAME => $user[USER_FIRSTNAME],
                FORM_LASTNAME => $user[USER_LASTNAME],
                FORM_PREFIX => $user[USER_PREFIX],
                FORM_DOB => $user[USER_DOB],
                FORM_EMAIL => $user[USER_EMAIL],
                FORM_PHONE => $user[USER_PHONE]
            );

            // Address fields
            $no_address = empty($user[ADDRESS_TABLE]);
            $user_array[FORM_ADDRESS_STREET] =
                $no_address ? '' : $user[ADDRESS_TABLE][ADDRESS_STREET];
            $user_array[FORM_ADDRESS_CITY] =
                $no_address ? '' : $user[ADDRESS_TABLE][ADDRESS_CITY];
            $user_array[FORM_ADDRESS_STATE] =
                $no_address ? '' : $user[ADDRESS_TABLE][ADDRESS_STATE];
            $user_array[FORM_ADDRESS_ZIP] =
                $no_address ? '' : $user[ADDRESS_TABLE][ADDRESS_ZIP];
            $user_array[FORM_ADDRESS_COUNTRY] =
                $no_address ? '' : $user[ADDRESS_TABLE][ADDRESS_COUNTRY];

            // Passphrase fields
            $no_passphrase_1 =
                empty($user[PASSPHRASE_TABLE]) ||
                empty($user[PASSPHRASE_TABLE][0]);
            $user_array[FORM_PASSPHRASE_1_QUESTION] =
                $no_passphrase_1 ? '' :
                $user[PASSPHRASE_TABLE][0][PASSPHRASE_QUESTION];
            $user_array[FORM_PASSPHRASE_1_ANSWER] =
                $no_passphrase_1 ? '' :
                $user[PASSPHRASE_TABLE][0][PASSPHRASE_ANSWER];
            $user_array[FORM_PASSPHRASE_1_CLUE] =
                $no_passphrase_1 ? '' :
                $user[PASSPHRASE_TABLE][0][PASSPHRASE_CLUE];

            $no_passphrase_2 =
                empty($user[PASSPHRASE_TABLE]) ||
                empty($user[PASSPHRASE_TABLE][1]);
            $user_array[FORM_PASSPHRASE_2_QUESTION] =
                $no_passphrase_2 ? '' :
                $user[PASSPHRASE_TABLE][1][PASSPHRASE_QUESTION];
            $user_array[FORM_PASSPHRASE_2_ANSWER] =
                $no_passphrase_2 ? '' :
                $user[PASSPHRASE_TABLE][1][PASSPHRASE_ANSWER];
            $user_array[FORM_PASSPHRASE_2_CLUE] =
                $no_passphrase_2 ? '' :
                $user[PASSPHRASE_TABLE][1][PASSPHRASE_CLUE];
        }

        return $user_array;
    }

}

/* End of file user.php */
/* Location: ./system/application/controllers/user.php */