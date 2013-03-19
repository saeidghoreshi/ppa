<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for the Passphrase object. Provides all data access to the Passphrase
 * DB table.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Passphrase_model extends Ppa_model
{
    function __construct()
    {
        parent::__construct(PASSPHRASE_TABLE);
    }

    /**
     * Create an address record
     *
     * @return    void
     */
    public function create($user_id = null, $data = null, $number = null)
    {
        if (empty($user_id) || empty($data) || empty($number))
        {
            return;
        }

        $passphrase_data = array(
            USER_ID => $user_id,
        );

        if ($number == 1)
        {
            $passphrase_data[PASSPHRASE_QUESTION] =
                $data[FORM_PASSPHRASE_1_QUESTION];
            $passphrase_data[PASSPHRASE_ANSWER] =
                $data[FORM_PASSPHRASE_1_ANSWER];
            $passphrase_data[PASSPHRASE_CLUE] =
                $data[FORM_PASSPHRASE_1_CLUE];
        }

        if ($number == 2)
        {
            $passphrase_data[PASSPHRASE_QUESTION] =
                $data[FORM_PASSPHRASE_2_QUESTION];
            $passphrase_data[PASSPHRASE_ANSWER] =
                $data[FORM_PASSPHRASE_2_ANSWER];
            $passphrase_data[PASSPHRASE_CLUE] =
                $data[FORM_PASSPHRASE_2_CLUE];
        }

        $this->insert($passphrase_data);
    }

    /**
     * Get all the records
     *
     * @return    void
     */
    public function get_by_user($user_id = '')
    {
        return $this->get_rows(USER_ID, ($user_id));
    }

    /**
     * Update passphrase records identified by the given passphrase_id_1 and
     * passphrase_id_2 with the values provided within the array data.
     *
     * @access	public
     * @param	string, ID value for the first passphrase record to be updated
     * @param	string, ID value for the second passphrase record to be updated
     * @param	string, array of data values to update within both passphrases
     * @return  result, or empty string
     */
    public function update($passphrase_id = null, $data = null, $number = null)
    {
        if (empty($passphrase_id) || empty($data) || empty($number))
        {
            return;
        }

        $passphrase_data = array();

        if ($number == 1)
        {
            $passphrase_data[PASSPHRASE_QUESTION] =
                $data[FORM_PASSPHRASE_1_QUESTION];
            $passphrase_data[PASSPHRASE_ANSWER] =
                $data[FORM_PASSPHRASE_1_ANSWER];
            $passphrase_data[PASSPHRASE_CLUE] =
                $data[FORM_PASSPHRASE_1_CLUE];
        }

        if ($number == 2)
        {
            $passphrase_data[PASSPHRASE_QUESTION] =
                $data[FORM_PASSPHRASE_2_QUESTION];
            $passphrase_data[PASSPHRASE_ANSWER] =
                $data[FORM_PASSPHRASE_2_ANSWER];
            $passphrase_data[PASSPHRASE_CLUE] =
                $data[FORM_PASSPHRASE_2_CLUE];
        }

        parent::update($passphrase_id, $passphrase_data);
    }

}

/* End of file passphrase_model.php */
/* Location: ./system/application/models/passphrase_model.php */