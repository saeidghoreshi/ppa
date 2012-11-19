<?php

//require_once(APPPATH.'libraries/Ppa_controller.php');

/**
 * Controller for Info related actions.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Info extends Ppa_controller
{

    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->load->model('user_model');
        $this->load->model('account_model');
        $this->load->model('address_model');
        $this->load->library('Ppa_gateway');
        $this->load->library('Beanstream_gateway');
    }

    /**
     * Default controller action to display Infos for a user profile.
     *
     * @access public
     * @return
     */
    public function index()
    {
        // init
        $this->smarty_common_assign();
		if( $this->config->item('index_page') == 'messages' )
		{
            $this->cismarty->assign('template', 'info_messages/overview');
		}
        else if (!$this->is_logged_in())
        {
            $this->cismarty->assign('template', 'info/contact');
        }
        else 
        {
            $this->cismarty->assign('template', 'info/overview');
        }
    }

    public function privacy()
    {
        $this->smarty_common_assign();
		if( $this->config->item('index_page') == 'messages' )
		{
            $this->cismarty->assign('template', 'info_messages/privacy');
		}
        else if (!$this->is_logged_in())
        {
            $this->cismarty->assign('template', 'info/contact');
        }
        else 
        {
            $this->cismarty->assign('template', 'info/privacy');
        }
    }
    
    public function terms()
    {
        $this->smarty_common_assign();
		if( $this->config->item('index_page') == 'messages' )
		{
            $this->cismarty->assign('template', 'info_messages/terms');
		}
        else if (false && !$this->is_logged_in())
        {
            $this->cismarty->assign('template', 'info/contact');
        }
        else 
        {
            $this->cismarty->assign('template', 'info/terms');
        }
    }
    
    public function policy()
    {
        $this->smarty_common_assign();
		if( $this->config->item('index_page') == 'messages' )
		{
            $this->cismarty->assign('template', 'info_messages/policy');
		}
        else if (!$this->is_logged_in())
        {
            $this->cismarty->assign('template', 'info/contact');
        }
        else 
        {
            $this->cismarty->assign('template', 'info/policy');
        }
    }
    public function contact()
    {
        $this->smarty_common_assign();
		if( $this->config->item('index_page') == 'messages' )
		{
            $this->cismarty->assign('template', 'info_messages/contact');
		}
		else
		{
			$this->cismarty->assign('template', 'info/contact');
		}
    }
    public function faq()
    {
        $this->smarty_common_assign();
		if( $this->config->item('index_page') == 'messages' )
		{
            $this->cismarty->assign('template', 'info_messages/faq');
		}
        else if (!$this->is_logged_in())
        {
            $this->cismarty->assign('template', 'info/contact');
        }
        else 
        {
            $this->cismarty->assign('template', 'info/faq');
        }
    }

}

/* End of file account.php */
/* Location: ./system/application/controllers/account.php */