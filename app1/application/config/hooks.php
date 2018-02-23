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
/* $hook['pre_controller'] = function()
{
		// $file = APPPATH.'logs/access_log.txt';
		// if (! file_exists($file))
			// file_put_contents($file, '');
		
		// $str = file_get_contents($file);
		// $data['method'] = $_SERVER['REQUEST_METHOD'];
		// $newstr = implode('|', $data) ."\r\n".$str;
		// file_put_contents($file, $newstr);

		$ipaddress = '';
    if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
    if($_SERVER['REMOTE_ADDR'])
			$ipaddress = $_SERVER['REMOTE_ADDR'];
    else
			$ipaddress = 'UNKNOWN';

		$data['created_at'] = date('Y-m-d H:i:s');
		$data['ip_address'] = $ipaddress;
		if (! filter_var($data['ip_address'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
			$data['is_local'] = TRUE;
		}
		$data['method'] = $_SERVER['REQUEST_METHOD'];
		$data['protocol'] = $_SERVER['REQUEST_SCHEME'];
		$data['host'] = $_SERVER['HTTP_HOST'];
		$data['request_uri'] = $_SERVER['REQUEST_URI'];
		$data['user_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
		$data['platform'] = isset($_COOKIE['platform']) ? $_COOKIE['platform'] : NULL;
		$data['is_mobile'] = isset($_COOKIE['is_mobile']) ? $_COOKIE['is_mobile'] : NULL;
		$data['mobile'] = isset($_COOKIE['mobile']) ? $_COOKIE['mobile'] : NULL;
		$data['is_robot'] = isset($_COOKIE['is_robot']) ? $_COOKIE['is_robot'] : NULL;
		$data['robot'] = isset($_COOKIE['robot']) ? $_COOKIE['robot'] : NULL;
		$data['is_browser'] = isset($_COOKIE['is_browser']) ? $_COOKIE['is_browser'] : NULL;
		$data['browser'] = isset($_COOKIE['browser']) ? $_COOKIE['browser'] : NULL;
		$data['browser_ver'] = isset($_COOKIE['browser_ver']) ? $_COOKIE['browser_ver'] : NULL;
		$data['width'] = isset($_COOKIE['screen_width']) ? $_COOKIE['screen_width'] : NULL;
		$data['height'] = isset($_COOKIE['screen_height']) ? $_COOKIE['screen_height'] : NULL;

		if (in_array($data['method'], ['POST','PUT','DELETE'])) {
			// $newstr = implode('|', $data) ."\r\n".$str;
			// file_put_contents($file, $newstr);
			try{
				$conn = new PDO(DB_DSN);
				if($conn){
					$result = $conn->query("insert into a_access_log (created_at, ip_address, is_local, method, protocol, host, request_uri, user_agent, platform, mobile, browser, browser_ver, width, height)
					values (
						'".$data['created_at']."',
						'".$data['ip_address']."',
						'".$data['is_local']."',
						'".$data['method']."',
						'".$data['protocol']."',
						'".$data['host']."',
						'".$data['request_uri']."',
						'".$data['user_agent']."',
						'".$data['platform']."',
						'".$data['mobile']."',
						'".$data['browser']."',
						'".$data['browser_ver']."',
						".$data['width'].",
						".$data['height']."
					);");
					$conn = null;
				}
			}catch (PDOException $e){
				echo $e->getMessage();
				exit();
			}
		}
}; */

$hook['post_controller_constructor'] = function()
{
	$ci =& get_instance();
	$ci->load->helper('z_libs/common');
	
	if (strpos_array($_SERVER['HTTP_HOST'], ['api','v1']) === false) {
		if(isset($_COOKIE['screen_width']) AND isset($_COOKIE['screen_height'])){
			$data['width'] = $_COOKIE['screen_width'];
			$data['height'] = $_COOKIE['screen_height'];
		} else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
			setcookie('screen_width', $_REQUEST['width']);
			setcookie('screen_height', $_REQUEST['height']);
			header('Location: ' . $_SERVER['PHP_SELF']);
		} else {
			echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
		}
	}
	
	$ci->load->library('user_agent','database');
	
	$data['created_at'] = date('Y-m-d H:i:s');
	$data['ip_address'] = get_ip_address();
	if (is_private_ip($data['ip_address'])) {
		$data['is_local'] = TRUE;
	}
	$data['method'] = $_SERVER['REQUEST_METHOD']; 
	$data['protocol'] = $_SERVER['REQUEST_SCHEME'];
	$data['host'] = $_SERVER['HTTP_HOST'];
	$data['request_uri'] = $_SERVER['REQUEST_URI'];
	$data['user_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
	$data['platform'] = $ci->agent->platform();
	$data['is_mobile'] = $ci->agent->is_mobile();
	$data['mobile'] = $ci->agent->mobile();
	$data['is_robot'] = $ci->agent->is_robot();
	$data['robot'] = $ci->agent->robot();
	$data['is_browser'] = $ci->agent->is_browser();
	$data['browser'] = $ci->agent->browser();
	$data['browser_ver'] = $ci->agent->version();

	$result = $ci->db->insert('a_access_log', $data);
};