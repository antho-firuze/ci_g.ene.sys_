<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Hrm extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
	}
	
	function hr_allowance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_card()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_education()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_education_level()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_employee_level()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_employee_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_excuse()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_experience()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_facility()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_gender()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_home_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_job_title()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_leave()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_marital_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_marital_tax_status()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_mutation()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_nationality()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_occupation()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_religion()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_sosial()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_training()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post_put'){
				/* This process is for Upload Photo */
				if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
					if (isset($this->params->id) && $this->params->id) {
						
						if (!$result = $this->_upload_file()){
							$this->xresponse(FALSE, ['message' => $this->messages()]);
						}
						/* If picture success upload to tmp folder */
						
						/* Method #1: if picture saved to table | this method required a lot of memory & high resource of hardware */
						// $data_img = bin2hex(file_get_contents($result["path"])); 
						/* insert to table */
						// $this->db->where('personnel_id', $this->params->id)->delete('hr_personnel_photo');
						// $this->insertRecord('hr_personnel_photo', ['personnel_id' => $this->params->id, 'photo_file' => $result["name"], 'photo_bin' => $data_img], TRUE, TRUE);
						
						/* Method #2: if picture saved to folder */
						
						/* Create random filename */
						$this->load->helper('string');
						$rndName = random_string('alnum', 10);
						
						/* Moving to desire location with rename */
						$ext = strtolower(pathinfo($result['name'], PATHINFO_EXTENSION));
						$new_filename = $this->session->personnel_photo_path.$rndName.'.'.$ext;
						if (!is_dir($this->session->personnel_photo_path))
							mkdir($this->session->personnel_photo_path, 0755, true);
						rename($result["path"], $new_filename);
					
						/* delete old file photo */
						$tbl = $this->base_model->getValue('photo_file', $this->c_method, 'id', $this->params->id);
						if ($tbl && $tbl->photo_file) {
							@unlink($this->session->personnel_photo_path.$tbl->photo_file);
						}
						
						/* update to table */
						$this->updateRecord($this->c_method, ['photo_file'=>$rndName.'.'.$ext], ['id' => $this->params->id]);
						// $this->xresponse(TRUE, ['message' => $this->lang->line('success_saving'), 'file_url' => base_url().'upload/images/personnel/'.$rndName.'.'.$ext, 'photo_file' => $rndName.'.'.$ext]);
						$this->xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
					}
				}
				
				$this->mixed_data['name'] = $this->mixed_data['first_name'].' '.$this->mixed_data['last_name'];
				/* for counting percentage of field population */
				$fields = $this->db->list_fields($this->c_method);
				// debug($datas);
				$datas_cnt = $this->remove_empty($this->mixed_data);
				// debug($datas);
				// $data = $this->base_model->getValueArray('*', $this->c_method, 'id', $id);
				$this->mixed_data['profile_status'] = (count($datas_cnt) / (count($fields)-11-8)) * 100;
			}
		}
	}
	
	function hr_personnel_photo()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['personnel_id']) && !empty($this->params['personnel_id'])) 
				$this->params['where']['t1.personnel_id'] = $this->params['personnel_id'];
			
			$this->_get_filtered();
	
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				foreach($result['data']['rows'] as $k => $v){
					ob_start(); // Let's start output buffering.
					fpassthru($v->photo_bin); 
					$contents = ob_get_contents(); //Instead, output above is saved to $contents
					ob_end_clean(); //End the output buffer.
					
					$result['data']['rows'][$k]->photo_binx = "data:image/png;base64," . base64_encode(hex2bin($contents));
					// $dataUri = "data:image/png;base64," . base64_encode(hex2bin($contents));
					// echo "<img src='$dataUri' />";
					unset($result['data']['rows'][$k]->photo_bin);
				}
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_allowance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_card()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_education()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_experience()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_facility()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_leave()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_loan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_location()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_mutation()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_requirement_ga()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_requirement_it()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_sosial()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_training()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function hr_personnel_travel()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered();
	
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
		
}