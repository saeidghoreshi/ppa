<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ', 							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 					'ab');
define('FOPEN_READ_WRITE_CREATE', 				'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 			'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

/*
|--------------------------------------------------------------------------
| PPA User Table Field Names
|--------------------------------------------------------------------------
*/
define('USER_TABLE', 'user');
define('USER_ID', 'user_id');
define('USER_FIRSTNAME', 'user_firstname');
define('USER_LASTNAME', 'user_lastname');
define('USER_PREFIX', 'user_prefix');
define('USER_EMAIL', 'user_email');
define('USER_PHONE', 'user_phone');
define('USER_DOB', 'user_dob');
define('USER_PASSCODE', 'user_passcode');
define('USER_ENABLED', 'user_enabled');

/*
|--------------------------------------------------------------------------
| PPA Account Table Field Names
|--------------------------------------------------------------------------
*/
define('ACCOUNTTYPE_TABLE', 'accounttype');
define('ACCOUNTTYPE_ID', 'accounttype_id');
define('ACCOUNTTYPE_NAME', 'accounttype_name');

/*
|--------------------------------------------------------------------------
| PPA Account Table Field Names
|--------------------------------------------------------------------------
*/
define('ACCOUNT_TABLE', 'account');
define('ACCOUNT_ID', 'account_id');
define('ACCOUNT_NUMBER', 'account_number');
define('ACCOUNT_BALANCE', 'account_balance');
define('ACCOUNT_TYPE', 'account_type');
define('ACCOUNT_NAME', 'account_name');
define('ACCOUNT_ENABLED', 'account_enabled');
define('PAYMENT_GATEWAY', 'payment_gateway');
define('ACCOUNT_EMAIL', 'account_email');

define('ACCOUNT_FIRSTNAME', 'account_firstname');
define('ACCOUNT_LASTNAME', 'account_lastname');
define('ACCOUNT_PREFIX', 'account_prefix');

// Bank specific fields
define('ACCOUNT_TRANSIT', 'account_transit');
define('ACCOUNT_INSTITUTION', 'account_institution');

// Visa specific fields
define('ACCOUNT_SECURITY_NUMBER', 'account_security_number');
define('ACCOUNT_SECURITY_PIN', 'account_security_pin');
// Note for expiry, account_expiry is the actual table field, but
// account_expiry_year and account_expiry_month are fields used to separate
// out the year and month values to display as drop down menus in form
define('ACCOUNT_EXPIRY', 'account_expiry');
define('ACCOUNT_EXPIRY_YEAR', 'account_expiry_year');
define('ACCOUNT_EXPIRY_MONTH', 'account_expiry_month');

/*
|--------------------------------------------------------------------------
| PPA Merchant Table Field Names
|--------------------------------------------------------------------------
*/
define('MERCHANT_TABLE', 'merchant');
define('MERCHANT_ID', 'merchant_id');
define('MERCHANT_NAME', 'merchant_name');

/*
|--------------------------------------------------------------------------
| PPA Transaction Table Field Names
|--------------------------------------------------------------------------
*/
define('TRANSACTION_TABLE', 'transaction');
define('REQUEST_TABLE', 'request');
define('TRANSACTION_ID', 'transaction_id');
define('TRANSACTION_AMOUNT', 'transaction_amount');
define('TRANSACTION_MERCHANT_NOTE', 'transaction_merchant_note');
define('TRANSACTION_USER_NOTE', 'transaction_user_note');
define('TRANSACTION_PAID', 'transaction_paid');
define('TRANSACTION_CANCELLED', 'transaction_cancelled');
define('TRANSACTION_FLAGGED', 'transaction_flagged');
define('TRANSACTION_CANCELLED_REASON', 'transaction_cancelled_reason');
define('TRANSACTION_DELETED', 'transaction_deleted');
define('TRANSACTION_LOCATION', 'transaction_location');

define('TRANSACTION_DATETIME_REQUESTED', 'transaction_datetime_requested');

define('TRANSACTION_DATETIME_PAID', 'transaction_datetime_paid');
define('TRANSACTION_DATE_PAID', 'transaction_date_paid');
define('TRANSACTION_TIME_PAID', 'transaction_time_paid');

// Order by columns for sorting transactions
define('TRANSACTION_ORDERBY_DATE', 'dt');
define('TRANSACTION_ORDERBY_ID', 'tr');
define('TRANSACTION_ORDERBY_TIME', 'tm');
define('TRANSACTION_ORDERBY_MERCHANT', 'mc');
define('TRANSACTION_ORDERBY_USER', 'us');
define('TRANSACTION_ORDERBY_NOTE', 'nt');
define('TRANSACTION_ORDERBY_STATUS', 'st');
define('TRANSACTION_ORDERBY_AMOUNT', 'am');
define('TRANSACTION_ORDERBY_ACCOUNT', 'at');
define('TRANSACTION_ORDERBY_FLAG', 'fl');
define('TRANSACTION_ORDER_DESC', 'dc');

/*
 * GEO variables
 */
define('GEO_DISTANCE_GC', 20000);
define('GEO_DISTANCE_CC', 2000);

/*
|--------------------------------------------------------------------------
| PPA Message Table Field Names
|--------------------------------------------------------------------------
*/
define('MESSAGE_TABLE', 'message');
define('MESSAGE_ID', 'message_id');
define('MESSAGE_TITLE', 'message_title');
define('MESSAGE_TEXT', 'message_text');

/*
|--------------------------------------------------------------------------
| PPA Passphrase Table Field Names
|--------------------------------------------------------------------------
*/
define('PASSPHRASE_TABLE', 'passphrase');
define('PASSPHRASE_ID', 'passphrase_id');
define('PASSPHRASE_ANSWER', 'passphrase_answer');
define('PASSPHRASE_QUESTION', 'passphrase_question');
define('PASSPHRASE_CLUE', 'passphrase_clue');

/*
|--------------------------------------------------------------------------
| PPA Passphrase Table Field Names
|--------------------------------------------------------------------------
*/
define('ADDRESS_TABLE', 'address');
define('ADDRESS_ID', 'address_id');
define('ADDRESS_TYPE', 'address_type');
define('ADDRESS_STREET', 'address_street');
define('ADDRESS_CITY', 'address_city');
define('ADDRESS_STATE', 'address_state');
define('ADDRESS_ZIP', 'address_zip');
define('ADDRESS_COUNTRY', 'address_country');
define('ADDRESS_ENABLED', 'address_enabled');

/*
|--------------------------------------------------------------------------
| FORM: Field Names for Forms (these are coupled to the Smarty template
| *.tpl files)
|--------------------------------------------------------------------------
*/
// This field stores the DB Id value of whatever object the form is modifying
// (e.g. user Id, or account Id)
define('FORM_ENTITY_ID', 'id');

define('FORM_FIRSTNAME', 'firstname');
define('FORM_LASTNAME', 'lastname');
define('FORM_PREFIX', 'prefix');
define('FORM_EMAIL', 'email');
define('FORM_PHONE', 'phone');
define('FORM_DOB', 'dob');
define('FORM_PASSCODE', 'passcode');
define('FORM_CONFIRM_PASSCODE', 'confirmpasscode');
define('FORM_OLD_PASSCODE', 'oldpasscode');
define('FORM_TOKEN', 'token');

define('FORM_ADDRESS_STREET', 'street');
define('FORM_ADDRESS_CITY', 'city');
define('FORM_ADDRESS_ZIP', 'zip');
define('FORM_ADDRESS_STATE', 'state');
define('FORM_ADDRESS_COUNTRY', 'country');
define('FORM_ADDRESS_TYPE', 'addresstype');

define('FORM_PASSPHRASE_1_QUESTION', 'question1');
define('FORM_PASSPHRASE_1_ANSWER', 'answer1');
define('FORM_PASSPHRASE_1_CLUE', 'clue1');
define('FORM_PASSPHRASE_2_QUESTION', 'question2');
define('FORM_PASSPHRASE_2_ANSWER', 'answer2');
define('FORM_PASSPHRASE_2_CLUE', 'clue2');
// Below strings are used for verify passphrase form
define('FORM_PASSPHRASE_ANSWER', 'answer');
define('FORM_PASSPHRASE_QUESTION', 'question');
define('FORM_PASSPHRASE_SELECTED', 'selectedpassphrase');

define('FORM_ACCOUNT_TYPE', 'accounttype');
// Bank fields
define('FORM_ACCOUNT_BANKNAME', 'bankname');
define('FORM_ACCOUNT_BANKNUMBER', 'banknumber');
define('FORM_ACCOUNT_BANKNUMBERCONFIRM', 'banknumberconfirm');
define('FORM_ACCOUNT_TRANSIT', 'transit');
define('FORM_ACCOUNT_INSTITUTION', 'institution');
// Visa fields
define('FORM_ACCOUNT_NICKNAME', 'nickname');
define('FORM_ACCOUNT_CREDITCARDNUMBER', 'creditcardnumber');
define('FORM_ACCOUNT_EXPIRY', 'expiry');
define('FORM_ACCOUNT_EXPIRY_YEAR', 'year');
define('FORM_ACCOUNT_EXPIRY_MONTH', 'month');
define('FORM_ACCOUNT_SECURITY_NUMBER', 'securitynumber');
define('FORM_ACCOUNT_SECURITY_PIN', 'securitypin');

define('FORM_TRANS_ANNOTATION', 'annotation');
define('FORM_TRANS_FLAGGED', 'flagged');

/*
|--------------------------------------------------------------------------
| Constants related to Type of Account
|--------------------------------------------------------------------------
*/
define('TYPE_ACCOUNT_VISA', 1);
define('TYPE_ACCOUNT_MC', 2);
define('TYPE_ACCOUNT_AMEX', 3);
define('TYPE_ACCOUNT_VISA_STR', 'Visa');
define('TYPE_ACCOUNT_BANK', 10);
define('TYPE_ACCOUNT_BANK_STR', 'Bank Account');
define('TYPE_ACCOUNT_PAYPAL', 9);
define('TYPE_ACCOUNT_PAYPAL_STR', 'Bank Account');

/*
|--------------------------------------------------------------------------
| Constants related to Type of Address
|--------------------------------------------------------------------------
*/
define('TYPE_ADDRESS_PROFILE', 'profile');
define('TYPE_ADDRESS_BILLING', 'billing');
define('TYPE_ADDRESS_PAYPAL', 'paypal');

/*
|--------------------------------------------------------------------------
| Constants related to Bean Stream Response
|--------------------------------------------------------------------------
*/
define('BEANSTREAM_CUSTOMER_CODE', 'customerCode');
define('BEANSTREAM_RESPONSE_CODE', 'responseCode');
define('BEANSTREAM_RESPONSE_MSG', 'responseMessage');
define('BEANSTREAM_CARD_NUMBER', 'trnCardNumber');
define('BEANSTREAM_CARD_TYPE', 'cardType');

/*
|--------------------------------------------------------------------------
| Constants related to User Registration
|--------------------------------------------------------------------------
*/
// Define the period of time (in days) from when a confirmation URL is
// generated for a specific user to when the user must click the confirmation
// URL before the registartion URL expires
define('USER_REG_TIMELIMIT', 1);

// Define a persistent unique phrase to be used to create security MD5 hash
// tokens for registration confirmation
define('USER_REG_CONFIRM_PHRASE', "P@yPh0ne@pp_Is_V3ry_S3cur3");

/*
|--------------------------------------------------------------------------
| Constants related to Authentication
|--------------------------------------------------------------------------
*/
// Name of parameter included within PPA cookie
define('AUTH_LOGGED_IN_FLAG', "logged_in");

/*
|--------------------------------------------------------------------------
| Constants related to Ajax requests
|--------------------------------------------------------------------------
*/
define('AJAX_JSON', "json");
define('AJAX_HTTP_200', "200");
define('AJAX_HTTP_401', "401");
define('AJAX_HTTP_500', "500");

/* End of file constants.php */
/* Location: ./system/application/config/constants.php */