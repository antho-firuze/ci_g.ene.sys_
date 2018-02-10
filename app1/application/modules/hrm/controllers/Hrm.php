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
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_card()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_education()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_education_level()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_employee_level()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_employee_status()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_excuse()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_experience()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_facility()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_gender()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_home_status()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_job_title()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_leave()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_marital_status()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_marital_tax_status()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_mutation()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_nationality()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_occupation()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_religion()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_sosial()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_training()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post_put'){
				/* This process is for Upload Photo */
				if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
					if (isset($this->params->id) && $this->params->id) {
						
						if (!$result = $this->_upload_file()){
							xresponse(FALSE, ['message' => $this->messages()]);
						}
						/* If picture success upload to tmp folder */
						
						/* Method #1: if picture saved to table | this method required a lot of memory & high resource of hardware */
						// $data_img = bin2hex(file_get_contents($result["path"])); 
						/* insert to table */
						// $this->db->where('personnel_id', $this->params->id)->delete('hr_personnel_photo');
						// $this->_recordInsert('hr_personnel_photo', ['personnel_id' => $this->params->id, 'photo_file' => $result["name"], 'photo_bin' => $data_img], TRUE, TRUE);
						
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
						$this->_recordUpdate($this->c_method, ['photo_file'=>$rndName.'.'.$ext], ['id' => $this->params->id]);
						// xresponse(TRUE, ['message' => $this->lang->line('success_saving'), 'file_url' => base_url().'upload/images/personnel/'.$rndName.'.'.$ext, 'photo_file' => $rndName.'.'.$ext]);
						xresponse(TRUE, ['message' => $this->lang->line('success_saving')]);
					}
				}
				
				$this->mixed_data['name'] = $this->mixed_data['first_name'].' '.$this->mixed_data['last_name'];
				/* for counting percentage of field population */
				$fields = $this->db->list_fields($this->c_method);
				// debug($datas);
				$datas_cnt = $this->_remove_empty($this->mixed_data);
				// debug($datas);
				// $data = $this->base_model->getValueArray('*', $this->c_method, 'id', $id);
				$this->mixed_data['profile_status'] = (count($datas_cnt) / (count($fields)-11-8)) * 100;
			}
		}
	}
	
	function hr_personnel_photo()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->personnel_id) && !empty($this->params->personnel_id)) 
				$this->params->where['t1.personnel_id'] = $this->params->personnel_id;
			
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_allowance()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_card()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_education()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_experience()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_facility()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_leave()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_loan()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_location()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_mutation()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_requirement_ga()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_requirement_it()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_sosial()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_training()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function hr_personnel_travel()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
		
}