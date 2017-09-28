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
	
	function _save_useragent($account, $status = 'Login Success', $desc = null)
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
		$data['description'] = $desc;

		$data['ip_address'] = get_ip_address();
		if (! in_array($data['ip_address'], ['::1','127.0.0.1']) && ! is_private_ip($data['ip_address'])) {
			$this->load->library('z_libs/IPAPI');
			if ($query = IPAPI::query($data['ip_address'])) {
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
		
		if (!$this->db->insert('a_login_log', $data)){
			$this->session->set_flashdata('message', $this->db->error()['message']);
			return FALSE;
		}
		return TRUE;
	}
	
	function _store_config($user_id)
	{
		$user = $this->base_model->getValueArray('id as user_id, client_id, user_org_id, user_orgtrx_id, user_orgdept_id, user_orgdiv_id, user_role_id, name as user_name, email as user_email, description as user_description, photo_file as user_photo_file, supervisor_id as user_supervisor_id, bpartner_id, is_fullbpaccess', 'a_user', 'id', $user_id);
		$client = $this->base_model->getValueArray('name as client_name', 'a_client', 'id', $user['client_id']);
		$org = $this->base_model->getValueArray('id as org_id, name as org_name, supervisor_id as org_supervisor_id, address_map as org_address_map, phone as org_phone, fax as org_fax, email as org_email, website as org_website', 'a_org', 'id', $user['user_org_id']);
		$orgtrx = $this->base_model->getValueArray('id as orgtrx_id, name as orgtrx_name, supervisor_id as orgtrx_supervisor_id, address_map as orgtrx_address_map, phone as orgtrx_phone, fax as orgtrx_fax, email as orgtrx_email, website as orgtrx_website', 'a_org', 'id', $user['user_orgtrx_id']);
		$orgdept = $this->base_model->getValueArray('id as orgdept_id, name as orgdept_name, supervisor_id as orgdept_supervisor_id, address_map as orgdept_address_map, phone as orgdept_phone, fax as orgdept_fax, email as orgdept_email, website as orgdept_website', 'a_org', 'id', $user['user_orgdept_id']);
		$orgdiv = $this->base_model->getValueArray('id as orgdiv_id, name as orgdiv_name, supervisor_id as orgdiv_supervisor_id, address_map as orgdiv_address_map, phone as orgdiv_phone, fax as orgdiv_fax, email as orgdiv_email, website as orgdiv_website', 'a_org', 'id', $user['user_orgdiv_id']);
		$role = $this->base_model->getValueArray('id as role_id, name as role_name, supervisor_id as role_supervisor_id, amt_approval, is_canexport, is_canimport, is_canreport, is_canapproveowndoc, is_accessallorgs, is_useuserorgaccess', 'a_role', 'id', $user['user_role_id']);
		$system = $this->base_model->getValueArray('api_token, head_title, page_title, logo_text_mn, logo_text_lg, date_format, time_format, datetime_format, user_photo_path, personnel_photo_path, max_file_upload, group_symbol, decimal_symbol, negative_front_symbol, negative_back_symbol, number_digit_decimal, default_skin, default_layout, default_screen_timeout, default_language, default_show_branch_entry', 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID]);
		$user_config = $this->base_model->getValue('attribute, value', 'a_user_config', 'user_id', $user_id);
		$userconfig = [];
		if ($user_config) {
			if (count($user_config) == 1) {
				$userconfig[$user_config->attribute] = $user_config->value;
			} else {
				foreach($user_config as $k => $v) {
					$userconfig[$v->attribute] = $v->value;
				}
			}
		}
		$user 			= ($user===FALSE) ? [] : $user;
		$client 		= ($client===FALSE) ? [] : $client;
		$org 				= ($org===FALSE) ? [] : $org;
		$orgtrx 		= ($orgtrx===FALSE) ? [] : $orgtrx;
		$orgdept 		= ($orgdept===FALSE) ? [] : $orgdept;
		$orgdiv 		= ($orgdiv===FALSE) ? [] : $orgdiv;
		$role 			= ($role===FALSE) ? [] : $role;
		$system 		= ($system===FALSE) ? [] : $system;
		$userconfig = ($user_config===FALSE) ? [] : $userconfig;
		$data = array_merge($user, $client, $org, $orgtrx, $orgdept, $orgdiv, $role, $system, $userconfig);
		$this->session->set_userdata($data);
		
		/* Default user config session */
		$this->session->set_userdata('skin', isset($this->session->skin) && $this->session->skin != '' ? $this->session->skin : $this->session->default_skin);
		$this->session->set_userdata('layout', isset($this->session->layout) && $this->session->layout != '' ? $this->session->layout : $this->session->default_layout);
		$this->session->set_userdata('screen_timeout', isset($this->session->screen_timeout) && $this->session->screen_timeout != '' ? $this->session->screen_timeout : $this->session->default_screen_timeout);
		$this->session->set_userdata('language', isset($this->session->language) && $this->session->language != '' ? $this->session->language : $this->session->default_language);
		$this->session->set_userdata('show_branch_entry', isset($this->session->show_branch_entry) && $this->session->show_branch_entry != '' ? $this->session->show_branch_entry : $this->session->default_show_branch_entry);
	}
	
	function a_user($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.id, 
		t1.client_id, t1.user_org_id, t1.user_orgtrx_id, t1.user_role_id, t1.is_active, t1.code, t1.name, 
		coalesce(t1.code, '')||'_'||t1.name as code_name, 
		t1.description, t1.email, t1.last_login, t1.is_online, t1.supervisor_id, t1.bpartner_id, t1.is_fullbpaccess, t1.is_expired, t1.ip_address, t1.photo_file,
		(select coalesce(code, '')||'_'||name from a_role where id = t1.user_role_id) as default_user_role_name,
		(select coalesce(code, '')||'_'||name from a_org where id = t1.user_org_id) as default_user_org_name,
		(select coalesce(code, '')||'_'||name from a_org where id = t1.user_orgtrx_id) as default_user_orgtrx_name,
		(select coalesce(code, '')||'_'||name from a_org where id = t1.user_orgdept_id) as default_user_orgdept_name,
		(select coalesce(code, '')||'_'||name from a_org where id = t1.user_orgdiv_id) as default_user_orgdiv_name
		";
		$params['table'] 	= "a_user as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_org($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_user where id = t1.user_id) as user_name,
		t1.*, 
		(select coalesce(code,'') ||'_'|| name from a_org where id = t1.org_id) as code_name, 
		(select (select coalesce(code,'') ||'_'|| name from a_org where id = f1.org_id) from a_user_org f1 where id = t1.parent_id) as parent_name,
		(select count(user_org_id) from a_user where id = t1.user_id and user_org_id = t1.org_id) as is_default";
		$params['table'] 	= "a_user_org as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_orgtrx($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_user where id = t1.user_id) as user_name,
		t1.*, 
		(select coalesce(code,'') ||'_'|| name from a_org where id = t1.org_id) as code_name, 
		(select (select coalesce(code,'') ||'_'|| name from a_org where id = f1.org_id) from a_user_org f1 where id = t1.parent_id) as parent_name,
		(select count(user_org_id) from a_user where id = t1.user_id and user_orgtrx_id = t1.org_id) as is_default";
		$params['table'] 	= "a_user_org as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_orgdept($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_user where id = t1.user_id) as user_name,
		t1.*, 
		(select coalesce(code,'') ||'_'|| name from a_org where id = t1.org_id) as code_name, 
		(select (select coalesce(code,'') ||'_'|| name from a_org where id = f1.org_id) from a_user_org f1 where id = t1.parent_id) as parent_name,
		(select count(user_org_id) from a_user where id = t1.user_id and user_orgdept_id = t1.org_id) as is_default";
		$params['table'] 	= "a_user_org as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_orgdiv($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_user where id = t1.user_id) as user_name,
		t1.*, 
		(select coalesce(code,'') ||'_'|| name from a_org where id = t1.org_id) as code_name, 
		(select (select coalesce(code,'') ||'_'|| name from a_org where id = f1.org_id) from a_user_org f1 where id = t1.parent_id) as parent_name,
		(select count(user_org_id) from a_user where id = t1.user_id and user_orgdiv_id = t1.org_id) as is_default";
		$params['table'] 	= "a_user_org as t1";
		return $this->base_model->mget_rec($params);
	}
	
	/* function a_user_orgtrx($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select (select name from a_org f2 where f2.id = f1.org_id) from a_user_org f1 where f1.id = t1.user_org_id) as user_org_name,
		t1.id, t1.is_active, t1.org_id, (select coalesce(code,'') ||'_'|| name from a_org where id = t1.org_id) as code_name, (select coalesce(code,'') ||'_'|| name from a_user where id = t1.user_id) as user_name, (select coalesce(x2.code,'') ||'_'|| x2.name from a_user_org x1 inner join a_org x2 on x1.org_id = x2.id where x1.id = t1.user_org_id) as org_name";
		$params['table'] 	= $this->c_method." as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['join'][] = ['a_org as t2', 't1.org_id = t2.id', 'left'];
		}
		// $params['table'] 	= $this->c_table." as t1";
		// $params['join'][] 	= ['a_org as t2', 't1.org_id = t2.id', 'inner'];
		// $params['where']['t2.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	} */
	
	function a_user_role($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_user where id = t1.user_id) as user_name,
		t1.*, (select coalesce(code,'') ||'_'|| name from a_role where id = t1.role_id) as code_name, 
		(select count(user_role_id) from a_user where id = t1.user_id and user_role_id = t1.id) as is_default";
		$params['table'] 	= $this->c_method." as t1";
		// $params['table'] 	= $this->c_table." as t1";
		// $params['table'] 	= "a_user_role as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_substitute($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, (select coalesce(code,'') ||'_'|| name from a_user where id = t1.user_id) as code_name, to_char(t1.valid_from, '".$this->session->date_format."') as valid_from, to_char(t1.valid_to, '".$this->session->date_format."') as valid_to";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_config($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function a_user_recent($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function a_menu($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		coalesce(t1.code,'') ||'_'|| t1.name as code_name, 
		(select coalesce(code,'') ||'_'|| name from a_menu where id = t1.parent_id) as parent_name";
		$params['table'] 	= "(select id as grp, * from a_menu where is_parent = '1' union all	select parent_id as grp, * from a_menu where is_parent = '0') as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_menu_parent_list($params)
	{
		$id = '';
		if (isset($params['where']['id']) && $params['where']['id'])
			$id = 'and id = '.$params['where']['id'];
		$q = '';
		if (isset($params['like']) && $params['like'])
			$q = 'and '.$params['like'];
		
		$str = "WITH RECURSIVE tmp_tree (id, level, parent_id, line_no, is_parent, name) 
			AS ( 
				SELECT 
					id, 0 as level, parent_id, 1 as line_no,	is_parent, '' || name 
				FROM a_menu
				WHERE (parent_id is NULL or parent_id = 0) and is_deleted = '0' 
				UNION ALL
				SELECT
					t1.id, tt.level + 1, tt.id, t1.line_no, t1.is_parent, tt.name || '->' || t1.name
				FROM a_menu t1, tmp_tree tt 
				WHERE t1.parent_id = tt.id and is_deleted = '0' 
			) 
			SELECT count(*) FROM tmp_tree 
			WHERE is_parent = '1' $id $q;";
		$qry = $this->db->query($str);
		$response['total'] = $qry->row()->count;
		
		$str = "WITH RECURSIVE tmp_tree (id, level, parent_id, line_no, is_parent, name) 
			AS ( 
				SELECT 
					id, 0 as level, parent_id, 1 as line_no,	is_parent, '' || name 
				FROM a_menu
				WHERE (parent_id is NULL or parent_id = 0) and is_deleted = '0' 
				UNION ALL
				SELECT
					t1.id, tt.level + 1, tt.id, t1.line_no, t1.is_parent, tt.name || '->' || t1.name
				FROM a_menu t1, tmp_tree tt 
				WHERE t1.parent_id = tt.id and is_deleted = '0' 
			) 
			SELECT * FROM tmp_tree 
			WHERE is_parent = '1' $id $q 
			ORDER BY level, parent_id, line_no;";
		$qry = $this->db->query($str);
		$response['rows']  = $qry->result();
		
		return $response;
	}
	
	function a_role_menu($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.id, 
		t1.menu_id, t2.code, t2.name, 
		coalesce(t2.code,'') ||'_'|| t2.name as code_name, 
		t1.is_active, t2.is_parent, 
		(select coalesce(code,'') ||'_'|| name from a_role where id = t1.role_id) as role_name, 
		(select coalesce(code,'') ||'_'|| name from a_menu where id = t2.parent_id) as parent_name, 
		t2.type, t1.permit_form, t1.permit_process, t1.permit_window";
		$params['table'] 	= "a_role_menu as t1";
		$params['join'][] = ['a_menu t2', 't1.menu_id = t2.id', 'left'];
		$params['where']['t2.is_deleted']	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function a_role_dashboard($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		t1.id, t1.role_id, t1.dashboard_id, 
		(select coalesce(code,'') ||'_'|| name from a_role where id = t1.role_id) as role_name, 
		t1.seq, t2.code, t2.name, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t1.is_active, t2.type";
		$params['table'] 	= $this->c_table." as t1";
		$params['join'][] = ['a_dashboard t2', 't1.dashboard_id = t2.id', 'left'];
		$params['where']['t2.is_deleted']	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function a_role_process($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.id, t1.process_id, coalesce(t2.code,'') ||'_'|| t2.name as code_name, t1.is_active";
		$params['table'] 	= $this->c_table." as t1";
		$params['join'][] = ['a_process t2', 't1.process_id = t2.id', 'left'];
		$params['where']['t2.is_deleted']	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function a_org($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		coalesce(t1.code,'') ||'_'|| t1.name as code_name, 
		(select coalesce(code,'') ||'_'|| name from a_orgtype where id = t1.orgtype_id) as orgtype_name, 
		(select coalesce(code,'') ||'_'|| name from a_org where id = t1.parent_id limit 1) as parent_name";
		$params['table'] 	= "a_org as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_org_parent_list($params)
	{
		$q = isset($params['like']) ? 'and '.$params['like'] : '';
		$id = isset($params['where']['id']) ? 'and id = '.$params['where']['id'] : '';
		$client_id = isset($params['where']['client_id']) ? 'client_id = '.$params['where']['client_id'] : 'client_id = '.$this->session->client_id;
		$org_id = isset($params['where']['org_id']) ? 'and org_id = '.$params['where']['org_id'] : '';
		$orgtype_id = isset($params['where']['orgtype_id']) ? 'and orgtype_id = '.$params['where']['orgtype_id'] : '';
		$parent_id = isset($params['where']['parent_id']) ? 'and parent_id = '.$params['where']['parent_id'] : '';
		$org_id_in = isset($params['where_in']['org_id']) ? 'and org_id in ('.implode(',',$params['where_in']['org_id']).')' : '';
		// debug("$client_id $org_id $orgtype_id $id $q $parent_id $org_id_in");
		
		$str = "WITH RECURSIVE tmp_tree (id, parent_id, level, line_no, is_parent, client_id, org_id, orgtype_id, name, name_tree) 
			AS ( 
				SELECT 
					id, parent_id, 0 as level, 1 as line_no,	is_parent, client_id, org_id, orgtype_id, coalesce(code, '') ||'_'|| name, '' || name 
				FROM a_org
				WHERE (parent_id is NULL or parent_id = 0) and is_deleted = '0'
				UNION ALL
				SELECT
					t1.id, tt.id, tt.level + 1, t1.line_no, t1.is_parent, t1.client_id, t1.org_id, t1.orgtype_id, coalesce(t1.code, '') ||'_'|| t1.name, tt.name_tree || '->' || t1.name
				FROM a_org t1, tmp_tree tt 
				WHERE t1.parent_id = tt.id and t1.is_deleted = '0' 
			) 
			SELECT count(*) FROM tmp_tree 
			WHERE $client_id $org_id $orgtype_id $id $q $parent_id $org_id_in;";
		$qry = $this->db->query($str);
		$response['total'] = $qry->row()->count;
		
		$str = "WITH RECURSIVE tmp_tree (id, parent_id, level, line_no, is_parent, client_id, org_id, orgtype_id, name, name_tree) 
			AS ( 
				SELECT 
					id, parent_id, 0 as level, 1 as line_no,	is_parent, client_id, org_id, orgtype_id, coalesce(code, '') ||'_'|| name, '' || name 
				FROM a_org
				WHERE (parent_id is NULL or parent_id = 0) and is_deleted = '0'
				UNION ALL
				SELECT
					t1.id, tt.id, tt.level + 1, t1.line_no, t1.is_parent, t1.client_id, t1.org_id, t1.orgtype_id, coalesce(t1.code, '') ||'_'|| t1.name, tt.name_tree || '->' || t1.name
				FROM a_org t1, tmp_tree tt 
				WHERE t1.parent_id = tt.id and t1.is_deleted = '0' 
			) 
			SELECT * FROM tmp_tree 
			WHERE $client_id $org_id $orgtype_id $id $q $parent_id $org_id_in 
			ORDER BY level, parent_id, line_no;";
		$qry = $this->db->query($str);
		$response['rows']  = $qry->result();
		
		return $response;
	}
	
	function a_sequence($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_orgtype($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_role($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, (select name from c_currency where id = t1.currency_id limit 1) as currency_name, (select name from a_user where id = t1.supervisor_id limit 1) as supervisor_name";
		$params['table'] 	= "a_role as t1";
		// $params['join'][] 	= ['c_currency as cc', 't1.currency_id = cc.id', 'left'];
		// $params['join'][] 	= ['a_user as au4', 't1.supervisor_id = au4.id', 'left'];
		
		return $this->base_model->mget_rec($params);
	}
	
	function dashboard1($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}
	
	function a_system($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_client($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_dashboard($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_domain($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function a_info($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function c_currency($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function c_1country($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function c_2province($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function c_3city($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function c_4district($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function c_5village($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	// function fun_
}