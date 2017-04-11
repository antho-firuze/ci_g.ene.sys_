<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Web extends Getmeb
{
	function __construct() {
		parent::__construct();
		
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
	}
	
	/* This method (function _remap), is a must exists for every controller */
	function _remap($method, $params = array())
	{
		/* Exeption list methods */
		$this->exception_method = [];
		/* This process is for checking login status (is a must on every controller) */
		$this->_check_is_login();
		/* This process is for checking permission (is a must on every controller) */
		$this->_check_is_allow();
		
		return call_user_func_array(array($this, $method), $params);
	}
	
	function w_menu()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or(["t1.code", "t1.name", "coalesce(t1.code,'') ||'_'|| t1.name"], $this->params['q']);

			$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			$this->params['where']['t1.org_id'] = DEFAULT_ORG_ID;
			if (($result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->boolfields = ['is_active','is_parent'];
			$this->nullfields = ['description','icon','parent_id'];
			$this->_pre_update_records();
		}
	}
	
	function w_page()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or(["t1.code", "t1.name", "coalesce(t1.code,'') ||'_'|| t1.name"], $this->params['q']);

			$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			$this->params['where']['t1.org_id'] = DEFAULT_ORG_ID;
			if (($result['data'] = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->params->name 			 = $this->params->title;
			$this->params->description = $this->params->title_desc;
			$this->boolfields = ['is_active','is_securesmtp'];
			$this->nullfields = ['description','smtp_host','smtp_port'];
			$this->_pre_update_records();
		}
	}
	
}