<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the Message object. Provides all data access to the Message
 * DB table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Message_model extends Ppa_model
{

    function __construct()
    {
        parent::__construct(MESSAGE_TABLE);
    }

    // Add create function later

    /**
     * Retrieves a Trasnaction record from the DB based on the given Id value,
     * or empty string if the Id value is empty or if the Trasnaction cannot be
     * found.
     *
     * @access	public
     * @return  result, or empty string
     */
    public function get_by_id($message_id = null, $user_id = null)
    {
    
	//return parent::get_row_by_id($message_id);
        //$query = parent::get_where(array(MESSAGE_ID => $message_id));
        $query = $this->db->select('*, IF(date_start != "0000-00-00",DATE_FORMAT(date_start, "%M %D %Y"),"Today Only") AS message_date, (\'%a %l%p, %b %D %Y\') as date_start_formatted, DATE_FORMAT(date_end,\'%a %l%p, %b %D %Y\') as date_end_formatted', false)->join('merchant', 'merchant.merchant_id = '.$this->table.'.merchant_id')->get_where($this->table,array(MESSAGE_ID => $message_id));
        
        return $query->row_array();
    }
    
    public function get_all()
    {
        //$select = '*, IF(date_start != "0000-00-00",DATE_FORMAT(date_start, "%M %D %Y"),"Today Only") AS message_date';
        $q = $this->db->select($this->table.'.*, merchant.merchant_name, merchant.icon AS merchant_icon, IF(date_start != "0000-00-00", DATE_FORMAT(date_start, "%M %D %Y"),"Today Only") AS message_date, date_start, DATE_FORMAT(date_start,\'%a %l%p, %b %D %Y\') as date_start_formatted, DATE_FORMAT(date_end,\'%a %l%p, %b %D %Y\') as date_end_formatted', false)->join('merchant', 'merchant.merchant_id = '.$this->table.'.merchant_id')->get($this->table);
        return $q->result();

        return parent::get_all();
    }

    public function insert($data)
    {
            return parent::insert($data);
    }

}

/* End of file message_model.php */
/* Location: ./system/application/models/message_model.php */