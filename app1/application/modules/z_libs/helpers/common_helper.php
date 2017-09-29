<?php defined('BASEPATH') OR exit('No direct script access allowed');

include 'datetime_helper.php';
include 'email_helper.php';
include 'sequence_helper.php';
include 'spelled_out_helper.php';

if ( ! function_exists('get_dsn_host'))
{
	function get_dsn_host()
	{
		return parse_dsn(DB_DSN)['pgsql:host'];
	}
}

if ( ! function_exists('parse_dsn'))
{
	function parse_dsn($dsn)
	{
		foreach(explode(';', $dsn) as $val){ list($k, $v) = explode('=', $val); $con[$k] = $v; }
		return $con;
	}
}

if ( ! function_exists('get_orgtrx'))
{
	function get_orgtrx()
	{
		$ci = &get_instance();
		$str = "select f1.org_id 
			from a_user_orgtrx f1 
			inner join a_user_org f2 on f1.user_org_id = f2.id
			where f1.is_active = '1' and f1.is_deleted = '0' and 
			f1.user_id = ".$ci->session->user_id." and f2.org_id = ".$ci->session->org_id;
		if (!$qry = $ci->db->query($str)->result()){
			return FALSE;
		}
		$arr = [];
		foreach ($qry as $k => $v){
			$arr[] = $v->org_id;
		}
		return $arr;
	}
}

if ( ! function_exists('translate_variable'))
{
	function translate_variable($str)
	{
		$ci = &get_instance();
		$vars = array(
			'{client_id}'	=> $ci->session->client_id,
			'{org_id}'		=> $ci->session->org_id,
			'{orgtrx_id}'		=> $ci->session->orgtrx_id,
			'{orgtrx}'		=> '('.implode(',', get_orgtrx()).')',
			'{role_id}'		=> $ci->session->role_id,
		);
		
		return str_replace(array_keys($vars), $vars, $str);
	}
}

if ( ! function_exists('lang'))
{
	function lang($str, $args = null, $module = '', $langfile = '', $idiom = 'english')
	{
		$ci = &get_instance();
		
		$deft_module = CI::$APP->router->fetch_module();
		$_module = ($module == '') ? $deft_module : $module;
		
		// $langfile = ($langfile == '') ? $_module : $langfile;
		$langfile OR $langfile = $_module;
		
		list($path, $_langfile) = Modules::find($langfile.'_lang', $_module, 'language/'.$idiom.'/');
		// list($path, $_langfile) = Modules::find($expected.'_lang', $expected, 'language/'.$language.'/');
		if ($path) {
			// CI::$APP->lang->load($langfile, $idiom, $return, $add_suffix, $alt_path, $this->_module);
			CI::$APP->lang->load($langfile, $idiom, FALSE, TRUE, '', $_module);
		} 
		
		$msg = $ci->lang->line($str);
		if (is_array($args) && $args)
			$msg = vsprintf($msg, $args);
		return $msg;
	}
}

if ( ! function_exists('run_shell'))
{
	function run_shell($cmd)
	{
		$WshShell = new COM("WScript.Shell"); 
		$oExec = $WshShell->Run($cmd, 0, false); 
		return $oExec == 0 ? true : false; 		
		// $pid 	=  $WshShell->Exec($cmd);
		// return $pid;
	}
}

if ( ! function_exists('get_ip_address'))
{
	function get_ip_address()
	{
		$ipaddress = '';
    // if ($_SERVER['HTTP_CLIENT_IP'])
			// $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    // if($_SERVER['HTTP_X_FORWARDED_FOR'])
			// $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    // if($_SERVER['HTTP_X_FORWARDED'])
			// $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    // else if($_SERVER['HTTP_FORWARDED_FOR'])
			// $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    // else if($_SERVER['HTTP_FORWARDED'])
			// $ipaddress = $_SERVER['HTTP_FORWARDED'];
    // if($_SERVER['REMOTE_ADDR'])
			// $ipaddress = $_SERVER['REMOTE_ADDR'];
    // else
			// $ipaddress = 'UNKNOWN';
		
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
    else
			$ipaddress = 'UNKNOWN';
 
    return $ipaddress;
	}
}

/**
* Check if a client IP is in our Server subnet
*
* @param string $client_ip
* @param string $server_ip
* @return boolean
*/
if ( ! function_exists('is_private_ip'))
{
	function is_private_ip($ip) {
    return !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}
}

