<?php 

	if(get_temporary_msg())
	{
		echo '<div class="success_msg_section">'.get_temporary_msg().'</div>'; 
	}
    
    //show ticked content
    $date_closed = ($post['rows'][0]->date_closed != NULL) ? date('j M, Y', strtotime($post['rows'][0]->date_closed)) : '---'; //format date if exist
    $date_updated = ($post['rows'][0]->date_updated != NULL) ? date('j M, Y', strtotime($post['rows'][0]->date_updated)) : '---';
?>


<fieldset>
<legend><?php echo $post['rows'][0]->title.' ',$this->lang->line('view_tickets_tbl_lb_info');?>
        </legend>


<?php if(!$is_stuff_replied && $post['rows'][0]->status_name != 'Closed') //if one of the stuff replied and post is closed, don't allow editing. In other words, if no stuff has replied and ticket is not closed yet, allow editing. Note: if first condition failed, second condition will be ignored because we are using AND.
          echo anchor('edit-ticket/'.$post['rows'][0]->ticket_id, $this->lang->line('ticket_link_edit'),'class="btn btn-primary"').'<br/><br/>';
?>

<?php $priority_style=($post['rows'][0]->priority_name=='Low')?'':($post['rows'][0]->priority_name=='High'?'label-important':'label-warning'); ?>

     <table class="table table-bordered">
        <tr>
            <th class="span2"><?php echo $this->lang->line('ticket_lbl_ticket_id'); ?></th>
            <td><?php echo $post['rows'][0]->ticket_id; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_title'); ?></th>
            <td><?php echo $post['rows'][0]->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_username'); ?></th>
            <td><?php echo $post['rows'][0]->username; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_date_created'); ?></th>
            <td><?php echo date('j M, Y', strtotime($post['rows'][0]->date_created)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_date_updated'); ?></th>
            <td><?php echo $date_updated;?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_date_closed'); ?></th>
            <td><?php echo $date_closed; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_category'); ?></th>
            <td><?php echo $post['rows'][0]->category_name; ?></td>
        </tr>
         <tr>
            <th><?php echo $this->lang->line('ticket_lbl_priority'); ?></th>
            <td><span class="label <?php echo $priority_style;?>"><?php echo $post['rows'][0]->priority_name; ?></span></td>   
        </tr>
         <tr>
            <th><?php echo $this->lang->line('ticket_lbl_status'); ?></th>
            <td><?php echo $post['rows'][0]->status_name; ?></td>
        </tr>
         
        <tr>
            <th><?php echo $this->lang->line('ticket_lbl_message'); ?></th>
            <td><?php echo $post['rows'][0]->message; ?></td>
        </tr>     
     </table>
<?php
echo $post['rows'][0]->attachment ? $this->lang->line('ticket_lbl_attachment').anchor('download/'.$post['rows'][0]->attachment, $post['rows'][0]->attachment).'<br />' : '';

?>
</fieldset>
    
<div id="reply-sec"> 
<fieldset>
<legend><?php echo $this->lang->line('view_tickets_lb_reply');?></legend>
 
<?php
//reply sections

if($replies['count'] > 0)
{
	echo $this->lang->line('ticket_lbl_count_replies').$replies['count'].'<br />';
    ?>

    <div class="replies">
    <?php foreach ($replies['rows'] as $row):?>
        <div class="media">
            <div class="media-body well well-small">
                <div class="media-heading"> 
                    <b><?php echo $row->username;?> @ <?php echo date('j M h:i:s A, Y', strtotime($row->date_created));?></b>
                    <span class="pull-right">
                        <?php echo $this->lang->line('ticket_replies_hdr_attachment').':';?>
                        <?php echo($row->attachment != NULL) ? anchor('download/'.$row->attachment, $row->attachment) : 'N/A';?>
                    </span>
                </div>
                
                <div class="replies-msg">
                <?php echo $row->reply_text;?>
                </div>
                
            </div>
        </div>
      <?php  endforeach; ?>
    </div>
    
    <?php
    echo $replies['pag_links'];
    ?>
    <br class="clear"/>
    <?php
}
?>
</fieldset>
    </div>
<?php 

//if ticket is closed, don't show reply box
if($post['rows'][0]->status_name != 'Closed')
{
?>
   
        <h4>
            <?php echo $this->lang->line('view_tickets_lb_add_reply');?>
        </h4>
    
    
	<?php if(isset($error_messages)) echo $error_messages.'<br /><br />'; 

	echo form_open_multipart($this->uri->uri_string()); ?>
    <div class="control-group"> 

			<?php	
				echo form_textarea('reply_message', set_value('reply_message'),'class="span6"');			
    			?>
    </div>
    <div class="control-group">     
			<?php
				echo form_label($this->lang->line('ticket_lbl_attachment'), 'reply_ticket_attachment');
				echo form_upload('reply_attachment'); 
			?>
    </div>
    <div class="control-group">
			<?php echo form_submit('ticket_reply_submit', $this->lang->line('ticket_btn_reply'), 'class="btn"'); ?>
    </div>
    
	<?php echo form_close();
} //end of if($post['rows'][0]->status_name != 'Closed') ?>
