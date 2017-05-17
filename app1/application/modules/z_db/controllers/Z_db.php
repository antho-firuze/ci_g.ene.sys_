<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Z_db extends CI_Controller {

	function __construct() {
		parent::__construct();
		
	}
	
	function field_bpartner()
	{
		$fields['first_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['last_name'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['join_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['birth_place'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['email'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		/* Marketing area */
		$fields['is_prospect'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_vendor'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_customer'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_employee'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_salesrep'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		/* Finance area */
		$fields['taxid'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['is_taxexempt'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
	}
	
	function field_bpartner_contact()
	{
		$fields['first_name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['last_name'] 	= ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['join_date'] = 	['type' => 'DATE', 'null' => TRUE];
		$fields['birth_place'] = 	['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['birth_date'] = 	['type' => 'DATE', 'null' => TRUE];
	}
	
	function field_bpartner_sosial()
	{
		$fields['url'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
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
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function create_table($tbl_name)
	{
		/* Drop table if exists  */
		$this->load->dbforge();
		$this->dbforge->drop_table($tbl_name,TRUE);
		/* DEFAULT FIELDS */
		$fields = $this->field_00_Main();
		/* ADDITIONAL FIELDS */
		$fields['number_employees'] = ['type' => 'NUMERIC', 'null' => TRUE];
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