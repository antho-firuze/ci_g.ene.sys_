<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Systems_Model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	/* public function __call($method, $arguments)
	{
		if (!method_exists( $this, $method) )
		{
			throw new Exception('Undefined method ' . $method . '() called');
		}
		return call_user_func_array( array($this, $method), $arguments);
	} */
	
	function _save_useragent($account, $status = 'Login Success')
	{
		/* Check is account as user_name */
		$query = $this->db->get_where('a_user', ['name' => $account], 1);
		if ($query->num_rows() < 1) {
			/* Check is account as email */
			$query = $this->db->get_where('a_user', ['email' => $account], 1);
			$user_id = ($query->num_rows() === 1) ? $query->row()->id : NULL;
		} else {
			$user_id = ($query->num_rows() === 1) ? $query->row()->id : NULL;
		}
		/* saving user_agent & ip address */
		$data['account'] = $account;
		$data['client_id'] = DEFAULT_CLIENT_ID;
		$data['org_id'] = DEFAULT_ORG_ID;
		$data['user_id'] = $user_id;
		$data['created_at'] = date('Y-m-d H:i:s');
		$data['status'] = $status;

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
		
		if (!$this->db->insert('a_loginlogs', $data)){
			$this->session->set_flashdata('message', $this->db->error()['message']);
			return FALSE;
		}
		return TRUE;
	}
	
	function _store_config($user_id)
	{
		$user = $this->base_model->getValueArray('id as user_id, client_id, user_org_id, user_role_id, name as user_name, email as user_email, description as user_description, photo_file as user_photo_file, supervisor_id as user_supervisor_id, bpartner_id, is_fullbpaccess', 'a_user', 'id', $user_id);
		$user_org = $this->base_model->getValueArray('org_id', 'a_user_org', 'id', $user['user_org_id']);
		$user_role = $this->base_model->getValueArray('role_id', 'a_user_role', ['id','is_active','is_deleted'], [$user['user_role_id'], '1', '0']);
		$client = $this->base_model->getValueArray('name as client_name', 'a_client', 'id', $user['client_id']);
		$org = $this->base_model->getValueArray('name as org_name, supervisor_id as org_supervisor_id, address_map as org_address_map, phone as org_phone, fax as org_fax, email as org_email, website as org_website, swg_margin', 'a_org', 'id', $user_org['org_id']);
		$role = $this->base_model->getValueArray('name as role_name, supervisor_id as role_supervisor_id, amt_approval, is_canexport, is_canreport, is_canapproveowndoc, is_accessallorgs, is_useuserorgaccess', 'a_role', 'id', $user_role['role_id']);
		$system = $this->base_model->getValueArray('api_token, head_title, page_title, logo_text_mn, logo_text_lg, date_format, time_format, datetime_format, user_photo_path, max_file_upload', 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID]);
		$user_config = $this->base_model->getValue('attribute, value', 'a_user_config', 'user_id', $user_id);
		if ($user_config) {
			$userconfig = [];
			foreach($user_config as $k => $v) {
				$userconfig[$v->attribute] = $v->value;
			}
		}
		$user 			= ($user===FALSE) ? [] : $user;
		$user_org 	= ($user_org===FALSE) ? ['org_id' => null] : $user_org;
		$user_role 	= ($user_role===FALSE) ? ['role_id' => null] : $user_role;
		$client 		= ($client===FALSE) ? [] : $client;
		$org 				= ($org===FALSE) ? [] : $org;
		$role 			= ($role===FALSE) ? [] : $role;
		$system 		= ($system===FALSE) ? [] : $system;
		$userconfig = ($user_config===FALSE) ? [] : $userconfig;
		$data = array_merge($user, $user_org, $user_role, $client, $org, $role, $system, $userconfig);
		$this->session->set_userdata($data);
	}
	
	function get_a_user($params)
	{
		$params['select'] = "t1.id, t1.client_id, t1.user_org_id, t1.user_role_id, t1.is_active, t1.code, t1.name, coalesce(t1.code, '')||' '||t1.name as code_name, t1.description, t1.email, t1.last_login, t1.is_online, t1.supervisor_id,	t1.bpartner_id, t1.is_fullbpaccess, t1.is_expired, t1.ip_address, t1.photo_file, t2.org_id, t3.role_id";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_user as t1";
		$params['join'][] 	= ['a_user_org as t2', 't1.user_org_id = t2.id', 'left'];
		$params['join'][] 	= ['a_user_role as t3', 't1.user_role_id = t3.id', 'left'];
		$params['join'][] 	= ['a_client as t4', 't1.client_id = t4.id', 'left'];
		$params['join'][] 	= ['a_org as t5', 't2.org_id = t5.id', 'left'];
		$params['join'][] 	= ['a_role as t6', 't3.role_id = t6.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user_org($params)
	{
		$params['select'] = "t1.id, t1.org_id, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t2.swg_margin, t1.is_active";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_user_org as t1";
		$params['join'][] 	= ['a_org as t2', 't1.org_id = t2.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		$params['where']['t2.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user_role($params)
	{
		$params['select'] = "t1.id, t1.role_id, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t1.is_active";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_user_role as t1";
		$params['join'][] 	= ['a_role as t2', 't1.role_id = t2.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		$params['where']['t2.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user_substitute($params)
	{
		$params['select'] = "t1.id, t1.substitute_id, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t1.is_active, to_char(t1.valid_from, '".$this->sess->date_format."') as valid_from, to_char(t1.valid_to, '".$this->sess->date_format."') as valid_to, t1.description";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_user_substitute as t1";
		$params['join'][] 	= ['a_user as t2', 't1.user_id = t2.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		$params['where']['t2.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user_config($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_user_config as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user_recent($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_user_recent as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_menu($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_menu as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_role_menu($params)
	{
		$params['select'] = "t1.id, t1.menu_id, t2.code, t2.name, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t1.is_active, t2.is_parent, (select coalesce(code,'') ||'_'|| name from a_menu where id = t2.parent_id limit 1) as parent_name, t2.type, t1.permit_form, t1.permit_process, t1.permit_window";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_role_menu t1";
		$params['join'][] = ['a_menu t2', 't1.menu_id = t2.id', 'left'];
		$params['where']['t1.is_deleted']	= '0';
		$params['where']['t2.is_deleted']	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_role_process($params)
	{
		$params['select'] = "t1.id, t1.process_id, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t1.is_active";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_role_process t1";
		$params['join'][] = ['a_process t2', 't1.process_id = t2.id', 'left'];
		$params['where']['t1.is_deleted']	= '0';
		$params['where']['t2.is_deleted']	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_org($params)
	{
		$params['select'] = "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, coalesce(t2.code,'') ||'_'|| t2.name as orgtype_name, t1.is_active, (select name from a_org where id = t1.parent_id limit 1) as parent_name";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_org as t1";
		$params['join'][] 	= ['a_orgtype as t2', 't1.orgtype_id = t2.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_sequence($params)
	{
		$params['select'] = "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_sequence as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_orgtype($params)
	{
		$params['select'] = "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_orgtype as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_role($params)
	{
		$params['select']	= "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_role as t1";
		$params['join'][] 	= ['c_currency as cc', 't1.currency_id = cc.id', 'left'];
		$params['join'][] 	= ['a_user as au4', 't1.supervisor_id = au4.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function getMenuByRoleId($role_id)
	{
		if ($role_id) {
			$query = "select 
						am1.id as menu_id1, am1.name as name1, am1.is_parent as is_parent1, am1.icon as icon1, am1.type as type1,
						am2.id as menu_id2, am2.name as name2, am2.is_parent as is_parent2, am2.icon as icon2, am2.type as type2,
						am3.id as menu_id3, am3.name as name3, am3.is_parent as is_parent3, am3.icon as icon3, am3.type as type3
			from (
				select * from a_menu am where am.is_submodule = '0' and am.is_active = '1' and am.is_deleted = '0' and am.parent_id = '0' and 
				exists (
					select * from (
						select am.id, am.name, am.is_parent, am.line_no, am.icon, am.type, am.parent_id, arm.role_id
						from a_menu am
						left join a_role_menu arm on am.id = arm.menu_id and arm.is_active = '1' and arm.is_deleted = '0' and arm.role_id = $role_id
						where am.is_parent = '0' and am.is_submodule = '0' and am.is_active = '1' and am.is_deleted = '0' and arm.role_id is not null
					) basemenu where role_id is not null and parent_id = am.id
				)
			) am1
			left join (
				select am.id, am.name, am.is_parent, am.line_no, am.icon, am.type, am.parent_id, arm.role_id
				from a_menu am
				left join a_role_menu arm on am.id = arm.menu_id and arm.is_active = '1' and arm.is_deleted = '0' and arm.role_id = $role_id
				where am.is_parent = '0' and am.is_submodule = '0' and am.is_active = '1' and am.is_deleted = '0' and arm.role_id is not null
			) am2 on am1.id = am2.parent_id and am2.role_id is not null
			left join (
				select am.id, am.name, am.is_parent, am.line_no, am.icon, am.type, am.parent_id, arm.role_id
				from a_menu am
				left join a_role_menu arm on am.id = arm.menu_id and arm.is_active = '1' and arm.is_deleted = '0' and arm.role_id = $role_id
				where am.is_parent = '0' and am.is_submodule = '0' and am.is_active = '1' and am.is_deleted = '0' and arm.role_id is not null
			) am3 on am2.id = am3.parent_id and am3.role_id is not null
			order by am1.line_no, am2.line_no, am3.line_no";
			
			$row = $this->db->query($query);
			return ($row->num_rows() > 0) ? $row->result() : FALSE;
		}
		return FALSE;
	}
	
	function getParentMenu($menu_id)
	{
		$query = "select lvl0.id as lvl0_id, lvl1.id as lvl1_id, lvl2.id as lvl2_id
		from a_menu lvl0
		left join (
		 select * from a_menu 
		) lvl1 on lvl1.id = lvl0.parent_id
		left join (
		 select * from a_menu 
		) lvl2 on lvl2.id = lvl1.parent_id
		where lvl0.id = $menu_id";
		
		$row = $this->db->query($query);
		return ($row->num_rows() > 0) ? $row->result() : FALSE;
	}
	
	function getDashboardByRoleId($role_id)
	{
		$params['select']	= "t2.*, t1.role_id, t1.is_readwrite";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		$params['order']	= "t2.type, t2.lineno";
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_system($params)
	{
		$params['select']	= "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_system as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_client($params)
	{
		$params['select']	= "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_client as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_info($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "a_info as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_currency($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "c_currency as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_1country($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "c_1country as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_2province($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "c_2province as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_3city($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "c_3city as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_4district($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "c_4district as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_5village($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "c_5village as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	// function fun_
}