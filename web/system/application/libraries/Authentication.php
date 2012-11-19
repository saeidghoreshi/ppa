<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Authentication Class
 *
 * Performs authentication (login/logout) for the PayPhoneApp application.
 *
 * Also performs user management operations such as create user and delete
 * user.
 *
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 * @filesource
 */
class Authentication
{
    private $CI;

    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->model('user_model');
    }

    /**
     * Log ito system using the given set of credentials:
     *  1. email (or phone), and
     *  2. password
     *
     * And set application context into session , if $set_session is true.
     * It may seem strange to ever have $set_session false (since that
     * would defeat the purpose of login).
     *
     * However, there is a situation where we want to have $set_session false.
     * Namely, when we perform login but then need to verify the user's
     * passphrase. In this instance, the login itself is not enough to complete
     * authentication. We must also perform passphrase verification.
     *
     * @access	public
     * @param	string $email
     * @param	string $phone
     * @param	string $password
     * @param	bool, $set_session
     * @return	bool, true if login was successful, false otherwise
     */
    public function login($email = '', $phone = '', $password = '',
        $set_session = true)
    {
		
		$phone = preg_replace('/[^\d]+/','',$phone);
        $user = $this->get_authenticated_user($email, $phone, $password);

        if (!empty($user))
        {
            // Check if already logged in
            if (    (!empty($email) &&
                    $this->CI->session->userdata(USER_EMAIL) == $email)
                ||
                    (!empty($phone) &&
                    $this->CI->session->userdata(USER_PHONE) == $phone))
            {
                // User is already logged in.
                return null;
            }

            if ($set_session)
            {
                $this->set_session($user);
            }

            return $user;
        }
        else
        {
            return null;
        }
    }


    /**
     * Determine if the given credentials authenticate successfully against
     * an existing user in the system:
     *  1. email (or phone), and
     *  2. password
     *
     * Uses get_authenticated_user().
     *
     * @access	public
     * @param	string $email
     * @param	string $phone
     * @param	string $password
     * @return	bool, true if email/phone & password were authenticated
     *          successfully, false otherwise
     */
    public function is_authenticated($email = '', $phone = '',
        $password = '')
    {
        $user = $this->get_authenticated_user($email, $phone, $password);
        return !empty($user);
    }

    /**
     * Authenticate the given combination of credentials:
     *  1. email (or phone), and
     *  2. password
     *
     * Determine whether:
     *  - user email/phone & password are non-empty
     *  - user email/phone exists within system
     *  - user password matches password within system
     *  - user account within system is set to enabled
     *
     * If any of above conditions is not true, then authentication fails and
     * function returns null. Otherwise, authenication passes and function
     * returns the authenticated user.
     *
     * @access	public
     * @param	string $email
     * @param	string $password
     * @return	user object, if email/phone & password were authenticated
     *          successfully, null otherwise
     */
    public function get_authenticated_user($email = '', $phone = '',
        $password = '')
    {
        // Make sure login info was sent
        if ((empty($email) && empty($phone)) OR empty($password))
        {
            return null;
        }

        $user = null;

        if (!empty($email))
        {
            $user = $this->CI->user_model->get_user_by_email($email);
        }
        else if(!empty($phone))
        {
            $user = $this->CI->user_model->get_user_by_phone($phone);
        }

        // Ensure user was found within system
        if (empty($user))
        {
            return null;
        }

        // Check against password
        if (md5($password) != $user[USER_PASSCODE])
        {
            return null;
        }

        // Ensure user account is set to enabled
        if (!$user[USER_ENABLED])
        {
            return null;
        }

        return $user;
    }

    /**
     * Set the necessary user account fields within the session to provide
     * application state & context (i.e. wheher user is logged in or not).
     *
     * @access	public
     * @return	void
     */
    public function set_session($user = null)
    {
        if (!empty($user))
        {
            // Destroy old session
            $this->CI->session->sess_destroy();

            // Create a fresh, brand new session
            //$this->CI->session->regenerate_id();

            // Remove security sensitive fields, before writing to session
            unset($user[USER_PASSCODE]);
            unset($user['user_passphrase']);

            // Set session data
            $this->CI->session->set_userdata($user);

            // Set logged_in to true
            $this->CI->session->set_userdata(
                array(AUTH_LOGGED_IN_FLAG => true));
        }
    }

    /**
     * Logout user
     *
     * @access	public
     * @return	void
     */
    public function logout()
    {
        // Destroy session
        $this->CI->session->sess_destroy();
    }

    /**
     * Determine whether the current user is logged into the system or not.
     *
     * @access	public
     * @return	bool, true if the current user is already logged in, false
     * otherwise
     */
    public function is_logged_in()
    {
        $is_logged_in = $this->CI->session->userdata(AUTH_LOGGED_IN_FLAG);

        // Check if already logged in
        if (!empty($is_logged_in) && $is_logged_in)
        {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retrieve the current user's email, if user is logged into the system.
     * Otherwise, return empty string.
     *
     * @access	public
     * @return	bool, true if the current user is already logged in, false
     *          otherwise
     */
    public function get_user_email()
    {
        if ($this->is_logged_in())
        {
            return $this->CI->session->userdata(USER_EMAIL);
        }
        return '';
    }

    /**
     * Retrieve the current user's phone number, if user is logged into the
     * system. Otherwise, return empty string.
     *
     * @access	public
     * @return	bool, true if the current user is already logged in, false
     *          otherwise
     */
    public function get_user_phone()
    {
        if ($this->is_logged_in())
        {
            return $this->CI->session->userdata(USER_PHONE);
        }
        return '';
    }


    /**
     * Generate a 4 digit token that will be used in the registartion
     * confirmation process.
     *
     * The token will be based on:
     * 1. The given user Id,
     * 2. A predefined security phrase
     *
     * @access	public
     * @return	string, the generated numeric token if $user_id is non-empty
     * string, otherwise an empty string is return to indicate failure
     */
    public function create_numerictoken($user_id = '')
    {
        // Email cannot be empty, because validation of this token will
        // fail later on (when user clicks the confirmation URL)
        if (empty($user_id))
        {
            return '';
        }

        // Create the SQL query string for generating the 4 digit token
        $sql_query =
            "SELECT " .
            "RPAD(" .
                "SUBSTRING(" .
                    "CONV(" .
                        "SUBSTRING(" .
                            "CAST(" .
                                "SHA(" .
                                    "CONCAT(" . $user_id . ", " .
                                            $this->CI->db->escape(
                                                USER_REG_CONFIRM_PHRASE) .
                                            ")" .
                                    ") AS CHAR" .
                                "), " .
                                "1, 4" .
                        "), ".
                        "16, 10" .
                    ")," .
                    "1,4" .
                ")," .
                "4,0" .
            ") AS token";

        // No need for safe checking because query is guaranteed to return
        // a single result no matter what
        //print_r($sql_query);
        $result = $this->CI->db->query($sql_query);
        return $result->row()->token;
    }

    /**
     * Generate a MD5 hash token that will be used in the registartion
     * confirmation process.
     *
     * The token will be based on:
     * 1. The given user contact reference (email address or another field),
     * 2. The current date plus a specific interval of time in days
     * 3. A predefined security phrase
     *
     * Note that the date value (2.) is converted to an timestamp integer value.
     *
     * @access	public
     * @return	string, the generated MD5 hash token if email is non-empty
     * string, otherwise an empty string is return to indicate failure
     */
    public function create_hashtoken($user_contact_ref = '')
    {
        // Email or alternative field cannot be empty, because validation of
        // this token will fail later on (when user clicks the confirmation URL)
        if (empty($user_contact_ref))
        {
            return 'empty';
        }

        // Create the SQL query string for generating the hash token
        $sql_query =
            "SELECT " .
            "MD5(" .
                "CONCAT(" .
                    $this->CI->db->escape($user_contact_ref) . ", " .
                    "UNIX_TIMESTAMP(" .
                        "DATE_ADD(" .
                            "CURDATE(), " .
                            "INTERVAL " .
                                USER_REG_TIMELIMIT .
                            " DAY" .
                        ") + 0" .
                    "), " .
                    $this->CI->db->escape(
                        USER_REG_CONFIRM_PHRASE) .
                ")" .
            ") AS token;";

        // No need for safe checking because query is guaranteed to return
        // a single result no matter what
        //print_r($sql_query);
        $result = $this->CI->db->query($sql_query);
        return $result->row()->token;
    }

    /**
     * Validate a given MD5 hash token. If valid a result will be found within
     * DB.
     *
     * The token will be based on:
     * 1. A specific user contact reference (email address or phone number),
     * 2. A specific date
     * 3. A predefined security phrase
     *
     * Note that the date value (2.) is converted to an timestamp integer value.
     *
     * @access	public
     * @return	result, if the given MD5 hash token matches a record in the
     * DB, otherwise return empty string
     */
    public function get_user_by_hashtoken($token = '',
        $user_contact_ref = USER_EMAIL)
    {
        if (empty($token))
        {
            return "";
        }

        // Get total number of days that a hash token is valid for
        $num_days = (int)USER_REG_TIMELIMIT;

        // Create SQL query
        $sql_query =
            "SELECT * FROM (`user`) " .
            "WHERE " . $this->CI->db->escape($token) . " " .
            "IN (";

        // Generate a listing of all valid hash codes based on timestamps
        // incrementing at one-day intervals
        for ($i = 0; $i <= $num_days; $i++)
        {
            $sql_query .=
                "MD5(" .
                    "CONCAT(" .
                        $user_contact_ref . ", " .
                        "UNIX_TIMESTAMP(" .
                            "DATE_ADD(" .
                                "CURDATE(), ".
                                "INTERVAL " .
                                    $i .
                                " DAY" .
                            ") + 0" .
                        "), " .
                        $this->CI->db->escape(
                            USER_REG_CONFIRM_PHRASE) .
                    ")" .
                ")";

            // Add comma spearator inbetween values
            if ($i + 1 <= $num_days)
            {
                $sql_query .= ", ";
            }
        }

        $sql_query .= ")";

        //print_r($sql_query);
        //echo '<br/><br/><br/>';

        $result = $this->CI->db->query($sql_query);

        if ($result->num_rows() > 0)
        {
            return $result->row_array();
        }
        return "";
    }

    /**
     * Validate a given 4 digit numeric token. If valid a result will be found within
     * DB.
     *
     * The token will be based on:
     * 1. User Id value
     * 2. A predefined security phrase
     *
     * @access	public
     * @return	result, if the given 4 digit numeric token matches a record in
     *          the DB, otherwise return empty string
     */
    public function get_user_by_numerictoken($token = '',
        $user_contact_ref = USER_ID, $user_phone = '')
    {
        if (empty($token))
        {
            return "";
        }

        // Create SQL query
        $sql_query =
            "SELECT * FROM (`user`) " .
            "WHERE " . $this->CI->db->escape($token) . " " .
            "IN (" .
                "RPAD(" .
                    "SUBSTRING(" .
                        "CONV(" .
                            "SUBSTRING(" .
                                "CAST(" .
                                    "SHA(" .
                                        "CONCAT(" . $user_contact_ref . ", " .
                                                $this->CI->db->escape(
                                                    USER_REG_CONFIRM_PHRASE) .
                                                ")" .
                                        ") AS CHAR" .
                                    "), " .
                                    "1, 4" .
                            "), ".
                            "16, 10" .
                        ")," .
                        "1,4" .
                    ")," .
                    "4,0" .
                ")" .
            ")";
        
        if( !empty($user_phone) )
        {
            $sql_query .= " AND user_phone = '".intval($user_phone)."'";
        }
        //print_r($sql_query);
        //echo '<br/><br/><br/>';

        $result = $this->CI->db->query($sql_query);

        if ($result->num_rows() > 0)
        {
            return $result->row_array();
        }
        return "";
    }
}

/* End of file Authentication.php */
/* Location: ./system/application/libraries/Authentication.php */