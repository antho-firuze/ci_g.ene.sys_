<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

// class Test extends Getmeb {
class Test extends CI_Controller {

	public $mdl_grp		= 'testing';

	function __construct() {
		parent::__construct();
		
		// if(check_auth_restapi() !== TRUE) 
			// return;
		// check_auth_restapi();
	}
	
	function arr_explode()
	{
		$filter['id'] = 123;
		$filter['doc_no'] = 'DOC_123';
		// echo implode(', ', $filter); 
		echo urldecode(http_build_query($filter,'',', '));
	}
	
	function get_field_type()
	{
		$fields = $this->db->field_data('cf_ar_ap');
		// $date_field = [];
		foreach ($fields as $field)
		{
			// var_dump($field);
			if ($field->type == 'date')
				$date_fields[] = $field->name;
			// echo $field->name;
			// echo $field->type;
			// echo $field->max_length;
			// echo $field->primary_key;
		}	
		if (isset($date_fields)){
			// echo "ada";
			foreach($date_fields as $f){
				echo $f;echo "<br>";
			}
		} else
			echo "tada";
		// var_dump($date_field);
	}
	
	function upload_file()
	{
		/* get the params & files (special for upload file) */
		$files = $_FILES;
		
		@ini_set( 'upload_max_size' , "2mb" );
		@ini_set( 'post_max_size', "2mb" );
		@ini_set( 'max_execution_time', '300' );
		
		// if ($this->r_method == 'POST') {
			if (isset($files['file']['name']) && $files['file']['name']) {
				/* Load the library */
				require_once APPPATH."/third_party/Plupload/PluploadHandler.php"; 
				$ph = new PluploadHandler(array(
					'target_dir' => FCPATH.'var/tmp/',
					'allow_extensions' => 'jpg,jpeg,png,gif,xls,xlsx,csv,doc,docx,ppt,pptx,pdf,zip,rar',
					'debug' => true,
				));
				$ph->sendNoCacheHeaders();
				$ph->sendCORSHeaders();
				/* And Do Upload */
				if (!$result = $ph->handleUpload()) {
					debug($ph->getErrorMessage());
					return FALSE;
				}
				/* Result Output in array : array('name', 'path', 'chunk', 'size') */
				var_dump($result);
				exit();
			}
		// }
	}
	
	
	
	function drop_table_tmp()
	{
		$qry = $this->db->get_where('a_tmp_tables', ['time <' => time()-60]);
		if ($qry->num_rows() > 0){
			$this->load->dbforge();
			foreach($qry->result() as $k => $v){
				$this->dbforge->drop_table($v->name,TRUE);
			}
			$this->db->where('time <', time()-60, FALSE);
			$this->db->delete('a_tmp_tables');
			debug('oke');
		}
		echo "drop";
	}
	
	function HTTP_Params()
	{
		// $this->load->view('flotr2');
		$this->fenomx->view('test/params');
	}
	
	function prnf(){
		// $args = NULL;
		// $args = '';
		// $args = [];
		$args = ['test'];
		// $args = 'test';
		if (!empty($args)){
			$args = is_array($args) ? implode(', ', $args) : $args;
			$msg = sprintf('[%s]', $args);
			echo $msg;
		}
	}
	
	function reorder_menu()
	{
		$strq = "select t1.* 
			from(select id as grp, * from a_menu where is_parent = '1' union all select parent_id as grp, * from a_menu where is_parent = '0') as t1
			where is_deleted = '0' and type != 'P' order by grp, is_parent desc, is_submodule, line_no";
		$fetch = $this->db->query($strq);
		$grp = ''; $line = 1; $lineh = 1;
		foreach($fetch->result() as $k => $v){
			if ($v->is_parent == 1){
				$grp = $v->grp;
				$line = 1;
				// $this->db->update('a_menu', ['line_no' => $lineh], ['id' => $v->id]);
				echo 'grp-id-line-newline: '.$v->grp.'-'.$v->id.'-'.$v->line_no.'-'.$lineh."<br>";
				$lineh++;
				continue;
			}
			// $this->db->update('a_menu', ['line_no' => $line], ['id' => $v->id]);
			echo 'grp-id-line-newline: '.$v->grp.'-'.$v->id.'-'.$v->line_no.'-'.$line."<br>";
			$line++;
		}
	}
	
