<?php

require_once(APPPATH . 'libraries/Ppa_controller.php');

/**
 * Controller for overview page.
 *
 * @package		PayPhoneApp
 * @author		Gavin L
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 */
class Summary extends Ppa_controller {

    function __construct() {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->load->model('user_model');
        $this->load->model('address_model');
        $this->load->model('summary_model');
        $this->load->model('account_model');
        $this->load->model('transaction_model');
    }

    function Summary() {
        
    }

    public function index() {
        $this->check_login_redirect();
        $user_email = $this->authentication->get_user_email();

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'summary');

        // Get user
        $user_info = array();
        $user_info = $this->user_model->get_user_by_email($user_email);

        // Get address
        $address_info = array();
        $address_info = $this->address_model->get_by_user($user_info['user_id']);

        // Get data for graph: time of day
        $summarize_timeofday = array();
        $summarize_timeofday =
                $this->summary_model->summarize_timeofday($user_email);

        // Get data for graph: account
        //$summary_account = array();
        $summary_account = $this->summary_model->summarize_account($user_email);

        // Get data for graph: merchant
        //$summary_merchant = array();
        $summary_merchant = $this->summary_model->summarize_merchant($user_email);

        // Get account info
        //$account = array();
        $account = $this->account_model->get_all_by_email($user_email);
        if( empty($account) )
        {
            redirect('account/add');
        }

        // Get transaction info
        $transactions = array();
        $transactions = $this->transaction_model->get_order_by($user_email);
        $order_by = TRANSACTION_ORDERBY_DATE;


        $this->cismarty->assign('user_info', $user_info);
        $this->cismarty->assign('address_info', $address_info);
        $this->cismarty->assign('summary_timeofday', $summarize_timeofday);
        $this->cismarty->assign('summary_account', $summary_account);
        $this->cismarty->assign('summary_merchant', $summary_merchant);
        $this->cismarty->assign('accounts', $account);

        $this->cismarty->assign('transactions', $transactions);
        $this->cismarty->assign('descend', "0");
        $this->cismarty->assign('column', $order_by);
    }

}

?>
