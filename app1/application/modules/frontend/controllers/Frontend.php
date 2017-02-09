<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/getmef/libraries/Getmef.php';

class Frontend extends Getmef 
{
	public $org_id = 16;
	
	function __construct() {
		parent::__construct();
		
	}
	
	function index()
	{
		// if ((bool)$this->session->userdata('user_id'))
			// redirect('dashboard');
		
		$data['title'] = '';
		$data['short_desc'] = '';
		$data['description'] = '';
		$this->frontend_view('include/page', $data);
	}
	
	function page($id = 0)
	{
		$data['org_id'] = 0;
		$data['title'] = 'Page Title';
		$data['short_desc'] = 'Page Short Description';
		$data['description'] = 'Page Body';
		$this->frontend_view('include/page', $data);
	}
	
	function infolist()
	{
		$arg = (object) $this->input->get();
		$params = (array) $arg;
		
		if (array_key_exists('client_id', $params))
			$params['where']['ai.client_id'] = $arg->client_id;
		if (array_key_exists('org_id', $params))
			$params['where']['ai.org_id'] 	 = $arg->org_id;
		$params['where']['ai.valid_from <='] = datetime_db_format();

		$result['data'] = $this->frontend_model->getInfo($params);
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