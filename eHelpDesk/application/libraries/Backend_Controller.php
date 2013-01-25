<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//We don't have Public_Backend_Controller and Secured_Backend_Controller that
//extend from Backend_Controller because all backend controllers have to be
//secured anyway. All backend controllers will extend the current class Backend_Controller
class Backend_Controller extends MY_Controller {

	function __construct() 
	{
		parent::__construct(); 	
		require_login();
		access_is_only_for(array(100), 'error-404');
	}
	
	protected function load_view($data = array()) 
	{
		$data['user_id'] = $this->tank_auth->get_user_id();
		$data['email'] = $this->tank_auth->get_email();
		$data['group_id'] = $this->tank_auth->get_group_id();
		
		$data['main_page'] = $this->_view;
		$this->load->view(BACKEND_SKELETON, $data); 
	}
}
