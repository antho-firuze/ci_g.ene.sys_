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
	}
	
	function cf_ar()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no']);
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (
						select distinct(ar_ap_id) from (
							select * from cf_ar_ap_plan f1 where is_active = '1' and is_deleted = '0'
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and ar_ap_plan_id = f1.id $having)
						) as t2 where t2.ar_ap_id = t1.id
					)";
				}
			}
			
			$this->params['where']['is_receipt'] = '1';
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
			/* This Event is used for Import */
			if ($this->params->event == 'pre_import'){
				$this->identity_keys 		= ['doc_no'];
				$this->imported_fields 	= ['org_id','orgtrx_id','department_id','description','is_receipt','doc_no','doc_date','doc_ref_no','doc_ref_date'];
				$this->validation_fk 		= ['org_id' => 'a_org', 'orgtrx_id' => 'a_org'];
			}
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_receipt'] = '1';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('ar_ap_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
		}
	}
	
	function _void__cf_ar_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total', 'cf_ar_ap', 'id', $this->params['ar_ap_id']);
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['ar_ap_id'] = $this->base_model->getValue('ar_ap_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->ar_ap_id;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
	}
	
	function cf_ar_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total', 'cf_ar_ap', 'id', $this->params['ar_ap_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (
						select distinct(id) from (
							select * from cf_ar_ap_plan f1 where is_active = '1' and is_deleted = '0' and ".$this->params['filter']."
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and ar_ap_plan_id = f1.id $having)
						) as t2 where t2.id = t1.id
					)";
					unset($this->params['filter']);
				}
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
			/* This Event is used for Import */
			if ($this->params->event == 'pre_import'){
				$this->identity_keys 		= ['ar_ap_id','seq'];
				$this->imported_fields 	= ['ar_ap_id','account_id','bpartner_id','seq','doc_date','received_plan_date','description','sub_amt','ttl_amt','vat_amt','note'];
				$this->validation_fk 		= ['ar_ap_id' => 'cf_ar_ap', 'account_id' => 'cf_account', 'bpartner_id' => 'c_bpartner'];
			}
			/* if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['is_plan'] = 1;
				if (! $this->{$this->mdl}->cf_ar_ap_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
				unset($this->mixed_data['is_plan']);
			} */
			
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan = 1;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_plan'] = 1;
				$this->params['ar_ap_id'] = $this->base_model->getValue('ar_ap_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->ar_ap_id;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
	}
	
	function cf_ap()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no']);
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (
						select distinct(ar_ap_id) from (
							select * from cf_ar_ap_plan f1 where is_active = '1' and is_deleted = '0'
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and ar_ap_plan_id = f1.id $having)
						) as t2 where t2.ar_ap_id = t1.id
					)";
				}
			}
			
			if (isset($this->params['for_cashbank']) && !empty($this->params['for_cashbank'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					// $this->params['select'] = "t1.*, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_request where id = t1.request_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
					// $this->params['where_custom'][] = "request_id = (select request_id from cf_requisition where id = $requisition_id)";
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
					// $this->params['where_custom'] = "exists (select distinct(inout_id) from cf_inout_line f1 where is_active = '1' and is_deleted = '0' 
						// and not exists (select 1 from cf_invoice_line where is_active = '1' and is_deleted = '0' and inout_line_id = f1.id $having) and f1.inout_id = t1.id)";
				}
			}
			
			$this->params['where']['is_receipt'] = '0';
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
			/* This Event is used for Import */
			if ($this->params->event == 'pre_import'){
				$this->identity_keys 		= ['doc_no'];
				$this->imported_fields 	= ['org_id','orgtrx_id','department_id','description','is_receipt','doc_no','doc_date','doc_ref_no','doc_ref_date'];
				$this->validation_fk 		= ['org_id' => 'a_org', 'orgtrx_id' => 'a_org'];
			}
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_receipt'] = '0';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('ar_ap_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
		}
	}
	
	function _void__cf_ap_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total', 'cf_ar_ap', 'id', $this->params['ar_ap_id']);
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['ar_ap_id'] = $this->base_model->getValue('ar_ap_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->ar_ap_id;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
	}
	
	function cf_ap_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total', 'cf_ar_ap', 'id', $this->params['ar_ap_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (
						select distinct(id) from (
							select * from cf_ar_ap_plan f1 where is_active = '1' and is_deleted = '0' and ".$this->params['filter']."
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and ar_ap_plan_id = f1.id $having)
						) as t2 where t2.id = t1.id
					)";
					unset($this->params['filter']);
				}
			}
			
			if (isset($this->params['for_cashbank']) && !empty($this->params['for_cashbank'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$this->params['select'] = "t1.*, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_request where id = t1.request_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
					$this->params['where_custom'][] = "request_id = (select request_id from cf_requisition where id = $requisition_id)";
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
					// $this->params['where_custom'] = "exists (select distinct(inout_id) from cf_inout_line f1 where is_active = '1' and is_deleted = '0' 
						// and not exists (select 1 from cf_invoice_line where is_active = '1' and is_deleted = '0' and inout_line_id = f1.id $having) and f1.inout_id = t1.id)";
				}
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
			/* This Event is used for Import */
			if ($this->params->event == 'pre_import'){
				$this->identity_keys 		= ['ar_ap_id','seq'];
				$this->imported_fields 	= ['ar_ap_id','account_id','bpartner_id','seq','doc_date','payment_plan_date','description','sub_amt','ttl_amt','vat_amt','note'];
				$this->validation_fk 		= ['ar_ap_id' => 'cf_ar_ap', 'account_id' => 'cf_account', 'bpartner_id' => 'c_bpartner'];
			}
			/* if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['is_plan'] = 1;
				if (! $this->{$this->mdl}->cf_ar_ap_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
				unset($this->mixed_data['is_plan']);
			} */
			
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan = 1;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_plan'] = 1;
				$this->params['ar_ap_id'] = $this->base_model->getValue('ar_ap_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->ar_ap_id;
				$this->{$this->mdl}->cf_ar_ap_update_summary($this->params);
			}
		}
	}
	
	function cf_cashbank_balance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from cf_account where id = t1.account_id)']);
			
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
			/* Check duplicate period */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_date = $this->base_model->getValue('doc_date', $this->c_table, 'id', $this->params->id)->doc_date;
				} else {
					$doc_date = null;
				}
				/* Convert to first date */
				$params_doc_date = date_first(NULL, date('Y',strtotime($this->params->doc_date)), date('m',strtotime($this->params->doc_date)));
				if ($doc_date != $params_doc_date) {
						$HadSameDocDate = $this->base_model->isDataExist($this->c_table, ['doc_date' => $params_doc_date, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocDate) {
						$period = date('m',strtotime($this->params->doc_date)).'-'.date('Y',strtotime($this->params->doc_date));
						$this->xresponse(FALSE, ['data' => [], 'message' => sprintf(lang('error_duplicate_balance_amt'), $period)], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
				$this->mixed_data['doc_date'] = date_first(NULL, date('Y',strtotime($this->params->doc_date)), date('m',strtotime($this->params->doc_date)));
			}
		}
	}
	
	function cf_cashbank_r()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			$this->params['where']['is_receipt'] = '1';
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_receipt'] = '1';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('cashbank_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
		}
	}
	
	function cf_cashbank_r_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(grand_total,0) as grand_total', 'cf_cashbank', 'id', $this->params['cashbank_id']);
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
			if ($this->params->event == 'pre_post_put'){
				if (! $this->{$this->mdl}->cf_cashbank_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
			}
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_cashbank_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['cashbank_id'] = $this->base_model->getValue('cashbank_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->cashbank_id;
				$this->{$this->mdl}->cf_cashbank_update_summary($this->params);
			}
		}
	}
	
	function cf_cashbank_p()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			$this->params['where']['is_receipt'] = '0';
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_receipt'] = '0';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('cashbank_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
		}
	}
	
	function cf_cashbank_p_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(grand_total,0) as grand_total', 'cf_cashbank', 'id', $this->params['cashbank_id']);
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
			if ($this->params->event == 'pre_post_put'){
				if (! $this->{$this->mdl}->cf_cashbank_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
			}
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_cashbank_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['cashbank_id'] = $this->base_model->getValue('cashbank_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->cashbank_id;
				$this->{$this->mdl}->cf_cashbank_update_summary($this->params);
			}
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
	}
	
	function cf_sinout()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_sotrx'] = '1';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('inout_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
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
	}
	
	function cf_pinout()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				$this->params['where_custom'] = "exists (select distinct(inout_id) from cf_inout_line f1 where is_active = '1' and is_deleted = '0' 
					and not exists (select 1 from cf_invoice_line where is_active = '1' and is_deleted = '0' and inout_line_id = f1.id $having) and f1.inout_id = t1.id)";
			}
			
			$this->params['level'] = 1;
			$this->params['where']['t1.is_sotrx'] = '0';
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_sotrx'] = '0';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('inout_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
		}
	}
	
	function cf_pinout_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['get_order_id']) && !empty($this->params['get_order_id'])) {
				$result = $this->base_model->getValueArray('order_id', 'cf_inout', 'id', $this->params['inout_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				$invoice_id = isset($this->params['invoice_id']) && $this->params['invoice_id'] ? $this->params['invoice_id'] : 0;
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = t1.qty' : 'having sum(ttl_amt) = t1.ttl_amt';
				$this->params['where_custom'][] = "inout_id = (select inout_id from cf_invoice where id = $invoice_id)";
				$this->params['where_custom'][] = "not exists (select 1 from cf_invoice_line where is_active = '1' and is_deleted = '0' and inout_line_id = t1.id and invoice_id = $invoice_id $having)";
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
	}
	
	function cf_oinvoice()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			$this->params['level'] = 1;
			$this->params['where_in']['t1.doc_type'] = ['5', '6'];
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
			
			if (isset($this->params['for_cashbank']) && !empty($this->params['for_cashbank'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					// $this->params['where_custom'] = "exists (select distinct(id) from cf_invoice f1 where is_active = '1' and is_deleted = '0' 
						// and not exists (select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id $having) and f1.id = t1.id)";

					$cashbank = $this->base_model->getValue('bpartner_id, is_receipt', 'cf_cashbank', 'id', $this->params['cashbank_id']);
					$params['select']	= "t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
					$having = isset($params['having']) && $params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$params['where']['bpartner_id'] = $cashbank->bpartner_id;
					$params['where']['is_receipt'] = $cashbank->is_receipt;
					$params['where_custom'] = "exists (select distinct(id) from cf_invoice f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id $having) and f1.id = t1.id)";
					$params['table'] 	= "cf_invoice as t1";
					$result['data'] = $this->base_model->mget_rec($params);
					$this->xresponse(TRUE, $result);
				} else {
					$cashbank = $this->base_model->getValue('bpartner_id, is_receipt', 'cf_cashbank', 'id', $this->params['cashbank_id']);
					$params['select']	= "t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
					$having = isset($params['having']) && $params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$params['where']['bpartner_id'] = $cashbank->bpartner_id;
					$params['where']['is_receipt'] = $cashbank->is_receipt;
					$params['table'] 	= "cf_invoice as t1";
					$result['data'] = $this->base_model->mget_rec($params);
					$this->xresponse(TRUE, $result);
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
				
				if ($this->params->doc_type == '5'){
					// $this->mixed_data['is_sotrx'] = '1';
					$this->mixed_data['is_receipt'] = '1';
				}
				if ($this->params->doc_type == '6'){
					// $this->mixed_data['is_sotrx'] = '0';
					$this->mixed_data['is_receipt'] = '0';
				}
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('invoice_id', explode(',', $this->params['id']))->update($this->c_table.'_plan');
			}
		}
	}
	
	function cf_sinvoice()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			$this->params['level'] = 1;
			$this->params['where']['t1.doc_type'] = '1';
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
			
			if (isset($this->params['for_cashbank']) && !empty($this->params['for_cashbank'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					// debug($this->params);
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (select distinct(id) from cf_invoice f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id $having) and f1.id = t1.id)";
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_receipt'] = '1';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
				$this->mixed_data['account_id'] = 1;
			}
		}
		/* if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('invoice_id', explode(',', $this->params['id']))->update($this->c_table.'_plan');
			}
		} */
	}
	
	function _void__cf_sinvoice_line()
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['invoice_id'] = $this->base_model->getValue('invoice_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->invoice_id;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
	}
	
	function _void__cf_sinvoice_plan()
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
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['is_plan'] = 1;
				if (! $this->{$this->mdl}->cf_invoice_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
				unset($this->mixed_data['is_plan']);
			}
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan = 1;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan = 1;
				$this->params['invoice_id'] = $this->base_model->getValue('invoice_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->invoice_id;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
	}
	
	function cf_pinvoice()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			$this->params['level'] = 1;
			$this->params['where_in']['t1.doc_type'] = ['2', '3', '4'];
			$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
			
			if (isset($this->params['for_cashbank']) && !empty($this->params['for_cashbank'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (select distinct(id) from cf_invoice f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id $having) and f1.id = t1.id)";
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_receipt'] = '0';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
				$this->mixed_data['account_id'] = 2;
				
				if ($this->params->doc_type == 2){
					$this->mixed_data['order_plan_id'] = $this->params->plan_id;
				} else if ($this->params->doc_type == 3){
					$this->mixed_data['order_plan_clearance_id'] = $this->params->plan_id;
				} else if ($this->params->doc_type == 4){
					$this->mixed_data['order_plan_import_id'] = $this->params->plan_id;
				} 
			}
		}
		/* if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('invoice_id', explode(',', $this->params['id']))->update($this->c_table.'_plan');
			}
		} */
	}
	
	function _void__cf_pinvoice_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total', 'cf_invoice', 'id',$this->params['invoice_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['get_inout_id']) && !empty($this->params['get_inout_id'])) {
				$result = $this->base_model->getValueArray('inout_id', 'cf_invoice', 'id', $this->params['invoice_id']);
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['invoice_id'] = $this->base_model->getValue('invoice_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->invoice_id;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
	}
	
	function _void__cf_pinvoice_plan()
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
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['is_plan'] = 1;
				if (! $this->{$this->mdl}->cf_invoice_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
				unset($this->mixed_data['is_plan']);
			}
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan = 1;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_invoice_update_summary($this->params);
			}
		}
	}
	
	function cf_movement()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_outbound'] = '1';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('movement_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
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
	}
	
	function cf_sorder()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			if (isset($this->params['for_shipment']) && !empty($this->params['for_shipment'])) {
				// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
				// $this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
					// and not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and order_line_id = f1.id $having) and f1.order_id = t1.id)";
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = f1.id) and f1.order_id = t1.id)";
				}
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(order_id) from (
							select * from cf_order_plan f1 where is_active = '1' and is_deleted = '0'
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = f1.id $having)
						) as t2 where t2.order_id = t1.id
					)";
				}
			}
			
			if (isset($this->params['for_request']) && !empty($this->params['for_request'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = f1.id) and f1.order_id = t1.id)";
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_sotrx'] = '1';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('order_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
				$this->db->set($this->delete_log)->where_in('order_id', explode(',', $this->params['id']))->update($this->c_table.'_plan');
			}
		}
	}
	
	function cf_sorder_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['for_shipment']) && !empty($this->params['for_shipment'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$inout_id = isset($this->params['inout_id']) && $this->params['inout_id'] ? $this->params['inout_id'] : 0;
					$this->params['where_custom'][] = "order_id = (select order_id from cf_inout where id = $inout_id)";
					$this->params['where_custom'][] = "not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id)";
				}
			}
			
			if (isset($this->params['for_request']) && !empty($this->params['for_request'])) {
				$request_id = isset($this->params['request_id']) && $this->params['request_id'] ? $this->params['request_id'] : 0;
				$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = t1.qty' : 'having sum(ttl_amt) = t1.ttl_amt';
				$this->params['where_custom'][] = "order_id = (select order_id from cf_request where id = $request_id)";
				// $this->params['where_custom'][] = "not exists (select 1 from cf_request_line where is_active = '1' and is_deleted = '0' and order_line_id = t1.id and request_id = $request_id $having)";
				$this->params['where_custom'][] = "not exists (select 1 from cf_request_line where is_active = '1' and is_deleted = '0' and order_line_id = t1.id and request_id = $request_id)";
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_sorder_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['get_custom_field']) && !empty($this->params['get_custom_field'])) {
				$qry = "select to_char(t1.etd, '".$this->session->date_format."') as etd, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top from cf_order t1 where t1.id = ".$this->params['order_id'];
				$result = $this->db->query($qry)->row_array();
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(id) from (
							select * from cf_order_plan f1 where is_active = '1' and is_deleted = '0' and ".$this->params['filter']."
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = f1.id $having)
						) as t2 where t2.id = t1.id
					)";
					unset($this->params['filter']);
				}
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['is_plan'] = 1;
				if (! $this->{$this->mdl}->cf_order_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
				unset($this->mixed_data['is_plan']);
			}
			
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan = 1;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_plan'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_sorder_etd()
	{
		if ($this->r_method == 'OPTIONS') {
			$id = $this->params->id;
			unset($this->params->id);
			$this->mixed_data = array_merge((array)$this->params, $this->update_log);
			
			$result = $this->updateRecord($this->c_table, $this->mixed_data, ['id'=>$id]);
			
			/* Throwing the result to Ajax */
			if (! $result)
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);

			$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
	}
	
	function cf_porder()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			if (isset($this->params['for_material_receipt']) && !empty($this->params['for_material_receipt'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (select distinct(order_id) from cf_order_line f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = f1.id) and f1.order_id = t1.id)";
				}
			}
			
			if (isset($this->params['for_invoice_plan']) && !empty($this->params['for_invoice_plan'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(order_id) from (
							select * from cf_order_plan f1 where is_active = '1' and is_deleted = '0'
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = f1.id $having)
						) as t2 where t2.order_id = t1.id
					)";
				}
			}
			
			if (isset($this->params['for_invoice_plan_clearance']) && !empty($this->params['for_invoice_plan_clearance'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(order_id) from (
							select * from cf_order_plan_clearance f1 where is_active = '1' and is_deleted = '0'
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_clearance_id = f1.id $having)
						) as t2 where t2.order_id = t1.id
					)";
				}
			}
			
			if (isset($this->params['for_invoice_plan_import']) && !empty($this->params['for_invoice_plan_import'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(order_id) from (
							select * from cf_order_plan_import f1 where is_active = '1' and is_deleted = '0'
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_import_id = f1.id $having)
						) as t2 where t2.order_id = t1.id
					)";
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
					// debug($this->params);
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['is_sotrx'] = '0';
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
			if ($this->params->event == 'pre_put'){
				$header = $this->base_model->getValue('*', $this->c_table, 'id', $this->params->id);
				// debug($this->c_table.'_line');
				$HadDetail = $this->base_model->isDataExist($this->c_table.'_line', ['order_id' => $this->params->id]);
				if ($this->mixed_data['requisition_id'] != $header->requisition_id && $HadDetail) {
					$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_had_detail')], 401);
				}
			}
			if ($this->params->event == 'pre_post_put'){
				$requisition = $this->base_model->getValue('*', 'cf_requisition', 'id', $this->params->requisition_id);
				if ($this->mixed_data['eta'] >= $requisition->eta) {
					$this->xresponse(FALSE, ['message' => lang('error_po_eta', [datetime_db_format($requisition->eta, $this->session->date_format, FALSE)])], 401);
				}
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('order_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
				$this->db->set($this->delete_log)->where_in('order_id', explode(',', $this->params['id']))->update($this->c_table.'_plan');
				$this->db->set($this->delete_log)->where_in('order_id', explode(',', $this->params['id']))->update($this->c_table.'_plan_clearance');
				$this->db->set($this->delete_log)->where_in('order_id', explode(',', $this->params['id']))->update($this->c_table.'_plan_import');
			}
		}
	}
	
	function cf_porder_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_material_receipt']) && !empty($this->params['for_material_receipt'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$inout_id = isset($this->params['inout_id']) && $this->params['inout_id'] ? $this->params['inout_id'] : 0;
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = t1.qty' : 'having sum(ttl_amt) = t1.ttl_amt';
					$this->params['where_custom'][] = "order_id = (select order_id from cf_inout where id = $inout_id)";
					// $this->params['where_custom'][] = "not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and order_line_id = t1.id and inout_id = $inout_id $having)";
					$this->params['where_custom'][] = "not exists (select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id and inout_id = $inout_id)";
				}
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
			/* if ($this->params->event == 'pre_post_put'){
				if (! $this->{$this->mdl}->cf_order_valid_qty($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_qty_overload', [abs($this->session->flashdata('message'))])], 401);
				}
			} */
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_line = 1;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_line'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder_plan()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['get_custom_field']) && !empty($this->params['get_custom_field'])) {
				$qry = "select to_char(t1.eta, '".$this->session->date_format."') as eta, (select po_top from c_bpartner where id = t1.bpartner_id) as po_top from cf_order t1 where t1.id = ".$this->params['order_id'];
				$result = $this->db->query($qry)->row_array();
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(id) from (
							select * from cf_order_plan f1 where is_active = '1' and is_deleted = '0' and ".$this->params['filter']."
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = f1.id $having)
						) as t2 where t2.id = t1.id
					)";
					unset($this->params['filter']);
				}
			}
			
			if (isset($this->params['for_cashbank']) && !empty($this->params['for_cashbank'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
					// $this->params['where_custom'] = "not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = t1.id)";
				}
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
				// $result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			if ($this->params->event == 'pre_post_put'){
				$this->mixed_data['is_plan'] = 1;
				if (! $this->{$this->mdl}->cf_order_valid_amount($this->mixed_data)){ 
					$this->xresponse(FALSE, ['message' => lang('error_amount_overload', [number_format(abs($this->session->flashdata('message')), $this->session->number_digit_decimal, $this->session->decimal_symbol, $this->session->group_symbol)])], 401);
				}
				unset($this->mixed_data['is_plan']);
			}
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan = 1;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params['is_plan'] = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder_plan_clearance()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['get_custom_field']) && !empty($this->params['get_custom_field'])) {
				$qry = "select to_char(t1.eta, '".$this->session->date_format."') as eta, (select po_top from c_bpartner where id = t1.bpartner_id) as po_top from cf_order t1 where t1.id = ".$this->params['order_id'];
				$result = $this->db->query($qry)->row_array();
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(id) from (
							select * from cf_order_plan_clearance f1 where is_active = '1' and is_deleted = '0' and ".$this->params['filter']."
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_clearance_id = f1.id $having)
						) as t2 where t2.id = t1.id
					)";
					unset($this->params['filter']);
				}
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan_cl = 1;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan_cl = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_porder_plan_import()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE);
			
			if (isset($this->params['get_custom_field']) && !empty($this->params['get_custom_field'])) {
				$qry = "select to_char(t1.eta, '".$this->session->date_format."') as eta, (select po_top from c_bpartner where id = t1.bpartner_id) as po_top from cf_order t1 where t1.id = ".$this->params['order_id'];
				$result = $this->db->query($qry)->row_array();
				$this->xresponse(TRUE, ['data' => $result]);
			}
			
			if (isset($this->params['for_invoice']) && !empty($this->params['for_invoice'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(amount) = f1.amount';
					$this->params['where_custom'] = "exists (
						select distinct(id) from (
							select * from cf_order_plan_import f1 where is_active = '1' and is_deleted = '0' and ".$this->params['filter']."
							and not exists (select 1 from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_import_id = f1.id $having)
						) as t2 where t2.id = t1.id
					)";
					unset($this->params['filter']);
				}
			}
			
			if (isset($this->params['summary']) && !empty($this->params['summary'])) {
				$result = $this->base_model->getValueArray('coalesce(sub_total,0) as sub_total, coalesce(vat_total,0) as vat_total, coalesce(grand_total,0) as grand_total, coalesce(plan_total,0) as plan_total, coalesce(plan_cl_total,0) as plan_cl_total, coalesce(plan_im_total,0) as plan_im_total', 'cf_order', 'id',$this->params['order_id']);
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
			if ($this->params->event == 'post_post_put'){
				$this->params->id = isset($this->params->id) && $this->params->id ? $this->params->id : $this->insert_id;
				$this->params->is_plan_im = 1;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->params->is_plan_im = 1;
				$this->params['order_id'] = $this->base_model->getValue('order_id', $this->c_table, 'id', @end(explode(',', $this->params['id'])))->order_id;
				$this->{$this->mdl}->cf_order_update_summary($this->params);
			}
		}
	}
	
	function cf_request()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no',"(select doc_no from cf_order where is_sotrx = '1' and id = t1.order_id)",'(select name from c_bpartner where id = t1.bpartner_id)']);
			
			if (isset($this->params['for_requisition']) && !empty($this->params['for_requisition'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					// $having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (select distinct(request_id) from cf_request_line f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_requisition_line where is_active = '1' and is_deleted = '0' and request_line_id = f1.id) and f1.request_id = t1.id)";
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
			if ($this->params->event == 'pre_put'){
				$header = $this->base_model->getValue('*', $this->c_method, 'id', $this->params->id);
				$HadDetail = $this->base_model->isDataExist($this->c_method.'_line', ['request_id' => $this->params->id]);
				// debug($this->mixed_data['request_type_id']);
				if ($this->mixed_data['request_type_id'] != $header->request_type_id && $HadDetail) {
					$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_had_detail')], 401);
				}
				if ($this->mixed_data['order_id'] != $header->order_id && $HadDetail) {
					$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_had_detail')], 401);
				}
				if ($this->mixed_data['request_type_id'] != 1){
					$this->mixed_data['order_id'] = NULL;
				}
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('request_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
		}
	}
	
	function cf_request_line()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, [], TRUE);
			
			if (isset($this->params['for_requisition']) && !empty($this->params['for_requisition'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$requisition_id = isset($this->params['requisition_id']) && $this->params['requisition_id'] ? $this->params['requisition_id'] : 0;
					$this->params['where_custom'][] = "request_id = (select request_id from cf_requisition where id = $requisition_id)";
					$this->params['where_custom'][] = "not exists (select 1 from cf_requisition_line where is_active = '1' and is_deleted = '0' and request_line_id = t1.id)";
				}
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
	}
	
	function cf_requisition()
	{
		if ($this->r_method == 'GET') {
			$this->_get_filtered(TRUE, TRUE, ['t1.doc_no','(select doc_no from cf_request where id = t1.request_id)','(select name from c_bpartner where id = t1.bpartner_id)']);
			
			if (isset($this->params['for_purchase_order']) && !empty($this->params['for_purchase_order'])) {
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$having = isset($this->params['having']) && $this->params['having'] == 'qty' ? 'having sum(qty) = f1.qty' : 'having sum(ttl_amt) = f1.ttl_amt';
					$this->params['where_custom'] = "exists (select distinct(requisition_id) from cf_requisition_line f1 where is_active = '1' and is_deleted = '0' 
						and not exists (select 1 from cf_order_line where is_active = '1' and is_deleted = '0' and requisition_line_id = f1.id) and f1.requisition_id = t1.id)";
				}
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
			/* Check duplicate doc_no */
			if ($this->params->event == 'pre_post_put'){
				if ($this->params->id){
					$doc_no = $this->base_model->getValue('doc_no', $this->c_table, 'id', $this->params->id)->doc_no;
				} else {
					$doc_no = null;
				}
				if ($doc_no != $this->params->doc_no) {
						$HadSameDocNo = $this->base_model->isDataExist($this->c_table, ['doc_no' => $this->params->doc_no, 'is_active' => '1', 'is_deleted' => '0']);
					if ($HadSameDocNo) {
						$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_duplicate_doc_no')], 401);
					}
				}
			}
			if ($this->params->event == 'pre_post'){
				$this->mixed_data['orgtrx_id'] = $this->session->orgtrx_id;
			}
			if ($this->params->event == 'pre_put'){
				$header = $this->base_model->getValue('*', $this->c_method, 'id', $this->params->id);
				$HadDetail = $this->base_model->isDataExist($this->c_method.'_line', ['requisition_id' => $this->params->id]);
				// debug($this->mixed_data['request_type_id']);
				if ($this->mixed_data['request_id'] != $header->request_id && $HadDetail) {
					$this->xresponse(FALSE, ['data' => [], 'message' => lang('error_had_detail')], 401);
				}
			}
			if ($this->params->event == 'pre_post_put'){
				$request = $this->base_model->getValue('*', 'cf_request', 'id', $this->params->request_id);
				if ($this->mixed_data['eta'] >= $request->eta) {
					$this->xresponse(FALSE, ['message' => lang('error_requisition_eta', [datetime_db_format($request->eta, $this->session->date_format, FALSE)])], 401);
				}
			}
		}
		if ($this->r_method == 'DELETE') {
			if ($this->params['event'] == 'post_delete'){
				$this->db->set($this->delete_log)->where_in('requisition_id', explode(',', $this->params['id']))->update($this->c_table.'_line');
			}
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
				if (isset($this->params['act']) && in_array($this->params['act'], ['new', 'cpy'])) {
					$order_id = isset($this->params['order_id']) && $this->params['order_id'] ? $this->params['order_id'] : 0;
					$this->params['select'] = "t1.*, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_requisition where id = t1.requisition_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
					$this->params['where_custom'][] = "requisition_id = (select requisition_id from cf_order where id = $order_id)";
					// $this->params['where_custom'][] = "(t1.qty - (select coalesce(sum(qty),0) from cf_order_line where is_active = '1' and is_deleted = '0' and requisition_line_id = t1.id)) > 0";
				}
			}
			
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				$this->_pre_export_data();
			}
			
			if (! $result['data'] = $this->{$this->mdl}->{$this->c_method}($this->params)){
				$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()],401);
			} else {
				$this->xresponse(TRUE, $result);
			}
		}
	}
	
	function rpt_cashflow_projection()
	{
		if ($this->r_method == 'OPTIONS') {
			/* Validation */
			$fdate = date_first(NULL, $this->params->fyear, $this->params->fmonth);
			$tdate = date_first(NULL, $this->params->tyear, $this->params->tmonth);
			$arr = [];
			if (($return = date_differ($fdate, $tdate)+1) < 2){
				$date = strtotime($fdate);
				$arr[0]['title'] = date('m',$date).date('Y',$date);
				$arr[0]['period'] = '('.date('m',$date).','.date('Y',$date).')';
			} else {
				if ($return > 12)
					$this->xresponse(FALSE, ['message' => $this->lang->line('error_range_overload')],401);
				
				$date = strtotime($fdate);
				for ($x = 0; $x <= $return-1; $x++) {
					$arr[$x]['title'] = date('m',$date).date('Y',$date);
					$arr[$x]['period'] = '('.date('m',$date).','.date('Y',$date).')';
					$date = strtotime("+1 month", $date);
				} 
			}
			/* Re-quering Data */
			$str = 'select t1.account_id, (select is_receipt from cf_account where id = t1.account_id), type, seq, description as "DESCRIPTION", ';
			foreach($arr as $i =>$v){
				$str .= "(select coalesce(sum(amount), 0) * (case (select is_receipt from cf_account where id = t1.account_id) when '1' then 1 else -1 end)".' as "'.$v['title'].'"' ." from cf_invoice where is_active = '1' and is_deleted = '0' and account_id = t1.account_id
								and ((extract(month from received_plan_date),extract(year from received_plan_date)) = ".$v['period']." or (extract(month from payment_plan_date),extract(year from payment_plan_date)) = ".$v['period']."))";
				if ((count($arr)-1)!=$i)
					$str .= ', ';
			}
			$str .= " from cf_rpt_cashflow_projection t1 order by seq";
			$qry = $this->db->query($str);
			$rows = $qry->result();
			/* Start process: Compiling Report */
			/* Define Variable */
			foreach($arr as $v){
				$ttl[0][$v['title']] = 0;
				$ttl[25][$v['title']] = 0;
				$ttl[30][$v['title']] = 0;
				$ttl[39][$v['title']] = 0;
				$ttl[41][$v['title']] = 0;
				$ttl[45][$v['title']] = 0;
				$ttl[47][$v['title']] = $this->db->query("select coalesce((select amount from cf_cashbank_balance where is_active = '1' and is_deleted = '0' and doc_date = '".$fdate."'), 0) as amount")->row()->amount;
				$ttl[48][$v['title']] = 0;
				$ttl[49][$v['title']] = 0;
			}
			// debug($rows);
			foreach($rows as $key => $val){
				if ($val->account_id){
					foreach($arr as $v){
						$ttl[0][$v['title']] += $rows[$key]->{$v['title']};
						if ($val->type == 'O') $ttl[25][$v['title']] += $rows[$key]->{$v['title']};
						if ($val->type == 'I') $ttl[30][$v['title']] += $rows[$key]->{$v['title']};
						if ($val->type == 'F') $ttl[39][$v['title']] += $rows[$key]->{$v['title']};
						if ($val->type == 'Z') $ttl[45][$v['title']] += $rows[$key]->{$v['title']};
					}
				} else {
					foreach($arr as $i => $v){
						// $rows[0]['112017'] = '';
						$rows[$key]->{$v['title']} = '';
						if ($val->seq == 25) $rows[$key]->{$v['title']} = $ttl[$val->seq][$v['title']];
						if ($val->seq == 30) $rows[$key]->{$v['title']} = $ttl[$val->seq][$v['title']];
						if ($val->seq == 39) $rows[$key]->{$v['title']} = $ttl[$val->seq][$v['title']];
						if ($val->seq == 41) $rows[$key]->{$v['title']} = $ttl[25][$v['title']] + $ttl[30][$v['title']] + $ttl[39][$v['title']];
						if ($val->seq == 45) $rows[$key]->{$v['title']} = $ttl[$val->seq][$v['title']];
						
						if ($i == 0) {
							$cb_a = $ttl[47][$v['title']];
							$cb_b = $ttl[0][$v['title']] + $cb_a;
						} else {
							$cb_a = $cb_b;
							$cb_b = $ttl[0][$v['title']] + $cb_a;
						}
						if ($val->seq == 47) $rows[$key]->{$v['title']} = $cb_a;
						if ($val->seq == 48) $rows[$key]->{$v['title']} = $cb_b;
						if ($val->seq == 49) $rows[$key]->{$v['title']} = $ttl[0][$v['title']];
					}
				}
			}
			
			/* Unset account_id: 31 & 32 */
			unset($rows[42],$rows[43]);
			/* Export the result to client */
			$filename = 'result_'.$this->c_table.'_'.date('YmdHi').'.xls';
			/* Remove this fields */
			$excl_cols = ['account_id','is_receipt','type','seq'];
			if (! $result = $this->_export_data_array($rows, $excl_cols, $filename, 'xls', TRUE)) {
				// $this->_update_process(['message' => 'Error: Exporting result data.', 'log' => 'Error: Exporting result data.', 'status' => 'FALSE', 'finished_at' => date('Y-m-d H:i:s'), 'stop_time' => time()], $id_process);
				$this->xresponse(FALSE, ['message' => sprintf($this->lang->line('error_downloading_report'), $filename)], 401);
			}
			
			/* Update status on process table */
			// $this->_update_process(['message' => $this->lang->line('success_import_data'), 'log' => $this->lang->line('success_import_data'), 'status' => 'TRUE', 'finished_at' => date('Y-m-d H:i:s'), 'stop_time' => time()], $id_process);
			/* Unset id_process, so can't be called again from client  */
			// $this->session->unset_userdata('id_process');
			
			$result['message'] = $this->lang->line('success_import_data');
			$this->xresponse(TRUE, $result);
		}
	}
	
	function rpt_cf_trace_performance_delivery()
	{
		if ($this->r_method == 'GET') {
			if (isset($this->params['peek_so']) && !empty($this->params['peek_so'])) {
				$this->_get_filtered(TRUE, TRUE, ['t1.doc_no']);
				$this->params['where']['is_sotrx'] = '1';
				$this->params['where']['t1.orgtrx_id'] = $this->session->orgtrx_id;
				if (! $result['data'] = $this->{$this->mdl}->cf_sorder($this->params)){
					$this->xresponse(FALSE, ['data' => [], 'message' => $this->base_model->errors()]);
				} else {
					$this->xresponse(TRUE, $result);
				}
			}
		}
		if ($this->r_method == 'OPTIONS') {
			/* Validation */
			/* Re-quering Data */
			$str = 'select t1.account_id, (select is_receipt from cf_account where id = t1.account_id), type, seq, description as "DESCRIPTION", ';
			debug($this->params);
			
			
			/* Export the result to client */
			$filename = 'result_'.$this->c_method.'_'.date('YmdHi').'.xls';
			if (! $result = $this->_export_data($rows, $filename, 'xls', TRUE)) {
				// $this->_update_process(['message' => 'Error: Exporting result data.', 'log' => 'Error: Exporting result data.', 'status' => 'FALSE', 'finished_at' => date('Y-m-d H:i:s'), 'stop_time' => time()], $id_process);
				$this->xresponse(FALSE, ['message' => sprintf($this->lang->line('error_downloading_report'), $filename)], 401);
			}
			/* Update status on process table */
			// $this->_update_process(['message' => $this->lang->line('success_import_data'), 'log' => $this->lang->line('success_import_data'), 'status' => 'TRUE', 'finished_at' => date('Y-m-d H:i:s'), 'stop_time' => time()], $id_process);
			/* Unset id_process, so can't be called again from client  */
			// $this->session->unset_userdata('id_process');
			$result['message'] = $this->lang->line('success_import_data');
			$this->xresponse(TRUE, $result);
		}
	}
	
}