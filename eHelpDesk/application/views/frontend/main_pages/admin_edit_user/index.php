<?php 
	if(get_temporary_msg())
	{
		echo '<div class="success_msg_section">'.get_temporary_msg().'</div>'; 
	}
	
	if(isset($error_messages))
	{
		echo '<div class="error_msg_section">'.$error_messages.'</div>';
	}
?>

<?php echo form_open($this->uri->uri_string()); ?>
<ul>
	<li>
		<?php
			if($this->tank_auth->get_group_id() == '100')
			{
				echo form_label($this->lang->line('admin_edit_user_lbl_groupid'), 'groupid_lookup_label');
				foreach ($groups['rows'] as $row)
				{
					$lookup_list[$row->group_id] = $row->group_name;
				}

				echo form_dropdown('groupid_lookup', $lookup_list, $current_group_id);
			}
		?>
	</li>
	<li>
		<?php
			if($this->tank_auth->get_group_id() == '100')
			{
				if($selected_user_id != $this->tank_auth->get_user_id()) //make sure ban is not shown for the current logged in staff.
				{
					//Is Active Dropdown
					echo form_label($this->lang->line('admin_edit_user_lbl_is_banned'));
					echo form_dropdown('is_banned_user_lookup', array('0' => $this->lang->line('value_no'), '1' => $this->lang->line('value_yes')), $current_is_banned);
				}
			}
		?>
	</li>
	<li>
		<?php
			echo form_label($this->lang->line('account_settings_lbl_user_id'), 'account_settings_user_id');
			echo form_label("$selected_user_id", 'account_settings_user_value'); 
		?>
	</li>
	<li>
		<?php
			echo form_label($this->lang->line('account_settings_lbl_username'), 'account_settings_username');
			echo form_label("$username", 'account_settings_username_value'); 
		?>
	</li>
	<li>
		<?php	
			echo form_label($this->lang->line('account_settings_lbl_current_email'), 'account_settings_current_email');
			echo form_label("$current_email", 'account_settings_current_email'); 	
		?>
	</li>
	<li>
		<?php
			echo form_label($this->lang->line('admin_edit_user_lbl_groupid'), 'groupid_lookup_label');
			echo form_label("$current_group_name", 'group_name'); 
		?>
	</li>
	<li>
		<?php
			$is_banned = ($current_is_banned == '1') ? $this->lang->line('value_yes') : $this->lang->line('value_no');
			echo form_label($this->lang->line('admin_edit_user_lbl_is_banned'));
			echo form_label("$is_banned"); 
		?>
	</li>
	<li>
		<?php	
			echo form_label($this->lang->line('account_settings_lbl_new_email'), 'account_settings_new_email');
			echo form_input('account_settings_new_email', set_value('account_settings_new_email')); 	
		?>
	</li>
	<li>
		<?php echo form_checkbox('notify_cbx', $notify, ($notify == 1) ? TRUE : FALSE); ?>
		<?php echo form_label($this->lang->line('account_settings_lbl_notify')); ?>
	</li>	
	<li>
		<?php echo form_submit('admin_edit_user_submit', $this->lang->line('account_settings_btn_update')); ?>
	</li>
</ul>
<?php echo form_close(); ?>
<?php echo form_open($this->uri->uri_string()); ?>
<ul>
	<li>
		<?php echo form_submit('reset', $this->lang->line('admin_edit_ticket_btn_reset')); ?>
	</li>
</ul>
<?php echo form_close(); ?>