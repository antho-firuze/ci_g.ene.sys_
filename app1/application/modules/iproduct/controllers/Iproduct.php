<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Iproduct extends Getmef 
{
	function __construct() {
		$this->theme = 'simplelte';
		parent::__construct();
		
		$this->load->model('iproduct/iproduct_model');
	}
	
	function cs($id = NULL)
	{
		/* Load database for getting data from SQL Server */
		$this->db = $this->load->database(DB_DSN_SQLSVR, TRUE);
		$product = $this->base_model->getValueArray('*', 'completion_slip', 'no_slip', $id);
		if ($product) {
			/* Check certificate */
			$product['certificates'] = $this->iproduct_model->getCertificates($product['id']);
			
			/* Load database default for saving logs */
			$this->db = $this->load->database('default', TRUE);
			/* Saving User Agent & IP Address & Severeal Info */
			$data['cs_no'] = $id;
			$data['cs_id'] = $product['id'];
			$data['no_so'] = $product['no_so'];
			$data['finish_date'] = $product['finish_date'];
			$data['customer'] = $product['customer'];
			$data['qty'] = $product['qty'];
			$this->iproduct_model->_save_useragent($data);
		
			/* Load database for getting data from SQL Server */
			$this->db = $this->load->database(DB_DSN_SQLSVR, TRUE);
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