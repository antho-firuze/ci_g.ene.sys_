<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once( FCPATH . '../vendor/autoload.php' );

class Fenomx extends Fenom
{
	public function __construct()
    {
        $this->template_dir = TEMPLATE_FCPATH;
        $this->compile_dir = CACHE_FCPATH;
		$this->options = array(
			'strip' 		=> true,
			'auto_trim' 	=> true,
			'auto_reload' 	=> true
		);
		
		$this->fenom = Fenom::factory($this->template_dir, $this->compile_dir, $this->options);
		
        // Assign CodeIgniter object by reference to CI
        if ( method_exists( $this, 'assignByRef') )
        {
            $ci =& get_instance();
            $this->assignByRef("ci", $ci);
        }

        log_message('debug', "Fenom Class Initialized");
    }
	
	function view($template, $data = array(), $return = FALSE)
    {
		$template = $template.'.tpl';
		
		if ($return == FALSE) 
		{
			log_message('debug', "Fenom: view return false");
			log_message('debug', "Fenom: display output to browser");
			$this->fenom->display($template, $data);
			
            // $CI =& get_instance();
            // if (method_exists( $CI->output, 'set_output' ))
            // {
				// log_message('debug', "Fenom: method exists \'set_output\'");
                // $CI->output->set_output( $this->fenom->fetch($template, $data) );
            // }
            // else
            // {
				// log_message('debug', "Fenom: method not exists \'set_output\'");
                // $CI->output->final_output = $this->fenom->fetch($template, $data);
            // }
            return;
		} 
		else 
		{
			log_message('debug', "Fenom: view return true");
			return $this->fenom->fetch($template, $data);
		}
    }
	
}