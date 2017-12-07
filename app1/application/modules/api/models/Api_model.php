<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_func/models/Z_Model.php';

class Api_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function w_shortenurl($params)
	{
		$params['select']	= !key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "w_shortenurls as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
}