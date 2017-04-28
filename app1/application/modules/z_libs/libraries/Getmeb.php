<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* THIS IS CLASS FOR BASE CONTROLLER (BACKEND) */
class Getmeb extends CI_Controller
{
	/* DEFAULT TEMPLATE */
	public $theme  	= 'adminlte';
	/* FOR REQUEST METHOD */
	public $r_method;	
	/* FOR CONTROLLER METHOD */
	public $c_method;
	/* FOR EXCEPTION METHOD */
	public $exception_method = [];
	/* FOR GETTING PARAMS FROM REQUEST URL */
	public $params;
	/* FOR AUTOLOAD MODEL */
	public $mdl;
	/* FOR ADDITIONAL CRUD FIXED DATA */
	public $fixed_data = array();
	public $create_log = array();
	public $update_log = array();
	public $delete_log = array();
	/* FOR GETTING ERROR MESSAGE OR SUCCESS MESSAGE */
	public $messages = array();
	
	/* ========================================= */
	/* This variable for dynamic page lookup		 */
	/* ========================================= */
	public $pageid;
	/* ========================================= */
	/* This variable for INSERT & UPDATE records */
	/* ========================================= */
	/* FOR DEFINED BOOLEAN FIELDS */
	// public $boolfields = [];
	/* FOR DEFINED ALLOW NULL FIELDS */
	// public $nullfields = [];
	/* FOR DEFINED IDENTITY FIELD WHICH CANNOT NE DUPLICATE */
	public $identity_keys = ['name'];
	
	/* ========================================= */
	/* This variable for UPLOAD & DOWNLOAD files */
	/* ========================================= */
	// public $tmp_dir = APPPATH.'../var/tmp/';
	public $tmp_dir = FCPATH.'var/tmp/';
	public $allow_ext = 'jpg,jpeg,png,gif,xls,xlsx,csv,doc,docx,ppt,pptx,pdf,zip,rar';
	public $max_file_upload = '2mb';
	
	/* ========================================= */
	/* This variable for IMPORT & EXPORT files */
	/* ========================================= */
	public $protected_fields = [];
	public $rel_tmp_dir = 'var/tmp/';
	public $filetype = 'xls';	// xls, csv, pdf, html
	public $is_compress = false;	
	public $imported_fields = [];
	public $tmp_fields = [];
	
	function __construct() {
		parent::__construct();
		$this->r_method = $_SERVER['REQUEST_METHOD'];
		$this->c_method = $this->uri->segment(2);
		
		/* Defined for template */
		define('ASSET_URL', base_url().'/assets/');
		define('TEMPLATE_URL', base_url().TEMPLATE_FOLDER.'/backend/'.$this->theme.'/');
		define('TEMPLATE_PATH', '/backend/'.$this->theme.'/');
		
		$this->lang->load('systems/systems', (!empty($this->session->language) ? $this->session->language : 'english'));
		
		$this->fixed_data = [
			'client_id'		=> DEFAULT_CLIENT_ID,
			'org_id'			=> DEFAULT_ORG_ID
		];
		$this->create_log = [
			'created_by'	=> (!empty($this->session->user_id) ? $this->session->user_id : '0'),
			'created_at'	=> date('Y-m-d H:i:s')
		];
		$this->update_log = [
			'updated_by'	=> (!empty($this->session->user_id) ? $this->session->user_id : '0'),
			'updated_at'	=> date('Y-m-d H:i:s')
		];
		$this->delete_log = [
			'is_deleted'	=> 1,
			'deleted_by'	=> (!empty($this->session->user_id) ? $this->session->user_id : '0'),
			'deleted_at'	=> date('Y-m-d H:i:s')
		];

		$this->_clear_tmp();
		
		/* This process is a special case, because using multiple r_method (POST and OPTIONS). Request for Import Data */
		// if (isset($this->params['import']) && !empty($this->params['import'])) {
			// /* Check permission in the role */
			// $this->_check_is_allow_inrole('canexport');
		// }


		/* This process is running before checking request method */
		$this->_check_is_login();
		/* This Request for GETTING/VIEWING Data */
		if (in_array($this->r_method, ['GET'])) {
			/* Become Array */
			$this->params = $this->input->get();

			/* Request for viewlog */
			if (isset($this->params['viewlog']) && !empty($this->params['viewlog'])) {
				/* Check permission in the role */
				$this->_check_is_allow_inrole('canviewlog');
				$this->_get_viewlog();
			}
			
			/* Request for Export Data */
			if (isset($this->params['export']) && !empty($this->params['export'])) {
				/* Check permission in the role */
				$this->_check_is_allow_inrole('canexport');
			}
		}
		
		/* This Request for INDERT & UPDATE Data */
		if (in_array($this->r_method, ['POST','PUT'])) {
			/* Must be checking permission before next process */
			$this->_check_is_allow();
			
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
			
		}
		
		/* This Request for DELETE Data */
		if (in_array($this->r_method, ['DELETE'])) {
			/* Must be checking permission before next process */
			$this->_check_is_allow();

			/* Become Array */
			$this->params = $this->input->get();
			if (! $this->deleteRecords($this->c_method, $this->params['id']))
				$this->xresponse(FALSE, ['message' => $this->messages()], 401);
			else
				$this->xresponse(TRUE, ['message' => $this->messages()]);
		}
		
		/* This Request for EXPORT/IMPORT, PROCESS/REPORT & FORM  */
		if (in_array($this->r_method, ['OPTIONS'])) {
			/* Must be checking permission before next process */
			$this->_check_is_allow();
			
			/* Become Object */
			$this->params = json_decode($this->input->raw_input_stream);
			$this->params = count($this->params) > 0 ? $this->params : (object)$_REQUEST;
			
			/* Request for Export Data */
			if (isset($this->params->export) && !empty($this->params->export)) {
				/* Check permission in the role */
				$this->_check_is_allow_inrole('canexport');
				$this->_pre_export_data();
			}
		}
	}
	
