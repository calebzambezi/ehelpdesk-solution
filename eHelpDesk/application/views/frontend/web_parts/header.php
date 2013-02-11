<div class="navbar navbar-fixed-top navbar-inverse">
  <div class="navbar-inner">
  <div class="container">
    <?php echo  anchor('login', 'eHelpDesk',array('class'=>'brand'));?>
    <ul class="nav">
      <li><?php echo  anchor('login', 'Home');?></li>
      <li><?php echo  anchor('aboutus', $this->lang->line('footer_link_about'));?></li>
      <li><?php echo anchor('contactus',$this->lang->line('footer_link_contact'));?></li>
    </ul>
    </div>
  </div>
</div>

<div class="container">


<?php

echo form_open($this->uri->uri_string(),array('class'=>'form'));
	$lookup_list['en'] = 'English';
	$lookup_list['fr'] = 'French';
?>
<div class="control-group">
    <div class="controls">
<?php
	echo form_dropdown('language_lookup', $lookup_list, $this->session->userdata('lang'));
	echo form_submit('lang_submit', $this->lang->line('header_btn_select_lang'),'class="btn "');
?>
</div>
</div>



<div class="page-header">
<h1>
<?php
echo form_close();

if ($this->tank_auth->is_logged_in())
{
	echo $this->lang->line('header_lbl_welcome').$this->tank_auth->get_username().' | '.anchor('view-tickets', $this->lang->line('header_link_my_tickets')).' | '.anchor('new-ticket', $this->lang->line('header_link_open_new_tickets')).' | '.anchor('account-settings', $this->lang->line('header_link_account_settings')).' | '.anchor('logout', $this->lang->line('header_link_logout')).'<br /><br />';
	
	if($this->tank_auth->get_group_id() == '100' || $this->tank_auth->get_group_id() == '300') //$group_id is set in Frontend_Controller
	{
		echo $this->lang->line('header_lbl_admin_features').anchor('manage-tickets', $this->lang->line('header_link_manage_tickets')).' | '.anchor('manage-users', $this->lang->line('header_link_manage_users'));
	}
}
else
{
	//echo $this->lang->line('header_msg_greeting');
    echo ('<img src="'.base_url().'resources/banner.jpg" />');
}
?>
</h1>
</div>
<h4>
<div>   
    <?php echo form_close();
          if ($this->tank_auth->is_logged_in()) {
              echo $this->lang->line('header_lbl_welcome').$this->tank_auth->get_username() ?>
              
          <ul class="nav nav-tabs">
            <li><?php echo anchor('view-tickets',$this->lang->line('header_link_my_tickets'),array('data-toggle'=>'tab'));?></li>            
            <li><?php echo anchor('new-ticket',$this->lang->line('header_link_open_new_tickets'),array('data-toggle'=>'tab'));?></li>
            <li><?php echo anchor('account-settings',$this->lang->line('header_link_account_settings'),array('data-toggle'=>'tab'));?></li>
            <li><?php echo anchor('logout',$this->lang->line('header_link_logout'),array('data-toggle'=>'tab')); ?></li>
         
          <?php
                if($this->tank_auth->get_group_id() == '100' || $this->tank_auth->get_group_id() == '300') //$group_id is set in Frontend_Controller
                {
                    ?>
                    <li><?php echo anchor('manage-tickets',$this->lang->line('header_link_manage_tickets'),array('data-toggle'=>'tab')); ?></li>
                    <li><?php echo anchor('manage-users',$this->lang->line('header_link_manage_users'),array('data-toggle'=>'tab')); ?></li>
                    <?php
                }                    
          ?>
          </ul>
          <?php
          }
          else 
          {
              echo $this->lang->line('header_msg_greeting');
          }
          ?>         
          
</div>
</h4>