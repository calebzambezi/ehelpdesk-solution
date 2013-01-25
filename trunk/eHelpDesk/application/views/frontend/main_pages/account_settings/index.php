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

<?php echo form_open('account-settings'); ?>
<ul>
	<li>
		<?php
			echo form_label($this->lang->line('account_settings_lbl_user_id'), 'account_settings_user_id');
			echo form_label("$user_id", 'account_settings_user_value'); 
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
			echo form_label($this->lang->line('account_settings_lbl_new_email'), 'account_settings_new_email');
			echo form_input('account_settings_new_email', set_value('account_settings_new_email')); 	
		?>
	</li>
	<li>
		<?php echo form_label($this->lang->line('account_settings_lbl_new_password')); ?>
		<?php echo form_password('account_settings_new_password', set_value('account_settings_new_password')); ?>
	</li>
	<li>
		<?php echo form_label($this->lang->line('account_settings_lbl_confirm_new_password')); ?>
		<?php echo form_password('account_settings_confirm_new_password'); ?>
	</li>
	<li>
		<?php echo form_checkbox('notify_cbx', $notify, ($notify == 1) ? TRUE : FALSE); ?>
		<?php echo form_label($this->lang->line('account_settings_lbl_notify')); ?>
	</li>
	<li>
		<?php echo form_label($this->lang->line('account_settings_lbl_old_password')); ?>
		<?php echo form_password('account_settings_current_password'); ?>
	</li>
	
	<li>
		<?php echo form_submit('account_settings_submit', $this->lang->line('account_settings_btn_update')); ?>
	</li>
	
</ul>
<?php echo form_close(); ?>