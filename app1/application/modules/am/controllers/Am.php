<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Am extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
	}
	
	function am_asset_type()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
	function am_asset_reminder()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered();
		}
	}
	
}