	function tim()
	{
		// echo time();
		$this->load->config('z_auth/auth', TRUE);
		echo $this->config->item('forgot_password_expiration', 'auth');
	}
	
	function datetime()
	{
		// $datetime = '03/23/2017';
		// $this_format = 'mm/dd/yyyy';
		$is_datetime = TRUE;
		// $datetime = '22/03/2017';
		// $this_format = 'dd/mm/yyyy';
		$datetime = '22/03/2017 06:17';
		$this_format = 'dd/mm/yyyy hh:mm';
		if (! in_array($this_format, ['dd/mm/yyyy', 'mm/dd/yyyy', 'dd-mm-yyyy', 'mm-dd-yyyy', 'dd/mm/yyyy hh:mm', 'mm/dd/yyyy hh:mm', 'dd-mm-yyyy hh:mm', 'mm-dd-yyyy hh:mm']))
			return FALSE;
		
		/* seperate between date & time */
		$dt = [];
		$dt_format = [];
		$dt = explode(' ', $datetime);
		$dt_format = explode(' ', $this_format);

		$date = (count($dt) > 1) ? $dt[0] : $dt[0];
		$time = (count($dt) > 1) ? $dt[1].':00' : FALSE;
		$date_format = (count($dt_format) > 1) ? $dt_format[0] : $dt_format[0];
		$time_format = (count($dt_format) > 1) ? $dt_format[1] : FALSE;
		
		/* time */
		$time_result = ($time !== FALSE) ? $time : '00:00:00';
		
		/* date */
		if (strpos($date_format, '/') !== false) {
			list($f[0], $f[1], $f[2]) = explode('/', $date_format);
			list($d[0], $d[1], $d[2]) = explode('/', $date);
		} else {
			list($f[0], $f[1], $f[2]) = explode('-', $date_format);
			list($d[0], $d[1], $d[2]) = explode('-', $date);
		}
		$date_result = implode('-',[$d[array_search("yyyy",$f)], $d[array_search("mm",$f)], $d[array_search("dd",$f)]]);
		echo $is_datetime ? implode(' ', [$date_result, $time_result]) : $date_result;
	}
	
	function get_shorten()
	{
		$params = $this->input->get();
		// debug($params);
		// echo base64_encode(1000);
		$this->load->helper('string');
		$rndstr = random_string('alnum', 5);
		xresponse(TRUE, ['base_url' => $params['url'], 'short_url' => 'http://jeil.bz/'.$rndstr]);
		// echo random_string('md5', 5);
		// echo random_string('sha1', 5);
	}
	
	function getSystem()
	{
		
		echo ($result = $this->base_model->getValue('*', 'a_system', ['client_id', 'org_id'], [DEFAULT_CLIENT_ID, DEFAULT_ORG_ID]))
		? $result->head_title
		: 'FALSE';
	}
	
	function sess()
	{
		$sess = (object) $this->session->userdata();
		echo $sess->user_id;
	}
	
	function shollu_cg() 
	{
		$this->fenomx->view('test/shollu_cg');
	}
	
	function shollu_cb() 
	{
		$this->fenomx->view('test/shollu_cb');
	}
	
	function avatar($word)
	{
		$set = [
			'word'		=> $word, 
			'img_path'	=> 'upload/images/users/',
			'img_url'	=> base_url().'upload/images/users/', 
		];
		// echo var_dump($set);
		$img = create_avatar_img($set);
		echo $img['image'];
		return;
		// header('Content-Type: image/jpeg');
		// $im = @imagecreatefrompng(base_url().'upload/images/users/'.$img['filename']);
		// imagepng($im);
		// imagedestroy($im); 
	}
	
	function param()
	{
		$params = ['id' => 1, 'name' => 'auaaaaaahhh'];
		$params = [];
		$params = is_array($params) ? $params : (array)$params;
		// $params = (count($params) < 1) ? '' : '?'.http_build_query($params);
		// echo (count($params) > 1) ? 'ada' : 'kosong';
		echo count($params);
		// echo $params;
	}
	
