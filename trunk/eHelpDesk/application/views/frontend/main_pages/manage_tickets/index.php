<?php echo form_open($this->uri->uri_string()); //START SEARCH ********* ?>
<ul>
	<li>
		<?php
			echo form_label($this->lang->line('view_tickets_lbl_search'), 'search_txt');
			echo form_input('search_txt', set_value('search_txt', $this->session->userdata('searched_text'))); 
		?>
	</li>
	<li>
		<?php echo form_submit('search_submit', $this->lang->line('view_tickets_btn_find')); ?>
	</li>
	
</ul>
<?php echo form_close(); //******** END SEARCH ?>
<?php  

if($posts['count'] == 0)
{
	echo $this->lang->line('view_tickets_msg_no_posts');
}
else
{
	echo get_temporary_msg(); 
	if(isset($error_messages)) echo $error_messages; 

	echo anchor("manage-tickets/$sort_by_dateop/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_date_ticket_opened')); //this represents one of the table header's
	echo "<br />";
	echo anchor("manage-tickets/$sort_by_status/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_status'));
	echo "<br />";
	echo anchor("manage-tickets/$sort_by_title/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_title'));
	echo "<br />";
	echo anchor("manage-tickets/$sort_by_datecl/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_date_closed'));
	echo "<br />";
	echo anchor("manage-tickets/$sort_by_lreply/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('manage_tickets_hdr_latest_reply'));
	echo "<br />";
	echo anchor("manage-tickets/$sort_by_act/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('manage_tickets_hdr_act'));
	
	echo "<br />";
	echo $this->lang->line('view_tickets_lbl_count').$posts['count'].'<br />';

	foreach ($posts['rows'] as $row)
	{
		$date_closed = ($row->date_closed != NULL) ? date('j M, Y', strtotime($row->date_closed)) : '---';
		$latest_reply = ($row->latest_reply != NULL) ? date('j M, Y', strtotime($row->latest_reply)) : '---';
		$title = ($row->is_replied != NULL) ? "<b>".$row->title."</b>" : $row->title;
		$is_active = ($row->is_ticket_active == '1') ? $this->lang->line('value_yes') : $this->lang->line('value_no');
		echo $this->lang->line('view_tickets_hdr_ticket_id').$row->ticket_id.' - '.$this->lang->line('manage_tickets_hdr_username').$row->username.' - '.$this->lang->line('view_tickets_hdr_title').anchor('admin-ticket/'.$row->ticket_id.'/'.url_title($row->title, '-', TRUE), $title).' - '.$this->lang->line('view_tickets_hdr_category').$row->category_name.' - '.$this->lang->line('view_tickets_hdr_priority').$row->priority_name.' - '.$this->lang->line('view_tickets_hdr_status').$row->status_name.' - '.$this->lang->line('view_tickets_hdr_date_ticket_opened').date('j M, Y', strtotime($row->date_created)).' - '.$this->lang->line('view_tickets_hdr_date_closed').$date_closed.' - '.$this->lang->line('manage_tickets_hdr_latest_reply').$latest_reply.' - '.$this->lang->line('manage_tickets_hdr_act').$is_active.'<br />';
	}
	
	echo $posts['pag_links'];
}