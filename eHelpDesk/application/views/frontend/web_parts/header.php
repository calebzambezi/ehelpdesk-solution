<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
  <div class="container">
    <?php echo  anchor('login', 'eHelpDesk',array('class'=>'brand'));?>
    <ul class="nav">
      <li><?php echo  anchor('login', 'Home');?></li>
      <li><?php echo  anchor('aboutus', $this->lang->line('footer_link_about'));?></li>
      <li><?php echo anchor('contactus',$this->lang->line('footer_link_contact'));?></li>
      
    </ul>
    <ul class="nav pull-right">
    <li>
        <?php

        echo form_open($this->uri->uri_string(),array('class'=>'navbar-form'));
        $lookup_list['en'] = 'English';
        $lookup_list['fr'] = 'French';
?>

<?php
echo form_dropdown('language_lookup', $lookup_list, $this->session->userdata('lang'),'class="span2"').' ';
echo form_submit('lang_submit', $this->lang->line('header_btn_select_lang'),'class="btn "');
echo form_close();
?>
      
      </li>
    <?php if($this->tank_auth->is_logged_in()):?>
    
    <li class="dropdown">
        <a href="#" class="navbar-link dropdown-toggle" data-toggle="dropdown"><?php echo ($this->tank_auth->is_logged_in())?$this->lang->line('header_lbl_welcome').$this->tank_auth->get_username():'';?>
        <b class="caret navbar-text"></b>
        </a>
          
  <ul class="dropdown-menu" role="menu" >
     <li><?php echo anchor('logout',$this->lang->line('header_link_logout')); ?></li>
      
  </ul>
    </li>    

<?php endif;?>
</ul>
    </div>
  </div>
</div>


    <?php

    //echo $this->lang->line('header_msg_greeting');
    if (!$this->tank_auth->is_logged_in()):?>
<div id="banner">
    <div class="container">
<?php
        //echo $this->lang->line('header_msg_greeting');
        echo ('<img src="'.base_url().'resources/banner.png" />');
    ?>
 </div>
    
</div>
<?php endif;?>
   

<div class="container" id="content" >










<?php $currentController=$this->uri->segment(1);
?>

<h4>
<div>   
    <?php echo form_close();
          if ($this->tank_auth->is_logged_in()) {
              //echo $this->lang->line('header_lbl_welcome').$this->tank_auth->get_username() ?>
              
          <ul class="nav nav-tabs">
            <li <?php echo ($currentController=='view-tickets'?'class="active"':'');?>>
                <?php echo anchor('view-tickets',$this->lang->line('header_link_my_tickets'));?>
            </li>            
            <li <?php echo ($currentController=='new-ticket'?'class="active"':'');?>>
                <?php echo anchor('new-ticket',$this->lang->line('header_link_open_new_tickets'));?>
            </li>
            <li <?php echo ($currentController=='account-settings'?'class="active"':'');?>>
                <?php echo anchor('account-settings',$this->lang->line('header_link_account_settings'));?>
            </li>
           
         
          <?php
                if($this->tank_auth->get_group_id() == '100' || $this->tank_auth->get_group_id() == '300') //$group_id is set in Frontend_Controller
                {
                    ?>
                    <li <?php echo ($currentController=='manage-tickets'?'class="active"':'');?>><?php echo anchor('manage-tickets',$this->lang->line('header_link_manage_tickets')); ?></li>
                    <li <?php echo ($currentController=='manage-users'?'class="active"':'');?>><?php echo anchor('manage-users',$this->lang->line('header_link_manage_users')); ?></li>
                    <?php
                }                    
          ?>
          </ul>
          <?php
          }
          else 
          {
          ?>
          <div class='center-text'>
          <?php
              echo $this->lang->line('header_msg_greeting');
              ?>
          </div>
          <?php
          }
          ?>         
          
</div>
</h4>