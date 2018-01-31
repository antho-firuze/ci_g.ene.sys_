<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* THIS IS CLASS FOR BASE CONTROLLER (BACKEND) */
class Getmeb extends CI_Controller
{
	/* DEFAULT TEMPLATE */
	public $theme  	= 'adminlte';
	/* FOR REQUEST METHOD */
	public $r_method;	
	/* FOR CONTROLLER METHOD */
	public $c_method;
	/* FOR THIS METHOD USING WHICH TABLE*/
	public $c_table;
	/* FOR EXCEPTION METHOD */
	public $exception_method = [];
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	/* FOR AUTOLOAD MODEL */
	public $mdl;
	/* FOR ADDITIONAL CRUD */
	public $mixed_data = array();
	public $fixed_data = array();
	public $create_log = array();
	public $update_log = array();
	public $delete_log = array();
	public $insert_id;
	/* FOR GETTING ERROR MESSAGE OR SUCCESS MESSAGE */
	public $messages = array();
	
	/* ========================================= */
	/* This variable for dynamic page lookup		 */
	/* ========================================= */
	public $pageid;
	/* ========================================= */
	/* This variable for CRUD & IMPORT/EXPORT    */
	/* ========================================= */
	/* FOR DEFINED IDENTITY FIELD WHICH CANNOT BE DUPLICATE */
	public $identity_keys = ['name'];
	/* FOR ISOLATED FIELDS WHICH CANNOT BE EXPORT */
	public $protected_fields = ['is_deleted','created_by','updated_by','deleted_by','deleted_at'];
	/* FOR DECLARE MANDATORY IMPORTED FIELDS */
	public $imported_fields = [];		// ['code','name','description']
	/* FOR VALIDATE FOREIGN KEY */
	public $validation_fk = [];					// ['user_id' => 'a_user', 'item_id' => 'm_item']
	/* ========================================= */
	/* This variable for UPLOAD & DOWNLOAD files */
	/* ========================================= */
	// public $tmp_dir = APPPATH.'../var/tmp/';
	public $tmp_dir = FCPATH.'var/tmp/';
	public $allow_ext = 'jpg,jpeg,png,gif,xls,xlsx,csv,doc,docx,ppt,pptx,pdf,zip,rar';
	public $max_file_upload = '2mb';
	/* FOR RELATIVE TMP DIRECTORY */
	public $rel_tmp_dir = 'var/tmp/';
	
	function __construct() {
		parent::__construct();
		$this->r_method = $_SERVER['REQUEST_METHOD'];
		$this->c_method = $this->uri->segment(2);
		
		/* Load models */
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
		
		/* Defined for template */
		define('ASSET_URL', base_url().'/assets/');
		define('TEMPLATE_URL', base_url().TEMPLATE_FOLDER.'/backend/'.$this->theme.'/');
		define('TEMPLATE_PATH', '/backend/'.$this->theme.'/');
		
		$this->fixed_data = [
			'client_id'		=> DEFAULT_CLIENT_ID,
			'org_id'			=> $this->session->org_id,
		];
		$this->create_log = [
			'created_by'	=> (!empty($this->session->user_id) ? $this->session->user_id : '0'),
			'created_at'	=> date('Y-m-d H:i:s')
		];
		$this->update_log = [
			'updated_by'	=> (!empty($this->session->user_id) ? $this->session->user_id : '0'),
			'updated_at'	=> date('Y-m-d H:i:s')
		];
		$this->delete_log = [
			'is_deleted'	=> 1,
			'deleted_by'	=> (!empty($this->session->user_id) ? $this->session->user_id : '0'),
			'deleted_at'	=> date('Y-m-d H:i:s')
		];

		$this->_heartbeat();
		$this->_clear_tmp();
		
		/* This method for Login, unlock screen */
		if (in_array($this->r_method, ['UNLOCK', 'LOCK'])) {
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
			$this->params = (array)$this->params;
		} 
		
		/* This method for Selection Role Window */
		if (in_array($this->r_method, ['PATCH'])) {
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
		}
		
		/* This method for GETTING/VIEWING Data & Document */
		if (in_array($this->r_method, ['GET'])) {
			
			/* Become Array */
			$this->params = $this->input->get();
			
			/* This params for getting process status */
			if (isset($this->params['get_process']) && !empty($this->params['get_process'])) {
				$this->_get_process();
			}
			
			/* This process is for bypass methods which do not need to login */
			if (count($this->exception_method) > 0){
				if (! in_array($this->c_method, $this->exception_method)){
					$this->_check_is_allow();
				}
			}
		
			/* Parsing pageid */
			if (isset($this->params['pageid'])) {
				$this->pageid = @end(explode(',', $this->params['pageid']));
				// $this->pageid = explode(',', $this->params['pageid']);
				// $this->pageid = end($this->pageid);
			}
			
			/* Request for viewlog */
			if (isset($this->params['viewlog']) && !empty($this->params['viewlog'])) {
				$pageid = explode(',', $this->params['pageid']);
				$this->c_table = $this->base_model->getValue('table', 'a_menu', 'id', end($pageid))->table;
				/* Check permission in the role */
				$this->_check_is_allow_inrole('canviewlog');
				$this->_get_viewlog();
			}
			
			/* Request for Export Data */
			if (isset($this->params['action']) && !empty($this->params['action'])) {
				switch($this->params['action']) {
					case 'exp':
						/* Check permission in the role */
						$this->_check_is_allow_inrole('canexport');
						break;
					case 'imp':
						/* Check permission in the role */
						$this->_check_is_allow_inrole('canexport');
						break;
				}
			}
			// if (isset($this->params['export']) && !empty($this->params['export'])) {
				// /* Check permission in the role */
				// $this->_check_is_allow_inrole('canexport');
			// }
			// debug($this->c_table);
		}
		
		/* This Request for INSERT & UPDATE Data */
		if (in_array($this->r_method, ['POST','PUT'])) {
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
			
			/* Must be checking permission before next process */
			$this->_check_is_allow();
			
			/* Request for import */
			if (isset($this->params->import) && !empty($this->params->import)) {
				
				/* Trigger events before import */
				$this->params->event = 'pre_import';
				$this->{$this->c_method}();
				
				$this->_import_data();
			}
			
			$this->_record_permutation_save();
		}
		
		/* This Request for DELETE Data */
		if (in_array($this->r_method, ['DELETE'])) {
			/* Must be checking permission before next process */
			$this->_check_is_allow();

			/* Become Array */
			$this->params = $this->input->get();
			
			$this->_record_permutation_delete();
		}
		
		/* This Request for EXPORT/IMPORT, PROCESS/REPORT & FORM  */
		if (in_array($this->r_method, ['OPTIONS'])) {
			/* Must be checking permission before next process */
			$this->_check_is_allow();
			
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
			
			/* Check is in params have a variable "is_allow" */
			// if (isset($this->params->is_allow) && !empty($this->params->is_allow)) {
				// xresponse(TRUE, ['is_allow' => 1]);
			// }
			
			/* Request for Export Data */
			if (isset($this->params->export) && !empty($this->params->export)) {
				/* Check permission in the role */
				$this->_check_is_allow_inrole('canexport');
				$this->_pre_export_data();
			}
		}
	}
	
	function _heartbeat()
	{
		/* update current user heartbeat */
		$this->db->update('a_user', ['heartbeat' => time()], ['id' => $this->session->user_id]);
		/* update inactive user status */
		$this->db->update('a_user', ['is_online' => '0', 'heartbeat' => null], ['(extract(epoch from now()) - heartbeat) >' => 60 * 15]);
	}
	
