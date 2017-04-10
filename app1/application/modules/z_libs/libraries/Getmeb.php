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
	/* FOR EXCEPTION METHOD */
	public $exception_method = [];
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	/* FOR DEFINED BOOLEAN FIELDS */
	public $boolfields = [];
	/* FOR DEFINED ALLOW NULL FIELDS */
	public $nullfields = [];
	/* FOR ADDITIONAL CRUD FIXED DATA */
	public $fixed_data = array();
	public $create_log = array();
	public $update_log = array();
	public $delete_log = array();
	
	/* FOR GETTING ERROR MESSAGE OR SUCCESS MESSAGE */
	public $messages = array();
	
	function __construct() {
		parent::__construct();
		$this->r_method = $_SERVER['REQUEST_METHOD'];
		$this->c_method = $this->uri->segment(2);
		
		/* Defined for template */
		define('ASSET_URL', base_url().'/assets/');
		define('TEMPLATE_URL', base_url().TEMPLATE_FOLDER.'/backend/'.$this->theme.'/');
		define('TEMPLATE_PATH', '/backend/'.$this->theme.'/');
		
		$this->lang->load('systems/systems', (!empty($this->session->language) ? $this->session->language : 'english'));
		
		$this->fixed_data = [
			'client_id'		=> DEFAULT_CLIENT_ID,
			'org_id'			=> DEFAULT_ORG_ID
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

		if (in_array($this->r_method, ['GET'])) {
			/* Become Array */
			$this->params = $this->input->get();
			/* Request for record info */
			if (isset($this->params['rec_info']) && !empty($this->params['rec_info'])) {
				$this->_get_change_log();
			}
		}
		
		if (in_array($this->r_method, ['POST','PUT','OPTIONS'])) {
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
		}
		
		if (in_array($this->r_method, ['DELETE'])) {
			/* Become Array */
			$this->params = $this->input->get();
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
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
		if (!$this->_check_path($data['path'].$data['table'])) {
			$this->set_message('ERROR: Menu [path] is could not be found or file not exist !');
			return FALSE;
		}
		
		if (key_exists('edit', $this->params) && !empty($this->params['edit'])) {
			if (!$this->_check_path($data['path'].$data['table'].'_edit')) {
				$this->set_message('ERROR: Page or File ['.$data['path'].$data['table'].'_edit'.'] is could not be found or file not exist !');
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
		/* This process is for bypass methods which do not need to login */
		if (count($this->exception_method) > 0){
			if (in_array($this->c_method, $this->exception_method)){
				return TRUE;
			}
		}
		
		/* Check the session data for user_id */
		if (!$this->session->userdata('user_id')) {
			/* set reference url to session */
			setURL_Index();
			/* forward to login page */
			// $this->x_login();
			redirect(LOGIN_LNK);
			exit();
		}
		return TRUE;
	}
	
	function _check_is_allow_new_but_inhold()
	{
		/* This process is for bypass methods which do not need to login */
		if (count($this->exception_method) > 0){
			if (in_array($this->c_method, $this->exception_method))
				return;
		}
		/* Only check this request method */
		if (!in_array($this->r_method, ['POST','PUT','DELETE'])){
			return;
		}
		
		$type 	 = $this->input->server('HTTP_TYPE');
		if (!in_array($type, ['F', 'P', 'W']))
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Menu Type is not exist !'], 401);

		if ($type == 'F')
			$this->_check_allow_form();
		
		if ($type == 'P')
			$this->_check_allow_process();
		
		if ($type == 'W')
			$this->_check_allow_window();
	}
	
	function _check_allow_form()
	{
		$table 	 = $this->base_model->getValue('id, name', 'a_form', 'table', $this->c_method);
		if (!$table){
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Table ['.$this->c_method.'] not found in [a_form] !'], 401);
		}
		$allow = $this->base_model->getValue('permit', 'a_role_form', ['role_id', 'form_id', 'is_active', 'is_deleted'], [$this->session->role_id, $table->id, '1', '0']);
		if ($allow === FALSE)
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$table->name.'] not found in [a_role_form] !'], 401);

		switch($allow->permit){
		case '1':
			/* Execute */
			if (!in_array($this->r_method, ['POST']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		default:
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$table->name.'] is not set !'], 401);
			break;
		}
	}
	
	function _check_allow_process()
	{
		$table = $this->base_model->getValue('id, name', 'a_process', 'table', $this->c_method);
		if (!$table){
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Table ['.$this->c_method.'] not found in [a_process] !'], 401);
		}
		$allow = $this->base_model->getValue('permit', 'a_role_process', ['role_id', 'process_id', 'is_active', 'is_deleted'], [$this->session->role_id, $table->id, '1', '0']);
		if ($allow === FALSE)
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$table->name.'] not found in [a_role_process] !'], 401);

		switch($allow->permit){
		case '1':
			/* Export */
			if (!in_array($this->r_method, ['POST']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		default:
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$table->name.'] is not set !'], 401);
			break;
		}
	}
	
	function _check_allow_window()
	{
		$table  = $this->base_model->getValue('id, name', 'a_window', 'table', $this->c_method);
		if (!$table){
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Table ['.$this->c_method.'] not found in [a_window] !'], 401);
		}
		$allow = $this->base_model->getValue('permit', 'a_role_window', ['role_id', 'window_id', 'is_active', 'is_deleted'], [$this->session->role_id, $table->id, '1', '0']);
		if ($allow === FALSE)
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$table->name.'] not found in [a_role_window] !'], 401);

		switch($allow->permit){
		case '1':
			/* Only Create */
			if (!in_array($this->r_method, ['POST']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		case '2':
			/* Only Edit */
			if (!in_array($this->r_method, ['PUT']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		case '3':
			/* Only Delete */
			if (!in_array($this->r_method, ['DELETE']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		case '4':
			/* Can Create & Edit */
			if (!in_array($this->r_method, ['POST','PUT']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		case '5':
			/* Can Create & Delete */
			if (!in_array($this->r_method, ['POST','DELETE']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		case '6':
			/* Can Edit & Delete */
			if (!in_array($this->r_method, ['PUT','DELETE']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		case '7':
			/* Can All */
			if (!in_array($this->r_method, ['POST','PUT','DELETE']))
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
			break;
		default:
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$table->name.'] is not set !'], 401);
			break;
		}
	}
	
	function _check_is_allow()
	{
		/* This process is for bypass methods which do not need to login */
		if (count($this->exception_method) > 0){
			if (in_array($this->c_method, $this->exception_method))
				return;
		}
		/* Only check this request method */
		if (!in_array($this->r_method, ['POST','PUT','DELETE'])){
			return;
		}
		
		$menu = $this->base_model->getValue('id, name, type', 'a_menu', 'table', $this->c_method);
		if (!$menu){
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Table ['.$this->c_method.'] not found in [a_menu] !'], 401);
		}
		$allow = $this->base_model->getValue('permit_form, permit_process, permit_window', 'a_role_menu', ['role_id', 'menu_id', 'is_active', 'is_deleted'], [$this->session->role_id, $menu->id, '1', '0']);
		if ($allow === FALSE)
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$menu->name.'] not found in [a_role_menu] !'], 401);

		if ($menu->type == 'F') {
			switch($allow->permit_form){
			case '1':
				/* Execute */
				if (!in_array($this->r_method, ['POST']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			default:
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$menu->name.'] is not set !'], 401);
				break;
			}
		}
		if ($menu->type == 'P') {
			switch($allow->permit_process){
			case '1':
				/* Export */
				if (!in_array($this->r_method, ['POST']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			default:
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$menu->name.'] is not set !'], 401);
				break;
			}
		}
		if ($menu->type == 'W') {
			switch($allow->permit_window){
			case '1':
				/* Only Create */
				if (!in_array($this->r_method, ['POST']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '2':
				/* Only Edit */
				if (!in_array($this->r_method, ['PUT']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '3':
				/* Only Delete */
				if (!in_array($this->r_method, ['DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '4':
				/* Can Create & Edit */
				if (!in_array($this->r_method, ['POST','PUT']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '5':
				/* Can Create & Delete */
				if (!in_array($this->r_method, ['POST','DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '6':
				/* Can Edit & Delete */
				if (!in_array($this->r_method, ['PUT','DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '7':
				/* Can All */
				if (!in_array($this->r_method, ['POST','PUT','DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			default:
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Menu ['.$menu->name.'] is not set !'], 401);
				break;
			}
		}
	}
	
	function _get_change_log()
	{
		$role = $this->base_model->getValue('*', 'a_role', 'id', $this->session->role_id);
		if (!$role->is_changelog)
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')]);
		
		$result = [];
		$result['table'] = $this->c_method;
		$result['id'] = $this->params['id'];
		if ($info = $this->base_model->getValue('created_by, created_at, updated_by, updated_at, deleted_by, deleted_at', $this->c_method, 'id', $this->params['id'])){
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
		$this->xresponse(TRUE, ['data' => $result]);
	}
	
	/**
	 * Prevent direct access to this controller via URL
	 *
	 * @access public
	 * @param  string $controller name
	 * @param  string $method name 
	 * @param  array|boolean  $exception_method Parameters that would normally get passed on to the method
	 * @return void
	 *
	**/  
	function _direct_access_this_controller_via_url($controller, $method, $exception_method = TRUE)
	{
		if ($exception_method === TRUE)
			return;
		
		$controller = mb_strtolower($controller);
		if ($controller === mb_strtolower($this->uri->segment(1))) {
			// if requested controller and this controller have the same name
			// show 404 error
			// show_404();
			if ($exception_method === FALSE)
				$this->backend_view('pages/404', ['message'=>'']);
			
			if (is_array($exception_method)){
				if (in_array($method, $exception_method))
					return;
			}
			$this->backend_view('pages/404', ['message'=>'']);
		} 
		return;
	}
	
	function _pre_update_records($return_data = FALSE)
	{
		$datas = [];
		$fields = $this->db->list_fields($this->c_method);
		foreach($fields as $f){
			if (key_exists($f, $this->params)){
				/* Check if any exists boolean fields */
				if (in_array($f, $this->boolfields)){
					$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
				} 
				/* Check if any exists allow null fields */
				elseif (in_array($f, $this->nullfields)){
					$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
				} else {
					$datas[$f] = $this->params->{$f};
				}
			}
		}
		if ($return_data) return $datas;
			
		if ($this->r_method == 'POST')
			$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
		else
			$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
		
		if (! $result)
			$this->xresponse(FALSE, ['message' => $this->messages()], 401);
		else
			$this->xresponse(TRUE, ['message' => $this->messages()]);
	}
	
	function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= '<p>' . $messageLang . '</p>';
		}

		return $_output;
	}

	function insertRecord($table, $data, $fixed_data = FALSE, $create_log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $fixed_data ? array_merge($data, $this->fixed_data) : $data;
		$data = $create_log ? array_merge($data, $this->create_log) : $data;

		if (key_exists('id', $data)) 
			unset($data['id']);

		// debug(var_dump($data));
		if (!$return = $this->db->insert($table, $data)) {
			$this->set_message($this->db->error()['message']);
			return false;
		} else {
			$this->set_message('success_saving');
			return true;
		}
	}
	
	function updateRecord($table, $data, $cond, $update_log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $update_log ? array_merge($data, $this->update_log) : $data;
		
		$cond = is_object($cond) ? (array) $cond : $cond;

		// if (!key_exists('id', $cond) && empty($cond['id'])) {
			// $this->set_message('update_data_unsuccessful');
			// return false;
		// }
		
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
	
	function deleteRecords($table, $ids, $real = FALSE)
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
	
	function xresponse($status=TRUE, $response=array(), $statusHeader=200)
	{
		$BM =& load_class('Benchmark', 'core');
		
		$statusHeader = empty($statusHeader) ? 200 : $statusHeader;
		if (! is_numeric($statusHeader))
			show_error('Status codes must be numeric', 500);
		
		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

		$output['status'] = $status;
		$output['execution_time'] = $elapsed;
		$output['environment'] = ENVIRONMENT;
		
		header("HTTP/1.0 $statusHeader");
		header('Content-Type: application/json');
		echo json_encode(array_merge($output, $response));
		exit();
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
	private function li($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="active"' : '';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="fa fa-circle"></i>';
		
		$html = '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span></a></li>';
		return $html;
	}
	
	private function li_parent($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="treeview active"' : ' class="treeview"';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="glyphicon glyphicon-menu-hamburger"></i>';
		
		$html= '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span><i class="fa fa-angle-left pull-right"></i></a>';
		$html.= '<ul class="treeview-menu">';
		return $html;
	}
	
	function getMenuStructure($cur_page)
	{
		/* Start Treeview Menu */
		$html = ''; $li1_closed = false; $li2_closed = false; $menu_id1 = 0; $menu_id2 = 0; $menu_id3 = 0; $parent_id = 0;
		$html.= $this->li($cur_page, 1, 'systems/x_page?pageid=1', 'Dashboard', 'fa fa-dashboard');
		$rowParentMenu = ($result = $this->systems_model->getParentMenu($cur_page)) ? $result[0] : (object)['lvl1_id'=>0, 'lvl2_id'=>0];
		$rowMenus = $this->systems_model->getMenuByRoleId($this->session->role_id);
		if ($rowMenus) {
			foreach ($rowMenus as $menu){
				if (($menu_id1 != $menu->menu_id1) && $li1_closed){
					$html.= '</ul></li>';
					$li1_closed = false;
				}
				if (($menu_id2 != $menu->menu_id2) && $li2_closed){
					$html.= '</ul></li>';
					$li2_closed = false;
				}
				if (!empty($menu->menu_id2) || !empty($menu->menu_id3)){
					if ($menu_id1 != $menu->menu_id1){
						$parent_id = $rowParentMenu->lvl2_id ? $rowParentMenu->lvl2_id : $rowParentMenu->lvl1_id;
						$html.= $this->li_parent($parent_id, $menu->menu_id1, 'systems/x_page?pageid='.$menu->menu_id1, $menu->name1, $menu->icon1);
						$li1_closed = true;
						$menu_id1 = $menu->menu_id1;
					}
					if (($menu_id2 != $menu->menu_id2) && !empty($menu->menu_id3)){
						$parent_id = $rowParentMenu->lvl1_id;
						$html.= $this->li_parent($parent_id, $menu->menu_id2, 'systems/x_page?pageid='.$menu->menu_id2, $menu->name2, $menu->icon2);
						$li2_closed = true;
						$menu_id2 = $menu->menu_id2;
						
					} elseif (($menu_id2 != $menu->menu_id2) && empty($menu->menu_id3)){
						$html.= $this->li($cur_page, $menu->menu_id2, 'systems/x_page?pageid='.$menu->menu_id2, $menu->name2, $menu->icon2);
						$menu_id2 = $menu->menu_id2;
					}
					if (!empty($menu->menu_id3)){
						$html.= $this->li($cur_page, $menu->menu_id3, 'systems/x_page?pageid='.$menu->menu_id3, $menu->name3, $menu->icon3);
					}
				} elseif (!empty($menu->menu_id1)){
					$html.= $this->li($cur_page, $menu->menu_id1, 'systems/x_page?pageid='.$menu->menu_id1, $menu->name1, $menu->icon1);
				}
			}
			if ($li1_closed)
				$html.= '</ul></li>';
		}
		/* End Treeview Menu */
		
		$html.= '<br><li><a href="#" id="go-lock-screen" onclick="lock_the_screen();"><i class="fa fa-circle-o text-yellow"></i> <span>' . $this->lang->line('nav_lckscr') . '</span></a></li>';
		$html.= '<li><a href="'.LOGOUT_LNK.'" id="go-sign-out"><i class="fa fa-sign-out text-red"></i> <span>' . $this->lang->line('nav_logout') . '</span></a></li>';
		return $html;
	}
	
	function single_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$select = 'head_title, page_title, logo_text_mn, logo_text_lg';
		$system = ($result = $this->base_model->getValueArray($select, 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.$content, array_merge($default, $system, $data));
		exit;
	}
	
	function backend_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$default['content'] 	= TEMPLATE_PATH.$content.'.tpl';
		
		$select = 'head_title, page_title, logo_text_mn, logo_text_lg, date_format, time_format, datetime_format, user_photo_path';
		// $system = ($result = $this->base_model->getValueArray($select, 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		$pageid = (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) ? $this->params['pageid'] : 0;
		$default['menus'] 		= $this->getMenuStructure($pageid);
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		// $this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $system, $data));
		$this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $data));
		exit;
	}
	
}