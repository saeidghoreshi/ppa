<?php

//require_once(APPPATH.'libraries/Ppa_controller.php');

/**
 * Controller for Message related actions.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */
class Message extends Ppa_controller
{
    function __construct()
    {
        // init
        parent::__construct();
        $this->cismarty->assign('config', $this->config->config);
        $this->load->model('message_model');
        $this->load->model('user_model');
        $this->load->model('account_model');
    }

    function Message()
    {

    }

    /**
     * Default controller action, displays Message records for the given
     * user.
     *
     * @access public
     * @param  string, $order_by, represents column to sort messages by
     * @param  int, $limit, represents number of messages to show
     * @param  boolean, $descend, represents message sort order, descending
     *         if true
     * @return void
     */
    public function index($order_by = null, $limit = 10, $descend = true)
    {
        // If user is not logged in, redirect to login/signup
        //$this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        $user_email = $this->authentication->get_user_email();


        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'message/overview');

        // Retrieve messages to display for user
        $messages = array();

        // --------------------------------------------------------------------
        // REQUEST TYPE: NORMAL (WEB BROWSER CLIENT)
        // --------------------------------------------------------------------
        if (!empty($order_by))
        {
            if ($order_by == TRANSACTION_ORDERBY_DATE)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_DATE_PAID), $descend, $limit);
                //echo "Sort by DATE<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_ID)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_ID), $descend, $limit);
                //echo "Sort by TRANS ID<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_TIME)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_TIME_PAID), $descend, $limit);
                //echo "Sort by TIME<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_MERCHANT)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => MERCHANT_NAME), $descend, $limit);
                //echo "Sort by MERCHANT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_NOTE)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_MERCHANT_NOTE), $descend, $limit);
                //echo "Sort by MERCHANT USER NOTE<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_STATUS)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_PAID), $descend, $limit);
                //echo "Sort by PAID<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_AMOUNT)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_AMOUNT), $descend, $limit);
                //echo "Sort by AMOUNT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_ACCOUNT)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => ACCOUNT_NAME), $descend, $limit);
                //echo "Sort by ACCOUNT<br/>";
            }
            else if ($order_by == TRANSACTION_ORDERBY_FLAG)
            {
                $messages =
                    $this->message_model->get_order_by($user_email, null,
                        array(1 => TRANSACTION_FLAGGED), $descend, $limit);
                //echo "Sort by FLAG<br/>";
            }
        }
        else
        {
            $messages = $this->message_model->get_all();
            //$messages = $this->message_model->get_order_by($user_email);
            //$order_by = TRANSACTION_ORDERBY_DATE;
        }

        // --------------------------------------------------------------------
        // REQUEST TYPE: AJAX (PHONEGAP CLIENT)
        // --------------------------------------------------------------------
//echo var_dump($messages);
        if ($is_ajax)
        {
            // Get all messages and order by default column (created date)
            $this->handle_ajax_request(AJAX_HTTP_200, $messages);
//            exit();
        }
        else
	{
    	    $this->cismarty->assign('messages', $messages);
    	    $this->cismarty->assign('descend', $descend ? "0" : "1");
    	    $this->cismarty->assign('column', $order_by);
        }
    }

    /**
     * Controller action to retrieve the details for a specific Message
     * record given its Id value.
     *
     * @access public
     * @param  string, $_POST parameter, represents database Id for the
     *         Transcation record
     * @return void
     */
    public function info()
    {
        // If user is not logged in, redirect to login/signup
        //$this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);
        

        $this->load->library('form_validation');
        $this->load->helper(array('form', 'date'));

        // Type of Account validation rules
        $this->form_validation->set_rules(FORM_ENTITY_ID, 'Message Id',
            'trim|xss_clean|required');

        if ($is_ajax)
        {
            // Validate the account id field
            if ($this->form_validation->run() == FALSE)
            {
                $this->handle_ajax_request(AJAX_HTTP_500);
            }
            else
            {
                $message =
                    $this->message_model->get_by_id($_POST[FORM_ENTITY_ID]);
/*
		$message = array_merge( array( 'message_tax'=>round((1-1/1.12)*($message['message_amount']-$message['message_tips']),2),
		    'message_subtotal'=>$message['message_amount']-(round((1-1/1.12)*($message['message_amount']-$message['message_tips']),2))-$message['message_tips'],
		    'merchant_name'=>'N/A', 'merchant_address'=>'N/A', 'merchant_phone'=>'N/A', 'message_payment_type'=>'N/A', 'message_account'=>'N/A', ), $message );
*/			
                $data = array('result' => $message);
                $this->handle_ajax_request(AJAX_HTTP_200, $data);
            }
        }
        else
        {
            $this->handle_ajax_request(AJAX_HTTP_500);
        }
    }

    public function details()
    {
        // init
        $this->check_login_redirect();

		if( $this->input->post('message_headline') )
		{
			if( $this->input->post('date_start') == 'today' )
			{
				$date_start = date('Y-m-d').' '.$this->input->post('time_start').' '.strtolower($this->input->post('ampm_start'));
			}
			elseif( $this->input->post('date_start') == 'tomorrow' )
			{
				$date_start = date( 'Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")) ).' '.$this->input->post('time_start').' '.strtolower($this->input->post('ampm_start'));
			}

			if( $this->input->post('date_end') == 'today' )
			{
				$date_end = date('Y-m-d').' '.$this->input->post('time_end').' '.strtolower($this->input->post('ampm_end'));
			}
			elseif( $this->input->post('date_end') == 'tomorrow' )
			{
				$date_end = date( 'Y-m-d', mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")) ).' '.$this->input->post('time_end').' '.strtolower($this->input->post('ampm_end'));
			}

			$data = array('merchant_id'=>$_SESSION['merchant_id'],
				'message_headline'=>$this->input->post('message_headline'),
				'message_title'=>$this->input->post('message_title'),
				'message_text'=>$this->input->post('message_text'),
				'message_category'=> $this->input->post('category'),
				'date_start'=>date('Y-m-d H:i:s',strtotime($date_start)),
				'date_end'=>date('Y-m-d H:i:s',strtotime($date_end)));
			//	'message_tags'=> implode(' ', $this->input->post('tags')),
			//echo var_dump($data);					
			if( $this->message_model->insert($data) )
			{
				$this->cismarty->assign('msg', 'Message Created');
			}
		}
		
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'message/details');
    
    }
}

/* End of file message.php */
/* Location: ./system/application/models/message.php */