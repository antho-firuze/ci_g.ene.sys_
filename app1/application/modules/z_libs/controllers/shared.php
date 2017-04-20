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
			
			$this->_insert_needle();

			/* Skipped the process if value is the same with in the session */
			if ($user_state == $this->session->user_state)
				return;
			
			if ($this->session->last_activity < (time()-30))
				return;
			
			$this->session->set_userdata(['user_state' => $user_state]);
			$this->session->set_userdata(['last_activity' => time()]);
			$this->db->update('a_user', ['is_online' => $user_state], ['id' => $this->session->user_id]);
			
			/* For announced to another logged session */
			$this->cache->save('table', 'a_user', 5);
		}
	}
	
	function _insert_needle()
	{
		$needle = $this->cache->get('online_users');
		if (isset($needle[$this->session->user_id])){
			$needle[$this->session->user_id]['last_activity'] = time();
		} else {
			$needle[$this->session->user_id] = ['last_activity' => time()];
		}
		$this->cache->save('online_users', $needle, 25);
	}
	
	function sse()
	{
		$output = [];
		$this->params = $this->input->get();
		
		/* heartbeat */
		
		$this->_set_user_state();
		$this->_running_shell();
		$output['table'] = $this->cache->get('table');
		
		header('Content-Type: application/json');
		header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
		echo json_encode($output);
		exit();
	}
	
	function _shell($cmd)
	{
		$WshShell = new COM("WScript.Shell"); 
		$oExec = $WshShell->Run($cmd, 0, false); 
		return $oExec == 0 ? true : false; 		
	}
	
	function _running_shell()
	{
		$php = getPHPExecutableFromPath();
		$_ci = FCPATH.SELF;
		$this->_shell("$php $_ci z_libs/shared check_innactivity");
	}
	
	function check_innactivity()
	{
		set_time_limit(0);
		if ($already_running = $this->cache->get('already_running'))
			exit();
		
		$this->cache->save('already_running', '1', 7);
		
		// debugf('check_innactivity running !');
		while($online_users = $this->cache->get('online_users')){
			// debugf('online_users true !');
			foreach($online_users as $k => $v){
				if ($v['last_activity'] < time()-10){
					// debugf('last_activity reach !');
					$this->db->update('a_user', ['is_online' => 0], ['id' => $k]);
					$this->cache->save('table', 'a_user', 5);
					// Update data on cache
					unset($online_users[$k]);
					$this->cache->save('online_users', $online_users, 25);
					break;
				}
			}
			sleep( 5 );
			continue;
		}
		
		/* if ($needle = $this->cache->get('online_users')){
			foreach($needle as $k => $v){
				if ($v['last_activity'] < time()-10){
					$this->db->update('a_user', ['is_online' => 0], ['id' => $k]);
					unset($needle[$k]);
					$this->cache->save('table', 'a_user', 5);
				}
			}
		} */
		/* while($this->cache->get('heartbeat')){
			$online_users = $this->cache->get('online_users');
			foreach($online_users as $k => $v){
				if ($v['last_activity'] < time()-10){
					$this->db->update('a_user', ['is_online' => 0], ['id' => $k]);
					$this->cache->save('table', 'a_user', 5);
				}
			}
			sleep( 5 );
			continue;
		} */
		
	}
	
	function get()
	{
		debug(FCPATH.SELF);
		$needle = $this->cache->get('online_users');
		debug($needle);
	}
	
	function set()
	{
		$needle[$this->session->user_id] = ['last_activity' => time()];
		$this->cache->save('online_users', $needle, 25);
	}
	
	function long_poll()
	{
		// set php runtime to unlimited
		set_time_limit(0);
		// where does the data come from ? In real world this would be a SQL query or something
		$data_source_file = FCPATH.'var/tmp/data.txt';
		// main loop
		while (true) {
			// Get request from client
			$this->params = $this->input->get();
			// if ajax request has send a timestamp, then $last_ajax_call = timestamp, else $last_ajax_call = null
			$last_ajax_call = isset($this->params['timestamp']) ? (int)$this->params['timestamp'] : null;
			// PHP caches file data, like requesting the size of a file, by default. clearstatcache() clears that cache
			clearstatcache();
			// get timestamp of when file has been changed the last time
			$last_change_in_data_file = filemtime($data_source_file);
			// if no timestamp delivered via ajax or data.txt has been changed SINCE last ajax timestamp
			if ($last_ajax_call == null || $last_change_in_data_file > $last_ajax_call) {
				// get content of data.txt
				$data = file_get_contents($data_source_file);
				// put data.txt's content and timestamp of last data.txt change into array
				$result = array(
					'data_from_file' => $data,
					'timestamp' => $last_change_in_data_file
				);
				header('Content-Type: application/json');
				header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
				// encode to JSON, render the result (for AJAX)
				$json = json_encode($result);
				echo $json;
				// leave this loop step
				break;
			} else {
				// wait for 1 sec (not very sexy as this blocks the PHP/Apache process, but that's how it goes)
				sleep( 5 );
				continue;
			}
			
			
			
			
		}
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
	
	function exec()
	{
		// echo exec('whoami');
		// exec("ping 192.168.1.3 -n 1 -w 90 && exit", $output);
    // print_r($output);
		exec("d:\\xampp\\php\\php.exe d:\htdocs\ci\app1\index.php z_libs/shared check_innactivity");
		debug('exec');
	}
	
	function passthru()
	{
		passthru("d:\\xampp\\php\\php.exe d:\htdocs\ci\app1\index.php z_libs/shared check_innactivity >> /path/to/log_file.log 2>&1 &");
		debug('passthru');
	}
	
}