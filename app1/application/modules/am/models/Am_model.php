<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Am_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function am_asset_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_method." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function am_asset_reminder($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name, to_char(t1.remind_date, '".$this->session->date_format."') as remind_date, (select coalesce(code,'') ||'_'|| name from am_asset_type where id = t1.asset_type_id) as asset_type_name";
		$params['table'] 	= $this->c_method." as t1";
		return $this->base_model->mget_rec($params);
	}
	
}