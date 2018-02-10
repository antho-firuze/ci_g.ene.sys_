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
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, TRUE);
		}
	}
	
	function c_bpartner()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, TRUE);
		}
	}
	
	function c_bpartner_location()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, TRUE);
		}
	}
	
	function c_bpartner_sosial()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, TRUE);
		}
	}
	
}