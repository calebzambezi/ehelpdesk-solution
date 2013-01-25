<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Public Frontend Controller is mainly identical to Frontend_Controller. However,
//Public_Frontend_Controller provides more organization, we explicitly know which
//controller is secured and which is public.
class Public_Frontend_Controller extends Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
	}
}