	/* This procedure is for cleaning a tmp file & tmp_tables */
	function _clear_tmp()
	{
		/* Note: 60(sec) x 60(min) x 2-24(hour) x 2~(day) */
		
		/* Check & Execute for every 1 hour */
		if (!empty($cookie = $this->input->cookie('_clear_tmp'))) {
			if ((time()-$cookie) < 60*60) 
				return;
		}
				
		setcookie('_clear_tmp', time());
		// if ($handle = @opendir($this->tmp_dir)) {
			// while (false !== ($file = @readdir($handle))) {
				// if (! preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $file)) {
					// if ((time()-filectime($this->tmp_dir.$file)) > 60*60) {  
						// @unlink($this->tmp_dir.$file);
					// }
				// }
			// }
		// }
		
		/* Cleaning tmp_tables */
		$qry = $this->db->get_where('a_tmp_tables', ['time <' => time()-60*60]);
		if ($qry->num_rows() > 0){
			$this->load->dbforge();
			foreach($qry->result() as $k => $v){
				$this->dbforge->drop_table($v->name,TRUE);
			}
			$this->db->where('time <', time()-60*60, FALSE);
			$this->db->delete('a_tmp_tables');
		}
	}
	
	function _check_menu($data=[])
	{
		/* CHECK METHOD */
		if (empty($data['method'])) {
			$this->set_message('ERROR: Menu [method] is could not be empty !');
			return FALSE;
		}
		
		/* CHECK PATH FILE */
		if (!$this->_check_path($data['path'].$data['method'])) {
			$this->set_message('ERROR: Menu [path] is could not be found or file not exist !');
			return FALSE;
		}
		
		if (key_exists('edit', $this->params) && !empty($this->params['edit'])) {
			if (!$this->_check_path($data['path'].$data['method'].'_edit')) {
				$this->set_message('ERROR: Page or File ['.$data['path'].$data['method'].'_edit'.'] is could not be found or file not exist !');
				return FALSE;
			}
		}
		
		/* CHECK CLASS/CONTROLLER */
		if (!$this->_check_class($data['class'])) {
			$this->set_message('ERROR: Menu [class] is could not be found or file not exist !');
			return FALSE;
		}
		
		return TRUE;
	}
	
	function _check_path($path)
	{
		return file_exists(APPPATH.'../'.TEMPLATE_FOLDER.'/backend/'.$this->theme.'/'.$path.'.tpl') ? TRUE : FALSE;
	}
	
	function _check_class($class)
	{
		return file_exists(APPPATH.'modules/'.$class.'/controllers/'.$class.'.php') ? TRUE : FALSE;
	}
	
	function _check_is_login()
	{
		/* Check the session data for user_id */
		if (! $this->session->userdata('user_id')) {
			/* set reference url to session */
			setURL_Index();
			/* forward to login page */
			$this->x_login();
			// redirect(LOGIN_LNK);
			exit();
		}
		return TRUE;
	}
	
