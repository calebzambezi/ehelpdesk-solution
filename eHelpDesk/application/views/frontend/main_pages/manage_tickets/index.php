
<?php  

if($posts['count'] == 0)
{
	echo $this->lang->line('view_tickets_msg_no_posts');
}
else
{
	echo get_temporary_msg(); 
	if(isset($error_messages)) echo $error_messages; 
}
?>

<div id="search-header">
<?php echo form_open($this->uri->uri_string(),'class="form-search pull-left"'); //START SEARCH ********* ?>

      <?php echo form_input('search_txt', set_value('search_txt', $this->session->userdata('searched_text')),'speech x-webkit-speech placeholder="'.$this->lang->line('view_tickets_lbl_search').'"').' '; 
            echo form_submit('search_submit', $this->lang->line('view_tickets_btn_find'), 'class="btn"'); ?>
<?php echo form_close(); //******** END SEARCH ?>
<?php
echo $posts['pag_links'];
?> 
<br class="clear"/>
</div>

<table class="table  table-bordered">
    <tr>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_ticket_id');?></th>
        <th class="span1"><?php echo $this->lang->line('manage_tickets_hdr_username');?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_title');?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_category');?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_priority');?></th>
        <th class="span1"><?php echo anchor("manage-tickets/$sort_by_status/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_status'));?></th>
        <th class="span1"><?php echo anchor("manage-tickets/$sort_by_date/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('view_tickets_hdr_date_ticket_opened'));?></th>
        <th class="span1"><?php echo $this->lang->line('view_tickets_hdr_date_closed');?></th>
        <th class="span1"><?php echo $this->lang->line('manage_tickets_hdr_latest_reply');?></th>
        <th class="span1"><?php echo $this->lang->line('manage_tickets_hdr_act');?></th>
    </tr>
    
    <?php foreach ($posts['rows'] as $row):
              $priority_style=($row->priority_name=='Low')?'':($row->priority_name=='High'?'label-important':'label-warning');   
        ?>
        <tr>
            <td><?php echo $row->ticket_id;?></td>
            <td><?php echo $row->username;?></td>
            <td><?php echo anchor('ticket/'.$row->ticket_id.'/'.url_title($row->title, '-', TRUE), $row->title);?></td>
            <td><?php echo $row->category_name;?></td>
            <td><span class="label <?php echo $priority_style;?>"><?php echo $row->priority_name;?></span></td>
            <td><?php echo $row->status_name;?></td>
            <td><?php echo date('j M, Y', strtotime($row->date_created));?></td>
            <td><?php echo $date_closed;?></td>
            <td><?php echo $latest_reply;?></td>
            <td><?php echo $is_active;?></td>
        </tr>
    <?php endforeach;?>
    </table>
    
    <?php
    echo $posts['pag_links'];
    ?> 