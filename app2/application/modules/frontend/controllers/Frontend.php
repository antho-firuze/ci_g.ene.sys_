<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Frontend extends Getmef 
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('frontend/frontend_model');
		$this->params = $this->input->get();
	}
	
	function index()
	{
		$this->page();
	}
	
	function page($id = 0)
	{
		if (!empty($id)) 
			$params['where']['t1.id'] = $id;
		else 
			$params['where']['t1.is_default'] = '1';
	
		if (count($this->getmef_model->getPage($params)) < 1)
			show_404();
			
		$data = (array)$this->getmef_model->getPage($params)[0];
		$this->frontend_view('include/page', $data);
	}
	
	function infolist()
	{
		$params['where']['t1.valid_from <='] = datetime_db_format();

		$result['data'] = $this->getmef_model->getInfo($params);
		$this->xresponse(true, $result);
	}
	
	function cs($id = NULL)
	{
		$this->db = $this->load->database('sqlsvr12', TRUE);
		
		$this->frontend_default_theme = 'simplelte';
		
		$result['data'] = []; 
		if (!empty($id)) {
			$result['data'] = $this->frontend_model->getProduct($id); 
		}
		
		if (count($result['data']) > 0) {
			$result['data'][0]->certificates = $this->frontend_model->getCertificates($result['data'][0]->id);
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
			$result['data'] = $this->frontend_model->getCertificates($this->params['id']);

		$this->xresponse(TRUE, $result);
		
		$this->db = $this->load->database('default', TRUE);
	}
	
}