<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/models/Base_model.php';

class Frontend_Model extends Base_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function getProduct($id = NULL)
	{
		$params['select']	= "cs.*, 'jfi' as company";
		$params['table'] 	= "z_completion_slip as cs";
		$params['where']['cs.no_slip'] = $id;
		
		return $this->mget_rec($params);
	}
	
	
}