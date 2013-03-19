<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the Request object. Provides all data access to the Transaction
 * DB table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Request_model extends Ppa_model
{

    function __construct()
    {
        parent::__construct(REQUEST_TABLE);
    }

    // Add create function later

    /**
     * Get all Receipt records using the optional where and order by arrays.
     *
     * The array $order_by may contain additional parameters to order the query
     * results by
     *
     * @return result
     */
    public function get_order_by($user_email = null, $account_id = null,
        $order_by = array(), $descend = true, $limit = 0)
    {
        if (empty($user_email))
        {
            return '';
        }

        $result = array();
        $params = array($user_email, $user_email);

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
            "FROM " . TRANSACTION_TABLE . " tr " .
            "INNER JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "LEFT JOIN " . MERCHANT_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            "INNER JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." .
                USER_ID . " " .
            "WHERE u." . USER_EMAIL . " = ? " .
            "AND u." . USER_ENABLED . " = 1 ";
        if (!empty($account_id))
        {
            $sql .= "AND tr." . ACCOUNT_ID . " = " . $account_id . " ";
        }


        $sql_request =
            "SELECT tr.*, ac.*, mc.*, " .
            "DATE(tr." . TRANSACTION_DATETIME_PAID . ") AS " .
                TRANSACTION_DATE_PAID. ", " .
            "TIME_FORMAT(TIME(tr." . TRANSACTION_DATETIME_PAID .
                "), '%l:%i%p') AS " . TRANSACTION_TIME_PAID . " " .
            ", mc.address_street AS merchant_street, mc.address_city AS merchant_city " .
            ", round((1-1/1.12)*(transaction_amount-transaction_tips),2) AS transaction_tax " .
            ", transaction_amount-round((1-1/1.12)*(transaction_amount-transaction_tips),2)-transaction_tips AS transaction_subtotal " .
            "FROM " . REQUEST_TABLE . " tr " .
            "LEFT JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "LEFT JOIN " . MERCHANT_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            "INNER JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." .
                USER_ID . " " .
            "WHERE u." . USER_EMAIL . " = ? " .
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

	//echo 'SQL: ' . $sql . '<br/>';
        //die();

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

        parent::update($transaction_id, $transaction_data, $id_column_name = 'transaction_id');
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
    
        if (!empty($transaction_id) && !empty($user_email))
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
            "FROM " . REQUEST_TABLE . " tr " .
            "INNER JOIN " . ACCOUNT_TABLE . " ac ON tr." . ACCOUNT_ID .
                " = ac." . ACCOUNT_ID . " " .
            "LEFT JOIN " . REQUEST_TABLE . " mc ON tr." . MERCHANT_ID .
                " = mc." . MERCHANT_ID . " " .
            "LEFT JOIN " . USER_TABLE . " u ON tr." . USER_ID . " = u." .
                USER_ID . " " .
            "WHERE u." . USER_EMAIL . " = ? " .
            "AND u." . USER_ENABLED . " = 1 AND transaction_id = ? LIMIT 1";

    	    $result = parent::query($sql, array($user_email,$transaction_id) )->row();
    	    
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