	function arr_loop()
	{
		$name = ['name' => 'namaku', 'value' => 123];
		if (is_array($name))
		{
			// always leave 'name' in last place, as the loop will break otherwise, due to $$item
			foreach (array('value', 'expire', 'domain', 'path', 'prefix', 'secure', 'httponly', 'name') as $item)
			{
				if (isset($name[$item]))
				{
					$$item = $name[$item];
				}
			}
		}
		return out($$item);
	}
	
	function salt()
	{
		echo salt();
	}
	
	function url()
	{
		$params = (count($params = $this->input->get()) < 1) ? '' : '?'.http_build_query($params);
		echo current_url().$params;
		// echo uri_string();
		// echo url_title(current_url());
		// echo base_url();
		// echo site_url();
	}
	
	function decrypt()
	{
		$this->load->library('encryption');
		// $this->encryption->initialize(['cipher' => 'aes-256', 'mode' => 'ctr']);		
		
		// return out(json_decode($this->encryption->decrypt("f8dd2e3058fb3ffbd0abf133527f231f58397476aca60f78c904a746b764eb6eafdbe165239bc47b3a36d73341fef73de050a431aa91228775735f1fdfdd79342/TPObEp/BQ/MYCiTUwMncH8dB24mpElV8F8V8cb7isngWWqKixYX2ltsKW93tOM7ai6jy9a3bqXaAu1ceYtmhjYffhgAzbtQdZvk5rtdV1SLKsS10yxl1lcWRQc0DLQLyhwTtVdBRuNdLL+zsHcdwCLRPdBdcha9xfL62jCdyetg8uus8yW98OonIePkucj")));
		return out(json_decode(urlsafeB64Decode("eyJ1c2VyX2lkIjoiMTEiLCJjbGllbnRfaWQiOiIxMSIsIm9yZ19pZCI6IjExIiwicm9sZV9pZCI6IjExIiwicGhvdG9fbGluayI6Imh0dHA6XC9cL2xvcmVtcGl4ZWwuY29tXC8xNjBcLzE2MFwvcGVvcGxlXC8ifQ")));
	}
	
	function index() {
		echo 'running test';
	}
	
	function tis()
	{
		$a = 1;
		$b = 0;
		$c = 3;
		$a || $a = $c;	// If $a = true, then right not execute
		$b || $b = $c;	// if $a = false, then right is execute

		return out($a .' - '. $b);
	}
	
	function gen_join()
	{
		$params['join'][] 	= ['a_user_config as auc', 'au.id = auc.user_id'];
		DBX::join($this, $params['join']);
	}
	
	function gen_like()
	{
		$field = 'u.username';
		$q = 'coba aja';

		// $params['like']['u.username'] = $q;
		// $params['like']['u.first_name'] = $q;
		// $params['like']['u.last_name'] = $q;
		// return out($params['like']);
		
		foreach (explode(',', $field) as $v)
		{
			$like[$v] = $q;
		}
		return out($like);
	}
	
	function outpit(){
		$obj = new stdClass();
		$obj->a = "1";
		$obj->b = "2";
		
		$arr = array();
		$arr['a'] = 1;
		$arr['b'] = 2;
		
		$txt = "coba coba";
		return out($arr);
	}
	
	function restopi(){
		// 1. cek auth
		// 2. method
		header('WWW-Authenticate: Basic realm="REST APO"');
		exit();
		
		// if(check_auth_restapi() !== TRUE) 
			// return;
			
		// if(check_method_post_restapi() !== TRUE) 
			// return;
			
			
		// echo file_get_contents('php://input');
		// $params = json_decode(file_get_contents('php://input'), TRUE);
		// var_dump($params);
		
		// $params = json_decode(file_get_contents('php://input'), TRUE);
		// $username = $params['username'];
		// $password = $params['password'];
		
		// $response = $this->MyModel->login($username,$password);
		// json_output($response['status'],$response);
	}
	
