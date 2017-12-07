<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Frontend extends Getmef 
{
	function __construct() {
		parent::__construct();
		
		$this->mdl = strtolower(get_class($this)).'_model';
		$this->load->model($this->mdl);
	}
	
	function _remap($method, $params = array())
	{
		if ($method == 'translate_url')
			return call_user_func_array(array($this, $method), [$this->uri->segment(1)]);
		
		return call_user_func_array(array($this, $method), $params);
	}
	
	function _shortenurl_log($add_data = [])
	{
		/* saving user_agent & ip address */
		$data['created_at'] = date('Y-m-d H:i:s');

		$data['ip_address'] = get_ip_address();
		if (is_private_ip($data['ip_address'])) {
			$data['is_local'] = TRUE;
		} else {
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
		$data['method'] = $_SERVER['REQUEST_METHOD'];
		$data['protocol'] = $_SERVER['REQUEST_SCHEME'];
		$data['host'] = $_SERVER['HTTP_HOST'];
		$data['request_uri'] = $_SERVER['REQUEST_URI'];
		$data['user_agent'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : NULL;
		
		$this->load->library('user_agent');
		$data['platform'] = $this->agent->platform();
		$data['is_mobile'] = $this->agent->is_mobile();
		$data['mobile'] = $this->agent->mobile();
		$data['is_robot'] = $this->agent->is_robot();
		$data['robot'] = $this->agent->robot();
		$data['is_browser'] = $this->agent->is_browser();
		$data['browser'] = $this->agent->browser();
		$data['browser_ver'] = $this->agent->version();
		
		$data = array_merge($data, (is_array($add_data) ? $add_data : []));
		
		if (!$this->db->insert('w_shortenurl_log', $data)){
			$this->session->set_flashdata('message', $this->db->error()['message']);
			return FALSE;
		}
		return TRUE;
	}
	
	function index()
	{
		redirect(base_url().'page');
	}
	
	/* method for translate shorten url */
	function translate_url($params)
	{
		if ($row = $this->base_model->getValue('id, url', 'w_shortenurl', 'code', $params)) {
			// record log access
			$this->_shortenurl_log(['shortenurl_id' => $row->id]);
			// redirect to target url
			header("Location: http://".$row->url);
		} else {
			show_404();
		}
	}
	
	function not_found()
	{
		$message = $this->session->flashdata('message') ? $this->session->flashdata('message') : '## This page does not exists ! ##';
		$this->frontend_view('pages/404', ['message'=>$message]);
	}
	
	function page()
	{
		if (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) {
			$menu = $this->base_model->getValue('*', 'w_menu', ['client_id','org_id','id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID, $this->params['pageid']]);
			if (!$menu){
				$this->frontend_view('pages/404', ['message'=>'## This page does not exists ! ##']);
			}
			
			$page = $this->base_model->getValueArray('*', 'w_page', ['client_id','org_id','id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID, $menu->page_id]);
			if (!$page){
				$this->frontend_view('pages/404', ['message'=>'## This page does not exists ! ##']);
			}
			$this->frontend_view('include/page', $page);
		}
		
		$page = $this->base_model->getValueArray('*', 'w_page', ['client_id','org_id','is_default'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID, '1']);
		if ($page){
			$this->frontend_view('include/page', $page);
		}
		$this->frontend_view('pages/404', ['message'=>'']);
	}
	
	function infolist()
	{
		$params['where']['t1.valid_from <='] = datetime_db_format();

		$result['data'] = $this->getmef_model->getInfo($params);
		$this->xresponse(true, $result);
	}
	
}