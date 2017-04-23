<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sse extends CI_Controller {

	private $params;
	private $non_active_time = 30;
	private $flash_time = 15;
	private $storage_time = 60*60;
	private $max_counter_session = 10;
	private $max_counter_reload = 60;
	private $reload = 0;
	private $proc_sse = FCPATH.'var/etc/proc_sse';
	
	function __construct() {
		parent::__construct();
		
		if (filemtime($this->proc_sse) < (time()-60)) {
			file_put_contents($this->proc_sse, 0);
		}
		
		$this->load->driver('cache', array('adapter' => 'memcached', 'backup' => 'file', 'key_prefix' => DEFAULT_CLIENT_ID.'_'));
	}

	/* Main process on server short polling method */
	function index()
	{
		$output = [];
		$this->params = $this->input->get();
		
		$this->_1_insert_needle();
		$this->_2_counter_session();
		// $this->_3_counter_reload();
		$this->_4_set_user_state();
		$this->_5_running_shell();
		$output['reload'] = $this->reload;
		$output['table'] = $this->cache->get('table');
		
		header('Content-Type: application/json');
		header('Cache-Control: no-cache'); // recommended to prevent caching of event data.
		echo json_encode($output);
		exit();
	}
	
	/* Insert user_id & last activity time to cache */
	function _1_insert_needle()
	{
		$this->session->set_userdata(['last_activity' => time()]);
		
		$needle = $this->cache->get('online_users');
		if (isset($needle[$this->session->user_id])){
			$needle[$this->session->user_id]['last_activity'] = time();
		} else {
			$needle[$this->session->user_id] = ['last_activity' => time()];
		}
		$this->cache->save('online_users', $needle, $this->storage_time);
	}
	
	/* Reset session on a specific count */
	function _2_counter_session()
	{
		// debugf($this->session->max_counter_session);
		if (! $i = $this->session->max_counter_session)
			$this->session->set_userdata(['max_counter_session' => 1]);
		elseif ($i >= $this->max_counter_session) {
			$this->session->set_userdata(['user_state' => '']);
			$this->session->set_userdata(['max_counter_session' => 1]);
		} else {
			$i++;
			$this->session->set_userdata(['max_counter_session' => $i]);
		}
	}
	
	/* Reload page on a specific count */
	function _3_counter_reload()
	{
		if (! $i = $this->session->max_counter_reload)
			$this->session->set_userdata(['max_counter_reload' => 1]);
		elseif ($i >= $this->max_counter_reload) {
			$this->session->set_userdata(['user_state' => '']);
			$this->session->set_userdata(['max_counter_reload' => 1]);
			$this->reload = 1;
		} else {
			$i++;
			$this->session->set_userdata(['max_counter_reload' => $i]);
		}
	}
	
	/* Update user state */
	function _4_set_user_state()
	{
		if (isset($this->params['_usr_state']) && !empty($this->params['_usr_state'])) {
			$user_state = $this->params['_usr_state'];
			
			/* Skipped the process if value is the same with in the session */
			if ($user_state == $this->session->user_state)
				return;
			
			// debugf('user_state-user_id-: '.$user_state.' '.$this->session->user_id.' '.$i);
			$this->session->set_userdata(['user_state' => $user_state]);
			$this->db->update('a_user', ['is_online' => $user_state], ['id' => $this->session->user_id]);
			
			/* For announced to another logged session */
			$this->cache->save('table', 'a_user', $this->flash_time);
		}
	}
	
	/* Running shell to calling function check_innactivity */
	function _5_running_shell()
	{
		$php = getPHPExecutableFromPath();
		$_ci = FCPATH.SELF;
		$pid = run_shell("$php $_ci z_libs/sse check_innactivity");
	}
	
	/* For checking user offline */
	function check_innactivity()
	{
		set_time_limit(0);
		
		// debugf('try to running...');
		if (file_get_contents($this->proc_sse) == 1){
			// debugf('already_running !');
			file_put_contents($this->proc_sse, 1);	// For update file last update
			exit();
		}
		
		// debugf('running...');
		file_put_contents($this->proc_sse, 1);
		
		// debugf('check_innactivity running !');
		while($online_users = $this->cache->get('online_users')){

			file_put_contents($this->proc_sse, 1);	// For update file last update
			
			foreach($online_users as $k => $v){
				if ($v['last_activity'] < (time()-$this->non_active_time)){
					if ($k != ''){
						// debugf('unset user_id: '.$k);
						unset($online_users[$k]);
						// Update data on cache
						$this->cache->save('online_users', $online_users, $this->storage_time);
						// Update data on database
						$this->db->update('a_user', ['is_online' => '0'], ['id' => $k]);
						// if (! $this->db->update('a_user', ['is_online' => '0'], ['id' => $k]))
							// debugf('update table [a_user] where [id='.$k.'] => failed => '.$this->db->error()['message']);
						// else
							// debugf('update table [a_user] where [id='.$k.'] => success !');
						$this->cache->save('table', 'a_user', $this->flash_time);
						break;
					}
				}
			}
			sleep( 5 );
			continue;
		}
		
		file_put_contents($this->proc_sse, 0);
	}
	
	function get()
	{
		// debugf($this->cache->get('online_users'));
		// debug(filemtime($this->proc_sse).'|'.time().'='.(time()-filemtime($this->proc_sse)));
		// debug((file_get_contents($this->proc_sse) == 1));
		// debug(FCPATH.SELF);
		// debug($this->proc_sse);
		// debug($this->storage_time);
		// debug($this->non_active_time);
		// debug($this->session->user_state);
		// debug($this->session->last_activity);
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
	
	function shell()
	{
		$php = getPHPExecutableFromPath();
		$_ci = FCPATH.SELF;
		run_shell("$php $_ci z_libs/shared check_innactivity");
	}
	
	function passthru()
	{
		passthru("d:\\xampp\\php\\php.exe d:\htdocs\ci\app1\index.php z_libs/shared check_innactivity >> /path/to/log_file.log 2>&1 &");
		debug('passthru');
	}
	
}