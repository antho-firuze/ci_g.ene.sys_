<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shared extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}

	function set_user_state()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
			
			$this->db->update('a_user', ['is_online' => $this->params->_user_state, 'heartbeat' => time()], ['id' => $this->session->user_id]);
			// debug($this->params);
		}
	}
	
}