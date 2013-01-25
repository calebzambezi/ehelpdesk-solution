<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Terms extends Public_Frontend_Controller  {

	function __construct() 
	{
		parent::__construct();
	}

	public function index() 
	{
		$data['page_title'] = $this->lang->line('terms_page_title');
		$this->load_view($data);
	}
}