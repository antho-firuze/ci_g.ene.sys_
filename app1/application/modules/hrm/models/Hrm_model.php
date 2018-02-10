<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hrm_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function hr_allowance($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_card($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_education($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_education_level($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_employee_level($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_employee_status($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_excuse($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_experience($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_facility($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_gender($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_home_status($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_job_title($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_leave($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_marital_status($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_marital_tax_status($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_mutation($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_nationality($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_occupation($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_religion($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_sosial($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_training($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_photo($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*";
		$params->table 	= $this->c_method." as t1";
				/* foreach($result['data']['rows'] as $k => $v){
					ob_start(); // Let's start output buffering.
					fpassthru($v->photo_bin); 
					$contents = ob_get_contents(); //Instead, output above is saved to $contents
					ob_end_clean(); //End the output buffer.
					
					$result['data']['rows'][$k]->photo_binx = "data:image/png;base64," . base64_encode(hex2bin($contents));
					// $dataUri = "data:image/png;base64," . base64_encode(hex2bin($contents));
					// echo "<img src='$dataUri' />";
					unset($result['data']['rows'][$k]->photo_bin);
				} */
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_allowance($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_card($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_education($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_experience($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_facility($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_leave($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_loan($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_location($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_mutation($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_requirement_ga($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_requirement_it($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_sosial($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_training($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	function hr_personnel_travel($params)
	{
		$params->select	= isset($params->select) ? $params->select : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params->table 	= $this->c_method." as t1";
		if (isset($params->level) && $params->level == 1)
			$params->join[] = ['hr_personnel as t2', 't1.personnel_id = t2.id', 'left'];
		xresponse(TRUE, ['data' => $this->base_model->mget_rec($params)]);
	}
	
	
}