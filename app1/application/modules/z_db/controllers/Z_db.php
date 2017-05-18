<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Z_db extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}
	
	function table_h_personnel()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['sex_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['religion_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['maritalstatus_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['educationlevel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['homestatus_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['jobtitle_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['nationality_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['occupation_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['first_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['last_name'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_place'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['idcard_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['idcard_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['pasport_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['pasport_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['kitas_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['kitas_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['npwp_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['npwp_date'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['npwp_address'] 	= ['type' => 'TEXT', 'null' => TRUE];
		$fields['website'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['email'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['phone'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['fax'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		/* Employee area */
		$fields['is_employee'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['begin_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['end_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['employee_type'] 	= ['type' => 'CHAR', 'constraint' => '1',  'null' => TRUE];
		$fields['employee_grade'] 	= ['type' => 'CHAR', 'constraint' => '1',  'null' => TRUE];
		$fields['bpjs_tk_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['bpjs_kes_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['father_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['mother_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['spouse_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child1_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child2_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child3_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		return $fields;
	}
	
	function table_h_personnel_sosial()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['url'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		return $fields;
	}
	
	function table_h_personnel_training()
	{
		$fields = $this->field_00_Main();
		$fields['personnel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['training_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['training_date'] = ['type' => 'DATE', 'null' => TRUE];
		return $fields;
	}
	
	function table_bpartner()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		
		$fields['parent_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['greeting_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['sex_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['religion_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['maritalstatus_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['educationlevel_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['homestatus_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['jobtitle_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['nationality_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['occupation_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['first_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['last_name'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['join_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['birth_place'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['idcard_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['idcard_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['pasport_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['pasport_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['kitas_no'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['kitas_expired'] 	= ['type' => 'DATE', 'null' => TRUE];
		$fields['website'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['email'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['phone'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['fax'] 	= ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		/* HRD area */
		$fields['is_employee'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['employee_type'] 	= ['type' => 'CHAR', 'constraint' => '1',  'null' => TRUE];
		$fields['employee_grade'] 	= ['type' => 'CHAR', 'constraint' => '1',  'null' => TRUE];
		$fields['bpjs_tk_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['bpjs_kes_no'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['father_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['mother_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['spouse_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child1_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child2_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['child3_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
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
	
	function table_bpartner_location()
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
	
	function table_bpartner_sosial()
	{
		$fields = $this->field_00_Main();
		$fields['bpartner_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['url'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
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