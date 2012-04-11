<?php
/**
* @file system/application/libraries/CISmarty.php
* @version $Id$                                                                                                                              
* @author
* @link 
* @desc 
*/

if (!defined('BASEPATH')) exit('No direct script access allowed');

require "smarty/libs/Smarty.class.php";

class CISmarty extends Smarty
{
	
        var $CI = null; 
        var $config = null;

	/**
	* @desc Smarty init
	*/
	
	function CISmarty()
	{
		$this->__construct();

		$this->config =& get_config();
                $this->CI =& get_instance();
		
		// if $this->config['smarty_template_dir'] is not defined use default 'application/views/' folder
		$this->template_dir = (!empty($this->config['smarty_template_dir']) ? 
			    $this->config['smarty_template_dir'] : BASEPATH . 'application/views/');

		// if $this->config['smarty_compile_dir'] is not defined use default 'cache' folder
		$this->compile_dir  = (!empty($this->config['smarty_compile_dir']) ? 
			    $this->config['smarty_compile_dir'] : BASEPATH . 'cache/');

		// determine CI full path
		if (function_exists('site_url')) {
			$this->assign("site_url", site_url());
		}
	}

	/**
	* @param $resource_name holds template filename in CI View fodler
	* @param $params array holds user varibles to be accessible in Smarty template
	* @desc diplays template
	*/
	function view($resource_name, $params = array())   {
		// 'tpl' is our default View file extension
		if (strpos($resource_name, '.') === false) {
			$resource_name .= '.tpl';
		}
		
		// assign all Smarty variables
		if (is_array($params) && count($params)) {
			foreach ($params as $key => $value) {
				$this->assign($key, $value);
			}
		}

		// Show error if View file exists to prevent silent error
		if (!is_file($this->template_dir .'/'. $resource_name)) {
			show_error("template: [$this->template_dir$resource_name] cannot be found.");
		}

		if( $this->config['index_page'] == 'merchant' && $this->getTemplateVars('template') != 'login' )
		{
		    parent::display('merchant.tpl');
		}
		else if( $this->config['index_page'] == 'messages'  )
		{
		    parent::display('messages.tpl');
		}
		else
		{
		    parent::display($resource_name);
		}
		// Display Smarty template
		//echo $this->CI->uri->segment(1);
		//return parent::display($resource_name);
	}
} // END class CISmarty
?>