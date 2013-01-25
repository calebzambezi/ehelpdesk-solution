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
	if(get_temporary_msg())
	{
		echo '<div class="success_msg_section">'.get_temporary_msg().'</div>'; 
	}
	
	if(isset($error_messages))
	{
		echo '<div class="error_msg_section">'.$error_messages.'</div>';
	}


	echo anchor("view-tickets/$sort_by_date/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_date_ticket_opened')); //this represents one of the table header's
	echo "<br />";
	echo anchor("view-tickets/$sort_by_status/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_status'));
	
	echo "<br />";
	echo $this->lang->line('view_tickets_lbl_count').$posts['count'].'<br />';

	foreach ($posts['rows'] as $row)
	{
		$date_closed = ($row->date_closed != NULL) ? date('j M, Y', strtotime($row->date_closed)) : '---';
		echo $this->lang->line('view_tickets_hdr_ticket_id').$row->ticket_id.' - '.$this->lang->line('view_tickets_hdr_title').anchor('ticket/'.$row->ticket_id.'/'.url_title($row->title, '-', TRUE), $row->title).' - '.$this->lang->line('view_tickets_hdr_category').$row->category_name.' - '.$this->lang->line('view_tickets_hdr_priority').$row->priority_name.' - '.$this->lang->line('view_tickets_hdr_status').$row->status_name.' - '.$this->lang->line('view_tickets_hdr_date_ticket_opened').date('j M, Y', strtotime($row->date_created)).' - '.$this->lang->line('view_tickets_hdr_date_closed').$date_closed.'<br />';
	}
	
	echo $posts['pag_links'];
}