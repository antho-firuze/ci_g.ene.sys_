<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Iproduct extends Getmef 
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('iproduct/iproduct_model');
		$this->params = $this->input->get();
	}
	
	function cs($id = NULL)
	{
		$this->db = $this->load->database('sqlsvr12', TRUE);
		
		$this->theme = 'simplelte';
		
		$result['data'] = []; 
		if (!empty($id)) {
			$result['data'] = $this->iproduct_model->getProduct($id); 
		}
		
		if (count($result['data']) > 0) {
			$result['data'][0]->certificates = $this->iproduct_model->getCertificates($result['data'][0]->id);
			$this->custom_view('pages/product_info', (array)$result['data'][0]);
		} else {
			$this->custom_view('pages/empty');
		}
		
		$this->db = $this->load->database('default', TRUE);
	}
	
	function getCertificates()
	{
		$this->db = $this->load->database('sqlsvr12', TRUE);
		
		$result['data'] = [];
		if (key_exists('id', $this->params) && !empty($this->params['id'])) 
			$result['data'] = $this->iproduct_model->getCertificates($this->params['id']);

		$this->xresponse(TRUE, $result);
		
		$this->db = $this->load->database('default', TRUE);
	}
	
}