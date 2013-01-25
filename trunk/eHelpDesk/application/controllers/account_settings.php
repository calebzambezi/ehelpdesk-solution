<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//Check sample codes file for the business rules of account settings
class Account_settings extends Secured_Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
	}
	
	public function index()
	{
		$records = $this->users_model->read('id, username, email, notify_user', 'id = '.$this->tank_auth->get_user_id());
		
		$data['user_id'] = $records['rows'][0]->id;
		$data['username'] = $records['rows'][0]->username;
		$data['current_email'] = $records['rows'][0]->email;
		$data['notify'] = $records['rows'][0]->notify_user;
		
		if($this->input->post('account_settings_submit'))
		{
			$data['error_messages'] = $this->_update_account_info();
		}
		
		$data['page_title'] = $this->lang->line('account_settings_page_title');
		$this->load_view($data);
	}
	
	private function _update_account_info()
	{
		if ($this->form_validation->run('account_settings_form') == FALSE)
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
		if($this->input->post('account_settings_new_email') != '' && $this->input->post('account_settings_new_email') != $this->tank_auth->get_email())
		{	
			if (!$this->users->is_email_available($this->input->post('account_settings_new_email')))
			{
				return $this->lang->line('account_settings_error_email_exists');
			}
			$email = $this->input->post('account_settings_new_email', TRUE);
		}
		else //maintain current email
		{
			$email = $this->tank_auth->get_email();
		}
		
		//grab current password
		$records = $this->users_model->read('password', 'id = '.$this->tank_auth->get_user_id());
		$current_password = $records['rows'][0]->password;
		
		$hasher = new PasswordHash($this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
		
		//confirm current password input matches the one in the db
		if ($hasher->CheckPassword($this->input->post('account_settings_current_password'), $current_password))
		{
			//By now, user already entered a correct current password. If new password field is filled, then update email, password and notify. Otherwise, just update notify and email. 
			//Regarding email, if user types something in new email, then new email will be inserted. Otherwise, the current email that exist in the session will be inserted.
			if(($this->input->post('account_settings_new_password') > 0) && ($this->input->post('account_settings_confirm_new_password') > 0))
			{
				$hashed_password = $hasher->HashPassword($this->input->post('account_settings_new_password')); 
				$data['affected_rows'] = $this->users_model->update('id = '.$this->tank_auth->get_user_id(), array('email' => $email, 'password' => $hashed_password, 'notify_user' => $notify));
			}
			else //just insert notify and email
			{
				$data['affected_rows'] = $this->users_model->update('id = '.$this->tank_auth->get_user_id(), array('email' => $email, 'notify_user' => $notify));
			}
			
			if($data['affected_rows'])
				set_temporary_msg($this->lang->line('account_settings_success_update_succeded'), 'account-settings'); 
			else
				return $this->lang->line('account_settings_error_update_failed');
		}
		else //ops! user didn't input current password.
		{
			return $this->lang->line('account_settings_error_invalid_password');
		}
	
	}
}