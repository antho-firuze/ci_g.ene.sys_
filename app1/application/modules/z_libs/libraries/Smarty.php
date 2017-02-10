<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once( FCPATH.'vendor/smarty/smarty/libs/Smarty.class.php' );

class Smartyx extends Smarty 
{
	public function __construct()
    {
        parent::__construct();

        $this->template_dir = APPPATH . "views";
        $this->compile_dir = FCPATH . "var/cache";
        $this->assign( 'APPPATH', APPPATH );
        $this->assign( 'BASEPATH', BASEPATH );

        // Assign CodeIgniter object by reference to CI
        if ( method_exists( $this, 'assignByRef') )
        {
            $ci =& get_instance();
            $this->assignByRef("ci", $ci);
        }

        log_message('debug', "Smarty Class Initialized");
    }
	
	function view($template, $data = array(), $return = FALSE)
    {
		$template = $template.'.tpl';
		
        foreach ($data as $key => $val)
        {
            $this->assign($key, $val);
        }
        
        if ($return == FALSE)
        {
            $CI =& get_instance();
            if (method_exists( $CI->output, 'set_output' ))
            {
                $CI->output->set_output( $this->fetch($template) );
            }
            else
            {
                $CI->output->final_output = $this->fetch($template);
            }
            return;
        }
        else
        {
            return $this->fetch($template);
        }
    }
}