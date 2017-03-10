<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Sales extends Getmef 
{
	function __construct() {
		parent::__construct();
		
		$this->params = $this->input->get();
	}
	
	function swg_price_calc()
	{
		
	}
}