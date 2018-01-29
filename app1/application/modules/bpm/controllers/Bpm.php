<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Bpm extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
	}
	
	function c_greeting()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function c_bpartner()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function c_bpartner_location()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
	function c_bpartner_sosial()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
	}
	
}