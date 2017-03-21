<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Urls extends Getmeb
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('urls/urls_model');
	}
	
	function _remap($method, $params = array())
	{
		$this->c_method = $method;
		
		return call_user_func_array(array($this, $method), $params);
	}
	
	function w_shortenurls()
	{
		if ($this->r_method == 'GET') {
			if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				$this->params['where']['t1.id'] = $this->params['id'];
			
			if (key_exists('q', $this->params) && !empty($this->params['q']))
				$this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			if (($result['data'] = $this->system_model->{'get_'.$this->c_method}($this->params)) === FALSE){
				$result['data'] = [];
				$result['message'] = $this->base_model->errors();
				$this->xresponse(FALSE, $result);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if ($this->r_method == 'POST') {
			if (!key_exists('address', $this->params)) 
				$this->xresponse(FALSE, ['message' => 'Address is not found !'], 401);
			
			if (empty($this->params['address'])) 
				$this->xresponse(FALSE, ['message' => 'Address cannot be empty !'], 401);
			
			$result['data'] = $this->urls_model->save_url($this->params);
			
			if (($result['data'] = $this->urls_model->save_url($this->params)) === FALSE)
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()], 401);
			else
				$this->xresponse(TRUE, $result);
		}
	}
	
}