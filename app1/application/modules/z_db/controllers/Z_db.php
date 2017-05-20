<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Z_db extends CI_Controller {

	function __construct() {
		parent::__construct();
		
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
		$fields['photo_file'] = ['type' => 'VARCHAR', 'constraint' => '120', 'null' => TRUE];
		$fields['photo_bin'] = ['type' => 'BYTEA', 'null' => TRUE];
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
		$fields['employee_status'] 	= ['type' => 'VARCHAR', 'constraint' => '60',  'null' => TRUE];
		$fields['number_leave_status'] = ['type' => 'NUMERIC', 'constraint' => '10', 'null' => TRUE];
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