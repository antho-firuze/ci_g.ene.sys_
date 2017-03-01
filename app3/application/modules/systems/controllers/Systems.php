<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Systems extends Getmeb
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('systems/system_model');
		
		$this->r_method = $_SERVER['REQUEST_METHOD'];
		$this->params = $this->input->get();
	}
	
	/**
	 * Prevent direct access to this controller via URL
	 *
	 * @access public
	 * @param  string $method name of method to call
	 * @param  array  $params Parameters that would normally get passed on to the method
	 * @return void
	 */
	/*  
	public function _remap($method, $params = array())
	{
		// get controller name
		$controller = mb_strtolower(get_class($this));
		$this->c_method = $method;
		 
		if ($controller === mb_strtolower($this->uri->segment(1))) {
			// if requested controller and this controller have the same name
			// show 404 error
			show_404();
		} elseif (method_exists($this, $method))
		{
			// if method exists
			// call method and pass any parameters we recieved onto it.
			return call_user_func_array(array($this, $method), $params);
		} else {
			// method doesn't exist, show error
			show_404();
		}
	} */

	function _remap($method, $params = array())
	{
		$this->c_method = $method;
		
		/* THIS METHODS ARE NOT THROUGH CHECKING LOGIN */
		if (!in_array($method, ['x_auth', 'x_login', 'x_logout']))
		{
			if (! $this->_check_is_login())
				redirect('/');
		}
		return call_user_func_array(array($this, $method), $params);
	}

	function index()
	{
		$this->dashboard();
	}
	
	function dashboard()
	{
		$this->backend_view('dashboard1', 'pages/dashboard/dashboard1');
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
		$this->params['select'] = 't1.id, t1.client_id, t1.org_id, t1.role_id, t1.name, t1.description, t1.email, 
			t1.photo_url, ac.name as client_name, ao.name as org_name, ar.name as role_name';
		$this->params['where']['t1.id'] = $id;
		$user = (object) $this->system_model->getUserAuthentication($this->params)[0];
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
		// $this->getAPI('system', 'menulist', $params, FALSE);
		$result['data'] = [];
		$this->params['select'] = "am.name, am.url, am.icon";
		// if (key_exists('q', $this->params)) 
		if (! empty($this->params['q'])) 
		{
			$this->params['like'] = empty($this->params['sf']) 
				? DBX::like_or('am.name', $this->params['q'])
				: DBX::like_or($this->params['sf'], $this->params['q']);
			
		}
		$result['data'] = $this->system_model->getMenu($this->params);
		$this->xresponse(true, $result);
	} */
	
	/* function x_setUserRecent()
	{
		$params = (count($params = $this->input->get()) < 1) ? '' : '?'.http_build_query($this->params);
		
		$data = [
			'user_id'	=> $this->sess->user_id,
			'value'		=> current_url().$params
		];
		// log_message('error', $data['value']);
		$this->system_model->createUserRecent($data);
	} */
	
	function x_srcmenu()
	{
		$result['data'] = [];
		if (key_exists('q', $this->params)) 
			if (!empty($this->params['q']))
				$this->params['like']	= DBX::like_or('am.name', $this->params['q']);
		$result['data'] = $this->system_model->getA_Role_Menu($this->params);
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
		
		$data = [];
		if (key_exists('id', $this->params)) 
			if (!empty($this->params['id'])) {
				$data = (array) $this->system_model->getUserById($this->params['id']);
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
		$data = [];
		if (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) {
			$data = (array) $this->system_model->getMenuById($this->params['pageid']);
			
			if (! $this->_check_menu($data)) {
				$this->backend_view('crud', 'pages/404', ['message'=>$this->messages()]);
				return;
			}
			$this->backend_view('crud', $data['path'].URL_SEPARATOR.$data['url'], $data);
			return;
		}
	}
	
	function a_user()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			if (key_exists('zone', $this->params) && ($this->params['zone']))
				$this->params['where']['t1.client_id'] = $this->sess->client_id;
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name, t1.description', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if ($this->r_method == 'POST') {
			$data 	= (object) $this->post();
			$this->load->library('z_auth/auth');
			if (! $id = $this->auth->register($data->username, $data->password, $data->email, array_merge($this->fixed_data, $this->create_log)))
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);

			$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
		}
		if ($this->r_method == 'PUT') {
			$data = json_decode($this->input->raw_input_stream);
			$fields = [
				'is_active', 'is_deleted', 'name', 'description', 'email', 'api_token', 'remember_token', 'is_online', 'supervisor_id', 'bpartner_id', 'is_fullbpaccess', 'is_expired', 'security_question', 'security_answer', 'ip_address', 'photo_url'
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
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			
			if (! $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), [ 'id'=>(int)$this->params['id']]))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_role()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name, t1.description', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','name','description','currency_id','supervisor_id','amt_approval','is_canexport','is_canapproveowndoc','is_accessallorgs','is_useuserorgaccess'];
			$boolfields = ['is_active','is_canexport','is_canapproveowndoc','is_accessallorgs','is_useuserorgaccess'];
			$nullfields = ['currency_id','supervisor_id'];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_menu()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name, t1.description', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','name','description','url','path','icon','is_parent','parent_id'];
			$boolfields = ['is_active','is_parent'];
			$nullfields = ['path','icon','parent_id'];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_info()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('zone', $this->params) && ($this->params['zone'])) {
				$this->params['where']['t1.client_id'] = $this->sess->client_id;
				$this->params['where']['t1.org_id'] 	 = $this->sess->org_id;
			}
			if (key_exists('valid', $this->params) && ($this->params['valid'])) {
				$this->params['where']['t1.is_active'] = '1';
				$this->params['where']['t1.valid_from <='] = datetime_db_format();
			}
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.description', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active', 'description', 'valid_from', 'valid_till'];
			$boolfields = [];
			$nullfields = ['valid_from','valid_till'];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function c_1country()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['name'];
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function c_2province()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('country_id', $this->params) && !empty($this->params['country_id'])) 
				$this->params['where']['t1.country_id'] = $this->params['country_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['name', 'country_id'];
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function c_3city()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('province_id', $this->params) && !empty($this->params['province_id'])) 
				$this->params['where']['t1.province_id'] = $this->params['province_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['name', 'province_id'];
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function c_4district()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('city_id', $this->params) && !empty($this->params['city_id'])) 
				$this->params['where']['t1.city_id'] = $this->params['city_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['name', 'city_id'];
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function c_5village()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('district_id', $this->params) && !empty($this->params['district_id'])) 
				$this->params['where']['t1.district_id'] = $this->params['district_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = empty($this->params['sf']) 
					? DBX::like_or('t1.name', $this->params['q'])
					: DBX::like_or($this->params['sf'], $this->params['q']);

			$result['data'] = $this->system_model->{'get'.$this->c_method}($this->params);
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['name', 'district_id'];
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
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
		// echo $this->lang->line('testing');
		echo $this->c_method;
		// return out($this->getFrontendMenu(11));
		
		// $arr = ['assets/plugins/raphael/raphael-min.js'];
		// $arr_s = serialize($arr);
		// $arr_u = unserialize($arr_s);
		// echo $arr_s."\n";
		// return out($arr_u);
	}
	
}