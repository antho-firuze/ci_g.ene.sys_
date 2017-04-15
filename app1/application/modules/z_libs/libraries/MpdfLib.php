<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( FCPATH . '../vendor/autoload.php' );

class MpdfLib extends Mpdf { 
    public function __construct() { 
        parent::__construct(); 
    } 
}