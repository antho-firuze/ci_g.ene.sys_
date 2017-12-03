<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Urls_db extends CI_Controller {

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
		// NUMBER
		$fields['number'] 	= ['type' => 'INT', 'constraint' => '16', 'null' => TRUE];	
		// NUMERIC PERCENTAGE
		$fields['percent'] 	= ['type' => 'NUMERIC', 'constraint' => '18,4', 'null' => TRUE];	
		// NUMERIC AMOUNT
		$fields['amount'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'null' => TRUE];
	}
	
	function table_w_shortenurl()
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
		$fields['url'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['counter'] 	= ['type' => 'INT', 'constraint' => '16', 'null' => TRUE];	
		$fields['hit'] 	= ['type' => 'INT', 'constraint' => '16', 'null' => TRUE];	
		return $fields;
	}
	
	function table_w_shortenurl_log()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['ip_address'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_local'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '12', 'null' => TRUE]; 
		$fields['protocol'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['host'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['request_uri'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['user_agent'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE]; 
		$fields['platform'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_mobile'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['mobile'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_robot'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['robot'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_browser'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['browser'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['browser_ver'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['width'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE]; 
		$fields['height'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE]; 
		/* This fields are for delay update, using schedule. To avoid slow access */
		$fields['domain_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['client_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['country'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['country_code'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['region'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['region_name'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['city'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['zip'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['lat'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['lon'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['timezone'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['isp'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['org'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['as_number'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
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