<?php

//require_once(APPPATH.'libraries/Ppa_controller.php');

/**
 * Controller for Account related actions.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Account extends Ppa_controller {

	function __construct() {
		// init
		parent::__construct();
		$this->cismarty->assign('config', $this->config->config);
		$this->load->model('user_model');
		$this->load->model('account_model');
		$this->load->model('address_model');
		$this->load->library('Ppa_gateway');
		$this->load->library($this->config->item('payment_getaway') . '_gateway', array(), 'payment_gateway');
	}

	function Account() {
		
	}

	/**
	 * Default controller action to display accounts for a user profile.
	 *
	 * @access public
	 * @return
	 */
	public function index() {
		// If user is not logged in, redirect to login/signup
		$this->check_login_redirect();

		// Create flag indicating whether HTTP request is normal or Ajax
		$is_ajax = !empty($_POST[AJAX_JSON]);

		// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
		if ($is_ajax) {
			$params = array();
			if (!empty($_POST['latitude']) && !empty($_POST['longitude'])) {
				$params['latitude'] = $_POST['latitude'];
				$params['longitude'] = $_POST['longitude'];
			}
			$this->load->helper('geo');
			if ($this->authentication->get_user_email()) {
				$user_accounts = $this->account_model->get_all_by_email(
						$this->authentication->get_user_email(), $params);
			} elseif ($this->authentication->get_user_phone()) {
				$user_accounts = $this->account_model->get_all_by_phone(
						$this->authentication->get_user_phone(), $params);
			}

			$this->handle_ajax_request(AJAX_HTTP_200, $user_accounts);
		} else {
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
	public function add() {
		$this->check_login_redirect();

		// init
		$this->smarty_common_assign();
		$this->cismarty->assign('template', 'account/edit');
		$this->cismarty->assign('account', $this->get_account_data($this->get_user()));
		$this->cismarty->assign('actionUrl', $this->config->site_url() . '/account/create');
	}

	public function paypal($action='step0',$session=null) {
		
		if( $action == 'session' )
		{
			$this->load->helper('crypt');
			if(isset($session)) {
				@session_destroy();
				session_id(rc4('j4utto3jd',base64_decode($session)));
				@session_start();
				redirect('/account/paypal/step2/');
			}
			if(isset($_POST['session'])) {
				redirect('/account/paypal/session/'.base64_encode(rc4('j4utto3jd',$_POST['session'])), 'refresh');
			}
			exit;
		}
		
		$this->check_login_redirect();
			
		require_once APPPATH . 'libraries/paypal/AdaptiveAccounts.php';
		require_once APPPATH . 'libraries/paypal/Stub/AA/AdaptiveAccountsProxy.php';
		require_once APPPATH . 'libraries/paypal/AdaptivePayments.php';
		//require_once APPPATH . 'libraries/paypal/web_constants.php';

		$this->load->helper('mobile_detect');
        //return is_mobile();

		$user = $this->get_user_for_form();
		$account = $this->get_account_data($user);
		$actionUrl = '';		
		$template = '';
		$errors = '';
		
//echo var_dump($user);
		switch ($action) {
			case 'step0':
				// Init Request
				$template = 'account/paypal_step2';
				$actionUrl = $this->config->site_url() . '/account/paypal/step3';
				break;
			case 'step1':
				
				if( !empty($_POST) )
				{
				// Paypap Assign Request
					try {

						$currencyCode = 'CAD';
						$accountType = 'Personal';
						$namefirstName = $_POST["firstname"];
						$namemiddleName = '';
						$namelastName = $_POST["lastname"];
						$dateOfBirth = $_POST[FORM_DOB];
						$addressline1 = $_POST["street"];
						$addressline2 = null;
						$addresscity = $_POST["city"];
						$addressstate = $_POST["state"];
						$addresspostalCode = $_POST["zip"];
						$name_salutation = $_POST["prefix"];
						$addresscountryCode = 'CA';
						$contactPhoneNumber = $_POST[FORM_PHONE];
						$citizenshipCountryCode = 'CA';
						$notificationURL = 'http://stranger.paypal.com/cgi-bin/ipntest.cgi';
						$partnerField1 = '';
						$sandboxEmail = $this->config->item('DeveloperEmailAccount');
						$email = $_POST['email'];

						$CARequest = new CreateAccountRequest();
						$CARequest->accountType = $accountType;

						$address = new AddressType();
						if( !empty($addresscity)) $address->city = $addresscity;
						if( !empty($addresscountryCode)) $address->countryCode = $addresscountryCode;
						if( !empty($addressline1)) $address->line1 = $addressline1;
						if( !empty($addressline2)) $address->line2 = $addressline2;
						if( !empty($addresspostalCode)) $address->postalCode = $addresspostalCode;
						if( !empty($addressstate)) $address->state = $addressstate;
						$CARequest->address = $address;

						$CARequest->citizenshipCountryCode = $citizenshipCountryCode;
						$CARequest->clientDetails = new ClientDetailsType();
						$CARequest->clientDetails->applicationId = $this->config->item('ApplicationID');
						$CARequest->clientDetails->deviceId = $this->config->item('DeviceID');
						$CARequest->clientDetails->ipAddress = $this->input->server('REMOTE_ADDR');

						if( !empty($contactPhoneNumber)) $CARequest->contactPhoneNumber = $contactPhoneNumber;
						if( !empty($currencyCode)) $CARequest->currencyCode = $currencyCode;
						if( !empty($dateOfBirth)) $CARequest->dateOfBirth = $dateOfBirth;

						$name = new NameType();
						if( !empty($namefirstName)) $name->firstName = $namefirstName;
						if( !empty($namemiddleName)) $name->middleName = $namemiddleName;
						if( !empty($namelastName)) $name->lastName = $namelastName;
						if( !empty($name_salutation)) $name->salutation = $name_salutation;
						if( !empty($name)) $CARequest->name = $name;

						$CARequest->notificationURL = $notificationURL;
						$CARequest->partnerField1 = $partnerField1;
						$CARequest->preferredLanguageCode = "en_US";

						$rEnvelope = new RequestEnvelope();
						$rEnvelope->errorLanguage = "en_US";
						$CARequest->requestEnvelope = $rEnvelope;

						$returnURL = $this->config->site_url() . '/account/paypal/step2'; //CreateAccountDetails.php

						$CARequest->createAccountWebOptions = new CreateAccountWebOptionsType();
						$CARequest->createAccountWebOptions->returnUrl = $returnURL;
						$CARequest->createAccountWebOptions->useMiniBrowser = is_mobile();
						$CARequest->registrationType = "WEB";

						//$CARequest->sandboxEmailAddress = $sandboxEmail;
						$CARequest->emailAddress = $email;

						$aa = new AdaptiveAccounts();
						$aa->sandBoxEmailAddress = $sandboxEmail;
						$response = $aa->CreateAccount($CARequest);
						if (strtoupper($aa->isSuccess) == 'FAILURE') {
							$_SESSION['FAULTMSG'] = $aa->getLastError();
							if( !empty($aa->getLastError()->error))
							{
								$errors = '';
								if( is_array($aa->getLastError()->error) )
								{
									foreach($aa->getLastError()->error AS $error)
									{
										$errors .= $error->message."\n";
									}
									$this->cismarty->assign('paypal_error', 'Paypal '. $errors);
								}
								else
								{
									$errors .= $aa->getLastError()->error->message;
								}
								
								$this->cismarty->assign('paypal_error', nl2br($errors));
							}
						} else {
							// update paypal references
							if (!empty($response->createAccountKey) && !empty($response->accountId)) {
								$currencyCode = 'CAD';
								$accountType = 'Personal';
								$namefirstName = $_POST["firstname"];
								$namemiddleName = '';
								$namelastName = $_POST["lastname"];
								$dateOfBirth = $_POST[FORM_DOB];
								$addressline1 = $_POST["street"];
								$addressline2 = null;
								$addresscity = $_POST["city"];
								$addressstate = $_POST["state"];
								$addresspostalCode = $_POST["zip"];
								$name_salutation = $_POST["prefix"];
								$addresscountryCode = 'CA';
								$contactPhoneNumber = $_POST[FORM_PHONE];


								$this->user_model->update($user[USER_ID], array(
									'paypal_key' => $response->createAccountKey,
									'paypal_id' => $response->accountId, 
									'paypal_email' => $email)
								);

								$paypal_address = array(FORM_ADDRESS_STREET => $addressline1,
									FORM_ADDRESS_CITY => $addresscity,
									FORM_ADDRESS_STATE => $addressstate,
									FORM_ADDRESS_ZIP => $addresspostalCode,
									FORM_ADDRESS_COUNTRY => 'Canada',
									FORM_ADDRESS_TYPE => TYPE_ADDRESS_PAYPAL, // Paypal Address Type
								);

								if (!$paypal_address_existing = $this->address_model->get_by_user($user[USER_ID], TYPE_ADDRESS_PAYPAL)) {
									$this->address_model->create($user[USER_ID], $paypal_address);
								} else {
									$this->address_model->update($paypal_address_existing[ADDRESS_ID], $paypal_address);
								}
							}
							$location = $response->redirectURL;
							if (!empty($location)) {
								$_SESSION['createdAccount'] = serialize($response);
								header("Location: $location");
							}
						}
					} catch (Exception $ex) {

						$fault = new FaultMessage();
						$errorData = new ErrorData();
						$errorData->errorId = $ex->getFile();
						$errorData->message = $ex->getMessage();
						$fault->error = $errorData;
						$_SESSION['FAULTMSG'] = $fault;
						$location = $this->config->site_url() . '/account/paypal/error2';
						header("Location: $location");
					}
					
				}
				
				$template = 'account/paypal';
				$actionUrl = $this->config->site_url() . '/account/paypal/step1';
				
				break;
				
			case 'step2':
				
				// Paypal Assign Confirmation
				$this->cismarty->assign('createdAccount', empty($_SESSION['createdAccount'])?null:unserialize($_SESSION['createdAccount']) );
				$template = 'account/paypal_step2';
				$actionUrl = $this->config->site_url() . '/account/paypal/step3';	
				break;
			
			case 'step3':
				
				// Preapprove Paypal
				$template = 'account/paypal_step3';
				$actionUrl = $this->config->site_url() . '/account/paypal/step2';

				try {
					$returnURL = $this->config->site_url() . '/account/paypal/step4';
					$cancelURL = $this->config->site_url() . '/account/paypal/cancel';
					$senderEmail = $_POST["email"];
					$startingDate = $_POST["startingDate"];
					$endingDate = $_POST["endingDate"];
					$maxNumberOfPayments = $_POST["maxNumberOfPayments"];
					$maxTotalAmountOfAllPayments = $_POST["maxTotalAmountOfAllPayments"];
					$currencyCode = 'CAD';
					$accountPin = $_POST[FORM_ACCOUNT_SECURITY_PIN];

					$preapprovalRequest = new PreapprovalRequest();
					$preapprovalRequest->cancelUrl = $cancelURL;
					$preapprovalRequest->returnUrl = $returnURL;
					$preapprovalRequest->clientDetails = new ClientDetailsType();
					$preapprovalRequest->clientDetails->applicationId = $this->config->item('ApplicationID');
					$preapprovalRequest->clientDetails->deviceId = $this->config->item('DeviceID');
					$preapprovalRequest->clientDetails->ipAddress = $this->input->server('REMOTE_ADDR');
					$preapprovalRequest->currencyCode = $currencyCode;
					$preapprovalRequest->startingDate = $startingDate;
					$preapprovalRequest->endingDate = $endingDate;
					$preapprovalRequest->maxNumberOfPayments = $maxNumberOfPayments;
					$preapprovalRequest->maxTotalAmountOfAllPayments = $maxTotalAmountOfAllPayments;
					$preapprovalRequest->requestEnvelope = new RequestEnvelope();
					$preapprovalRequest->requestEnvelope->errorLanguage = "en_US";
					$preapprovalRequest->senderEmail = $senderEmail;

					$ap = new AdaptivePayments();
					$response = $ap->Preapproval($preapprovalRequest);

					if (strtoupper($ap->isSuccess) == 'FAILURE' || empty($_POST["securitypin"]) ) {
						
						if( !empty($ap->getLastError()->error->errorId) && intval($ap->getLastError()->error->errorId) == 589039 )
						{
							// Paypal email does not exist
							$_SESSION['paypal_email'] = $senderEmail;
							redirect('/account/paypal/step1');
						}
						else
						{
							if( empty($_POST["securitypin"]) )
							{
								$this->cismarty->assign('paypal_error', 'Security PIN empty' );
							}
							else if( !empty($ap) && !empty($ap->getLastError()->error))
							{
								if( is_array($ap->getLastError()->error) )
								{
									$errors = '';
									foreach($ap->getLastError()->error AS $error)
									{
										$errors .= $error->message."\n";
									}
									$this->cismarty->assign('paypal_error', 'Paypal '. $errors);
								}
								else
								{
									$errors .= $ap->getLastError()->error->message;
								}
								
								$this->cismarty->assign('paypal_error', nl2br($errors));
							}
							else
							{
								$this->cismarty->assign('paypal_error', 'Unknown PayPal Error');
							}
							$this->cismarty->assign('createdAccount', empty($_SESSION['createdAccount'])?null:unserialize($_SESSION['createdAccount']) );
							$template = 'account/paypal_step2';
							$actionUrl = $this->config->site_url() . '/account/paypal/step3';	
						}

						$_SESSION['FAULTMSG'] = $ap->getLastError();
					} else {
						
						if (!$paypal_address_existing = $this->address_model->get_by_user($user[USER_ID], TYPE_ADDRESS_PAYPAL)) {
							// Create the address for the account in PPA
							$paypal_address = array(FORM_ADDRESS_STREET => 'n/a',
								FORM_ADDRESS_CITY => 'n/a',
								FORM_ADDRESS_STATE => 'n/a',
								FORM_ADDRESS_ZIP => 'n/a',
								FORM_ADDRESS_COUNTRY => 'Canada',
								FORM_ADDRESS_TYPE => TYPE_ADDRESS_PAYPAL, // Paypal Address Type
							);

							$address_id = $this->address_model->create($user[USER_ID], $paypal_address);
						} else {
							$address_id = $paypal_address_existing[ADDRESS_ID];
						}


						$paypal_account = array(ADDRESS_ID => $address_id,
							FORM_ACCOUNT_TYPE => TYPE_ACCOUNT_PAYPAL, // Paypal Account Type
							FORM_ACCOUNT_NICKNAME => 'PayPal',
							FORM_FIRSTNAME => $user['firstname'],
							FORM_LASTNAME => $user['lastname'],
							FORM_PREFIX => $user['prefix'],
							FORM_ACCOUNT_CREDITCARDNUMBER => $response->preapprovalKey,
							FORM_ACCOUNT_EXPIRY => $endingDate,
							FORM_ACCOUNT_SECURITY_NUMBER => '',
							FORM_ACCOUNT_SECURITY_PIN => $accountPin,
							ACCOUNT_ENABLED => 0,
							ACCOUNT_EMAIL => $senderEmail,
							PAYMENT_GATEWAY => 'Paypal'
						);

						if ($paypal_account_existing = $this->account_model->get_by_user_id($user[USER_ID], $account_enabled = array(0, 1), $account_type = 9)) {
							// Update preapprovalKey
							$account_id = $paypal_account_existing[0][ACCOUNT_ID];
							$this->account_model->update($account_id, $paypal_account);
						} else {
							// Create the account in PPA and save preapprovalKey
							$account_id = $this->account_model->create($address_id, $user[USER_ID], $paypal_account);
						}
						
						$this->user_model->update($user[USER_ID], array(
							'paypal_email' => $senderEmail)
						);

						unset($_SESSION['paypal_email']);

						// Redirect to paypal.com here
						$_SESSION['preapprovalKey'] = $response->preapprovalKey;
						$token = $response->preapprovalKey;
						$payPalURL = $this->config->item('PayPalUrl') . $token;
						
						/*
						echo '<pre>';
						echo 'url: <a href="'.$payPalURL.'" target="_self">click</a>';
						echo var_dump($_SESSION);
						echo var_dump($response);
						echo '</pre>';
						exit;
						/**/
						
						//header("Location: " . $payPalURL);
						redirect($payPalURL);
					}
				} catch (Exception $ex) {

					$fault = new FaultMessage();
					$errorData = new ErrorData();
					$errorData->errorId = $ex->getFile();
					$errorData->message = $ex->getMessage();
					$fault->error = $errorData;
					$_SESSION['FAULTMSG'] = $fault;
					redirect('/account/paypal/error');
				}


				break;
				
			case 'step4':
				
				// Check Paypal configuration
				
				$paypal_account_existing = $this->account_model->get_by_user_id($user[USER_ID], $account_enabled = array(0,1), $account_type = TYPE_ACCOUNT_PAYPAL);
		
				if( !empty($paypal_account_existing) && $paypal_account_existing[0][ACCOUNT_ENABLED] )
				{
					// Paypal configured and enabled
					if( is_mobile() )
					{
						redirect('account/paypal/success');
					}
					else
					{
						redirect('account/info/'.$paypal_account_existing[0][ACCOUNT_ID]);
					}
				}
				if( empty($paypal_account_existing) )
				{
					// No Paypal configured
					redirect('account/info/paypal/step1');
				}
				else
				{
					// Paypal configured but not confirmed
					try {

						$preapprovalKey = $paypal_account_existing[0]['real_account_number'];

						$PDRequest = new PreapprovalDetailsRequest();

						$PDRequest->requestEnvelope = new RequestEnvelope();
						$PDRequest->requestEnvelope->errorLanguage = "en_US";
						$PDRequest->preapprovalKey = $preapprovalKey;

						$ap = new AdaptivePayments();
						$response = $ap->PreapprovalDetails($PDRequest);
						
						if (strtoupper($ap->isSuccess) == 'FAILURE')
						{
							$_SESSION['FAULTMSG'] = $ap->getLastError();
							redirect('/account/paypal/error');
						}
						else
						{
							// Enable Paypal and redirect to account info
							$this->account_model->enable($paypal_account_existing[0][ACCOUNT_ID]);
							
							// Paypal configured and enabled
							if ( is_mobile() )
							{
								redirect('account/paypal/success');
							}
							else
							{
								redirect('account/info/' . $paypal_account_existing[0][ACCOUNT_ID]);
							}
						}
						
					} catch (Exception $ex) {

						$fault = new FaultMessage();
						$errorData = new ErrorData();
						$errorData->errorId = $ex->getFile();
						$errorData->message = $ex->getMessage();
						$fault->error = $errorData;
						$_SESSION['FAULTMSG'] = $fault;
						redirect('/account/paypal/error');
					}
				}
				
				break;
				
			case 'success':
				
				// Success
				$template = 'account/paypal_success';
				$actionUrl = $this->config->site_url() . '/account/paypal/step1';
				
				break;
				
			case 'cancel':
				
				// Cancel 
				$template = 'account/paypal_cancel';
				$actionUrl = $this->config->site_url() . '/account/paypal/step1';
				
				break;
				
			case 'error':
				
				// Error Handling
				$template = 'account/paypal';
				if( !empty($_SESSION['FAULTMSG']) ) 
				{
					$this->cismarty->assign('errors', $_SESSION['FAULTMSG']);
				}
				$actionUrl = $this->config->site_url() . '/account/paypal/step1';
				//echo var_dump($error);
				
				break;
		}

		$this->smarty_common_assign();
		$this->cismarty->assign('template', $template);
		$this->cismarty->assign('account', $this->get_account_data($this->get_user()));
		$this->cismarty->assign('user', $user);
		$this->cismarty->assign('actionUrl', $actionUrl);
		
	}

	/**
	 * Controller action to add a new account.
	 *
	 * @access public
	 * @param  string from POST request (email), represents email address
	 * @return
	 */
	public function create() {
		// If user is not logged in, redirect to login/signup
		$this->check_login_redirect();

		// Create flag indicating whether HTTP request is normal or Ajax
		$is_ajax = !empty($_POST[AJAX_JSON]);

		$_POST[FORM_ADDRESS_STATE] = $this->process_state($_POST[FORM_ADDRESS_STATE]);

		$this->load->library('form_validation');
		$this->load->helper(array('form', 'date'));

		$this->cismarty->assign('actionUrl', $this->config->site_url() . '/account/create');
		$this->cismarty->assign('template', 'account/edit');

		// Type of Account validation rules
		$this->form_validation->set_rules(FORM_ACCOUNT_TYPE, 'Type of Account', 'trim|xss_clean|required');

		// Validate the Type of Account field by itself, need to ensure it has
		// valid value before proceeding with anything else
		if ($this->form_validation->run() == FALSE) {
			// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
			if ($is_ajax) {
				$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ', ' '));
			}

			$this->errors .= $this->form_validation->error_string();

			$this->smarty_common_assign();
			// Retrieve values from POST to re-populate the form
			$this->cismarty->assign('account', $this->get_account_data($_POST));
			$this->cismarty->view('template');
			die();
		}
		// Validate all other fields
		else {
			// First name validation rules
			$this->form_validation->set_rules(FORM_FIRSTNAME, 'First Name', 'trim|xss_clean|required');

			// Last name validation rules
			$this->form_validation->set_rules(FORM_LASTNAME, 'Last Name', 'trim|xss_clean|required');

			// Prefix validation rules
			$this->form_validation->set_rules(FORM_PREFIX, 'Prefix', 'trim|xss_clean');

			// Street Address validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_STREET, 'Street Address', 'trim|xss_clean|required');

			// City validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_CITY, 'City', 'trim|xss_clean|required');

			// State validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_STATE, 'State/Province', 'trim|xss_clean|required');

			// Zip validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_ZIP, 'Zip/Postal Code', 'trim|xss_clean|required');

			// Country validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_COUNTRY, 'Country', 'trim|xss_clean|required');

			// If account is a Bank Account
			if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK) {
				$this->form_validation->set_rules(FORM_ACCOUNT_BANKNAME, 'Bank Name', 'trim|xss_clean|required');

				$this->form_validation->set_rules(FORM_ACCOUNT_TRANSIT, 'Transit Number', 'trim|xss_clean|required|min_length[5]|max_length[5]');

				$this->form_validation->set_rules(FORM_ACCOUNT_INSTITUTION, 'Institution Number', 'trim|xss_clean|required|min_length[3]|max_length[3]');

				$this->form_validation->set_rules(FORM_ACCOUNT_BANKNUMBER, 'Bank Number', 'trim|xss_clean|required|min_length[1]|max_length[12]');

				$this->form_validation->set_rules(
						FORM_ACCOUNT_BANKNUMBERCONFIRM, 'Reenter Bank Number', 'trim|xss_clean|required');
			}
			// If account is a Credit Card Account
			else if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_VISA) {
				$this->form_validation->set_rules(FORM_ACCOUNT_NICKNAME, 'Nickname for Account', 'trim|xss_clean|required|min_length[2]|max_length[15]');

				$this->form_validation->set_rules(FORM_ACCOUNT_CREDITCARDNUMBER, 'Credit Card Number', 'trim|xss_clean|required|min_length[15]|max_length[16]');

				$this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_MONTH, 'Expiry Month', 'trim|xss_clean|required');

				$this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_YEAR, 'Expiry Year', 'trim|xss_clean|required');

				$this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_NUMBER, 'Security Number on Card', 'trim|xss_clean|required|min_length[3]|max_length[3]');

				$this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_PIN, 'Security PIN', 'trim|xss_clean|required|min_length[4]|max_length[4]');
			}

			// Validate input fields
			if ($this->form_validation->run() == FALSE) {
				// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
				if ($is_ajax) {
					$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ', ' '));
				}

				$this->errors .= $this->form_validation->error_string();

				$this->smarty_common_assign();
				// Retrieve values from POST to re-populate the form
				$this->cismarty->assign('account', $this->get_account_data($_POST));
				$this->cismarty->view('template');
				die();
			}
			// If this is of Type Bank Account, ensure bank number fields match
			else if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK &&
					$_POST[FORM_ACCOUNT_BANKNUMBER] !=
					$_POST[FORM_ACCOUNT_BANKNUMBERCONFIRM]) {
				// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
				if ($is_ajax) {
					$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ', ' '));
				}

				$this->errors .= "<p>Bank Numbers must match</p>";

				$this->smarty_common_assign();
				// Retrieve values from POST to re-populate the form
				$this->cismarty->assign('account', $this->get_account_data($_POST));
				$this->cismarty->view('template');
				die();
			}
			// Otherwise, create new account in DB
			else {
				// Retrieve user
				$user = $this->get_user();

				// Create the address for the account in PPA
				$address_id =
						$this->address_model->create($user[USER_ID], $_POST);

				// Create the account in PPA
				$account_id =
						$this->account_model->create($address_id, $user[USER_ID], $_POST);

				// --------------- BEGIN Bean Stream Integration ---------------
				$response = $this->payment_profile_push($_POST, $user, $account_id, 'A', 'N', '1');

				// If profile already exists update instead of saving
				/* if(!empty($response[BEANSTREAM_RESPONSE_CODE]) &&
				  intval($response[BEANSTREAM_RESPONSE_CODE]) == 16)
				  {
				  $response = $this->payment_profile_push($_POST, $user,
				  'A', 'M', '1');

				  $response['responseMessage'] .=
				  ' Force Update on existing record.';
				  } */

				// Update database account_enabled field after successful
				// Beanstream update
				if (!empty($response[BEANSTREAM_RESPONSE_CODE])
						&& intval($response[BEANSTREAM_RESPONSE_CODE]) == 1) {
					$this->account_model->enable($account_id);

					// Change the account number to safe version, i.e.
					// containing XXX to hide number
					/* if (array_key_exists(BEANSTREAM_CARD_NUMBER, $response))
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
					if ($is_ajax) {
						$this->handle_ajax_request(AJAX_HTTP_200);
					}
				} else {
					// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
					if ($is_ajax) {
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
	public function enable($account_id = null) {
		$this->check_login_redirect();

		$status = $this->account_model->enable($account_id);
		redirect($this->config->site_url() . '/account/', 'refresh');
		die();
		$account = $this->account_model->get_by_id($account_id);
		$status = 0;

		// First check if account exists
		if (!empty($account)) {
			// Next, check if account is already enabled
			if ($account[ACCOUNT_ENABLED]) {
				$status = 2;
			}
			// Otherwise, account is not enabled, so attempt to enable it
			else {
				// --------------- BEGIN Bean Stream Integration ---------------
				$user = $this->get_user();
				$account_data = $this->get_account_data($account);

				$response = $this->payment_profile_push($account_data, $user, $account_id, 'A', 'M', '1');
				// ---------------- END Bean Stream Integration ----------------
				// If Bean Stream call was successful
				if (!empty($response[BEANSTREAM_RESPONSE_CODE]) &&
						intval($response[BEANSTREAM_RESPONSE_CODE]) == 1) {
					// Status will be either 1 (success) or 0 (fail)
					$status = $this->account_model->enable($account_id);
				}

				$this->cismarty->assign('response', $response);
			}
		} else {
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
	public function suspend($account_id = null) {
		// If user is not logged in, redirect to login/signup
		$this->check_login_redirect();

		$account = $this->account_model->get_by_id($account_id);

		// First, check if the account exists
		if (!empty($account)) {
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
	public function disable($account_id = null) {
		$this->suspend($account_id);
		//
		// If user is not logged in, redirect to login/signup
		$this->check_login_redirect();

		// Create flag indicating whether HTTP request is normal or Ajax
		$is_ajax = !empty($_POST[AJAX_JSON]);

		$account = $this->account_model->get_by_id($account_id);
		$status = 0;

		// First, check if the account exists
		if (!empty($account)) {
			// Next, check if the account is already disabled
			if (!$account[ACCOUNT_ENABLED]) {
				// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
				if ($is_ajax) {
					$this->handle_ajax_request(AJAX_HTTP_500, null, 'Account not Enabled');
				}
				$status = 2;
			}
			// Otherwise, account is not disabled, so attempt to disable it
			else {
				// --------------- BEGIN Bean Stream Integration ---------------
				$user = $this->get_user();
				$account_data = $this->get_account_data($account);

				$response = $this->payment_profile_push($account_data, $user, $account_id, 'D', 'M');
				// ---------------- END Bean Stream Integration ----------------
				// If Bean Stream call was successful
				if (!empty($response[BEANSTREAM_RESPONSE_CODE]) &&
						intval($response[BEANSTREAM_RESPONSE_CODE]) == 1) {
					// Status will be either 1 (success) or 0 (fail)
					$status = $this->account_model->disable($account_id);

					// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
					if ($is_ajax) {
						$this->handle_ajax_request(AJAX_HTTP_200);
					}
				} else {
					// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
					if ($is_ajax) {
						// TODO: Handle BS response
						//$this->handle_ajax_request(AJAX_HTTP_500, null, implode('; ', $response));
						$this->handle_ajax_request(AJAX_HTTP_200);
					}
				}

				$this->cismarty->assign('response', $response);
			}
		} else {
			// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
			if ($is_ajax) {
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
	public function info($account_id = null, $order_by = null, $limit = 10, $descend = true) {
		// If user is not logged in, redirect to login/signup
		$this->check_login_redirect();

		// Create flag indicating whether HTTP request is normal or Ajax
		$is_ajax = !empty($_POST[AJAX_JSON]);

		// Retrieve user email in order to query for transactions
		$user_email = $this->authentication->get_user_email();

		// Retrieve account info
		$account_data =
				$this->account_model->get_by_id($account_id, array(ACCOUNT_ENABLED => TRUE));

		// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
		if ($is_ajax) {
			$this->handle_ajax_request(AJAX_HTTP_200, $account_data);
		}


		$this->load->model('transaction_model');

		// init
		$this->smarty_common_assign();
		$this->cismarty->assign('template', 'account/info');

		// Get account data
		$this->cismarty->assign('account', $this->get_account_data($account_data));

		// Get transaction data for this account
		$transactions = array();

		if (!empty($order_by)) {
			if ($order_by == TRANSACTION_ORDERBY_DATE) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_DATE_PAID), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_ID) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_ID), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_TIME) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_TIME_PAID), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_MERCHANT) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => MERCHANT_NAME), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_NOTE) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_MERCHANT_NOTE), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_STATUS) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_PAID), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_AMOUNT) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_AMOUNT), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_ACCOUNT) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => ACCOUNT_NAME), $descend, $limit);
			} else if ($order_by == TRANSACTION_ORDERBY_FLAG) {
				$transactions =
						$this->transaction_model->get_order_by($user_email, $account_id, array(1 => TRANSACTION_FLAGGED), $descend, $limit);
			}
		} else {
			$transactions = $this->transaction_model->get_order_by($user_email, $account_id);
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
	public function edit($account_id = null) {
		$this->check_login_redirect();

		// init
		$this->smarty_common_assign();
		$this->cismarty->assign('actionUrl', $this->config->site_url() . '/account/update');
		$this->cismarty->assign('template', 'account/edit');
		$this->cismarty->assign('account', $this->get_account_data(
						$this->account_model->get_by_id($account_id, array(ACCOUNT_ENABLED => TRUE))));
	}

	/**
	 * Controller action to update an existing account.
	 *
	 * @access public
	 * @return
	 */
	public function update() {
		// If user is not logged in, redirect to login/signup
		$this->check_login_redirect();

		// Create flag indicating whether HTTP request is normal or Ajax
		$is_ajax = !empty($_POST[AJAX_JSON]);

		$this->load->library('form_validation');
		$this->load->helper(array('form', 'date'));

		$this->cismarty->assign('actionUrl', $this->config->site_url() . '/account/update');
		$this->cismarty->assign('template', 'account/edit');

		// Type of Account validation rules
		$this->form_validation->set_rules(FORM_ACCOUNT_TYPE, 'Type of Account', 'trim|xss_clean|required');

		$account_id = $_POST[FORM_ENTITY_ID];

		// Validate the Type of Account field by itself, need to ensure it has
		// valid value before proceeding with anything else
		if ($this->form_validation->run() == FALSE) {
			// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
			if ($is_ajax) {
				$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ', ' '));
			}

			$this->errors .= $this->form_validation->error_string();
			$this->smarty_common_assign();
			// Retrieve values from POST to re-populate the form
			$this->cismarty->assign('account', $this->get_account_data($_POST));
			$this->cismarty->view('template');
			die();
		}
		// Validate all other fields
		else {
			// First name validation rules
			$this->form_validation->set_rules(FORM_FIRSTNAME, 'First Name', 'trim|xss_clean|required');

			// Last name validation rules
			$this->form_validation->set_rules(FORM_LASTNAME, 'Last Name', 'trim|xss_clean|required');

			// Prefix validation rules
			$this->form_validation->set_rules(FORM_PREFIX, 'Prefix', 'trim|xss_clean');

			// Street Address validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_STREET, 'Street Address', 'trim|xss_clean|required');

			// City validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_CITY, 'City', 'trim|xss_clean|required');

			// State validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_STATE, 'State/Province', 'trim|xss_clean|required');

			// Zip validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_ZIP, 'Zip/Postal Code', 'trim|xss_clean|required');

			// Country validation rules
			$this->form_validation->set_rules(FORM_ADDRESS_COUNTRY, 'Country', 'trim|xss_clean|required');

			// If account is a Bank Account
			if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK) {
				$this->form_validation->set_rules(FORM_ACCOUNT_BANKNAME, 'Bank Name', 'trim|xss_clean|required');

				$this->form_validation->set_rules(FORM_ACCOUNT_TRANSIT, 'Transit Number', 'trim|xss_clean|required|min_length[5]|max_length[5]');

				$this->form_validation->set_rules(FORM_ACCOUNT_INSTITUTION, 'Institution Number', 'trim|xss_clean|required|min_length[3]|max_length[3]');

				$this->form_validation->set_rules(FORM_ACCOUNT_BANKNUMBER, 'Bank Number', 'trim|xss_clean|required|min_length[1]|max_length[12]');

				$this->form_validation->set_rules(
						FORM_ACCOUNT_BANKNUMBERCONFIRM, 'Reenter Bank Number', 'trim|xss_clean|required');
			}
			// If account is a Credit Card Account
			else if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_VISA) {
				$this->form_validation->set_rules(FORM_ACCOUNT_NICKNAME, 'Nickname for Account', 'trim|xss_clean|required|min_length[2]|max_length[15]');

				// Do not verify CC number if it has X - not going to be updated with BS
				if (!preg_match('/x/ims', $_POST[FORM_ACCOUNT_CREDITCARDNUMBER])) {
					$this->form_validation->set_rules(FORM_ACCOUNT_CREDITCARDNUMBER, 'Credit Card Number', 'trim|xss_clean|required|min_length[15]|max_length[16]');
				}

				$this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_MONTH, 'Expiry Month', 'trim|xss_clean|required');

				$this->form_validation->set_rules(FORM_ACCOUNT_EXPIRY_YEAR, 'Expiry Year', 'trim|xss_clean|required');

				$this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_NUMBER, 'Security Number on Card', 'trim|xss_clean|required|min_length[3]|max_length[3]');

				$this->form_validation->set_rules(FORM_ACCOUNT_SECURITY_PIN, 'Security PIN', 'trim|xss_clean|required|min_length[4]|max_length[4]');
			}

			// Validate input fields
			if ($this->form_validation->run() == FALSE) {
				// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
				if ($is_ajax) {
					$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ', ' '));
				}

				$this->errors .= $this->form_validation->error_string();
				$this->smarty_common_assign();
				// Retrieve values from POST to re-populate the form
				$this->cismarty->assign('account', $this->get_account_data($_POST));
				$this->cismarty->view('template');
				die();
			}
			// If this is of Type Bank Account, ensure bank number fields match
			else if ($_POST[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK &&
					$_POST[FORM_ACCOUNT_BANKNUMBER] !=
					$_POST[FORM_ACCOUNT_BANKNUMBERCONFIRM]) {
				// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
				if ($is_ajax) {
					$this->handle_ajax_request(AJAX_HTTP_500, null, 'Bank  Numbers does not match ');
				}

				$this->errors .= "<p>Bank Numbers must match</p>";
				$this->smarty_common_assign();
				// Retrieve values from POST to re-populate the form
				$this->cismarty->assign('account', $this->get_account_data($_POST));
				$this->cismarty->view('template');
				die();
			}
			// Otherwise, update existing account in DB
			else {
				// Retrieve user
				$user = $this->get_user();

				// Retrieve existing address record for this account, based on
				// account Id value
				$account = $this->account_model->get_by_id($account_id, array(ACCOUNT_ENABLED => TRUE));

				// --------------- BEGIN Bean Stream Integration ---------------
				if (!preg_match('/x/ims', $_POST[FORM_ACCOUNT_CREDITCARDNUMBER])) {
					$response = $this->payment_profile_push($_POST, $user, $account_id, 'A', 'M', '1');
				}
				// Update database account_enabled field after successful
				// Beanstream update
				if (preg_match('/x/ims', $_POST[FORM_ACCOUNT_CREDITCARDNUMBER]) || (!empty($response[BEANSTREAM_RESPONSE_CODE]) && intval($response[BEANSTREAM_RESPONSE_CODE]) == 1)) {
					// Update the existing address for this account
					$this->address_model->update($account[ADDRESS_ID], $_POST);
					// Update the account
					$this->account_model->update($account_id, $_POST);
					// Enable the account, do we need it?
					$this->account_model->enable($account_id);
					//$accounts = $this->account_model->get_by_user_id(
					//$user_id = null, $account_enabled = array(0, 1));
					// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
					if ($is_ajax) {
						$this->handle_ajax_request(AJAX_HTTP_200);
					} else {
						redirect($this->config->site_url() . '/account/', 'refresh');
						die();
					}
				} else {
					// REQUEST TYPE: AJAX (PHONEGAP CLIENT)
					if ($is_ajax) {
						// Handle BS response
						//$this->handle_ajax_request(AJAX_HTTP_500, null, $this->form_validation->error_string(' ',' '));
						//$this->handle_ajax_request(AJAX_HTTP_500, null, implode('; ', $this->form_validation->error_string(' ',' ')));
						//$this->handle_ajax_request(AJAX_HTTP_200);
						$this->handle_ajax_request(AJAX_HTTP_500, null, empty($response['errorMessage']) ? implode($response) : $response['errorMessage'] );
					} else {
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
                FORM_PHONE => $user[USER_PHONE],
                USER_ID => $user[USER_ID],
                'paypal_key' => $user['paypal_key'],
                'paypal_id' => $user['paypal_id']
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
	
	/**
	 * Helper function to construct an array filled with user data, to be used
	 * to pre-populate forms related to accounts (e.g. add or edit account).
	 *
	 * @access public
	 * @return  array
	 */
	protected function get_account_data($data = array()) {
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

		$account_array[PAYMENT_GATEWAY] =
				$this->get_form_data($data, array(PAYMENT_GATEWAY,
			PAYMENT_GATEWAY));

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

		$account_array[FORM_ACCOUNT_EXPIRY_YEAR] = str_pad(intval($year), 2, "0", STR_PAD_LEFT);
		;

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
	protected function payment_profile_push($data = null, $user = null, $account_id = null, $status = 'A', $operation_type = 'M', $velocity_identity = null) {
		$response = array();

		if (preg_match('/^canada|can$/ims', $data[FORM_ADDRESS_COUNTRY])) {
			$data[FORM_ADDRESS_COUNTRY] = 'CA';
		} elseif (preg_match('/^us|usa|united\s+states$/ims', $data[FORM_ADDRESS_COUNTRY])) {
			$data[FORM_ADDRESS_COUNTRY] = 'US';
		}
		
		$data[FORM_ADDRESS_STATE] = $this->process_state($data[FORM_ADDRESS_STATE]);

		/* print_r($data);
		  echo "<br/><br/><br/>";
		  //print_r($user);
		  // */

		if (array_key_exists(FORM_ACCOUNT_TYPE, $data)) {
			// For Bank Account records
			if ($data[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK) {
				// TODO: Missing data field for
				// ACCOUNT_NAME => $data[FORM_ACCOUNT_BANKNAME],
				$response = $this->payment_gateway->profile_push(
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
			else {
				// TODO: Missing field for
				// ACCOUNT_NAME => $data[FORM_ACCOUNT_NICKNAME],
				// ACCOUNT_SECURITY_NUMBER => $data[FORM_ACCOUNT_SECURITY_NUMBER]
				$response = $this->payment_gateway->profile_push(
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
	
	protected function process_state($state)
	{
		if (!preg_match('/^\w{2}$/ims', $state)) 
		{
			$pattern[] = "/Alabama/i";
			$pattern[] = "/Alaska/i";
			$pattern[] = "/American Samoa/i";
			$pattern[] = "/Arizona/i";
			$pattern[] = "/Arkansas/i";
			$pattern[] = "/Armed Forces Africa/i";
			$pattern[] = "/Armed Forces Americas/i";
			$pattern[] = "/Armed Forces Canada/i";
			$pattern[] = "/Armed Forces Europe/i";
			$pattern[] = "/Armed Forces Middle East/i";
			$pattern[] = "/Armed Forces Pacific/i";
			$pattern[] = "/California/i";
			$pattern[] = "/Colorado/i";
			$pattern[] = "/Connecticut/i";
			$pattern[] = "/Delaware/i";
			$pattern[] = "/District of Columbia/i";
			$pattern[] = "/Federated States Of Micronesia/i";
			$pattern[] = "/Florida/i";
			$pattern[] = "/Georgia/i";
			$pattern[] = "/Guam/i";
			$pattern[] = "/Hawaii/i";
			$pattern[] = "/Idaho/i";
			$pattern[] = "/Illinois/i";
			$pattern[] = "/Indiana/i";
			$pattern[] = "/Iowa/i";
			$pattern[] = "/Kansas/i";
			$pattern[] = "/Kentucky/i";
			$pattern[] = "/Louisiana/i";
			$pattern[] = "/Maine/i";
			$pattern[] = "/Marshall Islands/i";
			$pattern[] = "/Maryland/i";
			$pattern[] = "/Massachusetts/i";
			$pattern[] = "/Michigan/i";
			$pattern[] = "/Minnesota/i";
			$pattern[] = "/Mississippi/i";
			$pattern[] = "/Missouri/i";
			$pattern[] = "/Montana/i";
			$pattern[] = "/Nebraska/i";
			$pattern[] = "/Nevada/i";
			$pattern[] = "/New Hampshire/i";
			$pattern[] = "/New Jersey/i";
			$pattern[] = "/New Mexico/i";
			$pattern[] = "/New York/i";
			$pattern[] = "/North Carolina/i";
			$pattern[] = "/North Dakota/i";
			$pattern[] = "/Northern Mariana Islands/i";
			$pattern[] = "/Ohio/i";
			$pattern[] = "/Oklahoma/i";
			$pattern[] = "/Oregon/i";
			$pattern[] = "/Palau/i";
			$pattern[] = "/Pennsylvania/i";
			$pattern[] = "/Puerto Rico/i";
			$pattern[] = "/Rhode Island/i";
			$pattern[] = "/South Carolina/i";
			$pattern[] = "/South Dakota/i";
			$pattern[] = "/Tennessee/i";
			$pattern[] = "/Texas/i";
			$pattern[] = "/Utah/i";
			$pattern[] = "/Vermont/i";
			$pattern[] = "/Virgin Islands/i";
			$pattern[] = "/Virginia/i";
			$pattern[] = "/Washington/i";
			$pattern[] = "/West Virginia/i";
			$pattern[] = "/Wisconsin/i";
			$pattern[] = "/Wyoming/i";
			$pattern[] = "/Alberta/i";
			$pattern[] = "/British Columbia/i";
			$pattern[] = "/Manitoba/i";
			$pattern[] = "/Newfoundland/i";
			$pattern[] = "/New Brunswick/i";
			$pattern[] = "/Nova Scotia/i";
			$pattern[] = "/Northwest Territories/i";
			$pattern[] = "/Nunavut/i";
			$pattern[] = "/Ontario/i";
			$pattern[] = "/Prince Edward/i";
			$pattern[] = "/Quebec/i";
			$pattern[] = "/Saskatchewan/i";
			$pattern[] = "/Yukon/i";

			$replace[] = "AL";
			$replace[] = "AK";
			$replace[] = "AS";
			$replace[] = "AZ";
			$replace[] = "AR";
			$replace[] = "AF";
			$replace[] = "AA";
			$replace[] = "AC";
			$replace[] = "AE";
			$replace[] = "AM";
			$replace[] = "AP";
			$replace[] = "CA";
			$replace[] = "CO";
			$replace[] = "CT";
			$replace[] = "DE";
			$replace[] = "DC";
			$replace[] = "FM";
			$replace[] = "FL";
			$replace[] = "GA";
			$replace[] = "GU";
			$replace[] = "HI";
			$replace[] = "ID";
			$replace[] = "IL";
			$replace[] = "IN";
			$replace[] = "IA";
			$replace[] = "KS";
			$replace[] = "KY";
			$replace[] = "LA";
			$replace[] = "ME";
			$replace[] = "MH";
			$replace[] = "MD";
			$replace[] = "MA";
			$replace[] = "MI";
			$replace[] = "MN";
			$replace[] = "MS";
			$replace[] = "MO";
			$replace[] = "MT";
			$replace[] = "NE";
			$replace[] = "NV";
			$replace[] = "NH";
			$replace[] = "NJ";
			$replace[] = "NM";
			$replace[] = "NY";
			$replace[] = "NC";
			$replace[] = "ND";
			$replace[] = "MP";
			$replace[] = "OH";
			$replace[] = "OK";
			$replace[] = "OR";
			$replace[] = "PW";
			$replace[] = "PA";
			$replace[] = "PR";
			$replace[] = "RI";
			$replace[] = "SC";
			$replace[] = "SD";
			$replace[] = "TN";
			$replace[] = "TX";
			$replace[] = "UT";
			$replace[] = "VT";
			$replace[] = "VI";
			$replace[] = "VA";
			$replace[] = "WA";
			$replace[] = "WV";
			$replace[] = "WI";
			$replace[] = "WY";
			$replace[] = "AB";
			$replace[] = "BC";
			$replace[] = "MB";
			$replace[] = "NF";
			$replace[] = "NB";
			$replace[] = "NS";
			$replace[] = "NT";
			$replace[] = "NU";
			$replace[] = "ON";
			$replace[] = "PE";
			$replace[] = "QC";
			$replace[] = "SK";
			$replace[] = "YT";

			$state = preg_replace($pattern,$replace,$state);
		}
		
		return strtoupper($state);
	}

}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */