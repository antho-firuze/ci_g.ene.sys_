<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shared extends CI_Controller {

	public $_usr_state;
	
	function __construct() {
		parent::__construct();
		
	}

	function _check_online()
	{
		$this->input->cookie('_usr_state');
		/* Check & Execute for every 1 hour */
		if (!empty($cookie = $this->input->cookie('_usr_state'))) {
			// debugf('$cookie 1:'.$cookie);
			if ($cookie == $this->session->user_state)
				return;
			$this->session->set_userdata(['user_state' => $cookie]);
			$this->db->update('a_user', ['is_online' => $cookie], ['id' => $this->session->user_id]);
		} else {
			// debugf('$cookie 2:'.$cookie);
			setcookie('_usr_state', 1, 0, '/ci/app1/systems','localhost');
			$this->session->set_userdata(['user_state' => 1]);
			$this->db->update('a_user', ['is_online' => '1'], ['id' => $this->session->user_id]);
		}
	}
	
	function sse()
	{
		$output = [];
		
		$this->_check_online();
		// debugf($this->session->user_id);
		// $output['code'] = '';
		// $output['message'] = '';
		// $output['code'] = 'sys.reload';
		// $output['message'] = 'Info: System was updated !';
		
		header('Content-Type: application/json');
		header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
		echo json_encode($output);
		exit();
	}
	
	function pull()
	{
		$output = [];
		
		// $output['code'] = '';
		// $output['message'] = '';
		// $output['code'] = 'sys.reload';
		// $output['message'] = 'Info: System was updated !';
		
		// header('Access-Control-Allow-Origin: *');
		header('Content-Type: text/event-stream');
		header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
		$json = json_encode($output);
		echo "data: $json \n\n";
		flush();
	}
	
}