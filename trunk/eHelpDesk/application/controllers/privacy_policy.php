<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privacy_policy extends Public_Frontend_Controller  {

	function __construct() 
	{
		parent::__construct();
	}

	public function index() 
	{
		$data['page_title'] = $this->lang->line('privacy_policy_page_title');
		$this->load_view($data);
	}
}