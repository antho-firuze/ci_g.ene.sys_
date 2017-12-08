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
		if ($this->r_method != 'GET') {
			if (!key_exists('key', $this->params))
				xresponse(FALSE, ['message' => 'Undefined API Key !']);
			
			if (!$this->user = $this->_check_key_exists())
				xresponse(FALSE, ['message' => 'Invalid API Key !']);
		}
		
		/* Check Permission */
		$this->_check_is_allow();
		
		// xresponse(TRUE, ['message' => 'OK !']);
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
	
	function _check_is_allow()
	{
		/* Parsing request uri */
		if (count(explode('/', $_SERVER['REQUEST_URI'])) < 4) 
			xresponse(FALSE, ['message' => '[Unknown URI Format] : Invalid API URL Address !']);
		/* Assign to param */
		[, $class, $method, $version] = explode('/', $_SERVER['REQUEST_URI']);
		/* Check menu existance on the table a_menu */
		if (! $menu = $this->base_model->getValue('*', 'a_menu', ['class','method','is_active','is_deleted'], [$class, $method.'_'.$version, '1', '0']))
			xresponse(FALSE, ['message' => '[Unregistered/Inactive Method] : Unrecognized API Method !']);
		/* Check permission on the table a_user_role & a_role_menu */
		if (! $role = $this->base_model->getValue("string_agg(trim(role_id::char(4)), ',') as id", 'a_user_role', ['user_id','is_active','is_deleted'], [$this->user->id, '1', '0']))
			xresponse(FALSE, ['message' => '[Unregistered User Role] : Undefined User Role !']);
		if (! $role_menu = $this->db
				->where_in('role_id', explode(', ', $role->id))
				->where(['menu_id' => $menu->id, 'is_active' => '1', 'is_deleted' => '0', 'permit_process' => '1'])
				->get('a_role_menu'))
			xresponse(FALSE, ['message' => '[Unregistered Role Menu] : Unauthorized Access !']);
		/* Check method existance on API Controller */
		if (! method_exists($this, $method.'_'.$version))
			xresponse(FALSE, ['message' => '[Class API] : Undefined API Method !']);
		
		// xresponse(TRUE, ['message' => 'OK !']);
	}
	
}
