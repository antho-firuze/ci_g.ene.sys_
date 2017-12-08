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
		// $this->mdl = strtolower(get_class($this)).'_model';
		// $this->load->model($this->mdl);
		
		if (in_array($this->r_method, ['GET','POST','PUT','DELETE','OPTIONS'])) {
			/* FOR GETTING PARAMS */
			$this->params = $this->input->get();
			if (count($this->params) < 1) {
				$this->params = json_decode($this->input->raw_input_stream);
				$this->params = count($this->params) > 0 ? $this->params : $_REQUEST;
			}
			$this->params = (object) $this->params;
		}
		
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
				->where('api_token', $this->params->key)
				->get('a_user')
				->row();
	}
	
}
