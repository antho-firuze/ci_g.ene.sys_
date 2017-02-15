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
		/* $connection = array(
			'UID'			=> 'sa',
			'PWD'			=> 'admin123',
			'Database'		=> 'db_genesys'
		);
		if (sqlsrv_connect('tcp:115.85.74.130,8795', $connection))
			echo 'TRUE';
		else
			echo 'FALSE';
		// var_dump(sqlsrv_errors());
		return; */
		// $this->db = $this->load->database('sqlsvr12', TRUE);
		// $params['select']	= "cs.*, 'jfi' as company";
		// $params['table'] 	= "completion_slip as cs";
		// $params['where']['cs.no_slip'] = '2014-001-0000015';
		// $this->db->select($params['select']);
		// $this->db->from($params['table']);
		// if ( array_key_exists('where', $params)) $this->db->where($params['where']);
		
		// return $this->db->get()->result();
		// $this->db = $this->load->database('default', TRUE);
		
		$sqlsvr12 = $this->load->database('sqlsvr12', TRUE);
		$params['select']	= "cs.*, 'jfi' as company";
		$params['table'] 	= "completion_slip as cs";
		$params['where']['cs.no_slip'] = '2014-001-0000015';
		$sqlsvr12->select($params['select']);
		$sqlsvr12->from($params['table']);
		if ( array_key_exists('where', $params)) $sqlsvr12->where($params['where']);
		
		return out($sqlsvr12->get()->result());
		// return out($this->frontend_model->getProduct('2014-001-0000015'));

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
		$this->db = $this->load->database('sqlsvr12', TRUE);
		
		$data = [];
		$data = $this->frontend_model->getProduct($id);
		// return out($data[0]);
		$this->frontend_default_theme = 'simplelte';
		
		if (count($data) > 0) {
			$this->custom_view('pages/product_info', (array)$data[0]);
		} else {
			$this->custom_view('pages/empty');
		}
		
		$this->db = $this->load->database('default', TRUE);
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