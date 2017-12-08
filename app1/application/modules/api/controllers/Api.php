<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/modules/api/libraries/API_Controller.php';

class Api extends API_Controller {
	
	function __construct() {
		parent::__construct();
		
	}
	
	function urlshortener_v1()
	{
		/* Load models */
		$this->load->model('urlshorten_model');
		
		if ($this->r_method == 'POST') {
			if (key_exists('longUrl', $this->params) && isset($this->params->longUrl)) {
				
				if ($longUrl = URL_Purify($this->params->longUrl))
					$this->urlshorten_model->save_url($longUrl);
			} 
			xresponse(FALSE, ['message' => 'Invalid URL Address !']);
		}
	}
	
}