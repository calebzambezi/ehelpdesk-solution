<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Frontend_Controller extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
	}

	protected function load_view($data = array()) 
	{	
				
		$data['user_id'] = $this->tank_auth->get_user_id();
		$data['email'] = $this->tank_auth->get_email();
		$data['group_id'] = $this->tank_auth->get_group_id();
		
		$data['main_page'] = $this->_view;
		$this->load->view(FRONTEND_SKELETON, $data); 
	}
	
}