<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/getme/libraries/Getme.php';

class Systems extends Getme 
{
	
	function __construct() {
		parent::__construct();
		
	}
	
	function _remap($method, $params = array())
	{
		if (! method_exists($this, $method))
			show_404();
		
		if (! in_array($method, ['authentication', 'login', 'logout']))
		{
			if (! (bool)$this->session->userdata('user_id'))
				redirect('login');
		}
		
		return call_user_func_array(array($this, $method), $params);
	}

	function index()
	{
		redirect('dashboard');
	}
	
	function authentication()
	{
		$remember = $this->input->server('HTTP_REMEMBER');
		$auth 	  = $this->input->server('HTTP_X_AUTH');
		
		$headers = [
			'X-API-KEY'	=> APPLICATION_KEY,
			'X-AUTH' 	=> $auth,
		];
		$request = Requests::get(API_URL.'system/authentication', $headers);
		$result = json_decode($request->body);
		
		if (! $result->status)
			$this->xresponse(FALSE, ['message' => $result->message], $request->status_code);


		$data = (array)json_decode(urlsafeB64Decode($result->data));
		$data['token'] = $result->token;
		$this->session->set_userdata($data);
		
		/* if ($remember)
		{
			$expire = (60*60*24*365*2);
			$salt = salt();
			set_cookie([
				'name'   => 'remember_user',
				'value'  => $data['user_id'],
				'expire' => $expire
			]);
			set_cookie([
				'name'   => 'remember_token',
				'value'  => $salt,
				'expire' => $expire
			]);
		} */

		$this->xresponse(TRUE, ["token" => $data['token']], $request->status_code);
	}
	
	function unlockscreen()
	{
		$auth 	  = $this->input->server('HTTP_X_AUTH');
		
		$headers = [
			'TOKEN'	 	=> $this->session->userdata('token'),
			'X-AUTH' 	=> $auth,
			// 'X-AUTH' 	=> 'Basic YWRtaW4uZmJpOjEyMzQ=',
		];
		$request = Requests::get(API_URL.'system/unlockscreen', $headers);
		$result = json_decode($request->body);
		
		if (! $result->status)
			$this->xresponse(FALSE, ['message' => $result->message], $request->status_code);

		// UPDATE TOKEN
		if (! empty($result->token))
			$this->session->set_userdata('token', $result->token);
		
		$this->xresponse(TRUE, [], $request->status_code);
	}
	
	function change_passwd()
	{
		$auth	= $this->input->server('HTTP_X_AUTH');
		$data 	= json_decode($this->input->raw_input_stream);
		
		$headers = [
			'TOKEN'	 	=> $this->session->userdata('token'),
			'X-AUTH' 	=> $auth,
		];
		$request = Requests::post(API_URL.'system/change_passwd', $headers, $data);
		$result = json_decode($request->body);
		
		if (! $result->status)
			$this->xresponse(FALSE, ['message' => $result->message], $request->status_code);

		// UPDATE TOKEN
		if (! empty($result->token))
			$this->session->set_userdata('token', $result->token);
		
		$this->xresponse(TRUE, ['message' => $result->message], $request->status_code);
	}
	
	function login()
	{
		$data['validate_link'] = site_url('systems/authentication');
		$this->backend_view('login', 'pages/systems/auth/login', $data);
	}
	
	function logout()
	{
		$this->session->unset_userdata( array('user_id') );

		// delete the remember me cookies if they exist
		if (get_cookie($this->config->item('sess_cookie_name')))
		{
			delete_cookie($this->config->item('sess_cookie_name'));
		}
		if (get_cookie('remember_user'))
		{
			delete_cookie('remember_user');
		}
		if (get_cookie('remember_token'))
		{
			delete_cookie('remember_token');
		}

		// Destroy the session
		$this->session->sess_destroy();

		//Recreate the session
		/* if (substr(CI_VERSION, 0, 1) == '2')
		{
			$this->session->sess_create();
		}
		else
		{
			$this->session->sess_regenerate(TRUE);
		} */

		// redirect('login');
		redirect('frontend');
	}
	
	// REQUIRED LOGIN
	function menulist()
	{
		$params = (object) $this->input->get();
		$this->getAPI('system', 'menulist', $params, FALSE);
	}
	
	function dashboard()
	{
		$this->backend_view('dashboard', 1);
	}
	
