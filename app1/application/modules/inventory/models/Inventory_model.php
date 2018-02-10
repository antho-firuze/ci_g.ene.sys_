<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function m_item($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, (select name from m_itemtype where id = t1.itemtype_id limit 1) as itemtype_name, (select name from m_itemcat where id = t1.itemcat_id limit 1) as itemcat_name, (select name from m_measure where id = t1.measure_id limit 1) as measure_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}

	function m_itemcat($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}

	function m_itemtype($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}

	function m_measure($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}

}