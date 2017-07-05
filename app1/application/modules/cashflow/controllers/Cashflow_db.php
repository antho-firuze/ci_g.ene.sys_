<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Cashflow_db extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}

	/* 
	// for modify field type from text to integer	
	
	ALTER TABLE hr_personnel ALTER COLUMN employee_status_id TYPE integer USING (employee_status_id::integer);
	*/

	function _list_field()
	{
		// VARCHAR
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		// TEXT
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		// ID & FOREIGN ID
		$fields['_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		// DATE
		$fields['_date'] = 	['type' => 'DATE', 'null' => TRUE];
		// NUMERIC PERCENTAGE
		$fields['percent'] 	= ['type' => 'NUMERIC', 'constraint' => '18,4', 'null' => TRUE];	
		// NUMERIC AMOUNT
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
	}
	
	/* CashFlow Master */
	function table_cf_account()
	{
		$fields = $this->field_00_Main();
		$fields['parent_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_cashbank'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_projection'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_cf_charge_type()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	/* cf_order: sales order & purchase order */
	function table_cf_order()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['pricelist_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['requisition_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['etd'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['eta'] = ['type' => 'DATE', 'null' => TRUE];
		
		$fields['sub_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['grand_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['plan_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['plan_cl_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['plan_im_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_line()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['pricelist_version_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['requisition_line_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_plan()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_plan_import()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_plan_clearance()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_inout: shipment & material receipt */
	function table_cf_inout()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['delivery_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['received_date'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_inout_line()
	{
		$fields = $this->field_00_Main();
		$fields['inout_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['order_line_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_completed'] = ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_invoice: invoice customer & invoice vendor */
	function table_cf_invoice()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['plan_type'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['order_plan_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['order_plan_clearance_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['order_plan_import_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['inout_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];	// not in used, change reference to order_id
		$fields['inout_ids'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];	// example of shipment_id : 1,2,3,4
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['sub_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['grand_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['plan_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_invoice_line()
	{
		$fields = $this->field_00_Main();
		$fields['invoice_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['inout_line_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];	// not in used, change to order_line_id
		$fields['order_line_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['account_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_invoice_plan()
	{
		$fields = $this->field_00_Main();
		$fields['invoice_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_ar_ap: ar & ap */
	function table_cf_ar_ap()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		
		$fields['sub_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['grand_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['plan_total'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_ar_ap_line()
	{
		$fields = $this->field_00_Main();
		$fields['ar_ap_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['account_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_ar_ap_plan()
	{
		$fields = $this->field_00_Main();
		$fields['ar_ap_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_request_type: For Stock, For SO */
	function table_cf_request_type()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_cf_request()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['request_type_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['eta'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_request_line()
	{
		$fields = $this->field_00_Main();
		$fields['request_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['order_line_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_requisition()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['request_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['eta'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_requisition_line()
	{
		$fields = $this->field_00_Main();
		$fields['requisition_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['request_line_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_movement: inbound & outbound */
	function table_cf_movement()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['orgto_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['request_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['delivery_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['received_date'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_movement_line()
	{
		$fields = $this->field_00_Main();
		$fields['movement_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
		return $fields;
	}
	
	function field_00_Main()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['client_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['org_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['is_active'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_deleted'] = ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['created_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['updated_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['deleted_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['updated_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['deleted_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		return $fields;
	}
	
	function create_table($tbl_name)
	{
		/* Drop table if exists  */
		$this->load->dbforge();
		$this->dbforge->drop_table($tbl_name,TRUE);
		/* DEFAULT FIELDS */
		$fields = $this->{'table_'.$tbl_name}();
		// debug($fields);
		/* CREATE TABLE */
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field($fields);
		if (! $result = $this->dbforge->create_table($tbl_name, TRUE)){
			debug('FAILED !');
		}
		debug('SUCCESS !');
	}
	
	function drop_table($tbl_name)
	{
		$this->load->dbforge();
		$this->dbforge->drop_table($tbl_name,TRUE);
		debug('SUCCESS !');
	}
	
}