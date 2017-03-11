<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_e_swg_size($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "e_swg_size as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		if (key_exists('list', $params) && ($params['list'])) 
			return $this->base_model->mget_rec($params);
		else
			return $this->base_model->mget_rec_count($params);
	}
	
	function get_e_swg_class($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "e_swg_class as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		if (key_exists('list', $params) && ($params['list'])) 
			return $this->base_model->mget_rec($params);
		else
			return $this->base_model->mget_rec_count($params);
	}
	
	function get_e_swg_series($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "e_swg_series as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		if (key_exists('list', $params) && ($params['list'])) 
			return $this->base_model->mget_rec($params);
		else
			return $this->base_model->mget_rec_count($params);
	}
	
	function get_e_pl_swg_dimension($params)
	{
		$params['select']	= !array_key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "e_pl_swg_dimension as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		
		if (key_exists('list', $params) && ($params['list'])) 
			return $this->base_model->mget_rec($params);
		else
			return $this->base_model->mget_rec_count($params);
	}
	
}