<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Urls_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function _check_key_exists($key)
	{
		return $this->db
				->where('api_token', $key)
				->count_all_results('a_user') > 0;
	}
	
	function _post_url($url)
	{
		
	}
	
	function w_shortenurl($params)
	{
		$params['select']	= !key_exists('select', $params) ? "t1.*" : $params['select'];
		$params['table'] 	= "w_shortenurls as t1";
		
		return $this->base_model->mget_rec($params);
	}
	
	function save_url($params)
	{
		/*
    Let's see if the unique code already exists in 
    the database.  If it does exist then make a new 
    one and we'll check if that exists too.  
    Keep making new ones until it's unique.  
    When we make one that's unique, use it for our url 
    */
		$i = 0;
    do {
      $code = random_string('alnum', 5); 

      $this->db->where('code', $code);
      $this->db->from('w_shortenurls');
      $num = $this->db->count_all_results();
			$i++;
    } while ($num >= 1);

    $query = "INSERT INTO w_shortenurls (`code`, `address`, `counter`) VALUES (?,?,?) ";
    $result = $this->db->query($query, array($code, $params['address'], $i));

    if ($result) {
      return $code;
    } else {
      return false;
    }	
	}
	
}