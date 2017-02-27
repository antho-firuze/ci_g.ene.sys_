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

}