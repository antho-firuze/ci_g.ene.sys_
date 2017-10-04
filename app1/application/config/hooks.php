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
		
		$ci =& get_instance();
		$ci->load->helper('z_libs/common');
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
		$data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$data['platform'] = $ci->agent->platform();
		$data['is_mobile'] = $ci->agent->is_mobile();
		$data['mobile'] = $ci->agent->mobile();
		$data['is_robot'] = $ci->agent->is_robot();
		$data['robot'] = $ci->agent->robot();
		$data['is_browser'] = $ci->agent->is_browser();
		$data['browser'] = $ci->agent->browser();
		$data['browser_ver'] = $ci->agent->version();
		$data['width'] = $_SESSION['screen_width'];
		$data['height'] = $_SESSION['screen_height'];

		$result = $ci->db->insert('a_access_log', $data);
		if (! $result)
			echo $ci->db->error()['message'];
			// echo $ci->db->last_query();
		
		/* $qry = $ci->db->get_where('a_domain', ['name' => $_SERVER['HTTP_HOST']]);
		if ($qry->num_rows() > 0)
			$newstr = implode('|', $qry->row_array()) ."\r\n".$str; */
		
		/* try{
			$conn = new PDO(DB_DSN);
			if($conn){
				$result = $conn->query("select * from a_domain where name='$http_host'");
				$conn = null;
			}
		}catch (PDOException $e){
			echo $e->getMessage();
			exit();
		} */

		// $newstr = implode('|', $data) ."\r\n".$str;
		// file_put_contents($file, $newstr);
	} else if(isset($_REQUEST['width']) AND isset($_REQUEST['height'])) {
    $_SESSION['screen_width'] = $_REQUEST['width'];
    $_SESSION['screen_height'] = $_REQUEST['height'];
    header('Location: ' . $_SERVER['PHP_SELF']);
	} else {
    echo '<script type="text/javascript">window.location = "' . $_SERVER['PHP_SELF'] . '?width="+screen.width+"&height="+screen.height;</script>';
	}
	
};