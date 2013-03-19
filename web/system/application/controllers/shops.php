<?php

//require_once(APPPATH . 'libraries/Ppa_controller.php');

/**
 * Controller for shops & restaurants page.
 *
 * @package		PayPhoneApp
 * @author		Gavin L
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 */
class Shops extends Ppa_controller {

    function __construct() {
        // init
        parent::__construct();
        // $this->cismarty->assign('config', $this->config->config);
        $this->load->model('shops_model');
    }

    function Shops() {
        
    }

    public function index() {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        $searchCondition = '%%';

        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'shops');

        // Get merchants
        $merchants = array();
        $merchants = $this->shops_model->search($searchCondition, $searchCondition, $searchCondition, 0);
        $is_ajax = !empty($_POST[AJAX_JSON]);

        if ($is_ajax) {
            //$this->handle_ajax_request(AJAX_HTTP_200, array('result'=>$merchants) );
            $this->handle_ajax_request(AJAX_HTTP_200, $merchants );
        }
        else
        {
    	    $this->cismarty->assign('merchants', $merchants);
    	    $this->cismarty->assign('searchCondition', $searchCondition);
        }
    }

    public function search() {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // parameter
        $searchCondition = $this->input->post('search');
        if (empty($searchCondition)) {
            $searchCondition = '%%';
        } else {
            $searchCondition = '%' . $searchCondition . '%';
        }
        //echo $searchCondition."<br/>";
        // init
        $this->smarty_common_assign();
        $this->cismarty->assign('template', 'shops');

        // Get merchants
        $merchants = array();
        $merchants = $this->shops_model->search($searchCondition, $searchCondition, $searchCondition, 0);
        $this->cismarty->assign('merchants', $merchants);
        $this->cismarty->assign('searchCondition', $searchCondition);
    }

    public function getMarkers() {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax = !empty($_POST[AJAX_JSON]);

        if ($is_ajax) {
            $searchCondition = $_POST['search'];

            $merchants = array();
            $merchants = $this->shops_model->search($searchCondition, $searchCondition, $searchCondition, 0);

            $data = array($merchants);
            $this->handle_ajax_request(AJAX_HTTP_200, $data);
        } else {
            $this->handle_ajax_request(AJAX_HTTP_500);
        }
    }

    public function getDetail() {
	return $this->get_details();
    }
    public function get_details() {
        // If user is not logged in, redirect to login/signup
        $this->check_login_redirect();

        // Create flag indicating whether HTTP request is normal or Ajax
        $is_ajax_web = !empty($_POST[AJAX_JSON.'_web']);
        $is_ajax = !empty($_POST[AJAX_JSON]);


        if ($is_ajax) {
            $shopId = $_POST['shop_id'];

            $shop_info = array();
            $shop_info = $this->shops_model->getDetail($shopId);
            
            if( !empty($shop_info['hours']) ) 
            {
                if( $hours = preg_split('/\s/', $shop_info['hours']) )
                {
                    $shop_info['hours'] = array();
                    foreach($hours AS $key=>$hour)
                    $shop_info['hours'][] = array('hour'=>$hour);
                }
            }

            $this->handle_ajax_request(AJAX_HTTP_200, array('result'=>$shop_info) );
        }
        elseif ($is_ajax_web) {
            $shopId = $_POST['shopId'];

            $shop_info = array();
            $shop_info = $this->shops_model->getDetail($shopId);

            $result = "<h3>" . $shop_info['merchant_name'] . "</h3>"
                    . "<ul class=\"shop_info_list\">"
                    . "<li class=\"column\">"
                    . "<ul>"
                    . "<li>" . $shop_info['address_street'] . "</li>"
                    . "<li>Mon - Sat 7 - 8</li>"
                    . "<li>Sun 8 - 8</li>"
                    . "<li>Phone: " . $shop_info['phone_number'] . "</li>"
                    . "</ul>"
                    . "</li>"
                    . "<li class=\"column\">"
                    . "<ul>"
                    . "<li>" . $shop_info['type'] . "</li>"
                    . "<li>&nbsp;</li>"
                 // . "<li>Email: " . $shop_info['email'] . "</li>"
                    . "</ul>"
                    . "</li>"
                    . "<li class=\"column\">"
                    . "<ul>"
                 // . "<li>Contact: " . $shop_info['contact'] . "</li>"
                    . "</ul>"
                    . "</li>"
                    . "</ul>";

            $data = array('htmlresponse' => $result, 'shopId' => $shopId);
            $this->handle_ajax_request(AJAX_HTTP_200, $data);
        } else {
            $this->handle_ajax_request(AJAX_HTTP_500);
        }
    }

}

?>
