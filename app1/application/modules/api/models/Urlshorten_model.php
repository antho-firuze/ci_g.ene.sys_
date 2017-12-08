<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Urlshorten_Model extends CI_model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function save_url($url)
	{
		$result = $this->_generate_code();
		
		$data = array_merge($this->create_log, $result, ['url' => $url]);
		
		$result_url = $this->url_host.$data['code'];
		
		if (!$return = $this->db->insert('w_shortenurl', $data)) {
			xresponse(FALSE, ['message' => $this->db->error()['message']]);
		} else {
			xresponse(TRUE, ['message' => 'Success', 'shortUrl' => $result_url]);
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
	
}