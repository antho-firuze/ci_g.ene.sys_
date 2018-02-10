<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function e_swg_size($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function e_swg_class($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function e_swg_series($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function e_pl_swg_dimension($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function e_pl_swg_config($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function m_pricelist($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function m_pricelist_version($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, to_char(t1.valid_from, '".$this->session->date_format."') as valid_from, (select coalesce(code,'') ||'_'|| name from m_pricelist where id = t1.pricelist_id limit 1) as pricelist_name ";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['m_pricelist as t2', 't1.pricelist_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function m_pricelist_item($params)
	{
		// $params->select	= "t1.*, t1.code ||'_'|| t1.name as code_name, t3.code ||'_'|| t3.name as code_name_pricelist, t4.code ||'_'|| t4.name as code_name_pricelist_version";
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, (select coalesce(code,'') ||'_'|| name from m_pricelist where id = t1.pricelist_id limit 1) as pricelist_name, (select coalesce(code,'') ||'_'|| name from m_pricelist_version where id = t1.pricelist_version_id limit 1) as pricelist_version_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1){
			$params->join[] = ['m_item as t2', 't1.item_id = t2.id', 'inner'];
			$params->join[] = ['m_pricelist as t3', 't1.pricelist_id = t3.id', 'inner'];
			$params->join[] = ['m_pricelist_version as t4', 't1.pricelist_version_id = t4.id', 'inner'];
		}
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function m_pricelist_item_list($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, (select coalesce(code,'') ||'_'|| name from m_pricelist where id = t1.pricelist_id limit 1) as pricelist_name, (select coalesce(code,'') ||'_'|| name from m_pricelist_version where id = t1.pricelist_version_id limit 1) as pricelist_version_name";
		$params->table 	= "m_pricelist_item as t1";
		if (isset($params->level) && $params->level == 1){
			$params->join[] = ['m_item as t2', 't1.item_id = t2.id', 'inner'];
			$params->join[] = ['m_pricelist as t3', 't1.pricelist_id = t3.id', 'inner'];
			$params->join[] = ['m_pricelist_version as t4', 't1.pricelist_version_id = t4.id', 'inner'];
		}
		$params->where['t1.is_active'] 	= '1';
		$params->where['t4.is_deleted'] 	= '0';
		$params->where['t4.is_active'] 	= '1';
		$params->where_custom = "t4.valid_from = (SELECT MAX(valid_from) FROM m_pricelist_version where is_deleted = '0' and is_active = '1')";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
}