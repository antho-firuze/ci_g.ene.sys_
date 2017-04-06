<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Sales extends Getmeb
{
	function __construct() {
		parent::__construct();
		
		$class = strtolower(get_class($this));
		$this->load->model($class.'_model');
	}
	
	/* This method (function _remap), is a must exists for every controller */
	function _remap($method, $params = array())
	{
		/* Exeption list methods */
		$exception_method = [];
		/* This process is for checking login status (is a must on every controller) */
		$this->_check_is_login();
		/* This process is for checking permission (is a must on every controller) */
		$this->_check_is_allow();
		
		return call_user_func_array(array($this, $method), $params);
	}
	
	function a_user_org()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['zone']) && $this->params['zone'])
				$this->params['where']['t1.client_id'] = DEFAULT_CLIENT_ID;
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t2.code, t2.name', $this->params['q']);

			$this->params['where']['t1.is_active'] = '1';
			$this->params['where']['t1.client_id'] = $this->sess->user_id;
			
			$this->load->model('systems/system_model');
			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
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

			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function e_swg_size()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function e_swg_series()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function m_pricelist()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function m_pricelist_version()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = ['description'];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function m_pricelist_item()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function e_pl_swg_dimension()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);
	
			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function e_pl_swg_config()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.attribute, t1.description', $this->params['q']);
	
			if (($result['data'] = $this->sales_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$fields = $this->db->list_fields($this->c_method);
			$boolfields = [];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $this->params)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($this->params->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
					} else {
						$datas[$f] = $this->params->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
			else
				$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
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