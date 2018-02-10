<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Iproduct_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function _save_useragent($data = [])
	{
		/* saving user_agent & ip address */
		$data['client_id'] = DEFAULT_CLIENT_ID;
		$data['org_id'] = DEFAULT_ORG_ID;
		$data['created_at'] = date('Y-m-d H:i:s');

		$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
		if (! in_array($data['ip_address'], ['::1','127.0.0.1']) && ! is_private_ip($data['ip_address'])) {
			$this->load->library('z_libs/IPAPI');
			if ($query = IPAPI::query($data['ip_address'])) {
				$data['country'] = $query->country;
				$data['country_code'] = $query->countryCode;
				$data['region'] = $query->region;
				$data['region_name'] = $query->regionName;
				$data['city'] = $query->city;
				$data['zip'] = $query->zip;
				$data['lat'] = $query->lat;
				$data['lon'] = $query->lon;
				$data['timezone'] = $query->timezone;
				$data['isp'] = $query->isp;
				$data['org'] = $query->org;
				$data['as_number'] = $query->as;
			}
		}
		$this->load->library('user_agent');
		$data['platform'] = $this->agent->platform();
		$data['is_mobile'] = $this->agent->is_mobile();
		$data['mobile'] = $this->agent->mobile();
		$data['is_robot'] = $this->agent->is_robot();
		$data['robot'] = $this->agent->robot();
		$data['is_browser'] = $this->agent->is_browser();
		$data['browser'] = $this->agent->browser();
		$data['browser_ver'] = $this->agent->version();
		$data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		
		if (!$this->db->insert('e_qrcode_logs', $data)){
			$this->session->set_flashdata('message', $this->db->error()['message']);
			return FALSE;
		}
		return TRUE;
	}
	
	function getProduct($id = NULL)
	{
		$params->select	= "t1.*";
		$params->table 	= "completion_slip as t1";
		$params->where['t1.no_slip'] = $id;
		return $this->base_model->mget_rec($params);
	}
	
	function getCertificates($id = NULL)
	{
		$params->select	= "t2.*";
		$params->table 	= "cs_files as t1";
		$params->join[] = ['certificate_files as t2', 't1.id_certificate_files = t2.id', 'left'];
		$params->where['t1.id_cs'] = $id;
		$params->list = 1;
		return $this->base_model->mget_rec($params);
	}
	
	
}