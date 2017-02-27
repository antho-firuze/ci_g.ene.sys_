<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function getProduct($id = NULL)
	{
		$params['select']	= "t1.*, 'jfi' as company";
		$params['table'] 	= "completion_slip as t1";
		$params['where']['t1.no_slip'] = $id;
		return $this->base_model->mget_rec($params);
	}
	
	function getCertificates($id = NULL)
	{
		$params['select']	= "t2.*";
		$params['table'] 	= "cs_files as t1";
		$params['join'][] = ['certificate_files as t2', 't1.id_certificate_files = t2.id', 'left'];
		$params['where']['t1.id_cs'] = $id;
		return $this->base_model->mget_rec($params);
		
		// $query = 'SELECT "t2".* FROM "cs_files" as "t1" LEFT JOIN "certificate_files" as "t2" ON "t1"."id_certificate_files" = "t2"."id" WHERE "t1"."id_cs" = '.$id;
		// return $this->db->query($query)->result();
	}
	
	
}