<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Getmef extends CI_Controller
{
	public $asset_path;
	public $styles		= array();
	public $scripts		= array();
	public $backend_default_theme;
	public $frontend_default_theme;
	public $org_id 		= 0;
	
	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, X-AUTH, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		
		parent::__construct();
		
		define('URL_SEPARATOR', '/');
		define('ASSET_URL', base_url().'assets/');

		$this->backend_default_theme  = 'adminlte';
		$this->frontend_default_theme = 'adminlte';
		
		$this->load->model('frontend/frontend_model');
	}
	
	function _check_token()
	{
		$jwt 	= $this->input->server('HTTP_TOKEN');
		$auth 	= $this->input->server('HTTP_AUTHENTICATION');
		try {
			$data = json_decode(urlsafeB64Decode($auth));
			
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return TRUE;
	}
	
	function _decrypt_data($auth = NULL)
	{
        if ($auth !== NULL)
        {
            if (strpos(strtolower($auth), 'bearer') === 0)
            {
                list($user_id, $client_id, $org_id, $role_id) = explode(':', base64_decode(substr($auth, 7)));
				$GLOBALS['identifier'] = [
					'user_id' 	=> $user_id,
					'client_id'	=> $client_id,
					'org_id'	=> $org_id,
					'role_id'	=> $role_id
				];
				return TRUE;
            }
			throw new Exception("This Data Authorization is invalid.");
        }
		throw new Exception("Data Authorization cannot be empty.");
		return FALSE;
	}
	
	function getAPI($method, $function, $params = [], $keep = TRUE)
	{
		$params = is_array($params) ? $params : (array) $params;
		$params = (count($params) < 1) ? '' : '?'.http_build_query($params);
		
		$headers  = [
			'X-API-KEY'	=> APPLICATION_KEY,
			'TOKEN' => $this->session->userdata('token')
		];
		$response = Requests::get(API_URL.$method.'/'.$function.$params, $headers);
		$result   = json_decode($response->body);
		
		// UPDATE TOKEN TO SESSION
		if (! empty($result->token))
			if ((bool)$this->session->userdata('user_id'))
				$this->session->set_userdata('token', $result->token);
		
		$output['execution_time_api'] = $result->execution_time;
		$output['environment_api'] = $result->environment;
		$output['data']	= $result->data;
		
		// OUTPUT
		if (! $keep)
			$this->xresponse($result->status, $output, $response->status_code);
		else
			return $result;
	}
	
	function postAPI($method, $function, $data = [], $keep = TRUE)
	{
		$headers  = [
			'X-API-KEY'	=> APPLICATION_KEY,
			'TOKEN' => $this->session->userdata('token')
		];
		$response = Requests::post(API_URL.$method.'/'.$function, $headers, $data);
		$result = json_decode($response->body);
		
		// UPDATE TOKEN TO SESSION
		if (! empty($result->token))
			if ((bool)$this->session->userdata('user_id'))
				$this->session->set_userdata('token', $result->token);
		
		$output['execution_time_api'] = $result->execution_time;
		$output['environment_api'] = $result->environment;
		$output['message']	= $result->message;
		
		// OUTPUT
		if (! $keep)
			$this->xresponse($result->status, $output, $response->status_code);
		else
			return $result;
	}

	function putAPI($method, $function, $params = [], $data = [], $keep = TRUE)
	{
		$params = is_array($params) ? $params : (array) $params;
		$params = (count($params) < 1) ? '' : '?'.http_build_query($params);
		
		$headers  = [
			'X-API-KEY'	=> APPLICATION_KEY,
			'TOKEN' => $this->session->userdata('token')
		];
		$response = Requests::put(API_URL.$method.'/'.$function.$params, $headers, $data);
		$result = json_decode($response->body);
		
		// UPDATE TOKEN TO SESSION
		if (! empty($result->token))
			if ((bool)$this->session->userdata('user_id'))
				$this->session->set_userdata('token', $result->token);
		
		$output['execution_time_api'] = $result->execution_time;
		$output['environment_api'] = $result->environment;
		$output['message']	= $result->message;
		
		// OUTPUT
		if (! $keep)
			$this->xresponse($result->status, $output, $response->status_code);
		else
			return $result;
	}

	function deleteAPI($method, $function, $params = [], $keep = TRUE)
	{
		$params = is_array($params) ? $params : (array) $params;
		$params = (count($params) < 1) ? '' : '?'.http_build_query($params);
		
		$headers  = [
			'X-API-KEY'	=> APPLICATION_KEY,
			'TOKEN' => $this->session->userdata('token')
		];
		$response = Requests::delete(API_URL.$method.'/'.$function.$params, $headers);
		$result = json_decode($response->body);
		
		// UPDATE TOKEN TO SESSION
		if (! empty($result->token))
			if ((bool)$this->session->userdata('user_id'))
				$this->session->set_userdata('token', $result->token);
		
		$output['execution_time_api'] = $result->execution_time;
		$output['environment_api'] = $result->environment;
		$output['message']	= $result->message;
		
		// OUTPUT
		if (! $keep)
			$this->xresponse($result->status, $output, $response->status_code);
		else
			return $result;
	}

	function xresponse($status=TRUE, $response=array(), $statusHeader=200)
	{
		$BM =& load_class('Benchmark', 'core');
		
		$statusHeader = empty($statusHeader) ? 200 : $statusHeader;
		if (! is_numeric($statusHeader))
			show_error('Status codes must be numeric', 500);
		
		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

		$output['status'] = $status;
		$output['execution_time'] = $elapsed;
		$output['environment'] = ENVIRONMENT;
		
		header("HTTP/1.0 $statusHeader");
		header('Content-Type: application/json');
		echo json_encode(array_merge($output, $response));
		exit();
	}
	
	function getFrontendMenu()
	{
		$result['data'] = [];
		if ($this->org_id >= 0)
		{
			$result['data'] = $this->frontend_model->getMenu($this->org_id);
		}
		return $result['data'];
	}
	
	function getFrontendDashboard($org_id)
	{
		$org_id = is_numeric($org_id) ? $org_id : -1;
		
		$result['data'] = [];
		if ($org_id >= 0)
		{
			$result['data'] = $this->frontend_model->getDashboard($org_id);
		}
		return $result['data'];
		
		/* $params = ['id' => $org_id];
		$result = $this->getAPI('frontend', 'dashboard', $params);
		return $result->data; */
	}
	
	function frontend_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$default['category'] 		= 'home1';
		$default['theme_path'] 	= FRONTEND_THEME.$this->frontend_default_theme.URL_SEPARATOR;
		$default['menus'] 			= $this->getFrontendMenu();
		$default['content'] 		= FRONTEND_THEME.$this->frontend_default_theme.URL_SEPARATOR.$content.'.tpl';
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(FRONTEND_THEME.$this->frontend_default_theme.URL_SEPARATOR.'index', array_merge($default, $data));
	}
	
	// function qr_view($content, $data)
	
	// NOT USING REST-API
	function _check_session()
	{
		
		return (object) $this->session->userdata();
	}
	
}