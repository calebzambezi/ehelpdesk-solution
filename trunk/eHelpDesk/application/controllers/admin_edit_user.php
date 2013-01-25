<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Copied from account_settings
class Admin_edit_user extends Secured_Backend_Controller { //*** CHANGED to Backend

	function __construct() 
	{
		parent::__construct();
	}
	
	public function index($user_id)
	{
		$records = $this->v_users_model->read('id, username, group_id, group_name, email, notify_user, banned', "id = $user_id");

		$data['selected_user_id'] = $records['rows'][0]->id;
		$data['username'] = $records['rows'][0]->username;
		$data['current_email'] = $records['rows'][0]->email;
		$data['notify'] = $records['rows'][0]->notify_user;
		$data['current_group_id'] = $records['rows'][0]->group_id;
		$data['current_group_name'] = $records['rows'][0]->group_name;
		$data['current_is_banned'] = $records['rows'][0]->banned;
		
		if($this->input->post('admin_edit_user_submit'))
		{
			$data['error_messages'] = $this->_update_account_info($user_id, $data['current_email'], $records['rows'][0]->group_id);
		}
		
		if($this->input->post('reset')) //*** ADDED 
		{
			send_email(NOREPLY_EMAIL, SITE_NAME, NOREPLY_EMAIL, SITE_NAME, $data['current_email'], "eHelpDesk - Reset Password", 'Go to login page and select "forgot passowrd" hyperlink');
			set_temporary_msg($this->lang->line('admin_edit_user_password_reset'), $this->uri->uri_string());
			
		}
		
		$data['groups'] = $this->group_model->read('group_id, group_name');
		$data['page_title'] = $this->lang->line('account_settings_page_title');
		$this->load_view($data);
	}
	
	private function _update_account_info($user_id, $user_email, $current_group_id)
	{
		if ($this->form_validation->run('admin_edit_user_form') == FALSE)
		{
			return validation_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}
		
		//did user select notify? If false, means checkbox is not selected. If $this->input->post('notify_cbx')
		//return the value, it means checkbox is selected.. Note is 1 in notify column means user want to be notified and -1 means
		//user does not want to be notified
		if($this->input->post('notify_cbx') == false)
			$notify = -1;
		else if($this->input->post('notify_cbx') == 1 || $this->input->post('notify_cbx') == -1)
			$notify = 1;
		else
			$notify = 1;
		
		//confirm availibility of the new email
		$email = '';
		if($this->input->post('account_settings_new_email') != '' && $this->input->post('account_settings_new_email') != $user_email) //*** CHANGED: $this->tank_auth->get_email() to $user_email
		{	
			if (!$this->users->is_email_available($this->input->post('account_settings_new_email')))
			{
				return $this->lang->line('account_settings_error_email_exists');
			}
			$email = $this->input->post('account_settings_new_email', TRUE);
			
			//send email notification to the user informing him/her address has changed by staff# such and such*** ADDED
			send_email(NOREPLY_EMAIL, SITE_NAME, ADMIN_EMAIL, SITE_NAME, $user_email, "eHelpDask Account is Updated", "Staff #".$this->tank_auth->get_user_id()." changed your email from $user_email to $email");
		}
		else //maintain current email
		{
			$email = $user_email;
		}

		//Ban will not show on the staff's user editing page; you can not ban yourself. Therefore, we have to make sure that there was ban dropdown box
		$banned = ($this->input->post('is_banned_user_lookup')) ? $this->input->post('is_banned_user_lookup') : '0';
		$group_id = ($this->input->post('groupid_lookup')) ? $this->input->post('groupid_lookup') : $current_group_id;
		
		$data['affected_rows'] = $this->users_model->update("id = $user_id", array('email' => $email, 'notify_user' => $notify, 'group_id' => $group_id, 'banned' => $banned));

		if($data['affected_rows'])
			set_temporary_msg($this->lang->line('account_settings_success_update_succeded'), $this->uri->uri_string()); 
		else
			return $this->lang->line('account_settings_error_update_failed', $this->uri->uri_string());
	
	}

	
	//set ticket to active or inactive
	private function _delete_user($user_id)
	{	
		//ensure value is either 0 or 1. 1 is the default.
		$activate_code = ($this->input->post('is_active_user_lookup') == '0') ? $this->input->post('is_active_user_lookup') : '1'; //one, open, is the default one
		
		$data['effected_rows'] = $this->users_model->update("id = $user_id", array('activated' => $this->input->post('is_active_user_lookup')));

		if ($data['effected_rows'] === FALSE) //update will take effect when the new value differs than the value that already exist in DB. Otherwise, effected row will be FALSE
		{
			//LEFT BLANK INTENTIONALLY
		}
		else
		{
			if($this->input->post('is_active_user_lookup') == '0')
				set_temporary_msg($this->lang->line('ticket_success_ticket_deleted'), $this->uri->uri_string()); 
			else
				set_temporary_msg($this->lang->line('ticket_success_ticket_undeleted'), $this->uri->uri_string());
		}
	}

}