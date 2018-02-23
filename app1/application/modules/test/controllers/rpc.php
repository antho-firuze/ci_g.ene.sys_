<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Jsonrpc.php';

class Rpc extends Jsonrpc {

	function __construct() {
		parent::__construct();
		
	}
	
	
	function index() {
		// echo 'running rpc =-'."\n\n";
		echo $this->r_method;
		echo "<br>";
		echo $this->c_method;
		// echo 'running rpc'."\n\n";
	}
	
}