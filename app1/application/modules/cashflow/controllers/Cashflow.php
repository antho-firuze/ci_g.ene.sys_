<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Cashflow extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();	
		
	}
	
	function cf_account()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_charge()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_charge_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_charge_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_charge_type()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_sinout()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params['where']['is_sotrx'] = '1';
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_sinout_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_pinout()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params['where']['is_sotrx'] = '0';
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_pinout_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_sinvoice()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params['where']['is_sotrx'] = '1';
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_sinvoice_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_sinvoice_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_pinvoice()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params['where']['is_sotrx'] = '0';
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_pinvoice_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_pinvoice_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_movement()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_movement_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_sorder()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params['where']['is_sotrx'] = '1';
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST') {
				$datas['is_sotrx'] = '1';
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);

			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function cf_sorder_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total', 'cf_order', 'id',$this->params['order_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST') {
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			
			$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $result;
			
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_sorder_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_porder()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			$this->params['where']['is_sotrx'] = '0';
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_porder_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_porder_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_porder_plan_clearance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_porder_plan_import()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_request()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_request_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_request_type()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_requisition()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
	function cf_requisition_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
		if (($this->r_method == 'POST') || ($this->r_method == 'PUT')) {
			$this->_pre_update_records();
		}
	}
	
}