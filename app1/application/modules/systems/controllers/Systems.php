<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Systems extends Getmeb
{
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('systems/system_model');
		
		$this->method = $_SERVER['REQUEST_METHOD'];
		
	}
	
	function _remap($method, $params = array())
	{
		if (! in_array($method, ['x_auth', 'x_login', 'x_logout']))
		{
			if (! (bool)$this->session->userdata('user_id'))
				redirect('/');
		}
		
		return call_user_func_array(array($this, $method), $params);
	}

	function index()
	{
		// echo 'testing';
		redirect('sys/dashboard');
	}
	
	function dashboard()
	{
		$this->backend_view('dashboard', 1);
	}
	
	function x_auth()
	{
		$this->load->library('z_auth/auth');

		$remember 	= $this->input->server('HTTP_REMEMBER');
		$http_auth 	= $this->input->server('HTTP_X_AUTH');
		$username 	= $this->input->server('PHP_AUTH_USER');
		
		$password = NULL;
		if ($username !== NULL)
		{
				$password = $this->input->server('PHP_AUTH_PW');
		}
		elseif ($http_auth !== NULL)
		{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
						list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
		}
		if (! $id = $this->auth->login($username, $password))
		{
			$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
		}

		// User Data
		// $user = $this->db->get_where('a_user', ['id'=>$id])->row();
		$params['select'] = 'au.id, au.client_id, au.org_id, au.role_id, au.name, au.description, au.email, 
			au.photo_url, ac.name as client_name, ao.name as org_name, ar.name as role_name';
		$params['where']['au.id'] = $id;
		$user = (object) $this->system_model->getUserAuthentication($params)[0];
		$dataUser = [
			'user_id' 	=> $id,
			'client_id'	=> $user->client_id,
			'org_id'	=> $user->org_id,
			'role_id'	=> $user->role_id,
			'name'			=> $user->name,
			'description'	=> $user->description,
			'email'			=> $user->email,
			'client_name'	=> $user->client_name,
			'org_name'		=> $user->org_name,
			'role_name'		=> $user->role_name,
			// 'photo_url' 	=> empty($user->photo_url) ? urlencode('http://lorempixel.com/160/160/people/') : urlencode($user->photo_url),
			'photo_url' 	=> urlencode($user->photo_url),
		];
		
		$userConfig = (object) $this->system_model->getUserConfig([
			'select' => 'attribute, value', 
			'where' => ['user_id' => $id]
		]);
		
		$dataConfig = [];
		foreach($userConfig as $k => $v)
			$dataConfig[$v->attribute] = $v->value;
		
		$data = array_merge($dataUser, $dataConfig);
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

		$this->xresponse(TRUE);
	}
	
	function x_unlock()
	{
		$this->load->library('z_auth/auth');

		$http_auth 	= $this->input->server('HTTP_X_AUTH');
		$username 	= $this->input->server('PHP_AUTH_USER');
		
		$password = NULL;
		if ($username !== NULL)
		{
				$password = $this->input->server('PHP_AUTH_PW');
		}
		elseif ($http_auth !== NULL)
		{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
						list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
		}
		if (! $id = $this->auth->login($username, $password))
		{
			$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
		}

		$this->xresponse(TRUE);
		
		/* $auth 	  = $this->input->server('HTTP_X_AUTH');
		$headers = [
			'TOKEN'	 	=> $this->session->userdata('token'),
			'X-AUTH' 	=> $auth,
		];
		$request = Requests::get(API_URL.'system/unlockscreen', $headers);
		$result = json_decode($request->body);
		
		if (! $result->status)
			$this->xresponse(FALSE, ['message' => $result->message], $request->status_code);

		// UPDATE TOKEN
		if (! empty($result->token))
			$this->session->set_userdata('token', $result->token);
		
		$this->xresponse(TRUE); */
	}
	
	function x_chgpwd()
	{
		$this->load->library('z_auth/auth');

		$http_auth 	= $this->input->server('HTTP_X_AUTH');
		$username 	= $this->input->server('PHP_AUTH_USER');
		
		$password = NULL;
		if ($username !== NULL)
		{
				$password = $this->input->server('PHP_AUTH_PW');
		}
		elseif ($http_auth !== NULL)
		{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
						list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
		}
		if (! $this->auth->change_password($username, $password, $data->password_new))
		{
			$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
		}

		$this->xresponse(TRUE, ['message' => $this->auth->messages()]);
		/* $auth	= $this->input->server('HTTP_X_AUTH');
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
		
		$this->xresponse(TRUE, ['message' => $result->message], $request->status_code); */
	}
	
	function x_login()
	{
		$this->backend_view('login', 'pages/systems/auth/login');
	}
	
	function x_logout()
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
		redirect('/');
	}
	
	// REQUIRED LOGIN
	/* function x_menulist()
	{
		$params = $this->input->get();
		// $this->getAPI('system', 'menulist', $params, FALSE);
		$result['data'] = [];
		$params['select'] = "am.name, am.url, am.icon";
		// if (key_exists('q', $params)) 
		if (! empty($params['q'])) 
		{
			$params['like'] = empty($params['sf']) 
				? DBX::like_or('am.name', $params['q'])
				: DBX::like_or($params['sf'], $params['q']);
			
		}
		$result['data'] = $this->system_model->getMenu($params);
		$this->xresponse(true, $result);
	} */
	
	/* function x_setUserRecent()
	{
		$params = (count($params = $this->input->get()) < 1) ? '' : '?'.http_build_query($params);
		
		$data = [
			'user_id'	=> $this->sess->user_id,
			'value'		=> current_url().$params
		];
		// log_message('error', $data['value']);
		$this->system_model->createUserRecent($data);
	} */
	
	function x_srcmenu()
	{
		$params = $this->input->get();
		$result['data'] = [];
		if (key_exists('q', $params)) 
			if (!empty($params['q']))
				$params['like']	= DBX::like_or('am.name', $params['q']);
		$result['data'] = $this->system_model->getMenu($params);
		$this->xresponse(TRUE, $result);
	}
	
	function x_config()
	{
		$data = json_decode($this->input->raw_input_stream);
		$this->session->set_userdata((array)$data);
		$return = 0; 
		$result['data'] = [];
		foreach($data as $key => $value)
		{
			$cond = ['user_id' => $this->sess->user_id, 'attribute' => $key];
			$qry = $this->db->get_where('a_user_config', $cond, 1);
			if ($qry->num_rows() < 1)
			{
				$data = array_merge($cond, ['value' => $value]);
				$this->system_model->createUserConfig($data);
				$return++;
			}
			else
			{
				if ($arow = $this->system_model->updateUserConfig(['value' => $value], $cond))
				{
					$return += $arow;
				}
			}
		}
		$this->xresponse(TRUE, $result);
	}
	
	function x_profile($mode=NULL)
	{
		/* 
		$params = $this->input->get();
		
		$data = [];
		if (key_exists('id', $params)) 
			if (!empty($params['id'])) {
				$data = (array) $this->system_model->getUserById($params['id']);
				$this->xresponse(TRUE, $data);
			}
				
		show_404(); */
		
		$this->backend_view('crud', 'pages/systems/profile');
	}
	
	/*
	*		x_page?pageid=19
	*/
	function x_page()
	{
		$params = $this->input->get();
		
		$data = [];
		if (key_exists('pageid', $params)) 
			if (!empty($params['pageid'])) {
				$data = (array) $this->system_model->getMenuById($params['pageid']);
				$this->backend_view('crud', $data['path'].URL_SEPARATOR.$data['url'], $data);
				return;
			}
				
		show_404();
	}
	
	function a_user()
	{
		$params = $this->input->get();
		if ($this->method == 'GET') {
			if (key_exists('id', $params)) 
				if (!empty($params['id'])) {
					$params['where']['au.id'] = $params['id'];
				}
			if (key_exists('q', $params) && !empty($params['q']))
			{
				$params['like'] = empty($params['sf']) 
					? DBX::like_or('au.name, au.description', $params['q'])
					: DBX::like_or($params['sf'], $params['q']);
			}
			$result['data'] = $this->system_model->getUser($params);
			$this->xresponse(TRUE, $result);
		}
		
		if ($this->method == 'POST') {
			$data 	= (object) $this->post();
			$additional_data = [
				'client_id'		=> $this->sess->client_id,
				'created_by'	=> $this->sess->user_id,
				'created_at'	=> date('Y-m-d H:i:s')
			];
			$this->load->library('z_auth/auth');
			if (! $id = $this->auth->register($data->username, $data->password, $data->email, $additional_data))
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);

			$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
		}
		
		if ($this->method == 'PUT') {
			$data = json_decode($this->input->raw_input_stream);
			$fields = [
				'is_active', 'is_deleted', 'name', 'description', 'email', 'api_token', 'remember_token', 
				'is_online', 'supervisor_id', 'bpartner_id', 'is_fullbpaccess', 'is_expired', 'security_question',
				'security_answer', 'ip_address', 'photo_url'
			];
			$boolfields = ['is_active', 'is_fullbpaccess'];
			$nullfields = ['supervisor_id'];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} 
					else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if (key_exists('id', $params) && !empty($params['id'])) {
				if (! $this->system_model->updateUser($datas, [ 'id'=>(int)$params['id']]))
					$this->xresponse(FALSE, ['message' => $this->db->error()->message], 401);

				$this->xresponse(TRUE, ['message' => $this->lang->line('success_update')]);
			}
			$this->xresponse(FALSE, ['message' => $this->lang->line('error_update')], 400);
		}
		
		if ($this->method == 'DELETE') {
			if (key_exists('id', $params) && !empty($params['id'])) {
				if (! $this->system_model->deleteUser($params['id'], $this->sess->user_id))
					$this->xresponse(FALSE, ['message' => $this->db->error()->message], 401);
				
				$this->xresponse(TRUE, ['message' => $this->lang->line('success_delete')]);
			}
			
			$this->xresponse(FALSE, ['message' => $this->lang->line('error_delete')], 400);
		}
		
		/* switch($_SERVER['REQUEST_METHOD']){
		case 'GET':
			break;
		case 'POST':
			break;
		case 'PUT':
			break;
		case 'DELETE':
			break;
		} */
	}
	
	function a_userlist()
	{
		$params = $this->input->get();
		
		$result['data'] = [];
		$params['where']['au.client_id'] = $this->sess->client_id;
		$params['where']['au.org_id'] 	 = $this->sess->org_id;
		if (key_exists('id', $params)) 
		{
			$params['where']['au.id'] 	 = $params['id'];
		}
		$result['data'] = $this->system_model->getUser($params);
		$this->xresponse(TRUE, $result);
		/* $params = $this->input->get();
		$this->getAPI('system', 'userlist', $params, FALSE); */
	}
	
	function a_supervisorlist()
	{
		$params = $this->input->get();
		
		$result['data'] = [];
		$params['where']['au.client_id'] = $this->sess->client_id;
		$params['where']['au.org_id'] 	 = $this->sess->org_id;
		if (key_exists('id', $params)) 
		{
			$params['where']['au.id'] 	 = $params['id'];
		}
		$result['data'] = $this->system_model->getUser($params);
		$this->xresponse(TRUE, $result);
		/* $params = $this->input->get();
		$this->getAPI('system', 'userlist', $params, FALSE); */
	}
	
	function a_info($mode=NULL)
	{
		switch($_SERVER['REQUEST_METHOD']){
		case 'GET':
			if ($mode=='data'){
				$params = $this->input->get();
				
				if (key_exists('id', $params)) 
				{
					$params['where']['ai.id'] = $params['id'];
				}
				if (key_exists('q', $params)) 
				{
					$params['like'] = empty($params['sf']) 
						? DBX::like_or('ai.description', $params['q'])
						: DBX::like_or($params['sf'], $params['q']);
				}
				if (key_exists('validf', $params)) 
				{
					$params['where']['ai.valid_from <='] = $params['validf'];
				}
				$result['data'] = $this->system_model->getInfo($params);
				$this->xresponse(TRUE, $result);
				/* $arg = (object) $this->input->get();
				$this->getAPI('system', 'info', $arg, FALSE); */
			}
			
			$this->backend_view('crud', 'systems/info');
			break;
		case 'POST':
			$data = json_decode($this->input->raw_input_stream);
			$this->postAPI('system', 'info', $data, FALSE);
			// $this->x_setUserRecent();
			
			// echo "post";
			break;
		case 'PUT':
			// $this->x_setUserRecent();
			echo "put";
			break;
		case 'DELETE':
			echo "del";
			break;
		}
	}
	
	function a_infolist()
	{
		$params = $this->input->get();
		$params['where']['ai.client_id'] = $this->sess->client_id;
		$params['where']['ai.org_id'] 	 = $this->sess->org_id;
		$params['where']['ai.valid_from <='] = datetime_db_format();
		$result['data'] = $this->system_model->getInfo($params);
		$this->xresponse(TRUE, $result);
	}
	
	function c_countrylist()
	{
		$params = $this->input->get();
		// $this->getAPI('system', 'countrylist', $params, FALSE);
		if (key_exists('q', $params)) 
			$params['like'] = empty($params['sf']) 
				? DBX::like_or('name', $params['q'])
				: DBX::like_or($params['sf'], $params['q']);
		if (key_exists('id', $params)) 
			$params['where']['id'] = $params['id'];
		
		$result['data'] = $this->system_model->getCountry($params);
		$this->xresponse(TRUE, $result);
	}
	
	function c_provincelist()
	{
		$params = $this->input->get();
		// $this->getAPI('system', 'provincelist', $params, FALSE);
		if (key_exists('q', $params)) 
			$params['like'] = empty($params['sf']) 
				? DBX::like_or('name', $params['q'])
				: DBX::like_or($params['sf'], $params['q']);
		if (key_exists('id', $params)) 
			$params['where']['id'] = $params['id'];
		if (key_exists('country_id', $params)) 
			$params['where']['country_id'] = $params['country_id'];
		
		$result['data'] = $this->system_model->getProvince($params);
		$this->xresponse(TRUE, $result);
	}
	
	function c_citylist()
	{
		$params = $this->input->get();
		// $this->getAPI('system', 'citylist', $params, FALSE);
		if (key_exists('q', $params)) 
			$params['like'] = empty($params['sf']) 
				? DBX::like_or('name', $params['q'])
				: DBX::like_or($params['sf'], $params['q']);
		if (key_exists('id', $params)) 
			$params['where']['id'] = $params['id'];
		if (key_exists('province_id', $params)) 
			$params['where']['province_id'] = $params['province_id'];
		
		$result['data'] = $this->system_model->getCity($params);
		$this->xresponse(TRUE, $result);
	}
	
	function c_districtlist()
	{
		$params = $this->input->get();
		// $this->getAPI('system', 'districtlist', $params, FALSE);
		if (key_exists('q', $params)) 
			$params['like'] = empty($params['sf']) 
				? DBX::like_or('name', $params['q'])
				: DBX::like_or($params['sf'], $params['q']);
		if (key_exists('id', $params)) 
			$params['where']['id'] = $params['id'];
		if (key_exists('city_id', $params)) 
			$params['where']['city_id'] = $params['city_id'];
		
		$result['data'] = $this->system_model->getDistrict($params);
		$this->xresponse(TRUE, $result);
	}
	
	function c_villagelist()
	{
		$params = $this->input->get();
		// $this->getAPI('system', 'villagelist', $params, FALSE);
		if (key_exists('q', $params)) 
			$params['like'] = empty($params['sf']) 
				? DBX::like_or('name', $params['q'])
				: DBX::like_or($params['sf'], $params['q']);
		if (key_exists('id', $params)) 
			$params['where']['id'] = $params['id'];
		if (key_exists('district_id', $params)) 
			$params['where']['district_id'] = $params['district_id'];
		
		$result['data'] = $this->system_model->getVillage($params);
		$this->xresponse(TRUE, $result);
	}
	
	
	function z_smarty()
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$data['template'] = 'SMARTY !';
		$data['elapsed_time'] = $elapsed;
		$this->smarty->view('welcome_message', $data);
	}
	
	function z_fenom()
	{
		$GLOBALS['identifier'] = ['user_id' => 1234567];
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$data['template'] = 'FENOM !';
		$data['elapsed_time'] = $elapsed;
		// $this->fenom->view("welcome_message", $data);
		$this->fenom->view("index", $data);
	}
	
	function z_smarty_test()
	{
		$this->smarty->testInstall();
	}
	
	function z_test()
	{
		// $this->session->userdata();
		
		// $userConfig = (object) $this->system_model->getUserConfig([
			// 'select' => 'attribute, value', 
			// 'where' => ['user_id' => 11]
		// ]);
		
		// echo $this->session->userdata('language');
		
		// $this->lang->load('systems/genesys', 'indonesia');
		// $this->lang->load('systems/genesys', 'english');
		echo $this->lang->line('testing');
		// return out($this->getFrontendMenu(11));
		
		// $arr = ['assets/plugins/raphael/raphael-min.js'];
		// $arr_s = serialize($arr);
		// $arr_u = unserialize($arr_s);
		// echo $arr_s."\n";
		// return out($arr_u);
	}
	
}