	function setUserRecent()
	{
		$params = (count($params = $this->input->get()) < 1) ? '' : '?'.http_build_query($params);
		$data = ['value' => current_url().$params];
		// $data = ['value' => $this->uri->uri_string().$params];
		// log_message('error', $data['value']);
		$this->postAPI('system', 'userRecent', $data, TRUE);
	}
	
	function setUserConfig()
	{
		$data = json_decode($this->input->raw_input_stream);
		$this->session->set_userdata((array)$data);
		$this->postAPI('system', 'userConfig', $data, FALSE);
	}
	
	function profile($mode=NULL)
	{
		$this->setUserRecent();
		if ($mode='r') {
			
		}
		if ($mode='c') {
			
		}
		if ($mode='u') {
			
		}
		if ($mode='d') {
			
		}
		
		$this->backend_view('crud', 'pages/systems/profile');
	}
	
	function user($mode=NULL)
	{
		switch($_SERVER['REQUEST_METHOD']){
		case 'GET':
			if ($mode=='data'){
				$arg = (object) $this->input->get();
				$this->getAPI('system', 'user', $arg, FALSE);
			}
			
			$this->backend_view('crud', 'pages/systems/user');
			
			// echo "get";
			break;
		case 'POST':
			// $this->setUserRecent();
			$data = json_decode($this->input->raw_input_stream);
			$this->postAPI('system', 'user', $data, FALSE);
			
			// echo "post";
			break;
		case 'PUT':
			// $this->setUserRecent();
			$arg = (object) $this->input->get();
			$data = json_decode($this->input->raw_input_stream);
			
			$fields = [
				'is_active', 'is_deleted', 'name', 'description', 'email', 'api_token', 'remember_token', 
				'is_online', 'supervisor_id', 'bpartner_id', 'is_fullbpaccess', 'is_expired', 'security_question',
				'security_answer', 'ip_address', 'photo_url'
			];
			foreach($fields as $f){
				if (array_key_exists($f, $data)){
					$datas[$f] = $data->{$f};
				}
			}
			if (! empty($data->password_new)) $datas['password'] = $data->password_new;
			$this->putAPI('system', 'user', $arg, $datas, FALSE);
			
			// echo "put";
			break;
		case 'DELETE':
			echo "del";
			break;
		}
	}
	
	function userlist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'userlist', $params, FALSE);
	}
	
	function supervisorlist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'userlist', $params, FALSE);
	}
	
	function info($mode=NULL)
	{
		switch($_SERVER['REQUEST_METHOD']){
		case 'GET':
			if ($mode=='data'){
				$arg = (object) $this->input->get();
				$this->getAPI('system', 'info', $arg, FALSE);
			}
			
			$this->backend_view('crud', 'systems/info');
			break;
		case 'POST':
			$this->setUserRecent();
			$data = json_decode($this->input->raw_input_stream);
			$this->postAPI('system', 'info', $data, FALSE);
			
			// echo "post";
			break;
		case 'PUT':
			$this->setUserRecent();
			echo "put";
			break;
		case 'DELETE':
			echo "del";
			break;
		}
	}
	
	function infolist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'infolist', $params, FALSE);
	}
	
	function countrylist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'countrylist', $params, FALSE);
	}
	
	function provincelist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'provincelist', $params, FALSE);
	}
	
	function citylist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'citylist', $params, FALSE);
	}
	
	function districtlist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'districtlist', $params, FALSE);
	}
	
	function villagelist()
	{
		$params = $this->input->get();
		$this->getAPI('system', 'villagelist', $params, FALSE);
	}
	
	
	function smarty()
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$data['template'] = 'SMARTY !';
		$data['elapsed_time'] = $elapsed;
		$this->smarty->view('welcome_message', $data);
	}
	
	function fenom()
	{
		$GLOBALS['identifier'] = ['user_id' => 1234567];
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$data['template'] = 'FENOM !';
		$data['elapsed_time'] = $elapsed;
		// $this->fenom->view("welcome_message", $data);
		$this->fenom->view("index", $data);
	}
	
	function smarty_test()
	{
		$this->smarty->testInstall();
	}
	
	function test()
	{
		$arr = ['assets/plugins/raphael/raphael-min.js'];
		$arr_s = serialize($arr);
		$arr_u = unserialize($arr_s);
		echo $arr_s."\n";
		return out($arr_u);
	}
	
}