	function get_issue_to_dept(){
		$this->load->helper('ticketing/ticketing_function');
		echo empty(get_issue_to_dept(9)) ? 'empty' : get_issue_to_dept(9);
	}
	
	function test_array() {
		$arr = array();
		$arr[] = "satu";
		// $arr[] = "dua";
		// $arr[] = "tiga";
		// var_dump($arr);
		$message = "";
		for ($i=0; $i < count($arr); $i++) {
			if ($i==(count($arr)-1))
				$message .= (count($arr)>1?" and ":"").$arr[$i];
			elseif ($i==(count($arr)-2))
				$message .= $arr[$i];
			else
				$message .= $arr[$i].", ";
		}
		echo $message;
		/* foreach ($arr as $ar){
			if 
			echo $ar.",";
		} */
	}
	
	function test_explode() {
		$data['ids'] = "123, 456, 789";
		foreach (explode( ',', $data['ids'] ) as $id) {
			echo $id ."\n";
		}
	}
	
	function settimer() {
		while (true) {
			echo date('Y-m-d H:i:s');
			sleep(2);
		}
	}
	
	function tree_combo() {
		$this->load->model('shared/shared_model');
		
		$params['table'] = "opt_ticket_cat";
		$params['where']['company_id'] = 1;
		$result = $this->shared_model->get_rec_tree_combo($params);
		echo json_encode($result);
	}
	
	function test_object() {
		$items = new stdClass();
		
		$arr = array("1"=>"a", "2"=>"b", "3"=>"c");
		// $obj = object $arr;
		// $obj = ["a", "b", "c", "d"];
		foreach ($arr as $k => $v){
			// echo $k." -> ".$v;
			// echo $k[2];
			// echo $k["2"];
			$items->$k = $v;
			// $items->state = $k;
		}
		// echo $items->a;
		var_dump($items);
	}
	
	function set_comet() {
		set_comet("sys_reload", 'ayo pada reload semua yah....');
	}
	
	function ext_time() {
		// echo strtotime("2015-03-10");
		// echo strtotime("2015-03-10 9:43");
		echo time_between_string("2015-03-10 9:00", "2015-03-10 9:40");
	}
	
	function extract_date() {
		// echo date("m", strtotime("2013-1-07"));
		// echo substr(date("Y", strtotime("2013-1-07")), -2);
		// echo date("Y", strtotime("2013-02-02"));
		// echo db_date_format("02/12/2015 15:30");
		echo db_date_format("02/12/2015")." ".date('H:i:s');
		echo "<br>";
		echo date('Y-m-d H:i:s');
	}
	
	function php_info() {
		echo phpinfo();
	}
	
	function apc() {
		$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

		if ( ! $foo = $this->cache->get('foo'))
		{
			 echo 'Saving to the cache!<br />';
			 $foo = 'foobarbaz!';

			 // Save into the cache for 5 minutes
			 $this->cache->save('foo', $foo, 300);
		}

		echo $foo;


		// if ($this->cache->apc->is_supported())
		// {
			// echo 'this supported.';
		// } else
		// {
			// echo 'not supported.';
		// }
	}

	function test_comet() {
		// First we load the SimpleComet PHP class and the list of excuses.
		$this->load->library('Comet');
		$comet = new SimpleComet();
		$excuses = file('assets/jquery-simplecomet/excuses.txt');
		 
		// This is an infinite loop, which makes the stream endless.
		while (true) {
			// We fetch an excuse at random.
			// $excuse = trim($excuses[rand(0, count($excuses))]);
			$excuse = trim($excuses[rand(0, 20)]);
			// If the excuse is too long, we get another one.
			if (strlen($excuse) > 60) { continue; }
			// Finally, we push our excuse to the client.
			$comet->push($excuse);
			// 5 seconds delay before the next excuse.
			sleep(3);
		}
	}
	
