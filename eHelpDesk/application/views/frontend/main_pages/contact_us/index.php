<?php 

echo get_temporary_msg(); 
if(isset($error_messages)) echo $error_messages; 
?>

<?php echo form_open('contactus'); ?>
<ul>
	<li>
		<?php
			echo form_label($this->lang->line('contact_us_lbl_name'), 'contact_name');
			echo form_input('contact_name', set_value('contact_name')); 
		?>
	</li>
	<li>
		<?php
			echo form_label($this->lang->line('contact_us_lbl_email'), 'contact_email');
			echo form_input('contact_email', set_value('contact_email')); 
		?>
	</li>
	<li>
		<?php
			echo form_label($this->lang->line('contact_us_lbl_title'), 'contact_title');
			echo form_input('contact_title', set_value('contact_title')); 
		?>
	</li>
	<li>
		<?php	
			echo form_label($this->lang->line('contact_us_lbl_message'), 'contact_message');
			echo form_textarea('contact_message', set_value('contact_message'));			
		?>
	</li>
	<li>
		<?php echo form_submit('contact_submit', $this->lang->line('contact_us_btn_send')); ?>
	</li>
	
</ul>
<?php echo form_close(); ?>