<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $data = array(); //Holds values to be printed in view pages
	protected $_controller;
	protected $_method;
	protected $_view;
	
	public function _remap($method, $params)
	{
		if ($this->uri->segment(1) !== FALSE && $this->uri->segment(1) === $this->uri->segment(2))
		{ 
			view_404(); 
			return;
		}
		
		if (method_exists($this, $method))
		{
			$this->_method = $method;
			$this->_view = $this->_controller . '/'. $this->_method;
			call_user_func_array(array($this, $method), $params); //Call a method without passing parameters: $this->$method($this, TRUE);
			return;
		}
		else
		{
			view_404();
		}
	}
	
	function __construct() 
	{
		parent::__construct();

		//Load your models:
		$this->load->model('ticket_model');	
		$this->load->model('group_model');
		$this->load->model('status_model');	
		$this->load->model('priority_model');			
		$this->load->model('category_model');
		$this->load->model('reply_model');	
		$this->load->model('users_model');	
		$this->load->model('v_ticket_model');
		$this->load->model('v_reply_model');
		$this->load->model('v_users_model');
				
		$this->_controller = strtolower(get_class($this));

		//***** SET A LANGUAGE (START) ******
		if($this->input->post('lang_submit'))
		{
			//make sure user didn't manually enter a gerribish language code: run is_selected_lang_valid()
			if(is_selected_lang_valid($this->input->post('language_lookup')) != FALSE)
			{
				//if there isn't a session, or the session is 'en' then set config['language'] to english. english here refers to english folder under language
				//if there is a session or the session is not 'en', then just assign the language value e.g. 'fr' as is to the config['language']. Why? Because english
				//folder under language is determined by CI authors. Also, CI system by default looks for english folder. However, other langugages such as 'fr', 'ar', etc
				//are manually created by me. So refering them as $config['language'] = 'ar' is totally fine because "ar" would be a folder under language folder.
				//In short, this->session->set_userdata('lang'); represents the language file
				if($this->input->post('language_lookup') == 'en')
				{
					$this->session->set_userdata('lang', 'english');
				}
				else
				{
					$this->session->set_userdata('lang', $this->input->post('language_lookup'));
				}
			}
			else
			{
				$this->session->set_userdata('lang', 'english');
			}
		}
		//***** SET A LANGUAGE (END) ******
				
		//load the language file after language is selected. Make sure to load all the necessary language files under language/#lang e.g. fr# folder
		$this->lang->load('ehelpdesk', $this->session->userdata('lang')); //if you remove 2nd parameter, the default language specified in $config['language'] = 'english' will take place.
		$this->lang->load('form_validation', $this->session->userdata('lang'));
		$this->lang->load('upload', $this->session->userdata('lang'));
	}
}
