<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Superclass for all controllers. Contains common functionality that is
 * required by all controllers.
 *
 * @package		PayPhoneApp
 * @author		Steve Gao
 * @copyright           Copyright (c) 2010 - 2011, UPIC
 * @since		Version 1.0
 */

class Ppa_controller extends Controller
{
    // Store any error messages that need to be rendered in the view
    protected $errors = null;
    private $CI;

    protected function __construct()
    {
        // init
        parent::Controller();
        $this->CI = & get_instance();
    }

    /**
     * Assign common variables to Smarty object, which are needed across all
     * PPA controllers.
     *
     * @return    void
     */
    protected function smarty_common_assign()
    {
        $this->load->helper('url');

        if( $this->is_mobile() )
        {
            $this->CI->cismarty->template_dir .= 'mobile/';
            $this->CI->cismarty->compile_dir .= 'mobile/';
        }
        $this->CI->cismarty->assign('is_logged_in',
        $this->CI->authentication->is_logged_in());
        $this->CI->cismarty->assign('errors', $this->CI->errors);
        $this->cismarty->assign('current_url', current_url());
        $this->cismarty->assign('uri_string', uri_string());
   }

    /**
     * Determines whether the current user is logged in, or anonymous.
     *
     * @return    bool, true if current user is logged in, false otherwise
     */
    protected function is_logged_in()
    {
        return $this->CI->authentication->is_logged_in();
    }

    /**
     * Determines whether the current device is mobile device
     *
     * @return    bool, true if current user is logged in, false otherwise
     */
    protected function is_mobile()
    {
        $this->CI->load->helper('mobile_detect');
        //return is_mobile();
        return false;
    }

    /**
     * Retrieves the current logged in user, or empty string, if the user
     * is anonymous (i.e. not logged in).
     *
     * @return    result, or empty string
     */
    protected function get_user()
    {
        $this->CI->load->model('user_model');
        $this->CI->load->model('passphrase_model');
        $this->CI->load->model('address_model');

        if( $auth_email = $this->CI->authentication->get_user_email() )
        {
            $user = $this->CI->user_model->get_user_by_email($auth_email);
        }
        elseif( $auth_phone = $this->CI->authentication->get_user_phone() )
        {
            $user = $this->CI->user_model->get_user_by_phone($auth_phone);
        }

        $user[ADDRESS_TABLE] =
            $this->CI->address_model->get_by_user($user[USER_ID]);
        $user[PASSPHRASE_TABLE] =
            $this->CI->passphrase_model->get_by_user($user[USER_ID]);

        return $user;
    }

    /**
     * Helper function to check if user is logged in already. If no, then
     * redirect to the login page.
     *
     * Used for pages that are restricted to authenticated users.
     *
     * @return    void
     */
    protected function check_login_redirect()
    {
        // If user is not logged in, redirect to login/signup
        if (!$this->is_logged_in() )
        {
            redirect($this->config->site_url(), 'refresh');
        }
    }


    /**
     * Helper function to check if user is logged in already. If yes, then
     * redirect to the profile page.
     *
     * Used for pages that are restricted to anonymous users.
     *
     * @return    void
     */
    protected function check_anonymous_redirect()
    {
        // If user is logged in, redirect to login/signup
        if ($this->is_logged_in())
        {
            redirect($this->config->site_url() . '/user/', 'refresh');
        }
    }

    /**
     * Helper function to extract a data value for a given form field. Attempt
     * to extract value from $obj_array (if non-empty). Use each of the index
     * string values within $indexes, until one index value is successful.
     * If no value is found, then return empty string.
     *
     * @return    result, or empty string
     */
    protected function get_form_data($obj_array = null, $indexes = array())
    {
        if (!empty($obj_array) && !empty($indexes))
        {
            foreach ($indexes as $index)
            {
                if (array_key_exists($index, $obj_array))
                {
                    return $obj_array[$index];
                }
            }
        }

        return '';
    }

    /**
     * Helper function to handle Ajax/JSON requests. Set the appropriate HTTP
     * headers and then output a JSON formatted object.
     *
     * @param     $http_code, HTTP code to handle
     * @param     $json_object, JSON object to format
     * @return    void
     */
    protected function handle_ajax_request($http_code = 500, $json_object = '', $msg = '')
    {
        switch($http_code)
        {
            case AJAX_HTTP_200:
                header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
                header("Status: 200 OK");
                // Ensure we have a default JSON object value
                $json_object = empty($json_object)
                    ? '{"status":"success"}'
                    : json_encode($json_object);
                echo $json_object;
                break;

            case AJAX_HTTP_401:
                header($_SERVER["SERVER_PROTOCOL"]." 401 Authorization Required");
                header("Status: 401");
                // Ensure we have a default JSON object value
                $json_object = empty($json_object)
                    ? '{"status":"unauthorized"}'
                    : json_encode($json_object);
                echo $json_object;
                die();
                break;

            case AJAX_HTTP_500:
                //header($_SERVER["SERVER_PROTOCOL"].''.( empty($msg)?'500 Failed':preg_replace('/[\n\r]+/','',$msg) )) ;
                //header("Status: 500 Failed");
                header($_SERVER["SERVER_PROTOCOL"]." 200 OK");
                header("Status: 200 OK");
                // Ensure we have a default JSON object value
                $json_object = empty($json_object)
                    ? '{"status": "'.(empty($msg)?'internal error1':preg_replace('/[\n\r]+/','',$msg) ).'"}'
                    : json_encode($json_object);
                echo $json_object;
                break;

            default :
                // Use HTTP 500 as the default response
                header($_SERVER["SERVER_PROTOCOL"]." 500 Failed");
                header("Status: 500 Failed");
                // Ensure we have a default JSON object value
                $json_object = empty($json_object)
                    ? '{"status":"internal error2"}'
                    : json_encode($json_object);
                echo $json_object;
        }

        // Call die() because we want to halt the rest of the execution
        die();
    }

    /**
     * Handles output for this controller.
     *
     * @access public
     * @param  $output to render
     * @return void
     */
    public function _output($output)
    {
        // display template
        $this->cismarty->view('template');
    }
}

/* End of file Base_controller.php */
/* Location: ./system/application/libraries/Base_controller.php */