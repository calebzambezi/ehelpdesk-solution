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
				echo form_label($this->lang->line('admin_edit_user_lbl_groupid'), 'groupid_lookup_label');
				foreach ($groups['rows'] as $row)
				{
					$lookup_list[$row->group_id] = $row->group_name;
				}

				echo form_dropdown('groupid_lookup', $lookup_list, (isset($current_group_id)) ? $current_group_id : '');
			?>
		</li>
		<li>
			<?php echo form_label('Username'); ?>
			<?php echo form_input('admin_add_user_username', set_value('admin_add_user_username')); ?>
		</li>
		<li>
			<?php echo form_label('Email Address'); ?>
			<?php echo form_input('admin_add_user_email', set_value('admin_add_user_email')); ?>
		</li>
		<li>
			<?php echo form_label('Password'); ?>
			<?php echo form_password('admin_add_user_password', set_value('admin_add_user_password')); ?>
		</li>
	</ul>
<?php echo form_submit('admin_add_user_submit', $this->lang->line('admin_add_user_add')); ?>
<?php echo form_close(); ?>