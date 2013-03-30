<?php 

echo get_temporary_msg(); 
if(isset($error_messages)) echo $error_messages; 
?>

<?php echo form_open('contactus','class="offset2 span7"'); ?>
        <div>
       <p>
          <?php
          echo $this->lang->line('contact_us_header_message')
          ?>
       </p>
         </div>
      <div class="control-group">
             
         <?php
         echo form_label($this->lang->line('contact_us_lbl_name'), 'contact_name');
         echo form_input('contact_name', set_value('contact_name'),'class="span6"'); ?>
      </div>
      <div class="control-group">
         <?php
         echo form_label($this->lang->line('contact_us_lbl_email'), 'contact_email');
         echo form_input('contact_email', set_value('contact_email'),'class="span6"'); ?>
      </div>
      <div class="control-group">
         <?php
         echo form_label($this->lang->line('contact_us_lbl_title'), 'contact_title');
         echo form_input('contact_title', set_value('contact_title'),'class="span6"'); ?>
      </div>
      <div class="control-group">
         <?php	
         echo form_label($this->lang->line('contact_us_lbl_message'), 'contact_message');
         echo form_textarea('contact_message', set_value('contact_message'),'class="span6"'); ?>
      </div>
      <div class="control-group">
         <?php echo form_submit('contact_submit', $this->lang->line('contact_us_btn_send'),'class="btn btn-primary"'); ?>
      </div>

<?php echo form_close(); ?>
<br class="clear"/>