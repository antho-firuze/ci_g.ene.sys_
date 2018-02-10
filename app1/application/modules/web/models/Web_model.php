<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function w_menu($params)
	{
		$params->select = "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, (select coalesce(code,'') ||'_'|| name from w_menu where id = t1.parent_id limit 1) as parent_name, (select coalesce(code,'') ||'_'|| name from w_page where id = t1.page_id limit 1) as page_name";
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		$params->where['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
	function w_page($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		$params->where['t1.is_deleted'] 	= '0';
		
		return $this->base_model->mget_rec($params);
	}
	
}