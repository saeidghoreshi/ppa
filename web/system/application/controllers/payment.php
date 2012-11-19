<?php

//require_once(APPPATH.'libraries/Ppa_controller.php');

/*
  @file system/application/controllers/payment.php
  @desc Payment Controller.
  @version $Id$
  @link
  @author
 */

class Payment extends Ppa_controller
{
    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->check_login_redirect();
        $this->load->model('account_model');
    }

    function index()
    {
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'payment/index');
    }

    function request()
    {
//echo var_dump($_SESSION);    
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'payment/request');
    }
    
    function receipt()
    {
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'payment/receipt');
    }
    
    function request_new()
    {
//echo var_dump($_SESSION);    
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'payment/request_new');
    }
    
    function refill()
    {
	if( doubleval($this->input->post('amount')) <= 20
	    && intval($this->input->post('phone')) > 0 && doubleval($this->input->post('amount')) > 0 
	    && $this->input->post('phone') != $this->authentication->get_user_phone() )
	{
	    //echo var_dump($_POST);    
            $this->account_model->refill( array( 'user_phone' => preg_replace('/[^\d]/','',$this->input->post('phone')), 
        	'amount' => $this->input->post('amount'), 
        	'merchant_phone' => $this->authentication->get_user_phone() ) );
    	    redirect('payment/request_new');
	}
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'payment/refill');
    }
    
    function status()
    {
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('accounts',
            $this->account_model->get_all_by_email( $this->authentication->get_user_email() ) );
//        echo var_dump( $this->account_model->get_all_by_email( $this->authentication->get_user_email() ) );
        $this->cismarty->assign('template', 'payment/status');
    }
    
}

/* End of file payment.php */
/* Location: ./system/application/controllers/payment.php */