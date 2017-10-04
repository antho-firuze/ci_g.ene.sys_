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
	
	/* Delay update for IP PUBLIC. For getting more info. */
	function cron_update_ip_public()
	{
		$this->load->library('z_libs/IPAPI');
		/* For updating Domain & Client */
		$str = "update a_access_log t1 set domain_id = (select id from a_domain where name = t1.host), client_id = (select client_id from a_domain where name = t1.host) 
		where domain_id is null";
		$this->db->query($str);
		
		/* For updating IP PUBLIC on table [a_access_log] */
		$qry = $this->db->get_where('a_access_log', ['is_local' => null], 10);
		if ($qry->num_rows() > 0) {
			foreach($qry->result() as $row) {
				if (is_private_ip($row->ip_address)) {
					$data['is_local'] 		= TRUE;
					$data['country'] 			= NULL;
					$data['country_code'] = NULL;
					$data['region'] 			= NULL;
					$data['region_name'] 	= NULL;
					$data['city'] 				= NULL;
					$data['zip'] 					= NULL;
					$data['lat'] 					= NULL;
					$data['lon'] 					= NULL;
					$data['timezone'] 		= NULL;
					$data['isp'] 					= NULL;
					$data['org'] 					= NULL;
					$data['as_number'] 		= NULL;

					$this->db->update('a_access_log', $data, ['id' => $row->id]);
					continue;
				}
				if ($query = IPAPI::query($row->ip_address)) {
					$data['is_local'] 		= FALSE;
					$data['country'] 			= $query->country;
					$data['country_code'] = $query->countryCode;
					$data['region'] 			= $query->region;
					$data['region_name'] 	= $query->regionName;
					$data['city'] 				= $query->city;
					$data['zip'] 					= $query->zip;
					$data['lat'] 					= $query->lat;
					$data['lon'] 					= $query->lon;
					$data['timezone'] 		= $query->timezone;
					$data['isp'] 					= $query->isp;
					$data['org'] 					= $query->org;
					$data['as_number'] = $query->as;
					
					$this->db->update('a_access_log', $data, ['id' => $row->id]);
				}
			}
		}
		
		/* For updating IP PUBLIC on table [a_login_log] */
		$qry = $this->db->get_where('a_login_log', ['is_local' => null], 100);
		if ($qry->num_rows() > 0) {
			foreach($qry->result() as $row) {
				if (is_private_ip($row->ip_address)) {
					$data['is_local'] 		= TRUE;
					$data['country'] 			= NULL;
					$data['country_code'] = NULL;
					$data['region'] 			= NULL;
					$data['region_name'] 	= NULL;
					$data['city'] 				= NULL;
					$data['zip'] 					= NULL;
					$data['lat'] 					= NULL;
					$data['lon'] 					= NULL;
					$data['timezone'] 		= NULL;
					$data['isp'] 					= NULL;
					$data['org'] 					= NULL;
					$data['as_number'] 		= NULL;

					$this->db->update('a_login_log', $data, ['id' => $row->id]);
					continue;
				}
				if ($query = IPAPI::query($row->ip_address)) {
					$data['is_local'] 		= FALSE;
					$data['country'] 			= $query->country;
					$data['country_code'] = $query->countryCode;
					$data['region'] 			= $query->region;
					$data['region_name'] 	= $query->regionName;
					$data['city'] 				= $query->city;
					$data['zip'] 					= $query->zip;
					$data['lat'] 					= $query->lat;
					$data['lon'] 					= $query->lon;
					$data['timezone'] 		= $query->timezone;
					$data['isp'] 					= $query->isp;
					$data['org'] 					= $query->org;
					$data['as_number'] = $query->as;
					
					$this->db->update('a_login_log', $data, ['id' => $row->id]);
				}
			}
		}
	}
	
}