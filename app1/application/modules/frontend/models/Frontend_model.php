<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function getProduct($id = NULL)
	{
		
		$params['select']	= "cs.*, 'jfi' as company";
		$params['table'] 	= "completion_slip as cs";
		$params['where']['cs.no_slip'] = $id;
		
		return $this->base_model->mget_rec($params);
		
	}
	
	
}