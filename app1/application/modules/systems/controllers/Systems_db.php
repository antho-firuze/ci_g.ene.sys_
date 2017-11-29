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
		// BOOLEAN
		$fields['is_mobile'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
	}
	
	function table_a_client()
	{
		$fields = $this->field_00_Main();
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
	
	function table_a_dataset()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['query'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_domain()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['path'] = ['type' => 'VARCHAR', 'constraint' => '128', 'null' => TRUE];
		$fields['timezone'] = ['type' => 'VARCHAR', 'constraint' => '64', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_info()
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
		$fields['seq'] 				= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['valid_from'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['valid_till'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['valid_org'] 		= ['type' => 'INT[]', 'constraint' => '32', 'null' => TRUE];
		$fields['valid_orgtrx'] = ['type' => 'INT[]', 'constraint' => '32', 'null' => TRUE];
		$fields['valid_orgdept']= ['type' => 'INT[]', 'constraint' => '32', 'null' => TRUE];
		$fields['valid_orgdiv'] = ['type' => 'INT[]', 'constraint' => '32', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_loginattempt()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['login'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['ip_address'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['time'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['user_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_menu()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['line_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_submodule'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_parent'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['parent_id'] = ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['icon'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE];
		$fields['path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['class'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['table'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['title'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['title_desc'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['type'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => 'W'];
		$fields['is_canexport'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => 'Y'];
		$fields['is_canimport'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => 'N'];
		$fields['is_needsort'] = ['type' => 'INT', 'constraint' => '8', 'default' => 0];
		return $fields;
	}
	
	function table_a_org()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['line_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['supervisor_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_parent'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['parent_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['orgtype_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['transit_warehouse_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['address_map'] = ['type' => 'VARCHAR', 'constraint' => '128', 'null' => TRUE];
		$fields['phone'] = ['type' => 'VARCHAR', 'constraint' => '64', 'null' => TRUE];
		$fields['phone2'] = ['type' => 'VARCHAR', 'constraint' => '64', 'null' => TRUE];
		$fields['fax'] = ['type' => 'VARCHAR', 'constraint' => '64', 'null' => TRUE];
		$fields['email'] = ['type' => 'VARCHAR', 'constraint' => '64', 'null' => TRUE];
		$fields['website'] = ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_orgtype()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['line_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_password_reset()
	{
		$fields['email'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['token'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE, 'unique' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		return $fields;
	}
	
	/* NOT IN USED, MERGED INTO [a_menu] */
	function table_a_form()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['help'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['class'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['table'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		return $fields;
	}
	
	/* NOT IN USED, MERGED INTO [a_menu] */
	function table_a_process()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['help'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['class'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['table'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		return $fields;
	}
	
	/* NOT IN USED, MERGED INTO [a_menu] */
	function table_a_window()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['help'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['class'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['method'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['table'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_queuemail()
	{
		$fields = $this->field_00_Main();
		$fields['sender'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['receiver'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['subject'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['message'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['is_sent'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['sent_date'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_role()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['currency_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['supervisor_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['amt_approval'] = ['type' => 'NUMERIC', 'constraint' => '18,2', 'default' => 0];
		$fields['is_canimport'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_canexport'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_canreport'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_canapproveowndoc'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_accessallorgs'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['is_useuserorgaccess'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_canviewlog'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		return $fields;
	}
	
	function table_a_role_dashboard()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['role_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['dashboard_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_active'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_deleted'] = ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['created_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['updated_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['deleted_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['updated_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['deleted_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['is_readwrite'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['seq'] = ['type' => 'INT', 'constraint' => '16', 'default' => 0];
		return $fields;
	}
	
	function table_a_role_menu()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['role_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['menu_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_active'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_deleted'] = ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['created_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['updated_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['deleted_by'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['updated_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['deleted_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['permit_form'] 	= ['type' => 'CHAR', 'constraint' => '1', 'null' => TRUE];
		$fields['permit_process'] 	= ['type' => 'CHAR', 'constraint' => '1', 'null' => TRUE];
		$fields['permit_window'] 	= ['type' => 'CHAR', 'constraint' => '1', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_sequence()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['start_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['digit_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['prefix'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['suffix'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['revision_code'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => 'R'];
		$fields['startnewyear'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['startnewmonth'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		return $fields;
	}
	
	function table_a_sequence_no()
	{
		$fields = $this->field_00_Main();
		$fields['sequence_id'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['year'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['month'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['last_no'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_system()
	{
		$fields = $this->field_00_Main();
		$fields['code'] = ['type' => 'VARCHAR', 'constraint' => '40', 'null' => TRUE];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['head_title'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['page_title'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['logo_text_mn'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['logo_text_lg'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['date_format'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['time_format'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['datetime_format'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['user_photo_path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['smtp_host'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['smtp_port'] = ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['smtp_user'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['smtp_pass'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['smtp_timeout'] = ['type' => 'INT', 'constraint' => '32', 'default' => 5];
		$fields['charset'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['mailtype'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['priority'] = ['type' => 'INT', 'constraint' => '32', 'default' => 3];
		$fields['protocol'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['max_file_upload'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['personnel_photo_path'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['group_symbol'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => ','];
		$fields['decimal_symbol'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '.'];
		$fields['negative_front_symbol'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '-'];
		$fields['negative_back_symbol'] 	= ['type' => 'CHAR', 'constraint' => '1', 'null' => TRUE];
		$fields['number_digit_decimal'] = ['type' => 'INT', 'constraint' => '32', 'default' => 2];
		$fields['default_skin'] = ['type' => 'VARCHAR', 'constraint' => '255', 'default' => 'skin-purple'];
		$fields['default_layout'] = ['type' => 'VARCHAR', 'constraint' => '255', 'default' => 'layout-fixed'];
		$fields['default_screen_timeout'] = ['type' => 'INT', 'constraint' => '32', 'default' => 60000];
		$fields['default_language'] = ['type' => 'VARCHAR', 'constraint' => '255', 'default' => 'english'];
		$fields['default_show_branch_entry'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		return $fields;
	}
	
	function table_a_access_log()
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
	
	function table_a_login_log()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['created_at'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		$fields['account'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['client_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['org_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['user_id'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['platform'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['ip_address'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_local'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['is_mobile'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['mobile'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_robot'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['robot'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['is_browser'] = ['type' => 'BOOLEAN', 'constraint' => '0', 'null' => TRUE];
		$fields['browser'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['browser_ver'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['user_agent'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE]; 
		$fields['status'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE]; 
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		/* This fields are for delay update, using schedule. To avoid slow access */
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
	
	function table_a_user()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['client_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['user_role_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['user_org_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['user_orgtrx_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['user_orgdept_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['user_orgdiv_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
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
		$fields['api_token'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['email'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['password'] = ['type' => 'VARCHAR', 'constraint' => '80', 'null' => TRUE];
		$fields['salt'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['remember_token'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE];
		$fields['last_login'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['is_online'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['supervisor_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['bpartner_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['is_fullbpaccess'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '1'];
		$fields['is_expired'] 	= ['type' => 'CHAR', 'constraint' => '1', 'default' => '0'];
		$fields['forgotten_password_code'] = ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['forgotten_password_time'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		$fields['ip_address'] = ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['photo_file'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['heartbeat'] 	= ['type' => 'INT', 'constraint' => '32', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_user_config()
	{
		$fields = $this->field_00_Main();
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['attribute'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['value'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_user_org()
	{
		$fields = $this->field_00_Main();
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['parent_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['parent_org_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['orgtype_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 2];
		return $fields;
	}
	
	function table_a_user_recent()
	{
		$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['value'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE]; 
		$fields['last_update'] = ['type' => 'TIMESTAMP', 'null' => TRUE];
		return $fields;
	}
	
	function table_a_user_role()
	{
		$fields = $this->field_00_Main();
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['role_id'] 	= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		return $fields;
	}
	
	function table_a_user_dataset()
	{
		$fields = $this->field_00_Main();
		$fields['user_id'] 		= ['type' => 'INT', 'constraint' => '32', 'default' => 0];
		$fields['name'] = ['type' => 'VARCHAR', 'constraint' => '60', 'null' => FALSE, 'unique' => TRUE];
		$fields['description'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['query'] = ['type' => 'TEXT', 'null' => TRUE];
		return $fields;
	}
	
	/* A listing for temporary import/export process */
	function table_a_tmp_process()
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
		$fields['message'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['log'] = ['type' => 'TEXT', 'null' => TRUE];
		$fields['file_url'] = ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE];
		$fields['status'] = ['type' => 'VARCHAR', 'constraint' => '5', 'null' => TRUE];
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