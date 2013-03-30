<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticket extends Secured_Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
	}

	public function index($post_id = '', $title = '')
	{
		if($post_id == '')
			redirect(''); //goes to login (auth/login), login function checks if logged in or not? If yes, redirect to view-tickets.

		//grab the post based on the url post_id
		$data['post'] = $this->v_ticket_model->read('ticket_id, title, message, attachment, category_name, priority_name, status_id, status_name, date_created, date_closed, date_updated, username', "ticket_id = $post_id AND is_ticket_active = '1' AND users_id = ".$this->tank_auth->get_user_id()); //only show posts that are active and belongs to the user	
		
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
        
		//post a reply
		if($this->input->post('ticket_reply_submit') && $data['post']['rows'][0]->status_id != '2')
		{
			//No matter changes you do in the url, post will be submitted to the URL form action. That's good, even if user changes post id manually then presses reply, reply will be posted on current post, not the post user tried to access via url indirectly.
			$data['error_messages'] = $this->_reply($post_id, $title); //pass the title to maintain the url status. Parameters will be fetched from the form action URL.
		}
		
		//GRAB ALL ACTIVE REPLIES of the current ticket
		$column_names = 'reply_id, reply_text, attachment, username, date_created, date_updated, ticket_id';
		$pagin_page = 'ticket/'.$this->uri->rsegment(3).'/'.$this->uri->rsegment(4); //The URL looks like: http://localhost/ehelpdesk/ticket/##/my-ticket-title-is-here ... Page number is always tacked at the end. Therefore, we appended uri segements to 'ticket' so the page number appears after the URL title.
		$recs_per_page = 5;
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

		
		//Just before we view the page, lets see if any member other than the post's owner, replied to the post. This
		//will help us deicde whether to show edit button/link or not. We don't want for the owner to edit the post if
		//at least one reply is posted by another member. NOTE: i selected any column, in my case i chose users_id, just not to put *. All i care in here, did i get records back or not! 
		$data['is_stuff_replied'] = $this->v_reply_model->read('users_id', 'ticket_id = '.$data['post']['rows'][0]->ticket_id.' AND is_active = "1" AND users_id <> '.$this->tank_auth->get_user_id());
		$data['status'] = $this->status_model->read('status_id, status_name');
		$data['page_title'] = $this->lang->line('ticket_page_title').$data['post']['rows'][0]->title;
		$this->load_view($data);		
	}

	//post a reply
	private function _reply($post_id) 
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
			//No need to show success message because successful reply will directly appear on replies list.
			set_temporary_msg('', $this->uri->uri_string());
		}
	}
}