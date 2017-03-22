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
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	/* FOR STORE SESSION DATA */
	public $sess;
	/* FOR STORE SYSTEM SETTING */
	public $sysconfig;
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
		if (in_array($this->r_method, ['GET','DELETE']))
			$this->params = $this->input->get();
		if (in_array($this->r_method, ['POST','PUT']))
			$this->params = json_decode($this->input->raw_input_stream);
		define('ASSET_URL', base_url().'/assets/');
		define('TEMPLATE_URL', base_url().TEMPLATE_FOLDER.'/backend/'.$this->theme.'/');
		define('TEMPLATE_PATH', '/backend/'.$this->theme.'/');
		define('HOME_LINK', base_url().'systems');
		
		$this->sess = (object) $this->session->userdata();
		$this->lang->load('systems/systems', (!empty($this->sess->language) ? $this->sess->language : 'english'));
		
		$this->fixed_data = [
			'client_id'		=> DEFAULT_CLIENT_ID,
			'org_id'			=> DEFAULT_ORG_ID
		];
		$this->create_log = [
			'created_by'	=> (!empty($this->sess->user_id) ? $this->sess->user_id : '0'),
			'created_at'	=> date('Y-m-d H:i:s')
		];
		$this->update_log = [
			'updated_by'	=> (!empty($this->sess->user_id) ? $this->sess->user_id : '0'),
			'updated_at'	=> date('Y-m-d H:i:s')
		];
		$this->delete_log = [
			'is_deleted'	=> 1,
			'deleted_by'	=> (!empty($this->sess->user_id) ? $this->sess->user_id : '0'),
			'deleted_at'	=> date('Y-m-d H:i:s')
		];
	}
	
	function _check_menu($data=[])
	{
		/* CHECK METHOD */
		if (empty($data['method'])) {
			$this->set_message('ERROR: Menu [method] is could not be empty !');
			return FALSE;
		}

		/* CHECK PATH FILE */
		if (!$this->_check_path($data['path'].$data['url'])) {
			$this->set_message('ERROR: Menu [path] is could not be found or file not exist !');
			return FALSE;
		}
		
		if (key_exists('edit', $this->params) && !empty($this->params['edit'])) {
			if (!$this->_check_path($data['path'].$data['url'].'_edit')) {
				$this->set_message('ERROR: Page or File ['.$data['path'].$data['url'].'_edit'.'] is could not be found or file not exist !');
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
		if (!$this->session->userdata('user_id')) {
			/* set reference url to session */
			setURL_Index();
			/* forward to login page */
			$this->x_login();
			exit();
		}
		return TRUE;
	}
	
	function _save_useragent_ip($account, $user_id = NULL)
	{
		$data['account'] = $account;
		$data['client_id'] = DEFAULT_CLIENT_ID;
		$data['org_id'] = DEFAULT_ORG_ID;
		$data['user_id'] = $user_id;
		$data['created_at'] = date('Y-m-d H:i:s');

		$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		if (!in_array($data['ip_address'], ['::1','127.0.0.1'])) {
			$this->load->library('z_libs/IPAPI');
			$query = IPAPI::query($data['ip_address']);
			$data['country'] = $query->country;
			$data['country_code'] = $query->countryCode;
			$data['region'] = $query->region;
			$data['region_name'] = $query->regionName;
			$data['city'] = $query->city;
			$data['zip'] = $query->zip;
			$data['lat'] = $query->lat;
			$data['lon'] = $query->lon;
			$data['timezone'] = $query->timezone;
			$data['isp'] = $query->isp;
			$data['org'] = $query->org;
			$data['as_number'] = $query->as;
		}
		$this->load->library('user_agent');
		$data['platform'] = $this->agent->platform();
		$data['is_mobile'] = $this->agent->is_mobile();
		$data['mobile'] = $this->agent->mobile();
		$data['is_robot'] = $this->agent->is_robot();
		$data['robot'] = $this->agent->robot();
		$data['is_browser'] = $this->agent->is_browser();
		$data['browser'] = $this->agent->browser();
		$data['browser_ver'] = $this->agent->version();
		$data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		
		$this->db->insert('a_loginlogs', $data);
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
			// echo $this->db->last_query();
			// return;
			$this->set_message($this->db->error()['message']);
			return false;
		}
		return true;
	}
	
	function updateRecord($table, $data, $cond, $update_log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $update_log ? array_merge($data, $this->update_log) : $data;
		
		if (!key_exists('id', $cond) && empty($cond['id'])) {
			$this->set_message('update_data_unsuccessful');
			return false;
		}
		
		if (!$return = $this->db->update($table, $data, $cond)) {
			$this->set_message($this->db->error()['message']);
			return false;
		}
		return true;
		
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
		$rowParentMenu = ($result = $this->system_model->getParentMenu($cur_page)) ? $result[0] : (object)['lvl1_id'=>0, 'lvl2_id'=>0];
		$rowMenus = $this->system_model->getMenuByRoleId($this->sess->role_id);
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
		/* End Treeview Menu */
		
		$html.= '<br><li><a href="#" id="go-lock-screen"><i class="fa fa-circle-o text-yellow"></i> <span>' . $this->lang->line('nav_lckscr') . '</span></a></li>';
		$html.= '<li><a href="'.base_url().LOGOUT_LNK.'"><i class="fa fa-sign-out text-red"></i> <span>' . $this->lang->line('nav_logout') . '</span></a></li>';
		return $html;
	}
	
	function login_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$select = 'head_title, page_title, logo_text_mn, logo_text_lg';
		$system = ($result = $this->base_model->getValueArray($select, 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.$content, array_merge($default, $system, $data));
	}
	
	function backend_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$default['content'] 	= TEMPLATE_PATH.$content.'.tpl';
		
		$select = 'head_title, page_title, logo_text_mn, logo_text_lg, date_format, time_format, datetime_format, user_photo_path';
		$system = ($result = $this->base_model->getValueArray($select, 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		$pageid = (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) ? $this->params['pageid'] : 0;
		$default['menus'] 		= $this->getMenuStructure($pageid);
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $system, $data));
	}
	
}