<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array(
			'new_ticket_form' => array(
							array(
									'field' => 'new_ticket_title',
									'label' => 'lang:new_ticket_lbl_title',
									'rules' => 'required|min_length[5]|max_length[100]'
								 ),
							array(
									'field' => 'new_ticket_message',
									'label' => 'lang:new_ticket_lbl_question',
									'rules' => 'required|min_length[5]'
								 )
							),  
			'edit_ticket_form' => array(
							array(
									'field' => 'edit_ticket_title',
									'label' => 'lang:edit_ticket_lbl_title',
									'rules' => 'required|min_length[5]|max_length[100]'
								 ),
							array(
									'field' => 'edit_ticket_message',
									'label' => 'lang:edit_ticket_lbl_question',
									'rules' => 'required|min_length[5]'
								 )
							),  
			'contact_us_form' => array(
							array(
									'field' => 'contact_name',
									'label' => 'lang:contact_us_lbl_name',
									'rules' => 'required'
								 ),
							array(
									'field' => 'contact_title',
									'label' => 'lang:contact_us_lbl_title',
									'rules' => 'required'
								 ),
							array(
									'field' => 'contact_email',
									'label' => 'lang:contact_us_lbl_email',
									'rules' => 'required|valid_email'
								 ),
							array(
									'field' => 'contact_message',
									'label' => 'lang:contact_us_lbl_message',
									'rules' => 'required|min_length[5]'
								 )
							),
			'reply_form' => array(
							array(
									'field' => 'reply_message',
									'label' => 'lang:ticket_btn_reply',
									'rules' => 'required|min_length[2]'
								 )
							),
			'account_settings_form' => array(
							array(
									'field' => 'account_settings_new_email',
									'label' => 'lang:account_settings_lbl_new_email',
									'rules' => 'trim|xss_clean|valid_email'
								 ),
							array(
									'field' => 'account_settings_new_password',
									'label' => 'lang:account_settings_lbl_new_password',
									'rules' => 'trim|xss_clean|min_length[4]|max_length[20]|alpha_dash' //*** I hard-coded min and max length, make sure it matches the min and length of tank_auth config file
								 ),
							array(
									'field' => 'account_settings_confirm_new_password',
									'label' => 'lang:account_settings_lbl_confirm_new_password',
									'rules' => 'trim|xss_clean|matches[account_settings_new_password]'
								 ),
							array(
									'field' => 'account_settings_current_password',
									'label' => 'lang:account_settings_lbl_old_password',
									'rules' => 'trim|required|xss_clean|min_length[4]|max_length[20]|alpha_dash' //*** I hard-coded min and max length, make sure it matches the min and length of tank_auth config file
								 )
							),
			'admin_edit_user_form' => array(
							array(
									'field' => 'account_settings_new_email',
									'label' => 'lang:account_settings_lbl_new_email',
									'rules' => 'trim|xss_clean|valid_email'
								 )
							),

'visitor_post_form' => array(
							array(
									'field' => 'visitor_post_title',
									'label' => 'Title',
									'rules' => 'required|min_length[5]|max_length[100]'
								 ),
							array(
									'field' => 'visitor_post_description',
									'label' => 'Description',
									'rules' => 'required|min_length[5]'
								 ),
							array(
									'field' => 'institution_lookup',
									'label' => 'Institution',
									'rules' => 'required'
								 ),
							array(
									'field' => 'visitor_post_email',
									'label' => 'Email',
									'rules' => 'trim|required|xss_clean|valid_email'
								 ),
							array(
									'field' => 'visitor_post_password',
									'label' => 'Password',
									'rules' => 'trim|required|xss_clean|min_length[4]|max_length[20]|alpha_dash' //*** I hard-coded min and max length, make sure it matches the min and length of tank_auth config file
								 ),
							array(
									'field' => 'visitor_post_confirm_password',
									'label' => 'Confirm Password',
									'rules' => 'trim|required|xss_clean|matches[visitor_post_password]'
								 )
							),
			'add_new_user_form' => array(
							array(
									'field' => 'admin_add_user_username',
									'label' => 'Username',
									'rules' => 'trim|xss_clean|required'
								 ),
							array(
									'field' => 'admin_add_user_email',
									'label' => 'Email Address',
									'rules' => 'trim|xss_clean|valid_email|required'
								 ),
							array(
									'field' => 'admin_add_user_password',
									'label' => 'Password',
									'rules' => 'trim|required|xss_clean|min_length[4]|max_length[20]|alpha_dash' //*** I hard-coded min and max length, make sure it matches the min and length of tank_auth config file
								 )
							)							
			);

/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */