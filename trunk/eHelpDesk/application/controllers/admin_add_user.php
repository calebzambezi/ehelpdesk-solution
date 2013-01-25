<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//copied from auth/register
class Admin_add_user extends Secured_Backend_Controller { //*** CHANGED to Backend

	function __construct() 
	{
		parent::__construct();
		access_is_only_for(array(100), 'error-404');
	}
	
	public function index()
	{
		if($this->input->post('admin_add_user_submit'))
		{
			$data['error_messages'] = $this->_register();
			$data['current_group_id'] = $this->input->post('groupid_lookup');
		}
		
		$data['groups'] = $this->group_model->read('group_id, group_name');
		$data['page_title'] = $this->lang->line('admin_add_user_page_title');
		$this->load_view($data);
	}
	
	function _register()
	{
		if ($this->form_validation->run('add_new_user_form') == FALSE)
		{
			return validation_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}
			
		if (!$this->users->is_email_available($this->input->post('admin_add_user_email'))) //taken from tank_auth
		{
			return $this->lang->line('admin_add_user_fail_email');
		}
		
		if (!$this->users->is_username_available($this->input->post('admin_add_user_username'))) //taken from tank_auth
		{
			return $this->lang->line('admin_add_user_fail_username');
		}
		
		//Hasher is taken from tank_auth source code
		$hasher = new PasswordHash($this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
		$hashed_password = $hasher->HashPassword($this->input->post('admin_add_user_password'));

		$arr = $this->users->create_user(array('username' => $this->input->post('admin_add_user_username'), 'password' => $hashed_password, 'email' => $this->input->post('admin_add_user_email', TRUE), 'last_ip' => $this->input->ip_address(), 'group_id' => $this->input->post('groupid_lookup')));

		if ($arr == NULL)
		{
			return '<div '.CSS_CLASS_ERROR.'>User is not added successfully</div>';
		}
		else
		{		
			mkdir(ATTACHMENTS_FOLDER.'/'.$arr['user_id']); //*** create a folder for the user. User's attachments will be uploaded to that user's particular folder.
			mkdir(ATTACHMENTS_FOLDER.'/'.$arr['user_id'].'/thumbs'); //*** create thumbs folder for that particular user

			// Send email to the user
			send_email(NOREPLY_EMAIL, SITE_NAME, NOREPLY_EMAIL, SITE_NAME, $this->input->post('admin_add_user_email'), "eHelpDesk - Account is Created", 'Your username is '.$this->input->post('admin_add_user_username').' and your password is '.$this->input->post('admin_add_user_password').' We strongly recommend you to login and change your password');

			set_temporary_msg($this->lang->line('admin_add_user_success'), $this->uri->uri_string());
		}
	}
}