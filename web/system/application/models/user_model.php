<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the User. Provides all data access to the User DB table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class User_model extends Ppa_model
{

    function __construct()
    {
        parent::__construct(USER_TABLE);
    }

    /**
     * Create a user account. Returns true if a new user account was created
     * successfully. Otherwise, returns false.
     *
     * Specifically if a user account already exists with the given email
     * address or give phone number, then this funciton will return FALSE.
     *
     * @access	public
     * @param	string, email address
     * @param	string, phone address
     * @return	int, Id of newly created user if new user created successfully,
     *          void otherwise
     */
    public function create($email = '', $phone = '')
    {
        if (empty($email) && empty($phone))
        {
            return;
        }

        $user = $this->get_user_by_email($email);
        if (empty($user) && !empty($phone))
        {
            $user = $this->get_user_by_phone($phone);
        }

        // User already exists
        if (!empty($user))
        {
            return;
        }
        // Otherwise, create new user
        else
        {
            //Insert data into database
            $data = array();

            if (!empty($email))
            {
                $data[USER_EMAIL] = $email;
            }
            if (!empty($phone))
            {
                $data[USER_PHONE] = $phone;
            }

            return parent::insert($data);
        }
    }

    /**
     * Delete a user by id.
     *
     * @access	public
     * @param integer
     * @return	bool
     */
    public function delete($id)
    {
        if (!is_numeric($id))
        {
            //There was a problem
            return FALSE;
        }

        if ($this->delete($id))
        {
            //Database call was successful, user is deleted
            return TRUE;
        }
        else
        {
            //There was a problem
            return FALSE;
        }
    }

    /**
     * Update a given user's passcode.
     *
     * @access	public
     * @param	string, email address
     * @param	string, passcode
     * @return	bool
     */
    public function update_passcode($email = '', $phone = '', $passcode = '')
    {
        // Make sure account info was sent
        if ( (empty($email) && empty($phone)) || empty($passcode))
        {
            return FALSE;
        }

        $user = $this->get_user_by_email($email);
        if (empty($user) && !empty($phone))
        {
            $user = $this->get_user_by_phone($phone);
        }

        // User does not exist
        if (empty($user))
        {
            return FALSE;
        }
        // Otherwise, update existing user
        else
        {
            // Encrypt passcode
            $passcode = md5($passcode);

            $data = array(
                USER_PASSCODE => $passcode
            );

            parent::update($user[USER_ID], $data);

            return TRUE;
        }
    }

    /**
     * Enable a user account given by the email field.
     *
     * @access	public
     * @param	string, email address
     * @return	bool
     */
    public function enable($email = '', $phone = '')
    {
        // Make sure account info was sent
        if (empty($email) && empty($phone))
        {
            return FALSE;
        }

        $user = $this->get_user_by_email($email);
        if (empty($user) && !empty($phone))
        {
            $user = $this->get_user_by_phone($phone, $enabled=0);
        }

        // User exists
        if (!empty($user))
        {
            $data = array(
                USER_ENABLED => 1
            );

            parent::update($user[USER_ID], $data);
            
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Retrieves a user from the DB based on the given email, or empty string
     * if the user cannot be found.
     *
     * @access	public
     * @return  result, or empty string
     */
    public function get_user_by_email($email = '')
    {
        
        $sql_query = "SELECT u.*, m.merchant_name, m.merchant_id, m.latitude AS latitude, m.longitude AS longitude, CONCAT(address_street) AS merchant_address, m.accuracy AS merchant_accuracy FROM user u 
                LEFT JOIN merchant m ON m.merchant_id = u.merchant_id
                WHERE u.user_email = ?";

        $query = parent::query($sql_query, array($email));
        //return $result->row()->token;
        //$query = $this->get_where(array(USER_EMAIL => $email));
//echo $this->db->last_query();
        if ($query->num_rows() > 0)
        {
            return $query->row_array();
        }

        return '';
    }

    /**
     * Retrieves a user from the DB based on the given email, or empty string
     * if the user cannot be found.
     *
     * @access	public
     * @return  result, or empty string
     */
    public function get_user_by_phone($phone = '', $enabled = '')
    {
        $sql_query = "SELECT u.*, m.merchant_name, m.merchant_id, m.latitude AS latitude, m.longitude AS longitude, CONCAT(address_street) AS merchant_address, m.accuracy AS merchant_accuracy FROM user u 
                LEFT JOIN merchant m ON m.merchant_id = u.merchant_id
                WHERE u.user_phone = ?";
        
        $param = array($phone);
        if( $enabled !== '' )
        {
            $sql_query = $sql_query.' AND u.user_enabled = ?';
            $param[] = $enabled;
        }
        
        $query = parent::query($sql_query, $param);
        //echo $this->db->last_query();
        //$query = $this->get_where(array(USER_PHONE => $phone));

        if ($query->num_rows() > 0)
        {
            return $query->row_array();
        }

        return '';
    }

    /**
     * Retrieves a user from the DB based on the given Id, or empty string
     * if the user cannot be found.
     *
     * @access	public
     * @return  result, or empty string
     */
    public function get_user_by_id($id = '')
    {
        
        $sql_query = "SELECT u.*, m.merchant_name, m.merchant_id, m.latitude AS latitude, m.longitude AS longitude, CONCAT(address_street) AS merchant_address, m.accuracy AS merchant_accuracy FROM user u 
                LEFT JOIN merchant m ON m.merchant_id = u.merchant_id
                WHERE u.user_id = ?";
        
        $query = parent::query($sql_query, array($id));

        //$query = $this->get_where(array(USER_ID => $id));
        
        if ($query->num_rows() > 0)
        {
            return $query->row_array();
        }

        return '';
    }

    /**
     * Update user account identified by the given user_id with the values
     * provided within the array data.
     *
     * @access	public
     * @param	string, ID value for the user account to be updated
     * @param	string, array of data values to update within the user account
     * @return  result, or empty string
     */
    public function update($user_id = null, $data = null)
    {
		if( !empty($data[FORM_FIRSTNAME]) ) $user_data['USER_FIRSTNAME'] = $data[FORM_FIRSTNAME];
		if( !empty($data[FORM_LASTNAME]) ) $user_data['USER_LASTNAME'] = $data[FORM_LASTNAME];
		if( !empty($data[FORM_PREFIX]) ) $user_data['USER_PREFIX'] = $data[FORM_PREFIX];
		if( !empty($data[FORM_DOB]) ) $user_data['USER_DOB'] = $data[FORM_DOB];
		if( !empty($data[FORM_EMAIL]) ) $user_data['USER_EMAIL'] = $data[FORM_EMAIL];
		if( !empty($data[FORM_PHONE]) ) $user_data['USER_PHONE'] = 	$data[FORM_PHONE];
		if( !empty($data['paypal_key']) ) $user_data['paypal_key'] = $data['paypal_key'];
		if( !empty($data['paypal_id']) ) $user_data['paypal_id'] = $data['paypal_id'];
		if( !empty($data['paypal_email']) ) $user_data['paypal_email'] = $data['paypal_email'];

        parent::update($user_id, $user_data);
    }

    /**
     * Retrieves user_id from session
     *
     * @access  public
     * @return  user_id from session
     */
    public function get_user_id()
    {
        return $this->session->userdata(USER_ID);
    }


}

/* End of file user_model.php */
/* Location: ./system/application/models/user_model.php */