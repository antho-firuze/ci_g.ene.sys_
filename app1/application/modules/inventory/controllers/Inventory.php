<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/modules/z_libs/libraries/Getmeb.php';

class Inventory extends Getmeb 
{
	function __construct() {
		/* Exeption list methods is not required login */
		$this->exception_method = [];
		parent::__construct();
		
	}
	
	function m_item()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name, t1.description', $this->params->q);
		}
	}
	
	function m_itemcat()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name, t1.description', $this->params->q);
		}
	}
	
	function m_itemtype()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name, t1.description', $this->params->q);
		}
	}
	
	function m_measure()
	{
		if ($this->params->event == 'pre_get'){
			if (isset($this->params->id) && ($this->params->id !== '')) 
				$this->params->where['t1.id'] = $this->params->id;
			
			if (isset($this->params->q) && !empty($this->params->q))
				$this->params->like = DBX::like_or('t1.name, t1.description', $this->params->q);
		}
	}
	
}