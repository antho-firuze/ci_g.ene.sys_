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
	
}