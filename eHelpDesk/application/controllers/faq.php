<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Public_Frontend_Controller  {

	function __construct() 
	{
		parent::__construct();
	}


	public function index() 
	{
		$this->load_view();
	}
}