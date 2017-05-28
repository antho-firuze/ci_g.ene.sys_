<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Systems extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = ['x_auth','x_forgot','x_login','x_logout','x_reload'];
		parent::__construct();
		
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
	}
	
	function index()
	{
		redirect(base_url().'systems/x_page?pageid=1');
	}
	
	function get_menu()
	{
		$this->getMenuStructure2(0);
	}
	
	function dashboard1()
	{
		if ($this->r_method == 'GET') {
			
			$this->params['list'] = 1;
			$this->params['ob'] = 'line_no';
			if (!$result = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				foreach($result as $key => $val){
					$result[$key]->value = 0;
					if ($val->query) {
						if (!$qry = $this->db->query($val->query)) {
							$result[$key]->value = 0;
							// debugf($this->db->error()['message']);
						} else {
							// debugf(count($qry->list_fields()));
							if (count($qry->list_fields()) == 1) {
								foreach($qry->list_fields() as $field){
									// debugf($qry->row(0)->{$field});
									$result[$key]->value = $qry->row(0)->{$field};
								}
							} else {
								foreach($qry->result() as $k => $v){
									$res[$v->key] = $v->val;
								}
								$result[$key]->value = $res;
							}
							$qry->free_result();
						}
					}
					unset($result[$key]->query);
				}
				$this->xresponse(TRUE, ['data' => $result]);
			}
		}
		// $this->backend_view('dashboard1', 'pages/dashboard/dashboard1');
		if ($this->r_method == 'POST') {
			if (isset($this->params->send_mail) && $this->params->send_mail) {
				// debug($this->params);
				if(! send_mail($this->params->email_from, $this->params->email_to, $this->params->subject, $this->params->message)) {
					$this->xresponse(FALSE, ['message' => $this->session->flashdata('message')], 401);
				}
				
				/* success */
				$this->xresponse(TRUE, ['message' => 'Your email has been sent.']);
			}
		}
	}
	
	function x_auth()
	{
		$this->load->library('z_auth/auth');

		/* This line for processing forgot password */
		if (isset($this->params['forgot']) && $this->params['forgot']) {
			//run the forgotten password method to email an activation code to the user
			if (($user = $this->auth->forgotten_password($this->params['email'])) === FALSE){
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($this->params['email'], 'Email Not Registered/Intruder Detected');
				
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			
			/* Trapping user_agent, ip address & status */
			$this->{$this->mdl}->_save_useragent($this->params['email'], 'Forgot Password Success');
		
			/* Trying to sending email */
			$message = AUTH_LNK."?code=".$user->forgotten_password_code;
			if(! send_mail(NULL, $user->email, 'Your Reset Password Link', $message)) {
				$this->xresponse(FALSE, ['message' => $this->session->flashdata('message')], 401);
			}
			
			/* success */
			$this->xresponse(TRUE, ['message' => 'The link for reset your password has been sent to your email.']);
		}
		
		/* This line for validating forgot code */
		if (isset($this->params['code']) && $this->params['code']) {
			/* Checking forgotten code */
			if (($user = $this->auth->forgotten_password_complete($this->params['code'])) === FALSE ) {
				$this->session->set_flashdata('message', '<b>'.$this->auth->errors().'</b>');
				redirect(BASE_URL.'frontend/not_found');
			}
			
			/* Marking the session for resetting password  */
			$this->session->set_userdata(['allow-reset' => true]);
			
			/* Goto reset page */
			$this->single_view('pages/systems/auth/reset', is_array($user) ? $user : (array)$user);
		}
		
		/* This line for processing reset password */
		if (isset($this->params['reset']) && $this->params['reset']) {
			if (!$this->session->userdata('allow-reset'))
				$this->x_login();
			
			$http_auth = $this->input->server('HTTP_X_AUTH');
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}
			
			/* Reset Password*/
			if (($user_id = $this->auth->reset_password($username, $password)) === FALSE ) {
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($username, 'Reset Password Failed');
				
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			
			/* Unset session allow-reset */
			$this->session->unset_userdata('allow-reset');

			/* Trapping user_agent, ip address & status */
			$this->{$this->mdl}->_save_useragent($username, 'Reset Password Success');
		
			/* Store configuration to session */
			$this->{$this->mdl}->_store_config($user_id);
			
			$this->xresponse(TRUE, ['message' => $this->auth->messages()]);
		}
		
		/* This line for authentication login page */
		if (isset($this->params['login']) && $this->params['login']) {
			$http_auth 	= $this->input->server('HTTP_X_AUTH');
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}

			$rememberme = isset($this->params['rememberme']) && $this->params['rememberme'] ? TRUE : FALSE;
			/* Try to login */
			if (! $user_id = $this->auth->login($username, $password, $rememberme)) {
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($username, 'Login Failed/Intruder Detected');
				
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}

			/* Trapping user_agent, ip address & status */
			$this->{$this->mdl}->_save_useragent($username, 'Login Success');
			
			/* Store configuration to session */
			$this->{$this->mdl}->_store_config($user_id);
			
			$this->xresponse(TRUE);
		}

		/* This line for unlock the screen */
		if (isset($this->params['unlock']) && $this->params['unlock']) {
			$this->_check_is_login();
			
			$http_auth 	= $this->input->server('HTTP_X_AUTH');
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}
			
			/* Try to unlock/login */
			if (! $this->auth->login($username, $password))
			{
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($username, 'Unlock Failed/Intruder Detected');
				
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);
			}
			
			$this->xresponse(TRUE);
		}
	}
	
	/* Re-Store configuration to session */
	function x_reload()
	{
		if ($this->session->user_id) {
			$this->{$this->mdl}->_store_config($this->session->user_id);
		
			$this->xresponse(TRUE);
		}
		redirect(LOGIN_LNK);
	}
	
	function x_chgpwd()
	{
		if ($this->r_method == 'GET') {
			$this->params['where']['t1.id'] = $this->session->user_id;
			
			if (($result['data'] = $this->{$this->mdl}->get_a_user($this->params)) === FALSE){
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
	
	// REQUIRED LOGIN
	function x_srcmenu()
	{
		if (isset($this->params['q']) && $this->params['q']) 
			$this->params['like']	= DBX::like_or('t2.name', $this->params['q']);
			
		$this->params['where']['t1.role_id']	= $this->session->role_id;
		$this->params['where']['t2.is_active']	= '1';
		$this->params['where']['t1.is_active']	= '1';
		$this->params['where']['t2.is_parent']	= '0';
		$this->params['order'] = "t2.name";
		$this->params['list']	= 1;
		$result['data'] = $this->{$this->mdl}->get_a_role_menu($this->params);
		$this->xresponse(TRUE, $result);
	}
	
	function x_profile($mode=NULL)
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['view']) && $this->params['view']) {
				$this->params['where']['t1.id'] = $this->session->user_id;
				if (($result['data'] = $this->{$this->mdl}->get_a_user($this->params)) === FALSE){
					$result['data'] = [];
					$result['message'] = $this->base_model->errors();
					$this->xresponse(FALSE, $result);
				} else {
					$this->xresponse(TRUE, $result);
				}
			}
		}
		
		if ($this->r_method == 'PUT') {
			/* This line is for update default user role & user org */
			if (isset($this->params->user_role_id) && ($this->params->user_role_id != '')) {
				if (! $this->updateRecord($this->params->table, ['user_role_id' => $this->params->user_role_id], ['id' => $this->session->user_id]))
					$this->xresponse(FALSE, ['message' => $this->session->flashdata('message')]);

				$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
			}
			if (isset($this->params->user_org_id) && ($this->params->user_org_id != '')) {
				if (! $this->updateRecord($this->params->table, ['user_org_id' => $this->params->user_org_id], ['id' => $this->session->user_id]))
					$this->xresponse(FALSE, ['message' => $this->session->flashdata('message')]);

				$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
			}
			
			/* This line is for update user config */
			if (isset($this->params->table) && ($this->params->table == 'a_user_config')) {
				$result = [];
				foreach($this->params as $k => $v) {
					$data['value'] 		 = $v;
					$cond['attribute'] = $k;
					$cond['user_id'] 	 = $this->session->user_id;
					
					/* update to session */
					$this->session->set_userdata([$k => $v]);
					/* update config to database */
					$qry = $this->db->get_where($this->params->table, $cond, 1);
					if ($qry->num_rows() > 0) {
						if (!$this->updateRecord($this->params->table, $data, $cond, TRUE))
							$result[$k] = $this->messages();	// Trapping error
					} else {
						if (!$this->insertRecord($this->params->table, array_merge($data, $cond), FALSE, TRUE))
							$result[$k] = $this->messages();	// Trapping error
					}
				}
				if (count($result) > 0) {
					$this->xresponse(FALSE, ['message' => $result]);
				} else {
					$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
				}
			}
			
			/* This line is for update user info */
			if (isset($this->params->table) && ($this->params->table == 'a_user')) {
				$fields = $this->db->list_fields($this->params->table);
				$this->boolfields = [];
				$this->nullfields = [];
				foreach($fields as $f){
					if (key_exists($f, $this->params)){
						if (in_array($f, $this->boolfields)){
							$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
						} 
						elseif (in_array($f, $this->nullfields)){
							$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
						} else {
							$datas[$f] = $this->params->{$f};
						}
					}
				}
				if (! $this->updateRecord($this->params->table, array_merge($datas, $this->update_log), ['id' => $this->params->id]))
					$this->xresponse(FALSE, ['message' => $this->messages()], 401);
				else
					$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
			}
		}
		
		if ($this->r_method == 'POST') {
			/* This process is for Upload Photo */
			if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
				if (isset($this->params->id) && $this->params->id) {
					
					if (!$result = $this->_upload_file()){
						$this->xresponse(FALSE, ['message' => $this->messages()]);
					}
						
					/* If Success */
					/* Create random filename */
					$this->load->helper('string');
					$rndName = random_string('alnum', 10);
					
					/* Moving to desire location with rename */
					$ext = strtolower(pathinfo($result['name'], PATHINFO_EXTENSION));
					$new_filename = $this->session->user_photo_path.$rndName.'.'.$ext;
					if (!is_dir($this->session->user_photo_path))
						mkdir($this->session->user_photo_path, 0755, true);
					rename($result["path"], $new_filename);
				
					/* delete old file photo */
					$tbl = $this->base_model->getValue('photo_file', 'a_user', 'id', $this->params->id);
					if ($tbl && $tbl->photo_file) {
						@unlink($this->session->user_photo_path.$tbl->photo_file);
					}
					// /* delete old file photo */
					// if (isset($this->params->photo_file) && $this->params->photo_file) {
						// @unlink($this->session->user_photo_path.$this->params->photo_file);
					// }
					/* update to table */
					$this->updateRecord('a_user', ['photo_file'=>$rndName.'.'.$ext], ['id' => $this->params->id]);
					$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving'), 'file_url' => base_url().$this->session->user_photo_path.$rndName.'.'.$ext, 'photo_file' => $rndName.'.'.$ext]);
				}
			}
		}
		
		$this->backend_view('pages/systems/x_profile');
	}
	
	/*
	*		x_page?pageid=19
	*/
	function x_page()
	{
		if (isset($this->params['pageid']) && !empty($this->params['pageid'])) {
			
			$menu = $this->_check_is_allow();
			
			/* For getting breadcrumb */
			$this->params['bread'] = [];
			if ($qry = $this->db->where_in('id', explode(',', $this->params['pageid']))->order_by('id')->get('a_menu')) {
				$menus = $qry->result();
				for($i = 0; $i < count($menus); $i++){
					$link = 'javascript:history.go(-'.(count($menus)-$i).')';
					$title = $menus[$i]->title;
					
					/* Menu only one and also the first menu */
					if (count($menus) == 1 && $i+1 == 1)
						$link = '';

					/* Last menu on bc */
					if (count($menus) == $i+1) {
						$link = ''; 
						$actions = ['new'=>'(New)', 'edt'=>'(Edit)', 'cpy'=>'(Copy)'];
						$act_name = isset($this->params['action']) && isset($actions[$this->params['action']]) ? ' '.$actions[$this->params['action']] : '';
						$title = $menus[$i]->title.$act_name;
					}
					$bc[] = ['pageid' => $menus[$i]->id, 'icon' => $menus[$i]->icon, 'title' => $title, 'title_desc' => $menus[$i]->title_desc, 'link' => $link];
				}
				$this->params['bread'] = $bc;
			}
			
			/* For identify opened table to client (property for auto reload event) */
			setcookie('table', $menu['table']);
			
			if (isset($this->params['bread']) && count($this->params['bread']) >= 0)
				$menu = array_merge($menu, ['bread' => $this->params['bread']]);
			
			/* Check for action pages */
			if (isset($this->params['action']) && !empty($this->params['action'])){
				switch($this->params['action']) {
					case 'new': 
					case 'cpy': 
					case 'edt': 
						$this->backend_view($menu['path'].$menu['table'].'_edit', $menu);
						break;
					case 'exp':
						$this->backend_view('include/export_data',$menu);
						break;
					case 'imp':
						$this->backend_view('include/import_data', $menu);
						break;
					case 'prc':
						$this->backend_view($menu['path'].$menu['method'], $menu);
						break;
					default:
						$this->backend_view('pages/404', ['message'=>'']);
				}
			}
			/* Checking the menu existance */
			if (! $this->_check_menu($menu))
				$this->backend_view('pages/404', ['message'=>$this->messages()]);
			/* Standard page */
			$this->backend_view($menu['path'].$menu['table'], $menu);
		}
		$this->backend_view('pages/404', ['message'=>'']);
	}
	
	function x_forgot()
	{
		$this->single_view('pages/systems/auth/forgot');
	}
	
	function a_loginattempt()
	{
		if ($this->r_method == 'OPTIONS') {
			if (! $this->deleteRecords('a_loginattempt', $this->params->id, TRUE))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	/* Don't make example from a_user & a_role */
	function a_user()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->protected_fields = ['user_org_id','user_role_id','api_token','password','salt','remember_token','is_online','forgotten_password_code','forgotten_password_time','ip_address','photo_file'];
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if ($this->r_method == 'POST') {
			/* This process is for Upload Photo */
			if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
				if (isset($this->params->id) && $this->params->id) {
					if (!$result = $this->_upload_file()){
						$this->xresponse(FALSE, ['message' => $this->messages()]);
					}
						
					/* If picture success upload to tmp folder */
					/* Create random filename */
					$this->load->helper('string');
					$rndName = random_string('alnum', 10);
					
					/* Moving to desire location with rename */
					$ext = strtolower(pathinfo($result['name'], PATHINFO_EXTENSION));
					$new_filename = $this->session->user_photo_path.$rndName.'.'.$ext;
					if (!is_dir($this->session->user_photo_path))
						mkdir($this->session->user_photo_path, 0755, true);
					rename($result["path"], $new_filename);
				
					/* delete old file photo */
					$tbl = $this->base_model->getValue('photo_file', $this->c_method, 'id', $this->params->id);
					if ($tbl && $tbl->photo_file) {
						@unlink($this->session->user_photo_path.$tbl->photo_file);
					}
					// if (isset($this->params->photo_file) && $this->params->photo_file) {
						// @unlink($this->session->user_photo_path.$this->params->photo_file);
					// }
					/* update to table */
					$this->updateRecord($this->c_method, ['photo_file'=>$rndName.'.'.$ext], ['id' => $this->params->id]);
					$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving'), 'file_url' => base_url().$this->session->user_photo_path.$rndName.'.'.$ext, 'photo_file' => $rndName.'.'.$ext]);
				}
			}
			
			$this->load->library('z_auth/auth');
			if (! $id = $this->auth->register($this->params->name, $this->params->password, $this->params->email, array_merge($this->fixed_data, $this->create_log)))
				$this->xresponse(FALSE, ['message' => $this->auth->errors()], 401);

			/* create avatar image */
			$data = ['word'=>$this->params->name[0], 'img_path'=>$this->session->user_photo_path, 'img_url'=> base_url().$this->session->user_photo_path];
			$data = create_avatar_img($data);
			if ($data) {
				$this->updateRecord($this->c_method, ['photo_file'=>$data['filename']], ['id' => $id]);
			}
			$this->xresponse(TRUE, ['id' => $id, 'message' => $this->lang->line('success_saving')]);
		}
		if ($this->r_method == 'PUT') {
			/* Reset Password*/
			if (isset($this->params->password) && ($this->params->password != '')) {
				$this->load->library('z_auth/auth');
				$this->auth->reset_password($this->params->name, $this->params->password);
				unset($this->params->password);
			}
			
			$this->_pre_update_records();
		}
	}
	
	function a_user_org()
	{
		$this->identity_keys = ['user_id', 'org_id'];
		
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('user_id', $this->params) && ($this->params['user_id'] != '')) 
				$this->params['where']['t1.user_id'] = $this->params['user_id'];

			if (key_exists('zone', $this->params) && ($this->params['zone']))
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or(["t2.code", "t2.name", "coalesce(t2.code,'') ||'_'|| t2.name"], $this->params['q']);

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, ['client_id' => DEFAULT_CLIENT_ID]), FALSE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_user_role()
	{
		$this->identity_keys = ['user_id', 'role_id'];
		
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['user_id']) && ($this->params['user_id'] != '')) 
				$this->params['where']['t1.user_id'] = $this->params['user_id'];
			
			if (isset($this->params['role_id']) && ($this->params['role_id'] != '')) 
				$this->params['where']['t1.role_id'] = $this->params['role_id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				// $this->params['like'] = DBX::like_or("coalesce(t2.code,'') ||'_'|| t2.name", $this->params['q']);
				$this->params['like'] = DBX::like_or(["t2.code", "t2.name", "coalesce(t2.code,'') ||'_'|| t2.name"], $this->params['q']);

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$result['str_query'] = $this->session->flashdata('str_query');
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_user_substitute()
	{
		$this->identity_keys = ['user_id', 'substitute_id'];
		
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('user_id', $this->params) && ($this->params['user_id'] != '')) 
				$this->params['where']['t1.user_id'] = $this->params['user_id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_user_config()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['user_id']) && ($this->params['user_id'] !== '')) 
				$user_id = $this->params['user_id'];
			else
				$user_id = $this->session->user_id;
			
			$user_config = $this->base_model->getValue('attribute, value', 'a_user_config', 'user_id', $user_id);
			if ($user_config) {
				$userconfig = [];
				foreach($user_config as $k => $v) {
					$userconfig[$v->attribute] = $v->value;
				}
			}
			$userconfig = ($user_config===FALSE) ? [] : $userconfig;
			$result['data'] = $userconfig;
			$this->xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->profile) && $this->params->profile) {
				/* update to session */
				$this->session->set_userdata([$this->params->name => $this->params->value]);
				/* update config to database */
				$data['value'] 		 = $this->params->value;
				$cond['attribute'] = $this->params->name;
				$cond['user_id'] 	 = $this->session->user_id;
				
				$qry = $this->db->get_where($this->c_method, $cond, 1);
				if ($qry->num_rows() > 0) {
					if (!$this->updateRecord($this->c_method, $data, $cond, TRUE))
						$this->xresponse(FALSE, ['message' => $this->messages()]);
				} else {
					if (!$this->insertRecord($this->c_method, array_merge($data, $cond), FALSE, TRUE))
						$this->xresponse(FALSE, ['message' => $this->messages()]);
				}
				$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
			}
			
			$result = [];
			foreach($this->params as $k => $v) {
				$data['value'] 		 = $v;
				$cond['attribute'] = $k;
				$cond['user_id'] 	 = $this->session->user_id;
				
				$qry = $this->db->get_where($this->c_method, $cond, 1);
				if ($qry->num_rows() > 0) {
					if (!$this->updateRecord($this->c_method, $data, $cond, TRUE))
						$result[$k] = $this->messages();
				} else {
					if (!$this->insertRecord($this->c_method, array_merge($data, $cond), FALSE, TRUE))
						$result[$k] = $this->messages();
				}
			}
			if (count($result) > 0) {
				$this->xresponse(FALSE, ['message' => $result]);
			} else {
				$this->xresponse(TRUE);
			}
		}
	}
	
	/* Don't make example from a_role & a_user */
	function a_role()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_role_menu()
	{
		$this->identity_keys = ['role_id', 'menu_id'];
		
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['role_id']) && ($this->params['role_id'] != '')) 
				$this->params['where']['t1.role_id'] = $this->params['role_id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t2.code, t2.name, t2.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				// $this->_pre_export_data();
				$this->params['export'] = 1;
				$this->params['select']	= "t1.is_active, t2.code, t2.name, t2.type, (select coalesce(code,'') ||'_'|| name from a_menu where id = t2.parent_id limit 1) as parent_name, t1.permit_form, t1.permit_process, t1.permit_window";
				$this->params['table'] 	= "a_role_menu t1";
				$this->params['join'][] = ['a_menu t2', 't1.menu_id = t2.id', 'left'];
				$this->params['where']['t1.is_deleted']	= '0';
				$this->params['where']['t2.is_deleted']	= '0';
				if (! $result = $this->base_model->mget_rec($this->params))
					$this->xresponse(FALSE, ['message' => $this->base_model->errors()]);
				
				$result = $this->_export_data($result, TRUE);
				$this->xresponse(TRUE, $result);
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			switch ($this->params->type){
				case 'F': $this->params->permit_process = ''; $this->params->permit_window = ''; break;
				case 'P': $this->params->permit_form = ''; $this->params->permit_window = ''; break;
				case 'W': $this->params->permit_form = ''; $this->params->permit_process = ''; break;
			}
			
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, FALSE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_role_dashboard()
	{
		$this->identity_keys = ['role_id', 'dashboard_id'];
		
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['role_id']) && ($this->params['role_id'] != '')) 
				$this->params['where']['t1.role_id'] = $this->params['role_id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t2.code, t2.name, t2.description', $this->params['q']);

			$this->params['ob'] = "type, line_no";
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				// $this->_pre_export_data();
				$this->params['export'] = 1;
				$this->params['select']	= "t1.is_active, t2.code, t2.name, t2.type";
				$this->params['table'] 	= "a_role_menu t1";
				$this->params['join'][] = ['a_menu t2', 't1.menu_id = t2.id', 'left'];
				$this->params['where']['t1.is_deleted']	= '0';
				$this->params['where']['t2.is_deleted']	= '0';
				if (! $result = $this->base_model->mget_rec($this->params))
					$this->xresponse(FALSE, ['message' => $this->base_model->errors()]);
				
				$result = $this->_export_data($result, TRUE);
				$this->xresponse(TRUE, $result);
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, FALSE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_role_menu_xcopy()
	{
		if ($this->r_method == 'OPTIONS') {
			/* For copy menu from another role */
			$copy_role = $this->base_model->getValueArray($this->params->role_id.' as role_id, menu_id, is_active, permit_form, permit_process, permit_window', 'a_role_menu', ['role_id', 'is_active', 'is_deleted'], [$this->params->copy_role_id, '1', '0']);
			
			if ($copy_role){
				/* Delete old role menu */
				$this->db->delete('a_role_menu', ['role_id'=>$this->params->role_id]);
				
				$error_out = [];
				foreach($copy_role as $k=>$v){
					if (! $this->db->insert('a_role_menu', $copy_role[$k])){
						$copy_role['status'] = $this->db->error()['message'];
						$error_out[] = $copy_role;
					}
				}
				if (count($error_out) > 1)
					$this->xresponse(TRUE, ['message' => $error_out]);
				else
					$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
			}
			
			$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
		}
	}
	
	function a_system()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(FALSE, FALSE);
			
			$this->params['where']['t1.client_id'] 	=	DEFAULT_CLIENT_ID;
			$this->params['where']['t1.org_id']			= DEFAULT_ORG_ID;
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_client()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(FALSE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_dashboard()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			$this->params['ob'] = "type, line_no";
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_domain()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, FALSE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_menu()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->newline) && $this->params->newline != ''){
				if (!$result = $this->updateRecord($this->c_method, ['line_no' => $this->params->newline], ['id' => $this->params->id], FALSE))
					$this->xresponse(FALSE, ['message' => $this->messages()], 401);
				else {
					$this->_reorder_menu();
					$this->xresponse(TRUE, ['message' => $this->messages()]);
				}
			}
			
			$datas = $this->_pre_update_records(TRUE);
			$datas['line_no'] = $this->db->query('select max(line_no) from a_menu where parent_id = '.$datas['parent_id'])->row()->max + 1;
			
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_menu_parent_list()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['id'] = $this->params['id'];
		
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('name', $this->params['q']);
		
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function a_org()
	{
		$this->identity_keys = ['name', 'parent_id'];
		
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			$this->params['ob'] = 'orgtype_id';
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$datas = $this->_pre_update_records(TRUE);
			$datas['client_id'] = $this->session->client_id;
			
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, FALSE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function a_org_parent_list()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['id'] = $this->params['id'];
			
			if (isset($this->params['client_id']) && !empty($this->params['client_id'])) 
				$this->params['where']['client_id'] = $this->params['client_id'];
		
			if (isset($this->params['org_id']) && !empty($this->params['org_id'])) 
				$this->params['where']['org_id'] = $this->params['org_id'];
		
			if (isset($this->params['orgtype_id']) && !empty($this->params['orgtype_id'])) 
				$this->params['where']['orgtype_id'] = $this->params['orgtype_id'];
		
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('name', $this->params['q']);
		
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function a_orgtype()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_sequence()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function a_info()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('zone', $this->params) && ($this->params['zone'])) {
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
				$this->params['where']['t1.org_id'] 	 = DEFAULT_ORG_ID;
			}
			if (key_exists('valid', $this->params) && ($this->params['valid'])) {
				$this->params['where']['t1.is_active'] = '1';
				$this->params['where']['t1.valid_from <='] = datetime_db_format();
			}
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.description', $this->params['q']);

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function c_currency()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function c_1country()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function c_2province()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('country_id', $this->params) && !empty($this->params['country_id'])) 
				$this->params['where']['t1.country_id'] = $this->params['country_id'];
			else
				$this->params['where']['t1.country_id'] = 0;
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function c_3city()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			// $this->params['where']['t1.province_id'] = isset($this->params['province_id']) ? $this->params['province_id'] : 0;
			if (key_exists('province_id', $this->params) && !empty($this->params['province_id'])) 
				$this->params['where']['t1.province_id'] = $this->params['province_id'];
			else
				$this->params['where']['t1.province_id'] = 0;
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function c_4district()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('city_id', $this->params) && !empty($this->params['city_id'])) 
				$this->params['where']['t1.city_id'] = $this->params['city_id'];
			else
				$this->params['where']['t1.city_id'] = 0;
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function c_5village()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			else 
				if (isset($this->params['district_id']) && !empty($this->params['district_id'])) 
					$this->params['where']['t1.district_id'] = $this->params['district_id'];
				else
					$this->params['where']['t1.district_id'] = 0;

			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
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