<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Frontend extends Getmef 
{
	public $org_id = 16;
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('frontend/frontend_model');
	}
	
	function index()
	{
		$data = $this->getmef_model->getPage();
		$this->frontend_view('include/page', $data);
	}
	
	function hrd()
	{
		$data = $this->getmef_model->getPage();
		$this->frontend_view('include/page', $data);
	}
	
	function page($id = 0)
	{
		$data = $this->getmef_model->getPage($id);
		// var_dump($data);
		// $data['org_id'] = 0;
		// $data['title'] = 'Page Title';
		// $data['short_desc'] = 'Page Short Description';
		// $data['description'] = 'Page Body';
		$this->frontend_view('include/page', $data);
	}
	
	function infolist()
	{
		$arg = (object) $this->input->get();
		$params = (array) $arg;
		
		$params['where']['ai.client_id'] = DEFAULT_CLIENT_ID;
		$params['where']['ai.org_id'] 	 = DEFAULT_ORG_ID;
		$params['where']['ai.valid_from <='] = datetime_db_format();

		$result['data'] = $this->getmef_model->getInfo($params);
		$this->xresponse(true, $result);
		// $this->getAPI('frontend', 'infolist', [], FALSE);
	}
	
	function test()
	{
		return out($this->getFrontendDashboard(11));
	}

	function product_info($id)
	{
		$data = [];
		$data = $this->frontend_model->getProduct($id);
		// return out($data[0]);
		$this->frontend_view('pages/product_info', (array)$data[0]);
	}
	
	function cs($id = NULL)
	{
		$data = [];
		$data = $this->frontend_model->getProduct($id);
		// return out($data[0]);
		$this->frontend_view('pages/product_info', (array)$data[0]);
	}
	
	function fgid($id = NULL)
	{
		if (empty($id)) {
			redirect('dashboard');
			out('testing');
			return;
		}
	
		$data = [];
		$data = $this->frontend_model->getProduct($id);
		// return out($data[0]);
		$this->frontend_view('pages/product_info', (array)$data[0]);
	}
	
}