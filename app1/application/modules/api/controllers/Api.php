<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_rest/libraries/REST_Controller.php';
require APPPATH . '/modules/api/libraries/API_Controller.php';

class Api extends API_Controller {
	
	function __construct() {
		parent::__construct();
		
	}
	
	function api_v1()
	{
		if ($this->r_method == 'GET') {
			debug($this->user);
			// if (key_exists('id', $this->params) && !empty($this->params['id'])) 
				// $this->params['where']['t1.id'] = $this->params['id'];
			
			// if (key_exists('q', $this->params) && !empty($this->params['q']))
				// $this->params['like'] = DBX::like_or('t1.name', $this->params['q']);

			// if (($result['data'] = $this->system_model->{$this->c_method}($this->params)) === FALSE){
				// $result['data'] = [];
				// $result['message'] = $this->base_model->errors();
				// $this->xresponse(FALSE, $result);
			// } else {
				// $this->xresponse(TRUE, $result);
			// }
		}
		if ($this->r_method == 'POST') {
			if (key_exists('url', $this->params) && isset($this->params->url)) {
				
				if ($url = URL_Purify($this->params->url))
					$this->_post_url($url);
			} 
			$this->xresponse(FALSE, ['message' => 'Invalid URL Address !']);
		}
	}
	
}