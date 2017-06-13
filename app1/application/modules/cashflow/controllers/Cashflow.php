<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Cashflow extends Getmeb
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();	
		
		$this->lang->load('cashflow/cashflow', (!empty($this->session->language) ? $this->session->language : 'english'));
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
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(inout_id) from cf_inout_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_invoice_line where is_active = '1' and is_deleted = '0' and inout_line_id = f1.id $having) and f1.inout_id = t1.id)";
			}
			
			$this->params['level'] = 1;
			$this->params['where']['t1.is_sotrx'] = '1';
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
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
	
	function cf_sinout_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				$invoice_id = isset($this->params['invoice_id']) && $this->params['invoice_id'] ? $this->params['invoice_id'] : 0;
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = t1.qty' : 'having sum(ttl_amt) = t1.ttl_amt';
				$this->params['where_custom'][] = "inout_id = (select inout_id from cf_invoice where id = $invoice_id)";
				$this->params['where_custom'][] = "not exists (select 1 from cf_invoice_line where is_active = '1' and is_deleted = '0' and inout_line_id = t1.id and invoice_id = $invoice_id $having)";
			}
			
			if (isset($this->params['get_order_id']) && !empty($this->params['get_order_id'])) {
				$result = $this->base_model->getValueArray('order_id', 'cf_inout', 'id', $this->params['inout_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['get_order_line']) && !empty($this->params['get_order_line'])) {
				// $result = $this->base_model->getValueArray('order_id', 'cf_inout', 'id', $this->params['inout_id']);
				$result = $this->{$this->mdl}->cf_order_line_vs_inout_line($this->params);
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
			
			$this->params['level'] = 1;
			$this->params['where']['t1.is_sotrx'] = '1';
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
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
	
	function cf_sinvoice_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['get_inout_id']) && !empty($this->params['get_inout_id'])) {
				$result = $this->base_model->getValueArray('inout_id', 'cf_invoice', 'id', $this->params['invoice_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total', 'cf_invoice', 'id',$this->params['invoice_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['get_inout_line']) && !empty($this->params['get_inout_line'])) {
				// $result = $this->base_model->getValueArray('order_id', 'cf_inout', 'id', $this->params['inout_id']);
				$result = $this->{$this->mdl}->cf_inout_line_vs_invoice_line($this->params);
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
			
			$this->params->is_line = 1;
			$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['invoice_id'] = $this->base_model->getValue('invoice_id', $this->c_table, 'id', $this->params['id'])->invoice_id;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
	}
	
	function cf_sinvoice_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total', 'cf_invoice', 'id',$this->params['invoice_id']);
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
			
			$datas['is_plan'] = 1;
			if (! $this->{$this->mdl}->cf_invoice_valid_amount($datas)){ 
				$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
			}
			unset($datas['is_plan']);

			if ($this->r_method == 'POST') {
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			
			$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $result;
			
			$this->params->is_plan = 1;
			$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan = 1;
				$this->params['invoice_id'] = $this->base_model->getValue('invoice_id', $this->c_table, 'id', $this->params['id'])->invoice_id;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
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
			$datas = $this->_pre_update_records(TRUE);
			
			if ($this->r_method == 'POST') {
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			
			$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $result;
			
			$this->params->is_plan = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
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
			
			if (isset($this->params['for_shipment']) && !empty($this->params['for_shipment'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and order_line_id = f1.id $having) and f1.order_id = t1.id)";
			}
			
			if (isset($this->params['for_request']) && !empty($this->params['for_request'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_request_line where is_active = '1' and is_deleted = '0' and order_line_id = f1.id $having) and f1.order_id = t1.id)";
			}
			
			$this->params['where']['is_sotrx'] = '1';
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
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
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['for_shipment']) && !empty($this->params['for_shipment'])) {
				$inout_id = isset($this->params['inout_id']) && $this->params['inout_id'] ? $this->params['inout_id'] : 0;
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = t1.qty' : 'having sum(ttl_amt) = t1.ttl_amt';
				$this->params['where_custom'][] = "order_id = (select order_id from cf_inout where id = $inout_id)";
				$this->params['where_custom'][] = "not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and order_line_id = t1.id and inout_id = $inout_id $having)";
			}
			
			if (isset($this->params['for_request']) && !empty($this->params['for_request'])) {
				$request_id = isset($this->params['request_id']) && $this->params['request_id'] ? $this->params['request_id'] : 0;
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = t1.qty' : 'having sum(ttl_amt) = t1.ttl_amt';
				$this->params['where_custom'][] = "order_id = (select order_id from cf_request where id = $request_id)";
				$this->params['where_custom'][] = "not exists (select 1 from cf_request_line where is_active = '1' and is_deleted = '0' and order_line_id = t1.id and request_id = $request_id $having)";
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total, plan_cl_total, plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			
			$this->params->is_line = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_sorder_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total, plan_cl_total, plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			
			$datas['is_plan'] = 1;
			if (! $this->{$this->mdl}->cf_order_valid_amount($datas)){ 
				$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
			}
			unset($datas['is_plan']);
			
			if ($this->r_method == 'POST') {
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			
			$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $result;
			
			$this->params->is_plan = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_plan'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['for_material_receipt']) && !empty($this->params['for_material_receipt'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and order_line_id = f1.id $having) and f1.order_id = t1.id)";
			}
			
			$this->params['level'] = 1;
			$this->params['where']['is_sotrx'] = '0';
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
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
				$datas['is_sotrx'] = '0';
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
	
	function cf_porder_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total, plan_cl_total, plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			
			if (! $this->{$this->mdl}->cf_order_valid_qty($datas)){ 
				$this->xresponse(FALSE, ['message' => lang('error_qty_overload', [abs($this->session->flashdata('message'))])], 401);
			}

			if ($this->r_method == 'POST') {
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			
			$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $result;
			
			$this->params->is_line = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total, plan_cl_total, plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			
			$datas['is_plan'] = 1;
			if (! $this->{$this->mdl}->cf_order_valid_amount($datas)){ 
				$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
			}
			unset($datas['is_plan']);
			
			if ($this->r_method == 'POST') {
				$result = $this->insertRecord($this->c_table, $datas, TRUE, TRUE);
			} else {
				$result = $this->updateRecord($this->c_table, $datas, ['id'=>$this->params->id], TRUE);				
			}
			
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			
			$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $result;
			
			$this->params->is_plan = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_plan'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder_plan_clearance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total, plan_cl_total, plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			
			$this->params->is_plan_cl = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan_cl = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder_plan_import()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('sub_total, vat_total, grand_total, plan_total, plan_cl_total, plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			
			$this->params->is_plan_im = 1;
			$this->{$this->mdl}->cf_order_update_summary($this->params);
			
			if ($this->r_method == 'POST')
				$this->xresponse(TRUE, ['id' => $result, 'message' => $this->messages()]);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan_im = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', $this->params['id'])->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_request()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['for_requisition']) && !empty($this->params['for_requisition'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(request_id) from cf_request_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_requisition_line where is_active = '1' and is_deleted = '0' and request_line_id = f1.id $having) and f1.request_id = t1.id)";
			}
			
			$this->params['level'] = 1;
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
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
			
			if (isset($this->params['for_requisition']) && !empty($this->params['for_requisition'])) {
				$requisition_id = isset($this->params['requisition_id']) && $this->params['requisition_id'] ? $this->params['requisition_id'] : 0;
				$this->params['select'] = "t1.*, (t1.qty - (select coalesce(sum(qty),0) from cf_requisition_line where is_active = '1' and is_deleted = '0' and request_line_id = t1.id)) as qty, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_request where id = t1.request_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
				$this->params['where_custom'][] = "request_id = (select request_id from cf_requisition where id = $requisition_id)";
				$this->params['where_custom'][] = "(t1.qty - (select coalesce(sum(qty),0) from cf_requisition_line where is_active = '1' and is_deleted = '0' and request_line_id = t1.id)) > 0";
			}
			
			if (isset($this->params['get_order_id']) && !empty($this->params['get_order_id'])) {
				$result = $this->base_model->getValueArray('order_id', 'cf_request', 'id', $this->params['request_id']);
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
			
			if (isset($this->params['for_purchase_order']) && !empty($this->params['for_purchase_order'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(requisition_id) from cf_requisition_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_order_line where is_active = '1' and is_deleted = '0' and requisition_line_id = f1.id $having) and f1.requisition_id = t1.id)";
			}
			
			$this->params['level'] = 1;
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
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
			
			if (isset($this->params['get_request_id']) && !empty($this->params['get_request_id'])) {
				$result = $this->base_model->getValueArray('request_id', 'cf_requisition', 'id', $this->params['requisition_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_purchase_order']) && !empty($this->params['for_purchase_order'])) {
				$order_id = isset($this->params['order_id']) && $this->params['order_id'] ? $this->params['order_id'] : 0;
				$this->params['select'] = "t1.*, (t1.qty - (select coalesce(sum(qty),0) from cf_order_line where is_active = '1' and is_deleted = '0' and requisition_line_id = t1.id)) as qty, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_requisition where id = t1.requisition_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
				$this->params['where_custom'][] = "requisition_id = (select requisition_id from cf_order where id = $order_id)";
				$this->params['where_custom'][] = "(t1.qty - (select coalesce(sum(qty),0) from cf_order_line where is_active = '1' and is_deleted = '0' and requisition_line_id = t1.id)) > 0";
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
			// debug($datas);
			if (! $this->{$this->mdl}->cf_requisition_valid_qty($datas)){ 
				$this->xresponse(FALSE, ['message' => lang('error_qty_overload', [abs($this->session->flashdata('message'))])], 401);
			}

			if ($this->r_method == 'POST') {
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
	
}