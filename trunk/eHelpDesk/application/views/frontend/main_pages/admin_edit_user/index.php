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
    <form class="form-horizontal">
        
        <div class="page-header">
                <h1>
            <?php echo $username; ?>
                </h1>
        </div>  
    
        <div class="control-group">
        
        <table class="table  table-bordered">
            <tr>
                <td> <?php echo form_label($this->lang->line('account_settings_lbl_user_id'), 'account_settings_user_id');?> </td>
                <td> <?php echo form_label("$selected_user_id", 'account_settings_user_value'); ?></td>                
           </tr>
           <tr>
                <td> <?php	echo form_label($this->lang->line('account_settings_lbl_current_email'), 'account_settings_current_email');?></td>
                <td><a href="mailto: <?php  echo $current_email;?>"> <?php  echo $current_email;?></a> </td>
           </tr>
           <tr>
                <td> <?php echo form_label($this->lang->line('admin_edit_user_lbl_groupid'), 'groupid_lookup_label');?></td>
                <td> <?php echo form_label("$current_group_name", 'group_name'); ?></td>
           </tr>
           <tr>
                <td> <?php $is_banned = ($current_is_banned == '1') ? $this->lang->line('value_yes') : $this->lang->line('value_no');
                     echo form_label($this->lang->line('admin_edit_user_lbl_is_banned')); ?> </td>
                <td> <?php echo form_label("$is_banned"); ?></td>
           </tr>
       </table>
		
        
        <div class="control-group">
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
        </div>
        <div class="control-group">
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
        
        <div class="control-group">
		<?php	
			echo form_label($this->lang->line('account_settings_lbl_new_email'), 'account_settings_new_email');
			echo form_input('account_settings_new_email', set_value('account_settings_new_email')); 	
		?>
        </div>
        <div class="control-group">
		<?php echo form_checkbox('notify_cbx', $notify, ($notify == 1) ? TRUE : FALSE); ?>        
		<?php echo form_label($this->lang->line('account_settings_lbl_notify')); ?>
        
        </div>
        <div class="control-group">

		<?php echo form_submit('admin_edit_user_submit', $this->lang->line('account_settings_btn_update'), 'class="btn btn-primary"'); ?>
        </div>
        <div class="control-group">
<?php echo form_close(); ?>

<?php echo form_open($this->uri->uri_string()); ?>

		<?php echo form_submit('reset', $this->lang->line('admin_edit_ticket_btn_reset'),'class="btn"'); ?>
        </div>
<?php echo form_close(); ?>