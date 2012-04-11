<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the Account object. Provides all data access to the Account DB
 * table.
 *
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Account_model extends Ppa_model
{

    function __construct()
    {
        parent::__construct(ACCOUNT_TABLE);
    }

    /**
     * Create an Account record
     *
     * @return    int, DB Id for the newly created address record
     */
    public function create($address_id = null, $user_id = null, $data = null)
    {
        if (array_key_exists(FORM_ACCOUNT_TYPE, $data))
        {
            $account_data = null;

            // For Bank Account records
            if ($data[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK)
            {
                $account_data = array(
                    ACCOUNT_NAME => $data[FORM_ACCOUNT_BANKNAME],
                    ACCOUNT_NUMBER => $data[FORM_ACCOUNT_BANKNUMBER],
                    ACCOUNT_TRANSIT => $data[FORM_ACCOUNT_TRANSIT],
                    ACCOUNT_INSTITUTION => $data[FORM_ACCOUNT_INSTITUTION]
                );
            }
            // Otherwise, Type of Account is Visa (for now only two types)
            else
            {
                // Construct expiry date from year and month form fields
                $expiry_date =
                    '20' . $data[FORM_ACCOUNT_EXPIRY_YEAR] .
                    '-' .
                    $data[FORM_ACCOUNT_EXPIRY_MONTH] .
                    '-01';

                $account_data = array(
                    ACCOUNT_NAME => $data[FORM_ACCOUNT_NICKNAME],
                    ACCOUNT_NUMBER => $data[FORM_ACCOUNT_CREDITCARDNUMBER],
                    ACCOUNT_EXPIRY => $expiry_date,
                    ACCOUNT_SECURITY_NUMBER => md5($data[FORM_ACCOUNT_SECURITY_NUMBER]),
                    ACCOUNT_SECURITY_PIN => md5($data[FORM_ACCOUNT_SECURITY_PIN])
                );
            }

            // Now add the fields that are common to all account types
            $account_data[USER_ID] = $user_id;
            $account_data[ADDRESS_ID] = $address_id;
            $account_data[ACCOUNT_TYPE] = $data[FORM_ACCOUNT_TYPE];
            $account_data[ACCOUNT_FIRSTNAME] = $data[FORM_FIRSTNAME];
            $account_data[ACCOUNT_LASTNAME] = $data[FORM_LASTNAME];
            $account_data[ACCOUNT_PREFIX] = $data[FORM_PREFIX];

            //echo '<br/><br/>Account: ';
            //print_r($data);
            //echo '<br/><br/>';

            return parent::insert($account_data);
        }
    }
        
    public function insert($data)
    {
            return parent::insert($data);
    }

        /**
     * Get all Account records with corresponding Address and User details for the given user_id
     *
     * @return    void
     */
    public function get_by_user_id($user_id = null, $account_enabled = array(1))
    {
	$ret = array();

	if( empty($user_id) && !empty($this->user_model) )
	{
	    // get id from session if user_model is loaded
	    $user_id = $this->user_model->get_user_id();
	}

	//
	$sql = "SELECT ac.*, ad.*, u.user_firstname, u.user_lastname, u.user_phone, u.user_prefix, u.user_email, 
            IF(ac.account_balance>0,ac.account_balance,'N/A') AS account_balance,
            CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number
            FROM account ac
            INNER JOIN address ad ON ac.address_id = ad.address_id
            INNER JOIN user u ON ac.user_id = u.user_id
            WHERE ac.user_id = ? AND user_enabled = 1 AND account_enabled IN ('".implode("','",$account_enabled)."')";

	$query = $this->db->query($sql, array($user_id));

	foreach ($query->result_array() as $row)
	{
	    $ret[] = $row;
	}

        return $ret;
    }

    public function get_all_by_email($user_email = null, $optional = array())
    {
        if (empty($user_email))
        {
            return false;
        }
        
        $sql_query = "SELECT u.*, m.merchant_name, m.merchant_id, m.latitude AS latitude, m.longitude AS longitude, CONCAT(address_street) AS merchant_address FROM user u 
                LEFT JOIN merchant m ON m.merchant_id = u.merchant_id
                WHERE u.user_email = ?";

        $query = parent::query($sql_query, array($user_email));

        if ($query->num_rows() > 0)
        {
            $user = $query->row_array();
            return $this->get_all_by_user_id($user['user_id'], $optional);
        }
        
        return false;
    }
    
    public function get_all_by_phone($user_phone = null, $optional = array())
    {
        if (empty($user_phone))
        {
            return false;
        }
        
        $sql_query = "SELECT u.*, m.merchant_name, m.merchant_id, m.latitude AS latitude, m.longitude AS longitude, CONCAT(address_street) AS merchant_address FROM user u 
                LEFT JOIN merchant m ON m.merchant_id = u.merchant_id
                WHERE u.user_phone = ?";
        
        $query = parent::query($sql_query, array($user_phone));

        if ($query->num_rows() > 0)
        {
            $user = $query->row_array();
            return $this->get_all_by_user_id($user['user_id'], $optional);
        }
        
        return false;
    }
    
    /**
     * Get all Account records with corresponding Address and User details for
     * the given user_id
     *
     * Note, if $account_enabled is null, then we query for the account without
     * checking whether the account is enabled or not.
     *
     * @return result
     */
    public function get_all_by_user_id($user_id = null, $optional = array())
    {
        $result = array();
        $params = array($user_id);

        if (empty($user_id))
        {
            return '';
        }

        // Construct SQL query
        $sql =
            "SELECT at.accounttype_code, ac.*, ad.*, " .
            "u." . USER_FIRSTNAME . ", " .
            "u." . USER_LASTNAME . ", " .
            "u." . USER_PHONE . ", " .
            "u." . USER_PREFIX . ", " .
            "u." . USER_ID . ", " .
            "DATE_FORMAT(" . ACCOUNT_EXPIRY . ", '%y') AS "
                . ACCOUNT_EXPIRY_YEAR. ", " .
            "DATE_FORMAT(" . ACCOUNT_EXPIRY . ", '%m') AS "
                . ACCOUNT_EXPIRY_MONTH . " " .
            ", CONCAT(SUBSTRING(ac.account_number,1,4),' XXXXXXXX ',SUBSTRING(account_number,-4)) AS account_safenumber " . 
            ", IF(ac.account_balance>0,ac.account_balance,'') AS account_balance " .
            ", ac.account_type, at.merchant_id " .
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number " .
            ", m.latitude, m.longitude " .
            "FROM " . ACCOUNT_TABLE . " ac " .
            "INNER JOIN " . ADDRESS_TABLE ." ad ON ac." . ADDRESS_ID . " = ad."  . ADDRESS_ID . " " .
            "INNER JOIN " . USER_TABLE . " u ON ac." . USER_ID . " = u." . USER_ID . " " .
            "INNER JOIN " . ACCOUNTTYPE_TABLE . " at ON at." . ACCOUNTTYPE_ID . " = ac." . ACCOUNT_TYPE . " " .
            "LEFT JOIN " . MERCHANT_TABLE . " m ON at." . MERCHANT_ID . " = m." . MERCHANT_ID . " " .
            "WHERE u." . USER_ID . " = ? " . "AND " . USER_ENABLED . " = 1 ";

        if (!empty($optional) && array_key_exists(ACCOUNT_ENABLED, $optional))
        {
            $sql .= "AND " . ACCOUNT_ENABLED . " = ?";
            array_push($params, $optional[ACCOUNT_ENABLED]);
        }

        $query = parent::query($sql, $params);
        
        //echo $this->db->last_query();

        foreach ($query->result_array() as $row)
        {
            //  check Gift Card store distance
            if ( $row['account_type'] > 10 && !empty($row['latitude']) && !empty($optional['latitude']) )
            {
                    if( ($distance = distance($optional['latitude'], $optional['longitude'], $row['latitude'], $row['longitude'])) < GEO_DISTANCE_GC )
                    {
                        $result[$row['account_id']] = $row;
                    }
            }
            else
            {
                $result[$row['account_id']] = $row;
            }
        }

        $ret = $query->row_array();
        
        $sql = "SELECT  DISTINCT account_id, DATE_FORMAT(t.transaction_datetime_paid,'%b %D') AS transaction_datetime_paid, t.transaction_amount FROM transaction t WHERE user_id = ? AND transaction_paid IN (1) ORDER BY transaction_id DESC";

        if( !empty($row) && $row['account_id'] )
        {
            $query = parent::query($sql, array($user_id));
            //echo $sql;
            foreach ($query->result_array() as $row)
            {
                //echo 'account_id: '.$row['account_id'];
                if( !empty($result[$row['account_id']]) && empty($result[$row['account_id']]['transaction_datetime_paid']) ) 
                {
                    $result[$row['account_id']] = array_merge($result[$row['account_id']],$row);
                }
                
            }
            unset($ret);
        }
        
        foreach ($result as $row)
        {
            $ret[] = $row;
        }

        return $ret;
    }

    /**
     * Enable an account given by the account Id.
     *
     * @access	public
     * @param	string, email address
     * @return	bool
     */
    public function enable($account_id = null)
    {
        if (empty($account_id))
        {
            return FALSE;
        }

        // Attempt to retrieve disabled account
        $account = $this->get_by_id($account_id,
            array(ACCOUNT_ENABLED => FALSE));

        if (!empty($account))
        {
            parent::update($account_id, array(ACCOUNT_ENABLED => TRUE));
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Enable an account given by the account Id.
     *
     * @access	public
     * @param	string, email address
     * @return	bool
     */
    public function disable($account_id = null)
    {
        if (empty($account_id))
        {
            return FALSE;
        }

        // Attempt to retrieve enabled account
        $account = $this->get_by_id($account_id,
            array(ACCOUNT_ENABLED => TRUE));

        if (!empty($account))
        {
            parent::update($account_id, array(ACCOUNT_ENABLED => FALSE));
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Get a single Account record with corresponding Address and User details
     * for the given $account_id.
     *
     * Note, if $account_enabled is null, then we query for the account without
     * checking whether the account is enabled or not.
     *
     * @return row array, array of data representing the account
     */
    public function get_by_id($account_id = null, $optional = array())
    {
        if (empty($account_id))
        {
            return '';
        }

        $params = array($account_id);

        // Construct SQL query
        $sql =
            "SELECT at.accounttype_code, ac.*, ad.*, " .
            "u." . USER_FIRSTNAME . ", " .
            "u." . USER_LASTNAME . ", " .
            "u." . USER_PHONE . ", " .
            "u." . USER_PREFIX . ", " .
            "DATE_FORMAT(" . ACCOUNT_EXPIRY . ", '%y') AS "
                . ACCOUNT_EXPIRY_YEAR. ", " .
            "DATE_FORMAT(" . ACCOUNT_EXPIRY . ", '%m') AS "
                . ACCOUNT_EXPIRY_MONTH . " " .
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_safenumber " . 
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number " . 
            ", '***' AS account_security_number " . 
            ", '****' AS account_security_pin " . 
            "FROM " . ACCOUNT_TABLE . " ac " .
            "INNER JOIN " . ADDRESS_TABLE ." ad ON ac." . ADDRESS_ID .
                " = ad."  . ADDRESS_ID . " " .
            "INNER JOIN " . USER_TABLE . " u ON ac." . USER_ID . " = u." .
                USER_ID . " " .
            "INNER JOIN " . ACCOUNTTYPE_TABLE . " at ON at." . ACCOUNTTYPE_ID . " = ac." . ACCOUNT_TYPE . " " .
            "WHERE ac." . ACCOUNT_ID . " = ? " .
            "AND " . USER_ENABLED . " = 1 ";
        //echo $sql;
        if (!empty($optional) && array_key_exists(ACCOUNT_ENABLED, $optional))
        {   // TODO: decide in when to use enabled flag
            //$sql .= "AND " . ACCOUNT_ENABLED . " = ?";
            //array_push($params, $optional[ACCOUNT_ENABLED]);
        }

        $query = parent::query($sql, $params);
        
        $ret = $query->row_array();
        
        $sql = "SELECT t.transaction_datetime_paid , t.transaction_amount FROM transaction t WHERE account_id = ? AND transaction_paid = 1 ORDER BY transaction_id DESC LIMIT 1";

        if( $account_id )
        {
            $query = parent::query($sql, array($account_id));
            $ret = array_merge($ret,$query->row_array());
        }

        return $ret;
    }

    /**
     * Refill GC Account record identified by the given values
     * provided within the array data.
     *
     * @access	public
     * @param	array with user_phone, merchant_phone and amount variables
     * @return  true
     */
    public function refill($data = null)
    {
        if( !empty($data['user_phone']) && !empty($data['merchant_phone']) && !empty($data['amount']) )
        {
    	    $sql = "UPDATE user u
    		INNER JOIN account a ON a.user_id = u.user_id
    		INNER JOIN accounttype at ON at.accounttype_id = a.account_type
    		INNER JOIN user m ON m.merchant_id = at.merchant_id
    		SET a.account_balance = a.account_balance + ".doubleval($data['amount'])."
    		WHERE u.user_phone = '".intval($data['user_phone'])."' AND a.account_enabled = 1 AND u.user_enabled = 1 AND m.user_enabled = 1 AND m.user_phone = '".intval($data['merchant_phone'])."'";
            $query = parent::query($sql);
            //echo $sql;
        }

        return $ret = true;
    }
    /**
     * Update Account record identified by the given Account_id with the values
     * provided within the array data.
     *
     * @access	public
     * @param	string, ID value for the Account record to be updated
     * @param	string, array of data values to update within the Account
     * @return  result, or empty string
     */
    public function update($account_id = null, $data = null)
    {
        if (array_key_exists(FORM_ACCOUNT_TYPE, $data))
        {
            $account_data = null;

            // For Bank Account records
            if ($data[FORM_ACCOUNT_TYPE] == TYPE_ACCOUNT_BANK)
            {
                $account_data = array(
                    ACCOUNT_NAME => $data[FORM_ACCOUNT_BANKNAME],
                    ACCOUNT_NUMBER => $data[FORM_ACCOUNT_BANKNUMBER],
                    ACCOUNT_TRANSIT => $data[FORM_ACCOUNT_TRANSIT],
                    ACCOUNT_INSTITUTION => $data[FORM_ACCOUNT_INSTITUTION]
                );
            }
            // Otherwise, Type of Account is Visa (for now only two types)
            else
            {
                // Construct expiry date from year and month form fields
                $expiry_date =
                    '20' . $data[FORM_ACCOUNT_EXPIRY_YEAR] .
                    '-' .
                    $data[FORM_ACCOUNT_EXPIRY_MONTH] .
                    '-01';

                $account_data = array(
                    ACCOUNT_NAME => $data[FORM_ACCOUNT_NICKNAME],
                    ACCOUNT_EXPIRY => $expiry_date
                );
                if( !preg_match('/x/ims',$data[FORM_ACCOUNT_CREDITCARDNUMBER]) )
                {
                    $account_data[ACCOUNT_NUMBER] = preg_replace('/(\d{4})(\d+)(\d{4})/','$1XXXXXXXX$3',$data[FORM_ACCOUNT_CREDITCARDNUMBER]);
                }
                if( !preg_match('/\*/ims',$data[FORM_ACCOUNT_SECURITY_NUMBER]) )
                {
                    $account_data[ACCOUNT_SECURITY_NUMBER] = md5($data[FORM_ACCOUNT_SECURITY_NUMBER]);
                }
                if( !preg_match('/\*/ims',$data[FORM_ACCOUNT_SECURITY_PIN]) )
                {
                    $account_data[ACCOUNT_SECURITY_PIN] = md5($data[FORM_ACCOUNT_SECURITY_PIN]);
                }
            }

            // Now add the fields that are common to all account types
            $account_data[ACCOUNT_TYPE] = $data[FORM_ACCOUNT_TYPE];
            $account_data[ACCOUNT_FIRSTNAME] = $data[FORM_FIRSTNAME];
            $account_data[ACCOUNT_LASTNAME] = $data[FORM_LASTNAME];
            $account_data[ACCOUNT_PREFIX] = $data[FORM_PREFIX];

            parent::update($account_id, $account_data);
        }
    }

}

/* End of file account_model.php */
/* Location: ./system/application/models/account_model.php */