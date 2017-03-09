<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmef.php';

class Frontend extends Getmef 
{
	function __construct() {
		parent::__construct();
		
		$this->load->model('frontend/frontend_model');
		$this->params = $this->input->get();
	}
	
	function index()
	{
		redirect(base_url().'page');
	}
	
	function page()
	{
		if (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) {
			$menu = $this->base_model->getValue('*', 'w_menu', ['client_id','org_id','id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID, $this->params['pageid']]);
			if (!$menu){
				$this->frontend_view('pages/404', ['message'=>'## This page does not exists ! ##']);
				return;
			}
			
			$page = $this->base_model->getValueArray('*', 'w_page', ['client_id','org_id','id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID, $menu->page_id]);
			if (!$page){
				$this->frontend_view('pages/404', ['message'=>'## This page does not exists ! ##']);
				return;
			}
			$this->frontend_view('include/page', $page);
			return;
		}
		
		$page = $this->base_model->getValueArray('*', 'w_page', ['client_id','org_id','is_default'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID, '1']);
		if ($page){
			$this->frontend_view('include/page', $page);
			return;
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