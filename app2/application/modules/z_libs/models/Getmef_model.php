<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Getmef_Model extends CI_Model
{

	function getMenu($org_id)
	{
		$query = "select 
		am1.id as menu_id1, am1.name as name1, am1.is_parent as is_parent1, am1.page_id as page_id1, am1.icon as icon1,  
		am2.id as menu_id2, am2.name as name2, am2.is_parent as is_parent2, am2.page_id as page_id2, am2.icon as icon2,  
		am3.id as menu_id3, am3.name as name3, am3.is_parent as is_parent3, am3.page_id as page_id3, am3.icon as icon3
		from (
			select am.* from w_menu am 
			where am.is_active = '1' and am.is_deleted = '0' and am.org_id = ?
		) am1
		left join (
			select am.* from w_menu am 
			where am.is_active = '1' and am.is_deleted = '0' and am.org_id = ?
		) am2 on am1.id = am2.parent_id 
		left join (
			select am.* from w_menu am 
			where am.is_active = '1' and am.is_deleted = '0' and am.org_id = ?
		) am3 on am2.id = am3.parent_id 
		where am1.parent_id = '0'
		order by am1.line_no, am2.line_no, am3.line_no";
		return $this->db->query($query, [$org_id, $org_id, $org_id])->result();
	}
	
	function getDashboard($org_id)
	{
		$params['select']	= "ad.*";
		$params['table'] 	= "a_dashboard ad";
		$params['where']['ad.is_active']  = '1';
		$params['where']['ad.is_deleted'] = '0';
		$params['where']['ad.org_id'] 	  = $org_id;
		$params['order']	= "ad.type, ad.lineno";
		
		return $this->base_model->mget_rec($params);
	}
	
	function getInfo($params)
	{
		$params['select']	= "ai.*";
		$params['table'] 	= "a_info as ai";
		$params['where']['ai.is_active']  = '1';
		$params['where']['ai.is_deleted'] = '0';
		
		return $this->base_model->mget_rec_count($params);
	}
	
	function getPage($id = NULL, $name = NULL)
	{
		$params['select']	= "wp.*";
		$params['table'] 	= "w_page as wp";
		$params['where']['wp.is_active']  = '1';
		$params['where']['wp.is_deleted'] = '0';
		if (empty($id))	
			$params['where']['wp.is_default'] = '1';
		else
			$params['where']['wp.id'] = $id;
		
		$data = [];
		$data = (array) $this->base_model->mget_rec($params)[0];
		
		// $data['title'] = $data[0]->name;
		// $data['short_desc'] = $data[0]->short_desc;
		// $data['description'] = $data[0]->description;
		return $data;
	}
	


}