	function test_two_dim_array1() {
		$shop = array( array("rose", 1.25 , 15),
               array("daisy", 0.75 , 25),
               array("orchid", 1.15 , 7) 
             ); 

		echo "<h1>Manual access to each element</h1>";

		echo $shop[0][0]." costs ".$shop[0][1]." and you get ".$shop[0][2]."<br />";
		echo $shop[1][0]." costs ".$shop[1][1]." and you get ".$shop[1][2]."<br />";
		echo $shop[2][0]." costs ".$shop[2][1]." and you get ".$shop[2][2]."<br />";

		echo "<h1>Using loops to display array elements</h1>";

		echo "<ol>";
		for ($row = 0; $row < 3; $row++)
		{
			echo "<li><b>The row number $row</b>";
			echo "<ul>";

			for ($col = 0; $col < 3; $col++)
			{
				echo "<li>".$shop[$row][$col]."</li>";
			}

			echo "</ul>";
			echo "</li>";
		}
		echo "</ol>";
		
		// echo '<pre>';
		// print_r ($shop);
		// echo '</pre>';
	}
	
	function test_two_dim_array2() {
		$shop = array( array( "Title" => "rose", 
                      "Price" => 1.25,
                      "Number" => 15 
                    ),
               array( "Title" => "daisy", 
                      "Price" => 0.75,
                      "Number" => 25,
                    ),
               array( "Title" => "orchid", 
                      "Price" => 1.15,
                      "Number" => 7 
                    )
             );
		echo "<h1>Manual access to each element from associative array</h1>";

		for ($row = 0; $row < 3; $row++)
		{
			echo $shop[$row]["Title"]." costs ".$shop[$row]["Price"]." and you get ".$shop[$row]["Number"];
			echo "<br />";
		}

		echo "<h1>Using foreach loop to display elements</h1>";

		echo "<ol>";
		for ($row = 0; $row < 3; $row++)
		{
			echo "<li><b>The row number $row</b>";
			echo "<ul>";

			foreach($shop[$row] as $key => $value)
			{
				echo "<li>".$value."</li>";
			}

			echo "</ul>";
			echo "</li>";
		}
		echo "</ol>";
		
		// echo '<pre>';
		// print_r ($shop);
		// echo '</pre>';
	}
	
	function test_three_dim_array() {
		$shop = array(array(array("rose", 1.25, 15),
                    array("daisy", 0.75, 25),
                    array("orchid", 1.15, 7) 
                   ),
              array(array("rose", 1.25, 15),
                    array("daisy", 0.75, 25),
                    array("orchid", 1.15, 7) 
                   ),
              array(array("rose", 1.25, 15),
                    array("daisy", 0.75, 25),
                    array("orchid", 1.15, 7) 
                   )
             );
		echo "<ul>";
		for ( $layer = 0; $layer < 3; $layer++ )
		{
			echo "<li>The layer number $layer";
			echo "<ul>";
		   
			for ( $row = 0; $row < 3; $row++ ) 
			{
			   echo "<li>The row number $row";
			   echo "<ul>";
			 
				for ( $col = 0; $col < 3; $col++ )
				{
					echo "<li>".$shop[$layer][$row][$col]."</li>";
				} 
				echo "</ul>";
				echo "</li>";
			}
			echo "</ul>";
			echo "</li>";
		}   
		echo "</ul>";
		
		// echo '<pre>';
		// print_r ($shop);
		// echo '</pre>';
	}
	
	function get_memcached_is_working() {
		$check_memcache = @memcache_connect('127.0.0.1',11211);
		if( $check_memcache === FALSE ){
		    // memcached is _probably_ not running
			echo "MEMCACHED IS PROBABLY NOT RUNNING (MEMCACHED = FALSE).";
		} else
			echo "TRUE";
	}
	
