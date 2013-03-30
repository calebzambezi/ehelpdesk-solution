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
<table class="table  table-bordered">
    <tr>
        <th class="span1"><?php echo form_label($this->lang->line('account_settings_lbl_user_id'), 'account_settings_user_id'); ?></th>
        <th class="span1"><?php echo form_label($this->lang->line('account_settings_lbl_username'), 'account_settings_username'); ?></th>
        <th class="span1"><?php	echo form_label($this->lang->line('account_settings_lbl_current_email'), 'account_settings_current_email'); ?></th>
    </tr>
    <tr>
        <th class="span1"><?php echo form_label("$user_id", 'account_settings_user_value'); ?></th>
        <th class="span1"><?php echo form_label("$username", 'account_settings_username_value'); ?></th>
        <th class="span1"><?php echo form_label("$current_email", 'account_settings_current_email'); ?></th>
    </tr>
</table>
<form class="form-horizontal">
  
  <div class="control-group">
      <?php	
      echo form_label($this->lang->line('account_settings_lbl_new_email'), 'account_settings_new_email');
      echo form_input('account_settings_new_email', set_value('account_settings_new_email')); 	
		?>
  </div>
  <div class="control-group">
      <?php echo form_label($this->lang->line('account_settings_lbl_new_password')); ?>
		<?php echo form_password('account_settings_new_password', set_value('account_settings_new_password')); ?>
  </div>
   <div class="control-group">
      <?php echo form_label($this->lang->line('account_settings_lbl_confirm_new_password')); ?>
		<?php echo form_password('account_settings_confirm_new_password'); ?>
  </div>
   <div class="control-group">
      <?php echo form_checkbox('notify_cbx', $notify, ($notify == 1) ? TRUE : FALSE); ?>
		<?php echo form_label($this->lang->line('account_settings_lbl_notify')); ?>
  </div>
  <div class="control-group">
      <?php echo form_label($this->lang->line('account_settings_lbl_old_password')); ?>
		<?php echo form_password('account_settings_current_password'); ?>
  </div>
  <div class="control-group">
      <?php echo form_submit('account_settings_submit', $this->lang->line('account_settings_btn_update'), 'class="btn btn-primary"'); ?>
  </div>
</form>  

<?php echo form_close(); ?>