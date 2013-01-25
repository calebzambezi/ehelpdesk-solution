<?php 

	if(get_temporary_msg())
	{
		echo '<div class="success_msg_section">'.get_temporary_msg().'</div>'; 
	}
	
	if(isset($err_msg))  //errors related to is_active and status dropdown box
	{
		echo '<div class="error_msg_section">'.$err_msg.'</div>';
	}

	echo form_open_multipart($this->uri->uri_string()); 
?>
	<ul>
		<li>
			<?php
				echo form_label($this->lang->line('ticket_lbl_status'), 'status_lookup_label');
				foreach ($status['rows'] as $row)
				{
					$lookup_list[$row->status_id] = $row->status_name;
				}

				echo form_dropdown('status_lookup', $lookup_list, $current_status);
			?>
		</li>
		<li>
			<?php echo form_submit('edit_status_submit', $this->lang->line('ticket_btn_update')); ?>
		</li>
		<li>
			<?php
				if($this->tank_auth->get_group_id() == '100')
				{
					//Is Active Dropdown
					echo form_label($this->lang->line('ticket_lbl_is_active'), 'delete_lookup_label');
					echo form_dropdown('delete_lookup', array('0' => $this->lang->line('value_no'), '1' => $this->lang->line('value_yes')), $current_activity);
					echo form_submit('delete_submit', $this->lang->line('ticket_btn_delete'));
				}
			?>
		</li>
	</ul>
	<?php echo form_close(); ?>

<?php 

//show ticked content
$date_closed = ($post['rows'][0]->date_closed != NULL) ? date('j M, Y', strtotime($post['rows'][0]->date_closed)) : '---'; //format date if exist
$date_updated = ($post['rows'][0]->date_updated != NULL) ? date('j M, Y', strtotime($post['rows'][0]->date_updated)) : '---';
$is_active = ($post['rows'][0]->is_ticket_active == '1') ? $this->lang->line('value_yes') : $this->lang->line('value_no');

echo $this->lang->line('ticket_lbl_is_active').$is_active.'<br />';
echo $this->lang->line('ticket_lbl_ticket_id').$post['rows'][0]->ticket_id.'<br />';
echo $this->lang->line('ticket_lbl_username').$post['rows'][0]->username.'<br />';
echo $this->lang->line('ticket_lbl_date_created').date('j M, Y', strtotime($post['rows'][0]->date_created)).'<br />';
echo $this->lang->line('ticket_lbl_date_updated').$date_updated.'<br />';
echo $this->lang->line('ticket_lbl_date_closed').$date_closed.'<br />';
echo $this->lang->line('ticket_lbl_category').$post['rows'][0]->category_name.'<br />';
echo $this->lang->line('ticket_lbl_priority').$post['rows'][0]->priority_name.'<br />';
echo $this->lang->line('ticket_lbl_status').$post['rows'][0]->status_name.'<br />';
echo $this->lang->line('ticket_lbl_title').$post['rows'][0]->title.'<br />';
echo $this->lang->line('ticket_lbl_message').$post['rows'][0]->message.'<br />';
echo $post['rows'][0]->attachment ? $this->lang->line('ticket_lbl_attachment').anchor('download/'.$post['rows'][0]->attachment, $post['rows'][0]->attachment).'<br />' : '';
if($post['rows'][0]->status_name != 'Closed')
	echo anchor('admin-edit-ticket/'.$post['rows'][0]->ticket_id, $this->lang->line('ticket_link_edit'));
?>

<?php
//reply sections
echo '<br />';

if($replies['count'] > 0)
{
	echo $this->lang->line('ticket_lbl_count_replies').$replies['count'].'<br />';

	foreach ($replies['rows'] as $row)
	{
		$attachment_file = ($row->attachment != NULL) ? '- '.$this->lang->line('ticket_lbl_attachment').anchor('download/'.$row->attachment, $row->attachment) : '';
		echo 'Reply ID: '.$row->reply_id.' - Reply Text: '.$row->reply_text.' '.$attachment_file.' - '.$this->lang->line('ticket_lbl_username').$row->username.' - '.$this->lang->line('ticket_lbl_date_created').date('j M, Y', strtotime($row->date_created)).' - '.$this->lang->line('ticket_lbl_ticket_id').$row->ticket_id.'<br />';
	}
	
	echo $replies['pag_links'];
}
?>

<?php 

//if ticket is closed, don't show reply box
if($post['rows'][0]->status_name != 'Closed')
{
	if(isset($error_messages)) echo $error_messages.'<br /><br />'; 

	echo form_open_multipart($this->uri->uri_string()); ?>
	<ul>
		<li>
			<?php	
				echo form_textarea('reply_message', set_value('reply_message'));			
			?>
		</li>
		<li>
			<?php
				echo form_label($this->lang->line('ticket_lbl_attachment'), 'reply_ticket_attachment');
				echo form_upload('reply_attachment'); 
			?>
		</li>
		<li>
			<?php echo form_submit('ticket_reply_submit', $this->lang->line('ticket_btn_reply')); ?>
		</li>
	</ul>
	<?php echo form_close();
} //end of if($post['rows'][0]->status_name != 'Closed') ?>