	function benchmark_test() {
		// $this->benchmark->mark('one');
		// $this->db->select('*')->from('big_data')->order_by('id', 'asc');
		// $num_row1 = $this->db->get()->num_rows();
		// $this->benchmark->mark('two');
		
		// $this->benchmark->mark('three');
		// $this->db->flush_cache();
		// $this->db->select('COUNT(*) AS rec_count', FALSE)->from('big_data');
		// $num_row2 = $this->db->get()->row()->rec_count;
		// $this->benchmark->mark('four');
	
		// $this->benchmark->mark('five');
		// $this->db->flush_cache();
		// $num_row3 = $this->db->query("select count(*) as rec_count from big_data")->row()->rec_count;
		// $this->benchmark->mark('six');
	
		// $this->benchmark->mark('seven');
		// $num_row4 = $this->cache->memcached->get('num_row4');
		// if ( !$num_row4 ) {
			// $this->db->flush_cache();
			// $this->db->select('COUNT(*) AS rec_count', FALSE)->from('big_data');
			// $num_row4 = $this->db->get()->row()->rec_count;
			// $this->cache->memcached->save('num_row4', $num_row4, 60);
		// }
		// $this->benchmark->mark('eight');

		// $this->benchmark->mark('nine');
		// $this->db->flush_cache();
		// $num_row5 = $this->db->get('big_data')->num_rows;
		// $this->benchmark->mark('ten');

		// echo "PROCESS #1 : ".$this->benchmark->elapsed_time('one', 'two')."<br />";
		// echo "REC. COUNT #1 : $num_row1"."<br />";
		// echo "PROCESS #2 : ".$this->benchmark->elapsed_time('three', 'four')."<br />";
		// echo "REC. COUNT #2 : $num_row2"."<br />";
		// echo "PROCESS #3 : ".$this->benchmark->elapsed_time('five', 'six')."<br />";
		// echo "REC. COUNT #3 : $num_row3"."<br />";
		// echo "PROCESS #4 : ".$this->benchmark->elapsed_time('seven', 'eight')."<br />";
		// echo "REC. COUNT #4 : $num_row4"."<br />";
		// echo "PROCESS #5 : ".$this->benchmark->elapsed_time('nine', 'ten')."<br />";
		// echo "REC. COUNT #5 : $num_row5"."<br />";
	}
	
	function get_doc_no() {
		//
		// echo get_doc_code(2, 1, 1, 'PHD');
		echo get_doc_code2(1, 0, 0, "2013-02-02", "TKT", "FBI", "IT");
	}

	function flotr2() {
		$this->load->view('flotr2');
	}
	
	function str() {
		echo substr("2015", -2);
	}
	
	function terbilang() {
		// if (strpos(168.3, '.') !== false) 
			// echo 1;
		// else 
			// echo 2;
		echo terbilang_ina2(168.456);
	}
	
	function cek_weekday() {
		$d=0;$m=0;$y=0;$h=0;$i=0;$s=0;
		$d=4;
		echo set_datetime_weekday('2015-05-29', $d,$m,$y,$h,$i,$s)."\n";
		// echo date("N", strtotime(set_datetime('2015-05-29 05:03', $d,$m,$y,$h,$i,$s)));
		// echo "2015-05-23"."\n".date("N", strtotime('2015-05-23'));
		// date("w", strtotime("wednesday"));
		
	}
	
	function mdetect() {
		$detect = new Mobile_Detect();
		// return log_array($detect);
		
		if ( $detect->isTablet() || $detect->isMobile() )
			$sess['is_mobile'] = 1;
		else
			$sess['is_mobile'] = 0;
			
		return log_json($sess);
	}

	function mpdf() {
		$mpdf = new mPDF( 'utf-8', array(215.9,330.2),'','',15,15,40,16,10,10 ); //FORMAT F4 (FOLIO)
		$mpdf->SetWatermarkText('VOID');
		$mpdf->showWatermarkText = true;
		$mpdf->WriteHTML("ini testing saja !");
		$mpdf->Output();
	}
	
	function phpexcel() {
		error_reporting(E_ALL);
	
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPHPExcel->setActiveSheetIndex(0);
		
		// Set properties
		$objPHPExcel->getProperties()->setCreator("Maarten Balliauw");
		$objPHPExcel->getProperties()->setLastModifiedBy("Maarten Balliauw");
		$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
		$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");


		// Add some data
		$objPHPExcel->setActiveSheetIndex(0);
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Hello');
		$objPHPExcel->getActiveSheet()->SetCellValue('B2', 'world!');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Hello');
		$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'world!');

		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');
		
		// Sending headers to force the user to download the file
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment;filename='sample.xls'");
		header("Cache-Control: max-age=0");
		
		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter->save('php://output');
	}
	
}