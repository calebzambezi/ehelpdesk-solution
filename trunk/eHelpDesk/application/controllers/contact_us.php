<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends Public_Frontend_Controller  {

	function __construct() 
	{
		parent::__construct();
	}


	public function index() 
	{
		$data = array();
		
		if($this->input->post('contact_submit'))
		{
			$data['error_messages'] = $this->_send();
		}
		
		$this->load_view($data);
	}

	private function _send() 
	{		
		$support_email = ADMIN_EMAIL;
		
		if ($this->form_validation->run('contact_us_form') == FALSE)
		{
			return validation_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}
		
		if(send_email($this->input->post('contact_email'), $this->input->post('contact_name'), $this->input->post('contact_email'), $this->input->post('contact_name'), $support_email, $this->input->post('contact_title'), $this->input->post('contact_message')))
			set_temporary_msg($this->lang->line('contact_us_success_message_sent'), $this->uri->uri_string());
		else
			return $this->lang->line('contact_us_error_message_failed');
	}
}