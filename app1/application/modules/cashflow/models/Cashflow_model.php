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
		$params['table'] 	= $this->c_method." as t1";
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
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(t1.invoice_plan_date, '".$this->session->date_format."') as invoice_plan_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date, 
		case when t1.doc_date is null then 'Projection' else 'Actual' end as invoice_status,
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_invoice as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order, to_char(t2.etd, '".$this->session->date_format."') as etd_order";
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
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
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
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
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
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_invoice as t1";
		if (isset($params['level']) && $params['level'] == 1) {
			// $params['select'] .= ", t2.doc_no as doc_no_inout, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_inout";
			// $params['join'][] = ['cf_inout as t2', 't1.inout_id = t2.id', 'left'];
			$params['select'] .= ", t2.doc_no as doc_no_order, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_order, to_char(t2.eta, '".$this->session->date_format."') as eta_order";
			$params['join'][] = ['cf_order as t2', 't1.order_id = t2.id', 'left'];
			$params['join'][] = ['cf_order_plan as t3', 't1.order_plan_id = t3.id', 'left'];
			$params['join'][] = ['cf_order_plan_clearance as t4', 't1.order_plan_clearance_id = t4.id', 'left'];
			$params['join'][] = ['cf_order_plan_import as t5', 't1.order_plan_import_id = t5.id', 'left'];
		}
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
		to_char(t1.received_date, '".$this->session->date_format."') as received_date";
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
		/* if (isset($params['level']) && $params['level'] == 1) {
			$params['select'] .= ", t2.bpartner_id, (select name from c_bpartner where id = t2.bpartner_id) as bpartner_name, t2.doc_no as doc_no_request, to_char(t2.doc_date, '".$this->session->date_format."') as doc_date_request, to_char(t2.eta, '".$this->session->date_format."') as eta_request";
			$params['join'][] = ['cf_request as t2', 't1.request_id = t2.id', 'left'];
		} */
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
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.etd, '".$this->session->date_format."') as etd, to_char(t1.expected_dt_cust, '".$this->session->date_format."') as expected_dt_cust, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "cf_order as t1";
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
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select po_top from c_bpartner where id = t1.bpartner_id) as po_top, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.eta, '".$this->session->date_format."') as eta, coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
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
		(select count(doc_no) from cf_invoice where order_plan_clearance_id = t1.id and is_active = '1' and is_deleted = '0') as is_posted, 
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.payment_plan_date, '".$this->session->date_format."') as payment_plan_date, t1.note as code_name";
		$params['table'] 	= "cf_order_plan_clearance as t1";
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan_import($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, 
		(select doc_no from cf_order where id = t1.order_id), 
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
		coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
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
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as invoice_plan_date, 
		(select doc_no from cf_order where id = t1.order_id) as so_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as so_date, 
		(select to_char(etd, '".$this->session->date_format."') from cf_order where id = t1.order_id) as etd, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			) t1";
		// debug($this->base_model->mget_rec($params)->result());
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
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order_plan where id = t1.order_plan_id) as invoice_plan_date, 
		(select doc_no from cf_order where id = t1.order_id) as po_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_order where id = t1.order_id) as po_date, 
		(select to_char(eta, '".$this->session->date_format."') from cf_order where id = t1.order_id) as eta, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_order_plan where is_active = '1' and is_deleted = '0' and id = t1.order_plan_id)
			) t1";
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
		(select doc_no from cf_ar_ap where id = t1.ar_ap_id) as ar_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap where id = t1.ar_ap_id) as ar_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_plan_id) as invoice_plan_date";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			) t1";
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
		(select doc_no from cf_ar_ap where id = t1.ar_ap_id) as ap_no, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap where id = t1.ar_ap_id) as ap_date, 
		(select to_char(doc_date, '".$this->session->date_format."') from cf_ar_ap_plan where id = t1.ar_ap_plan_id) as invoice_plan_date";
		$params['table'] 	= "(
			select *, 'by amount' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date = (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount = 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			union all
			select *, 'by amount & date' as status from cf_invoice t1 
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and orgtrx_id = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and ar_ap_plan_id is not null and extract(month from doc_date) = extract(month from current_date) and 
			adj_amount <> 0 and doc_date > (select doc_date from cf_ar_ap_plan where is_active = '1' and is_deleted = '0' and id = t1.ar_ap_plan_id)
			) t1";
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
		to_char(etd, '".$this->session->date_format."') as etd, 
		to_char(delivery_date, '".$this->session->date_format."') as delivery_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select t1.*, order_id, delivery_date from (
			select order_id, 
			max((select (select max(delivery_date) from cf_inout where id = f1.inout_id) as delivery_date from cf_inout_line f1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id limit 1)) as delivery_date
			from cf_order_line t1
			where 
			client_id = ".$this->session->client_id." and org_id = ".$this->session->org_id." and (select orgtrx_id from cf_order f1 where id = t1.order_id) = ".$this->session->orgtrx_id." and 
			is_active = '1' and is_deleted = '0' and exists(select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id) 
			group by 1
			) t2 inner join cf_order t1 on t2.order_id = t1.id where delivery_date > etd and extract(month from etd) = extract(month from current_date) 
			) t1";
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
			) t2 inner join cf_order t1 on t2.order_id = t1.id where received_date > eta and extract(month from eta) = extract(month from current_date) 
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
		to_char(doc_date, '".$this->session->date_format."') as doc_date, 
		to_char(etd, '".$this->session->date_format."') as etd";
		$params['table'] 	= "(
			select t1.*, order_id, delivery_date from (
			select order_id, 
			max((select (select max(delivery_date) from cf_inout where id = f1.inout_id) as delivery_date from cf_inout_line f1 where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id limit 1)) as delivery_date
			from cf_order_line t1
			where 
			client_id = {client_id} and org_id = {org_id} and (select orgtrx_id from cf_order f1 where id = t1.order_id) in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and exists(select 1 from cf_inout_line where is_active = '1' and is_deleted = '0' and is_completed = '1' and order_line_id = t1.id) 
			group by 1
			) t2 inner join cf_order t1 on t2.order_id = t1.id where delivery_date > etd and extract(month from etd) = extract(month from current_date) 
		) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_outstanding_trans_po($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, 
		(select residence from c_bpartner where id = t1.bpartner_id) as residence, 
		(select po_top from c_bpartner where id = t1.bpartner_id) as po_top,  
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
			(select count(*) as so_unmatch from cf_order where is_active = '1' and is_deleted = '0' and is_sotrx = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as ship_unmatch from cf_inout where is_active = '1' and is_deleted = '0' and is_sotrx = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as po_unmatch from cf_order where is_active = '1' and is_deleted = '0' and is_sotrx = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as mr_unmatch from cf_inout where is_active = '1' and is_deleted = '0' and is_sotrx = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as req_unmatch from cf_request where is_active = '1' and is_deleted = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as pr_unmatch from cf_requisition where is_active = '1' and is_deleted = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_c_unmatch from cf_invoice where is_active = '1' and is_deleted = '0' and doc_type = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_v_unmatch from cf_invoice where is_active = '1' and is_deleted = '0' and doc_type = '2' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_if_unmatch from cf_invoice where is_active = '1' and is_deleted = '0' and doc_type = '5' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inv_of_unmatch from cf_invoice where is_active = '1' and is_deleted = '0' and doc_type = '6' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as outflow_unmatch from cf_ar_ap where is_active = '1' and is_deleted = '0' and is_receipt = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as inflow_unmatch from cf_ar_ap where is_active = '1' and is_deleted = '0' and is_receipt = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as ar_unmatch from cf_cashbank where is_active = '1' and is_deleted = '0' and is_receipt = '1' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD')),
			(select count(*) as ap_unmatch from cf_cashbank where is_active = '1' and is_deleted = '0' and is_receipt = '0' and to_char(created_at, 'YYYY-MM-DD') = to_char(i.date, 'YYYY-MM-DD') and to_char(doc_date, 'YYYY-MM-DD') <> to_char(i.date, 'YYYY-MM-DD'))
			from generate_series( date_trunc('month', now()), now(), '1 day'::interval) i
			) t1";
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
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date,
		to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "(
			select *, (select received_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id),
			(select f2.doc_no as voucher_no from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id) from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '1' and extract(month from received_plan_date) = extract(month from current_date) and 
			received_plan_date < (select received_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id)
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
			select f1.doc_no,f1.doc_date,f1.bpartner_id,f1.doc_ref_date,g1.id as order_plan_id,g1.order_id, f1.client_id, f1.org_id,f1.orgtrx_id,f1.is_active,f1.is_deleted,f1.id, g1.note,g1.description,g1.amount from cf_order f1 inner join 
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
			select f1.doc_no,f1.doc_date,f1.bpartner_id,f1.doc_ref_date,g1.id as order_plan_id,g1.order_id, f1.client_id, f1.org_id,f1.orgtrx_id,f1.is_active,f1.is_deleted,f1.id, g1.note,g1.description,g1.amount from cf_order f1 inner join 
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
			select * from cf_ar_ap e1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx}  and 
			is_active = '1' and is_deleted = '0' and is_receipt ='0' and grand_total=0
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
			select * from cf_ar_ap e1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx}  and 
			is_active = '1' and is_deleted = '0' and is_receipt ='0' and grand_total=0
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}
	
	function db_outstanding_invoice_customer($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.received_plan_date, '".$this->session->date_format."') as Recv_plan_date, to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, (select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= " (
			select * from cf_invoice a1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			a1.is_active='1' and a1.is_deleted='0' and extract(month from a1.received_plan_date) = extract(month from current_date)
			and a1.doc_type='1'
			and not exists(select b1.id from cf_cashbank_line b1 where b1.is_active='1' and b1.is_deleted='0' and b1.invoice_id =a1.id )
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_supplier($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.payment_plan_date, '".$this->session->date_format."') as Pay_plan_date, to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, (select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name,case 
		when (t1.doc_type = '2') then 'vendor' 
		when (t1.doc_type = '3') then 'Clearence'
		when (t1.doc_type = '4') then 'Custom Duty'
		else ''
		end as document_type";
		$params['table'] 	= "(
			select * from cf_invoice a1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			a1.is_active='1' and a1.is_deleted='0' and extract(month from a1.payment_plan_date) = extract(month from current_date)
			and a1.doc_type='2'
			and not exists(select b1.id from cf_cashbank_line b1 where b1.is_active='1' and b1.is_deleted='0' and b1.invoice_id =a1.id )
			) t1";

		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_other_inflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.received_plan_date, '".$this->session->date_format."') as Recv_plan_date, to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, (select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select * from cf_invoice a1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			a1.is_active='1' and a1.is_deleted='0' and extract(month from a1.received_plan_date) = extract(month from current_date)
			and a1.doc_type='5'
			and not exists(select b1.id from cf_cashbank_line b1 where b1.is_active='1' and b1.is_deleted='0' and b1.invoice_id =a1.id )
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_invoice_other_outflow($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, (select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, (select residence from c_bpartner where id = t1.bpartner_id) as residence, (select so_top from c_bpartner where id = t1.bpartner_id) as so_top, to_char(t1.payment_plan_date, '".$this->session->date_format."') as Pay_plan_date, to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, (select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.order_id) as category_name";
		$params['table'] 	= "(
			select * from cf_invoice a1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			a1.is_active='1' and a1.is_deleted='0' and extract(month from a1.payment_plan_date) = extract(month from current_date)
			and a1.doc_type='6'
			and not exists(select b1.id from cf_cashbank_line b1 where b1.is_active='1' and b1.is_deleted='0' and b1.invoice_id =a1.id )
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
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
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
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= "(
			select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id ) from cf_invoice f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active='1' and is_deleted='0' and received_plan_date <= current_date and
			doc_type in ('1') 
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
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name,case 
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
		doc_type in ('2','3','4') 
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
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= "(
			select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id ) from cf_invoice f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active='1' and is_deleted='0' and received_plan_date <= current_date and
			doc_type in ('6') 
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
		to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, 
		(select string_agg((select name from m_itemcat where id = s1.itemcat_id), E'<br>') from cf_order_line s1 where order_id = t1.id) as category_name";
		$params['table'] 	= "(
			select *, (select id as cashbank_line_id from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id ) from cf_invoice f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active='1' and is_deleted='0' and received_plan_date <= current_date and
			doc_type in ('5') 
			and not exists(select 1 from cf_cashbank_line where is_active = '1' and is_deleted = '0' and invoice_id = f1.id )
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
		to_char(t1.doc_date, '".$this->session->date_format."') as invoice_date, 
		to_char(t1.doc_ref_date, '".$this->session->date_format."') as invoice_ref_date, 
		to_char(t1.received_plan_date, '".$this->session->date_format."') as received_plan_date,
		to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "(
			select *, (select received_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id),
			(select f2.doc_no as voucher_no from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id) from cf_invoice t1 
			where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and is_receipt = '0' and extract(month from received_plan_date) = extract(month from current_date) and 
			received_plan_date < (select received_date from cf_cashbank_line f1 inner join cf_cashbank f2 on f1.cashbank_id = f2.id where f1.is_active = '1' and f1.is_deleted = '0' and f1.invoice_id = t1.id)
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_incomplete_request($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "
		(select name from a_org where id = t1.org_id) as org_name, 
		(select name from a_org where id = t1.orgtrx_id) as orgtrx_name, 
		t1.*, 
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.eta, '".$this->session->date_format."') as eta, (select name from cf_request_type where id = t1.request_type_id) as request_type_name,(select doc_no from cf_order where id = t1.order_id) as doc_no_order,(select doc_date from cf_order where id = t1.order_id) as doc_date_order,  coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "(
			select * from cf_request f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' 
			and exists (select * from (Select distinct(request_id) from cf_request_line a1 where 
			is_active = '1' and is_deleted = '0' and is_stocked='0'
			and not exists (select * from cf_requisition_line b1 where 
			is_active = '1' and is_deleted = '0' and request_line_id = a1.id)
			) g1 where g1.request_id = f1.id)
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
		(select name from c_bpartner where id = t1.bpartner_id) as bpartner_name, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.eta, '".$this->session->date_format."') as eta, (select name from cf_request_type where id = t1.request_type_id) as request_type_name,(select doc_no from cf_order where id = t1.order_id) as doc_no_order,(select doc_date from cf_order where id = t1.order_id) as doc_date_order,  coalesce(t1.doc_no,'') ||'_'|| to_char(t1.doc_date, '".$this->session->date_format."') as code_name";
		$params['table'] 	= "(
			select * from cf_request f1 where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0'
			and exists (select * from (
				Select distinct(request_id) from cf_request_line a1 where 
				is_active = '1' and is_deleted = '0'
				and not exists (select * from cf_movement_line b1 where 
				is_active = '1' and is_deleted = '0' and  is_completed='1' and request_line_id = a1.id)) g1 where g1.request_id = f1.id)
			)t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

	function db_outstanding_outbound($params)
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
		$params['table'] 	= " (
			select * from cf_movement where 
			client_id = {client_id} and org_id = {org_id} and orgtrx_id in {orgtrx} and 
			is_active = '1' and is_deleted = '0' and received_date is null 
			) t1";
		$params['table'] = translate_variable($params['table']);
		return $this->base_model->mget_rec($params);
	}

}