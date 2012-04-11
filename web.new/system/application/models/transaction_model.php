<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the Transaction object. Provides all data access to the Transaction
 * DB table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Transaction_model extends Ppa_model
{

    function __construct()
    {
        parent::__construct(TRANSACTION_TABLE);
    }

    /**
     * Get all Receipt records using the optional where and order by arrays.
     *
     * The array $order_by may contain additional parameters to order the query
     * results by
     *
     * @return result
     */
    public function get_order_by($user_email = null, $account_id = null,
        $order_by = array(), $descend = true, $limit = 0, $mode = 'user')
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
            return $this->get_by_user_id_order_by($user['user_id'], $account_id, $order_by, $descend, $limit, $mode);
        }
        
        return false;
    }

    public function get_by_phone_order_by($user_phone = null, $account_id = null,
        $order_by = array(), $descend = true, $limit = 0, $mode = 'user')
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
            return $this->get_by_user_id_order_by($user['user_id'], $account_id, $order_by, $descend, $limit, $mode);
        }
        
        return false;
    }
    
    public function get_by_user_id_order_by($user_id = null, $account_id = null,
        $order_by = array(), $descend = true, $limit = 0, $mode = 'user')
    {
        if (empty($user_id))
        {
            return '';
        }

        $result = array();
        $params = array($user_id, $user_id);

        // Determine sort order (ascending or descending)
        $sort_order = $descend ? 'DESC' : 'ASC';

        // Construct SQL query
        $sql =
            "SELECT tr.*, ac.*, mc.*, " .
            "DATE(tr." . TRANSACTION_DATETIME_PAID . ") AS " .
                TRANSACTION_DATE_PAID. ", " .
            "TIME_FORMAT(TIME(tr." . TRANSACTION_DATETIME_PAID .
                "), '%l:%i%p') AS " . TRANSACTION_TIME_PAID . " " .
            ", mc.address_street AS merchant_street, mc.address_city AS merchant_city " .
            ", round((1-1/1.12)*(transaction_amount-transaction_tips),2) AS transaction_tax " .
            ", transaction_amount-round((1-1/1.12)*(transaction_amount-transaction_tips),2)-transaction_tips AS transaction_subtotal " .
            ", ROUND(tr.transaction_amount,2) AS transaction_amount " .
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number " .
            ", tr.user_id as tr_user_id " .
            ", tr.transaction_amount AS tr_transaction_amount " .
            "FROM " . TRANSACTION_TABLE . " tr " .
            "INNER JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "LEFT JOIN " . MERCHANT_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            (  ($mode == 'merchant') ? 
                "INNER JOIN " . USER_TABLE . " u ON mc." . MERCHANT_ID . " = u." . MERCHANT_ID . " " :
                "INNER JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." . USER_ID . " " 
            ) .
            "WHERE u." . USER_ID . " = ? " .
            "AND u." . USER_ENABLED . " = 1 ";
        if (!empty($account_id))
        {
            $sql .= "AND tr." . ACCOUNT_ID . " = " . $account_id . " ";
        }
