<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for shops page.
 *
 * @package		PayPhoneApp
 * @author		Gavin L
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 */
class shops_model extends Ppa_model {

    function __construct() {
        
    }

    public function search($searchname = null, $searchaddress = null, $searchtype = null, $limit = null) {
        $result = array();
        $params = array($searchname, $searchaddress, $searchtype);

        $sql = "select merchant_id, merchant_name, address_street, address_city, address_state, address_zip, type AS merchant_description, latitude, longitude, type, phone_number, email, contact, count(*) as frequency from "
                . "( "
                . "select * from merchant where hidden = 0 AND lower(merchant_name) like ? "
                . "union all "
                . "select * from merchant where hidden = 0 AND lower(address_street) like ? "
                . "union all "
                . "select * from merchant where hidden = 0 AND lower(type) like ? "
                . ") t "
                . "group by merchant_id "
                . "order by frequency desc, merchant_name ";
        if (!empty($limit)) {
            $sql .= " limit " . $limit;
        }
        //echo 'SQL: ' . $sql . '<br/>';

        $query = parent::query($sql, $params);
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }
        return $result;
    }
    
    public function getDetail($merchant_id = null) {
        $result = array();
        $params = array($merchant_id);
        
        $sql = "select *, type AS merchant_description, TRIM( CONCAT(IF(morning!=0,'Morning ','') ,IF(midday!=0,'Midday ','') ,IF(evening!=0,'Evening ','') ,IF(night!=0,'Night','') )) AS hours from merchant where merchant_id = ?";
        
        $query = parent::query($sql, $params);
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
        }
        return $result;
    }

}

?>
