<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Web extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
	}
	
	function w_menu()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && !empty($this->params->id)) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or(["t1.code", "t1.name", "coalesce(t1.code,'') ||'_'|| t1.name"], $this->params->q);

			$this->params->where['t1.client_id'] = DEFAULT_CLIENT_ID;
			$this->params->where['t1.org_id'] = DEFAULT_ORG_ID;
			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function w_page()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && !empty($this->params->id)) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or(["t1.code", "t1.name", "coalesce(t1.code,'') ||'_'|| t1.name"], $this->params->q);

			$this->params->where['t1.client_id'] = DEFAULT_CLIENT_ID;
			$this->params->where['t1.org_id'] = DEFAULT_ORG_ID;
			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['name'] = $this->params->title;
				$this->mixed_data['description'] = $this->params->title_desc;
			}
		}
	}
	
}