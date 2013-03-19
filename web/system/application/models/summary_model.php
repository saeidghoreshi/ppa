<?php

//require_once(APPPATH . 'libraries/Ppa_model.php');

/**
 * Model for overview page.
 *
 * @package		PayPhoneApp
 * @author		Gavin L
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 */
class Summary_model extends Ppa_model {

    function __construct() {
        
    }

    public function summarize_timeofday($user_email = null) {
        if (empty($user_email)) {
            return '';
        }

        $result = array();
        $params = array($user_email, $user_email, $user_email, $user_email, $user_email);

        $sql = "select t.timeofday, t.amount from "
                . "( "
                . "select 'morning' as timeofday, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join user u on t.user_id = u.user_id "
                . "where u.user_email = ? and t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "and time(t.transaction_datetime_paid) > '06:00:00' "
                . "and time(t.transaction_datetime_paid) < '10:59:59' "
                . "union "
                . "select 'mid-day'as timeofday, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join user u on t.user_id = u.user_id "
                . "where u.user_email = ? and t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "and time(t.transaction_datetime_paid) > '11:00:00' "
                . "and time(t.transaction_datetime_paid) < '15:59:59' "
                . "union "
                . "select 'afternoon/evening' as timeofday, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join user u on t.user_id = u.user_id "
                . "where u.user_email = ? and t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "and time(t.transaction_datetime_paid) > '16:00:00' "
                . "and time(t.transaction_datetime_paid) < '20:59:59' "
                . "union "
                . "select 'night' as timeofday, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join user u on t.user_id = u.user_id "
                . "where u.user_email = ? and t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "and time(t.transaction_datetime_paid) > '21:00:00' "
                . "or time(t.transaction_datetime_paid) < '01:59:59' "
                . "union "
                . "select 'late-night' as timeofday, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join user u on t.user_id = u.user_id "
                . "where u.user_email = ? and t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "and time(t.transaction_datetime_paid) > '01:00:00' "
                . "and time(t.transaction_datetime_paid) < '05:59:59' "
                . ") t where t.amount is not null and t.amount > 0";

        $query = parent::query($sql, $params);
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function summarize_account($user_email = null) {
        if (empty($user_email)) {
            return '';
        }

        $result = array();
        $params = array($user_email);

        $sql = "select a.account_name, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join account a on t.account_id = a.account_id "
                . "left join user u on a.user_id = u.user_id "
                . "where u.user_email = ? and "
                . "t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "group by a.account_id having amount > 0";
        //echo 'SQL: ' . $sql . '<br/>';

        $query = parent::query($sql, $params);
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }
        return $result;
    }

    public function summarize_merchant($user_email = null) {
        if (empty($user_email)) {
            return '';
        }

        $result = array();
        $params = array($user_email);

        $sql = "select m.merchant_name, sum(t.transaction_amount) as amount "
                . "from transaction t "
                . "left join merchant m on t.merchant_id = m.merchant_id "
                . "left join user u on t.user_id = u.user_id "
                . "where u.user_email = ? and "
                . "t.transaction_datetime_paid >= DATE_SUB(CURDATE(),INTERVAL 30 DAY) "
                . "group by m.merchant_id having amount > 0";
        //echo 'SQL: ' . $sql . '<br/>';

        $query = parent::query($sql, $params);
        foreach ($query->result_array() as $row) {
            $result[] = $row;
        }
        return $result;
    }

}

?>
