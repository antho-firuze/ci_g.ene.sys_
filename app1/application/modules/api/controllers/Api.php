<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/modules/api/libraries/API_Controller.php';

class Api extends API_Controller {
	
	function __construct() {
		parent::__construct();
		
	}
	
	function api_v1()
	{
		if ($this->r_method == 'POST') {
			if (key_exists('url', $this->params) && isset($this->params->url)) {
				
				if ($url = URL_Purify($this->params->url))
					$this->_post_url($url);
			} 
			$this->xresponse(FALSE, ['message' => 'Invalid URL Address !']);
		}
	}
	
}