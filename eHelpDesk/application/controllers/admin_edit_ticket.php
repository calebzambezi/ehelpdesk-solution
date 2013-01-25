<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//allow staff to edit a post.
class Admin_edit_ticket extends Secured_Backend_Controller { //*** CHANGED: Extend from Secured_Backend_Controller rather than Secured_Frontend_Controller

	function __construct() 
	{
		parent::__construct();
	}

	public function index($post_id = '') 
	{	
		if($post_id == '')
			redirect('');
			
		if($this->input->post('edit_ticket_submit'))
		{
			$data['error_messages'] = $this->_edit_ticket($post_id); //if edit succeeded, user will be redirected; we won't reach this block. If edit_ticket() returned something, means edit didn't succeed.
			$data['maintain_priority'] = $this->input->post('priority_lookup'); //if error is returned we are going to store the latest selected priority_lookup value into maintain_priority to mainain the value status as error message is printed to screen. Same rule applies to category 
			$data['maintain_category'] = $this->input->post('category_lookup');
		}

		//just grab the ticket based on ticket_id, don't worry status, is_active or whether this ticket belongs to you or not because you are the admin
		//you have priviage of editing any ticket.
		$data['post'] = $this->v_ticket_model->read('ticket_id, title, message, attachment, category_id, category_name, priority_id, priority_name, status_id, status_name, date_created, date_closed, date_updated, username', "ticket_id = $post_id"); //*** CHANGED: narrowed down the where clause to Ticket_id = $post_id

		//as a rule of thumb, always check availibility before loading the view rather than checking within the view itself.
		if($data['post']['rows'] == NULL)
		{
			view_404(); //post_id is wrong, just go back to home page (default controller)
			return;
		}
		
		if($this->input->post('delete_attach'))
		{
			$data['error_messages'] = $this->_delete_attachment($post_id, $data['post']['rows'][0]->attachment); //the attachment name belongs to the first paramter, post_id.
			$data['maintain_priority'] = $this->input->post('priority_lookup');
			$data['maintain_category'] = $this->input->post('category_lookup');
		}
		
		//since we already grabbed the post, lets grab the necessary values as title, message, priority value ,etc to be populate in view
		$data['current_priority'] = $data['post']['rows'][0]->priority_id;
		$data['current_category'] = $data['post']['rows'][0]->category_id;
		$data['ticket_id'] = $data['post']['rows'][0]->ticket_id;
		$data['title'] = $data['post']['rows'][0]->title;
		$data['message'] = $data['post']['rows'][0]->message;
		$data['attachment'] = $data['post']['rows'][0]->attachment;

		$data['status'] = $this->status_model->read('status_id, status_name');
		$data['category'] = $this->category_model->read('category_id, category_name');
		$data['priority'] = $this->priority_model->read('priority_id, priority_name');
		$data['page_title'] = $this->lang->line('edit_ticket_page_title').$post_id;
		$this->load_view($data);		
	}

	private function _edit_ticket($p_id) 
	{	
		$error_messages = '';
		$attachment_file_name = NULL;
		
		if ($this->form_validation->run('edit_ticket_form') == FALSE)
		{ 
			return $error_messages .= validation_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}	
			
		if(isset($_FILES['edit_ticket_attachment'])) //if the attachment box is showing, do the following:
		{
			//here we consider the attacment field
			if($_FILES['edit_ticket_attachment']['name'])
			{	
				$file_data = upload_file('edit_ticket_attachment'); //file is sanitized and cleaned as it gets uploaded. upload_file() is part of general_helper.php
				if(is_array($file_data)) //if $file_data is not an array, then image wasn't uploaded, so show an error message; error message is returned in form of string
				{
					$attachment_file_name = $file_data['file_name'];
				}
				else
				{	
					return $file_data;
				}
			}
			
			//update including attachment
			$data['effected_rows'] = $this->ticket_model->update("ticket_id = $p_id", array('title' => $this->input->post('edit_ticket_title', TRUE), 'message' => $this->input->post('edit_ticket_message', TRUE), 'attachment' => $attachment_file_name, 'priority_id' => $this->input->post('priority_lookup'), 'category_id' => $this->input->post('category_lookup'))); //*** CHANGED, removed update of user id
		}
		else //user already has an attachment, so the attachment upload box is not showing
		{
			//update without attachment field because in this case user is already have an attachment that available for downloading
			$data['effected_rows'] = $this->ticket_model->update("ticket_id = $p_id", array('title' => $this->input->post('edit_ticket_title', TRUE), 'message' => $this->input->post('edit_ticket_message', TRUE), 'users_id' => $this->tank_auth->get_user_id(), 'priority_id' => $this->input->post('priority_lookup'), 'category_id' => $this->input->post('category_lookup')));
		}
		
		if ($data['effected_rows'] === FALSE)
		{
			return $this->lang->line('edit_ticket_error_edit_failed');
		}
		else
		{
			set_temporary_msg($this->lang->line('edit_ticket_success_edit_ok'), $this->uri->uri_string());
		}
	}	
	
	//LOOK AT general_helper
	private function _delete_attachment($p_id, $file_name)
	{
		$deletion_status = delete_file(ATTACHMENTS_FOLDER.'/'.$this->tank_auth->get_user_id().'/'.$file_name);
		if($deletion_status == 'true' || $deletion_status == 'no file')
		{
			//delete from the DB
			$data['effected_rows'] = $this->ticket_model->update("ticket_id = $p_id AND users_id = ".$this->tank_auth->get_user_id(), array('attachment' => NULL));
			if($data['effected_rows'])
				set_temporary_msg('', $this->uri->uri_string());
			else
				return $this->lang->line('edit_ticket_error_del_attach_failed1'); //Sample Msg: Temporary issue is encountered. Please press delete button again.
		}
		else 
		{
			return $this->lang->line('edit_ticket_error_del_attach_failed2'); //probably due to folder permission or so
		}
	}
}