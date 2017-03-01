<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* THIS IS CLASS FOR BASE CONTROLLER (BACKEND) */
class Getmeb extends CI_Controller
{
	/* DEFAULT TEMPLATE */
	public $theme  	= 'adminlte';
	/* FOR REQUEST METHOD */
	public $r_method;	
	/* FOR CONTROLLER METHOD */
	public $c_method;
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	/* FOR STORE SESSION DATA */
	public $sess;
	
	/* FOR ADDITIONAL CRUD FIXED DATA */
	public $fixed_data = array();
	public $create_log = array();
	public $update_log = array();
	public $delete_log = array();
	
	/* FOR GETTING ERROR MESSAGE OR SUCCESS MESSAGE */
	public $messages = array();
	
	function __construct() {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, X-AUTH, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == "OPTIONS") {
			die();
		}
		
		parent::__construct();
		define('ASSET_URL', base_url().'/assets/');
		
		$this->sess = (object) $this->session->userdata();
		$this->lang->load('systems/genesys', (!empty($this->sess->language) ? $this->sess->language : 'english'));
		
		$this->fixed_data = [
			'client_id'		=> (!empty($this->sess->client_id) ? $this->sess->client_id : '0'),
			'org_id'			=> (!empty($this->sess->org_id) ? $this->sess->org_id : '0')
		];
		$this->create_log = [
			'created_by'	=> (!empty($this->sess->user_id) ? $this->sess->user_id : '0'),
			'created_at'	=> date('Y-m-d H:i:s')
		];
		$this->update_log = [
			'updated_by'	=> (!empty($this->sess->user_id) ? $this->sess->user_id : '0'),
			'updated_at'	=> date('Y-m-d H:i:s')
		];
		$this->delete_log = [
			'is_deleted'	=> 1,
			'deleted_by'	=> (!empty($this->sess->user_id) ? $this->sess->user_id : '0'),
			'deleted_at'	=> date('Y-m-d H:i:s')
		];
	}
	
	function _check_menu($data=[])
	{
		/* CHECK METHOD */
		if (empty($data['method'])) {
			$this->set_message('ERROR: Menu [method] is could not be empty !');
			return FALSE;
		}

		/* CHECK PATH FILE */
		if (!$this->_check_path($data['path'].URL_SEPARATOR.$data['method'])) {
			$this->set_message('ERROR: Menu [path] is could not be found or file not exist !');
			return FALSE;
		}
		
		/* CHECK CLASS/CONTROLLER */
		if (!$this->_check_class($data['class'])) {
			$this->set_message('ERROR: Menu [class] is could not be found or file not exist !');
			return FALSE;
		}
		
		return TRUE;
	}
	
	function _check_path($path)
	{
		return file_exists(APPPATH.'../templates/'.BACKEND_THEME.$this->theme.URL_SEPARATOR.$path.'.tpl') ? TRUE : FALSE;
	}
	
	function _check_class($class)
	{
		return file_exists(APPPATH.'modules/'.$class.'/controllers/'.$class.'.php') ? TRUE : FALSE;
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
	
	function _check_is_login()
	{
		return (bool)$this->session->userdata('user_id') ? TRUE : FALSE;
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
	
	function set_message($message)
	{
		$this->messages[] = $message;

		return $message;
	}

	function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			$messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
			$_output .= '<p>' . $messageLang . '</p>';
		}

		return $_output;
	}

	function insertRecord($table, $data)
	{
		$data = is_object($data) ? (array) $data : $data;
		
		if (!key_exists('id', $cond) && empty($cond['id'])) {
			$this->set_message('error_saving');
			return false;
		}
		
		$this->db->insert($table, $data);
		$return = $this->db->affected_rows() == 1;
		if ($return)
			// $this->set_message('update_data_successful');
			$this->set_message('success_saving');
		else
			$this->set_message('error_saving');
		
		return true;
	}
	
	function updateRecord($table, $data, $cond)
	{
		$data = is_object($data) ? (array) $data : $data;
		
		if (!key_exists('id', $cond) && empty($cond['id'])) {
			$this->set_message('update_data_unsuccessful');
			return false;
		}
		
		$this->db->update($table, $data, $cond);
		$return = $this->db->affected_rows() == 1;
		if ($return)
			// $this->set_message('update_data_successful');
			$this->set_message('success_update');
		else
			$this->set_message('update_data_unsuccessful');
		
		return true;
	}
	
	function deleteRecords($table, $ids)
	{
		$ids = array_filter(array_map('trim',explode(',',$ids)));
		$return = 0;
		foreach($ids as $v)
		{
			if ($this->db->update($table, $this->delete_log, ['id'=>$v]))
			{
				$return += 1;
			}
		}
		if ($return)
			$this->set_message('success_delete');
		else
			$this->set_message('delete_data_unsuccessful');
			
		return $return;
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
	
	function backend_view($page, $content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		if($page=='login')
		{
			$default['theme_path'] 	= BACKEND_THEME.$this->theme.URL_SEPARATOR;
			$default['elapsed_time']= $elapsed;
			$default['start_time'] 	= microtime(true);
			$this->fenomx->view(BACKEND_THEME.$this->theme.URL_SEPARATOR.$content, array_merge($default, $data));
			return;
		}

		if($page=='dashboard1' || $page=='dashboard2')
		{
			$default['category'] = $page;
			$default['dashboard'] = $this->system_model->getDashboardByRoleId($this->sess->role_id);
		}

		if($page=='crud')
		{
			$default['category'] = 'crud';
		}
		
		$default['theme_path'] 	= BACKEND_THEME.$this->theme.URL_SEPARATOR;
		$default['menus'] 		= $this->system_model->getMenuByRoleId($this->sess->role_id);
		$default['content'] 	= BACKEND_THEME.$this->theme.URL_SEPARATOR.$content.'.tpl';
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(BACKEND_THEME.$this->theme.URL_SEPARATOR.'index', array_merge($default, $data));
	}
	
}