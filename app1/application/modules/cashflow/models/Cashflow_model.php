<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function cf_account($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= "cf_account as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_ar($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from a_org where id = t1.department_id) as department_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_ar_ap as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_ar_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_ar_ap where id = t1.ar_ap_id), 
		(select count(doc_no) from cf_invoice where ar_ap_plan_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select name from cf_account where id = t1.account_id) as account_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		t1.seq ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') ||'_'|| coalesce(t1.ttl_amt,'0') as code_name";
		$params['table'] 	= "cf_ar_ap_plan as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_ap($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from a_org where id = t1.department_id) as department_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_ar_ap as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_ap_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_ar_ap where id = t1.ar_ap_id), 
		(select count(doc_no) from cf_invoice where ar_ap_plan_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select name from cf_account where id = t1.account_id) as account_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		t1.seq ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') ||'_'|| coalesce(t1.ttl_amt,'0') as code_name";
		$params['table'] 	= "cf_ar_ap_plan as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_cashbank_balance($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from cf_account where id = t1.account_id) as account_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date";
		$params['table'] 	= "cf_cashbank_balance as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_cashbank_r($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "cf_cashbank as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_cashbank_r_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_cashbank where id = t1.cashbank_id), 
		(select name from cf_account where id = t1.account_id) as account_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, (select doc_no from cf_invoice where id = t1.invoice_id) as invoice_no, (select to_char(doc_date, '".$this->session->date_format."') from cf_invoice where id = t1.invoice_id) as invoice_date";
		$params['table'] 	= "cf_cashbank_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_cashbank_p($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.payment_date, '".$this->session->date_format."') as payment_date";
		$params['table'] 	= "cf_cashbank as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_cashbank_p_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_cashbank where id = t1.cashbank_id), 
		(select name from cf_account where id = t1.account_id) as account_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, (select doc_no from cf_invoice where id = t1.invoice_id) as invoice_no, (select to_char(doc_date, '".$this->session->date_format."') from cf_invoice where id = t1.invoice_id) as invoice_date";
		$params['table'] 	= "cf_cashbank_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_cashbank_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->cashbank_id) ? 'where t1.id = '.$params->cashbank_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_cashbank t1 set (grand_total) = 
				(
					select coalesce(sum(amount),0) from cf_cashbank_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.cashbank_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
	function cf_cashbank_valid_amount($params)
	{
		/* Insert: (grand_total - plan_total) < new_amount => error */
		/* Update: (grand_total - sum(plan_amount except current id)) < new_amount => error */
		$params = is_array($params) ? (object) $params : $params;
		// debug($params);
		
		$id = isset($params->id) && $params->id ? 'and t2.id <> '.$params->id : '';
		$invoice_id = $params->invoice_id;
		$str = "SELECT (net_amount - (select coalesce(sum(amount),0) from cf_cashbank_line t2 where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id $id)) as amount 
			from cf_invoice t1 where t1.id = $invoice_id";
		$row = $this->db->query($str)->row();
		if ($row->amount - $params->amount < 0) {
			$this->session->set_flashdata('message', $row->amount);
			return FALSE;
		}
		return TRUE;
	}
	
	function cf_charge_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_method." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinout($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "cf_inout as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order, to_char(t2.etd, '".$this->session->date_format."') as etd_order";
			$params['join'][] = ['cf_order as t2', 't1.order_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinout_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_inout where id = t1.inout_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_inout where id = t1.inout_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_inout_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinout($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "cf_inout as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order, to_char(t2.eta, '".$this->session->date_format."') as eta_order";
			$params['join'][] = ['cf_order as t2', 't1.order_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinout_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_inout where id = t1.inout_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_inout where id = t1.inout_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_inout_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinvoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name,
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name,
		array_to_string(reasons, ',') as reasons,
		(select string_agg(name, E',') from rf_invoice_adj_reason where id = ANY(t1.reasons)) as reason_name";
		$params['table'] 	= "cf_invoice as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", 
				t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order, 
				to_char(t2.etd, '".$this->session->date_format."') as etd_order, 
				t2.doc_ref_no as doc_ref_no_order,
				to_char(t3.received_plan_date, '".$this->session->date_format."') as received_plan_date_order
				";
			$params['join'][] = ['cf_order as t2', 't1.order_id = t2.id', 'left'];
			$params['join'][] = ['cf_order_plan as t3', 't1.order_plan_id = t3.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_oinvoice_i($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name,
		array_to_string(reasons, ',') as reasons,
		(select string_agg(name, E',') from rf_invoice_adj_reason where id = ANY(t1.reasons)) as reason_name";
		$params['table'] 	= "cf_invoice as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_ar_ap, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_ar_ap, t3.note";
			$params['join'][] = ['cf_ar_ap as t2', 't1.ar_ap_id = t2.id', 'left'];
			$params['join'][] = ['cf_ar_ap_plan as t3', 't1.ar_ap_plan_id = t3.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_oinvoice_o($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name,
		array_to_string(reasons, ',') as reasons,
		(select string_agg(name, E',') from rf_invoice_adj_reason where id = ANY(t1.reasons)) as reason_name";
		$params['table'] 	= "cf_invoice as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_ar_ap, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_ar_ap, t3.note";
			$params['join'][] = ['cf_ar_ap as t2', 't1.ar_ap_id = t2.id', 'left'];
			$params['join'][] = ['cf_ar_ap_plan as t3', 't1.ar_ap_plan_id = t3.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinvoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		case t1.doc_type when '2' then 'Inv. Vendor' when '3' then 'Inv. Clearence' else 'Inv. Custom Duty' end as invoice_type,
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name,
		(select doc_no from cf_order where id = t1.order_id) as doc_no_order, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as doc_date_order, 
		(select to_char(eta, '".$this->session->date_format."') from cf_order where id = t1.order_id) as eta_order, 
		case doc_type when '2' then (select to_char(payment_plan_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) 
		when '3' then (select to_char(payment_plan_date, '".$this->session->date_format."') from cf_order_plan_clearance where id = t1.order_plan_clearance_id) 
		else (select to_char(payment_plan_date, '".$this->session->date_format."') from cf_order_plan_import where id = t1.order_plan_import_id) end as payment_plan_date_order,
		array_to_string(reasons, ',') as reasons,
		(select string_agg(name, E',') from rf_invoice_adj_reason where id = ANY(t1.reasons)) as reason_name";
		$params['table'] 	= "cf_invoice as t1";
		// if (isset($params['level']) && $params['level'] == 1) {
			// $params['select'] .= ", t2.doc_no as doc_no_inout, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_inout";
			// $params['join'][] = ['cf_inout as t2', 't1.inout_id = t2.id', 'left'];
			// $params['select'] .= ", t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order, to_char(t2.eta, '".$this->session->date_format."') as eta_order";
			// $params['join'][] = ['cf_order as t2', 't1.order_id = t2.id', 'left'];
			// $params['join'][] = ['cf_order_plan as t3', 't1.order_plan_id = t3.id', 'left'];
			// $params['join'][] = ['cf_order_plan_clearance as t4', 't1.order_plan_clearance_id = t4.id', 'left'];
			// $params['join'][] = ['cf_order_plan_import as t5', 't1.order_plan_import_id = t5.id', 'left'];
		// }
		return $this->base_model->mget_rec($params);
	}
	
	function cf_omovement($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		(select name from a_org where id = t1.org_to_id) as org_to_name, 
		(select name from a_org where id = t1.orgtrx_to_id) as orgtrx_to_name, 
		t1.*, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, 
		to_char(t1.received_date, '".$this->session->date_format."') as received_date
		";
		$params['table'] 	= "cf_movement as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.bpartner_id, (select name from c_bpartner where id = t2.bpartner_id) as bpartner_name, t2.doc_no as doc_no_request, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_request, to_char(t2.eta, '".$this->session->date_format."') as eta_request";
			$params['join'][] = ['cf_request as t2', 't1.request_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_omovement_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_movement where id = t1.movement_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_movement where id = t1.movement_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_movement_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_imovement($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		(select name from a_org where id = t1.org_to_id) as org_to_name, 
		(select name from a_org where id = t1.orgtrx_to_id) as orgtrx_to_name, 
		t1.*, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, 
		to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "cf_movement as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.bpartner_id, (select name from c_bpartner where id = t2.bpartner_id) as bpartner_name, t2.doc_no as doc_no_request, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_request, to_char(t2.eta, '".$this->session->date_format."') as eta_request";
			$params['join'][] = ['cf_request as t2', 't1.request_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_imovement_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_movement where id = t1.movement_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_movement where id = t1.movement_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_movement_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sorder($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name,
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.etd, '".$this->session->date_format."') as etd, 
		to_char(t1.expected_dt_cust, '".$this->session->date_format."') as expected_dt_cust, 
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name,
		array_to_string(scm_dt_reasons, ',') as scm_dt_reasons,
		(select string_agg(name, E',') from rf_scm_dt_reason where id = ANY(t1.scm_dt_reasons)) as reason_name,
		coalesce(etd - expected_dt_cust, 0) as estimation_late,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name,
		case 
		when ((etd - expected_dt_cust) * penalty_percent * grand_total) > (max_penalty_percent * grand_total) 
		then (max_penalty_percent * grand_total) 
		else (case when (etd - expected_dt_cust) > 0 then ((etd - expected_dt_cust) * penalty_percent * grand_total) else 0 end) 
		end as estimation_penalty_amount";
		$params['table'] 	= "cf_order as t1";
		// $table_custom = "(select
		// (select name from a_org where id = t0.org_id) as org_name, 
		// (select name from a_org where id = t0.orgtrx_id) as orgtrx_name, 
		// t0.*, 
		// (select name from c_bpartner where id = t0.bpartner_id) as bpartner_name, 
		// (select so_top from c_bpartner where id = t0.bpartner_id) as so_top, 
		// to_char(t0.doc_date, '".$this->session->date_format."') as doc_date, 
		// to_char(t0.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		// to_char(t0.etd, '".$this->session->date_format."') as etd, 
		// to_char(t0.expected_dt_cust, '".$this->session->date_format."') as expected_dt_cust, 
		// coalesce(t0.doc_no,'') ||'_'|| to_char(t0.doc_date, '".$this->session->date_format."') as code_name,
		// array_to_string(scm_dt_reasons, ',') as scm_dt_reason,
		// (select string_agg(name, E',') from rf_scm_dt_reason where id = ANY(t0.scm_dt_reasons)) as reason_name,
		// coalesce(etd - expected_dt_cust, 0) as estimation_late,
		// case 
		// when ((etd - expected_dt_cust) * penalty_percent * grand_total) > (max_penalty_percent * grand_total) 
		// then (max_penalty_percent * grand_total) 
		// else (case when (etd - expected_dt_cust) > 0 then ((etd - expected_dt_cust) * penalty_percent * grand_total) else 0 end) 
		// end as estimation_penalty_amount
		// from cf_order as t0) as t1";
		// $params['select']	= isset($params['select']) ? $params['select'] : "*";
		// $params['table'] 	= $table_custom;
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sorder_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_order where id = t1.order_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		// $params['select']	= isset($params['select']) ? $params['select'] : "t1.*, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_order where id = t1.order_id) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		// $params['select']	= isset($params['select']) ? $params['select'] : "t1.*, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_order_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sorder_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
		(select count(doc_no) from cf_invoice where order_plan_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date";
		$params['table'] 	= "cf_order_plan as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.eta, '".$this->session->date_format."') as eta, 
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_order as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_requisition, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_requisition, to_char(t2.eta, '".$this->session->date_format."') as eta_requisition";
			$params['join'][] = ['cf_requisition as t2', 't1.requisition_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_order where id = t1.order_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_order_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
		(select count(doc_no) from cf_invoice where order_plan_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, t1.note as code_name";
		$params['table'] 	= "cf_order_plan as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan_clearance($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select count(doc_no) from cf_invoice where order_plan_clearance_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, t1.note as code_name";
		$params['table'] 	= "cf_order_plan_clearance as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan_import($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select count(doc_no) from cf_invoice where order_plan_import_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, t1.note as code_name";
		$params['table'] 	= "cf_order_plan_import as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.eta, '".$this->session->date_format."') as eta, (select name from cf_request_type where id = t1.request_type_id) as request_type_name, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_request as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order";
			$params['join'][] = ['cf_order as t2', 't1.order_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_request where id = t1.request_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_request where id = t1.request_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_request_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_method." as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_requisition($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.eta, '".$this->session->date_format."') as eta, 
		case when ((select eta from cf_request where id = t1.request_id) - t1.eta) <= 6 then 'Warning' else '' end as eta_status, 
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name,
		((select eta from cf_request where id = t1.request_id) - t1.eta) as estimation_late";
		$params['table'] 	= "cf_requisition as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_request, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_request, to_char(t2.eta, '".$this->session->date_format."') as eta_request";
			$params['join'][] = ['cf_request as t2', 't1.request_id = t2.id', 'left'];
		}
		return $this->base_model->mget_rec($params);
	}
	
	function cf_requisition_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_requisition where id = t1.requisition_id), 
		(select name from m_itemcat where id = t1.itemcat_id) as itemcat_name, ((select doc_no from cf_requisition where id = t1.requisition_id) ||'_'|| (t1.seq) ||'_'|| (select name from m_itemcat where id = t1.itemcat_id)) as list_name";
		$params['table'] 	= "cf_requisition_line as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->order_id) ? 'where t1.id = '.$params->order_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_order t1 set (sub_total, vat_total, grand_total) = 
				(
					select coalesce(sum(sub_amt),0), coalesce(sum(vat_amt),0), coalesce(sum(ttl_amt),0) from cf_order_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "update cf_order t1 set (plan_total) = 
				(
					select coalesce(sum(amount),0) from cf_order_plan t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan_cl) && $params->is_plan_cl) {
			$str = "update cf_order t1 set (plan_cl_total) = 
				(
					select coalesce(sum(amount),0) from cf_order_plan_clearance t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan_im) && $params->is_plan_im) {
			$str = "update cf_order t1 set (plan_im_total) = 
				(
					select coalesce(sum(amount),0) from cf_order_plan_import t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
	/* For CF Sales Order Plan vs Sales Order Line */
	function cf_order_valid_amount($params)
	{
		/* Insert: (grand_total - plan_total) < new_amount => error */
		/* Update: (grand_total - sum(plan_amount except current id)) < new_amount => error */
		$params = is_array($params) ? (object) $params : $params;
		if (! isset($params->order_id) && !$params->order_id)
			return false;
		
		$id = isset($params->id) && $params->id ? 'and t2.id <> '.$params->id : '';
		$order_id = $params->order_id;
		if (isset($params->is_plan) && $params->is_plan) {
			// $str = "SELECT grand_total,
				// (
					// select coalesce(sum(amount),0) from cf_order_plan t2 where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id $id
				// ) as plan_total 
				// from cf_order t1 where t1.id = $order_id";
			$str = "SELECT (grand_total - (select coalesce(sum(amount),0) from cf_order_plan t2 where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id $id)) as amount 
				from cf_order t1 where t1.id = $order_id";
		}
		$row = $this->db->query($str)->row();
		// if ($row->grand_total - $row->plan_total - $params->amount < 0) {
		if ($row->amount - $params->amount < 0) {
			// $this->session->set_flashdata('message', $row->grand_total - $row->plan_total);
			$this->session->set_flashdata('message', $row->amount);
			return FALSE;
		}
		return TRUE;
		// if ($row->grand_total - $row->plan_total < $params->amount)
	}
	
	/* For CF Purchase Order Line vs Requisition Line */
	function cf_order_valid_qty($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		if (! isset($params->requisition_line_id) && !$params->requisition_line_id)
			return false;
		
		$id = $params->requisition_line_id;
		$str = "select (t1.qty - (select coalesce(sum(qty),0) from cf_order_line where is_active = '1' and is_deleted = '0' and requisition_line_id = t1.id)) as qty 
			from cf_requisition_line as t1 where t1.is_deleted = '0' and t1.id = $id";
		$row = $this->db->query($str)->row();
		if ($row->qty - $params->qty < 0) {
			$this->session->set_flashdata('message', $row->qty);
			return FALSE;
		}
		return TRUE;
	}
	
	function cf_ar_ap_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->ar_ap_id) ? 'where t1.id = '.$params->ar_ap_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_ar_ap t1 set (sub_total, vat_total, grand_total) = 
				(
					select coalesce(sum(sub_amt),0), coalesce(sum(vat_amt),0), coalesce(sum(ttl_amt),0) from cf_ar_ap_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.ar_ap_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "update cf_ar_ap t1 set (sub_total, vat_total, grand_total) = 
				(
					select coalesce(sum(sub_amt),0), coalesce(sum(vat_amt),0), coalesce(sum(ttl_amt),0) from cf_ar_ap_plan t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.ar_ap_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
	function cf_ar_ap_valid_amount($params)
	{
		/* Insert: (grand_total - plan_total) < new_amount => error */
		/* Update: (grand_total - sum(plan_amount except current id)) < new_amount => error */
		$params = is_array($params) ? (object) $params : $params;
		if (! isset($params->ar_ap_id) && !$params->ar_ap_id)
			return false;
		
		$id = isset($params->id) && $params->id ? 'and t2.id <> '.$params->id : '';
		$ar_ap_id = $params->ar_ap_id;
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "SELECT (grand_total - (select coalesce(sum(amount),0) from cf_ar_ap_plan t2 where t2.is_active = '1' and t2.is_deleted = '0' and t2.ar_ap_id = t1.id $id)) as amount 
				from cf_ar_ap t1 where t1.id = $ar_ap_id";
		}
		$row = $this->db->query($str)->row();
		if ($row->amount - $params->amount < 0) {
			$this->session->set_flashdata('message', $row->amount);
			return FALSE;
		}
		return TRUE;
	}
	
	function cf_invoice_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->invoice_id) ? 'where t1.id = '.$params->invoice_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_invoice t1 set (sub_total, vat_total, grand_total) = 
				(
					select coalesce(sum(sub_amt),0), coalesce(sum(vat_amt),0), coalesce(sum(ttl_amt),0) from cf_invoice_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "update cf_invoice t1 set (plan_total) = 
				(
					select coalesce(sum(amount),0) from cf_invoice_plan t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
	function cf_invoice_valid_amount($params)
	{
		/* Insert: (grand_total - plan_total) < new_amount => error */
		/* Update: (grand_total - sum(plan_amount except current id)) < new_amount => error */
		$params = is_array($params) ? (object) $params : $params;
		if (! isset($params->invoice_id) && !$params->invoice_id)
			return false;
		
		$id = isset($params->id) && $params->id ? 'and t2.id <> '.$params->id : '';
		$invoice_id = $params->invoice_id;
		if (isset($params->is_plan) && $params->is_plan) {
			// $str = "SELECT grand_total,
				// (
					// select coalesce(sum(amount),0) from cf_invoice_plan t2 where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id $id
				// ) as plan_total 
				// from cf_invoice t1 where t1.id = $invoice_id";
			$str = "SELECT (grand_total - (select coalesce(sum(amount),0) from cf_invoice_plan t2 where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id $id)) as amount 
				from cf_invoice t1 where t1.id = $invoice_id";
		}
		$row = $this->db->query($str)->row();
		// if ($row->grand_total - $row->plan_total - $params->amount < 0) {
		if ($row->amount - $params->amount < 0) {
			// $this->session->set_flashdata('message', $row->grand_total - $row->plan_total);
			$this->session->set_flashdata('message', $row->amount);
			return FALSE;
		}
		return TRUE;
		// if ($row->grand_total - $row->plan_total < $params->amount)
	}
	
	function cf_requisition_valid_qty($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		if (! isset($params->request_line_id) && !$params->request_line_id)
			return false;
		
		$id = $params->request_line_id;
		$str = "select (t1.qty - (select coalesce(sum(qty),0) from cf_requisition_line where is_active = '1' and is_deleted = '0' and request_line_id = t1.id)) as qty 
			from cf_request_line as t1 where t1.is_deleted = '0' and t1.id = $id";
		$row = $this->db->query($str)->row();
		if ($row->qty - $params->qty < 0) {
			$this->session->set_flashdata('message', $row->qty);
			return FALSE;
		}
		return TRUE;
	}

	function db_unmatch_crp_so_vs_invoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as invoice_plan_date, 
		(select to_char(received_plan_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as rcv_plan_date, 
		coalesce(received_plan_date-(select received_plan_date from cf_order_plan where id = t1.order_plan_id), 0) as late,
		(select doc_no from cf_order where id = t1.order_id) as so_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as so_date, 
		(select to_char(etd, '".$this->session->date_format."') from cf_order where id = t1.order_id) as etd, 		
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			) t1";
		// debug($this->base_model->mget_rec($params)->result());
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_unmatch_cpp_po_vs_invoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as invoice_plan_date, 
		(select to_char(payment_plan_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as pay_plan_date, 
		coalesce(payment_plan_date-(select payment_plan_date from cf_order_plan where id = t1.order_plan_id), 0) as late,
		(select doc_no from cf_order where id = t1.order_id) as po_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as po_date, 
		(select to_char(eta, '".$this->session->date_format."') from cf_order where id = t1.order_id) as eta, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_unmatch_crp_oth_inflow_vs_invoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		(select doc_no from cf_ar_ap where id = t1.ar_ap_id) as ar_no, 
		(select to_char(received_plan_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_plan_id) as rcv_plan_date,
		coalesce(received_plan_date-(select received_plan_date from cf_ar_ap_plan where id = t1.ar_ap_plan_id), 0) as late,
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap where id = t1.ar_ap_id) as ar_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_plan_id) as invoice_plan_date";

		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_unmatch_cpp_oth_outflow_vs_invoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		(select doc_no from cf_ar_ap where id = t1.ar_ap_id) as ap_no, 
		(select to_char(payment_plan_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_plan_id) as pay_plan_date,
		coalesce(payment_plan_date-(select payment_plan_date from cf_ar_ap_plan where id = t1.ar_ap_plan_id), 0) as late,	
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap where id = t1.ar_ap_id) as ap_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_plan_id) as invoice_plan_date";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_unmatch_trans_date_so_vs_shp($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(expected_dt_cust, '".$this->session->date_format."') as expected_dt_cust, 
		to_char(etd, '".$this->session->date_format."') as etd, 
		to_char(delivery_date, '".$this->session->date_format."') as delivery_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name,
		(select string_agg(name, E',') from rf_scm_dt_reason where id = ANY(t1.scm_dt_reasons)) as reason_name,
		coalesce((case when delivery_date is null then current_date else delivery_date end) - expected_dt_cust, 0) as late,
		coalesce(expected_dt_cust-current_date, 0) as estimation_late,
		case 
		when (((case when delivery_date is null then current_date else delivery_date end) - expected_dt_cust) * penalty_percent * grand_total) > (max_penalty_percent * grand_total) 
		then (max_penalty_percent * grand_total) 
		else (case when ((case when delivery_date is null then current_date else delivery_date end) - expected_dt_cust) > 0 then (((case when delivery_date is null then current_date else delivery_date end) - expected_dt_cust) * penalty_percent * grand_total) else 0 end) 
		end as penalty_amount";
		$params['table'] 	= "(
			select * from (
				select *,	(select max(delivery_date) from cf_inout where is_active = '1' and is_deleted = '0' and order_id = a1.id limit 1) as delivery_date, current_date
				from cf_order a1 
				where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
				is_active = '1' and is_deleted = '0' and is_sotrx = '1'
			) r1
			where extract(month from etd) = extract(month from current_date) and (delivery_date > etd or delivery_date is null)
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_unmatch_trans_date_po_vs_mr($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		to_char(doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(eta, '".$this->session->date_format."') as eta, 
		to_char(received_date, '".$this->session->date_format."') as received_date, 
		coalesce(eta-current_date, 0) as estimation_late,
		coalesce(received_date-eta, 0) as late,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select t1.*, order_id, received_date from (
			select order_id, 
			max((select (select max(received_date) from cf_inout where id = f1.inout_id) as received_date from cf_inout_line f1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id limit 1)) as received_date
			from cf_order_line t1
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and (select orgtrx_id from cf_order f1 where id = t1.order_id) = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and exists(select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id) 
			group by 1
			) t2 inner join cf_order t1 on t2.order_id = t1.id where received_date > eta and extract(month from eta) = extract(month from current_date) and extract(year from eta) = extract(year from current_date)
		) t1";
		return $this->base_model->mget_rec($params);
	}
	
	function db_outstanding_trans_so($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name, 
		coalesce(expected_dt_cust-current_date, 0) as estimation_late,
		coalesce(current_date-expected_dt_cust, 0) as late,
		(select penalty_percent from cf_order where id = t1.id) as penalty_percent, 
		(select max_penalty_percent from cf_order where id = t1.id) as max_penalty_percent, 
		to_char(doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(expected_dt_cust, '".$this->session->date_format."') as expected_dt_cust, 
		to_char(etd, '".$this->session->date_format."') as etd";
		$params['table'] 	= "(
			select * from cf_order o1
			where 
			client_id = {client_id} and org_id = {org_id} and (select orgtrx_id from cf_order f1 where id = o1.id) in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_sotrx = '1'
			and current_date > o1.etd 
			and exists(
			select 
			distinct(id) 
			from cf_order_line a1
			where is_active = '1' and is_deleted = '0' 
			and a1.order_id = o1.id
			and not exists(
			select * from cf_inout_line 
			where is_active = '1' and is_deleted = '0'
			and is_completed = '1' and order_line_id =a1.id 
			))) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_outstanding_trans_po($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top,  
		coalesce(eta-current_date, 0) as estimation_late,
		coalesce(current_date-eta, 0) as late,
		to_char(doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(eta, '".$this->session->date_format."') as eta";
		$params['table'] 	= "(
			select * from cf_order f1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_sotrx = '0' 
			AND NOT EXISTS(SELECT 1 FROM cf_inout WHERE is_active = '1' AND is_deleted = '0'	AND order_id = f1.ID) 
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_unmatch_daily_entry($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "(
			select to_char(i.date, 'YYYY-MM-DD') as date, '1'::character(1) as is_active, '0'::character(1) as is_deleted,
			(select count(*) as so_unmatch from cf_order where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as ship_unmatch from cf_inout where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as po_unmatch from cf_order where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as mr_unmatch from cf_inout where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as req_unmatch from cf_request where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as pr_unmatch from cf_requisition where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_c_unmatch from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_v_unmatch from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type = '2' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_if_unmatch from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type = '5' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_of_unmatch from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type = '6' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as outflow_unmatch from cf_ar_ap where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_receipt = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inflow_unmatch from cf_ar_ap where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_receipt = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as ar_unmatch from cf_cashbank where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_receipt = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as ap_unmatch from cf_cashbank where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_receipt = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD'))
			from generate_series( date_trunc('month', now()), now(), '1 day'::interval) i
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
		
	function db_late_invoice_vs_bank_received($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		(received_date - received_plan_date) as late,
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date,
		to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "(
				select * from (
					select *, 
					(select received_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = a1.id), 
					(select f2.doc_no as voucher_no from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = a1.id) 
					from cf_invoice a1 
					where 
					client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
					is_active = '1' and is_deleted = '0' and is_receipt = '1' 
				) t1
				where (doc_date is not null and received_date is not null and (received_date > received_plan_date or received_plan_date > current_date) and (extract(month from received_plan_date) = extract(month from current_date) and extract(year from received_plan_date) = extract(year from current_date)))
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_late_invoice_vs_bank_payment($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		(payment_date - payment_plan_date) as late,
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date,
		to_char(t1.payment_date, '".$this->session->date_format."') as payment_date";
		$params['table'] 	= "(
				select * from (
					select *, (select payment_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = a1.id) 
					, (select f2.doc_no as voucher_no from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = a1.id) 
					from cf_invoice a1 
					where 
					client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
					is_active = '1' and is_deleted = '0' and is_receipt = '0' 
				) t1
				where (doc_date is not null and payment_date is not null and (payment_date > payment_plan_date or payment_plan_date > current_date) and (extract(month from payment_plan_date) = extract(month from current_date) and extract(year from payment_plan_date) = extract(year from current_date)))
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_unmatch_invoice_vs_bank_payment($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date,
		to_char(t1.payment_date, '".$this->session->date_format."') as payment_date";
		$params['table'] 	= "(
			select *, (select payment_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id),
			(select f2.doc_no as voucher_no from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id),
			case 
			when payment_plan_date < (select payment_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id) then 'Late Payment'
			when payment_plan_date > (select payment_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id) then 'Advance Payment' end as payment_status
			from cf_invoice t1 
			where 
			f1.client_id = {client_id} and f1.org_id = {org_id} and f1.orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from received_plan_date) = extract(month from current_date) and 
			payment_plan_date <> (select payment_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_uninvoiced_sales_order($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as invoice_plan_date, 
		(select doc_no from cf_order where id = t1.order_id) as so_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as so_date, 
		(select to_char(etd, '".$this->session->date_format."') from cf_order where id = t1.order_id) as etd, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select f1.doc_no,f1.doc_date,f1.bpartner_id,f1.doc_ref_date,g1.id as order_plan_id,g1.order_id, f1.client_id, f1.org_id,f1.orgtrx_id,f1.is_active,f1.is_deleted,f1.id, g1.note,g1.description,f1.grand_total,g1.amount from cf_order f1 inner join 
			cf_order_plan g1 on f1.id = g1.order_id 
			where
			f1.client_id = {client_id} and f1.org_id = {org_id} and f1.orgtrx_id in {orgtrx} and 
			f1.is_active = '1' and f1.is_deleted = '0' and f1.is_sotrx='1' and g1.is_active='1' and g1.is_deleted = '0'
			and not exists(select distinct(id) from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = g1.id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_uninvoiced_purchase_order($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as invoice_plan_date, 
		(select doc_no from cf_order where id = t1.order_id) as so_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as so_date, 
		(select to_char(eta, '".$this->session->date_format."') from cf_order where id = t1.order_id) as eta, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select f1.doc_no,f1.doc_date,f1.bpartner_id,f1.doc_ref_date,g1.id as order_plan_id,g1.order_id, f1.client_id, f1.org_id,f1.orgtrx_id,f1.is_active,f1.is_deleted,f1.id, g1.note,g1.description,g1.amount,f1.grand_total from cf_order f1 inner join 
			cf_order_plan g1 on f1.id = g1.order_id 
			where
			f1.client_id = {client_id} and f1.org_id = {org_id} and f1.orgtrx_id in {orgtrx} and 
			f1.is_active = '1' and f1.is_deleted = '0' and f1.is_sotrx='0' and g1.is_active='1' and g1.is_deleted = '0'
			and not exists(select distinct(id) from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = g1.id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_uninvoiced_other_inflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.plan_date, '".$this->session->date_format."') as invoice_date, (select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_id) as invoice_plan_date, (select doc_no from cf_ar_ap where id = t1.ar_ap_id) as ar_ap_no, (select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap where id = t1.ar_ap_id) as ar_ap_date";
		$params['table'] 	= "(
			select e1.doc_no, e1.doc_date,f1.ar_ap_id,f1.bpartner_id,e1.doc_ref_no,e1.doc_ref_date,e1.description,f1.note,e1.client_id,e1.org_id,e1.orgtrx_id,e1.is_deleted,e1.is_active,e1.id,e1.grand_total,f1.ttl_amt,f1.doc_date as plan_date from cf_ar_ap e1 inner join cf_ar_ap_plan f1 on e1.id=f1.ar_ap_id
			WHERE
			e1.client_id = {client_id} and e1.org_id = {org_id} and e1.orgtrx_id in {orgtrx} and 
			e1.is_active = '1' and e1.is_deleted = '0' and e1.is_receipt ='1' and f1.is_active = '1' and f1.is_deleted = '0'
			and not exists(
			select distinct(id) from cf_invoice where 
			is_active = '1' and is_deleted = '0' and ar_ap_plan_id = f1.id
			) 
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_uninvoiced_other_outflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.plan_date, '".$this->session->date_format."') as invoice_date, (select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_id) as invoice_plan_date, (select doc_no from cf_ar_ap where id = t1.ar_ap_id) as ar_ap_no, (select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap where id = t1.ar_ap_id) as ar_ap_date";
		$params['table'] 	= "(
			select e1.doc_no, e1.doc_date,f1.ar_ap_id,f1.bpartner_id,e1.doc_ref_no,e1.doc_ref_date,e1.description,f1.note,e1.client_id,e1.org_id,e1.orgtrx_id,e1.is_deleted,e1.is_active,e1.id,e1.grand_total,f1.ttl_amt,f1.doc_date as plan_date from cf_ar_ap e1 inner join cf_ar_ap_plan f1 on e1.id=f1.ar_ap_id
			WHERE
			e1.client_id = {client_id} and e1.org_id = {org_id} and e1.orgtrx_id in {orgtrx} and 
			e1.is_active = '1' and e1.is_deleted = '0' and e1.is_receipt ='0' and f1.is_active = '1' and f1.is_deleted = '0'
			and not exists(
			select distinct(id) from cf_invoice where 
			is_active = '1' and is_deleted = '0' and ar_ap_plan_id = f1.id
			) 
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_incomplete_so($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, (select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where order_id = t1.id) as invoice_plan_date, (select doc_no from cf_order where id = t1.id) as so_no, (select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.id) as so_date, (select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= " (
			select * 
			from cf_order f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_sotrx='1'
			and not exists (select distinct(id) from cf_order_plan where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and order_id = f1.id)
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_incomplete_po($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, (select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where order_id = t1.id) as invoice_plan_date, (select doc_no from cf_order where id = t1.id) as so_no, (select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.id) as so_date, (select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= " (
			select * 
			from cf_order f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_sotrx='0'
			and not exists (select distinct(id) from cf_order_plan where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and order_id = f1.id)
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_incomplete_other_inflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date";
		$params['table'] 	= "(
			select * from cf_ar_ap t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and grand_total = 0
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_incomplete_other_outflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date";
		$params['table'] 	= "(
			select * from cf_ar_ap t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and grand_total = 0
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_outstanding_invoice_customer($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= " (
			select * 
			from cf_invoice 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and doc_type = '1' and doc_date is null and invoice_plan_date <= current_date
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

 	function db_outstanding_invoice_supplier($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name,
		case 
		when (t1.doc_type = '2') then 'Vendor' 
		when (t1.doc_type = '3') then 'Clearence'
		when (t1.doc_type = '4') then 'Custom Duty'
		end as document_type";
		$params['table'] 	= "(
			select * 
			from cf_invoice 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and doc_date is null and invoice_plan_date <= current_date
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_other_inflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select * 
			from cf_invoice 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and doc_type = '5' and doc_date is null and invoice_plan_date <= current_date
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_other_outflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top, 
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select * 
			from cf_invoice 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and doc_type = '6' and doc_date is null and invoice_plan_date <= current_date
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_unmatch_so_etd_vs_planner_etd($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.etd, '".$this->session->date_format."') as etd, 
		to_char(t1.expected_dt_cust, '".$this->session->date_format."') as expected_dt_cust, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name,
		array_to_string(scm_dt_reasons, ',') as scm_dt_reasons,
		(select string_agg(name, E',') from rf_scm_dt_reason where id = ANY(t1.scm_dt_reasons)) as reason_name,
		(etd - expected_dt_cust) as estimation_late,
		case when ((etd - expected_dt_cust) * penalty_percent * grand_total) > (max_penalty_percent * grand_total) 
		then (max_penalty_percent * grand_total) 
		else ((etd - expected_dt_cust) * penalty_percent * grand_total) 
		end as estimation_penalty_amount";
		$params['table'] 	= "(
		select * from cf_order where 
		client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and to_char(expected_dt_cust, 'YYYY-MM') = to_char(current_date, 'YYYY-MM') and 
		is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_overdue_uninvoiced_so($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= "(
			select * from cf_invoice t1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and doc_type = '1' and 
			received_plan_date <= current_date and doc_date is null
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_customer_by_amount($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top,
		(current_date-received_plan_date) as estimation_late,
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date,
		case 
		when (current_date-received_plan_date > 0) then 'Over Due' 
		else 'On Due'
		end as aging_ar_status,
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id ) from cf_invoice f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active='1' and is_deleted='0' and received_plan_date <= current_date and
			doc_type in ('1') and doc_date is not null
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_vendor_by_amount($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top,
		(current_date-payment_plan_date) as estimation_late,
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date,
		case 
		when (current_date-payment_plan_date > 0) then 'Over Due' 
		else 'On Due'
		end as aging_ar_status,
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name,case 
		when (t1.doc_type = '2') then 'vendor' 
		when (t1.doc_type = '3') then 'Clearence'
		when (t1.doc_type = '4') then 'Custom Duty'
		else ''
		end as document_type";
		$params['table'] 	= "(
		select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
		from cf_invoice f1 where  
		client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
		is_active='1' and is_deleted='0' and payment_plan_date <= current_date and
		doc_type in ('2','3','4') and doc_date is not null
		and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_other_outflow_by_amount($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top,
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date,
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date,
		(current_date-payment_plan_date) as estimation_late,
		case 
		when (current_date-payment_plan_date > 0) then 'Over Due' 
		else 'On Due'
		end as aging_ar_status, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= "(
			select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
			from cf_invoice f1
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active='1' and is_deleted='0' and payment_plan_date <= current_date and
			doc_type in ('6') and doc_date is not null
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_other_inflow_by_amount($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select so_top from c_bpartner where id = t1.bpartner_id) as so_top,
		(current_date-received_plan_date) as estimation_late,
		case 
		when (current_date-received_plan_date > 0) then 'Over Due' 
		else 'On Due'
		end as aging_ar_status,
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= "(
			select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id ) from cf_invoice f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active='1' and is_deleted='0' and received_plan_date <= current_date and
			doc_type in ('5') and doc_date is not null
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_incomplete_request($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		coalesce(current_date - doc_date, 0) as late,
		t1.*, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name,
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.eta, '".$this->session->date_format."') as eta, (select name from cf_request_type where id = t1.request_type_id) as request_type_name,(select doc_no from cf_order where id = t1.order_id) as doc_no_order,(select doc_date from cf_order where id = t1.order_id) as doc_date_order,  coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "(
			select * from cf_request f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' 
			and exists (
			select distinct(request_id) from cf_request_line a1 where is_active = '1' and is_deleted = '0' and is_stocked = '0'
			and not exists (select * from cf_requisition_line b1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and request_line_id = a1.id)
			and a1.request_id = f1.id)
		)t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_request($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		coalesce(current_date - eta, 0) as late,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name,
		(select residence from c_bpartner where id = t1.bpartner_id) as residence,
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.eta, '".$this->session->date_format."') as eta, 
		(select name from cf_request_type where id = t1.request_type_id) as request_type_name,
		(select doc_no from cf_order where id = t1.order_id) as doc_no_order,
		(select doc_date from cf_order where id = t1.order_id) as doc_date_order,  
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "(
			select * from cf_request f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and eta <= (current_date + 3)
			and exists (
			select distinct(request_id) from cf_request_line a1 where is_active = '1' and is_deleted = '0'
			and not exists (select 1 from cf_movement_line b1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and request_line_id = a1.id)
			and a1.request_id = f1.id
			)
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_requisition($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence,
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_requisition_line s1 where requisition_id = t1.id) as category_name,
		coalesce(eta - current_date , 0) as estimation_late,
		coalesce(current_date - eta, 0) as late,
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.eta, '".$this->session->date_format."') as eta, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "(
			select *,(select eta from cf_request where id = f1.request_id ) as eta_request from cf_requisition f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0'
			and exists (
			Select distinct(requisition_id) from cf_requisition_line a1 where 
			is_active = '1' and is_deleted = '0'
			and a1.requisition_id = f1.id
			and not exists (select * from cf_order_line b1 where 
			is_active = '1' and is_deleted = '0' and is_completed= '1' and requisition_line_id = a1.id)
			)
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_outbound($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name,
		coalesce(current_date - (select eta from cf_request where id = t1.request_id), 0) as late, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		(select name from a_org where id = t1.org_to_id) as org_to_name, 
		(select name from a_org where id = t1.orgtrx_to_id) as orgtrx_to_name, 
		t1.*, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_movement_line s1 where movement_id = t1.id) as category_name,
		(select doc_no from cf_request where id = t1.request_id) as doc_no_request,
		(select to_char(doc_date, '".$this->session->date_format."') from cf_request where id = t1.request_id) as doc_date_request,
		(select to_char(eta, '".$this->session->date_format."') from cf_request where id = t1.request_id) as eta_request,
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, 
		to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] = "(
			select * from cf_movement where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_to_id in {orgtrx} and  
			is_active = '1' and is_deleted = '0' and received_date is null 
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_unmatch_po_plan_vs_invoice_payment_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = (select bpartner_id from cf_order where id = t1.order_id)) as bpartner_name, 
		(select doc_no from cf_order where id = t1.order_id) as doc_no_order,
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		to_char(t1.payment_plan_date_invoice, '".$this->session->date_format."') as payment_plan_date_invoice, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date_order"
		;
		$params['table'] = "(
			select * from 
			(
			select *, (select bpartner_id from cf_order where id = t0.order_id), 
			(select orgtrx_id from cf_order where is_active = '1' and is_deleted = '0' and id = t1.order_id), 
			(select payment_plan_date from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_id = t1.id) as payment_plan_date_invoice
			from cf_order_plan t1 where is_active = '1' and is_deleted = '0' 
			and client_id = {client_id} and org_id = {org_id} and exists(select 1 from cf_order where is_active = '1' and is_deleted = '0' and id = t1.order_id and orgtrx_id in {orgtrx} and is_sotrx = '0') 
			and exists(select 1 from cf_invoice f1 where is_active = '1' and is_deleted = '0' and doc_type = '2' 
			and payment_plan_date > t1.payment_plan_date and order_plan_id = t1.id and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id))
			union all
			select *, 
			(select orgtrx_id from cf_order where is_active = '1' and is_deleted = '0' and id = t1.order_id), 
			(select payment_plan_date from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_clearance_id = t1.id) as payment_plan_date_invoice
			from cf_order_plan_clearance t1 where is_active = '1' and is_deleted = '0' 
			and client_id = {client_id} and org_id = {org_id} and exists(select 1 from cf_order where is_active = '1' and is_deleted = '0' and id = t1.order_id and orgtrx_id in {orgtrx} and is_sotrx = '0') 
			and exists(select 1 from cf_invoice f1 where is_active = '1' and is_deleted = '0' and doc_type = '3' 
			and payment_plan_date > t1.payment_plan_date and order_plan_clearance_id = t1.id and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id))
			union all
			select *, 
			(select orgtrx_id from cf_order where is_active = '1' and is_deleted = '0' and id = t1.order_id), 
			(select payment_plan_date from cf_invoice where is_active = '1' and is_deleted = '0' and order_plan_import_id = t1.id) as payment_plan_date_invoice
			from cf_order_plan_import t1 where is_active = '1' and is_deleted = '0' 
			and client_id = {client_id} and org_id = {org_id} and exists(select 1 from cf_order where is_active = '1' and is_deleted = '0' and id = t1.order_id and orgtrx_id in {orgtrx} and is_sotrx = '0') 
			and exists(select 1 from cf_invoice f1 where is_active = '1' and is_deleted = '0' and doc_type = '4' 
			and payment_plan_date > t1.payment_plan_date and order_plan_import_id = t1.id and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id))
			) t0
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function rpt_cf_statement_invoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		t1.account_id, (select is_receipt from cf_account where id = t1.account_id), type, seq, description, 
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as current 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date = '".$params['date']."' or payment_plan_date = '".$params['date']."')
		),
		(
			select coalesce(sum(case when s1.received_date is not null then amount else -amount end), 0) as current_actual 
			from cf_cashbank s1 inner join cf_cashbank_line s2 on s1.id = s2.cashbank_id and s2.is_active = '1' and s2.is_deleted = '0'
			where s1.client_id = {client_id} and s1.org_id = {org_id} and s1.orgtrx_id in {orgtrx} and
			s1.is_active = '1' and s1.is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and (received_date = '".$params['date']."' or payment_date = '".$params['date']."')
		),
		'account_id='||t1.account_id||',date='''||'".$params['date']."'||''',type=1' as today_param,
		'account_id='||t1.account_id||',date='''||'".$params['date']."'||''',type=2' as today_a_param,
		'Projection Today' as today_title,
		'Actual Today' as today_a_title
		"
		;
		$params['table'] = "cf_rpt_cashflow_projection as t1";
		$params['select'] = translate_variable($params['select']);
		$params['where']['is_show_for_daily'] = '1';
		$params['xdel'] = false;
		$result = $this->base_model->mget_rec($params);
		
		// Processed to calculate CASH & CASH EQUIVALENT
		$qry = "select coalesce(sum(amount), 0) as amount from cf_cashbank_balance 
		where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
		is_active = '1' and is_deleted = '0' and doc_date = '".$params['date']."'";
		$qry = translate_variable($qry);
		$cb_amount = $this->db->query($qry)->row()->amount;
		
		foreach ($result['rows'] as $k => $v){
			if ($v->seq == 41) {
				$amount[0] = $v->current;
			}
			if ($v->seq == 45) {
				$amount[0] += $v->current;
			}
			if ($v->seq == 47) {
				// $result['rows'][46]->current = $cb_amount;
				// $result['rows'][47]->current = $cb_amount + $amount[0];
			}
		}
		return $result;
	}
	
	function rpt_cf_statement_invoice_old($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		t1.account_id, (select is_receipt from cf_account where id = t1.account_id), type, seq, description, 
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as prev_90_after 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date < ('".$params['date']."'::date - interval '90 day')::date or payment_plan_date < ('".$params['date']."'::date - interval '90 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as prev_90 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date between ('".$params['date']."'::date - interval '90 day')::date and ('".$params['date']."'::date - interval '61 day')::date or payment_plan_date between ('".$params['date']."'::date - interval '90 day')::date and ('".$params['date']."'::date - interval '61 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as prev_60 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date between ('".$params['date']."'::date - interval '60 day')::date and ('".$params['date']."'::date - interval '31 day')::date or payment_plan_date between ('".$params['date']."'::date - interval '60 day')::date and ('".$params['date']."'::date - interval '31 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as prev_30 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date between ('".$params['date']."'::date - interval '30 day')::date and ('".$params['date']."'::date - interval '1 day')::date or payment_plan_date between ('".$params['date']."'::date - interval '30 day')::date and ('".$params['date']."'::date - interval '1 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as total_outstanding 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date < '".$params['date']."' or payment_plan_date < '".$params['date']."')
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as total_projection 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date >= '".$params['date']."' or payment_plan_date >= '".$params['date']."')
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as grand_total 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as current 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date = '".$params['date']."' or payment_plan_date = '".$params['date']."')
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as next_30 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date between ('".$params['date']."'::date + interval '1 day')::date and ('".$params['date']."'::date + interval '30 day')::date or payment_plan_date between ('".$params['date']."'::date + interval '1 day')::date and ('".$params['date']."'::date + interval '30 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as next_60 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date between ('".$params['date']."'::date + interval '31 day')::date and ('".$params['date']."'::date + interval '60 day')::date or payment_plan_date between ('".$params['date']."'::date + interval '31 day')::date and ('".$params['date']."'::date + interval '60 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as next_90 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date between ('".$params['date']."'::date + interval '61 day')::date and ('".$params['date']."'::date + interval '90 day')::date or payment_plan_date between ('".$params['date']."'::date + interval '61 day')::date and ('".$params['date']."'::date + interval '90 day')::date)
		),
		(
			select coalesce(sum(case is_receipt when '1' then net_amount else -net_amount end), 0) as next_90_after 
			from cf_invoice s1
			where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
			is_active = '1' and is_deleted = '0' and account_id = ANY(ARRAY[t1.accounts])
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = s1.id)
			and (received_plan_date > ('".$params['date']."'::date + interval '90 day')::date or payment_plan_date > ('".$params['date']."'::date + interval '90 day')::date)
		),
		'account_id='||t1.account_id||',(received_plan_date<'''||('".$params['date']."'::date - interval '90 day')::date||''' or payment_plan_date<'''||('".$params['date']."'::date - interval '90 day')::date||''')' as prev_90_after_param,
		'account_id='||t1.account_id||',(received_plan_date between '''||('".$params['date']."'::date - interval '90 day')::date||''' and '''||('".$params['date']."'::date - interval '61 day')::date||''' or payment_plan_date between '''||('".$params['date']."'::date - interval '90 day')::date||'''  and '''||('".$params['date']."'::date - interval '61 day')::date||''')' as prev_90_param,
		'account_id='||t1.account_id||',(received_plan_date between '''||('".$params['date']."'::date - interval '60 day')::date||''' and '''||('".$params['date']."'::date - interval '31 day')::date||''' or payment_plan_date between '''||('".$params['date']."'::date - interval '60 day')::date||'''  and '''||('".$params['date']."'::date - interval '31 day')::date||''')' as prev_60_param,
		'account_id='||t1.account_id||',(received_plan_date between '''||('".$params['date']."'::date - interval '30 day')::date||''' and '''||('".$params['date']."'::date - interval '1 day')::date||''' or payment_plan_date between '''||('".$params['date']."'::date - interval '30 day')::date||'''  and '''||('".$params['date']."'::date - interval '1 day')::date||''')' as prev_30_param,
		'account_id='||t1.account_id||',(received_plan_date='''||'".$params['date']."'::date||''' or payment_plan_date='''||'".$params['date']."'::date||''')' as today_param,
		'account_id='||t1.account_id||',(received_plan_date between '''||('".$params['date']."'::date + interval '1 day')::date||''' and '''||('".$params['date']."'::date + interval '30 day')::date||''' or payment_plan_date between '''||('".$params['date']."'::date + interval '1 day')::date||'''  and '''||('".$params['date']."'::date + interval '30 day')::date||''')' as next_30_param,
		'account_id='||t1.account_id||',(received_plan_date between '''||('".$params['date']."'::date + interval '31 day')::date||''' and '''||('".$params['date']."'::date + interval '60 day')::date||''' or payment_plan_date between '''||('".$params['date']."'::date + interval '31 day')::date||'''  and '''||('".$params['date']."'::date + interval '60 day')::date||''')' as next_60_param,
		'account_id='||t1.account_id||',(received_plan_date between '''||('".$params['date']."'::date + interval '61 day')::date||''' and '''||('".$params['date']."'::date + interval '90 day')::date||''' or payment_plan_date between '''||('".$params['date']."'::date + interval '61 day')::date||'''  and '''||('".$params['date']."'::date + interval '90 day')::date||''')' as next_90_param,
		'account_id='||t1.account_id||',(received_plan_date>'''||('".$params['date']."'::date + interval '90 day')::date||''' or payment_plan_date>'''||('".$params['date']."'::date + interval '90 day')::date||''')' as next_90_after_param,
		'Outstanding > 90 Days' as prev_90_after_title,
		'Outstanding 60-90 Days' as prev_90_title,
		'Outstanding 30-60 Days' as prev_60_title,
		'Outstanding 1-30 Days' as prev_30_title,
		'Projection Today' as today_title,
		'Projection 1-30 Days' as next_30_title,
		'Projection 30-60 Days' as next_60_title,
		'Projection 60-90 Days' as next_90_title,
		'Projection > 90 Days' as next_90_after_title"
		;
		$params['table'] = "cf_rpt_cashflow_projection as t1";
		$params['select'] = translate_variable($params['select']);
		$params['xdel'] = false;
		$result = $this->base_model->mget_rec($params);
		
		// Processed to calculate CASH & CASH EQUIVALENT
		$qry = "select coalesce(sum(amount), 0) as amount from cf_cashbank_balance 
		where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and
		is_active = '1' and is_deleted = '0' and doc_date = '".$params['date']."'";
		$qry = translate_variable($qry);
		$cb_amount = $this->db->query($qry)->row()->amount;
		
		foreach ($result['rows'] as $k => $v){
			if ($v->seq == 41) {
				$amount[0] = $v->current;
				$amount[1] = $v->next_30;
				$amount[2] = $v->next_60;
				$amount[3] = $v->next_90;
				$amount[4] = $v->next_90_after;
			}
			if ($v->seq == 45) {
				$amount[0] += $v->current;
				$amount[1] += $v->next_30;
				$amount[2] += $v->next_60;
				$amount[3] += $v->next_90;
				$amount[4] += $v->next_90_after;
			}
			if ($v->seq == 47) {
				$result['rows'][46]->current = $cb_amount;
				$result['rows'][47]->current = $cb_amount + $amount[0];
				$result['rows'][46]->next_30 = $result['rows'][47]->current;
				$result['rows'][47]->next_30 = $result['rows'][47]->current + $amount[1];
				$result['rows'][46]->next_60 = $result['rows'][47]->next_30;
				$result['rows'][47]->next_60 = $result['rows'][47]->next_30 + $amount[2];
				$result['rows'][46]->next_90 = $result['rows'][47]->next_60;
				$result['rows'][47]->next_90 = $result['rows'][47]->next_60 + $amount[3];
				$result['rows'][46]->next_90_after = $result['rows'][47]->next_90;
				$result['rows'][47]->next_90_after = $result['rows'][47]->next_90 + $amount[4];
			}
		}
		return $result;
	}
	
	function rpt_cf_statement_invoice_detail($params)
	{
		if ($params['type'] == 1) {
			$params['select']	= isset($params['select']) ? $params['select'] : "
			(select name from a_org where id = t1.org_id) as org_name, 
			(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
			(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name,
			(select name from cf_account where id = t1.account_id) as account_name,
			case doc_type 
			when '1' then 'Sales Order' 
			when '2' then 'Purchase Order'
			when '3' then 'Purchase Order Clearance'
			when '4' then 'Purchase Order Custom Duty'
			when '5' then 'Other Inflow'
			when '6' then 'Other Outflow'
			end as doc_type_name,
			case doc_type 
			when '1' then (select doc_no from cf_order where id = t1.order_id) 
			when '2' then (select doc_no from cf_order where id = t1.order_id)
			when '3' then (select doc_no from cf_order where id = t1.order_id)
			when '4' then (select doc_no from cf_order where id = t1.order_id)
			when '5' then (select doc_no from cf_ar_ap where id = t1.ar_ap_id)
			when '6' then (select doc_no from cf_ar_ap where id = t1.ar_ap_id)
			end as doc_type_reference,
			doc_no as invoice_no, 
			to_char(invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
			to_char(doc_date, '".$this->session->date_format."') as invoice_date, 
			to_char(received_plan_date, '".$this->session->date_format."') as received_plan_date, 
			to_char(payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
			note, description, amount, adj_amount, net_amount,
			(select (select doc_no from cf_cashbank where id = s1.cashbank_id) from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id) as voucher_no, 
			(select (select to_char(doc_date, '".$this->session->date_format."') from cf_cashbank where id = s1.cashbank_id) from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id) as voucher_date,
			(select name from a_user where id = t1.created_by) as created_by_name,
			(select name from a_user where id = t1.updated_by) as updated_by_name, is_receipt"
			;
			$params['table'] = "cf_invoice as t1";
			$params['where']['is_active'] = '1';
			$params['where']['account_id'] = $params['account_id'];
			$params['where_custom'][] = "(received_plan_date = ".$params['date']." or payment_plan_date = ".$params['date'].")";
			$params['where_custom'][] = "not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = t1.id)";
		}
		if ($params['type'] == 2) {
			$params['select']	= isset($params['select']) ? $params['select'] : "
			(select name from a_org where id = t1.org_id) as org_name, 
			(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
			(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name,
			(select name from cf_account where id = t1.account_id) as account_name,
			case doc_type 
			when '1' then 'Sales Order' 
			when '2' then 'Purchase Order'
			when '3' then 'Purchase Order Clearance'
			when '4' then 'Purchase Order Custom Duty'
			when '5' then 'Other Inflow'
			when '6' then 'Other Outflow'
			end as doc_type_name,
			case doc_type 
			when '1' then (select doc_no from cf_order where id = t1.order_id) 
			when '2' then (select doc_no from cf_order where id = t1.order_id)
			when '3' then (select doc_no from cf_order where id = t1.order_id)
			when '4' then (select doc_no from cf_order where id = t1.order_id)
			when '5' then (select doc_no from cf_ar_ap where id = t1.ar_ap_id)
			when '6' then (select doc_no from cf_ar_ap where id = t1.ar_ap_id)
			end as doc_type_reference,
			doc_no as invoice_no, 
			to_char(invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
			to_char(doc_date, '".$this->session->date_format."') as invoice_date, 
			to_char(received_plan_date, '".$this->session->date_format."') as received_plan_date, 
			to_char(payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
			note, description, amount, adj_amount, net_amount,
			(select (select doc_no from cf_cashbank where id = s1.cashbank_id) from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id) as voucher_no, 
			(select (select to_char(doc_date, '".$this->session->date_format."') from cf_cashbank where id = s1.cashbank_id) from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id) as voucher_date,
			(select name from a_user where id = t1.created_by) as created_by_name,
			(select name from a_user where id = t1.updated_by) as updated_by_name, is_receipt,
			(select doc_no as voucher_no from cf_cashbank where id = (select cashbank_id from cf_cashbank_line where invoice_id = t1.id and is_active = '1' and is_deleted = '0')),
			(select doc_date as voucher_date from cf_cashbank where id = (select cashbank_id from cf_cashbank_line where invoice_id = t1.id and is_active = '1' and is_deleted = '0'))
			";
			$params['table'] = "cf_invoice as t1";
			$params['where']['is_active'] = '1';
			$params['where']['account_id'] = $params['account_id'];
			$params['where_custom'][] = "((select received_date from cf_cashbank where id = (select cashbank_id from cf_cashbank_line where invoice_id = t1.id and is_active = '1' and is_deleted = '0')) = ".$params['date']." or (select payment_date from cf_cashbank where id = (select cashbank_id from cf_cashbank_line where invoice_id = t1.id and is_active = '1' and is_deleted = '0')) = ".$params['date'].")";
			$params['where_custom'][] = "exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = t1.id)";
		}
		
		return $this->base_model->mget_rec($params);
	}

	function rf_invoice_adj_reason($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= "rf_invoice_adj_reason as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function rf_scm_dt_reason($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= "rf_scm_dt_reason as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function va_finance($params)
	{
		$fdate = $params['fdate'];
		$tdate = $params['tdate'];

		/* line chart */
		if (date_differ($fdate, $tdate, 'day') < 32) {
			$str = "select i.date, to_char(i.date, 'Mon DD') as name,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date = i.date) as total_projection1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date = i.date) as total_projection2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date = i.date) as total_projection3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date = i.date) as total_projection4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date = i.date and doc_date = invoice_plan_date) as total_release1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date = i.date and doc_date = invoice_plan_date) as total_release2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date = i.date and doc_date = invoice_plan_date) as total_release3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date = i.date and doc_date = invoice_plan_date) as total_release4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date = i.date and doc_date < invoice_plan_date) as total_release_early1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date = i.date and doc_date < invoice_plan_date) as total_release_early2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date = i.date and doc_date < invoice_plan_date) as total_release_early3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date = i.date and doc_date < invoice_plan_date) as total_release_early4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date = i.date and doc_date > invoice_plan_date) as total_release_late1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date = i.date and doc_date > invoice_plan_date) as total_release_late2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date = i.date and doc_date > invoice_plan_date) as total_release_late3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date = i.date and doc_date > invoice_plan_date) as total_release_late4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date = i.date and doc_date is null) as total_unrelease1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date = i.date and doc_date is null) as total_unrelease2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date = i.date and doc_date is null) as total_unrelease3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date = i.date and doc_date is null) as total_unrelease4
			from generate_series('$fdate', '$tdate', '1 day'::interval) i;";
		} else {
			$str = "select i.date, (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE as end_of_month, to_char(i.date, 'Mon') as name,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date = invoice_plan_date) as total_release1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date = invoice_plan_date) as total_release2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date = invoice_plan_date) as total_release3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date = invoice_plan_date) as total_release4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date < invoice_plan_date) as total_release_early1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date < invoice_plan_date) as total_release_early2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date < invoice_plan_date) as total_release_early3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date < invoice_plan_date) as total_release_early4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date > invoice_plan_date) as total_release_late1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date > invoice_plan_date) as total_release_late2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date > invoice_plan_date) as total_release_late3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date > invoice_plan_date) as total_release_late4,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date is null) as total_unrelease1,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date is null) as total_unrelease2,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date is null) as total_unrelease3,
			(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and doc_date is null) as total_unrelease4
			from generate_series('$fdate', '$tdate', '1 month'::interval) i;";
		}
		$str = translate_variable($str);
		// debug($str);
		$qry = $this->db->query($str);
		if ($qry->num_rows() > 0) {
			$arr['labels'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->total_projection1;
				$arr['data2'][] = $row->total_release1;
				$arr['data3'][] = $row->total_release_early1;
				$arr['data4'][] = $row->total_release_late1;
				$arr['data5'][] = $row->total_unrelease1;
				$arr2['labels'][] = $row->name;
				$arr2['data1'][] = $row->total_projection2;
				$arr2['data2'][] = $row->total_release2;
				$arr2['data3'][] = $row->total_release_early2;
				$arr2['data4'][] = $row->total_release_late2;
				$arr2['data5'][] = $row->total_unrelease2;
				$arr3['labels'][] = $row->name;
				$arr3['data1'][] = $row->total_projection3;
				$arr3['data2'][] = $row->total_release3;
				$arr3['data3'][] = $row->total_release_early3;
				$arr3['data4'][] = $row->total_release_late3;
				$arr3['data5'][] = $row->total_unrelease3;
				$arr4['labels'][] = $row->name;
				$arr4['data1'][] = $row->total_projection4;
				$arr4['data2'][] = $row->total_release4;
				$arr4['data3'][] = $row->total_release_early4;
				$arr4['data4'][] = $row->total_release_late4;
				$arr4['data5'][] = $row->total_unrelease4;
			}
			/* datasets for line chart */
			$result['data']['linechart']['labels'] = $arr['labels'];
			$result['data']['linechart']['datasets'][] = ['label' => 'Invoice Customer Plan', 'borderColor' => get_rgba('red'), 'data' => $arr['data1']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr['data2']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr['data3']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr['data4']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr['data5']];
			/* datasets for line chart2 */
			$result['data']['linechart2']['labels'] = $arr2['labels'];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Invoice Inflow Plan', 'borderColor' => get_rgba('red'), 'data' => $arr2['data1']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr2['data2']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr2['data3']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr2['data4']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr2['data5']];
			/* datasets for line chart3 */
			$result['data']['linechart3']['labels'] = $arr3['labels'];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Invoice Vendor Plan', 'borderColor' => get_rgba('red'), 'data' => $arr3['data1']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr3['data2']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr3['data3']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr3['data4']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr3['data5']];
			/* datasets for line chart4 */
			$result['data']['linechart4']['labels'] = $arr4['labels'];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Invoice Outflow Plan', 'borderColor' => get_rgba('red'), 'data' => $arr4['data1']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr4['data2']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr4['data3']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr4['data4']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr4['data5']];
		}	
		/* total & release by document */
		$str = "with tmp as (
		select 
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate') as total_projection1,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate') as total_projection2,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate') as total_projection3,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate') as total_projection4,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release1,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release2,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release3,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release4,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early1,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early2,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early3,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early4,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late1,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late2,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late3,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late4,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease1,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease2,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease3,
		(select count(*) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease4
		) select *, 
		(100 * t1.total_release1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_percent1, 
		(100 * t1.total_release2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_percent2, 
		(100 * t1.total_release3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_percent3, 
		(100 * t1.total_release4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_percent4, 
		(100 * t1.total_release_early1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_early_percent1, 
		(100 * t1.total_release_early2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_early_percent2, 
		(100 * t1.total_release_early3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_early_percent3, 
		(100 * t1.total_release_early4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_early_percent4, 
		(100 * t1.total_release_late1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_late_percent1, 
		(100 * t1.total_release_late2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_late_percent2, 
		(100 * t1.total_release_late3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_late_percent3, 
		(100 * t1.total_release_late4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_late_percent4, 
		(100 * t1.total_unrelease1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_unrelease_percent1,
		(100 * t1.total_unrelease2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_unrelease_percent2,
		(100 * t1.total_unrelease3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_unrelease_percent3,
		(100 * t1.total_unrelease4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_unrelease_percent4
		from tmp as t1;";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_by_document'] = $row;
		/* total & release by amount */
		$str = "with tmp as (
		select 
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate') as total_projection1,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate') as total_projection2,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate') as total_projection3,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate') as total_projection4,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release1,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release2,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release3,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date = invoice_plan_date) as total_release4,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early1,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early2,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early3,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date < invoice_plan_date) as total_release_early4,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late1,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late2,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late3,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date > invoice_plan_date) as total_release_late4,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('1') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease1,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('5') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease2,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('2','3','4') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease3,
		(select coalesce(sum(net_amount), 0) from cf_invoice where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_type in ('6') and invoice_plan_date between '$fdate' and '$tdate' and doc_date is null) as total_unrelease4
		) select *, 
		(100 * t1.total_release1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_percent1, 
		(100 * t1.total_release2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_percent2, 
		(100 * t1.total_release3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_percent3, 
		(100 * t1.total_release4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_percent4, 
		(100 * t1.total_release_early1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_early_percent1, 
		(100 * t1.total_release_early2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_early_percent2, 
		(100 * t1.total_release_early3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_early_percent3, 
		(100 * t1.total_release_early4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_early_percent4, 
		(100 * t1.total_release_late1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_late_percent1, 
		(100 * t1.total_release_late2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_late_percent2, 
		(100 * t1.total_release_late3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_late_percent3, 
		(100 * t1.total_release_late4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_late_percent4, 
		(100 * t1.total_unrelease1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_unrelease_percent1,
		(100 * t1.total_unrelease2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_unrelease_percent2,
		(100 * t1.total_unrelease3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_unrelease_percent3,
		(100 * t1.total_unrelease4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_unrelease_percent4
		from tmp as t1;";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_by_amount'] = $row;
		
		xresponse(TRUE, $result);
	}

	function va_finance_dd($params)
	{
		$fdate = $params['fdate'];
		$tdate = $params['tdate'];

		// if ($params['doc'] == 1) { $doc = "t1.doc_type in ('1')"; $title = "Invoice Customer"; }
		// if ($params['doc'] == 2) { $doc = "t1.doc_type in ('5')"; $title = "Invoice Inflow"; }
		// if ($params['doc'] == 3) { $doc = "t1.doc_type in ('2','3','4')"; $title = "Invoice Vendor"; }
		// if ($params['doc'] == 4) { $doc = "t1.doc_type in ('6')"; $title = "Invoice Outflow"; }
		
		// if ($params['lvl'] == 1) { $lvl = ""; $title .= " Plan"; }
		// if ($params['lvl'] == 2) { $lvl = "doc_date = invoice_plan_date"; $title .= " Actual (Ontime)"; }
		// if ($params['lvl'] == 3) { $lvl = "doc_date < invoice_plan_date"; $title .= " Actual (Early)"; }
		// if ($params['lvl'] == 4) { $lvl = "doc_date > invoice_plan_date"; $title .= " Actual (Late)"; }
		// if ($params['lvl'] == 5) { $lvl = "doc_date is null"; $title .= " Not Yet Release"; }
		
		if ($params['doc'] == 1) $doc = "t1.doc_type in ('1')"; 
		if ($params['doc'] == 2) $doc = "t1.doc_type in ('5')"; 
		if ($params['doc'] == 3) $doc = "t1.doc_type in ('2','3','4')"; 
		if ($params['doc'] == 4) $doc = "t1.doc_type in ('6')"; 
		
		if ($params['lvl'] == 1) $lvl = ""; 
		if ($params['lvl'] == 2) $lvl = "doc_date = invoice_plan_date"; 
		if ($params['lvl'] == 3) $lvl = "doc_date < invoice_plan_date"; 
		if ($params['lvl'] == 4) $lvl = "doc_date > invoice_plan_date"; 
		if ($params['lvl'] == 5) $lvl = "doc_date is null"; 
		
		$params['select']	= isset($params['select']) ? $params['select'] : "
		case t1.doc_type when '1' then 'Invoice Customer' when '2' then 'Invoice Vendor' when '3' then 'Invoice Clearence' when '4' then 'Invoice Custom Duty' when '5' then 'Invoice Inflow' when '6' then 'Invoice Outflow' end as invoice_type,
		(select name as org_name from a_org where id = t1.org_id), 
		(select name as orgtrx_name from a_org where id = t1.orgtrx_id), 
		(select residence from c_bpartner where id = t1.bpartner_id),
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') as category_name from cf_order_line s1 where order_id = t1.order_id),
		(select name as bpartner_name from c_bpartner where id = t1.bpartner_id), 
		t1.doc_no, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		t1.amount, t1.adj_amount, t1.net_amount,
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		t1.note, t1.description,
		(select name as account_name from cf_account where id = t1.account_id),
		(select name as created_by_name from a_user where id = t1.created_by)";
		$params['table'] 	= "cf_invoice as t1";
		$params['where_custom'][] = "invoice_plan_date between '$fdate' and '$tdate' and $doc".($lvl ? " and $lvl" : "");
		
		return $this->base_model->mget_rec($params);
		// $result = $this->base_model->mget_rec($params);
		// $result['title'] = $title;
		// return $result;
	}
	
	function va_finance2($params)
	{
		$fdate = $params['fdate'];
		$tdate = $params['tdate'];

		/* line chart */
		if (date_differ($fdate, $tdate, 'day') < 32) {
			$str = "select i.date, to_char(i.date, 'Mon DD') as name,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date = i.date) as total_projection1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date = i.date) as total_projection2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date = i.date) as total_projection3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date = i.date) as total_projection4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date = i.date and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date = i.date and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date = i.date and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date = i.date and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date = i.date and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease4
			from generate_series('$fdate', '$tdate', '1 day'::interval) i;";
		} else {
			$str = "select i.date, (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE as end_of_month, to_char(i.date, 'Mon') as name,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_projection4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late4,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease1,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease2,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease3,
			(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease4
			from generate_series('$fdate', '$tdate', '1 month'::interval) i;";
		}
		$str = translate_variable($str);
		// debug($str);
		$qry = $this->db->query($str);
		if ($qry->num_rows() > 0) {
			$arr['labels'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->total_projection1;
				$arr['data2'][] = $row->total_release1;
				$arr['data3'][] = $row->total_release_early1;
				$arr['data4'][] = $row->total_release_late1;
				$arr['data5'][] = $row->total_unrelease1;
				$arr2['labels'][] = $row->name;
				$arr2['data1'][] = $row->total_projection2;
				$arr2['data2'][] = $row->total_release2;
				$arr2['data3'][] = $row->total_release_early2;
				$arr2['data4'][] = $row->total_release_late2;
				$arr2['data5'][] = $row->total_unrelease2;
				$arr3['labels'][] = $row->name;
				$arr3['data1'][] = $row->total_projection3;
				$arr3['data2'][] = $row->total_release3;
				$arr3['data3'][] = $row->total_release_early3;
				$arr3['data4'][] = $row->total_release_late3;
				$arr3['data5'][] = $row->total_unrelease3;
				$arr4['labels'][] = $row->name;
				$arr4['data1'][] = $row->total_projection4;
				$arr4['data2'][] = $row->total_release4;
				$arr4['data3'][] = $row->total_release_early4;
				$arr4['data4'][] = $row->total_release_late4;
				$arr4['data5'][] = $row->total_unrelease4;
			}
			/* datasets for line chart */
			$result['data']['linechart']['labels'] = $arr['labels'];
			$result['data']['linechart']['datasets'][] = ['label' => 'Plan', 'borderColor' => get_rgba('red'), 'data' => $arr['data1']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr['data2']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr['data3']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr['data4']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr['data5']];
			/* datasets for line chart2 */
			$result['data']['linechart2']['labels'] = $arr2['labels'];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Plan', 'borderColor' => get_rgba('red'), 'data' => $arr2['data1']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr2['data2']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr2['data3']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr2['data4']];
			$result['data']['linechart2']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr2['data5']];
			/* datasets for line chart3 */
			$result['data']['linechart3']['labels'] = $arr3['labels'];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Plan', 'borderColor' => get_rgba('red'), 'data' => $arr3['data1']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr3['data2']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr3['data3']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr3['data4']];
			$result['data']['linechart3']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr3['data5']];
			/* datasets for line chart4 */
			$result['data']['linechart4']['labels'] = $arr4['labels'];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Plan', 'borderColor' => get_rgba('red'), 'data' => $arr4['data1']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Act (Ontime)', 'borderColor' => get_rgba('blue'), 'data' => $arr4['data2']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Act (Early)', 'borderColor' => get_rgba('yellow'), 'data' => $arr4['data3']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Act (Late)', 'borderColor' => get_rgba('green'), 'data' => $arr4['data4']];
			$result['data']['linechart4']['datasets'][] = ['label' => 'Not Yet', 'borderColor' => get_rgba('purple'), 'data' => $arr4['data5']];
		}	
		/* total & release by document */
		$str = "with tmp as (
		select 
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate') as total_projection1,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate') as total_projection2,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate') as total_projection3,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate') as total_projection4,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release1,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release2,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release3,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release4,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early1,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early2,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early3,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early4,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late1,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late2,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late3,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late4,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease1,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease2,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease3,
		(select count(*) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease4
		) select *, 
		(100 * t1.total_release1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_percent1, 
		(100 * t1.total_release2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_percent2, 
		(100 * t1.total_release3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_percent3, 
		(100 * t1.total_release4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_percent4, 
		(100 * t1.total_release_early1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_early_percent1, 
		(100 * t1.total_release_early2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_early_percent2, 
		(100 * t1.total_release_early3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_early_percent3, 
		(100 * t1.total_release_early4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_early_percent4, 
		(100 * t1.total_release_late1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_late_percent1, 
		(100 * t1.total_release_late2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_late_percent2, 
		(100 * t1.total_release_late3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_late_percent3, 
		(100 * t1.total_release_late4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_late_percent4, 
		(100 * t1.total_unrelease1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_unrelease_percent1,
		(100 * t1.total_unrelease2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_unrelease_percent2,
		(100 * t1.total_unrelease3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_unrelease_percent3,
		(100 * t1.total_unrelease4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_unrelease_percent4
		from tmp as t1;";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_by_document'] = $row;
		/* total & release by amount */
		$str = "with tmp as (
		select 
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate') as total_projection1,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate') as total_projection2,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate') as total_projection3,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate') as total_projection4,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release1,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) = f1.received_plan_date)) as total_release2,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release3,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) = f1.payment_plan_date)) as total_release4,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early1,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) < f1.received_plan_date)) as total_release_early2,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early3,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) < f1.payment_plan_date)) as total_release_early4,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late1,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select received_date from cf_cashbank where id = s1.cashbank_id) > f1.received_plan_date)) as total_release_late2,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late3,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = f1.id and (select payment_date from cf_cashbank where id = s1.cashbank_id) > f1.payment_plan_date)) as total_release_late4,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('1') and received_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease1,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('5') and received_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease2,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('2','3','4') and payment_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease3,
		(select coalesce(sum(net_amount), 0) from cf_invoice f1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and doc_date is not null and doc_type in ('6') and payment_plan_date between '$fdate' and '$tdate' and not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id)) as total_unrelease4
		) select *, 
		(100 * t1.total_release1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_percent1, 
		(100 * t1.total_release2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_percent2, 
		(100 * t1.total_release3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_percent3, 
		(100 * t1.total_release4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_percent4, 
		(100 * t1.total_release_early1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_early_percent1, 
		(100 * t1.total_release_early2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_early_percent2, 
		(100 * t1.total_release_early3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_early_percent3, 
		(100 * t1.total_release_early4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_early_percent4, 
		(100 * t1.total_release_late1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_release_late_percent1, 
		(100 * t1.total_release_late2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_release_late_percent2, 
		(100 * t1.total_release_late3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_release_late_percent3, 
		(100 * t1.total_release_late4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_release_late_percent4, 
		(100 * t1.total_unrelease1 / coalesce(nullif(t1.total_projection1, 0), 1)::float) as total_unrelease_percent1,
		(100 * t1.total_unrelease2 / coalesce(nullif(t1.total_projection2, 0), 1)::float) as total_unrelease_percent2,
		(100 * t1.total_unrelease3 / coalesce(nullif(t1.total_projection3, 0), 1)::float) as total_unrelease_percent3,
		(100 * t1.total_unrelease4 / coalesce(nullif(t1.total_projection4, 0), 1)::float) as total_unrelease_percent4
		from tmp as t1;";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_by_amount'] = $row;
		
		xresponse(TRUE, $result);
	}
	
	function va_finance2_dd($params)
	{
		$fdate = $params['fdate'];
		$tdate = $params['tdate'];

		if ($params['doc'] == 1) { $doc = "t1.doc_type in ('1')"; $var1 = "received_date"; $var2 = "t1.received_plan_date"; }
		if ($params['doc'] == 2) { $doc = "t1.doc_type in ('5')"; $var1 = "received_date"; $var2 = "t1.received_plan_date"; }
		if ($params['doc'] == 3) { $doc = "t1.doc_type in ('2','3','4')"; $var1 = "payment_date"; $var2 = "t1.payment_plan_date"; }
		if ($params['doc'] == 4) { $doc = "t1.doc_type in ('6')"; $var1 = "payment_date"; $var2 = "t1.payment_plan_date"; } 
		
		if ($params['lvl'] == 1) $lvl = ""; 
		if ($params['lvl'] == 2) $lvl = "exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id and (select $var1 from cf_cashbank where id = s1.cashbank_id) = $var2)"; 
		if ($params['lvl'] == 3) $lvl = "exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id and (select $var1 from cf_cashbank where id = s1.cashbank_id) < $var2)"; 
		if ($params['lvl'] == 4) $lvl = "exists(select 1 as has_cb from cf_cashbank_line s1 where is_active = '1' and is_deleted = '0' and invoice_id = t1.id and (select $var1 from cf_cashbank where id = s1.cashbank_id) > $var2)"; 
		if ($params['lvl'] == 5) $lvl = "not exists(select 1 as has_cb from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = t1.id)"; 
		
		$params['select']	= isset($params['select']) ? $params['select'] : "
		case t1.doc_type when '1' then 'Invoice Customer' when '2' then 'Invoice Vendor' when '3' then 'Invoice Clearence' when '4' then 'Invoice Custom Duty' when '5' then 'Invoice Inflow' when '6' then 'Invoice Outflow' end as invoice_type,
		(select name as org_name from a_org where id = t1.org_id), 
		(select name as orgtrx_name from a_org where id = t1.orgtrx_id), 
		(select residence from c_bpartner where id = t1.bpartner_id),
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') as category_name from cf_order_line s1 where order_id = t1.order_id),
		(select name as bpartner_name from c_bpartner where id = t1.bpartner_id), 
		t1.doc_no, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, 
		t1.amount, t1.adj_amount, t1.net_amount,
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		t1.note, t1.description,
		(select name as account_name from cf_account where id = t1.account_id),
		(select name as created_by_name from a_user where id = t1.created_by),
		(select doc_no as voucher_no from cf_cashbank where id = (select cashbank_id from cf_cashbank_line where invoice_id = t1.id)),
		(select to_char(doc_date, '".$this->session->date_format."') as voucher_date from cf_cashbank where id = (select cashbank_id from cf_cashbank_line where invoice_id = t1.id))";
		$params['table'] 	= "cf_invoice as t1";
		$params['where_custom'][] = "doc_date is not null and $var2 between '$fdate' and '$tdate' and $doc".($lvl ? " and ".$lvl : "");
		
		return $this->base_model->mget_rec($params);
	}
	
	function va_sales($params)
	{
		$fdate = $params['fdate'];
		$tdate = $params['tdate'];

		/* line chart */
		if (date_differ($fdate, $tdate, 'day') < 32) {
			$str = "select i.date, to_char(i.date, 'Mon DD') as name,
			(select count(*) from cf_order where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date = i.date) as total_so,
			(select count(*) from cf_order where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date = i.date and etd > expected_dt_cust) as total_so_late
			from generate_series('$fdate', '$tdate', '1 day'::interval) i;";
		} else {
			$str = "select i.date, (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE as end_of_month, to_char(i.date, 'Mon') as name,
			(select count(*) from cf_order where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE) as total_so,
			(select count(*) from cf_order where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date between i.date and (date_trunc('MONTH', i.date) + INTERVAL '1 MONTH - 1 day')::DATE and etd > expected_dt_cust) as total_so_late
			from generate_series('$fdate', '$tdate', '1 month'::interval) i;";
		}
		$str = translate_variable($str);
		$qry = $this->db->query($str);
		if ($qry->num_rows() > 0) {
			$arr['labels'] = [];
			foreach($qry->result() as $row){
				$arr['labels'][] = $row->name;
				$arr['data1'][] = $row->total_so;
				$arr['data2'][] = $row->total_so_late;
			}
			/* datasets for line chart so vs so_late */
			$result['data']['linechart']['labels'] = $arr['labels'];
			$result['data']['linechart']['datasets'][] = ['label' => 'Sales Order', 'borderColor' => get_rgba(), 'data' => $arr['data1']];
			$result['data']['linechart']['datasets'][] = ['label' => 'Estimate Late Shipment', 'borderColor' => get_rgba(), 'data' => $arr['data2']];
		}	
		/* total_so */
		$str = "select coalesce(count(*), 0) as total from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date between '$fdate' and '$tdate';";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_so'] = $row->total;
		/* total_so_amount */
		$str = "select 
		case 
		when coalesce(sum(grand_total), 0) < 1000000 then trim(to_char(sum(grand_total)/1000, '999D9')||' RB')
		when coalesce(sum(grand_total), 0) between 1000000 and 999999999 then trim(to_char(sum(grand_total)/1000000, '999D9')||' JT')
		when coalesce(sum(grand_total), 0) >= 1000000000 then trim(to_char(sum(grand_total)/1000000000, '999D9')||' M')
		end as sorten,
		trim(to_char(coalesce(sum(grand_total), 0), '99G999G999G999')) as total from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date between '$fdate' and '$tdate';";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_so_amount'] = $row->total;
		/* estimate_late_shipment */
		$str = "select coalesce(count(*), 0) as total, 
		100 * count(*) / coalesce((select coalesce(count(*), 0) as total from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and doc_date between '$fdate' and '$tdate'), 1)::float as percent 
		from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust and doc_date between '$fdate' and '$tdate';";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_so_late'] = $row->total;
		$result['data']['total_so_late_percent'] = $row->percent;
		/* estimate_penalty */
		$str = "select trim(to_char(coalesce(sum(
		case when ((etd - expected_dt_cust) * penalty_percent * grand_total) > (max_penalty_percent * grand_total) 
		then (max_penalty_percent * grand_total) 
		else ((etd - expected_dt_cust) * penalty_percent * grand_total) 
		end), 0), '99G999G999G999')) as total,
		100 * (coalesce(sum(
		case when ((etd - expected_dt_cust) * penalty_percent * grand_total) > (max_penalty_percent * grand_total) 
		then (max_penalty_percent * grand_total) 
		else ((etd - expected_dt_cust) * penalty_percent * grand_total) 
		end), 0)) / coalesce(sum(grand_total), 1)::float as percent 
		from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust and doc_date between '$fdate' and '$tdate';";
		$str = translate_variable($str);
		$row = $this->db->query($str)->row();
		$result['data']['total_so_penalty'] = $row->total;
		$result['data']['total_so_penalty_percent'] = $row->percent;
		
		
		/* Shipment All */
		$result['data']['shipment_all'] = [
			0	=>	['name' => 'Estimate Late Shipment', 'count' => $result['data']['total_so_late'], 'percent' => $result['data']['total_so_late_percent']],
			1	=>	['name' => 'Estimate Ontime Shipment', 'count' => $result['data']['total_so'] - $result['data']['total_so_late'], 'percent' => 100-$result['data']['total_so_late_percent']],
		];
		$result['data']['shipment_all_chart']['labels'] = ['Estimate Late Shipment', 'Estimate Ontime Shipment'];
		$result['data']['shipment_all_chart']['datasets'][] = ['label' => 'Description', 'backgroundColor' => [get_rgba('red'), get_rgba('blue')], 'data' => [$result['data']['total_so_late'], $result['data']['total_so'] - $result['data']['total_so_late']]];
		
		/* Estimate Late Shipment */
		$str = "with el as (
		select unnest(scm_dt_reasons) as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust 
		and doc_date between '$fdate' and '$tdate'
		union all
		select 0 as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust and scm_dt_reasons is null
		and doc_date between '$fdate' and '$tdate'
		) select coalesce((select name from rf_scm_dt_reason where id = el.reason), 'Undefined') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from el group by 1 order by 2 desc;";
		$str = translate_variable($str);
		$qry = $this->db->query($str);
		$arr['labels'] = []; $arr['data1'] = []; $arr['color'] = [];
		foreach($qry->result() as $row){
			$arr['labels'][] = $row->name;
			$arr['data1'][] = $row->count;
			$arr['color'][] = get_rgba();
		}
		$result['data']['estimate_late_shipment'] = $qry->result();
		$result['data']['estimate_late_shipment_chart']['labels'] = $arr['labels'];
		$result['data']['estimate_late_shipment_chart']['datasets'][] = ['label' => 'Description', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
		/* Estimate Ontime Shipment */
		$str = "with el as (
		select unnest(scm_dt_reasons) as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd <= expected_dt_cust 
		and doc_date between '$fdate' and '$tdate'
		union all
		select 0 as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd <= expected_dt_cust and scm_dt_reasons is null
		and doc_date between '$fdate' and '$tdate'
		) select coalesce((select name from rf_scm_dt_reason where id = el.reason), 'Undefined') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from el group by 1 order by 2 desc;";
		$str = translate_variable($str);
		$qry = $this->db->query($str);
		$arr['labels'] = []; $arr['data1'] = []; $arr['color'] = [];
		foreach($qry->result() as $row){
			$arr['labels'][] = $row->name;
			$arr['data1'][] = $row->count;
			$arr['color'][] = get_rgba();
		}
		$result['data']['estimate_ontime_shipment'] = $qry->result();
		$result['data']['estimate_ontime_shipment_chart']['labels'] = $arr['labels'];
		$result['data']['estimate_ontime_shipment_chart']['datasets'][] = ['label' => 'Description', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
		
		// /* SO Late All */
		// $str = "with el as (
		// select unnest(scm_dt_reasons) as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust 
		// and doc_date between '$fdate' and '$tdate'
		// union all
		// select 0 as reason, doc_no, doc_date from cf_order t1 where is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust and scm_dt_reasons is null
		// and doc_date between '$fdate' and '$tdate'
		// ) select coalesce((select name from rf_scm_dt_reason where id = el.reason), 'Undefined') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from el group by 1 order by 2 desc;";
		// $str = translate_variable($str);
		// $qry = $this->db->query($str);
		// $result['data']['so_late_all'] = $qry->result();
		// /* SO Late All (Chart) */
		// $arr['labels'] = []; $arr['data1'] = [];
		// foreach($qry->result() as $row){
			// $arr['labels'][] = $row->name;
			// $arr['data1'][] = $row->count;
			// $arr['color'][] = get_rgba();
		// }
		// $result['data']['so_late_all_chart']['labels'] = $arr['labels'];
		// $result['data']['so_late_all_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
		
		// /* SO Late Complete */
		// $str = "with el as (
		// select unnest(scm_dt_reasons) as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust 
		// and (select count(*) as ship from cf_inout_line a1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and exists(select 1 from cf_order_line where id = a1.order_line_id and order_id = t1.id)) >= 
		// (select count(*) as line from cf_order_line where is_active = '1' and is_deleted = '0' and order_id = t1.id group by order_id)
		// and doc_date between '$fdate' and '$tdate'
		// union all
		// select 0 as reason, doc_no, doc_date from cf_order t1 where is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust and scm_dt_reasons is null
		// and (select count(*) as ship from cf_inout_line a1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and exists(select 1 from cf_order_line where id = a1.order_line_id and order_id = t1.id)) >= 
		// (select count(*) as line from cf_order_line where is_active = '1' and is_deleted = '0' and order_id = t1.id group by order_id)
		// and doc_date between '$fdate' and '$tdate'
		// ) select coalesce((select name from rf_scm_dt_reason where id = el.reason), 'Undefined') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from el group by 1 order by 2 desc;";
		// $str = translate_variable($str);
		// $qry = $this->db->query($str);
		// $result['data']['so_late_complete'] = $qry->result();
		// /* SO Late All (Chart) */
		// $arr['labels'] = []; $arr['data1'] = [];
		// foreach($qry->result() as $row){
			// $arr['labels'][] = $row->name;
			// $arr['data1'][] = $row->count;
			// $arr['color'][] = get_rgba();
		// }
		// $result['data']['so_late_complete_chart']['labels'] = $arr['labels'];
		// $result['data']['so_late_complete_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
		// /* SO Late Incomplete */
		// $str = "with el as (
		// select unnest(scm_dt_reasons) as reason, doc_no, doc_date from cf_order t1 where client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust 
		// and (select count(*) as ship from cf_inout_line a1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and exists(select 1 from cf_order_line where id = a1.order_line_id and order_id = t1.id)) < 
		// (select count(*) as line from cf_order_line where is_active = '1' and is_deleted = '0' and order_id = t1.id group by order_id)
		// and doc_date between '$fdate' and '$tdate'
		// union all
		// select 0 as reason, doc_no, doc_date from cf_order t1 where is_active = '1' and is_deleted = '0' and is_sotrx = '1' and etd > expected_dt_cust and scm_dt_reasons is null
		// and (select count(*) as ship from cf_inout_line a1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and exists(select 1 from cf_order_line where id = a1.order_line_id and order_id = t1.id)) < 
		// (select count(*) as line from cf_order_line where is_active = '1' and is_deleted = '0' and order_id = t1.id group by order_id)
		// and doc_date between '$fdate' and '$tdate'
		// ) select coalesce((select name from rf_scm_dt_reason where id = el.reason), 'Undefined') as name, count(*), 100 * count(*) / coalesce(sum(count(*)) over(), 1) as percent from el group by 1 order by 2 desc;";
		// $str = translate_variable($str);
		// $qry = $this->db->query($str);
		// $result['data']['so_late_incomplete'] = $qry->result();
		// /* SO Late All (Chart) */
		// $arr['labels'] = []; $arr['data1'] = [];
		// foreach($qry->result() as $row){
			// $arr['labels'][] = $row->name;
			// $arr['data1'][] = $row->count;
			// $arr['color'][] = get_rgba();
		// }
		// $result['data']['so_late_incomplete_chart']['labels'] = $arr['labels'];
		// $result['data']['so_late_incomplete_chart']['datasets'][] = ['label' => 'Reason', 'backgroundColor' => $arr['color'], 'data' => $arr['data1']];
		xresponse(TRUE, $result);
	}

	function dashboard_sales($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_purchase($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_warehouse($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_invoice_vendor($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_invoice_customer($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_other_inflow($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_other_outflow($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}

	function dashboard_unmatch_daily_entry($params)
	{
		$params['select']	= "t2.*, t1.seq";
		$params['table'] 	= "a_role_dashboard t1";
		$params['join'][] 	= ['a_dashboard t2', 't2.id = t1.dashboard_id', 'left'];
		$params['where']['t1.role_id'] = $this->session->role_id;
		$params['where']['t1.is_active'] = '1';
		$params['where']['t1.is_deleted'] = '0';
		$params['where']['t2.is_active'] = '1';
		$params['where']['t2.is_deleted'] = '0';
		// $params['order']	= "t2.type, t2.lineno";
		$params['sort']	= "t1.seq asc";
		// debug($this->base_model->mget_rec($params));
		return $this->base_model->mget_rec($params);
	}
	
}