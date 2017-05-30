<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Sales extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
	}
	
	function a_user_org()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['zone']) && $this->params['zone'])
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or(["t2.code", "t2.name", "coalesce(t2.code,'') ||'_'|| t2.name"], $this->params['q']);

			$this->params['where']['t1.is_active'] = '1';
			$this->params['where']['t1.user_id'] = $this->session->user_id;
			
			$this->load->model('systems/system_model');
			if (($result['data'] = $this->system_model->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function e_swg_class()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function e_swg_size()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function e_swg_series()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function m_pricelist()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function m_pricelist_version()
	{
		$this->identity_keys = ['pricelist_id','code','name'];
		
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
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
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
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
	
	function e_pl_swg_dimension()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);
	
			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function e_pl_swg_config()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.attribute, t1.description', $this->params['q']);
	
			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function swg_price_calc()
	{
		
		$result['data'] = $this->params;
		$this->xresponse(TRUE, $result);
	}
	
	function swg_ir_or_calc()
	{
		
	}
	
	function swg_or_or_calc()
	{
		
	}
	
	function swg_basic_calc()
	{
		
	}
	
}