<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shared extends CI_Controller {

	public $params;
	
	function __construct() {
		parent::__construct();
		
		// $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file', 'key_prefix' => DEFAULT_CLIENT_ID.'_'));
		$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file', 'key_prefix' => DEFAULT_CLIENT_ID.'_'));
	}

	function _set_user_state()
	{
		if (isset($this->params['_usr_state']) && !empty($this->params['_usr_state'])) {
			$user_state = $this->params['_usr_state'];
			/* Skipped the process if value is the same with in the session */
			if ($user_state == $this->session->user_state)
				return;
			
			$this->session->set_userdata(['user_state' => $user_state]);
			$this->db->update('a_user', ['is_online' => $user_state], ['id' => $this->session->user_id]);
			
			/* Temporary solution for checking online user */
			$this->_check_online();
			
			
			/* For announced to another logged session */
			$this->cache->save('table', 'a_user', 5);
		}
	}
	
	function _check_online()
	{
		$arr = [];
		if ($online_user = $this->cache->get('online_user')){
			$arr[] = $online_user;
			$this->cache->save('online_user', $arr[], 10);
		}
		
	}
	
	function sse()
	{
		$output = [];
		$this->params = $this->input->get();
		
		$this->_set_user_state();
		$output['table'] = $this->cache->get('table');
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