<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Systems_db extends CI_Controller {

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
	
	function table_a_activity_log()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['client_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['org_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '12', 'null' => TRUE];
		$fields['table_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['record_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['column_name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['old_value'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['new_value'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['trxname'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_user_org()
	{
		$fields = $this->field_00_Main();
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		return $fields;
	}
	
	function table_a_user_orgtrx()
	{
		$fields = $this->field_00_Main();
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['user_orgtrx_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		return $fields;
	}
	
	/* A listing for temporary table name for import process */
	function table_a_tmp_tables()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['time'] 	= ['type' => 'INT', 'constraint' => '64', 'default' => 0];
		return $fields;
	}
	
	/* A listing for temporary import/export process */
	function table_a_tmp_progress()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['created_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['percent'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['finished_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['duration'] = ['type' => 'TIME', 'null' => TRUE];
		$fields['start_time'] 	= ['type' => 'INT', 'constraint' => '64', 'default' => 0];
		$fields['stop_time'] 	= ['type' => 'INT', 'constraint' => '64', 'default' => 0];
		$fields['duration_time'] = ['type' => 'INT', 'constraint' => '64', 'default' => 0];
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