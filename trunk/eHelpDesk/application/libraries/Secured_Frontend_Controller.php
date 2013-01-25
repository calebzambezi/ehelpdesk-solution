<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Secured_Frontend_Controller extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
		require_login();
		access_is_only_for(array(100,300,200), 'error-404');
	}
	
}