<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the Address object. Provides all data access to the Address DB
 * table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Address_model extends Ppa_model
{

    function __construct()
    {
        parent::__construct(ADDRESS_TABLE);
    }


    /**
     * Create an address record
     *
     * @return    int, DB Id for the newly created address record
     */
    public function create($user_id = null, $data = null)
    {
        if (empty($data) || empty($user_id))
        {
            return;
        }

        $address_data = array(
            USER_ID => $user_id,
            ADDRESS_STREET => $data[FORM_ADDRESS_STREET],
            ADDRESS_CITY => $data[FORM_ADDRESS_CITY],
            ADDRESS_STATE => $data[FORM_ADDRESS_STATE],
            ADDRESS_ZIP => $data[FORM_ADDRESS_ZIP],
            ADDRESS_COUNTRY => $data[FORM_ADDRESS_COUNTRY]
        );

        // By default address_type is set to 'profile' in DB
        if (array_key_exists(FORM_ADDRESS_TYPE, $data))
        {
            $address_data[ADDRESS_TYPE] = $data[FORM_ADDRESS_TYPE];
        }

        return parent::insert($address_data);
    }

    /**
     * Get a single address record for the given user Id
     *
     * @return    row array
     */
    public function get_by_user($user_id = '', $address_type = TYPE_ADDRESS_PROFILE)
    {
        $query = parent::get_where(array(USER_ID => $user_id,
            ADDRESS_TYPE => $address_type));

        return $query->row_array();
    }


    /**
     * Get a single address record for the given account Id
     *
     * @return    row array
     */
    public function get_by_account($account_id = '')
    {
        $query = parent::get_where(array(_ID => $account_id,
            ADDRESS_TYPE => TYPE_ADDRESS_BILLING));

        return $query->row_array();
    }

    /**
     * Update address record identified by the given address_id with the values
     * provided within the array data.
     *
     * @access	public
     * @param	string, ID value for the address record to be updated
     * @param	string, array of data values to update within the address
     * @return  result, or empty string
     */
    public function update($address_id = null, $data = null)
    {
        $address_data = array(
            ADDRESS_STREET => $data[FORM_ADDRESS_STREET],
            ADDRESS_CITY => $data[FORM_ADDRESS_CITY],
            ADDRESS_STATE => $data[FORM_ADDRESS_STATE],
            ADDRESS_ZIP => $data[FORM_ADDRESS_ZIP],
            ADDRESS_COUNTRY => $data[FORM_ADDRESS_COUNTRY]
        );

        parent::update($address_id, $address_data);
    }

}

/* End of file address_model.php */
/* Location: ./system/application/models/address_model.php */