	/* This procedure is for cleaning a tmp file & tmp_tables */
	function _clear_tmp()
	{
		/* Note: 60(sec) x 60(min) x 2-24(hour) x 2~(day) */
		
		/* Check & Execute for every 1 hour */
		if (!empty($cookie = $this->input->cookie('_clear_tmp'))) {
			if ((time()-$cookie) < 60*60) 
				return;
		}
				
		setcookie('_clear_tmp', time());
		if ($handle = @opendir($this->tmp_dir)) {
			while (false !== ($file = @readdir($handle))) {
				if (! preg_match('/^(\.htaccess|index\.(html|htm|php)|web\.config)$/i', $file)) {
					if ((time()-filectime($this->tmp_dir.$file)) > 60*60) {  
						@unlink($this->tmp_dir.$file);
					}
				}
			}
		}
		
		/* Cleaning tmp_tables */
		$qry = $this->db->get_where('a_tmp_tables', ['time <' => time()-60*60]);
		if ($qry->num_rows() > 0){
			$this->load->dbforge();
			foreach($qry->result() as $k => $v){
				$this->dbforge->drop_table($v->name,TRUE);
			}
			$this->db->where('time <', time()-60*60, FALSE);
			$this->db->delete('a_tmp_tables');
		}
	}
	
	function _check_menu($data=[])
	{
		/* CHECK METHOD */
		if (empty($data['method'])) {
			$this->set_message('ERROR: Menu [method] is could not be empty !');
			return FALSE;
		}

		/* CHECK PATH FILE */
		if (!$this->_check_path($data['path'].$data['table'])) {
			$this->set_message('ERROR: Menu [path] is could not be found or file not exist !');
			return FALSE;
		}
		
		if (key_exists('edit', $this->params) && !empty($this->params['edit'])) {
			if (!$this->_check_path($data['path'].$data['table'].'_edit')) {
				$this->set_message('ERROR: Page or File ['.$data['path'].$data['table'].'_edit'.'] is could not be found or file not exist !');
				return FALSE;
			}
		}
		
		/* CHECK CLASS/CONTROLLER */
		if (!$this->_check_class($data['class'])) {
			$this->set_message('ERROR: Menu [class] is could not be found or file not exist !');
			return FALSE;
		}
		
		return TRUE;
	}
	
	function _check_path($path)
	{
		return file_exists(APPPATH.'../'.TEMPLATE_FOLDER.'/backend/'.$this->theme.'/'.$path.'.tpl') ? TRUE : FALSE;
	}
	
	function _check_class($class)
	{
		return file_exists(APPPATH.'modules/'.$class.'/controllers/'.$class.'.php') ? TRUE : FALSE;
	}
	
