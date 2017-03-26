<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Iproduct extends Getmef 
{
	function __construct() {
		$this->theme = 'simplelte';
		parent::__construct();
		
		$this->load->model('iproduct/iproduct_model');
		$this->params = $this->input->get();
	}
	
	function cs($id = NULL)
	{
		$this->db = $this->load->database(DB_DSN_SQLSVR, TRUE);
		
		$product = $this->base_model->getValueArray('*', 'completion_slip', 'no_slip', $id);
		if ($product) {
			$product['certificates'] = $this->iproduct_model->getCertificates($product['id']);
			$this->custom_view('pages/product_info', $product);
		} else {
			$this->custom_view('pages/empty');
		}
	}
	
	function getCertificates()
	{
		$this->db = $this->load->database(DB_DSN_SQLSVR, TRUE);
		
		$result['data'] = [];
		if (key_exists('id', $this->params) && !empty($this->params['id'])) 
			$result['data'] = $this->iproduct_model->getCertificates($this->params['id']);

		$this->xresponse(TRUE, $result);
	}
	
}