if ( ! function_exists('getPHPExecutableFromPath'))
{
	function getPHPExecutableFromPath() {
		$paths = explode(PATH_SEPARATOR, getenv('PATH'));
		foreach ($paths as $path) {
			// we need this for XAMPP (Windows)
			if (strstr($path, 'php.exe') && isset($_SERVER["WINDIR"]) && file_exists($path) && is_file($path)) {
				return $path;
			}
			else {
				$php_executable = $path . DIRECTORY_SEPARATOR . "php" . (isset($_SERVER["WINDIR"]) ? ".exe" : "");
				if (file_exists($php_executable) && is_file($php_executable)) {
					return $php_executable;
				}
			}
		}
		return FALSE; // not found
	}
}

if ( ! function_exists('UUIDv4'))
{
	function UUIDv4() 
	{
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		// 32 bits for "time_low"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff),
		// 16 bits for "time_mid"
		mt_rand(0, 0xffff),
		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		mt_rand(0, 0x0fff) | 0x4000,
		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		mt_rand(0, 0x3fff) | 0x8000,
		// 48 bits for "node"
		mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}
}

if ( ! function_exists('create_avatar_img'))
{
	function create_avatar_img($data = '', $img_path = '', $img_url = '', $font_path = '')
	{
		$defaults = array(
			'word'		=> '',
			'img_path'	=> '',
			'img_url'	=> '',
			'img_width'	=> '215',
			'img_height'	=> '215',
			'img_type'	=> 'png',
			'font_path'	=> BASEPATH.'fonts/texb.ttf',
			'word_length'	=> 1,
			'font_size'	=> 100,
			'img_id'	=> '',
		);
		
		foreach ($defaults as $key => $val)
		{
			if ( ! is_array($data) && empty($$key))
			{
				$$key = $val;
			}
			else
			{
				$$key = isset($data[$key]) ? $data[$key] : $val;
			}
		}
		
		if ($img_path === '' OR $img_url === ''
			OR ! is_dir($img_path) OR ! is_really_writable($img_path)
			OR ! extension_loaded('gd'))
		{
			return FALSE;
		}
		
		$im = function_exists('imagecreatetruecolor')
			? imagecreatetruecolor($img_width, $img_height)
			: imagecreate($img_width, $img_height);
		
		$i = strtoupper(substr($word, 0, 1));
		$r = rand(0, 255);
		$g = rand(0, 255);
		$b = rand(0, 255);
		$x = (imagesx($im) - $font_size * strlen($i)) / 2;
		$y = (imagesy($im) + ($font_size-($font_size*0.25))) / 2;
		$bg = imagecolorallocate($im, $r, $g, $b);
		$tc = imagecolorallocate($im, 255, 255, 255);
		
		// Create the rectangle
		ImageFilledRectangle($im, 0, 0, $img_width, $img_height, $bg);
		
		$use_font = ($font_path !== '' && file_exists($font_path) && function_exists('imagettftext'));
		if ($use_font === FALSE)
		{
			($font_size > 5) && $font_size = 5;
			imagestring($im, $font_size, $x, $y, $i, $tc);
		}
		else
		{
			// ($font_size > 30) && $font_size = 30;
			imagettftext($im, $font_size, 0, $x, $y, $tc, $font_path, $i);
		}

		// -----------------------------------
		//  Generate the image
		// -----------------------------------
		$now = microtime(TRUE);
		$img_url = rtrim($img_url, '/').'/';

		if ($img_type == 'jpeg')
		{
			$img_filename = $now.'.jpg';
			imagejpeg($im, $img_path.$img_filename);
		}
		elseif ($img_type == 'png')
		{
			$img_filename = $now.'.png';
			imagepng($im, $img_path.$img_filename);
		}
		else
		{
			return FALSE;
		}

		$img = '<img '.($img_id === '' ? '' : 'id="'.$img_id.'"').' src="'.$img_url.$img_filename.'" style="width: '.$img_width.'; height: '.$img_height .'; border: 0;" alt=" " />';
		ImageDestroy($im);

		return array(
			'image' 	=> $img, 
			'file_path' => $img_path.$img_filename, 
			'file_url'	=> $img_url.$img_filename,
			'filename' 	=> $img_filename
		);
	}
}
	
if ( ! function_exists('xresponse'))
{
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
}
	
