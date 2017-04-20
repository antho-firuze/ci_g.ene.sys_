<?php defined('BASEPATH') OR exit('No direct script access allowed');

// GENERATE AUTO CODE ===============================
if ( ! function_exists('get_doc_code'))
{
	function get_doc_code( $company_id=NULL, $branch_id=NULL, $department_id=NULL, $date, $code, $custom_1=NULL, $custom_2=NULL, $custom_3=NULL ) {
		$ci = get_instance();
		
		$filter['code'] = $code;
		if ( !empty($company_id) ) $filter['company_id'] = $company_id;
		if ( !empty($branch_id) ) $filter['branch_id'] = $branch_id;
		if ( !empty($department_id) ) $filter['department_id'] = $department_id;
		$qry = $ci->db->get_where( 'setup_documents', $filter );
		if ($qry->num_rows() < 1) 
			return FALSE;
		
		// NEW METHOD (with back date support)
		$row = $qry->row();
		$qry2 = $ci->db->get_where( 'setup_documents_num', array("document_id"=>$row->id, "year"=>date("Y", strtotime($date))) );
		if ($qry2->num_rows() < 1) {
			$data1['document_id'] = $row->id;
			$data1['year']		  = empty($date) ? date('Y') : date("Y", strtotime($date));
			$data1['number']	  = 1;
			$ci->db->insert( 'setup_documents_num', $data1);
			
			$id_num = $ci->db->insert_id();
			$last_number = $data1['number'];
		} else {
			$row2 = $qry2->row();
			
			$id_num 	 = $row2->id;
			$last_number = $row2->number+1;
		}
		
		$prefix_code_length = $row->prefix_code_length;
		for ($i = 1; $i <= $prefix_code_length; $i++){
			if ($i==1) {
				if ( !empty($row->prefix_code1) )
					$newcode[$i] = get_doc_prefix($row->prefix_code1, $date, $row->number_digit, $last_number, $custom_1, $custom_2, $custom_3);
			} elseif ($i==2) {
				if ( !empty($row->prefix_code2) )
					$newcode[$i] = get_doc_prefix($row->prefix_code2, $date, $row->number_digit, $last_number, $custom_1, $custom_2, $custom_3);
			} elseif ($i==3) {
				if ( !empty($row->prefix_code3) )
					$newcode[$i] = get_doc_prefix($row->prefix_code3, $date, $row->number_digit, $last_number, $custom_1, $custom_2, $custom_3);
			} elseif ($i==4) {
				if ( !empty($row->prefix_code4) )
					$newcode[$i] = get_doc_prefix($row->prefix_code4, $date, $row->number_digit, $last_number, $custom_1, $custom_2, $custom_3);
			} elseif ($i==5) {
				if ( !empty($row->prefix_code5) )
					$newcode[$i] = get_doc_prefix($row->prefix_code5, $date, $row->number_digit, $last_number, $custom_1, $custom_2, $custom_3);
			} elseif ($i==6) {
				if ( !empty($row->prefix_code6) )
					$newcode[$i] = get_doc_prefix($row->prefix_code6, $date, $row->number_digit, $last_number, $custom_1, $custom_2, $custom_3);
			}
		}
		
		// UPDATE & SAVE LAST NUMBER
		$data3['number'] = $last_number;
		$ci->db->update( 'setup_documents_num', $data3, array("id"=>$id_num) );
		
		return implode($row->separator,$newcode);
	}
}

if ( ! function_exists('number_code'))
{
	function number_code($num, $len = 5) {
		
		for ($i = 1, $n = (string)$num; strlen($n) < $len; $i++)
			$n = '0'.$n;
			
		return $n;
	}
}

if ( ! function_exists('get_doc_prefix'))
{
	function get_doc_prefix( $prefix_code, $date=NULL, $number_digit=NULL, $number=NULL, $custom_1=NULL, $custom_2=NULL, $custom_3=NULL ) {
		if ($prefix_code=='YYYY') 
			return date("Y", strtotime($date));
		elseif ($prefix_code=='YY') 
			return substr(date("Y", strtotime($date)), -2);
		elseif ($prefix_code=='MM') 
			return date('m', strtotime($date));
		elseif ($prefix_code=='NUMBER') 
			return number_code($number, $number_digit);
		elseif ($prefix_code=='CUSTOM_1') 
			return $custom_1;
		elseif ($prefix_code=='CUSTOM_2') 
			return $custom_2;
		elseif ($prefix_code=='CUSTOM_3') 
			return $custom_3;
		else
			return $prefix_code;
	}
}

if ( ! function_exists('set_doc_last_number'))
{
	function set_doc_last_number( $company_id, $branch_id, $department_id, $code, $auto_code ) {
		$ci = get_instance();
		
		$data['company_id']    = $company_id;
		$data['branch_id'] 	   = $branch_id;
		$data['department_id'] = $department_id;
		$data['department_id'] = $department_id;
		$data['code'] 		   = $code;
		$qry = $ci->db->get_where( 'setup_documents', $data );
		if ($qry->num_rows() < 1) 
			return FALSE;
		
		$row = $qry->row();
		if ( empty($row->separator) ) {
			$start = 0;
			for ($i = 1; $i <= $row->prefix_code_length; $i++){
				if ($i==1) {
					$prefix_code = $row->prefix_code1;
				} elseif ($i==2) {
					$prefix_code = $row->prefix_code2;
				} elseif ($i==3) {
					$prefix_code = $row->prefix_code3;
				} elseif ($i==4) {
					$prefix_code = $row->prefix_code4;
				} elseif ($i==5) {
					$prefix_code = $row->prefix_code5;
				} elseif ($i==6) {
					$prefix_code = $row->prefix_code6;
				}
				
				if ($prefix_code=='YYYY') {
					$year = (int)substr($auto_code, $start, 4);
					$start += 4;
				} elseif ($prefix_code=='MM') {
					$start += 2;
				} elseif ($prefix_code=='NUMBER') {
					$num = (int)substr($auto_code, $start, $row->number_digit);
					$start += $row->number_digit;
				} else {
					$start += strlen($prefix_code);
				}
			}
		} else {
		
			$tmp = explode($row->separator, $auto_code);
			for ($i = 1, $a = 0; $a < $row->prefix_code_length; $i++, $a++){
				if ($i==1) {
					$prefix_code = $row->prefix_code1;
				} elseif ($i==2) {
					$prefix_code = $row->prefix_code2;
				} elseif ($i==3) {
					$prefix_code = $row->prefix_code3;
				} elseif ($i==4) {
					$prefix_code = $row->prefix_code4;
				} elseif ($i==5) {
					$prefix_code = $row->prefix_code5;
				} elseif ($i==6) {
					$prefix_code = $row->prefix_code6;
				}
				
				if ($prefix_code=='YYYY') {
					$year = (int)$tmp[$a];
				} elseif ($prefix_code=='MM') { 
					$month = (int)$tmp[$a];
				} elseif ($prefix_code=='NUMBER') {
					$num = (int)$tmp[$a];
				} else {
					$cod = $tmp[$a];
				}
			}
		}
		
		$data1['last_year'] = $year;
		$data1['last_number'] = $num;
		$ci->db->update( 'setup_documents', $data1, $data );
		
		return TRUE;
	}
}
