<?php
//require_once(APPPATH.'libraries/Ppa_controller.php');

/*
  @file system/application/controllers/homepage.php
  @desc Homepage Controller.
  @version $Id$
  @link
  @author
 */

class Homepage extends Ppa_controller
{
    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
    }

    function Homepage()
    {

    }

    function montreal()
    {
		echo 'Montreal Landing Page';
		exit;
	}

	function index()
    {
		$this->load->helper('geo');
		$location = getLocation();
		if(!empty($location) && !empty($location->region) && $location->region == 'QC')
		{
			// redirect
			//redirect($this->config->site_url().'/homepage/montreal', 'refresh');
			//exit;
		}
		
        // assign Smarty variables
        $this->smarty_common_assign();
		$this->cismarty->assign('template', 'user/register');
        if( $this->authentication->is_logged_in() || $this->config->config['index_page'] == 'messages' )
        {
            if( $this->config->item('index_page') == 'merchant' )
            {
                // redirect to default merchant page
                redirect($this->config->site_url().'/payment/request_new', 'refresh');
                exit;
            }
            if( $this->config->item('index_page') == 'messages' )
            {
                // redirect to default merchant page
                //redirect($this->config->site_url().'/message', 'refresh');
                
                $this->cismarty->assign('transactions', array());
                $this->cismarty->assign('template', 'message/list');
            }
            else
            {
                // redirect to default user page
                redirect($this->config->site_url().'/summary', 'refresh');
                exit;
            }
    	}
    }

}

/* End of file homepage.php */
/* Location: ./system/application/controllers/homepage.php */