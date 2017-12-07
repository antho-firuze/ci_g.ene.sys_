<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Rest Controller
 * A fully RESTful server implementation for CodeIgniter using one library, one config file and one controller.
 *
 * @package         CodeIgniter
 * @subpackage      Libraries
 * @category        Libraries
 * @author          Antho Firuze (antho.firuze@gmail.com)
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 * @version         1.0.0
 */
abstract class API_Controller extends CI_Controller {
	
	/* FOR REQUEST METHOD */
	public $r_method;	
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	/* FOR AUTOLOAD MODEL */
	public $mdl;
	/* FOR GETTING ERROR MESSAGE OR SUCCESS MESSAGE */
	public $messages = array();
	/* FOR ADDITIONAL CRUD */
	public $create_log = array();
	/* FOR CONTAINER */
	public $user;
	/* FOR SHORTEN URL */
	public $url_host = 'jeil.bz/';

	function __construct() {
		parent::__construct();
		$this->r_method = $_SERVER['REQUEST_METHOD'];
		
		/* Load models */
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
		
		/* Get the params */
		$this->params = (object) $this->input->get();
		
		/* Check Authentication */
		if (!key_exists('key', $this->params))
			$this->xresponse(FALSE, ['message' => 'Undefined API Key !']);
		
		if (!$this->user = $this->_check_key_exists())
			$this->xresponse(FALSE, ['message' => 'Invalid API Key !']);
		
		// $this->xresponse(TRUE, ['message' => 'OK !']);
		$this->create_log = [
			'created_by'	=> (!empty($this->user->id) ? $this->user->id : '0'),
			'created_at'	=> date('Y-m-d H:i:s')
		];
	}
	
	function _check_key_exists()
	{
		return $this->db
				->where('api_token', urlencode($this->params->key))
				->get('a_user')
				->row();
	}
	
	function _post_url($url)
	{
		$result = $this->_generate_code();
		
		$data = array_merge($this->create_log, $result, ['url' => $url]);
		
		$result_url = $this->url_host.$data['code'];
		// debug($result_url);
		
		if (!$return = $this->db->insert('w_shortenurl', $data)) {
			$this->xresponse(FALSE, ['message' => $this->db->error()['message']]);
		} else {
			$this->xresponse(TRUE, ['message' => 'Success', 'url' => $result_url]);
		}
	}
	
	function _generate_code()
	{
		$this->load->helper('string');
		/*
    Let's see if the unique code already exists in 
    the database.  If it does exist then make a new 
    one and we'll check if that exists too.  
    Keep making new ones until it's unique.  
    When we make one that's unique, use it for our url 
    */
		$i = 0;
    do {
			if ($i > 4)
				$code = random_string('alnum', 6); 
			else
				$code = random_string('alnum', 5); 
			
			$i++;
    } while ($this->db->where('code', $code)->count_all_results('w_shortenurl') >= 1);
		
		return ['code' => $code, 'counter' => $i];
	}
	
	function xresponse($status=TRUE, $response=array(), $statusHeader=200, $exit=TRUE)
	{
		$BM =& load_class('Benchmark', 'core');
		
		$statusCode = $status ? 200 : 401;
		$statusCode = $statusHeader != 200 ? $statusHeader : $statusCode;
		if (! is_numeric($statusCode))
			show_error('Status codes must be numeric', 500);
		
		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

		$output['status'] = $status;
		$output['execution_time'] = $elapsed;
		$output['environment'] = ENVIRONMENT;
		
		header("HTTP/1.0 $statusCode");
		header('Content-Type: application/json');
		echo json_encode(array_merge($output, $response));
		if ($exit) 
			exit();
	}
	
	
}
