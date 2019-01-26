<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jsonrpc extends CI_Controller
{
	public $r_method;
	public $c_method;
	
	function __construct() {
		parent::__construct();
		
		$this->r_method = $_SERVER['REQUEST_METHOD'];
		$this->c_method = $this->uri->segment(2) ? $this->uri->segment(2) : 'index';
		
		if (in_array($this->r_method, ['UNLOCK','LOCK','PATCH','POST','PUT','OPTIONS'])) {
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			// $this->params = count($this->params) > 0 ? $this->params : (object) $_REQUEST;
		} 
		
		if (in_array($this->r_method, ['GET','DELETE'])) {
			/* Become Object */
			$this->params = (object) $this->input->get();
		}
		
	}
	
}