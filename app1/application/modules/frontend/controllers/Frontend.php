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
		// debug($method);
		// debug($this->uri->segment(1));
		if ($method == 'translate_url')
			return call_user_func_array(array($this, $method), [$this->uri->segment(1)]);
		
		return call_user_func_array(array($this, $method), $params);
	}
	
	function index()
	{
		redirect(base_url().'page');
	}
	
	/* method for translate shorten url */
	function translate_url($params)
	{
		if ($row = $this->base_model->getValue('url', 'w_shortenurl', 'code', $params)) 
			header("Location: http://".$row->url);
		else
			show_404();
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