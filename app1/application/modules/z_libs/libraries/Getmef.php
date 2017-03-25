<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* THIS IS CLASS FOR BASE CONTROLLER (FRONTEND) */
// class Getmef extends CI_Controller
class Getmef extends MX_Controller
{
	/* DEFAULT TEMPLATE */
	public $theme 	= 'adminlte';
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	
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
		define('TEMPLATE_URL', base_url().TEMPLATE_FOLDER.'/frontend/'.$this->theme.'/');
		define('TEMPLATE_PATH', '/frontend/'.$this->theme.'/');
		define('HOME_LINK', base_url());
		
		$this->load->model('z_libs/getmef_model');
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
	
	/**
	 * li
	 *
	 * Function for left menu on backend <li></li>
	 *
	 * @param	string	$cur_page   Current page
	 * @param	string	$page_chk   Page check
	 * @param	string	$url   Url
	 * @param	string	$menu_name   Menu label
	 * @param	string	$icon   bootstrap glyphicon class
	 * @param	string	$submenu   Submenu (TRUE or FALSE)
	 * @return  string
	 */
	private function li($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="active"' : '';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="fa fa-circle"></i>';
		
		$html = '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span></a></li>';
		return $html;
	}
	
	private function li_parent($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="treeview active"' : ' class="treeview"';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="glyphicon glyphicon-menu-hamburger"></i>';
		
		$html= '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span><i class="fa fa-angle-left pull-right"></i></a>';
		$html.= '<ul class="treeview-menu">';
		return $html;
	}
	
	function getMenuStructure($cur_page)
	{
		/* Start Treeview Menu */
		$html = ''; $li1_closed = false; $li2_closed = false; $menu_id1 = 0; $menu_id2 = 0; $menu_id3 = 0; $parent_id = 0;
		$rowParentMenu = ($result = $this->getmef_model->getParentMenu($cur_page)) ? $result[0] : (object)['lvl1_id'=>0, 'lvl2_id'=>0];
		$rowMenus = $this->getmef_model->getMenu();
		foreach ($rowMenus as $menu){
			if (($menu_id1 != $menu->menu_id1) && $li1_closed){
				$html.= '</ul></li>';
				$li1_closed = false;
			}
			if (($menu_id2 != $menu->menu_id2) && $li2_closed){
				$html.= '</ul></li>';
				$li2_closed = false;
			}
			if (!empty($menu->menu_id2) || !empty($menu->menu_id3)){
				if ($menu_id1 != $menu->menu_id1){
					$parent_id = $rowParentMenu->lvl2_id ? $rowParentMenu->lvl2_id : $rowParentMenu->lvl1_id;
					$html.= $this->li_parent($parent_id, $menu->menu_id1, 'page?pageid='.$menu->menu_id1, $menu->name1, $menu->icon1);
					$li1_closed = true;
					$menu_id1 = $menu->menu_id1;
				}
				if (($menu_id2 != $menu->menu_id2) && !empty($menu->menu_id3)){
					$parent_id = $rowParentMenu->lvl1_id;
					$html.= $this->li_parent($parent_id, $menu->menu_id2, 'page?pageid='.$menu->menu_id2, $menu->name2, $menu->icon2);
					$li2_closed = true;
					$menu_id2 = $menu->menu_id2;
					
				} elseif (($menu_id2 != $menu->menu_id2) && empty($menu->menu_id3)){
					$html.= $this->li($cur_page, $menu->menu_id2, 'page?pageid='.$menu->menu_id2, $menu->name2, $menu->icon2);
					$menu_id2 = $menu->menu_id2;
				}
				if (!empty($menu->menu_id3)){
					$html.= $this->li($cur_page, $menu->menu_id3, 'page?pageid='.$menu->menu_id3, $menu->name3, $menu->icon3);
				}
			} elseif (!empty($menu->menu_id1)){
				$html.= $this->li($cur_page, $menu->menu_id1, 'page?pageid='.$menu->menu_id1, $menu->name1, $menu->icon1);
			}
		}
		if ($li1_closed)
			$html.= '</ul></li>';
		/* End Treeview Menu */
		
		$html.= '<br><li><a href="'.LOGIN_LNK.'"><i class="fa fa-sign-in text-red"></i> <span>Login</span></a></li>';
		return $html;
	}
	
	function frontend_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$select = 'head_title,page_title,logo_text_mn,logo_text_lg,date_format,time_format,datetime_format,skin_color';
		$config = ($result = $this->base_model->getValueArray($select, 'w_config', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		$pageid = (key_exists('pageid', $this->params) && !empty($this->params['pageid'])) ? $this->params['pageid'] : 0;
		$default['menus'] 			= $this->getMenuStructure($pageid);
		$default['content'] 		= TEMPLATE_PATH.$content.'.tpl';
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $config, $data));
		exit;
	}
	
	// VIEW FOR PRODUCT INFO (QRCODE)
	function custom_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$default['content'] 		= TEMPLATE_PATH.$content.'.tpl';
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $data));
		exit;
	}
	
}