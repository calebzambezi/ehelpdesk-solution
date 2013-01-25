<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom404 extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
	}
	
	public function index() 
	{
		view_404();
	}
	
}