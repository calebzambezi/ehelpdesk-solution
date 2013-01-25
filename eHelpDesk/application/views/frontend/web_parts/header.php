<?php

echo form_open($this->uri->uri_string());
	$lookup_list['en'] = 'English';
	$lookup_list['fr'] = 'French';

	echo form_dropdown('language_lookup', $lookup_list, $this->session->userdata('lang'));
	echo form_submit('lang_submit', $this->lang->line('header_btn_select_lang'));
echo form_close(); 

echo "<br />";	
if ($this->tank_auth->is_logged_in())
{
	echo $this->lang->line('header_lbl_welcome').$this->tank_auth->get_username().' | '.anchor('view-tickets', $this->lang->line('header_link_my_tickets')).' | '.anchor('new-ticket', $this->lang->line('header_link_open_new_tickets')).' | '.anchor('account-settings', $this->lang->line('header_link_account_settings')).' | '.anchor('logout', $this->lang->line('header_link_logout')).'<br /><br />';
	
	if($this->tank_auth->get_group_id() == '100' || $this->tank_auth->get_group_id() == '300') //$group_id is set in Frontend_Controller
	{
		echo $this->lang->line('header_lbl_admin_features').anchor('manage-tickets', $this->lang->line('header_link_manage_tickets')).' | '.anchor('manage-users', $this->lang->line('header_link_manage_users'));
	}
}
else
{
	echo $this->lang->line('header_msg_greeting');
}