	/* 
	*
	*	$param1 = Default: 'json' | 'html' 
	*
	*/
	function _check_is_allow($output = 'json')
	{
		/* Trick for transition after login, which calling class "systems" without method. */
		if (! $this->c_method)
			return array();
		
		$this->_check_is_login();
		
		/* Check menu existance on the table a_menu */
		// debug($this->c_method);
		if ($this->pageid)
			$menu = $this->base_model->getValueArray('*', 'a_menu', ['client_id','id'], [DEFAULT_CLIENT_ID, $this->pageid]);
		else
			$menu = $this->base_model->getValueArray('*', 'a_menu', ['client_id','method'], [DEFAULT_CLIENT_ID, $this->c_method]);
		
		if (!$menu){
			/* This process is for bypass methods which do not need to login */
			if (count($this->exception_method) > 0){
				if (in_array($this->c_method, $this->exception_method))
					return $menu;
			} else {
				if (strtolower($output) == 'json')
					xresponse(FALSE, ['message' => 'Menu permission not found !'], 401);
				else
					$this->backend_view('pages/404', ['message' => 'Menu permission not found !']);
			}
		}
		
		/* This params for x_role_selection */
		if (key_exists('identify', (array)$this->params))
			return TRUE;
		// debug(in_array('identify', $this->params));
		
		// debug($this->session->role_id);
		if (! $this->session->role_id)
			// redirect('systems/x_profile');
			$this->single_view('pages/systems/auth/select_role');
		
		/* Set this menu using this table */
		// debug($menu);
		$this->c_table = $menu['table'];

		/* Check menu active & permission on the table a_role_menu */
		$allow = $this->base_model->getValue('permit_form, permit_process, permit_window', 'a_role_menu', ['role_id', 'menu_id', 'is_active', 'is_deleted'], [$this->session->role_id, $menu['id'], '1', '0']);
		if (!$allow) {
			if (strtolower($output) == 'json')
				xresponse(FALSE, ['message' => sprintf('Permission [%s] <b>not found</b> or <b>not active</b> in [a_role_menu] !', $menu['name'])], 401);
			else
				$this->backend_view('pages/unauthorized', ['message' => sprintf('Permission [%s] <b>not found</b> or <b>not active</b> in [a_role_menu] !', $menu['name'])]);
		}
		
		/* Permission for view */
		if ($this->r_method == 'GET' && $allow)
			return $menu;
		
		if ($menu['type'] == 'F') {
			switch($allow->permit_form){
			case '1':
				/* Execute */
				if (!in_array($this->r_method, ['OPTIONS'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			default:
				if (strtolower($output) == 'json')
					xresponse(FALSE, ['message' => lang('error_permit_crud'), 'note' => sprintf('Permission [%s] is not set !', $menu['name'])], 401);
				else
					$this->backend_view('pages/unauthorized', ['message' => sprintf('Permission [%s] is not set !', $menu->name)]);
				break;
			}
		}
		if ($menu['type'] == 'P') {
			switch($allow->permit_process){
			case '1':
				/* Export */
				if (!in_array($this->r_method, ['OPTIONS'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			default:
				if (strtolower($output) == 'json')
					xresponse(FALSE, ['message' => lang('error_permit_crud'), 'note' => sprintf('Permission [%s] is not set !', $menu['name'])], 401);
				else
					$this->backend_view('pages/unauthorized', ['message' => sprintf('Permission [%s] is not set !', $menu['name'])]);
				break;
			}
		}
		if ($menu['type'] == 'W') {
			switch($allow->permit_window){
			case '1':
				/* Only Create */
				if (!in_array($this->r_method, ['POST'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			case '2':
				/* Only Edit */
				if (!in_array($this->r_method, ['PUT'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			case '3':
				/* Only Delete */
				if (!in_array($this->r_method, ['DELETE'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			case '4':
				/* Can Create & Edit */
				if (!in_array($this->r_method, ['POST','PUT'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			case '5':
				/* Can Create & Delete */
				if (!in_array($this->r_method, ['POST','DELETE'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			case '6':
				/* Can Edit & Delete */
				if (!in_array($this->r_method, ['PUT','DELETE'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			case '7':
				/* Can All */
				if (!in_array($this->r_method, ['POST','PUT','DELETE'])) {
					if (strtolower($output) == 'json')
						xresponse(FALSE, ['message' => lang('error_permit_crud')], 401);
					else
						$this->backend_view('pages/unauthorized', ['message' => lang('error_permit_crud')]);
				}
				break;
			default:
				if (strtolower($output) == 'json')
					xresponse(FALSE, ['message' => lang('error_permit_crud'), 'note' => sprintf('Permission [%s] is not set !', $menu['name'])], 401);
				else
					$this->backend_view('pages/unauthorized', ['message' => sprintf('Permission [%s] is not set !', $menu['name'])]);
				break;
			}
		}
		return $menu;
	}
	
	function _check_is_allow_inrole($permit)
	{
		$role = $this->base_model->getValue('*', 'a_role', 'id', $this->session->role_id);
		switch($permit){
			case 'canviewlog':
				if (!$role->is_canviewlog)
					$this->backend_view('pages/unauthorized', ['message'=>'You are not authorized !']);
					// xresponse(FALSE, ['message' => lang('error_permit_crud')]);
				break;
			case 'canexport':
				if (!$role->is_canexport)
					$this->backend_view('pages/unauthorized', ['message'=>'You are not authorized !']);
					// xresponse(FALSE, ['message' => lang('error_permit_crud')]);
				break;
			case 'canapproveowndoc':
				if (!$role->is_canapproveowndoc)
					$this->backend_view('pages/unauthorized', ['message'=>'You are not authorized !']);
					// xresponse(FALSE, ['message' => lang('error_permit_crud')]);
				break;
			case 'canreport':
				if (!$role->is_canreport)
					$this->backend_view('pages/unauthorized', ['message'=>'You are not authorized !']);
					// xresponse(FALSE, ['message' => lang('error_permit_crud')]);
				break;
		}
	}
	
	function _get_process()
	{
		usleep(100000);
		// if ($process = $this->base_model->getValue('*', 'a_tmp_process', 'id', $this->params['id'])){
		if ($process = $this->base_model->getValue('*', 'a_tmp_process', 'id', $this->session->id_process)){
			xresponse(TRUE, ['data' => $process]);
		}
		xresponse(FALSE, ['message' => sprintf('Error: Retrieving process [id=%s] failed !', $this->session->id_process)], 401);
	}
	
	function _get_viewlog()
	{
		$result = [];
		$result['table'] = $this->c_table;
		$result['id'] = $this->params['id'];
		if ($info = $this->base_model->getValue('created_by, created_at, updated_by, updated_at, deleted_by, deleted_at', $result['table'], 'id', $this->params['id'])){
			if ($info->created_by){
				if ($user = $this->base_model->getValue('id, name', 'a_user', 'id', $info->created_by)) {
					$result['created_by'] 		 = $user->id;
					$result['created_at'] 		 = $info->created_at;
					$result['created_by_name'] = $user->name;
				}
			}
			if ($info->updated_by){
				if ($user = $this->base_model->getValue('id, name', 'a_user', 'id', $info->updated_by)) {
					$result['updated_by'] 		 = $user->id;
					$result['updated_at'] 		 = $info->updated_at;
					$result['updated_by_name'] = $user->name;
				}
			}
			if ($info->deleted_by){
				if ($user = $this->base_model->getValue('id, name', 'a_user', 'id', $info->deleted_by)) {
					$result['deleted_by'] 		 = $user->id;
					$result['deleted_at'] 		 = $info->deleted_at;
					$result['deleted_by_name'] = $user->name;
				}
			}
		}
		xresponse(TRUE, ['data' => $result]);
	}
	
	function _record_mixing_data($table = NULL, $fixed_data = TRUE, $log = TRUE)
	{
		$datas = [];
		$fields = $this->db->list_fields( $table ? $table : $this->c_table );
		foreach($fields as $f){
			if (key_exists($f, $this->params)){
				/* Check if any exists allow null fields */
				$datas[$f] = ($this->params->{$f} == '') ? NULL : $this->params->{$f}; 
				
				/* Check if any exists boolean fields */
				/* if (in_array($f, $this->boolfields)){
					$datas[$f] = empty($this->params->{$f}) ? '0' : '1'; 
				}  */
				/* Check if any exists allow null fields */
				/* elseif (in_array($f, $this->nullfields)){
					$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
				} else {
					$datas[$f] = $this->params->{$f};
				} */
			}
		}
		
		if ($this->r_method == 'POST') {
			$datas = $fixed_data ? array_merge($datas, $this->fixed_data) : $datas;
			$datas = $log ? array_merge($datas, $this->create_log) : $datas;
		} else {
			$datas = $log ? array_merge($datas, $this->update_log) : $datas;
		}
		
		$this->mixed_data = $datas;
	}
	
	function _record_permutation_save()
	{
		/* Mixing the Data */
		$this->_record_mixing_data();
		
		/* Trigger events before POST & PUT */
		$this->params->event = 'pre_post_put';
		$this->{$this->c_method}();
		
		/* Trigger events before POST */
		if ($this->r_method == 'POST') {
			$this->params->event = 'pre_post';
			$this->{$this->c_method}();
		}
		
		/* Trigger events before PUT */
		if ($this->r_method == 'PUT') {
			$this->params->event = 'pre_put';
			$this->{$this->c_method}();
		}
		
		/* Go INSERT or UPDATE */
		if ($this->r_method == 'POST') {
			$result = $this->_recordInsert($this->c_table, $this->mixed_data);
			$this->insert_id = $result;
			
			/* _crudlog here */
			// $this->_crudlog($result, 1);
		} else {
			/* _crudlog here */
			$this->_crudlog($this->params->id, 2);
			
			$result = $this->_recordUpdate($this->c_table, $this->mixed_data, ['id'=>$this->params->id]);
		}
		
		/* Trigger events after POST & PUT */
		$this->params->event = 'post_post_put';
		$this->{$this->c_method}();
		
		/* Trigger events before POST */
		if ($this->r_method == 'POST') {
			$this->params->event = 'post_post';
			$this->{$this->c_method}();
		}
		
		/* Trigger events before PUT */
		if ($this->r_method == 'PUT') {
			$this->params->event = 'post_put';
			$this->{$this->c_method}();
		}
		
		/* Throwing the result to Ajax */
		if (! $result)
			xresponse(FALSE, ['message' => $this->messages()], 401);

		if ($this->r_method == 'POST')
			xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
		else
			xresponse(TRUE, ['message' => $this->messages()]);
	}
	
	function _record_permutation_delete()
	{
		/* For reverse value "is_deleted", if param "xdel" exists & user_id = 11 */
		$this->delete_log['is_deleted'] = isset($this->params['xdel']) && ($this->params['xdel'] == 1) && ($this->session->user_id == 11) ? 0 : 1;
		
		/* Trigger events before delete */
		$this->params['event'] = 'pre_delete';
		$this->{$this->c_method}();
		
		$result = $this->_recordDelete($this->c_table, $this->params['id']);
		
		/* Trigger events after delete */
		$this->params['event'] = 'post_delete';
		$this->{$this->c_method}();
		
		if (!$result)
			xresponse(FALSE, ['message' => $this->messages()], 401);
		else
			xresponse(TRUE, ['message' => $this->messages()]);
	}
	
	function _recordInsert($table, $data, $fixed_data = FALSE, $log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $fixed_data ? array_merge($data, $this->fixed_data) : $data;
		$data = $log ? array_merge($data, $this->create_log) : $data;

		if (key_exists('id', $data)) 
			unset($data['id']);

		if ($this->identity_keys){
			$val = [];
			foreach($this->identity_keys as $k => $v){
				if (isset($data[$v])){
					$val[$v] = $data[$v];
				}
			}
			
			if (count($val) > 0) {
				if (! $fk = $this->db->get_where($table, array_merge($val, ['is_deleted' => '0']), 1)) {
					$this->set_message($this->db->error()['message']);
					return FALSE;
				}
				// debug($this->db->last_query());
				if ($fk->num_rows() > 0){
					// $this->set_message('error_identity_keys', __FUNCTION__, $val);
					$this->set_message('error_identity_keys');
					return false;
				}
			}
		}

		if (!$return = $this->db->insert($table, $data)) {
			// debug($return);
			// debug($this->db->error()['message']);
			$this->set_message($this->db->error()['message']);
			return false;
		} else {
			$id = $this->db->insert_id();
			// debug($this->db->last_query());
			// debug($return);
			$this->set_message('success_saving');
			return $id;
		}
	}
	
	function _recordUpdate($table, $data, $cond, $log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $log ? array_merge($data, $this->update_log) : $data;
		
		$cond = is_object($cond) ? (array) $cond : $cond;

		if (isset($data['id'])) 
			unset($data['id']);
		
		if (!$return = $this->db->update($table, $data, $cond)) {
			$this->set_message($this->db->error()['message']);
			return false;
		} else {
			$this->set_message('success_update');
			return true;
		}
		
		/* $this->db->update($table, $data, $cond);
		$return = $this->db->affected_rows() == 1;
		if ($return)
			// $this->set_message('update_data_successful');
			$this->set_message('success_update');
		else
			$this->set_message('update_data_unsuccessful');
		
		return true; */
	}
	
	function _recordDelete($table, $ids, $real = FALSE)
	{
		$ids = array_filter(array_map('trim',explode(',',$ids)));
		$return = 0;
		foreach($ids as $v)
		{
			if ($real) {
				if ($this->db->delete($table, ['user_id'=>$v]))
				{
					$return += 1;
				}
			} else {
				if ($this->db->update($table, $this->delete_log, ['id'=>$v]))
				{
					$return += 1;
				}
			}
		}
		if ($return)
			$this->set_message('success_delete');
		else
			$this->set_message($this->db->error()['message']); 
			
		return $return;
	}
	
	function _get_filtered($client = TRUE, $org = TRUE, $qField = [], $qReplaceField = FALSE)
	{
		if (isset($this->params['id']) && !empty($this->params['id'])) 
			$this->params['where']['t1.id'] = $this->params['id'];
		
		if (isset($this->params['q']) && !empty($this->params['q'])) {
			$defaultField = $qReplaceField ? [] : ['t1.code', 't1.name', 't1.description'];
			$qField = implode(',', array_merge($defaultField, $qField));
			if ($qField)
				$this->params['like'] = DBX::like_or($qField, $this->params['q']);
		}
		
		if ($client)
			$this->params['where']['t1.client_id'] = $this->session->client_id;

		if ($org)
			$this->params['where']['t1.org_id'] = $this->session->org_id;
	}
	
	function _remove_empty($array) {
		return array_filter($array, function($value){
			return !empty($value) || $value === 0;
		});
	}

	function _get_table_id()
	{
		$table_id = $this->base_model->getValue('id', 'a_table', 'name', $this->c_table)->id;
		return $table_id ? $table_id : 0;
	}
	
	/* 
	* 	$key_id		integer; 
	* 	$type			integer; 		Ex.: 1=created, 2=updated, 3=comment, 4=deleted
	* 	$description		text; 
	*/
	function _crudlog($key_id, $type = 0, $description = NULL)
	{
		$data['client_id'] = DEFAULT_CLIENT_ID;
		$data['org_id'] =  $this->session->org_id;
		$data['table_id'] = $this->_get_table_id();
		$data['user_id'] = $this->session->user_id;
		
		$data['key_id'] = $key_id;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['type'] = $type;
		// $data['title'] = $table_id;
		$data['description'] = $description;

		$log_id = 0;
		if (in_array($type, [1, 3])){
			$this->db->insert('a_history_log', $data);
			$log_id = $this->db->insert_id();
		} else {
			$new = $this->mixed_data;
			unset($new['id'], $new['description'], $new['updated_at'], $new['updated_by']);
			$old = $this->base_model->getValueArray(implode(',', array_keys($new)), $this->c_table, 'id', $key_id);
			
			foreach($new as $k => $v) {
				if ($old[$k] != $v){
					if ($log_id){
						$line['history_log_id'] = $log_id;
						$line['changed_field'] = $k;
						$line['old_value'] = $old[$k];
						$line['new_value'] = $v;
						$this->db->insert('a_history_log_line', $line);
					} else {
						$this->db->insert('a_history_log', $data);
						$log_id = $this->db->insert_id();
						
						$line['history_log_id'] = $log_id;
						$line['changed_field'] = $k;
						$line['old_value'] = $old[$k];
						$line['new_value'] = $v;
						$this->db->insert('a_history_log_line', $line);
					}
				}
			}
		}
	}
	
	function _upload_file()
	{
		/* get the params & files (special for upload file) */
		$files = $_FILES;
		
		$this->max_file_upload = isset($this->session->max_file_upload) ? $this->session->max_file_upload : $this->max_file_upload;
		
		@ini_set( 'upload_max_size' , $this->max_file_upload );
		@ini_set( 'post_max_size', $this->max_file_upload );
		@ini_set( 'max_execution_time', '300' );
		
		if (isset($files['file']['name']) && $files['file']['name']) {
			/* Load the library */
			require_once APPPATH."/third_party/Plupload/PluploadHandler.php"; 
			$ph = new PluploadHandler(array(
				'target_dir' => $this->tmp_dir,
				'allow_extensions' => $this->allow_ext,
				'debug' => false,
			));
			$ph->sendNoCacheHeaders();
			$ph->sendCORSHeaders();
			/* And Do Upload */
			if (!$result = $ph->handleUpload()) {
				// $this->set_message($ph->getErrorMessage());
				// return FALSE;
				xresponse(FALSE, ['message' => $ph->getErrorMessage()], 401);
			}
			/* Result Output in array : array('name', 'path', 'chunk', 'size') */
			// return $result;
			
			/* For checking is any file chunking or not in plupload plugins */
			if (isset($this->params->chunks)) {
				if (!$this->params->chunks || $this->params->chunk == $this->params->chunks - 1)
					return $result;
				else
					xresponse(TRUE, $result);
			} else {
				return $result;
			}
		}
	}
	
	function _pre_export_data($return = FALSE)
	{
		$filetype = $this->params['filetype'];
		$filename = $this->c_method.'_'.date('YmdHi').'.'.$filetype;
		$is_compress = $this->params['is_compress'];
		/* Parsing pageid, if on sub module */
		$this->pageid = explode(',', $this->params['pageid']);
		$this->pageid = end($this->pageid);
		
		/* Used existing queries in model */
		if (! $result = $this->{$this->mdl}->{$this->c_method}($this->params)){
			$result['data'] = [];
			$result['message'] = $this->base_model->errors();
			xresponse(FALSE, $result);
		}

		if ($return)
			return $result;
		
		/* Defined exclude fields/cols */
		$excl_cols = isset($this->params['excl_cols']) ? $this->params['excl_cols'] : $this->protected_fields;
		/* Export the data */
		if (! $result = $this->_export_data($result, $excl_cols, $filename, $filetype, TRUE))
			xresponse(FALSE, ['message' => 'export_data_failed']);
		
		/* Compress the file */
		if ($is_compress) 
			if(! $result = $this->_compress_file($result['filepath']))
				xresponse(FALSE, ['message' => 'compress_file_failed']);
			
		xresponse(TRUE, $result);
	}
	
	function _export_data($qry, $excl_cols=[], $filename, $filetype, $return = FALSE)
	{
		ini_set('memory_limit', '-1');
		$this->load->library('z_libs/Excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
		$objPHPExcel->setActiveSheetIndex(0);

		// Set the Title in the first row
		$current = 'A';
		$col = 0;
		$fields = [];
		if ($excl_cols) {
			foreach ($qry->list_fields() as $field) {
				if (!in_array($field,$excl_cols)){
					$columns[] = ($col == 0) ? $current : ++$current;
					$fields[] = $field;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
					$col++;
				}
			}
		} else {
			foreach ($qry->list_fields() as $field) {
				$columns[] = ($col == 0) ? $current : ++$current;
				$fields[] = $field;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
				$col++;
			}
		}
		// debug($fields);
		// Set the Data in the next row
		$row = 2;
		foreach($qry->result() as $data) {
			$col = 0;
			// foreach ($qry->list_fields() as $field) {
			foreach ($fields as $field) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->{$field});
				$col++;
			}
			$row++;
		}
		
		// Set the Column to Fit AutoSize
		foreach($columns as $column) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		
		if (in_array($filetype, ['xls', 'xlsx'])) {
			if ($return){
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}

			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save('php://output');
		}
		if ($filetype == 'csv'){
			PHPExcel_Shared_String::setDecimalSeparator('.');
			PHPExcel_Shared_String::setThousandsSeparator(',');

			if ($return){
				$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			
			$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
			$objWriter->save('php://output');
			
		}
		if ($filetype == 'pdf'){
			$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
			$rendererLibraryPath = FCPATH.'../vendor/mpdf/mpdf/src/';
			if (!PHPExcel_Settings::setPdfRenderer($rendererName,	$rendererLibraryPath)) {
					die(
							'Please set the $rendererName and $rendererLibraryPath values' .
							PHP_EOL .
							' as appropriate for your directory structure'
					);
			}
			if ($return){
				$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
			$objWriter->save('php://output');
		}
		if ($filetype == 'html'){
			if ($return){
				$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			
			$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
			$objWriter->save('php://output');
		}
		exit;
	}
	
	function _export_data_array($rows, $excl_cols=[], $filename, $filetype, $return = FALSE)
	{
		ini_set('memory_limit', '-1');
		$this->load->library('z_libs/Excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Set the Title in the first row
		$current = 'A';
		$col = 0;
		$fields = [];
		if ($excl_cols) {
			foreach ($rows[0] as $field => $val) {
				if (!in_array($field,$excl_cols)){
					$columns[] = ($col == 0) ? $current : ++$current;
					$fields[] = $field;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
					$col++;
				}
			}
		} else {
			foreach ($rows[0] as $field => $val) {
				$columns[] = ($col == 0) ? $current : ++$current;
				$fields[] = $field;
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
				$col++;
			}
		}
		
		// Set the Data in the next row
		$row = 2;
		foreach($rows as $data) {
			$col = 0;
			foreach ($fields as $field) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->{$field});
				$col++;
			}
			$row++;
		}
		
		// Set the Column to Fit AutoSize
		foreach($columns as $column) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		
		if (in_array($filetype, ['xls', 'xlsx'])) {
			if ($return){
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}

			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save('php://output');
		}
		if ($filetype == 'csv'){
			PHPExcel_Shared_String::setDecimalSeparator('.');
			PHPExcel_Shared_String::setThousandsSeparator(',');

			if ($return){
				$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			
			$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
			$objWriter->save('php://output');
			
		}
		if ($filetype == 'pdf'){
			$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
			$rendererLibraryPath = FCPATH.'../vendor/mpdf/mpdf/src/';
			if (!PHPExcel_Settings::setPdfRenderer($rendererName,	$rendererLibraryPath)) {
					die(
							'Please set the $rendererName and $rendererLibraryPath values' .
							PHP_EOL .
							' as appropriate for your directory structure'
					);
			}
			if ($return){
				$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
			$objWriter->save('php://output');
		}
		if ($filetype == 'html'){
			if ($return){
				$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				return ['filename' => $filename, 'filepath' => $this->tmp_dir.$filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			
			$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
			$objWriter->save('php://output');
		}
		exit;
	}
	
	function _compress_file($file)
	{
		$zip = new ZipArchive();
		$pathinfo = pathinfo($file);
		$dir = $pathinfo['dirname'];
		$fil = $pathinfo['filename'];
		$fbn = $pathinfo['basename'];
		$ext = strtolower($pathinfo['extension']);
		$filezip = $fil.'.zip';
		$fil_tmp = $dir.'/'.$filezip;
		if ($zip->open($fil_tmp, ZipArchive::CREATE)!==TRUE) {
			exit("cannot open <$fil_tmp>\n");
		}
		$zip->addFile($file,$fbn);
		$zip->close();
		/* remove master file */
		@unlink($file);
		return ['filename' => $filezip, 'filepath' => $this->rel_tmp_dir.$filezip, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filezip];
	}
	
	function _reorder_menu($parent_id = NULL)
	{
		if (empty($parent_id)) {
			$str = "select * from a_menu where is_deleted = '0' and (parent_id = 0 or parent_id is null) order by parent_id, line_no, is_needsort desc, is_submodule";
		} else {
			$str = "select * from a_menu where is_deleted = '0' and parent_id = $parent_id order by is_parent desc, line_no, is_needsort desc, is_submodule";
		}
		// debug($str);
		$qry = $this->db->query($str);
		$line = 1;
		foreach($qry->result() as $k => $v){
			$this->db->update('a_menu', ['line_no' => $line, 'is_needsort' => 0], ['id' => $v->id]);
			$line++;
		}
	}
	
	function _reorder_dashboard($role_id)
	{
		$str = "select t1.* from a_role_dashboard t1 left join a_dashboard t2 on t1.dashboard_id = t2.id where t1.is_deleted = '0' and role_id = $role_id order by t2.type, t1.seq";
		$qry = $this->db->query($str);
		$line = 1;
		foreach($qry->result() as $k => $v){
			$this->db->update('a_role_dashboard', ['seq' => $line], ['id' => $v->id]);
			$line++;
		}
	}
	
	/* 
	*
	*	$param1 : table name
	*	$param2 : condition ex. ['role_id' => 11]
	*
	*/
	function _reorder_line($table, $cond = [])
	{
		$this->db->order_by('seq');
		if (! $qry = $this->db->get_where($table, $cond))
			return FALSE;
		
		// debug($qry->result());
		$line = 1;
		foreach($qry->result() as $k => $v){
			$this->db->update($table, ['seq' => $line], ['id' => $v->id]);
			$line++;
		}
	}
	/*  
	*		$data = [
	*			'name'				=>	'Process Name',
	*			'percent'			=>	10,				// 1-100
	*			'finished_at'	=>	date('Y-m-d H:i:s'),
	*			'start_time'	=>	time(),
	*			'stop_time'		=>	time(),
	*			'log'					=>	'',
	*			'message'			=>	'',				
	*			'status'			=>	'TRUE', 	// TRUE/FALSE
	*		];
	*/
	function _update_process($data=[], $id=NULL)
	{
		if ($id){
			$this->db->set('log', "log || E'\r\n' || '".$data['log']."'", FALSE);
			unset($data['log']);
			if (isset($data['finished_at'])){
				$this->db->set('duration', "finished_at - created_at", FALSE);
			}
			if (isset($data['stop_time']) && !empty($data['stop_time'])){
				$this->db->set('duration_time', "stop_time - start_time", FALSE);
			}
			if (!$return = $this->db->update('a_tmp_process', $data, ['id'=>$id])) {
				// xresponse(FALSE, ['message' => $this->db->error()['message']], 401);
				return FALSE;
			} 
		} else {
			if (!$return = $this->db->insert('a_tmp_process', array_merge($data, $this->create_log))) {
				// xresponse(FALSE, ['message' => $this->db->error()['message']], 401);
				return FALSE;
			} 
		}

		return ($id) ? $id : $this->db->insert_id();
		// $id_process = $this->db->insert_id();
		// xresponse(TRUE, ['id_process' => $id_process], 200, FALSE);
	}
	
	function _import_data()
	{
		if (isset($this->params->step) && $this->params->step == '1') {
			/* Received the file to be import */
			$result = $this->_upload_file();
			
			/* Check file type */
			$this->load->library('z_libs/Excel');
			/**  Identify the type of $inputFileName  **/
			$inputFileType = PHPExcel_IOFactory::identify($result["path"]);
			/**  Create a new Reader of the type that has been identified  **/
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			/**  Load $inputFileName to a PHPExcel Object  **/
			$objPHPExcel = $objReader->load($result["path"]);
			/**  Convert object to array and populate to variable  **/
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			if (!$tmp_table = $this->session->tmp_table) {
				/* Create random filename for tmp_table */
				$this->load->helper('string');
				$tmp_table = "z_".random_string('alnum', 5);
				$this->session->set_userdata(['tmp_table' => $tmp_table]);
			} 
			
			/* Drop table if exists  */
			$this->load->dbforge();
			$this->dbforge->drop_table($tmp_table,TRUE);
			
			/* Process for parsing data_sheet (csv & xls) file */
			foreach($sheetData as $key => $values){
				if ($key == 1){
					/* Row #1, for header/title */
					$fields['tmp_id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
					foreach($values as $k => $v){
						$fn = !empty($v) && $v && $v != '' ? $v : $k;
						$title[$k] = $fn;
						$fields[$fn] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE];
					}
					$fields['status'] = ['type' => 'text', 'null' => TRUE];
					$this->dbforge->add_field($fields);
					if (! $result = $this->dbforge->create_table($tmp_table)){
						// $this->set_message('no_header_fields');
						// return FALSE;
						xresponse(FALSE, ['message' => lang('error_import_no_header')], 401);
					}
					// debug($fields);
				} else {
					/* Next, Row #2 until end is value */
					foreach($values as $k => $v){
						$val[$title[$k]] = !empty($v) && $v && $v != '' ? $v : NULL;
						$val[$title[$k]] = $val[$title[$k]] == 'Y' ? '1' : $val[$title[$k]] == 'N' ? '0' : $val[$title[$k]];
					}
					$this->db->insert($tmp_table, $val);
				}
			}
			/* Adding table name & creation date to a_tmp_tables */
			$this->db->delete('a_tmp_tables', ['name' => $tmp_table]);
			$this->db->insert('a_tmp_tables', ['name' => $tmp_table, 'created_at' => date('Y-m-d H:i:s'), 'time' => time()]);
			/* Getting fields from tmp_table */
			$tmp_fields = $this->db->list_fields($tmp_table);
			$tmp_fields = array_diff($tmp_fields, ['tmp_id', 'status']);
			// return ['tmp_fields' => array_values($tmp_fields), 'table_fields' => $this->imported_fields];
			xresponse(TRUE, ['message' => 'Uploading the file is succeeded !', 'tmp_fields' => array_values($tmp_fields), 'table_fields' => $this->imported_fields]);
		}
		
		if (isset($this->params->step) && $this->params->step == '2') {
			/* Create process id on table a_tmp_process, and throw response "id_process" to client */
			$data = [
				'name' => sprintf('Importing table [%s]', $this->c_table),
				'percent' => 0,
				'start_time' => time(),
				'message' => 'Importing process...',
				'log' => 'Initialization',
				'status' => 'TRUE',
			];
			$id_process = $this->_update_process($data);
			$this->session->set_userdata('id_process', $id_process);
			// xresponse(TRUE, ['id_process' => $id_process], 200, FALSE);
			 
			/* fields syncronization with target table */
			$tmp_fields = $this->db->list_fields($this->session->tmp_table);
			/* flip it, so it can be compare */
			$tmp_flip = array_flip($tmp_fields);
			$params_flip = array_flip($this->params->fields);
			/* Compare result to imported_fields, only grab which exist in the imported_fields */
			$tmp_fields = array_flip(array_intersect_key($tmp_flip, $params_flip));
			/* Adding default fields */
			$tmp_fields[] = 'tmp_id';
			$tmp_fields[] = 'status';
			
			/* For import type [insert], adding column id_new */
			if ($this->params->importtype == 'insert') {
				/* Adding column [id] */
				$this->load->dbforge();
				$fields['id_new'] = ['type' => 'INT', 'constraint' => 9];
				$this->dbforge->add_column($this->session->tmp_table, $fields);
				/* Adding [id_new] to tmp_fields */
				$tmp_fields[] = 'id_new';
			}
			
			foreach($tmp_fields as $k => $v){
				if (isset($params_flip[$v]))
					$tmp_fields[$k] = $v . ' as ' . $params_flip[$v];
			}

			/* Select fields with new alias */
			$this->db->select($tmp_fields);
			$qry = $this->db->get($this->session->tmp_table);
			if($ttl_rows = $qry->num_rows() > 0){
				
				/* ============================ Parameters for progress status */
				$rows = 0;
				$ttl_rows = $qry->num_rows();
				$step = intval($ttl_rows * 0.1);
				$progress = $step;
				
				foreach($qry->result_array() as $key => $values){
					$tmp_id = ['tmp_id' => $values['tmp_id']];
					unset($values['tmp_id'], $values['status'], $values['id'], $values['id_new']);
					
					/* ============================ Update progress status */
					$rows++;
					if ($rows == $progress){
						$percent = intval($rows/$ttl_rows*100);
						$this->_update_process(['percent' => $percent, 'message' => sprintf('%s row(s) processed.', $rows), 'log' => sprintf('Importing Process...[%s percent - %s row(s) of %s]', $percent, $rows, $ttl_rows), 'status' => 'TRUE'], $id_process);
						$progress += $step;
					} else if ($rows == $ttl_rows){
						$percent = intval($rows/$ttl_rows*100);
						$this->_update_process(['percent' => $percent, 'message' => sprintf('%s row(s) processed.', $rows), 'log' => sprintf('Importing Process...[%s percent - %s row(s) of %s]', $percent, $rows, $ttl_rows), 'status' => 'TRUE'], $id_process);
					}
					
					/* ============================ Validation Date/Time Format */
					/* Retrieve field date from current table */
					$fields = $this->db->field_data($this->c_table);
					foreach($fields as $field) {
						if ($field->type == 'date')
							$date_fields[] = $field->name;
					}	
					/* Compare result to imported_fields, only grab which exist in the imported_fields */
					$date_fields = array_intersect($date_fields, $this->imported_fields);
					/* If exists field date */
					if (isset($date_fields)) {
						$is_valid_date = true;
						foreach($date_fields as $field){
							/* If Field Date is not NULL */
							if ($values[$field]){
								/* Convert Date/Time to Database date format [yyyy-mm-dd] */
								if ($this->params->date_format != 'yyyy-mm-dd') {
									if ($return = datetime_db_format($values[$field], $this->params->date_format, FALSE) == FALSE){
										$this->db->update($this->session->tmp_table, ['status' => sprintf("Error: Unsupported Date Format, Column [%s].", $field)], $tmp_id);
										$this->db->flush_cache();
										$is_valid_date = false;
									} 
								} else {
									$return = $values[$field];
								}
								/* Double check date with php native */
								$dateTime = DateTime::createFromFormat('Y-m-d', $return);
								$errors = DateTime::getLastErrors();
								if (!$dateTime || !empty($errors['warning_count'])) {
									$this->db->update($this->session->tmp_table, ['status' => sprintf("Error: Date Format, Column [%s].", $field)], $tmp_id);
									$this->db->flush_cache();
									$is_valid_date = false;
								}
							} else {
								$values[$field] = NULL;
							}
						}
						if (!$is_valid_date) 
							continue;
					}
					
					/* ============================ Validation Foreign Key */
					if ($this->validation_fk){
						$is_valid = true;
						foreach($this->validation_fk as $k => $v) {
							if ($result = $this->db->where('id', $values[$k])->get($v)) {
								if ($result->num_rows() < 1) {
									$this->db->update($this->session->tmp_table, ['status' => sprintf("Error: FK, [%s] doesn't exists !", $k)], $tmp_id);
									$this->db->flush_cache();
									$is_valid = false;
								}
							} else {
								$this->db->update($this->session->tmp_table, ['status' => sprintf("Error: FK, [%s] doesn't exists !", $k)], $tmp_id);
								$this->db->flush_cache();
								$is_valid = false;
							}
						}
						if (!$is_valid) 
							continue;
					}
						
					/* ============================ Insert cluster ============================ */
					if ($this->params->importtype == 'insert') {
						
						/* Validation Identity Key */
						if ($this->identity_keys){
							/* Build filter with identity field */
							foreach($this->identity_keys as $field) {	$identity[$field] = $values[$field]; }
							$filter['is_deleted'] = '0';
							if ($this->db->where( array_merge($filter, $identity) )->get($this->c_table)->num_rows() > 0) {
								// $this->db->update($this->session->tmp_table, ['status' => sprintf("[%s] is already exists !", urldecode(http_build_query($identity,'',', ')))], $tmp_id);
								$this->db->update($this->session->tmp_table, ['status' => sprintf("Error: [%s] already exists !", implode(', ', array_keys($identity)))], $tmp_id);
								$this->db->flush_cache();
								continue;
							}
						}
						
						/* Start the Insert Process */
						if (!$result = $this->_recordInsert($this->c_table, $values, TRUE, TRUE)) {
							$this->db->update($this->session->tmp_table, ['status' => $this->messages(FALSE)], $tmp_id);
						}
						
						$this->db->update($this->session->tmp_table, ['status' => 'OK', 'id_new' => $result], $tmp_id);
						$this->db->flush_cache();
					} 
					
					/* ============================ Update cluster ============================ */
					if ($this->params->importtype == 'update') {
						
						/* Validation Identity Key */
						if ($this->identity_keys){
							/* Build filter with identity field */
							foreach($this->identity_keys as $field) {	$identity[$field] = $values[$field]; }
							$filter['is_deleted'] = '0';
							if ($this->db->where( array_merge($filter, $identity) )->get($this->c_table)->num_rows() < 1) {
								// $this->db->update($this->session->tmp_table, ['status' => sprintf("[%s] doesn't exists !", urldecode(http_build_query($identity,'',', ')))], $tmp_id);
								$this->db->update($this->session->tmp_table, ['status' => sprintf("Error: [%s] doesn't exists !", implode(', ', array_keys($identity)))], $tmp_id);
								$this->db->flush_cache();
								continue;
							}
						}
						
						/* Start the Update Process */
						if (!$result = $this->_recordUpdate($this->c_table, $values, array_merge($filter, $identity), TRUE)) {
							$this->db->update($this->session->tmp_table, ['status' => $this->messages(FALSE)], $tmp_id);
						}
						
						$this->db->update($this->session->tmp_table, ['status' => 'OK'], $tmp_id);
						$this->db->flush_cache();
					}
				}
				
				/* ============================ Update progress status */
				$this->_update_process(['message' => 'Exporting result data...', 'log' => 'Exporting result data...', 'status' => 'TRUE'], $id_process);
				
				/* Export the result to client */
				$filename = 'result_'.$this->c_table.'_'.date('YmdHi').'.'.$this->params->filetype;
				$fields = $this->db->list_fields($this->session->tmp_table);
				// $fields = array_diff($fields, ['tmp_id']);
				$this->db->select($fields);
				$qry = $this->db->get($this->session->tmp_table);
				if (! $result = $this->_export_data($qry, [], $filename, $this->params->filetype, TRUE)) {
					$this->_update_process(['message' => 'Error: Exporting result data.', 'log' => 'Error: Exporting result data.', 'status' => 'FALSE', 'finished_at' => date('Y-m-d H:i:s'), 'stop_time' => time()], $id_process);
					xresponse(FALSE, ['message' => lang('error_import_download_result')], 401);
				}
				
				/* Update status on process table */
				$this->_update_process(['message' => lang('success_import_data'), 'log' => lang('success_import_data'), 'status' => 'TRUE', 'finished_at' => date('Y-m-d H:i:s'), 'stop_time' => time()], $id_process);
				/* Unset id_process, so can't be called again from client  */
				$this->session->unset_userdata('id_process');
				
				$result['message'] = lang('success_import_data');
				xresponse(TRUE, $result);
			}
		}
	}
	
	function set_message($message, $func=NULL, $args=NULL)
	{
		$msg = lang($message, '', 'systems') ? lang($message, '', 'systems'): '##' . $message . '##';
		
		if (!empty($args)){
			$args = is_array($args) ? 
				str_replace('+', ' ', http_build_query($args,'',', ')) : 
				$args;
			$args = sprintf('Context : <br> function %s(), [%s]', $func, $args);
			$msg = sprintf('%s<br><br>%s', $msg, $args);
		}
		$this->messages[] = $msg;
		return $message;
		
		/* $msg = lang($message, $args, 'systems') ? lang($message) : '##' . $message . '##';
		
		if (!empty($args)){
			$args = is_array($args) ? 
				str_replace('+', ' ', http_build_query($args,'',', ')) : 
				$args;
			$args = sprintf('Context : <br> function %s(), [%s]', $func, $args);
			$msg = sprintf('%s<br><br>%s', $msg, $args);
		}
		$this->messages[] = $msg;
		return $message; */
	}

	function messages($use_p = TRUE)
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			if ($use_p)
				$_output .= '<p>' . $message . '</p>';
			else
				$_output .= $message.' ';
		}
		$this->messages = [];
		return $_output;
	}

	/**
	 * li
	 *
	 * Function for left menu on backend <li></li>
	 *
	 * @param	string	$cur_page   Current page
	 * @param	string	$page_chk   Page check
	 * @param	string	$url   Url
	 * @param	string	$menu_name   Menu label
	 * @param	string	$icon   bootstrap glyphicon class
	 * @param	string	$submenu   Submenu (TRUE or FALSE)
	 * @return  string
	 */
	private function _getmenu_li($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="active"' : '';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="fa fa-circle"></i>';
		
		$html = '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span></a></li>';
		return $html;
	}
	
	function _getmenu_recursively($categories, $parent = null, $menu_active = array())
	{
    $ret = '';
    foreach($categories as $index => $category)
    {
			if($category['parent_id'] == $parent)
			{
				$url = base_url().'systems/x_page?pageid='.$category['id'];
				$active = in_array($category['id'], $menu_active) ? 'active' : '';
				if ($category['is_parent'] == '1'){
					$glyp_icon = ($category['icon']) ? '<i class="'.$category['icon'].'"></i> ' : '<i class="glyphicon glyphicon-menu-hamburger"></i>';
					$ret .= '<li class="treeview '.$active.'"><a href="'.$url.'">'.$glyp_icon.'<span>'.$category['name'].'</span><i class="fa fa-angle-left pull-right"></i></a>';
					$ret .= '<ul class="treeview-menu">'.$this->_getmenu_recursively($categories, $category['id'], $menu_active).'</ul>';
					$ret .= '</li>';
				} else {
					$glyp_icon = ($category['icon']) ? '<i class="'.$category['icon'].'"></i> ' : '<i class="fa fa-circle"></i>';
					$ret .= '<li class="treeview '.$active.'"><a href="'.$url.'">'.$glyp_icon.'<span>'.$category['name'].'</span></a>';
					$ret .= $this->_getmenu_recursively($categories, $category['id'], $menu_active);
					$ret .= '</li>';
				}
			}
    }
    return $ret;
	}
	
	function _getmenu_structure($cur_page)
	{
		$cur_page = $cur_page ? 'and id = '.$cur_page : '';
		$str = "WITH RECURSIVE menu_tree (id, parent_id, level, menu_active) 
			AS ( 
				SELECT 
					id, parent_id, 0 as level, cast(id as text)
				FROM a_menu
				WHERE (parent_id is NULL or parent_id = 0) and is_deleted = '0' and is_active = '1' and is_submodule = '0' 
				UNION ALL
				SELECT 
					mn.id, mt.id, mt.level + 1, mt.menu_active || ',' || mn.id
				FROM a_menu mn, menu_tree mt 
				WHERE mn.parent_id = mt.id and is_deleted = '0' and is_active = '1' and is_submodule = '0' 
			) 
			SELECT * FROM menu_tree WHERE id != 1 $cur_page ORDER BY level, parent_id;";
		$qry = $this->db->query($str);
		$menu_active = $qry->row() ? explode(',', $qry->row()->menu_active) : [];
		// debugf(explode(',', $menu_active));		
		/* $str = "WITH RECURSIVE menu_tree (id, parent_id, level, childno, line_no, is_parent, name, name_tree, icon) 
			AS ( 
				SELECT 
					id, parent_id, 0 as level, (select count(distinct am.id) from a_menu as am where am.parent_id = a_menu.id) as childno, 1 as line_no, is_parent, name, '' || name, icon
				FROM a_menu
				WHERE (parent_id is NULL or parent_id = 0) and is_deleted = '0' and is_active = '1' and is_submodule = '0' and type != 'P'
				UNION ALL
				SELECT 
					mn.id, mt.id, mt.level + 1, (select count(distinct am.id) from a_menu as am where am.parent_id = mn.id) as childno, mn.line_no, mn.is_parent, mn.name, mt.name_tree || '->' || mn.name,mn.icon
				FROM a_menu mn, menu_tree mt 
				WHERE mn.parent_id = mt.id and is_deleted = '0' and is_active = '1' and is_submodule = '0' and type != 'P'
			) 
			SELECT * FROM menu_tree WHERE id != 1	ORDER BY level, parent_id, line_no;"; */
		$role_id = $this->session->role_id;
		$str = "WITH RECURSIVE menu_tree (id, parent_id, childno, line_no, is_parent, name, icon) 
			AS ( 
				SELECT
					id, parent_id, (select count(distinct am.id) from a_menu as am where am.parent_id = a_menu.id) as childno, line_no, is_parent, name, icon
				FROM a_menu
				WHERE is_deleted = '0' and is_active = '1' and is_submodule = '0' and exists(select menu_id from a_role_menu where role_id = $role_id and is_deleted = '0' and is_active = '1' and menu_id = a_menu.id)
				UNION ALL
				SELECT
					mn.id, mn.parent_id, (select count(distinct am.id) from a_menu as am where am.parent_id = mn.id) as childno, mn.line_no, mn.is_parent, mn.name, mn.icon
				FROM a_menu mn, (select distinct parent_id from menu_tree) mt 
				WHERE mn.id = mt.parent_id --and (mt.parent_id is NULL or mt.parent_id = 0) 
			) 
			SELECT distinct * FROM menu_tree 
			WHERE id != 1
			ORDER BY parent_id, line_no;";
		$qry = $this->db->query($str);
		$html = '';
		$html.= $this->_getmenu_li($cur_page, 1, 'systems/x_page?pageid=1', 'Dashboard', 'fa fa-dashboard');
		// debug($qry->result_array());
		$html.= $this->_getmenu_recursively($qry->result_array(), null, $menu_active);
		$html.= '<br><li><a href="#" id="go-lock-screen" onclick="lock_the_screen();"><i class="fa fa-circle-o text-yellow"></i> <span>' . lang('nav_lckscr') . '</span></a></li>';
		$html.= '<li><a href="'.LOGOUT_LNK.'" id="go-sign-out"><i class="fa fa-sign-out text-red"></i> <span>' . lang('nav_logout') . '</span></a></li>';
		return $html;
	}
	
	/* For getting org/company list base on user_org access */
	function _get_org($user_id = NULL)
	{
		$str = "select org_id from a_user_org where is_active = '1' and is_deleted = '0' and orgtype_id = 2 and user_id = ".($user_id !== NULL ? $user_id : $this->session->user_id);
		if (!$qry = $this->db->query($str)->result()){
			return FALSE;
		}
		$arr = [];
		foreach ($qry as $k => $v){
			$arr[] = $v->org_id;
		}
		return $arr;
	}
	
	/* For getting orgtrx/location list base on user_org access */
	function _get_orgtrx($parent_org_id = NULL)
	{
		$str = "select org_id from a_user_org where is_active = '1' and is_deleted = '0' and orgtype_id = 3 and user_id = ".$this->session->user_id." and parent_org_id = ".($parent_org_id !== NULL ? $parent_org_id : $this->session->org_id);
		// debug($str);
		if (!$qry = $this->db->query($str)->result()){
			return FALSE;
		}
		$arr = [];
		foreach ($qry as $k => $v){
			$arr[] = $v->org_id;
		}
		return $arr;
	}
	
	/* For getting orgdept/department list base on user_org access */
	function _get_orgdept($parent_org_id = NULL)
	{
		$str = "select org_id from a_user_org where is_active = '1' and is_deleted = '0' and orgtype_id = 4 and user_id = ".$this->session->user_id." and parent_org_id = ".($parent_org_id !== NULL ? $parent_org_id : $this->session->orgtrx_id);
		if (!$qry = $this->db->query($str)->result()){
			return FALSE;
		}
		$arr = [];
		foreach ($qry as $k => $v){
			$arr[] = $v->org_id;
		}
		return $arr;
	}
	
	/* For getting orgdiv/division list base on user_org access */
	function _get_orgdiv($parent_org_id = NULL)
	{
		$str = "select org_id from a_user_org where is_active = '1' and is_deleted = '0' and orgtype_id = 5 and user_id = ".$this->session->user_id." and parent_org_id = ".($parent_org_id !== NULL ? $parent_org_id : $this->session->orgdept_id);
		if (!$qry = $this->db->query($str)->result()){
			return FALSE;
		}
		$arr = [];
		foreach ($qry as $k => $v){
			$arr[] = $v->org_id;
		}
		return $arr;
	}
	
	/* For getting role list base on user_role access */
	function _get_role($user_id = NULL)
	{
		$str = "select role_id from a_user_role f1 where is_active = '1' and is_deleted = '0' and user_id = ". ($user_id !== NULL ? $user_id : $this->session->user_id);
		if (!$qry = $this->db->query($str)->result()){
			return FALSE;
		}
		$arr = [];
		foreach ($qry as $k => $v){
			$arr[] = $v->role_id;
		}
		return $arr;
	}
	
	function single_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$select = 'head_title, page_title, logo_text_mn, logo_text_lg';
		$system = ($result = $this->base_model->getValueArray($select, 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.$content, array_merge($default, $data, $system));
		exit;
	}
	
	function backend_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$default['content'] 	= TEMPLATE_PATH.$content.'.tpl';
		$default['menus'] 		= $this->_getmenu_structure($this->pageid ? $this->pageid : 0);
		
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $data));
		exit;
	}
	
}