<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['pre_controller'] = function()
{
};

$hook['post_controller_constructor'] = function()
{
	if(isset($_SESSION['screen_width']) AND isset($_SESSION['screen_height'])){
		// $data['screen_res'] = $_SESSION['screen_width'] .'x'. $_SESSION['screen_height'];
		
		// $file = APPPATH.'logs/access_log.txt';
		// if (! file_exists($file))
			// file_put_contents($file, '');
		
		// $str = file_get_contents($file);
		
		// $ci =& get_instance();
		// $ci->load->helper('z_libs/common');
		// $ci->load->library('user_agent');
		
		// $data['ip_address'] = get_ip_address();
		// $data['method'] = $_SERVER['REQUEST_METHOD'];
		// $data['request_uri'] = $_SERVER['REQUEST_URI'];
		// $data['platform'] = $ci->agent->platform();
		// $data['is_mobile'] = $ci->agent->is_mobile();
		// $data['mobile'] = $ci->agent->mobile();
		// $data['is_robot'] = $ci->agent->is_robot();
		// $data['robot'] = $ci->agent->robot();
		// $data['is_browser'] = $ci->agent->is_browser();
		// $data['browser'] = $ci->agent->browser();
		// $data['browser_ver'] = $ci->agent->version();
		// $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

		// $newstr = date('Y-m-d H:i:s').' '. implode('|', $data) ."\r\n".$str;

		// file_put_contents($file, $newstr);
	} else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
    $_SESSION['screen_width'] = $_REQUEST['width'];
    $_SESSION['screen_height'] = $_REQUEST['height'];
    header('Location: ' . $_SERVER['PHP_SELF']);
	} else {
    echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
	}
	
};