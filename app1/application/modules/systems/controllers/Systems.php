<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Systems extends Getmeb
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('systems/system_model');
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
		if (!in_array($method, ['x_auth', 'x_login', 'x_logout', 'x_reload', 'x_forgot']))
		{
			$this->_check_is_login();
		}
		return call_user_func_array(array($this, $method), $params);
	}

	function index()
	{
		redirect(base_url().'systems/x_page?pageid=1');
	}
	
	function dashboard()
	{
		// $this->backend_view('dashboard1', 'pages/dashboard/dashboard1');
	}
	
	function x_auth()
	{
		$this->load->library('z_auth/auth');

		/* This line for processing forgot password */
		if (isset($this->params['forgot']) && $this->params['forgot']) {
			//run the forgotten password method to email an activation code to the user
			if (($user = $this->auth->forgotten_password($this->params['email'])) === FALSE){
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			
			/* Trying to sending email */
			$message = FORGOT_LNK."/".$user->forgotten_password_code;
			if($sending = send_mail($user->email, 'Your Reset Password Link', $message) !== TRUE) {
				$this->xresponse(FALSE, ['message' => $sending], 401);
			}
			
			/* success */
			$this->xresponse(TRUE, ['message' => 'The link for reset your password has been sent to your email.']);
		}
		
		/* This line for processing reset password */
		if (isset($this->params['reset']) && $this->params['reset']) {
			if (!$this->session->userdata('forgot'))
				$this->x_login();
			
			/* Reset Password*/
			if (($user = $this->auth->reset_password($username, $password)) === FALSE ) {
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			
			$this->session->unset_userdata('forgot');
			
			$this->single_view('pages/systems/auth/reset', $user);
			return;
			
		}
		/* This line for authentication login page */
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
		/* Trapping user_agent & ip address */
		/* get user_id if exists */
		$query = $this->db->get_where('a_user', ['name' => $username], 1);
		$user_id = ($query->num_rows() === 1) ? $query->row()->id : NULL;
		/* saving user_agent & ip address */
		$this->_save_useragent_ip($username, $user_id);
		
		/* Start to login */
		if (! $user_id = $this->auth->login($username, $password))
		{
			$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
		}

		/* Store configuration to session */
		$this->system_model->_store_config($user_id);
		
		if (isset($this->params['rememberme']) && $this->params['rememberme'])
		{
			$expire = (60*60*24*365*2);
			$salt = salt();
			set_cookie(['name' => 'remember_user', 'value' => $username, 'expire' => $expire]);
			set_cookie(['name' => 'remember_token', 'value' => $salt, 'expire' => $expire]);
		} else {
			set_cookie("remember_user", isset($_COOKIE["remember_user"]) ? '' : '');
			set_cookie("remember_token", isset($_COOKIE["remember_token"]) ? '' : '');
		}

		$this->xresponse(TRUE);
	}
	
	/* Re-Store configuration to session */
	function x_reload()
	{
		if ($this->sess->user_id) {
			$this->system_model->_store_config($this->sess->user_id);
		
			$this->xresponse(TRUE);
		}
		redirect(LOGIN_LNK);
	}
	
	function x_unlock()
	{
		$this->load->library('z_auth/auth');

		$http_auth 	= $this->input->server('HTTP_X_AUTH');
		
		if ($http_auth !== NULL)
		{
			if (strpos(strtolower($http_auth), 'basic') === 0)
			{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
			}
			if (! $this->auth->login($username, $password))
			{
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			$this->xresponse(TRUE);
		} else {
			$this->xresponse(FALSE, ['message' => $this->lang->line('login_unsuccessful')], 401);
		}

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
		if ($this->r_method == 'GET') {
			$this->params['where']['t1.id'] = $this->sess->user_id;
			
			if (($result['data'] = $this->system_model->get_a_user($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if ($this->r_method == 'PUT') {
			$this->load->library('z_auth/auth');
			$http_auth 	= $this->input->server('HTTP_X_AUTH');
			
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}
			if (! $this->auth->change_password($username, $password, $this->params->password_new))
			{
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}

			$this->xresponse(TRUE, ['message' => $this->auth->messages()]);
		}
		/* 
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
		 */
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
		$this->single_view('pages/systems/auth/login');
	}
	
	function x_logout()
	{
		// Destroy the session
		$this->session->sess_destroy();

		redirect(LOGIN_LNK);
	}
	
	function x_forgot($forgotten_code = NULL)
	{
		if ($forgotten_code) {
			$this->load->library('z_auth/auth');
			
			/* Checking forgotten code */
			if (($user = $this->auth->forgotten_password_complete($forgotten_code)) === FALSE ) {
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			
			$this->session->set_userdata(['forgot' => true]);
			
			$this->single_view('pages/systems/auth/reset', $user);
			return;
		}
		$this->single_view('pages/systems/auth/forgot');
	}
	
	// REQUIRED LOGIN
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
			
		$this->params['where']['am.is_active']	= '1';
		$this->params['where']['arm.is_active']	= '1';
		$this->params['where']['am.is_parent']	= '0';
		$this->params['order']	= "am.name";
		$this->params['list']	= 1;
		$result['data'] = $this->system_model->get_a_role_menu($this->params);
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
		if (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) {
			$menu = $this->base_model->getValueArray('*', 'a_menu', ['client_id','id'], [DEFAULT_CLIENT_ID, $this->params['pageid']]);
			if (! $this->_check_menu($menu)) {
				$this->backend_view('pages/404', ['message'=>'<b>'.$this->messages().'</b>']);
				return;
			}
			
			if (key_exists('edit', $this->params) && !empty($this->params['edit']))
				$this->backend_view($menu['path'].$menu['url'].'_edit', $menu);
			else
				$this->backend_view($menu['path'].$menu['url'], $menu);
			return;
		}
		$this->backend_view('pages/404', ['message'=>'']);
	}
	
	/* Don't make example from a_user & a_role */
	function a_user()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && ($this->params['id'] != '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('zone', $this->params) && ($this->params['zone']))
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if ($this->r_method == 'POST') {
			$this->load->library('z_auth/auth');
			if (! $id = $this->auth->register($this->params->name, $this->params->password, $this->params->email, array_merge($this->fixed_data, $this->create_log)))
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);

			$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
		}
		if ($this->r_method == 'PUT') {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active','is_fullbpaccess'];
			$nullfields = ['supervisor_id'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			
			if (! $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id' => $this->params->id]))
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
	
	function a_user_org()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('user_id', $this->params) && ($this->params['user_id'] != '')) 
				$this->params['where']['t1.user_id'] = $this->params['user_id'];

			if (key_exists('zone', $this->params) && ($this->params['zone']))
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t2.code, t2.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, ['client_id' => DEFAULT_CLIENT_ID]), FALSE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
			
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
	
	function a_user_role()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('user_id', $this->params) && ($this->params['user_id'] != '')) 
				$this->params['where']['t1.user_id'] = $this->params['user_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_user_substitute()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('user_id', $this->params) && ($this->params['user_id'] != '')) 
				$this->params['where']['t1.user_id'] = $this->params['user_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			$datefields = [];
			$timefields = [];
			$datetimefields = ['valid_from','valid_to'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} elseif (in_array($f, $datetimefields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : datetime_db_format($this->params->{$f}, $this->sess->date_format); 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	/* Don't make example from a_role & a_user */
	function a_role()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && ($this->params['id'] != '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active','is_canexport','is_canreport','is_canapproveowndoc','is_accessallorgs','is_useuserorgaccess'];
			$nullfields = ['currency_id','supervisor_id'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_role_menu()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('role_id', $this->params) && ($this->params['role_id'] != '')) 
				$this->params['where']['t1.role_id'] = $this->params['role_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_role_process()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('role_id', $this->params) && ($this->params['role_id'] != '')) 
				$this->params['where']['t1.role_id'] = $this->params['role_id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_system()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			$this->params['where']['t1.client_id'] 	=	DEFAULT_CLIENT_ID;
			$this->params['where']['t1.org_id']			= DEFAULT_ORG_ID;
			
			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = ['description'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_client()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active','is_securesmtp'];
			$nullfields = ['description','smtp_host','smtp_port'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			$this->params['where']['t1.client_id'] 	=	DEFAULT_CLIENT_ID;
			
			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = ['description','url','path','icon','class','method','window_title'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_org()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.code, t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active','is_parent'];
			$nullfields = ['supervisor_id','phone','phone2','fax','email','website','address_map'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_orgtype()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.code, t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
				$this->params['where']['t1.org_id'] 	 = DEFAULT_ORG_ID;
			}
			if (key_exists('valid', $this->params) && ($this->params['valid'])) {
				$this->params['where']['t1.is_active'] = '1';
				$this->params['where']['t1.valid_from <='] = datetime_db_format();
			}
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.description', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = ['valid_from','valid_till'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
	function a_loginattempt()
	{
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id'], TRUE))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	function c_currency()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
			else
				$this->params['where']['t1.country_id'] = 0;
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
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
	
}
