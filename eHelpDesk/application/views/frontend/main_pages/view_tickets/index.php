<div>
<?php echo form_open($this->uri->uri_string(),'class="form-search"'); //START SEARCH ********* ?>
        
		<?php
            echo form_input('search_txt', set_value('search_txt', $this->session->userdata('searched_text')),('id="search_txt" speech x-webkit-speech placeholder="'.$this->lang->line('view_tickets_lbl_search').'"') ); 
		?>

		<?php echo form_submit('search_submit', $this->lang->line('view_tickets_btn_find'),'class="btn"'); ?>

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
	
	echo $this->lang->line('view_tickets_lbl_count').$posts['count'].'<br />';
    ?>
    <table class="table  table-bordered">
    <tr>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_ticket_id');?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_title');?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_category');?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_priority');?></th>
        <th class="span1"><?php echo anchor("view-tickets/$sort_by_status/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_status'));?></th>
        <th class="span1"><?php echo anchor("view-tickets/$sort_by_date/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_date_ticket_opened'));?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_date_closed');?></th>
    </tr>
<?php foreach ($posts['rows'] as $row):?>
	
		<?php 
            $date_closed = ($row->date_closed != NULL) ? date('j M, Y', strtotime($row->date_closed)) : '---';
            $priority_style=($row->priority_name=='Low')?'':($row->priority_name=='High'?'label-important':'label-warning');      
        ?>
        
        <tr>
            <td><?php echo $row->ticket_id;?></td>
            <td><?php echo anchor('ticket/'.$row->ticket_id.'/'.url_title($row->title, '-', TRUE), $row->title);?></td>
            <td><?php echo $row->category_name;?></td>
            <td><span class="label <?php echo $priority_style;?>"><?php echo $row->priority_name;?></span></td>
            <td><?php echo $row->status_name;?></td>
            <td><?php echo date('j M, Y', strtotime($row->date_created));?></td>
            <td><?php echo $date_closed;?></td>
        </tr>
        
<?php endforeach;?>
<?php	
	echo $posts['pag_links'];
}?>
    </table>
</div>