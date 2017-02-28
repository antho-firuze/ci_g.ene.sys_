<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getmef_Model extends CI_Model
{

	function getMenu()
	{
		$query = "select 
		am1.id as menu_id1, am1.name as name1, am1.is_parent as is_parent1, am1.page_id as page_id1, am1.icon as icon1,  
		am2.id as menu_id2, am2.name as name2, am2.is_parent as is_parent2, am2.page_id as page_id2, am2.icon as icon2,  
		am3.id as menu_id3, am3.name as name3, am3.is_parent as is_parent3, am3.page_id as page_id3, am3.icon as icon3
		from (
			select am.* from w_menu am 
			where am.is_active = '1' and am.is_deleted = '0' and am.client_id = ".DEFAULT_CLIENT_ID." and am.org_id = ".DEFAULT_ORG_ID."
		) am1
		left join (
			select am.* from w_menu am 
			where am.is_active = '1' and am.is_deleted = '0' and am.client_id = ".DEFAULT_CLIENT_ID." and am.org_id = ".DEFAULT_ORG_ID."
		) am2 on am1.id = am2.parent_id 
		left join (
			select am.* from w_menu am 
			where am.is_active = '1' and am.is_deleted = '0' and am.client_id = ".DEFAULT_CLIENT_ID." and am.org_id = ".DEFAULT_ORG_ID."
		) am3 on am2.id = am3.parent_id 
		where am1.parent_id = '0'
		order by am1.line_no, am2.line_no, am3.line_no";
		return $this->db->query($query)->result();
	}
	
	function getDashboard()
	{
		$params['select']	= "t1.*";
		$params['table'] 	= "a_dashboard t1";
		$params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
		$params['where']['t1.org_id'] = DEFAULT_ORG_ID;
		$params['where']['t1.is_active']  = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['order']	= "t1.type, t1.lineno";
		return $this->base_model->mget_rec($params);
	}
	
	function getInfo($params)
	{
		$params['select']	= "t1.*";
		$params['table'] 	= "a_info as t1";
		$params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
		$params['where']['t1.org_id'] = DEFAULT_ORG_ID;
		$params['where']['t1.is_active']  = '1';
		$params['where']['t1.is_deleted'] = '0';
		return $this->base_model->mget_rec_count($params);
	}
	
	function getPage($params)
	{
		$params['select']	= "t1.*";
		$params['table'] 	= "w_page as t1";
		$params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
		$params['where']['t1.org_id'] = DEFAULT_ORG_ID;
		$params['where']['t1.is_active']  = '1';
		$params['where']['t1.is_deleted'] = '0';
		return $this->base_model->mget_rec($params);
	}
	
}