if ( ! function_exists('salt'))
{
	/**
	 * Generates a random salt value.
	 *
	 * Salt generation code taken from https://github.com/ircmaxell/password_compat/blob/master/lib/password.php
	 *
	 * @return void
	 * @author Anthony Ferrera
	 **/
	function salt($salt_length=22)
	{

		$raw_salt_len = 16;

 		$buffer = '';
        $buffer_valid = false;

        if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
            $buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
            $buffer = openssl_random_pseudo_bytes($raw_salt_len);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && @is_readable('/dev/urandom')) {
            $f = fopen('/dev/urandom', 'r');
            $read = strlen($buffer);
            while ($read < $raw_salt_len) {
                $buffer .= fread($f, $raw_salt_len - $read);
                $read = strlen($buffer);
            }
            fclose($f);
            if ($read >= $raw_salt_len) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid || strlen($buffer) < $raw_salt_len) {
            $bl = strlen($buffer);
            for ($i = 0; $i < $raw_salt_len; $i++) {
                if ($i < $bl) {
                    $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                } else {
                    $buffer .= chr(mt_rand(0, 255));
                }
            }
        }

        $salt = $buffer;

        // encode string with the Base64 variant used by crypt
        $base64_digits   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $base64_string   = base64_encode($salt);
        $salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);

	    $salt = substr($salt, 0, $salt_length);


		return $salt;

	}
}

if ( ! function_exists('urlsafeB64Encode'))
{
	function urlsafeB64Encode($input)
	{
		return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
	}
}

if ( ! function_exists('urlsafeB64Decode'))
{
	function urlsafeB64Decode($input)
	{
		$remainder = strlen($input) % 4;
		if ($remainder) {
			$padlen = 4 - $remainder;
			$input .= str_repeat('=', $padlen);
		}
		return base64_decode(strtr($input, '-_', '+/'));
	}
}

if ( ! function_exists('get_api_sig'))
{
    function get_api_sig(){
		$secretKey = "BismILLAHirrohmaanirrohiim";

		// Generates a random string of ten digits
		$salt = mt_rand();

		// Computes the signature by hashing the salt with the secret key as the key
		$signature = hash_hmac('sha256', $salt, $secretKey, true);

		// base64 encode...
		$encodedSignature = base64_encode($signature);

		// urlencode...
		$encodedSignature = urlencode($encodedSignature);

		return $encodedSignature;
    }
}

// NOTIFICATION
if ( ! function_exists('set_email_notif'))
{
    function set_email_notif($params = array())
    {
		$ci = get_instance();
		
		if ( !is_array($params) )
			return FALSE;
			
		$data['email']	 = $params['email'];
		$data['subject'] = $params['subject'];
		$data['message'] = $params['message'];
		$data['status']  = 'created';
		$data['created'] = date('Y-m-d H:i:s');
		
		$ci->db->insert('notification_email', $data);
        return TRUE;
	}
}

// FILE SIZE
if ( ! function_exists('formatSizeUnits'))
{
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
	}
}

// TRUNCATE FILE NAME
if ( ! function_exists('truncateFilename'))
{
	function truncateFilename($filename, $max = 30) {
		if (strlen($filename) <= $max) {
			return $filename;
		}
		if ($max <= 3) {
			return '...';
		}
		if (!preg_match('/^(.+?)(\.[^\.]+)?$/', $filename, $match)) {
			// has newlines or is an empty string
			return $filename;
		}
		list (, $name, $ext) = $match;
		$extLen = strlen($ext);
		$nameMax = $max - ($extLen == 0 ? 3 : $extLen + 2); // 2 for two dots of the elipses
		if ($nameMax <= 1) {
			$truncated = substr($filename, 0, $max - 3) . '...';
		}
		else {
			$truncated = substr($name, 0, $nameMax) . '...' . substr($ext, 1);
		}
		return $truncated;
	}
}

