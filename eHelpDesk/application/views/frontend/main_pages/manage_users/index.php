<?php echo form_open($this->uri->uri_string(),'class="form-search"'); //START SEARCH ********* ?>

		<?php
			
        echo form_input('search_txt', set_value('search_txt', $this->session->userdata('searched_text')),'speech x-webkit-speech placeholder="'.$this->lang->line('view_users_lbl_search').'"'); 
		?>

		<?php echo form_submit('search_submit', $this->lang->line('manage_users_btn_find'),'class="btn"'); ?>

<?php echo form_close(); //******** END SEARCH ?>
<?php  
if($this->tank_auth->get_group_id() == '100')
{
	echo anchor('admin-add-user', $this->lang->line('admin_add_user_link')).'<br />';
}

if($posts['count'] == 0)
{
	echo $this->lang->line('manage_users_no_members');
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
    

    
    ?>
	
    <table class="table  table-bordered">
    <tr>
        <th class="span1"><?php echo $this->lang->line('manage_users_hdr_group_id');?></th>
        <th class="span1"><?php echo $this->lang->line('manage_users_hdr_user_id');?></th>
        <th class="span1"><?php echo $this->lang->line('manage_users_hdr_username');?></th>
        <th class="span1"><?php echo $this->lang->line('manage_users_hdr_email');?></th>
        <th class="span1"><?php echo anchor("manage-users/$sort_by_datec/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('manage_users_hdr_register_date'));?></th>        
        <th class="span1"><?php echo anchor("manage-users/$sort_by_dateu/$sort_order/$maintain_page_number".get_query_string(), $this->lang->line('manage_users_hdr_is_updat_date'));?></th>
        <th class="span1"><?php echo $this->lang->line('manage_users_hdr_is_active');?></th>        
    </tr>
    
    <?php foreach ($posts['rows'] as $row):
              $priority_style=($row->priority_name=='Low')?'':($row->priority_name=='High'?'label-important':'label-warning');   
        ?>
        <tr>
            <td><?php echo $row->group_id;?></td>
            <td><?php echo $row->id;?></td>
            <td><?php echo anchor('admin-edit-user/'.$row->id, $row->username);?></td>
            <td><?php echo $row->email;?></td>
            <td><?php echo date('j M, Y', strtotime($row->created));?></td>
            <td><?php echo date('j M, Y', strtotime($row->modified));?></td>            
            <td><?php echo $is_active;?></td>
        </tr>
    <?php endforeach;?>
    </table>
    
    
    <?php
	echo $posts['pag_links'];
}

?>