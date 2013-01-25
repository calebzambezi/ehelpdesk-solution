<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_ticket extends Secured_Backend_Controller {

	function __construct() 
	{
		parent::__construct();
	}

	public function index($post_id = '', $title = '')
	{
		if($post_id == '')
			redirect(''); //goes to login (auth/login), login function checks if logged in or not? If yes, redirect to view-tickets.

		//grab the post based on the url post_id
		$data['post'] = $this->v_ticket_model->read('ticket_id, is_ticket_active, email, notify_user, title, message, attachment, category_name, priority_name, status_id, status_name, date_created, date_closed, date_updated, username', "ticket_id = $post_id");	
		
		//as a rule of thumb, always check availibility before loading the view rather than checking within the view itself.
		if($data['post']['rows'] == NULL)
		{
			view_404(); //post_id is wrong, just go back to home page (default controller)
			return;
		}
		
		//**** URL TITLE CONFIRMATION (START) ***
		//if no title within the URL, redirect user to the page with title included.
		if($title == '')
		{
			if($data['post']['rows'] != NULL)
				redirect(current_url().'/'.url_title($data['post']['rows'][0]->title, '-', TRUE));
			
		}
		else //if title exist, confirm that url title matches the real title that is fetched at the beginning of index() function.
		{
			if($title != url_title($data['post']['rows'][0]->title, '-', TRUE))
			{
				//redirect user to the same page with correct URL format. $this->uri->segment(1) represents "ticket"
				redirect(base_url().$this->uri->segment(1)."/$post_id/".url_title($data['post']['rows'][0]->title, '-', TRUE)); //Instead of "$this->uri->segment(1)", you could type "strtolower(get_class($this)"
			}
		}
		//**** URL TITLE CONFIRMATION (END) ***		
		
		//update status
		if($this->input->post('edit_status_submit'))
		{
			$data['err_msg'] = $this->_update_status($post_id);
		}
		
		if($this->input->post('delete_submit'))
		{
			$data['err_msg'] = $this->_delete_ticket($post_id);
		}
		
		//post a reply only if status is open. Otherwise, don't post a reply.
		if($this->input->post('ticket_reply_submit') && $data['post']['rows'][0]->status_id != '2')
		{
			//No matter changes you do in the url, post will be submitted to the URL form action. That's good, even if user changes post id manually then presses reply, reply will be posted on current post, not the post user tried to access via url indirectly.
			$data['error_messages'] = $this->_reply($post_id, $data['post']['rows'][0]->email, $data['post']['rows'][0]->notify_user, $title); 
		}
		
		//GRAB ALL ACTIVE REPLIES of the current ticket
		$column_names = 'reply_id, reply_text, attachment, username, date_created, date_updated, ticket_id';
		$pagin_page = 'admin-ticket/'.$this->uri->rsegment(3).'/'.$this->uri->rsegment(4); //The URL looks like: http://localhost/ehelpdesk/ticket/##/my-ticket-title-is-here ... Page number is always tacked at the end. Therefore, we appended uri segements to 'ticket' so the page number appears after the URL title.
		$recs_per_page = 10;
		$num_of_pagin_links = 3;
		$current_page_value = $this->uri->rsegment(5);
		$loc_of_page_val = 4; 
		$where = "ticket_id = $post_id AND is_active = '1'";
		$sort_order =  'asc';
		$data['replies'] = $this->v_reply_model->read_with_pagin($column_names, 
																$pagin_page, 
																$recs_per_page, 
																$num_of_pagin_links, 
																$current_page_value, 
																$loc_of_page_val, 
																$where, 
																$sort_order);

		
		$data['status'] = $this->status_model->read('status_id, status_name');
		$data['page_title'] = $this->lang->line('ticket_page_title').$data['post']['rows'][0]->title;
		$data['current_activity'] = $data['post']['rows'][0]->is_ticket_active; //reveal current activity in dropbox as the selected default
		$data['current_status'] = $data['post']['rows'][0]->status_id; //drop down box will select the status_id that currently exists in the system
		$this->load_view($data);		
	}

	//post a reply
	private function _reply($post_id, $email, $notify_user, $title) 
	{	
		$error_messages = '';
		$attachment_file_name = NULL;
		
		if ($this->form_validation->run('reply_form') == FALSE)
		{
			return $error_messages .= validation_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}
			
		if($_FILES['reply_attachment']['name'])
		{	
			$file_data = upload_file('reply_attachment'); //file is sanitized and cleaned as it gets uploaded
				
			if(is_array($file_data)) 
			{
				$attachment_file_name = $file_data['file_name'];
			}
			else
			{	
				return $file_data;
			}
		}

		$data['insert_id'] = $this->reply_model->create(array('reply_text' => $this->input->post('reply_message', TRUE), 'attachment' => $attachment_file_name, 'users_id' => $this->tank_auth->get_user_id(), 'ticket_id' => $post_id));
		if ($data['insert_id'] === FALSE)
		{
			return $this->lang->line('ticket_error_reply_failed');
		}
		else
		{
			if($notify_user == 1)
				send_email(NOREPLY_EMAIL, SITE_NAME, NOREPLY_EMAIL, SITE_NAME, $email, "eHelpDesk - Reply Notification (Ticket# $post_id)", "You received a new reply on ticket: <a href='".base_url()."ticket/$post_id' target='_blank'>$title</a>");
			
			//No need to show success message because successful reply will directly appear on replies list.
			set_temporary_msg('', $this->uri->uri_string());
		}
	}
	
	private function _update_status($post_id)
	{
		//if user decided to close the ticket, set close date/time. Otherwise, don't set close date
		if($this->input->post('status_lookup') == '2') //2 means user selected closed
			$close_date = date('Y-m-d H:i:s');
		else
			$close_date = NULL;
			
		//What if user changed the value manually via HTML source? Confirm that correct value is passed
		$status_code = ($this->input->post('status_lookup') == '2') ? $this->input->post('status_lookup') : '1'; //one, open, is the default one
		
		$data['effected_rows'] = $this->ticket_model->update_status("ticket_id = $post_id", array('status_id' => $status_code, 'date_closed' => $close_date));
		
		if ($data['effected_rows'] === FALSE) //update will take effect when the new value differs than the value that already exist in DB. Otherwise, effected row will be FALSE
		{
			//return '<div '.CSS_CLASS_ERROR.'>Try again. If problem persists, contact us.</div>'; NOT NEEDED, if new value is as same as the value that already exist in DB, we don't to show an error message. For example, if user selects "Open" when the ticket is already in "Open" state, we will hit this line.
		}
		else
		{
			if($this->input->post('status_lookup') == '2')
				set_temporary_msg($this->lang->line('ticket_success_ticket_closed'), $this->uri->uri_string()); //only show the message when selected status is "closed". If user selected another status e.g. open, on hold or so. We'll not show Your ticket is closed message.
			else
				set_temporary_msg($this->lang->line('ticket_success_ticket_opened'), $this->uri->uri_string()); 
		}
	}	
	
	//set ticket to active or inactive
	private function _delete_ticket($post_id)
	{	
		//ensure value is either 0 or 1. 1 is the default.
		$delete_code = ($this->input->post('delete_lookup') == '0') ? $this->input->post('delete_lookup') : '1'; //one, open, is the default one
		
		$data['effected_rows'] = $this->ticket_model->update_status("ticket_id = $post_id", array('is_active' => $delete_code));

		if ($data['effected_rows'] === FALSE) //update will take effect when the new value differs than the value that already exist in DB. Otherwise, effected row will be FALSE
		{
			//LEFT BLANK INTENTIONALLY
		}
		else
		{
			if($this->input->post('delete_lookup') == '0')
				set_temporary_msg($this->lang->line('ticket_success_ticket_deleted'), $this->uri->uri_string()); 
			else
				set_temporary_msg($this->lang->line('ticket_success_ticket_undeleted'), $this->uri->uri_string());
		}
	}
}