	function _check_is_login()
	{
		/* This process is for bypass methods which do not need to login */
		if (count($this->exception_method) > 0){
			if (in_array($this->c_method, $this->exception_method)){
				return TRUE;
			}
		}
		
		/* Check the session data for user_id */
		if (!$this->session->userdata('user_id')) {
			/* set reference url to session */
			setURL_Index();
			/* forward to login page */
			// $this->x_login();
			redirect(LOGIN_LNK);
			exit();
		}
		return TRUE;
	}
	
	function _check_is_allow()
	{
		/* This process is for bypass methods which do not need to login */
		if (count($this->exception_method) > 0){
			if (in_array($this->c_method, $this->exception_method))
				return;
		}
		/* Only check this request method */
		if (!in_array($this->r_method, ['POST','PUT','DELETE','OPTIONS'])){
			return;
		}
		
		$menu = $this->base_model->getValue('id, name, type', 'a_menu', 'table', $this->c_method);
		if (!$menu){
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Table ['.$this->c_method.'] not found in [a_menu] !'], 401);
		}
		$allow = $this->base_model->getValue('permit_form, permit_process, permit_window', 'a_role_menu', ['role_id', 'menu_id', 'is_active', 'is_deleted'], [$this->session->role_id, $menu->id, '1', '0']);
		if ($allow === FALSE)
			$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$menu->name.'] not found in [a_role_menu] !'], 401);

		if ($menu->type == 'F') {
			switch($allow->permit_form){
			case '1':
				/* Execute */
				if (!in_array($this->r_method, ['OPTIONS']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			default:
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$menu->name.'] is not set !'], 401);
				break;
			}
		}
		if ($menu->type == 'P') {
			switch($allow->permit_process){
			case '1':
				/* Export */
				if (!in_array($this->r_method, ['OPTIONS']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			default:
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Permission ['.$menu->name.'] is not set !'], 401);
				break;
			}
		}
		if ($menu->type == 'W') {
			switch($allow->permit_window){
			case '1':
				/* Only Create */
				if (!in_array($this->r_method, ['POST']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '2':
				/* Only Edit */
				if (!in_array($this->r_method, ['PUT']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '3':
				/* Only Delete */
				if (!in_array($this->r_method, ['DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '4':
				/* Can Create & Edit */
				if (!in_array($this->r_method, ['POST','PUT']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '5':
				/* Can Create & Delete */
				if (!in_array($this->r_method, ['POST','DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '6':
				/* Can Edit & Delete */
				if (!in_array($this->r_method, ['PUT','DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			case '7':
				/* Can All */
				if (!in_array($this->r_method, ['POST','PUT','DELETE']))
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')], 401);
				break;
			default:
				$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud'), 'note' => 'Menu ['.$menu->name.'] is not set !'], 401);
				break;
			}
		}
	}
	
	function _check_is_allow_inrole($permit)
	{
		$role = $this->base_model->getValue('*', 'a_role', 'id', $this->session->role_id);
		switch($permit){
			case 'canviewlog':
				if (!$role->is_canviewlog)
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')]);
				break;
			case 'canexport':
				if (!$role->is_canexport)
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')]);
				break;
			case 'canapproveowndoc':
				if (!$role->is_canapproveowndoc)
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')]);
				break;
			case 'canreport':
				if (!$role->is_canreport)
					$this->xresponse(FALSE, ['message' => $this->lang->line('permission_failed_crud')]);
				break;
		}
	}
	
	function _get_viewlog()
	{
		$result = [];
		$result['table'] = $this->c_method;
		$result['id'] = $this->params['id'];
		if ($info = $this->base_model->getValue('created_by, created_at, updated_by, updated_at, deleted_by, deleted_at', $this->c_method, 'id', $this->params['id'])){
			if ($info->created_by){
				if ($user = $this->base_model->getValue('id, name', 'a_user', 'id', $info->created_by)) {
					$result['created_by'] 		 = $user->id;
					$result['created_at'] 		 = $info->created_at;
					$result['created_by_name'] = $user->name;
				}
			}
			if ($info->updated_by){
				if ($user = $this->base_model->getValue('id, name', 'a_user', 'id', $info->updated_by)) {
					$result['updated_by'] 		 = $user->id;
					$result['updated_at'] 		 = $info->updated_at;
					$result['updated_by_name'] = $user->name;
				}
			}
			if ($info->deleted_by){
				if ($user = $this->base_model->getValue('id, name', 'a_user', 'id', $info->deleted_by)) {
					$result['deleted_by'] 		 = $user->id;
					$result['deleted_at'] 		 = $info->deleted_at;
					$result['deleted_by_name'] = $user->name;
				}
			}
		}
		$this->xresponse(TRUE, ['data' => $result]);
	}
	
	function _pre_update_records($return = FALSE)
	{
		$datas = [];
		$fields = $this->db->list_fields($this->c_method);
		foreach($fields as $f){
			if (key_exists($f, $this->params)){
				/* Check if any exists allow null fields */
				$datas[$f] = ($this->params->{$f} == '') ? NULL : $this->params->{$f}; 
				
				/* Check if any exists boolean fields */
				/* if (in_array($f, $this->boolfields)){
					$datas[$f] = empty($this->params->{$f}) ? '0' : '1'; 
				}  */
				/* Check if any exists allow null fields */
				/* elseif (in_array($f, $this->nullfields)){
					$datas[$f] = ($this->params->{$f}=='') ? NULL : $this->params->{$f}; 
				} else {
					$datas[$f] = $this->params->{$f};
				} */
			}
		}
		
		if ($return) 
			return $datas;
			
		if ($this->r_method == 'POST')
			$result = $this->insertRecord($this->c_method, $datas, TRUE, TRUE);
		else
			$result = $this->updateRecord($this->c_method, $datas, ['id'=>$this->params->id], TRUE);				
		
		if (! $result)
			$this->xresponse(FALSE, ['message' => $this->messages()], 401);
		else
			$this->xresponse(TRUE, ['message' => $this->messages()]);
	}
	
	function _upload_file()
	{
		/* get the params & files (special for upload file) */
		$files = $_FILES;
		
		$this->max_file_upload = isset($this->session->max_file_upload) ? $this->session->max_file_upload : $this->max_file_upload;
		
		@ini_set( 'upload_max_size' , $this->max_file_upload );
		@ini_set( 'post_max_size', $this->max_file_upload );
		@ini_set( 'max_execution_time', '300' );
		
		if ($this->r_method == 'POST') {
			if (isset($files['file']['name']) && $files['file']['name']) {
				/* Load the library */
				require_once APPPATH."/third_party/Plupload/PluploadHandler.php"; 
				$ph = new PluploadHandler(array(
					'target_dir' => $this->tmp_dir,
					'allow_extensions' => $this->allow_ext
				));
				$ph->sendNoCacheHeaders();
				$ph->sendCORSHeaders();
				/* And Do Upload */
				if (!$result = $ph->handleUpload()) {
					$this->set_message($ph->getErrorMessage());
					return FALSE;
				}
				/* Result Output in array : array('name', 'path', 'chunk', 'size') */
				return $result;
			}
		}
	}
	
	function _pre_export_data($return = FALSE)
	{
		/* Parsing pageid, if on sub module */
		$this->pageid = explode(',', $this->params['pageid']);
		$this->pageid = end($this->pageid);
		
		/* Get the Table */
		$menu = $this->base_model->getValue('*', 'a_menu', ['client_id','id'], [DEFAULT_CLIENT_ID, $this->pageid]);
		if (!$menu)
			$this->xresponse(FALSE, ['message' => $this->lang->line('export_failed'), 'note' => '[pageid='.$this->pageid.'] is not exists on [a_menu]'], 401);

		if (!$this->db->table_exists($menu->table))
			$this->xresponse(FALSE, ['message' => $this->lang->line('export_failed'), 'note' => '[pageid='.$this->pageid.'][table='.$menu->table.'] does not exists'], 401);

		$protected_fields = ['id','client_id','org_id','is_deleted','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];
		$fields = $this->db->list_fields($menu->table);
		$fields = array_diff($fields, array_merge($protected_fields, $this->protected_fields));
		$select = implode(',', $fields);
		
		$this->params['export'] = 1;
		$this->params['select'] = $select;
		if (! $result = $this->{$this->mdl}->{'get_'.$this->c_method}($this->params)){
			$result['data'] = [];
			$result['message'] = $this->base_model->errors();
			$this->xresponse(FALSE, $result);
		}

		if ($return)
			return $result;
		
		$this->filetype = $this->params['filetype'];
		$this->is_compress = $this->params['is_compress'];
		
		// $this->_export_data($result);
		$result = $this->_export_data($result, TRUE);
		$this->xresponse(TRUE, $result);
	}
	
	function _export_data($qry, $return = FALSE)
	{
		ini_set('memory_limit', '-1');
		$this->load->library('z_libs/Excel');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Set the Title in the first row
		$current = 'A';
		$col = 0;
		foreach ($qry->list_fields() as $field) {
			$columns[] = ($col == 0) ? $current : ++$current;
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}

		// Set the Data in the next row
		$row = 2;
		foreach($qry->result() as $data) {
			$col = 0;
			foreach ($qry->list_fields() as $field) {
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
				$col++;
			}
			$row++;
		}
		
		// Set the Column to Fit AutoSize
		foreach($columns as $column) {
			$objPHPExcel->getActiveSheet()->getColumnDimension($column)->setAutoSize(true);
		}
		
		$filename = $this->c_method.'_'.date('YmdHi').'.'.$this->filetype;
		
		if ($this->filetype == 'xls') {
			if ($return){
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				if ($this->is_compress) {
					if(! $result = $this->_compress_file($this->tmp_dir.$filename))
						return FALSE;
					
					return $result;
				}
				return ['filename' => $filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}

			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			$objWriter->save('php://output');
		}
		if ($this->filetype == 'csv'){
			PHPExcel_Shared_String::setDecimalSeparator('.');
			PHPExcel_Shared_String::setThousandsSeparator(',');

			if ($return){
				$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				if ($this->is_compress) {
					if(! $result = $this->_compress_file($this->tmp_dir.$filename))
						return FALSE;
					
					return $result;
				}
				return ['filename' => $filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			
			$objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
			$objWriter->save('php://output');
			
		}
		if ($this->filetype == 'pdf'){
			$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
			$rendererLibraryPath = FCPATH.'../vendor/mpdf/mpdf/src/';
			if (!PHPExcel_Settings::setPdfRenderer($rendererName,	$rendererLibraryPath)) {
					die(
							'Please set the $rendererName and $rendererLibraryPath values' .
							PHP_EOL .
							' as appropriate for your directory structure'
					);
			}
			if ($return){
				$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				if ($this->is_compress) {
					if(! $result = $this->_compress_file($this->tmp_dir.$filename))
						return FALSE;
					
					return $result;
				}
				return ['filename' => $filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
			$objWriter->save('php://output');
		}
		if ($this->filetype == 'html'){
			if ($return){
				$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
				$objWriter->save($this->tmp_dir.$filename);
				if ($this->is_compress) {
					if(! $result = $this->_compress_file($this->tmp_dir.$filename))
						return FALSE;
					
					return $result;
				}
				return ['filename' => $filename, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filename];
			}
			
			$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);
			$objWriter->save('php://output');
		}
		exit;
	}
	
	function _compress_file($file)
	{
		$zip = new ZipArchive();
		$pathinfo = pathinfo($file);
		$dir = $pathinfo['dirname'];
		$fil = $pathinfo['filename'];
		$fbn = $pathinfo['basename'];
		$ext = strtolower($pathinfo['extension']);
		$filezip = $fil.'.zip';
		$fil_tmp = $dir.'/'.$filezip;
		if ($zip->open($fil_tmp, ZipArchive::CREATE)!==TRUE) {
			exit("cannot open <$fil_tmp>\n");
		}
		$zip->addFile($file,$fbn);
		$zip->close();
		/* remove master file */
		@unlink($file);
		return ['filename' => $filezip, 'file_url' => BASE_URL.$this->rel_tmp_dir.$filezip];
	}
	
	function _reorder_menu()
	{
		$strq = "select t1.* 
			from(select id as grp, * from a_menu where is_parent = '1' union all select parent_id as grp, * from a_menu where is_parent = '0') as t1
			where is_deleted = '0' and type != 'P' order by grp, is_parent desc, is_submodule, line_no";
		$fetch = $this->db->query($strq);
		$line = 1; $lineh = 1;
		foreach($fetch->result() as $k => $v){
			if ($v->is_parent == 1){
				$line = 1;
				$this->db->update('a_menu', ['line_no' => $lineh], ['id' => $v->id]);
				$lineh++;
				continue;
			}
			$this->db->update('a_menu', ['line_no' => $line], ['id' => $v->id]);
			$line++;
		}
	}

	function _import_data()
	{
		if (isset($this->params->step) && $this->params->step == '1') {
			if (!$result = $this->_upload_file()){
				$this->xresponse(FALSE, ['message' => $this->messages()]);
			}
			
			/* If Success */
			if ($this->params->filetype == 'csv'){
				$this->load->library('z_libs/Excel');
				$objReader = new PHPExcel_Reader_CSV();
				$objReader->setInputEncoding('CP1252');
				$objReader->setDelimiter(';');
				$objReader->setEnclosure('');
				$objReader->setSheetIndex(0);
				$objPHPExcel = $objReader->load($result["path"]);
				$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			}
			
			if (!$tmp_table = $this->session->tmp_table) {
				/* Create random filename for tmp_table */
				$this->load->helper('string');
				$tmp_table = "z_".random_string('alnum', 5);
				$this->session->set_userdata(['tmp_table' => $tmp_table]);
			} 
			
			/* Insert into Table  */
			$this->load->dbforge();
			$this->dbforge->drop_table($tmp_table,TRUE);
			foreach($sheetData as $k => $v){
				if ($k == 1){
					$title = explode(',', $v['A']);
					$fields['id'] = ['type' => 'INT', 'constraint' => 9, 'auto_increment' => TRUE];
					foreach(explode(',', $v['A']) as $k => $name) {
						$fields[$name] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE];
					}
					$this->dbforge->add_field($fields);
					$this->dbforge->create_table($tmp_table);
					
					/* Adding table name to a_tmp_tables */
					$this->db->delete('a_tmp_tables', ['name' => $tmp_table]);
					$this->db->insert('a_tmp_tables', ['name' => $tmp_table, 'created_at' => date('Y-m-d H:i:s'), 'time' => time()]);
				} else {
					foreach(explode(',', $v['A']) as $k => $v) {
						$val[$title[$k]] = !empty($v) && $v && $v != '' ? str_replace('"','',$v) : NULL;
					}
					
					$this->db->insert($tmp_table, $val);
				}
			}
			$this->tmp_fields = $this->db->list_fields($tmp_table);
		}
		if (isset($this->params->step) && $this->params->step == '2') {
			/* Add column status to tmp_table */
			$fields['status'] = ['type' => 'VARCHAR', 'constraint' => '100', 'null' => TRUE];
			$this->load->dbforge();
			$this->dbforge->add_column($this->session->tmp_table, $fields);
			
			/* Insert into target table */
			$qry = $this->db->get($this->session->tmp_table);
			if($qry->num_rows() > 0){
				foreach($qry->result_array() as $k => $values){
					$id = ['id' => $values['id']];
					unset($values['id']);
					unset($values['status']);
					// debug($values);
					if ($this->import_type == 'insert') {
						
						if (!$result = $this->insertRecord($this->c_method, $values, TRUE, TRUE)) {
							$this->db->update($this->session->tmp_table, ['status' => $this->messages(FALSE)], $id);
						}
						
					} elseif ($this->import_type == 'update') {
						
						/* Setup identity_keys */
						if ($this->identity_keys){
							$val = [];
							foreach($this->identity_keys as $k => $v){
								if (isset($values[$v])){
									$val[$v] = $values[$v];
								}
							}

							if (count($val) > 0) {
								$fk = $this->db->get_where($this->c_method, array_merge($val, ['is_active' => '1', 'is_deleted' => '0']), 1);
								// debugf($this->db->last_query());
								if ($fk->num_rows() < 1){
									$this->db->update($this->session->tmp_table, ['status' => 'This line is not exist !'], $id);
								} else {
									if (!$result = $this->updateRecord($this->c_method, $values, array_merge($val, ['is_active' => '1', 'is_deleted' => '0']), TRUE)) {
										$this->db->update($this->session->tmp_table, ['status' => $this->messages(FALSE)], $id);
									}
								}
							}
						} else {
							$this->set_message('Failed: Method ['.$this->c_method.'] the identity_keys was not set !');
							return FALSE;
						}
					}
				}
			}
		}
	}
	
	function set_message($message, $func=NULL, $args=NULL)
	{
		$msg = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
		
		if (!empty($args)){
			$args = is_array($args) ? 
				str_replace('+', ' ', http_build_query($args,'',', ')) : 
				$args;
			$args = sprintf('Context : <br> function %s(), [%s]', $func, $args);
			$msg = sprintf('%s<br><br>%s', $msg, $args);
		}
		$this->messages[] = $msg;
		return $message;
	}

	function messages($use_p = TRUE)
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
			if ($use_p)
				$_output .= '<p>' . $message . '</p>';
			else
				$_output .= $message.' ';
		}
		$this->messages = [];
		return $_output;
	}

	function insertRecord($table, $data, $fixed_data = FALSE, $create_log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $fixed_data ? array_merge($data, $this->fixed_data) : $data;
		$data = $create_log ? array_merge($data, $this->create_log) : $data;

		if (key_exists('id', $data)) 
			unset($data['id']);

		if ($this->identity_keys){
			$val = [];
			foreach($this->identity_keys as $k => $v){
				if (isset($data[$v])){
					$val[$v] = $data[$v];
				}
			}

			if (count($val) > 0) {
				$fk = $this->db->get_where($table, array_merge($val, ['is_active' => '1', 'is_deleted' => '0']), 1);
				// debugf($this->db->last_query());
				if ($fk->num_rows() > 0){
					// $this->set_message('error_identity_keys', __FUNCTION__, $val);
					$this->set_message('error_identity_keys');
					return false;
				}
			}
		}

		if (!$return = $this->db->insert($table, $data)) {
			$this->set_message($this->db->error()['message']);
			return false;
		} else {
			$this->set_message('success_saving');
			return true;
		}
	}
	
	function updateRecord($table, $data, $cond, $update_log = FALSE)
	{
		$data = is_object($data) ? (array) $data : $data;
		$data = $update_log ? array_merge($data, $this->update_log) : $data;
		
		$cond = is_object($cond) ? (array) $cond : $cond;

		if (isset($data['id'])) 
			unset($data['id']);
		
		if (!$return = $this->db->update($table, $data, $cond)) {
			$this->set_message($this->db->error()['message']);
			return false;
		} else {
			$this->set_message('success_update');
			return true;
		}
		
		/* $this->db->update($table, $data, $cond);
		$return = $this->db->affected_rows() == 1;
		if ($return)
			// $this->set_message('update_data_successful');
			$this->set_message('success_update');
		else
			$this->set_message('update_data_unsuccessful');
		
		return true; */
	}
	
	function deleteRecords($table, $ids, $real = FALSE)
	{
		$ids = array_filter(array_map('trim',explode(',',$ids)));
		$return = 0;
		foreach($ids as $v)
		{
			if ($real) {
				if ($this->db->delete($table, ['user_id'=>$v]))
				{
					$return += 1;
				}
			} else {
				if ($this->db->update($table, $this->delete_log, ['id'=>$v]))
				{
					$return += 1;
				}
			}
		}
		if ($return)
			$this->set_message('success_delete');
		else
			$this->set_message($this->db->error()['message']); 
			
		return $return;
	}
	
	function xresponse($status=TRUE, $response=array(), $statusHeader=200)
	{
		$BM =& load_class('Benchmark', 'core');
		
		$statusHeader = empty($statusHeader) ? 200 : $statusHeader;
		if (! is_numeric($statusHeader))
			show_error('Status codes must be numeric', 500);
		
		$elapsed = $BM->elapsed_time('total_execution_time_start', 'total_execution_time_end');

		$output['status'] = $status;
		$output['execution_time'] = $elapsed;
		$output['environment'] = ENVIRONMENT;
		
		header("HTTP/1.0 $statusHeader");
		header('Content-Type: application/json');
		echo json_encode(array_merge($output, $response));
		exit();
	}
	
	/**
	 * li
	 *
	 * Function for left menu on backend <li></li>
	 *
	 * @param	string	$cur_page   Current page
	 * @param	string	$page_chk   Page check
	 * @param	string	$url   Url
	 * @param	string	$menu_name   Menu label
	 * @param	string	$icon   bootstrap glyphicon class
	 * @param	string	$submenu   Submenu (TRUE or FALSE)
	 * @return  string
	 */
	private function li($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="active"' : '';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="fa fa-circle"></i>';
		
		$html = '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span></a></li>';
		return $html;
	}
	
	private function li_parent($cur_page, $page_chk, $url, $menu_name, $icon)
	{
		$active = ($cur_page == $page_chk) ? ' class="treeview active"' : ' class="treeview"';
		$glyp_icon = ($icon) ? '<i class="'.$icon.'"></i> ' : '<i class="glyphicon glyphicon-menu-hamburger"></i>';
		
		$html= '<li'.$active.'><a href="'.base_url().''.$url.'">'.$glyp_icon.'<span>'.$menu_name.'</span><i class="fa fa-angle-left pull-right"></i></a>';
		$html.= '<ul class="treeview-menu">';
		return $html;
	}
	
	function getParentMenu($menu_id)
	{
		$query = "select lvl0.id as lvl0_id, lvl1.id as lvl1_id, lvl2.id as lvl2_id
		from a_menu lvl0
		left join (
		 select * from a_menu 
		) lvl1 on lvl1.id = lvl0.parent_id
		left join (
		 select * from a_menu 
		) lvl2 on lvl2.id = lvl1.parent_id
		where lvl0.id = $menu_id";
		// debug($query);
		$row = $this->db->query($query);
		return ($row->num_rows() > 0) ? $row->result() : FALSE;
	}
	
	function getMenuStructure($cur_page)
	{
		/* Start Treeview Menu */
		$html = ''; $li1_closed = false; $li2_closed = false; $menu_id1 = 0; $menu_id2 = 0; $menu_id3 = 0; $parent_id = 0;
		$html.= $this->li($cur_page, 1, 'systems/x_page?pageid=1', 'Dashboard', 'fa fa-dashboard');
		$rowParentMenu = ($result = $this->getParentMenu($cur_page)) ? $result[0] : (object)['lvl1_id'=>0, 'lvl2_id'=>0];
		$rowMenus = $this->systems_model->getMenuByRoleId($this->session->role_id);
		if ($rowMenus) {
			foreach ($rowMenus as $menu){
				if (($menu_id1 != $menu->menu_id1) && $li1_closed){
					$html.= '</ul></li>';
					$li1_closed = false;
				}
				if (($menu_id2 != $menu->menu_id2) && $li2_closed){
					$html.= '</ul></li>';
					$li2_closed = false;
				}
				if (!empty($menu->menu_id2) || !empty($menu->menu_id3)){
					if ($menu_id1 != $menu->menu_id1){
						$parent_id = $rowParentMenu->lvl2_id ? $rowParentMenu->lvl2_id : $rowParentMenu->lvl1_id;
						$html.= $this->li_parent($parent_id, $menu->menu_id1, 'systems/x_page?pageid='.$menu->menu_id1, $menu->name1, $menu->icon1);
						$li1_closed = true;
						$menu_id1 = $menu->menu_id1;
					}
					if (($menu_id2 != $menu->menu_id2) && !empty($menu->menu_id3)){
						$parent_id = $rowParentMenu->lvl1_id;
						$html.= $this->li_parent($parent_id, $menu->menu_id2, 'systems/x_page?pageid='.$menu->menu_id2, $menu->name2, $menu->icon2);
						$li2_closed = true;
						$menu_id2 = $menu->menu_id2;
						
					} elseif (($menu_id2 != $menu->menu_id2) && empty($menu->menu_id3)){
						$html.= $this->li($cur_page, $menu->menu_id2, 'systems/x_page?pageid='.$menu->menu_id2, $menu->name2, $menu->icon2);
						$menu_id2 = $menu->menu_id2;
					}
					if (!empty($menu->menu_id3)){
						$html.= $this->li($cur_page, $menu->menu_id3, 'systems/x_page?pageid='.$menu->menu_id3, $menu->name3, $menu->icon3);
					}
				} elseif (!empty($menu->menu_id1)){
					$html.= $this->li($cur_page, $menu->menu_id1, 'systems/x_page?pageid='.$menu->menu_id1, $menu->name1, $menu->icon1);
				}
			}
			if ($li1_closed)
				$html.= '</ul></li>';
		}
		/* End Treeview Menu */
		
		$html.= '<br><li><a href="#" id="go-lock-screen" onclick="lock_the_screen();"><i class="fa fa-circle-o text-yellow"></i> <span>' . $this->lang->line('nav_lckscr') . '</span></a></li>';
		$html.= '<li><a href="'.LOGOUT_LNK.'" id="go-sign-out"><i class="fa fa-sign-out text-red"></i> <span>' . $this->lang->line('nav_logout') . '</span></a></li>';
		return $html;
	}
	
	function single_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$select = 'head_title, page_title, logo_text_mn, logo_text_lg';
		$system = ($result = $this->base_model->getValueArray($select, 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID])) ? $result : [];
		
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.$content, array_merge($default, $data, $system));
		exit;
	}
	
	function backend_view($content, $data=[])
	{
		$elapsed = $this->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		
		$default['content'] 	= TEMPLATE_PATH.$content.'.tpl';
		$default['menus'] 		= $this->getMenuStructure($this->pageid ? $this->pageid : 0);
		
		$default['elapsed_time']= $elapsed;
		$default['start_time'] 	= microtime(true);
		$this->fenomx->view(TEMPLATE_PATH.'index', array_merge($default, $data));
		exit;
	}
	
}