<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Systems extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		/* Note: addition 4 method ['a_role_list','a_org_list','a_orgtrx_list','a_orgdept_list','a_orgdiv_list'] is for by pass authentication in user profile */
		$this->exception_method = ['x_forgot','x_reset','x_login','x_logout','x_reload','x_info','x_page','x_role_selector','a_menu_parent_list','a_org_parent_list','x_srcmenu','a_role_list','a_org_list','a_orgtrx_list','a_orgdept_list','a_orgdiv_list',];
		parent::__construct();
	}
	
	function index()
	{
		redirect(base_url().'systems/x_page?pageid=1');
	}
	
	function dashboard1()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->run) && $this->params->run) {
				$str = $this->base_model->getValue('query', 'a_dashboard', 'id', $this->params->id)->query;
				if ($str) {
					$str = translate_variable($str);
					
					if (!$qry = $this->db->query($str)) {
						$result['value'] = -1;
					} else {
						if ($qry->num_rows() > 0){
							$result = $qry->result();
						} else {
							$result['value'] = -1;
						}
						
						// if (count($qry->list_fields()) == 1) {
							// if ($qry->num_rows() == 1)
								// $result['value'] = array_values($qry->row_array());
							// else
								// $result['value'] = -1;
						// } else {
							// foreach($qry->result() as $k => $v){
								// $res[$v->key] = $v->val;
							// }
							// $result['value'] = $res;
						// }
					}
					xresponse(TRUE, ['data' => $result]);
				}
				xresponse(FALSE, []);
			}
			
			$this->params->list = 1;
			$this->params->where_custom[] = 'tags is null';
			// $this->params->where_custom[] = 'tags is not null';
			if (!$result = $this->{$this->mdl}->{$this->c_method}($this->params)){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				foreach($result as $key => $val){
					$result[$key]->value = 0;
					unset($result[$key]->query);
				}
				xresponse(TRUE, ['data' => $result]);
			}
		}
		// $this->backend_view('dashboard1', 'pages/dashboard/dashboard1');
		if ($this->r_method == 'POST') {
			if (isset($this->params->send_mail) && $this->params->send_mail) {
				// debug($this->params);
				if(! send_mail_systems($this->params->email_from, $this->params->email_to, $this->params->subject, $this->params->message)) {
					xresponse(FALSE, ['message' => $this->session->flashdata('message')]);
				}
				
				/* success */
				xresponse(TRUE, ['message' => 'Your email has been sent.']);
			}
		}
	}
	
	function va_server()
	{
		if ($this->params->event == 'pre_get'){
			$fdate = $this->params->fdate . ' 00:00:00';
			$tdate = $this->params->tdate . ' 23:59:59';
			
			/* line chart */
			if (date_differ($fdate, $tdate, 'day') < 1) {
				$str = "select to_char(i, 'Mon DD HH24:MI') || '-' || to_char(i + interval '1 hour', 'HH24:MI') as name, 
				(select count(*) from a_access_log where created_at >= i and created_at < i + interval '1 hour') as data 
				from generate_series('$fdate', '$tdate', interval '1 hour') i;";
			} else if (date_differ($fdate, $tdate, 'day') < 32) {
				$str = "select to_char(i.date, 'Mon DD') as name, 
				(select count(*) from a_access_log where to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD')) as data 
				from generate_series('$fdate', '$tdate', '1 day'::interval) i;";
			} else if (date_differ($fdate, $tdate, 'day') >= 32) {
				$str = "select to_char(i.date, 'Mon ''YY') as name, 
				(select count(*) from a_access_log where to_char(created_at, 'YYYY-MM-DD') between to_char(i.date, 'YYYY-MM-DD') and to_char(i.date + interval '1 month', 'YYYY-MM-DD')) as data 
				from generate_series('$fdate', '$tdate', '1 month'::interval) i;";
			}
			$qry = $this->db->query($str);
			if ($qry->num_rows() > 0) {
				$arr['labels'] = []; $arr['data'] = []; $arr['bgcolor'] = [];
				foreach($qry->result() as $row){
					$arr['labels'][] = $row->name;
					$arr['data'][] = $row->data;
				}
				$result['dataHits']['labels'] = $arr['labels'];
				$result['dataHits']['datasets'][] = ['label' => 'Hits', 'borderColor' => get_rgba(), 'data' => $arr['data']];
			}	
			
			/* total & avg */
			$str = "select count(*) as total, 
			(count(*) / coalesce(nullif(abs(round(EXTRACT(epoch FROM '$fdate'::timestamp - '$tdate'::timestamp)/3600)), 0), 1)) as avg_hour,
			(count(*) / coalesce(nullif(abs(round(EXTRACT(epoch FROM '$fdate'::timestamp - '$tdate'::timestamp)/86400)), 0), 1)) as avg_day, 
			(count(*) / coalesce(nullif(abs(round(EXTRACT(epoch FROM '$fdate'::timestamp - '$tdate'::timestamp)/604800)), 0), 1)) as avg_week,
			(count(*) / coalesce(nullif(abs(round(EXTRACT(epoch FROM '$fdate'::timestamp - '$tdate'::timestamp)/2592000)), 0), 1)) as avg_month
			from a_access_log where created_at between '$fdate' and '$tdate';";
			$row = $this->db->query($str)->row();
			$result['data']['total'] = $row->total;
			$result['data']['avg_hour'] = $row->avg_hour;
			$result['data']['avg_day'] = $row->avg_day;
			$result['data']['avg_week'] = $row->avg_week;
			$result['data']['avg_month'] = $row->avg_month;

			/* method */
			$str = "select method as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['method'] = $qry->result();
			/* method (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['method_chart']['labels'] = $arr['labels'];
			$result['data']['method_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* domain/host */
			$str = "select host as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['domain'] = $qry->result();
			/* domain/host (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['domain_chart']['labels'] = $arr['labels'];
			$result['data']['domain_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* country */
			$str = "select coalesce(country, 'unknown') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['country'] = $qry->result();
			/* country (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['country_chart']['labels'] = $arr['labels'];
			$result['data']['country_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* city */
			$str = "select coalesce(city, 'unknown') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['city'] = $qry->result();
			/* city (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['city_chart']['labels'] = $arr['labels'];
			$result['data']['city_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* FOR SYSTEMS============================= */
			/* platform/os */
			$str = "select platform as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = false and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['os'] = $qry->result();
			/* platform/os (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['os_chart']['labels'] = $arr['labels'];
			$result['data']['os_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* browser */
			$str = "select browser as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = false and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['browser'] = $qry->result();
			/* browser (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['browser_chart']['labels'] = $arr['labels'];
			$result['data']['browser_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* screen_res */
			$str = "select width ||'x'|| height as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = false and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['screen_res'] = $qry->result();
			/* screen_res (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['screen_res_chart']['labels'] = $arr['labels'];
			$result['data']['screen_res_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* isp */
			$str = "select coalesce(isp, 'unknown') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = false and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['isp'] = $qry->result();
			/* isp (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['isp_chart']['labels'] = $arr['labels'];
			$result['data']['isp_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* FOR MOBILE============================= */
			/* platform/os */
			$str = "select platform as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = true and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['m_os'] = $qry->result();
			/* platform/os (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['m_os_chart']['labels'] = $arr['labels'];
			$result['data']['m_os_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* browser */
			$str = "select browser as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = true and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['m_browser'] = $qry->result();
			/* browser (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['m_browser_chart']['labels'] = $arr['labels'];
			$result['data']['m_browser_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* screen_res */
			$str = "select width ||'x'|| height as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = true and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['m_screen_res'] = $qry->result();
			/* screen_res (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['m_screen_res_chart']['labels'] = $arr['labels'];
			$result['data']['m_screen_res_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			/* isp */
			$str = "select coalesce(isp, 'unknown') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from a_access_log where is_mobile = true and created_at between '$fdate' and '$tdate' group by 1 order by 2 desc";
			$qry = $this->db->query($str);
			$result['data']['m_isp'] = $qry->result();
			/* isp (Chart) */
			$arr['labels'] = []; $arr['data1'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->count;
				$arr['color'][] = get_rgba();
			}
			$result['data']['m_isp_chart']['labels'] = $arr['labels'];
			$result['data']['m_isp_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
			// xresponse(FALSE, ['message' => 'Failure !']);
			
			xresponse(TRUE, $result);
			// debug($result);
			// debug($this->params);
		}
	}
	
	function x_forgot()
	{
		$this->single_view('pages/systems/auth/forgot');
	}
	
	function x_reset()
	{
		$this->load->library('z_auth/auth');
		
		/* This line for validating forgot code */
		if (isset($this->params->code) && $this->params->code) {
			/* Checking forgotten code */
			if (($user = $this->auth->forgotten_password_complete($this->params->code)) === FALSE ) {
				$this->session->set_flashdata('message', '<b>'.$this->auth->errors().'</b>');
				redirect(BASE_URL.'frontend/not_found');
			}
			
			/* Goto reset page */
			$this->single_view('pages/systems/auth/reset', is_array($user) ? $user : (array)$user);
		}
	}
	
	function x_auth()
	{
		$this->load->library('z_auth/auth');
		
		/* This line for processing forgot password */
		if (isset($this->params->forgot) && $this->params->forgot) {
			//run the forgotten password method to email an activation code to the user
			if (($user = $this->auth->forgotten_password($this->params->email)) === FALSE){
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($this->params->email, 'Email Not Registered/Intruder Detected');
				
				xresponse(FALSE, ['message' => $this->auth->errors()]);
			}
			
			/* Trying to sending email */
			$body = "Hai ".$user->name.", <br><br>";
			$body .= "This is your Reset Password Link Address : <br><br>".RESET_LNK."?code=".$user->forgotten_password_code."<br><br>";
			$body .= "Please click link above for reset your password.<br><br>";
			$body .= "Warning: This link is valid about 1 hour, start from your received this email, and can be use only one time.<br><br>";
			$body .= "Thank you,<br><br>";
			$body .= "System.";
			$message = $body;
			if($result = send_mail_systems(NULL, $user->email, 'Your Reset Password Link', $message) !== TRUE) {
				$this->{$this->mdl}->_save_useragent($this->params->email, 'Forgot Password: Reset Link failed delivered !', $this->session->flashdata('message'));
				xresponse(FALSE, ['message' => $this->session->flashdata('message')]);
			}
			
			/* Trapping user_agent, ip address & status */
			$this->{$this->mdl}->_save_useragent($this->params->email, 'Forgot Password: Reset Link succeeded delivered !');
		
			/* success */
			xresponse(TRUE, ['message' => 'The link for reset your password has been sent to your email.']);
		}
		
		/* This line for processing reset password */
		if (isset($this->params->reset) && $this->params->reset) {
			
			/* Check code for expiration */
			if (($user = $this->auth->forgotten_password_complete($this->params->code)) === FALSE ) {
				xresponse(FALSE, ['message' => $this->auth->errors()]);
			}
			
			$http_auth = $this->input->server('HTTP_X_AUTH');
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}
			
			/* Reset Password*/
			if (($user_id = $this->auth->reset_password($username, $password)) === FALSE ) {
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($username, 'Reset Password Failed');
				
				xresponse(FALSE, ['message' => $this->auth->errors()]);
			}
			
			/* Remove forgotten_password_code & forgotten_password_time */
			$this->auth->forgotten_password_remove($user_id);
			
			/* Trapping user_agent, ip address & status */
			$this->{$this->mdl}->_save_useragent($username, 'Reset Password Success');
		
			/* Store configuration to session */
			$this->{$this->mdl}->_store_config($user_id);
			
			$url = APPS_LNK;
			xresponse(TRUE, ['message' => $this->auth->messages(), 'url' => $url]);
		}
		
		/* This line for authentication login page */
		if (isset($this->params->login) && $this->params->login) {
			$http_auth 	= $this->input->server('HTTP_X_AUTH');
			// debug(filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE));
			// debug($_SERVER['REMOTE_ADDR'].'-'.$_SERVER['SERVER_ADDR']);
			// debug((! in_array($_SERVER['REMOTE_ADDR'], ['::1','127.0.0.1']) && ! is_private_ip($_SERVER['REMOTE_ADDR'])));
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			} else {
				$username = $_SERVER['PHP_AUTH_USER'];
				$password = $_SERVER['PHP_AUTH_PW'];
			}

			$username = strtolower($username);
			$rememberme = isset($this->params->rememberme) && $this->params->rememberme ? TRUE : FALSE;
			/* Try to login */
			if (! $user_id = $this->auth->login($username, $password, $rememberme)) {
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($username, 'Login Failed/Intruder Detected');
				
				xresponse(FALSE, ['message' => $this->auth->errors()]);
			}

			/* Trapping user_agent, ip address & status */
			$this->{$this->mdl}->_save_useragent($username, 'Login Success');
			
			/* Store configuration to session */
			$this->{$this->mdl}->_store_config($user_id);
			
			$url = $this->session->referred_index == $this->params->current_url ? APPS_LNK : $this->session->referred_index;
			$url = $url ? $url : APPS_LNK;
			xresponse(TRUE, ['message' => 'Login Success !', 'url' => $url]);
		}

		/* This line for unlock the screen */
		if (isset($this->params->unlock) && $this->params->unlock) {
			$this->_check_is_login();
			// xresponse(FALSE, ['message' => 'testing']);
			$http_auth 	= $this->input->server('HTTP_X_AUTH');
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}
			
			/* Try to unlock/login */
			if (! $this->auth->login($username, $password))
			{
				/* Trapping user_agent, ip address & status */
				$this->{$this->mdl}->_save_useragent($username, 'Unlock Failed/Intruder Detected');
				
				xresponse(FALSE, ['message' => $this->auth->errors()]);
			}
			
			xresponse(TRUE);
		}
	}
	
	/* Re-Store configuration to session */
	function x_reload()
	{
		if ($this->session->user_id) {
			$this->{$this->mdl}->_store_config($this->session->user_id);
		
			xresponse(TRUE);
		}
		redirect(LOGIN_LNK);
	}
	
	function x_chgpwd()
	{
		if ($this->params->event == 'pre_get'){
			$this->params->where['t1.id'] = $this->session->user_id;
			
			if (($result['data'] = $this->{$this->mdl}->a_user($this->params)) === FALSE){
				xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				xresponse(TRUE, $result);
			}
		}
		if ($this->r_method == 'PUT') {
			$this->load->library('z_auth/auth');
			$http_auth 	= $this->input->server('HTTP_X_AUTH');
			
			if ($http_auth !== NULL)
			{
				if (strpos(strtolower($http_auth), 'basic') === 0)
				{
					list($username, $password) = explode(':', base64_decode(substr($http_auth, 6)));
				}
			}
			if (! $this->auth->change_password($username, $password, $this->params->password_new))
			{
				xresponse(FALSE, ['message' => $this->auth->errors()]);
			}

			xresponse(TRUE, ['message' => $this->auth->messages()]);
		}
	}
	
	function x_login()
	{
		$this->single_view('pages/systems/auth/login');
	}
	
	function x_logout()
	{
		/* Set offline to table user */
		$this->db->update('a_user', ['is_online' => '0', 'heartbeat' => null], ['id' => $this->session->user_id]);
		/* Destroy the session */
		$this->session->sess_destroy();

		redirect(LOGIN_LNK);
	}
	
	// REQUIRED LOGIN
	function x_srcmenu()
	{
		if (isset($this->params->q) && $this->params->q) 
			$this->params->like	= DBX::like_or('t2.name', $this->params->q);
			
		$this->params->where['t1.role_id']	= $this->session->role_id;
		$this->params->where['t2.is_active']	= '1';
		$this->params->where['t1.is_active']	= '1';
		$this->params->where['t2.is_parent']	= '0';
		$this->params->where['t2.is_submodule']	= '0';
		$this->params->order = "t2.name";
		$this->params->list	= 1;
		$result['data'] = $this->{$this->mdl}->a_role_menu($this->params);
		xresponse(TRUE, $result);
	}
	
	function x_profile($mode=NULL)
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->view) && $this->params->view) {
				$this->params->where['t1.id'] = $this->session->user_id;
				if (($result['data'] = $this->{$this->mdl}->a_user($this->params)) === FALSE){
					$result['data'] = [];
					$result['message'] = $this->base_model->errors();
					xresponse(FALSE, $result);
				} else {
					xresponse(TRUE, $result);
				}
			}
		}
		
		if ($this->r_method == 'PUT') {
			/* This line is for update default user role & user org */
			if (isset($this->params->change_user_role) && !empty($this->params->change_user_role)) {
				$this->_record_mixing_data('a_user', FALSE, FALSE);
				// debug($this->mixed_data);
				if (! $this->_recordUpdate('a_user', $this->mixed_data, ['id' => $this->session->user_id], FALSE))
					xresponse(FALSE, ['message' => $this->session->flashdata('message')]);

				xresponse(TRUE, ['message' => lang('success_saving')]);
			}
			
			/* This line is for update user info */
			if (isset($this->params->update_user_profile) && !empty($this->params->update_user_profile)) {
				$this->_record_mixing_data('a_user', FALSE, TRUE);
				if (! $this->_recordUpdate('a_user', $this->mixed_data, ['id' => $this->session->user_id], FALSE))
					xresponse(FALSE, ['message' => $this->session->flashdata('message')]);

				xresponse(TRUE, ['message' => lang('success_saving')]);
			}
			
			/* This line is for update user config */
			if (isset($this->params->update_user_config) && !empty($this->params->update_user_config)) {
				$result = [];
				foreach($this->params as $k => $v) {
					$data['value'] 		 = $v;
					$cond['attribute'] = $k;
					$cond['user_id'] 	 = $this->session->user_id;
					
					/* update to session */
					$this->session->set_userdata([$k => $v]);
					/* update config to database */
					$qry = $this->db->get_where('a_user_config', $cond, 1);
					if ($qry->num_rows() > 0) {
						if (!$this->_recordUpdate('a_user_config', $data, $cond, TRUE))
							$result[$k] = $this->messages();	// Trapping error
					} else {
						if (!$this->_recordInsert('a_user_config', array_merge($data, $cond), FALSE, TRUE))
							$result[$k] = $this->messages();	// Trapping error
					}
				}
				if (count($result) > 0) {
					xresponse(FALSE, ['message' => $result]);
				} else {
					xresponse(TRUE, ['message' => lang('success_saving')]);
				}
			}
		}
		
		if ($this->r_method == 'POST') {
			/* This process is for Upload Photo */
			if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
				if (isset($this->params->id) && $this->params->id) {
					
					if (!$result = $this->_upload_file()){
						xresponse(FALSE, ['message' => $this->messages()]);
					}
						
					/* If Success */
					/* Create random filename */
					$this->load->helper('string');
					$rndName = random_string('alnum', 10);
					
					/* Moving to desire location with rename */
					$ext = strtolower(pathinfo($result['name'], PATHINFO_EXTENSION));
					$new_filename = $this->session->user_photo_path.$rndName.'.'.$ext;
					if (!is_dir($this->session->user_photo_path))
						mkdir($this->session->user_photo_path, 0755, true);
					rename($result["path"], $new_filename);
				
					/* delete old file photo */
					$tbl = $this->base_model->getValue('photo_file', 'a_user', 'id', $this->params->id);
					if ($tbl && $tbl->photo_file) {
						@unlink($this->session->user_photo_path.$tbl->photo_file);
					}
					// /* delete old file photo */
					// if (isset($this->params->photo_file) && $this->params->photo_file) {
						// @unlink($this->session->user_photo_path.$this->params->photo_file);
					// }
					/* update to table */
					$this->_recordUpdate('a_user', ['photo_file'=>$rndName.'.'.$ext], ['id' => $this->params->id]);
					xresponse(TRUE, ['message' => lang('success_saving'), 'file_url' => base_url().$this->session->user_photo_path.$rndName.'.'.$ext, 'photo_file' => $rndName.'.'.$ext]);
				}
			}
		}
		
		$this->backend_view('pages/systems/x_profile');
	}
	
	function x_info()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);

			if (key_exists('valid', $this->params) && ($this->params->valid)) {
				$this->params->where['is_active'] = '1';
				$this->params->where['valid_from <='] = date('Y-m-d H:i:s');
				$this->params->where_custom[] = $this->session->org_id . " = ANY (valid_org)";
				$this->params->where_custom[] = $this->session->orgtrx_id . " = ANY (valid_orgtrx)";
				$this->params->where_custom[] = "(valid_till >= '". date('Y-m-d H:i:s') ."' or valid_till is null)";
			}
			
			if (isset($this->params->pageid) && ($this->params->pageid)) {
				$this->params->where_custom[] = @end(explode(',',$this->params->pageid)) . " = ANY (valid_menu)";
			}
			
			$this->params->sort = 'seq';
			$this->{$this->mdl}->a_info($this->params);
		}
	}
	
	/*
	*		x_page?pageid=19
	*/
	function x_page()
	{
		if (isset($this->params->pageid) && !empty($this->params->pageid)) {
			
			if (! $menu = $this->_check_is_allow('html'))
				$menu = array();
			
			/* For getting breadcrumb */
			$this->params->bread = [];
			if ($qry = $this->db->where_in('id', explode(',', $this->params->pageid))->order_by('id')->get('a_menu')) {
				$menus = $qry->result();
				for($i = 0; $i < count($menus); $i++){
					$link = 'javascript:history.go(-'.(count($menus)-$i).')';
					$title = $menus[$i]->title;
					
					/* Menu only one and also the first menu */
					if (count($menus) == 1 && $i+1 == 1)
						$link = '';

					/* Last menu on bc */
					if (count($menus) == $i+1) {
						if (isset($this->params->action) && $this->params->action == 'imp'){
							$link = 'javascript:history.go(-'.(count($menus)-$i).')';
							$title = $menus[$i]->title;
							$bc[] = ['pageid' => $menus[$i]->id, 'icon' => $menus[$i]->icon, 'title' => $title, 'title_desc' => $menus[$i]->title_desc, 'link' => $link];
						}
						if (isset($this->params->action) && $this->params->action == 'exp'){
							$link = 'javascript:history.go(-'.(count($menus)-$i).')';
							$title = $menus[$i]->title;
							$bc[] = ['pageid' => $menus[$i]->id, 'icon' => $menus[$i]->icon, 'title' => $title, 'title_desc' => $menus[$i]->title_desc, 'link' => $link];
						}
						$link = ''; 
						$actions = ['new'=>'(New)', 'edt'=>'(Edit)', 'cpy'=>'(Copy)', 'imp'=>'(Import)', 'exp'=>'(Export)'];
						$act_name = isset($this->params->action) && isset($actions[$this->params->action]) ? ' '.$actions[$this->params->action] : '';
						$title = $menus[$i]->title.$act_name;
					}
					$bc[] = ['pageid' => $menus[$i]->id, 'icon' => $menus[$i]->icon, 'title' => $title, 'title_desc' => $menus[$i]->title_desc, 'link' => $link];
				}
				$this->params->bread = isset($bc) ? $bc : array();
			}
			
			/* For identify opened table to client (property for auto reload event) */
			if ($menu)
				setcookie('table', $menu['table']);
			
			if (isset($this->params->bread) && count($this->params->bread) >= 0)
				$menu = array_merge($menu, ['bread' => $this->params->bread]);
			
			
			/* Check for action pages */
			if (isset($this->params->action) && !empty($this->params->action)){
				switch($this->params->action) {
					case 'new': 
					case 'cpy': 
					case 'edt': 
						if (! $this->_check_path($menu['path'].$menu['method'].'_edit'))
							$this->backend_view('pages/404', ['message'=>'']);
						
						$this->backend_view($menu['path'].$menu['method'].'_edit', $menu);
						break;
					case 'exp':
						$this->backend_view('include/export_data',$menu);
						break;
					case 'imp':
						$this->backend_view('include/import_data', $menu);
						break;
					case 'prc':
						$this->backend_view($menu['path'].$menu['method'], $menu);
						break;
					default:
						$this->backend_view('pages/404', ['message'=>'']);
				}
			}
			/* Checking the menu existance */
			if (! $this->_check_menu($menu))
				$this->backend_view('pages/404', ['message'=>$this->messages()]);
			/* Standard page */
			$this->backend_view($menu['path'].$menu['method'], $menu);
		}
		$this->backend_view('pages/404', ['message'=>'']);
	}
	
	function x_role_selector()
	{
		if ($this->r_method == 'PATCH') {
			if (isset($this->params->identify) && !empty($this->params->identify)) {
				unset($this->params->identify);
				// debug($this->params);
				
				$result = $this->_recordUpdate('a_user', $this->params, ['id'=>$this->session->user_id], FALSE);
				
				if (! $result)
					xresponse(FALSE, ['message' => $this->messages()]);

				xresponse(TRUE, ['message' => $this->messages()]);
			}
		}
	}
	
	function a_user_reset_login_attempt()
	{
		if ($this->r_method == 'OPTIONS') {
			
			if (isset($this->params->id) && !empty($this->params->id)) {
				/* clear loggin attempt */
				if (! $this->_recordDelete('a_loginattempt', $this->params->id, TRUE))
					xresponse(FALSE, ['message' => $this->messages()]);
				else
					xresponse(TRUE, ['message' => lang('success_rla')]);
			}
			xresponse(FALSE, ['message' => '']);
		}
	}
	
	function a_user_create_api_key()
	{
		if ($this->r_method == 'OPTIONS') {
			
			if (isset($this->params->id) && !empty($this->params->id)) {
				/* create api key */
				if (! $this->db->update($this->c_table, ['api_token' => create_api_key()], ['id' => $this->params->id]))
					xresponse(FALSE, ['message' => $this->db->error()['message']]);
				else 
					xresponse(TRUE, ['message' => lang('success_create_api_key')]);
			}
			xresponse(FALSE, ['message' => '']);
		}
	}
	
	/* Don't make example from a_user & a_role */
	function a_user()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->export) && !empty($this->params->export)) {
				$this->protected_fields = ['user_org_id','user_role_id','api_token','password','salt','remember_token','is_online','forgotten_password_code','forgotten_password_time','ip_address','photo_file'];
			}
		}
		if ($this->r_method == 'POST') {
			if ($this->params->event == 'pre_post'){
			
				/* This process is for Upload Photo */
				if (isset($this->params->userphoto) && !empty($this->params->userphoto)) {
					if (isset($this->params->id) && $this->params->id) {
						if (!$result = $this->_upload_file()){
							xresponse(FALSE, ['message' => $this->messages()]);
						}
							
						/* If picture success upload to tmp folder */
						/* Create random filename */
						$this->load->helper('string');
						$rndName = random_string('alnum', 10);
						
						/* Moving to desire location with rename */
						$ext = strtolower(pathinfo($result['name'], PATHINFO_EXTENSION));
						$new_filename = $this->session->user_photo_path.$rndName.'.'.$ext;
						if (!is_dir($this->session->user_photo_path))
							mkdir($this->session->user_photo_path, 0755, true);
						rename($result["path"], $new_filename);
					
						/* delete old file photo */
						$tbl = $this->base_model->getValue('photo_file', $this->c_method, 'id', $this->params->id);
						if ($tbl && $tbl->photo_file) {
							@unlink($this->session->user_photo_path.$tbl->photo_file);
						}
						// if (isset($this->params->photo_file) && $this->params->photo_file) {
							// @unlink($this->session->user_photo_path.$this->params->photo_file);
						// }
						/* update to table */
						$this->_recordUpdate($this->c_method, ['photo_file'=>$rndName.'.'.$ext], ['id' => $this->params->id]);
						xresponse(TRUE, ['message' => lang('success_saving'), 'file_url' => base_url().$this->session->user_photo_path.$rndName.'.'.$ext, 'photo_file' => $rndName.'.'.$ext]);
					}
				}
				
				$this->load->library('z_auth/auth');
				if (! $id = $this->auth->register($this->params->name, $this->params->password, $this->params->email, array_merge($this->fixed_data, $this->create_log)))
					xresponse(FALSE, ['message' => $this->auth->errors()]);

				/* create avatar image */
				$data = ['word'=>$this->params->name[0], 'img_path'=>$this->session->user_photo_path, 'img_url'=> base_url().$this->session->user_photo_path];
				$data = create_avatar_img($data);
				if ($data) {
					$this->_recordUpdate($this->c_method, ['photo_file'=>$data['filename']], ['id' => $id]);
				}
				
				xresponse(TRUE, ['id' => $id, 'message' => lang('success_saving')]);
			}			
		}
		if ($this->r_method == 'PUT') {
			if ($this->params->event == 'pre_put'){
				/* Reset Password*/
				if (isset($this->params->password) && ($this->params->password != '')) {
					$this->load->library('z_auth/auth');
					$this->auth->reset_password($this->params->name, $this->params->password);
				}
				unset($this->mixed_data['password']);
			}
		}
	}
	
	function a_user_org()
	{
		$this->identity_keys = ['user_id', 'org_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['(select code from a_org where id = t1.org_id)','(select name from a_org where id = t1.org_id)',], TRUE);

			$this->params->where['orgtype_id'] = 2;
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->set_default) && !empty($this->params->set_default)) {
				// debug($this->params);
				$result = $this->_recordUpdate('a_user', ['user_org_id' => $this->params->org_id], ['id'=>$this->params->user_id]);
				
				/* Throwing the result to Ajax */
				if (! $result)
					xresponse(FALSE, ['message' => $this->messages()]);

				xresponse(TRUE, ['message' => $this->messages()]);
			}
			
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['org_id'] = $this->params->org_id;
				$this->mixed_data['orgtype_id'] = 2;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'pre_delete'){
				$str = "with recursive tbl AS (
				select id, user_id, org_id, orgtype_id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id, cld.user_id, cld.org_id, cld.orgtype_id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) select id, user_id, org_id, orgtype_id from tbl";
				if ($qry = $this->db->query($str)){
					foreach($qry->result() as $row){
						if ($row->orgtype_id == 2)
							$str = "update a_user set user_org_id = NULL where id = ".$row->user_id." and user_org_id = ".$row->org_id;
						else if ($row->orgtype_id == 3)
							$str = "update a_user set user_orgtrx_id = NULL where id = ".$row->user_id." and user_orgtrx_id = ".$row->org_id;
						else if ($row->orgtype_id == 4)
							$str = "update a_user set user_orgdept_id = NULL where id = ".$row->user_id." and user_orgdept_id = ".$row->org_id;
						else if ($row->orgtype_id == 5)
							$str = "update a_user set user_orgdiv_id = NULL where id = ".$row->user_id." and user_orgdiv_id = ".$row->org_id;
						
						$this->db->query($str);
					}
				}
			}
			if ($this->params->event == 'post_delete'){
				$str = "with recursive tbl AS (
				select id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) update a_user_org set is_deleted = '1', deleted_by = ".$this->session->user_id.", deleted_at = '".date('Y-m-d H:i:s')."' where id in (select id from tbl)";
				$this->db->query($str);
			}
		}
	}
	
	function a_user_orgtrx()
	{
		$this->identity_keys = ['user_id', 'org_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['(select code from a_org where id = t1.org_id)','(select name from a_org where id = t1.org_id)',], TRUE);

			/* For getting org_id in a_user_orgtrx.tpl */
			if (isset($this->params->get_org_id) && !empty($this->params->get_org_id)) {
				$row = $this->base_model->getValue('user_id, org_id', 'a_user_org', 'id', $this->params->parent_id);
				xresponse(TRUE, ['data'=>$row]);
			}
			
			if (isset($this->params->parent_org_id) && !empty($this->params->parent_org_id)) {
				$this->params->where['parent_org_id'] = $this->params->parent_org_id;
			}
			
			$this->params->where['orgtype_id'] = 3;
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->set_default) && !empty($this->params->set_default)) {
				$result = $this->_recordUpdate('a_user', ['user_orgtrx_id' => $this->params->org_id], ['id'=>$this->params->user_id]);
				
				/* Throwing the result to Ajax */
				if (! $result)
					xresponse(FALSE, ['message' => $this->messages()]);

				xresponse(TRUE, ['message' => $this->messages()]);
			}
			
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['org_id'] = $this->params->org_id;
				$this->mixed_data['orgtype_id'] = 3;
				$this->mixed_data['parent_org_id'] = $this->base_model->getValue('org_id', 'a_user_org', 'id', $this->params->parent_id)->org_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'pre_delete'){
				$str = "with recursive tbl AS (
				select id, user_id, org_id, orgtype_id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id, cld.user_id, cld.org_id, cld.orgtype_id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) select id, user_id, org_id, orgtype_id from tbl";
				if ($qry = $this->db->query($str)){
					foreach($qry->result() as $row){
						if ($row->orgtype_id == 2)
							$str = "update a_user set user_org_id = NULL where id = ".$row->user_id." and user_org_id = ".$row->org_id;
						else if ($row->orgtype_id == 3)
							$str = "update a_user set user_orgtrx_id = NULL where id = ".$row->user_id." and user_orgtrx_id = ".$row->org_id;
						else if ($row->orgtype_id == 4)
							$str = "update a_user set user_orgdept_id = NULL where id = ".$row->user_id." and user_orgdept_id = ".$row->org_id;
						else if ($row->orgtype_id == 5)
							$str = "update a_user set user_orgdiv_id = NULL where id = ".$row->user_id." and user_orgdiv_id = ".$row->org_id;
						
						$this->db->query($str);
					}
				}
			}
			if ($this->params->event == 'post_delete'){
				$str = "with recursive tbl AS (
				select id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) update a_user_org set is_deleted = '1', deleted_by = ".$this->session->user_id.", deleted_at = '".date('Y-m-d H:i:s')."' where id in (select id from tbl)";
				$this->db->query($str);
			}
		}
	}
	
	function a_user_orgdept()
	{
		$this->identity_keys = ['user_id', 'org_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['(select code from a_org where id = t1.org_id)','(select name from a_org where id = t1.org_id)',], TRUE);

			/* For getting org_id in a_user_orgdept.tpl */
			if (isset($this->params->get_org_id) && !empty($this->params->get_org_id)) {
				$row = $this->base_model->getValue('user_id, org_id', 'a_user_org', 'id', $this->params->parent_id);
				xresponse(TRUE, ['data'=>$row]);
			}
			
			$this->params->where['orgtype_id'] = 4;
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->set_default) && !empty($this->params->set_default)) {
				$result = $this->_recordUpdate('a_user', ['user_orgdept_id' => $this->params->org_id], ['id'=>$this->params->user_id]);
				
				/* Throwing the result to Ajax */
				if (! $result)
					xresponse(FALSE, ['message' => $this->messages()]);

				xresponse(TRUE, ['message' => $this->messages()]);
			}
			
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['org_id'] = $this->params->org_id;
				$this->mixed_data['orgtype_id'] = 4;
				$this->mixed_data['parent_org_id'] = $this->base_model->getValue('org_id', 'a_user_org', 'id', $this->params->parent_id)->org_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'pre_delete'){
				$str = "with recursive tbl AS (
				select id, user_id, org_id, orgtype_id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id, cld.user_id, cld.org_id, cld.orgtype_id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) select id, user_id, org_id, orgtype_id from tbl";
				if ($qry = $this->db->query($str)){
					foreach($qry->result() as $row){
						if ($row->orgtype_id == 2)
							$str = "update a_user set user_org_id = NULL where id = ".$row->user_id." and user_org_id = ".$row->org_id;
						else if ($row->orgtype_id == 3)
							$str = "update a_user set user_orgtrx_id = NULL where id = ".$row->user_id." and user_orgtrx_id = ".$row->org_id;
						else if ($row->orgtype_id == 4)
							$str = "update a_user set user_orgdept_id = NULL where id = ".$row->user_id." and user_orgdept_id = ".$row->org_id;
						else if ($row->orgtype_id == 5)
							$str = "update a_user set user_orgdiv_id = NULL where id = ".$row->user_id." and user_orgdiv_id = ".$row->org_id;
						
						$this->db->query($str);
					}
				}
			}
			if ($this->params->event == 'post_delete'){
				$str = "with recursive tbl AS (
				select id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) update a_user_org set is_deleted = '1', deleted_by = ".$this->session->user_id.", deleted_at = '".date('Y-m-d H:i:s')."' where id in (select id from tbl)";
				$this->db->query($str);
			}
		}
	}
	
	function a_user_orgdiv()
	{
		$this->identity_keys = ['user_id', 'org_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['(select code from a_org where id = t1.org_id)','(select name from a_org where id = t1.org_id)',], TRUE);

			/* For getting org_id in a_user_orgdiv.tpl */
			if (isset($this->params->get_org_id) && !empty($this->params->get_org_id)) {
				$row = $this->base_model->getValue('user_id, org_id', 'a_user_org', 'id', $this->params->parent_id);
				xresponse(TRUE, ['data'=>$row]);
			}
			
			$this->params->where['orgtype_id'] = 5;
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->set_default) && !empty($this->params->set_default)) {
				$result = $this->_recordUpdate('a_user', ['user_orgdiv_id' => $this->params->org_id], ['id'=>$this->params->user_id]);
				
				/* Throwing the result to Ajax */
				if (! $result)
					xresponse(FALSE, ['message' => $this->messages()]);

				xresponse(TRUE, ['message' => $this->messages()]);
			}
			
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['org_id'] = $this->params->org_id;
				$this->mixed_data['orgtype_id'] = 5;
				$this->mixed_data['parent_org_id'] = $this->base_model->getValue('org_id', 'a_user_org', 'id', $this->params->parent_id)->org_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'pre_delete'){
				$str = "with recursive tbl AS (
				select id, user_id, org_id, orgtype_id from a_user_org where id in (".$this->params->id.")
				union all
				select cld.id, cld.user_id, cld.org_id, cld.orgtype_id from a_user_org cld join tbl on tbl.id = cld.parent_id
				) select id, user_id, org_id, orgtype_id from tbl";
				if ($qry = $this->db->query($str)){
					foreach($qry->result() as $row){
						if ($row->orgtype_id == 2)
							$str = "update a_user set user_org_id = NULL where id = ".$row->user_id." and user_org_id = ".$row->org_id;
						else if ($row->orgtype_id == 3)
							$str = "update a_user set user_orgtrx_id = NULL where id = ".$row->user_id." and user_orgtrx_id = ".$row->org_id;
						else if ($row->orgtype_id == 4)
							$str = "update a_user set user_orgdept_id = NULL where id = ".$row->user_id." and user_orgdept_id = ".$row->org_id;
						else if ($row->orgtype_id == 5)
							$str = "update a_user set user_orgdiv_id = NULL where id = ".$row->user_id." and user_orgdiv_id = ".$row->org_id;
						
						$this->db->query($str);
					}
				}
			}
		}
	}
	
	function a_user_role()
	{
		$this->identity_keys = ['user_id', 'role_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['(select code from a_role where id = t1.role_id)','(select name from a_role where id = t1.role_id)',], TRUE);
		}
		if ($this->r_method == 'PUT') {
			
			if (isset($this->params->set_default) && !empty($this->params->set_default)) {
				$result = $this->_recordUpdate('a_user', ['user_role_id' => $this->params->role_id], ['id'=>$this->params->user_id]);
				
				/* Throwing the result to Ajax */
				if (! $result)
					xresponse(FALSE, ['message' => $this->messages()]);

				xresponse(TRUE, ['message' => $this->messages()]);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'pre_delete'){
				foreach(explode(',', $this->params->id) as $id) {
					$user_role = $this->base_model->getValue('user_id, role_id', 'a_user_role', 'id', $id);
					$str = "update a_user set user_role_id = NULL where id = ".$user_role->user_id." and user_role_id = ".$user_role->role_id;
					$this->db->query($str);
				}
			}
		}
	}
	
	function a_user_substitute()
	{
		$this->identity_keys = ['user_id', 'substitute_id'];
		
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (key_exists('user_id', $this->params) && ($this->params->user_id != '')) 
				$this->params->where['t1.user_id'] = $this->params->user_id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name, t1.description', $this->params->q);

		}
	}
	
	function a_user_config()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->user_id) && ($this->params->user_id !== '')) 
				$user_id = $this->params->user_id;
			else
				$user_id = $this->session->user_id;
			
			$user_config = $this->base_model->getValue('attribute, value', 'a_user_config', 'user_id', $user_id);
			if ($user_config) {
				$userconfig = [];
				foreach($user_config as $k => $v) {
					$userconfig[$v->attribute] = $v->value;
				}
			}
			$userconfig = ($user_config===FALSE) ? [] : $userconfig;
			$result['data'] = $userconfig;
			xresponse(TRUE, $result);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if (isset($this->params->profile) && $this->params->profile) {
				/* update to session */
				$this->session->set_userdata([$this->params->name => $this->params->value]);
				/* update config to database */
				$data['value'] 		 = $this->params->value;
				$cond['attribute'] = $this->params->name;
				$cond['user_id'] 	 = $this->session->user_id;
				
				$qry = $this->db->get_where($this->c_method, $cond, 1);
				if ($qry->num_rows() > 0) {
					if (!$this->_recordUpdate($this->c_method, $data, $cond, TRUE))
						xresponse(FALSE, ['message' => $this->messages()]);
				} else {
					if (! $this->_recordInsert($this->c_method, array_merge($data, $cond), FALSE, TRUE))
						xresponse(FALSE, ['message' => $this->messages()]);
				}
				xresponse(TRUE, ['message' => lang('success_saving')]);
			}
			
			$result = [];
			foreach($this->params as $k => $v) {
				$data['value'] 		 = $v;
				$cond['attribute'] = $k;
				$cond['user_id'] 	 = $this->session->user_id;
				
				$qry = $this->db->get_where($this->c_method, $cond, 1);
				if ($qry->num_rows() > 0) {
					if (!$this->_recordUpdate($this->c_method, $data, $cond, TRUE))
						$result[$k] = $this->messages();
				} else {
					if (!$this->_recordInsert($this->c_method, array_merge($data, $cond), FALSE, TRUE))
						$result[$k] = $this->messages();
				}
			}
			if (count($result) > 0) {
				xresponse(FALSE, ['message' => $result]);
			} else {
				xresponse(TRUE);
			}
		}
	}
	
	function a_user_dataset()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params->where['user_id'] = $this->session->user_id;
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['user_id'] = $this->session->user_id;
			}
		}
	}
	
	/* Don't make example from a_role & a_user */
	function a_role()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				$this->params->where_in['id'] = $this->_get_role($this->params->for_user);
			}
		}
	}
	
	function a_role_list()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				$this->params->where_in['id'] = $this->_get_role();
			}
			
			$this->{$this->mdl}->a_role($this->params);
		}
	}
	
	function a_role_menu()
	{
		$this->identity_keys = ['role_id', 'menu_id'];
		
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->role_id) && ($this->params->role_id != '')) 
				$this->params->where['t1.role_id'] = $this->params->role_id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t2.code, t2.name, t2.description', $this->params->q);

		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post_put'){
				$this->_remove_empty($this->mixed_data);
			}
			if ($this->params->event == 'pre_post'){
				unset($this->mixed_data['client_id']);
				unset($this->mixed_data['org_id']);
			}
		}
	}
	
	function a_role_menu_xcopy()
	{
		if ($this->r_method == 'OPTIONS') {
			/* For copy menu from another role */
			$copy_role = $this->base_model->getValueArray($this->params->role_id.' as role_id, menu_id, is_active, permit_form, permit_process, permit_window', 'a_role_menu', ['role_id', 'is_active', 'is_deleted'], [$this->params->copy_role_id, '1', '0']);
			
			if ($copy_role){
				/* Delete old role menu */
				$this->db->delete('a_role_menu', ['role_id'=>$this->params->role_id]);
				
				$error_out = [];
				foreach($copy_role as $k=>$v){
					if (! $this->db->insert('a_role_menu', $copy_role[$k])){
						$copy_role['status'] = $this->db->error()['message'];
						$error_out[] = $copy_role;
					}
				}
				if (count($error_out) > 1)
					xresponse(TRUE, ['message' => $error_out]);
				else
					xresponse(TRUE, ['message' => lang('success_saving')]);
			}
			
			xresponse(TRUE, ['message' => lang('success_saving')]);
		}
	}
	
	function a_role_dashboard()
	{
		$this->identity_keys = ['role_id', 'dashboard_id'];
		
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->role_id) && ($this->params->role_id != '')) 
				$this->params->where['t1.role_id'] = $this->params->role_id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t2.code, t2.name, t2.description', $this->params->q);

		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'post_post_put'){
				$this->_reorder_dashboard($this->params->role_id);
			}
			if ($this->params->event == 'pre_put'){
				// debug($this->params->role_id);
				if (isset($this->params->newline) && $this->params->newline != ''){
					if (!$result = $this->_recordUpdate($this->c_method, ['seq' => $this->params->newline], ['id' => $this->params->id], FALSE))
						xresponse(FALSE, ['message' => $this->messages()]);
					else {
						$this->_reorder_dashboard($this->params->role_id);
						xresponse(TRUE, ['message' => $this->messages()]);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				unset($this->mixed_data['client_id']);
				unset($this->mixed_data['org_id']);
				$this->mixed_data['seq'] = $this->db->query("select max(seq) from a_role_dashboard where is_deleted = '0' and role_id = ".$this->params->role_id)->row()->max + 1;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'pre_delete'){
				$this->params->role_id = $this->base_model->getValue('role_id', $this->c_table, 'id', explode(',', $this->params->id)[0])->role_id;
			}
			if ($this->params->event == 'post_delete'){
				$this->_reorder_dashboard($this->params->role_id);
			}
		}
	}
	
	function a_role_dashboard_xcopy()
	{
		if ($this->r_method == 'OPTIONS') {
			/* For copy dashboard from another role */
			$copy_role = $this->base_model->getValueArray($this->params->role_id.' as role_id, dashboard_id, is_active, is_readwrite, seq', 'a_role_dashboard', ['role_id', 'is_active', 'is_deleted'], [$this->params->copy_role_id, '1', '0']);
			
			if ($copy_role){
				/* Delete old role dashboard */
				$this->db->delete('a_role_dashboard', ['role_id'=>$this->params->role_id]);
				
				$error_out = [];
				foreach($copy_role as $k=>$v){
					if (! $this->db->insert('a_role_dashboard', array_merge($copy_role[$k], $this->create_log))){
						$copy_role['status'] = $this->db->error()['message'];
						$error_out[] = $copy_role;
					}
				}
				if (count($error_out) > 1)
					xresponse(TRUE, ['message' => $error_out]);
				else
					xresponse(TRUE, ['message' => lang('success_saving')]);
			}
			
			xresponse(TRUE, ['message' => lang('success_saving')]);
		}
	}
	
	function a_system()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(FALSE, FALSE);
			
			$this->params->where['t1.client_id'] 	=	DEFAULT_CLIENT_ID;
			$this->params->where['t1.org_id']			= DEFAULT_ORG_ID;
		}
		if (($this->r_method == 'POST')) {
			if ($this->params->event == 'pre_post'){
				if (isset($this->params->send_mail_test) && !empty($this->params->send_mail_test)) {
					/* Trying to sending email */
					$body = "Hai ".$this->session->user_name.", <br><br>";
					$body .= "This is Email Testing from ".$this->session->head_title.".<br><br><br>";
					$body .= "Please do not reply this email.<br><br>";
					$body .= "Thank you,<br>";
					$body .= "Your's Systems.";
					$message = $body;
					if($result = send_mail_systems(NULL, $this->session->user_email, 'Email Testing From '.$this->session->head_title, $message) !== TRUE) {
						xresponse(FALSE, ['message' => $this->session->flashdata('message')]);
					}
					/* success */
					xresponse(TRUE, ['message' => 'Testing Mail has been sent to your email address.']);
				}
			}
		}
	}
	
	function a_client()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(FALSE, FALSE);
		}
	}
	
	function a_dashboard()
	{
		$this->identity_keys = ['name', 'tags'];
		
		if ($this->r_method == 'PATCH') {
			if (isset($this->params->testing_query) && !empty($this->params->testing_query)) {
				if ($this->params->query) {
					$query = translate_variable($this->params->query);
					
					// xresponse(FALSE, ['message' => $query]);
					
					if (!$qry = $this->db->query($query)) {
						xresponse(FALSE, ['message' => $this->db->error()['message']]);
					} else {
						// debugf(count($qry->list_fields()));
						$result['data']['qry_str'] = $query;
						$result['data']['num_fields'] = count($qry->list_fields());
						$result['data']['num_rows'] = $qry->num_rows();
						$result['data']['field_name'] = implode(', ', $qry->list_fields());
						if ($qry->num_rows() == 1){
							$result['data']['row_value'] = array_values($qry->row_array());
						} else {
							$result['data']['row_value'] = 'Rows exceeded more than one !';
						}
						$result['message'] = 'OK';
						$qry->free_result();
					}
					xresponse(TRUE, $result);
				}
			}
		}
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['t1.type', 't1.tags']);
			
			// $this->params->ob = "type, line_no";
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_put'){
				if (isset($this->params->newline) && $this->params->newline != ''){
					if (!$result = $this->_recordUpdate($this->c_method, ['line_no' => $this->params->newline], ['id' => $this->params->id], FALSE))
						xresponse(FALSE, ['message' => $this->messages()]);
					else {
						xresponse(TRUE, ['message' => $this->messages()]);
					}
				}
			}
		}
	}
	
	function a_dataset()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
		}
	}
	
	function a_domain()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post'){
				// unset($this->mixed_data['client_id']);
				// unset($this->mixed_data['org_id']);
			}
		}
	}
	
	function a_menu()
	{
		$this->identity_keys = ['name', 'parent_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE, ['method','title','title_desc']);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post_put'){
				// $this->mixed_data['parent_id'] = $this->mixed_data['parent_id'] ? $this->mixed_data['parent_id'] : 0;
				$this->mixed_data['parent_id'] OR $this->mixed_data['parent_id'] = 0;
				if ($this->params->type == 'G') 
					$this->mixed_data['is_parent'] = '1';
				else
					$this->mixed_data['is_parent'] = '0';
			}
			if ($this->params->event == 'pre_put'){
				if (isset($this->params->newline) && $this->params->newline != ''){
					$needsort = $this->params->line_no - $this->params->newline;
					if (!$result = $this->_recordUpdate($this->c_method, ['line_no' => $this->params->newline, 'is_needsort' => $needsort], ['id' => $this->params->id], FALSE))
						xresponse(FALSE, ['message' => $this->messages()]);
					else {
						$this->_reorder_menu($this->params->parent_id);
						xresponse(TRUE, ['message' => $this->messages()]);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$parent_id = $this->mixed_data['parent_id'] ? $this->mixed_data['parent_id'] : 0;
				$this->mixed_data['line_no'] = $this->db->query('select max(line_no) from a_menu where parent_id = '.$parent_id)->row()->max + 1;
			}
		}
	}
	
	function a_menu_parent_list()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && !empty($this->params->id)) 
				$this->params->where['id'] = $this->params->id;
		
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('name', $this->params->q);
		
		}
	}
	
	function a_org()
	{
		$this->identity_keys = ['name', 'parent_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				if (isset($this->params->parent_id) && !empty($this->params->parent_id)) {
					$this->params->where_in['parent_id'] = $this->params->parent_id;
				} else {
					$this->params->where_in['id'] = $this->_get_org();
				}
			}
			
			$this->params->where['orgtype_id'] = 2;
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['client_id'] = $this->session->client_id;
				unset($this->mixed_data['org_id']);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'post_delete'){
				$str = "with recursive tbl AS (
				select id from a_org where id in (".$this->params->id.")
				union all
				select cld.id from a_org cld join tbl on tbl.id = cld.parent_id
				) update a_org set is_deleted = '1', deleted_by = ".$this->session->user_id.", deleted_at = '".date('Y-m-d H:i:s')."' where id in (select id from tbl)";
				$this->db->query($str);
			}
		}
	}
	
	function a_orgtrx()
	{
		$this->identity_keys = ['name', 'parent_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				if (isset($this->params->parent_id) && !empty($this->params->parent_id)) {
					// debug($this->params->parent_id);
					$this->params->where_in['parent_id'] = explode(',', $this->params->parent_id);
				} else {
					$this->params->where_in['id'] = $this->_get_orgtrx();
				}
			}
			
			$this->params->where['orgtype_id'] = 3;
			$this->{$this->mdl}->a_org($this->params);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['client_id'] = $this->session->client_id;
				unset($this->mixed_data['org_id']);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'post_delete'){
				$str = "with recursive tbl AS (
				select id from a_org where id in (".$this->params->id.")
				union all
				select cld.id from a_org cld join tbl on tbl.id = cld.parent_id
				) update a_org set is_deleted = '1', deleted_by = ".$this->session->user_id.", deleted_at = '".date('Y-m-d H:i:s')."' where id in (select id from tbl)";
				$this->db->query($str);
			}
		}
	}
	
	function a_orgdept()
	{
		$this->identity_keys = ['name', 'parent_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user_org) && !empty($this->params->for_user_org)) {
				$this->params->where_in['id'] = $this->_get_org($this->params->for_user_org);
			}
			
			$this->params->where['orgtype_id'] = 4;
			$this->{$this->mdl}->a_org($this->params);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['client_id'] = $this->session->client_id;
				unset($this->mixed_data['org_id']);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params->event == 'post_delete'){
				$str = "with recursive tbl AS (
				select id from a_org where id in (".$this->params->id.")
				union all
				select cld.id from a_org cld join tbl on tbl.id = cld.parent_id
				) update a_org set is_deleted = '1', deleted_by = ".$this->session->user_id.", deleted_at = '".date('Y-m-d H:i:s')."' where id in (select id from tbl)";
				$this->db->query($str);
			}
		}
	}
	
	function a_orgdiv()
	{
		$this->identity_keys = ['name', 'parent_id'];
		
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user_org) && !empty($this->params->for_user_org)) {
				$this->params->where_in['id'] = $this->_get_org($this->params->for_user_org);
			}
			
			$this->params->where['orgtype_id'] = 5;
			$this->{$this->mdl}->a_org($this->params);
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['client_id'] = $this->session->client_id;
				unset($this->mixed_data['org_id']);
			}
		}
	}
	
	function a_org_list()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				$this->params->where_in['id'] = $this->_get_org();
			}
			
			$this->params->where['orgtype_id'] = 2;
			$this->{$this->mdl}->a_org($this->params);
		}
	}
	
	function a_orgtrx_list()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				if (! $orgtrx = $this->_get_orgtrx($this->params->parent_org_id))
					$orgtrx = 0;
				
				$this->params->where_in['id'] = $orgtrx;
			}
			
			$this->params->where['orgtype_id'] = 3;
			$this->{$this->mdl}->a_org($this->params);
		}
	}
	
	function a_orgdept_list()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				if (! $orgdept = $this->_get_orgdept($this->params->parent_org_id))
					$orgdept = 0;
				
				$this->params->where_in['id'] = $orgdept;
			}
			
			$this->params->where['orgtype_id'] = 4;
			$this->{$this->mdl}->a_org($this->params);
		}
	}
	
	function a_orgdiv_list()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
			
			if (isset($this->params->for_user) && !empty($this->params->for_user)) {
				if (! $orgdiv = $this->_get_orgdiv($this->params->parent_org_id))
					$orgdiv = 0;
				
				$this->params->where_in['id'] = $orgdiv;
			}
			
			$this->params->where['orgtype_id'] = 5;
			$this->{$this->mdl}->a_org($this->params);
		}
	}
	
	function a_org_parent_list()
	{
		if ($this->params->event == 'pre_get'){
			// debug($this->_get_orgtrx());
			if (isset($this->params->id) && !empty($this->params->id)) 
				$this->params->where['id'] = $this->params->id;
			
			if (isset($this->params->client_id) && !empty($this->params->client_id)) 
				$this->params->where['client_id'] = $this->params->client_id;
		
			if (isset($this->params->org_id) && !empty($this->params->org_id)) 
				$this->params->where['org_id'] = $this->params->org_id;
			
			if (isset($this->params->orgtype_id) && !empty($this->params->orgtype_id)) 
				$this->params->where['orgtype_id'] = $this->params->orgtype_id;
		
			if (isset($this->params->user_org) && !empty($this->params->user_org)) 
				$this->params->where_in['org_id'] = $this->_get_org();
		
			if (isset($this->params->user_orgtrx) && !empty($this->params->user_orgtrx)) 
				$this->params->where_in['org_id'] = $this->_get_orgtrx();
		
			if (isset($this->params->parent_id) && !empty($this->params->parent_id)) 
				$this->params->where['parent_id'] = $this->params->parent_id;
		
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('name', $this->params->q);
		
		}
	}
	
	function a_orgtype()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
		}
	}
	
	function a_sequence()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
		}
	}
	
	function a_info()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);

			$this->params->where_in['org_id'] = $this->_get_org();
			
			if (key_exists('valid', $this->params) && ($this->params->valid)) {
				$this->params->where['t1.is_active'] = '1';
				$this->params->where['t1.valid_from <='] = datetime_db_format();
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			if ($this->params->event == 'pre_put'){
				if (isset($this->params->newline) && $this->params->newline != ''){
					if (!$result = $this->_recordUpdate($this->c_method, ['seq' => $this->params->newline], ['id' => $this->params->id], FALSE))
						xresponse(FALSE, ['message' => $this->messages()]);
					else {
						xresponse(TRUE, ['message' => $this->messages()]);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['seq'] = $this->db->query("select max(seq) from a_info where is_deleted = '0' and client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id)->row()->max + 1;
			}
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['valid_org'] = '{'.$this->params->valid_org.'}';
				$this->mixed_data['valid_orgtrx'] = '{'.$this->params->valid_orgtrx.'}';
				$this->mixed_data['valid_menu'] = '{'.$this->params->valid_menu.'}';
				// debug($this->mixed_data);
			}
		}
	}
	
	function c_currency()
	{
		if ($this->params->event == 'pre_get'){
			$this->_get_filtered(TRUE, FALSE);
		}
	}
	
	function c_1country()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name', $this->params->q);

		}
	}
	
	function c_2province()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (key_exists('country_id', $this->params) && !empty($this->params->country_id)) 
				$this->params->where['t1.country_id'] = $this->params->country_id;
			else
				$this->params->where['t1.country_id'] = 0;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name', $this->params->q);

		}
	}
	
	function c_3city()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			// $this->params->where['t1.province_id'] = isset($this->params->province_id) ? $this->params->province_id : 0;
			if (key_exists('province_id', $this->params) && !empty($this->params->province_id)) 
				$this->params->where['t1.province_id'] = $this->params->province_id;
			else
				$this->params->where['t1.province_id'] = 0;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name', $this->params->q);

		}
	}
	
	function c_4district()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (key_exists('city_id', $this->params) && !empty($this->params->city_id)) 
				$this->params->where['t1.city_id'] = $this->params->city_id;
			else
				$this->params->where['t1.city_id'] = 0;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name', $this->params->q);

		}
	}
	
	function c_5village()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			else 
				if (isset($this->params->district_id) && !empty($this->params->district_id)) 
					$this->params->where['t1.district_id'] = $this->params->district_id;
				else
					$this->params->where['t1.district_id'] = 0;

			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name', $this->params->q);

		}
	}
	
	function z_smarty()
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$data['template'] = 'SMARTY !';
		$data['elapsed_time'] = $elapsed;
		$this->smarty->view('welcome_message', $data);
	}
	
	function z_fenom()
	{
		$GLOBALS['identifier'] = ['user_id' => 1234567];
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$data['template'] = 'FENOM !';
		$data['elapsed_time'] = $elapsed;
		// $this->fenom->view("welcome_message", $data);
		$this->fenom->view("index", $data);
	}
	
	function z_smarty_test()
	{
		$this->smarty->testInstall();
	}
	
}