<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_Model extends CI_model
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
	
	function createUserRecent($data)
	{
		/* $qry = $this->db
			   ->select('*')
			   ->from('a_user_recent')
			   ->where($data)
			   ->limit(1)
			   ->order_by('id desc'); */
		$qry = $this->db->order_by('id desc')->get_where('a_user_recent', $data, 1);
		if ($qry->num_rows() > 0)
			return $this->db->update('a_user_recent', ['last_update' => date('Y-m-d H:i:s')], $data);
		
		return $this->db->insert('a_user_recent', $data);
	}
	
	function createUserConfig($data)
	{
		return $this->db->insert('a_user_config', $data);
	}
	
	function updateUserConfig($data, $cond)
	{
		$this->db->update('a_user_config', $data, $cond);
		return $this->db->affected_rows();
	}
	
	function getUserAuthentication($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_user as t1";
		$params['join'][] 	= ['a_client as ac', 't1.client_id = ac.id', 'left'];
		$params['join'][] 	= ['a_org as ao', 't1.org_id = ao.id', 'left'];
		$params['join'][] 	= ['a_role as ar', 't1.role_id = ar.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user($params)
	{
		$params['select'] = "t1.id,t1.client_id,t1.org_id,t1.role_id,t1.is_active,t1.is_deleted,
			t1.created_by,t1.updated_by,t1.deleted_by,t1.created_at,t1.updated_at,t1.deleted_at,
			t1.name,t1.description,t1.email,t1.last_login,t1.is_online,t1.supervisor_id,
			t1.bpartner_id,t1.is_fullbpaccess,t1.is_expired,t1.security_question,t1.security_answer,
			t1.ip_address,t1.photo_file,ao.name as org_name, ar.name as role_name, au4.name as supervisor_name,
			au1.name as _created_by, au2.name as _updated_by, au3.name as _deleted_by";
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_user as t1";
		$params['join'][] 	= ['a_client as ac', 't1.client_id = ac.id', 'left'];
		$params['join'][] 	= ['a_org as ao', 't1.org_id = ao.id', 'left'];
		$params['join'][] 	= ['a_role as ar', 't1.role_id = ar.id', 'left'];
		$params['join'][] 	= ['a_user as au1', 't1.created_by = au1.id', 'left'];
		$params['join'][] 	= ['a_user as au2', 't1.updated_by = au2.id', 'left'];
		$params['join'][] 	= ['a_user as au3', 't1.deleted_by = au3.id', 'left'];
		$params['join'][] 	= ['a_user as au4', 't1.supervisor_id = au4.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_user_org($params)
	{
		$params['select'] = "t1.id, t1.org_id, t2.code ||'_'|| t2.name as code_name, t2.swg_margin";
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_user_org as t1";
		$params['join'][] 	= ['a_org as t2', 't1.org_id = t2.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		$params['where']['t1.is_active'] 	= '1';
		$params['where']['t1.user_id'] 	= $this->sess->user_id;
		// $params['where']['t2.orgtype_id'] 	= 1; // type 1=Central, 2=Branch, 3=Division
		
		return $this->base_model->mget_rec($params);
	}
	
	function getUserConfig($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_user_config t1";
		$params['where']['t1.is_deleted'] 	= '0';
		$params['where']['t1.is_active'] 	= '1';
		$params['list'] = 1;
		
		return $this->base_model->mget_rec($params);
	}
	
	function getUserRole($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*, t2.name as role_name" : $params['select'];
		$params['table'] 	= "a_user_role t1";
		$params['join'][] 	= ['a_role as t2', 't1.role_id = t2.id', 'left'];
		$params['where']['t1.is_active'] 	= '1';
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function getUserWCount($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_user as t1";
		$params['join'][] 	= ['a_user_config as auc', 't1.id = auc.user_id', 'left'];
		$params['join'][] 	= ['a_client as ac', 't1.client_id = ac.id', 'left'];
		$params['join'][] 	= ['a_org as ao', 't1.org_id = ao.id', 'left'];
		$params['join'][] 	= ['a_role as ar', 't1.role_id = ar.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec_count($params);
	}
	
	function get_a_menu($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_menu as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_role_menu($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "am.*" : $params['select'];
		$params['table'] 	= "a_role_menu arm";
		$params['join'][] 	= ['a_menu am', 'am.id = arm.menu_id', 'left'];
		$params['where']['am.is_active']	= '1';
		$params['where']['am.is_deleted']	= '0';
		$params['where']['arm.is_active']	= '1';
		$params['where']['arm.is_deleted']	= '0';
		$params['where']['am.is_parent']	= '0';
		$params['order']	= "am.name";

		return $this->base_model->mget_rec($params);
	}
	
	function get_a_org($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_org as t1";
		$params['join'][] 	= ['a_orgtype as t2', 't1.orgtype_id = t2.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_role($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_role as t1";
		$params['join'][] 	= ['c_currency as cc', 't1.currency_id = cc.id', 'left'];
		$params['join'][] 	= ['a_user as au4', 't1.supervisor_id = au4.id', 'left'];
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function getMenuByRoleId($role_id)
	{
		$query = "select 
		am1.id as menu_id1, am1.role_id as role_id1, am1.name as name1, am1.is_parent as is_parent1, am1.url as url1, am1.icon as icon1, am1.is_readwrite as is_readwrite1, 
		am2.id as menu_id2, am2.role_id as role_id2, am2.name as name2, am2.is_parent as is_parent2, am2.url as url2, am2.icon as icon2, am2.is_readwrite as is_readwrite2, 
		am3.id as menu_id3, am3.role_id as role_id3, am3.name as name3, am3.is_parent as is_parent3, am3.url as url3, am3.icon as icon3, am3.is_readwrite as is_readwrite3
		from (
			select am.*, arm.role_id, arm.is_readwrite from a_role_menu arm left join a_menu am on am.id = arm.menu_id 
			where am.is_active = '1' and am.is_deleted = '0' and arm.is_active = '1' and arm.is_deleted = '0' and arm.role_id = $role_id
		) am1
		left join (
			select am.*, arm.role_id, arm.is_readwrite from a_role_menu arm left join a_menu am on am.id = arm.menu_id 
			where am.is_active = '1' and am.is_deleted = '0' and arm.is_active = '1' and arm.is_deleted = '0' and arm.role_id = $role_id
		) am2 on am1.id = am2.parent_id 
		left join (
			select am.*, arm.role_id, arm.is_readwrite from a_role_menu arm left join a_menu am on am.id = arm.menu_id 
			where am.is_active = '1' and am.is_deleted = '0' and arm.is_active = '1' and arm.is_deleted = '0' and arm.role_id = $role_id
		) am3 on am2.id = am3.parent_id 
		where am1.parent_id = '0'
		order by am1.line_no, am2.line_no, am3.line_no";
		
		$row = $this->db->query($query);
		return ($row->num_rows() > 0) ? $row->result() : FALSE;
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
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_system as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_a_info($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "a_info as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_currency($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "c_currency as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_1country($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "c_1country as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_2province($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "c_2province as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_3city($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "c_3city as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_4district($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "c_4district as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function get_c_5village($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "c_5village as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
}