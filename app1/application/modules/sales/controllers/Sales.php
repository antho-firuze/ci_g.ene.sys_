<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Sales extends Getmeb
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('sales/sales_model');
	}
	
	function _remap($method, $params = array())
	{
		$this->c_method = $method;
		
		return call_user_func_array(array($this, $method), $params);
	}
	
	function e_swg_class()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
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
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','code','name','description'];
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
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
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
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
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','code','name','description'];
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
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
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
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
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','code','name','description'];
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
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
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
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
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','code','name','description'];
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
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
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
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
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','code','name','description'];
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
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
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
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
			$data = json_decode($this->input->raw_input_stream);
			$fields = ['is_active','code','name','description'];
			$boolfields = ['is_active'];
			$nullfields = [];
			foreach($fields as $f){
				if (key_exists($f, $data)){
					if (in_array($f, $boolfields)){
						$datas[$f] = empty($data->{$f}) ? 0 : 1; 
					} 
					elseif (in_array($f, $nullfields)){
						$datas[$f] = ($data->{$f}=='') ? NULL : $data->{$f}; 
					} else {
						$datas[$f] = $data->{$f};
					}
				}
			}
			if ($this->r_method == 'POST')
				$result = $this->insertRecord($this->c_method, array_merge($datas, $this->update_log));
			else
				$result = $this->updateRecord($this->c_method, array_merge($datas, $this->update_log), ['id'=>(int)$this->params['id']]);
			
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
	
	function swg_basic_calc()
	{
		
	}
	
}