//echo $sql;

        $sql_request =
            "SELECT tr.*, ac.*, mc.*, " .
            "DATE(tr." . TRANSACTION_DATETIME_PAID . ") AS " .
                TRANSACTION_DATE_PAID. ", " .
            "TIME_FORMAT(TIME(tr." . TRANSACTION_DATETIME_PAID .
                "), '%l:%i%p') AS " . TRANSACTION_TIME_PAID . " " .
            ", mc.address_street AS merchant_street, mc.address_city AS merchant_city " .
            ", round((1-1/1.12)*(transaction_amount-transaction_tips),2) AS transaction_tax " .
            ", transaction_amount-round((1-1/1.12)*(transaction_amount-transaction_tips),2)-transaction_tips AS transaction_subtotal " .
            ", ROUND(tr.transaction_amount,2) AS transaction_amount " .
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number " .
            ", tr.user_id as tr_user_id " .
            ", tr.transaction_amount AS tr_transaction_amount " .
            "FROM " . REQUEST_TABLE . " tr " .
            "LEFT JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "LEFT JOIN " . MERCHANT_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            (  ($mode == 'merchant') ? 
                "INNER JOIN " . USER_TABLE . " u ON mc." . MERCHANT_ID . " = u." . MERCHANT_ID . " " :
                "INNER JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." . USER_ID . " " 
            ) .
            "WHERE u." . USER_ID . " = ? " .
            "AND u." . USER_ENABLED . " = 1 ";
        if (!empty($account_id))
        {
            $sql_request .= "AND tr." . ACCOUNT_ID . " = " . $account_id . " ";
        }

	$sql = "($sql) UNION ($sql_request) ";
        if (!empty($order_by) &&
            !in_array(TRANSACTION_DATE_PAID, $order_by))
        {
            $sql .= "ORDER BY ";

            foreach ($order_by as $column)
            {
                $sql .= $column . " " . $sort_order . ", ";
            }

            // Always do an inner sort by TRANSACTION_DATETIME_PAID
            // in descending order
            $sql .= TRANSACTION_DATETIME_PAID . " DESC";
        }
        else
        {
            $sql .= "ORDER BY " . TRANSACTION_DATETIME_PAID . " " . $sort_order;
        }

        if ($limit > 0)
        {
            $sql .= " LIMIT " . $limit;
        }

        //echo $sql;

        $query = parent::query($sql, $params);

        foreach ($query->result_array() as $row)
        {
            $result[] = $row;
        }

        /*
         * echo 'Query: <br/>';
        print_r($query);
        echo '<br/><br/>';
         *
         */

        return $result;
    }

    public function get_merchant_order_by($user_email = null, $account_id = null,
        $order_by = array(), $descend = true, $limit = 0, $mode = 'merchant')
    {
        return $this->get_order_by($user_email, $account_id,
                        $order_by, $descend, $limit, $mode);
    }
    /**
     * Update Account record identified by the given Account_id with the values
     * provided within the array data.
     *
     * @access	public
     * @param	string, ID value for the Transaction record to be updated
     * @param	string, array of data values to update within the Transaction
     * @return  result, or empty string
     */
    public function update($transaction_id = null, $data = null)
    {
        if (empty($transaction_id) || empty($data))
        {
            return;
        }

        $transaction_data = array();

        if (array_key_exists(FORM_TRANS_ANNOTATION, $data))
        {
            $transaction_data[TRANSACTION_USER_NOTE] = $data[FORM_TRANS_ANNOTATION];
        }

        if (array_key_exists(FORM_TRANS_FLAGGED, $data))
        {
            $transaction_data[TRANSACTION_FLAGGED] = $data[FORM_TRANS_FLAGGED];
        }

        parent::update($transaction_id, $transaction_data);
        
        if( $this->db->affected_rows() == 0 )
        {
    	    $this->load->model('request_model');
    	    $this->request_model->update($transaction_id, $data);
        }
        
    }


    /**
     * Retrieves a Trasnaction record from the DB based on the given Id value,
     * or empty string if the Id value is empty or if the Trasnaction cannot be
     * found.
     *
     * @access	public
     * @return  result, or empty string
     */
    public function get_by_id($transaction_id = null, $user_email = null)
    {
    
	//return parent::get_row_by_id($transaction_id);
    
        if (!empty($transaction_id))
        {
    	    $sql =
            "SELECT tr.*, ac.*, mc.*, " .
            "DATE(tr." . TRANSACTION_DATETIME_PAID . ") AS " .
                TRANSACTION_DATE_PAID. ", " .
            "TIME_FORMAT(TIME(tr." . TRANSACTION_DATETIME_PAID .
                "), '%l:%i%p') AS " . TRANSACTION_TIME_PAID . " " .
            ", mc.address_street AS merchant_street, mc.address_city AS merchant_city " .
            ", round((1-1/1.12)*(transaction_amount-transaction_tips),2) AS transaction_tax " .
            ", transaction_amount-round((1-1/1.12)*(transaction_amount-transaction_tips),2)-transaction_tips AS transaction_subtotal " .
            ", ROUND(tr.transaction_amount,2) AS transaction_amount " .
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number " .
            "FROM " . TRANSACTION_TABLE . " tr " .
            "INNER JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "INNER JOIN " . MERCHANT_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            "INNER JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." .
                USER_ID . " " .
            "WHERE u." . USER_EMAIL . " = ? " .
            "AND u." . USER_ENABLED . " = 1 AND transaction_id = ? LIMIT 1";

    	    $sql_request =
            "SELECT tr.*, ac.*, mc.*, " .
            "DATE(tr." . TRANSACTION_DATETIME_PAID . ") AS " .
                TRANSACTION_DATE_PAID. ", " .
            "TIME_FORMAT(TIME(tr." . TRANSACTION_DATETIME_PAID .
                "), '%l:%i%p') AS " . TRANSACTION_TIME_PAID . " " .
            ", mc.address_street AS merchant_street, mc.address_city AS merchant_city " .
            ", round((1-1/1.12)*(transaction_amount-transaction_tips),2) AS transaction_tax " .
            ", transaction_amount-round((1-1/1.12)*(transaction_amount-transaction_tips),2)-transaction_tips AS transaction_subtotal " .
            ", ROUND(tr.transaction_amount,2) AS transaction_amount " .
            ", CONCAT(SUBSTR(ac.account_number,1,4),REPEAT('X',LENGTH(ac.account_number)-8),SUBSTR(ac.account_number,-4)) AS account_number " .
            "FROM " . REQUEST_TABLE . " tr " .
            "LEFT JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "INNER JOIN " . MERCHANT_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            "INNER JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." .
                USER_ID . " " .
            "WHERE u." . USER_EMAIL . " = ? " .
            "AND u." . USER_ENABLED . " = 1 AND transaction_id = ? LIMIT 1";
            
            $sql = "($sql) UNION ($sql_request)";

    	    $result = parent::query($sql, array($user_email,$transaction_id,$user_email,$transaction_id) )->row();
    	    
    	}
        else
        {
            return '';
        }

        return $result;
    }
}

/* End of file transaction_model.php */
/* Location: ./system/application/models/transaction_model.php */