<?php echo form_open($this->uri->uri_string()); //START SEARCH ********* ?>
<ul>
	<li>
		<?php
			echo form_label($this->lang->line('manage_users_lbl_search'), 'search_txt');
			echo form_input('search_txt', set_value('search_txt', $this->session->userdata('searched_text'))); 
		?>
	</li>
	<li>
		<?php echo form_submit('search_submit', $this->lang->line('manage_users_btn_find')); ?>
	</li>
	
</ul>
<?php echo form_close(); //******** END SEARCH ?>
<?php  
if($this->tank_auth->get_group_id() == '100')
{
	echo anchor('admin-add-user', $this->lang->line('admin_add_user_link')).'<br />';
}

if($posts['count'] == 0)
{
	echo $this->lang->line('manage_users_no_members');
}
else
{
	if(get_temporary_msg())
	{
		echo '<div class="success_msg_section">'.get_temporary_msg().'</div>'; 
	}
	
	if(isset($error_messages))
	{
		echo '<div class="error_msg_section">'.$error_messages.'</div>';
	}
	
	echo anchor("manage-users/$sort_by_datec/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('manage_users_hdr_register_date')); //this represents one of the table header's
	echo "<br />";
	echo anchor("manage-users/$sort_by_dateu/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('manage_users_hdr_is_updat_date'));
	echo "<br />";

	echo $this->lang->line('manage_users_lbl_count').$posts['count'].'<br />';

	foreach ($posts['rows'] as $row)
	{
		$is_active = ($row->activated == 1) ? $this->lang->line('value_yes') : $this->lang->line('value_no');
		echo $this->lang->line('manage_users_hdr_group_id').' - '.$row->group_id.' - '.$this->lang->line('manage_users_hdr_user_id').$row->id.' - '.$this->lang->line('manage_users_hdr_username').anchor('admin-edit-user/'.$row->id, $row->username).' - '.$this->lang->line('manage_users_hdr_email').$row->email.' - '.$this->lang->line('manage_users_hdr_register_date').date('j M, Y', strtotime($row->created)).' - '.$this->lang->line('manage_users_hdr_is_updat_date').date('j M, Y', strtotime($row->modified)).' - '.$this->lang->line('manage_users_hdr_is_active').$is_active.'<br />';
	}
	
	echo $posts['pag_links'];
}