// EXPORT TO PDF ===============
if ( ! function_exists('export_to_pdf'))
{
	function export_to_pdf($qry, $filename, $paper_size='A4', $is_portrait=TRUE) {
		$ci = get_instance();
		
		$company	= $ci->systems_model->getCompany_ById(sesCompany()->id);
		
		$ci->load->library('mpdf');
		//=====================================================================================================\\
		
		if ($paper_size == 'F4') 
			if ($is_portrait)
				$paper_setup = array(215.9,330.2);
			else
				$paper_setup = array(330.2,215.9);
		
		if ($paper_size == 'A3') 
			if ($is_portrait)
				$paper_setup = array(297,420);
			else
				$paper_setup = array(420,297);
		
		$mpdf = new mPDF( 'utf-8', $paper_setup,'','',15,15,35,16,10,10 ); 
		$mpdf->SetTitle("Example");
		$mpdf->SetAuthor("Example");
		$logo_path = base_url()."assets/images/logo-$company->code.png";
		
		$title = join(" ", explode("_", strtoupper($filename)));
		$html_head = "<html><head>
		<style>
		.logo 	{ float: left; margin-top: -80px; width: 100px; height: 100px; }
		body  	{ font-family: Courier; font-size: 10pt; }
		td 		{ vertical-align: top; }
		.top-border 	{ border-top: 0.1mm solid #000000; }
		.bottom-border 	{ border-bottom: 0.1mm solid #000000; }
		.left-border 	{ border-left: 0.1mm solid #000000; }
		.right-border 	{ border-right: 0.1mm solid #000000; }
		table thead td { 
			text-align: center;
			border: 0.1mm solid #000000;
			border-collapse: collapse;
		}
		.items td {
			border-left: 0.1mm solid #000000;
			border-right: 0.1mm solid #000000;
		}
		.items td.blanktotal {
			background-color: #FFFFFF;
			border: 0mm none #000000;
			border-top: 0.1mm solid #000000;
			/* border-right: 0.1mm solid #000000; */
		}		
		.items td.totals {
			text-align: right;
			border: 0.1mm solid #000000;
		}
		</style>
		</head>
		<body>
		
		<!--mpdf
		<htmlpageheader name='myheader'>
			<div class='logo'><img src='$logo_path' width='100' /></div>
			<table width='100%'>
				<tr><td><center><h1>$company->name</h1></center></td></tr>
				<tr><td><center>|||</center></td></tr>
				<tr><td><center><h3>$title</h3></center></td></tr>
			</table>
		</htmlpageheader>

		<sethtmlpageheader name='myheader' value='on' show-this-page='1' />
		mpdf-->";
		$mpdf->WriteHTML($html_head);
		$mpdf->SetFooter("|Page {PAGENO} of {nb}|Printed @ ". date('d M Y H:i'));
		
		$header = "
		<table class='items' width='100%' style='margin-top: 1.25em; border-collapse: collapse;' cellpadding='8'>
		<thead>
			<tr>
				<td><strong>NO.</strong></td>";
			
		$fields = $qry->list_fields();
		$fields_count = count($fields);
		foreach ($fields as $field) {
			$header .= "<td><strong>$field</strong></td>";
		}
				
		$header .= "</tr>
		</thead>
		<tbody>";
		$mpdf->WriteHTML($header);

		if ($qry->num_rows() < 1) 
			crud_error( l('report_no_data') );
		
		$num = 1;
		foreach ( $qry->result() as $row ) {
			
			$detail .= "
				<tr>
					<td align='right'>$num</td>
					";
					
			foreach ($fields as $field) {
				$detail .= "<td>".$row->$field."</td>";
			}
			
			/* foreach ($fields as $field) {
				$detail .= "<td style='white-space: nowrap;>".$row->$field."</td>";
			} */
			
			$detail .= "
				</tr>
			";
			$num++;
		}
		$mpdf->WriteHTML($detail);
		
		$fields_count = $fields_count+1;
		$footer = "
				<tr>
					<td colspan=".$fields_count." class='blanktotal'>&nbsp;</td>
				</tr>
				</tbody>
			</table>";
		$mpdf->WriteHTML($footer);
		
		$mpdf->WriteHTML("</body></html>");
		
		// Sending headers to force the user to download the file
		header('Set-Cookie: fileDownload=true; path=/');
		// setcookie("fileDownload", "true", time() - 3600, "/");
		// setcookie("fileDownload", "true", time() - 3600);
		
		// $mpdf->Output();
		$mpdf->Output($filename.'.pdf','D');
	}
}

// CURRENCY ====================================
if ( ! function_exists('format_rupiah'))
{
	function format_rupiah($val, $precision = 0) {
		//1. cek apakah negatif?
		$n = '';
		if(strstr($val,"-")) { 
			$val = str_replace("-","",$val); 
			$n = "-"; 
		} 
		//2. cek apakah pecahan?
		$val = round((float) $val, (int) $precision);
		if (strpos($val, '.') !== false) {
			list($a, $b) = explode('.', $val); 
		} else {
			$a = $val;
			$b = '';
		}
		//3. format rupiah ! (cara pertama)
		$x = '';
		$i = strlen($a);
		while ($i > 3) {
			$x = "." . substr($a, -3) . $x;
			$a = substr($a, 0, strlen($a)-3);
			$i = strlen($a);
		}
		$a = $a . $x;
		
/* 		//3. format rupiah ! (cara kedua)
		for ($i=0, $j=1, $x=''; $i<strlen($a); $i++, $j++) {
			if (($j % 3) == 0) 
				$x = '.'.substr(strrev($a), $i,1).$x;
			else
				$x = substr(strrev($a), $i,1).$x;
		}
		if ((strlen($a) % 3) == 0)
			$x = substr($x, 1, strlen($x));
		$a = $x;
 */		
		//4. pembulatan
		if (strlen($b) < $precision) $b = str_pad($b, $precision, '0', STR_PAD_RIGHT); 
		
		return $precision ? "$n$a,$b" : "$n$a"; 
	}
}

if ( ! function_exists('seo_friendly'))
{
	function seo_friendly($realname) {

		$seoname = preg_replace('/\%/',' percentage',$realname); 
		$seoname = preg_replace('/\@/',' at ',$seoname); 
		$seoname = preg_replace('/\&/',' and ',$seoname); 
		$seoname = preg_replace('/\s[\s]+/','-',$seoname);    // Strip off multiple spaces 
		$seoname = preg_replace('/[\s\W]+/','-',$seoname);    // Strip off spaces and non-alpha-numeric 
		$seoname = preg_replace('/^[\-]+/','',$seoname); // Strip off the starting hyphens 
		$seoname = preg_replace('/[\-]+$/','',$seoname); // // Strip off the ending hyphens 
		$seoname = strtolower($seoname); 
		return $seoname;
	}
}

if ( ! function_exists('tempnam_sfx'))
{
   function tempnam_sfx($path, $suffix) 
   { 
      do 
      { 
         $file = $path."/".mt_rand().$suffix; 
         $fp = @fopen($file, 'x'); 
      } 
      while(!$fp); 

      fclose($fp); 
      return $file; 
   } 

   // call it like this: 
   //$file = tempnam_sfx("/tmp", ".jpg"); 
 }

/* Begin::URL Refererrer */
/**
 *
 * Function for get full url with parameter string
 *
 */
if ( ! function_exists('current_full_url'))
{
	function current_full_url()
	{
		$CI =& get_instance();
		$url = $CI->config->site_url($CI->uri->uri_string());
    return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
	}
}

/**
 * setURL_Index
 *
 * Function for set the session for page when redirect after save
 *
 * @param	string	$index    Session name
 */
if ( ! function_exists('setURL_Index'))
{
	function setURL_Index($index = '')
	{
		if(!$index){
				$key = 'referred_index';
		}else{
				$key = 'referred_'.$index;
		}
		$_SESSION[$key] = current_full_url();
	}
}

/**
 * getURL_Index
 *
 * Function for get page from session
 *
 * @param	string	$index    session name
 * @return	string
 */
if ( ! function_exists('getURL_Index'))
{
	function getURL_Index($index = '')
	{
		if(!$index){
			$key = 'referred_index';
		}else{
			$key = 'referred_'.$index;
		}
		if(isset($_SESSION[$key])){
			$referred_from = $_SESSION[$key];
		}else{
			$referred_from = current_full_url();
		}
		return $referred_from;
	}
}
/* End::URL Refererrer */


/* Begin::Debugging  */
if (! function_exists('debug'))
{
	function debug($data='')
	{
		echo var_dump($data); exit;
	}
}

if (! function_exists('debugf'))
{
	function debugf($data='')
	{
		$file = APPPATH.'logs/debug';
		$str = file_get_contents($file);
		
		$type = 'String: ';
		if (is_array($data)) $type = 'Array: ';
		if (is_object($data)) $type = 'Object: '.http_build_query($data, '', ';');
		if (is_bool($data)) $type = 'Boolean: ';
		
		if (is_array($data) || is_object($data)) 
			$data = $type.http_build_query($data, '', ';');
		elseif (is_bool($data) && $data) 
			$data = $type.'TRUE';
		elseif (is_bool($data) && !$data) 
			$data = $type.'FALSE';
		else 
			$data = $type.$data;
		
		$newstr = date('Y-m-d H:i').' '.$data."\r\n".$str;
		file_put_contents($file, $newstr);
	}
}
/* End::Debugging  */

