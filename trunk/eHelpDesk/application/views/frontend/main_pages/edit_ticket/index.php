<div class="page-header"> 
<h3>
<?php echo (isset($page_title) ? $page_title : $this->lang->line('header_page_default_title')); ?>
</h3>
</div>
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
        <div class="control-group">
		<?php
			echo form_label($this->lang->line('edit_ticket_lbl_priority'), 'priority_lookup_label');
			foreach ($priority['rows'] as $row)
			{
				$lookup_list[$row->priority_id] = $row->priority_name;
			}

			echo form_dropdown('priority_lookup', $lookup_list, isset($maintain_priority) ? $maintain_priority : $current_priority, 'class="span6"');
		?>
        </div>
        <div class="control-group">
		<?php
			echo form_label($this->lang->line('edit_ticket_lbl_category'), 'category_lookup_label');
			foreach ($category['rows'] as $row)
			{
				$lookup_list[$row->category_id] = $row->category_name;
			}

			echo form_dropdown('category_lookup', $lookup_list, isset($maintain_category) ? $maintain_category : $current_category, 'class="span6"');
		?>
        </div>
        <div class="control-group">
		<?php
			echo form_label($this->lang->line('edit_ticket_lbl_title'), 'edit_ticket_title');
			echo form_input('edit_ticket_title', set_value('edit_ticket_title', $title), 'class="span6"'); 
		?>
        </div>
        <div class="control-group">
		<?php	
			echo form_label($this->lang->line('edit_ticket_lbl_question'), 'edit_ticket_message');
			echo form_textarea('edit_ticket_message', set_value('edit_ticket_message', $message), 'class="span6"');			
		?>
        </div>
        <div class="control-group">
		<?php
			if($attachment == NULL)
			{
				echo form_label($this->lang->line('edit_ticket_lbl_attach'), 'edit_ticket_attachment');
				echo form_upload('edit_ticket_attachment'); 
			}
			else
			{
				echo $this->lang->line('edit_ticket_lbl_attach').anchor('download/'.$attachment, $attachment);
				echo form_submit('delete_attach', $this->lang->line('edit_ticket_btn_delete_attachment'));
			}
		?>
        </div>
        <div class="control-group">
		<?php 
                echo form_submit('edit_ticket_submit', $this->lang->line('edit_ticket_btn_edit'), 'class="btn btn-primary"'); 
                echo anchor('ticket/'.$ticket_id, $this->lang->line('edit_ticket_link_back'),'class="btn btn-link"');            
        ?>
        </div>
<?php 
	echo form_close();

	

?>