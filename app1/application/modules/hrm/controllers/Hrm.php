<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Hrm extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
	}
	
	function hr_allowance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_card()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_education()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_education_level()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_employee_level()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_employee_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_excuse()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_experience()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_facility()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_gender()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_home_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_job_title()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_leave()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_marital_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_marital_tax_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_mutation()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_nationality()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_occupation()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_religion()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_sosial()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_training()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			/* This process is for Upload Photo */
			if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
				if (isset($this->params->id) && $this->params->id) {
					
					if (!$result = $this->_upload_file()){
						$this->xresponse(FALSE, ['message' => $this->messages()]);
					}
						
					/* If Success */
					if (! $img = fopen($result["path"], 'rb'))
						$this->xresponse(FALSE, ['message' => 'Error: Cannot read image !']);
					
					$data_img = fread($img, $result["size"]);
					$data_imgUri = "data:image/png;base64," . base64_encode($data_img);
					$es_data_img = pg_escape_bytea($data_img);
					fclose($img);
					
					/* For reading image field */
					// $data_img = pg_unescape_bytea($photo_bin);
					// $data_imgUri = "data:image/png;base64," . base64_encode($data_img);
					
					/* update to table */
					// $this->updateRecord('hr_personnel', ['photo_file' => $result["name"], 'photo_bin' => $es_data_img], ['id' => $this->params->id]);
					$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving'), 'data_uri' => $data_imgUri]);
					@unlink($result["path"]);
				}
			}
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_allowance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_card()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_education()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_experience()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_facility()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_leave()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_loan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_location()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_mutation()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_requirement_ga()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_requirement_it()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_sosial()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_training()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function hr_personnel_travel()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function m_pricelist_item()
	{
		$this->identity_keys = ['pricelist_id','pricelist_version_id','item_id'];
		$this->imported_fields = ['is_active','pricelist_id','pricelist_version_id','item_id','itemtype_id','itemcat_id','measure_id','code','name','size','description','price'];
		$this->validations = ['pricelist_id' => 'm_pricelist', 'pricelist_version_id' => 'm_pricelist_version', 'item_id' => 'm_item', 'itemtype_id' => 'm_itemtype', 'itemcat_id' => 'm_itemcat', 'measure_id' => 'm_measure'];
		
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->import) && !empty($this->params->import)) {
				/* Step #1:  */
				if (isset($this->params->step) && $this->params->step == '1') {
					/* Check permission in the role */
					if (! $result = $this->_import_data())
						$this->xresponse(FALSE, ['message' => $this->messages()]);
					else
						$this->xresponse(TRUE, $result);
				}
				/* Step #2:  */
				if (isset($this->params->step) && $this->params->step == '2') {
					/* Check permission in the role */
					if (! $result = $this->_import_data())
						$this->xresponse(FALSE, ['message' => $this->messages()]);
					else
						$this->xresponse(TRUE, array_merge($result, ['message' => $this->lang->line('import_finish')]));
				}
			}
				
				
			$this->_pre_update_records();
		}
	}
	
	
}