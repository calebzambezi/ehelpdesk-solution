<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class New_ticket extends Secured_Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
	}
	
	public function index() 
	{
		if($this->input->post('new_ticket_submit'))
		{
			$data['error_messages'] = $this->_add_new_ticket();
			$data['maintain_priority'] = $this->input->post('priority_lookup');
			$data['maintain_category'] = $this->input->post('category_lookup');
		}

		$data['category'] = $this->category_model->read('category_id, category_name');
		$data['priority'] = $this->priority_model->read('priority_id, priority_name');
		$data['page_title'] = $this->lang->line('new_ticket_page_title');
		$this->load_view($data);
	}
		
	private function _add_new_ticket() 
	{	
		$error_messages = '';
		$attachment_file_name = NULL;
		
		if ($this->form_validation->run('new_ticket_form') == FALSE)
		{ 
			return $error_messages .= validation_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}	
			
		//$this->input->post() does not support/print input of type file, $_FILES[]; it only supports $POST[]. HTML does not have a feature that preserves file type fields anyway for security purposes
		if($_FILES['new_ticket_attachment']['name'])
		{	
			$file_data = upload_file('new_ticket_attachment'); //file is sanitized and cleaned as it gets uploaded. upload_file() is part of general_helper.php
			if(is_array($file_data)) //if $file_data is not an array, then image wasn't uploaded, so show an error message; error message is returned in form of string
			{
				$attachment_file_name = $file_data['file_name'];
			}
			else
			{	
				return $file_data;
			}
		}

		$data['insert_id'] = $this->ticket_model->create(array('title' => $this->input->post('new_ticket_title', TRUE), 'message' => $this->input->post('new_ticket_message', TRUE), 'attachment' => $attachment_file_name, 'users_id' => $this->tank_auth->get_user_id(), 'priority_id' => $this->input->post('priority_lookup'), 'category_id' => $this->input->post('category_lookup')));
		if ($data['insert_id'] === FALSE)
		{
			return $this->lang->line('new_ticket_error_ticket_failed');
		}
		else
		{
			set_temporary_msg($this->lang->line('new_ticket_success_ticket_posted'), 'new-ticket');
		}
	}
}