<?php

/**
 * Sms Example Controller
 * 
 * @package		PayPhoneApp
 * @author		Dmitry
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 * @filesource          system/application/controllers/sms.php
 */
require_once(APPPATH . 'libraries/Ppa_controller.php');

class Sms_twilio extends Ppa_controller {

    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        //$this->check_login_redirect();
    }

    function index()
    {
        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'sms');
    }

    function call()
    {
        
    }

    function sms()
    {
        
    }

    function send($action='view', $id=null)
    {
        if (!empty($_POST['phone']) && !empty($_POST['message']))
        {
            $this->load->library('Sms_gateway');
            $response = $this->sms_gateway->send($_POST['phone'], $_POST['message']);
            $this->cismarty->assign('response', $response);

            if (!empty($_POST['json']))
            {
                if (!empty($response->ResponseXml->RestException->Message))
                {
                    header($_SERVER["SERVER_PROTOCOL"] . " 500 Failed");
                    header("Status: 500 Failed");
                    die('{"status":"' . $response->ResponseXml->RestException->Message . '"}');
                } else
                {
                $this->cismarty->assign('response_msg', 'message sent');
                    header($_SERVER["SERVER_PROTOCOL"] . " 200 OK");
                    header("Status: 200 OK");
                    die('{"status":"sent"}');
                }
            }
            else
            {
                $this->cismarty->assign('response_msg', 'Message Sent');
            }
        } else
        {
            if (!empty($_POST['json']))
            {
                header($_SERVER["SERVER_PROTOCOL"] . " 500 Failed");
                header("Status: 500 Failed");
                die('{"status":"failed - no recepient phone or message specified"}');
            }
            else
            {
                $this->cismarty->assign('response_msg', 'failed - no recepient phone or message specified');
            }
        }


        // assign Smarty variables
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'sms');
    }

    function _output($output)
    {
        // display template
        $this->cismarty->view('template');
    }

}

/* End of file sms.php */
/* Location: ./system/application/controllers/sms.php */
?>