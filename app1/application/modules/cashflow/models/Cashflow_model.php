<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cashflow_Model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		
	}

	function cf_account($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_charge_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinout($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "cf_inout as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinout_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "cf_inout_line as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinout($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= "cf_inout as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinout_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "cf_inout_line as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinvoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date";
		$params['table'] 	= "cf_invoice as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinvoice_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "cf_invoice_line as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sinvoice_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_invoice_plan as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinvoice($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date";
		$params['table'] 	= "cf_invoice as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinvoice_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "cf_invoice_line as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_pinvoice_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_invoice_plan as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_movement($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date, to_char(t1.doc_ref_date, '".$this->session->date_format."') as doc_ref_date, to_char(t1.delivery_date, '".$this->session->date_format."') as delivery_date, to_char(t1.received_date, '".$this->session->date_format."') as received_date";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_movement_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sorder($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_order as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sorder_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, (select name from m_itemcat where id = t1.itemcat_id) as itemcat_name";
		$params['table'] 	= "cf_order_line as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_sorder_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_order_plan as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_order as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= "cf_order_line as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_order_plan as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan_clearance($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_order_plan_clearance as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_porder_plan_import($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= "cf_order_plan_import as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_request_type($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, coalesce(t1.code,'') ||'_'|| t1.name as code_name";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_requisition($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*, to_char(t1.doc_date, '".$this->session->date_format."') as doc_date";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_requisition_line($params)
	{
		$params['select']	= isset($params['select']) ? $params['select'] : "t1.*";
		$params['table'] 	= $this->c_table." as t1";
		$params['where']['t1.is_deleted'] 	= '0';
		return $this->base_model->mget_rec($params);
	}
	
	function cf_order_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->order_id) ? 'where t1.id = '.$params->order_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_order t1 set (sub_total, vat_total, grand_total) = 
				(
					select sum(sub_amt), sum(vat_amt), sum(ttl_amt) from cf_order_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "update cf_order t1 set (plan_total) = 
				(
					select sum(amount) from cf_order_plan t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan_cl) && $params->is_plan_cl) {
			$str = "update cf_order t1 set (plan_cl_total) = 
				(
					select sum(amount) from cf_order_plan_clearance t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan_im) && $params->is_plan_im) {
			$str = "update cf_order t1 set (plan_im_total) = 
				(
					select sum(amount) from cf_order_plan_import t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.order_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
	function cf_charge_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->charge_id) ? 'where t1.id = '.$params->charge_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_charge t1 set (sub_total, vat_total, grand_total) = 
				(
					select sum(sub_amt), sum(vat_amt), sum(ttl_amt) from cf_charge_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.charge_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "update cf_charge t1 set (plan_total) = 
				(
					select sum(amount) from cf_charge_plan t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.charge_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
	function cf_invoice_update_summary($params)
	{
		$params = is_array($params) ? (object) $params : $params;
		$id = isset($params->invoice_id) ? 'where t1.id = '.$params->invoice_id : '';
		if (isset($params->is_line) && $params->is_line) {
			$str = "update cf_invoice t1 set (sub_total, vat_total, grand_total) = 
				(
					select sum(sub_amt), sum(vat_amt), sum(ttl_amt) from cf_invoice_line t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id
				)
				$id";
		}
		if (isset($params->is_plan) && $params->is_plan) {
			$str = "update cf_invoice t1 set (plan_total) = 
				(
					select sum(amount) from cf_invoice_plan t2 
					where t2.is_active = '1' and t2.is_deleted = '0' and t2.invoice_id = t1.id
				)
				$id";
		}
		return $this->db->query($str);
	}
	
}