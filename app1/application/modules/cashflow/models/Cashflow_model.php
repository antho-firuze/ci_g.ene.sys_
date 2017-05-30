<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function cf_account($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_inout($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_inout_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_invoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_invoice_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_invoice_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_movement($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_movement_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order_plan_clearance($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order_plan_import($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_requisition($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_requisition_dt($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_method." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
}