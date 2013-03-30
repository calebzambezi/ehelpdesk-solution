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

<?php echo form_open_multipart($this->uri->uri_string()); ?>

<form class="form-horizontal">
  
  <div class="control-group">
      <?php
      echo form_label($this->lang->line('new_ticket_lbl_priority'), 'priority_lookup_label');
      foreach ($priority['rows'] as $row)
      {
          $lookup_list[$row->priority_id] = $row->priority_name;
      }

      echo form_dropdown('priority_lookup', $lookup_list, isset($maintain_priority) ? $maintain_priority : '', 'class="span6"');
		?>
  </div>
  <div class="control-group">
      <?php
      echo form_label($this->lang->line('new_ticket_lbl_category'), 'category_lookup_label');
      foreach ($category['rows'] as $row)
      {
          $lookup_list[$row->category_id] = $row->category_name;
      }

      echo form_dropdown('category_lookup', $lookup_list, isset($maintain_category) ? $maintain_category : '', 'class="span6"');
		?>
  </div>
  <div class="control-group">
      <?php
      echo form_label($this->lang->line('new_ticket_lbl_title'), 'new_ticket_title');
      echo form_input('new_ticket_title', set_value('new_ticket_title'), 'class="span6"'); 
		?>
  </div>
  <div class="control-group">
      <?php	
      echo form_label($this->lang->line('new_ticket_lbl_question'), 'new_ticket_message');
      echo form_textarea('new_ticket_message', set_value('new_ticket_message'), 'class="span6"');			
		?>
  </div>
  <div class="control-group">
      <?php
      echo form_label($this->lang->line('new_ticket_lbl_attach'), 'new_ticket_attachment');
      echo form_upload('new_ticket_attachment'); 
		?>
  </div>
  <div class="control-group">
      <?php echo form_submit('new_ticket_submit', $this->lang->line('new_ticket_btn_post'), 'class="btn btn-primary"'); ?>
  </div>
</form>

<?php echo form_close(); ?>