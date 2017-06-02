<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Z_db extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}

	/* 
	// for modify field type from text to integer	
	
	ALTER TABLE hr_personnel ALTER COLUMN employee_status_id TYPE integer USING (employee_status_id::integer);
	*/

	function table_a_client()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['is_active'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_deleted'] = ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['created_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['updated_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['deleted_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['updated_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['deleted_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_dashboard()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['link'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE];
		$fields['type'] = ['type' => 'VARCHAR', 'constraint' => '12', 'null' => FALSE];
		$fields['position'] = ['type' => 'VARCHAR', 'constraint' => '12', 'null' => FALSE];
		$fields['query'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['include_files'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['line_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['icon'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE];
		$fields['color'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE];
		return $fields;
	}
	
	function table_a_changelog()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['table_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['record_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['column_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '12', 'null' => TRUE];
		$fields['old_value'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['new_value'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['trxname'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
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
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['pricelist_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		
		$fields['sub_total'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_total'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['grand_total'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_dt()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['pricelist_version_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_plan()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_plan_import()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_order_plan_clearance()
	{
		$fields = $this->field_00_Main();
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_inout: shipment & material receipt */
	function table_cf_inout()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
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
	
	function table_cf_inout_dt()
	{
		$fields = $this->field_00_Main();
		$fields['inout_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_invoice: invoice customer & invoice vendor */
	function table_cf_invoice()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['inout_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['order_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['doc_ref_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_ref_date'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_invoice_dt()
	{
		$fields = $this->field_00_Main();
		$fields['invoice_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
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
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_invoice_plan()
	{
		$fields = $this->field_00_Main();
		$fields['invoice_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_charge: charge in & charge out */
	function table_cf_charge()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['orgtrx_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_sotrx'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['charge_type_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['bpartner_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_no'] = ['type' => 'VARCHAR', 'constraint' => '125', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_charge_dt()
	{
		$fields = $this->field_00_Main();
		$fields['charge_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['account_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_charge_plan()
	{
		$fields = $this->field_00_Main();
		$fields['charge_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['doc_date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
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
		return $fields;
	}
	
	function table_cf_request()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
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
	
	function table_cf_request_dt()
	{
		$fields = $this->field_00_Main();
		$fields['request_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	function table_cf_requisition()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
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
	
	function table_cf_requisition_dt()
	{
		$fields = $this->field_00_Main();
		$fields['requisition_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['itemcat_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['measure_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		
		$fields['seq'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['item_code'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['item_size'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		
		$fields['qty'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['price'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	
	/* cf_movement: inbound & outbound */
	function table_cf_movement()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE];
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
	
	function table_cf_movement_dt()
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
		
		$fields['sub_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['vat_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['ttl_amt'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		return $fields;
	}
	

	
	function table_hr_config()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['photo_path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['company_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['branch_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['department_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['division_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['user_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['gender_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['religion_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['marital_status_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['marital_tax_status_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['education_level_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['home_status_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['job_title_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['nationality_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['occupation_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['employee_level_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['bank_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['first_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['last_name'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_place'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_date'] = 	['type' => 'DATE', 'null' => TRUE];
		// $fields['idcard_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		// $fields['idcard_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		// $fields['drivinglicence_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		// $fields['drivinglicence_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		// $fields['pasport_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		// $fields['pasport_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		// $fields['kitas_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		// $fields['kitas_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['npwp_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['npwp_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['npwp_address'] 	= ['type' => 'TEXT', 'null' => TRUE];
		$fields['bank_account_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['website'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['email'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['phone'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['fax'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['profile_status'] 	= ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];	// percentage
		/* Employee area */
		$fields['is_employee'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['begin_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['end_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['employee_id'] 	= ['type' => 'VARCHAR', 'constraint' => '60',  'null' => TRUE];
		$fields['employee_status_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['number_leave_status'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['bpjs_tk_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['bpjs_kes_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['father_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['mother_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['spouse_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child1_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child2_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child3_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['photo_file'] = ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_photo()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['photo_file'] = ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['photo_bin'] = ['type' => 'BYTEA', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_requirement_it()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_usingemail'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['email'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['is_usinginternet'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_usingcomputer'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['computer_level'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sent'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['sent_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['is_approved'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['approved_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['status'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_hr_personnel_clearance_it()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_datacopies'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['datacopies_note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_laptopreturn'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['laptopreturn_note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_emailclosing'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['emailclosing_note'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['computer_level'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sent'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['sent_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['is_approved'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['approved_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['status'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_hr_personnel_requirement_ga()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_usingphone'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['phone_ext'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['is_usingfurniture'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['furniture'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sent'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['sent_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['is_approved'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['approved_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['status'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_hr_personnel_card()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['card_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['card_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['expired_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_employee_status()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['employee_status_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date_from'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['date_to'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['num_months'] 	= ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['expired_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_allowance()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['allowance_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['amount'] 	= ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_facility()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['facility_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_mutation()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['mutation_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_leave()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['leave_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['excuse_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['date_range'] 	= ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['num_days'] 	= ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['is_approvedleader'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_approvedhrd'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['status'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_hr_personnel_travel()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['date_from'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['date_to'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['num_days'] 	= ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['destination'] 	= ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['requirement'] 	= ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['cash_advance'] 	= ['type' => 'NUMERIC', 'constraint' => '10', 'default' => 0];
		$fields['is_approvedleader'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_approvedhrd'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['status'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_hr_personnel_loan()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['amount'] 	= ['type' => 'NUMERIC', 'constraint' => '10', 'default' => 0];
		$fields['installment'] 	= ['type' => 'INT', 'constraint' => '10', 'default' => 1];
		$fields['is_approvedhrd'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['note'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['status'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_hr_personnel_location()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['country_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['province_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['city_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['district_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['village_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['postal_code'] = ['type' => 'VARCHAR', 'constraint' => '10', 'null' => FALSE];
		$fields['lat'] = ['type' => 'VARCHAR', 'constraint' => '50', 'null' => FALSE];
		$fields['lng'] = ['type' => 'VARCHAR', 'constraint' => '50', 'null' => FALSE];
		return $fields;
	}
	
	function table_hr_personnel_sosial()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['sosial_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['sosial_url'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_training()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['training_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['date'] = ['type' => 'DATE', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_education()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['education_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['from_year'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['to_year'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['status'] = ['type' => 'VARCHAR', 'constraint' => '1', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_personnel_experience()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['experience_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['occupation_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['from_year'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['to_year'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_allowance()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_facility()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_gender()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_religion()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_marital_status()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_marital_tax_status()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_education_level()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_home_status()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_employee_status()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_employee_level()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_job_title()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_leave()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_nationality()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_occupation()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_card()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_education()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_experience()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_excuse()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_mutation()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_sosial()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_hr_training()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_fa_bank()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_c_greeting()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_c_bpartner()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['parent_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['greeting_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['first_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['last_name'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['website'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['email'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['phone'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['fax'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		/* Marketing area */
		$fields['is_customer'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_prospect'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_salesrep'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_manufacturer'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_sotaxexempt'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['salesrep_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['number_employees'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
		$fields['so_creditstatus'] = ['type' => 'CHAR', 'constraint' => '1', 'null' => TRUE];
		$fields['so_creditlimit'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['so_creditused'] = ['type' => 'NUMERIC', 'constraint' => '0', 'null' => TRUE];
		$fields['so_pricelist_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['invoice_rule'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['delivery_rule'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['deliveryvia_rule'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['freightcost_rule'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		/* Purchasing area */
		$fields['is_vendor'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_potaxexempt'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['po_pricelist_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		/* Finance area */
		$fields['taxid'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		return $fields;
	}
	
	function table_c_bpartner_location()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['bpartner_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['address'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['phone'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['fax'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['handphone'] = 	['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_c_bpartner_sosial()
	{
		$fields = $this->field_00_Main();
		$fields['bpartner_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['sosial_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['sosial_url'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
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