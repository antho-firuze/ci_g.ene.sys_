<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Inventory extends Getmeb 
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
	}
	
	function m_item()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function m_itemcat()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function m_itemtype()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function m_measure()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['id']) && ($this->params['id'] !== '')) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (isset($this->params['q']) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name, t1.description', $this->params['q']);

			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}

			if (($result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
}