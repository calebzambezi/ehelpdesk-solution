
<div class= "row-fluid">
    <div class="span8 offset2 well"> 
     <header class="page-header">
        <h2>Log in</h2>
     </header>
<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
    
);
if ($login_by_username AND $login_by_email) {
	$login_label = $this->lang->line('auth_login_lbl_username_or_email');
} else if ($login_by_username) {
	$login_label = $this->lang->line('auth_login_lbl_username');
} else {
	$login_label = $this->lang->line('auth_login_lbl_email');
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
    
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
    //'error'=>form_error('captcha','<div class="text-error">','</div>'),
);

$form_errors=array(
    'login'=>form_error('login','<div class="text-error">','</div>'),
    'password'=>form_error('password','<div class="text-error">','</div>'),
    'captcha'=>form_error('captcha','<div class="text-error">','</div>'),
    );

?>
<?php 
	if(get_temporary_msg())
	{
		echo '<div class="success_msg_section">'.get_temporary_msg().'</div>'; 
	}
?>
<?php echo form_open($this->uri->uri_string(),array('class'=>'form-horizontal')); ?>

       
	    <div class="control-group <?php echo ($form_errors[$login['name']]!=='')?'error':'' ?>">
		
        <?php echo form_label($login_label, $login['id'],array('class'=>'control-label')); ?> 
        <div class="controls">
		<?php echo form_input($login); ?>
		
        <?php echo $form_errors[$login['name']];?><?php echo isset($errors[$login['name']])?$errors[$login['name']]:''; ?>
        </div>        
	    </div>
	 
        <div class="control-group <?php echo ($form_errors[$password['name']]!=='')?'error':'' ?>">
		 <?php echo form_label($this->lang->line('auth_login_lbl_password'), $password['id'],array('class'=>'control-label')); ?>
         <div class="controls">
		 <?php echo form_password($password); ?>
		 <?php echo $form_errors[$password['name']] ?><?php echo isset($errors[$password['name']])?$errors[$password['name']]:''; ?>
         </div>
	    </div>

	<?php if ($show_captcha) {
		if ($use_recaptcha) { ?>
	 
		
			<div id="recaptcha_image"></div>
		
		 
			<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
			<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
			<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
		
	 
	 
		 
			<div class="recaptcha_only_if_image">Enter the words above</div>
			<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>
		
		 <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" />
		 <?php echo form_error('recaptcha_response_field'); ?>
		<?php echo $recaptcha_html; ?>
	 
	<?php } else { ?>
	 
		 
			<p>Enter the code exactly as it appears:</p>
			<?php echo $captcha_html; ?>
		
	 
	 
		 <?php echo form_label('Confirmation Code', $captcha['id']); ?>
		 <?php echo form_input($captcha); ?>
		 <?php echo form_error($captcha['name']); ?>
	 
	<?php }
	} ?>

	 <div class="controls">
		    <?php echo form_submit('submit', $this->lang->line('auth_login_btn_login'),'class ="btn btn-primary btn-large"'); ?> 
			<?php echo anchor('forgot-password', $this->lang->line('auth_login_link_forgot_password')); ?>
      </div>
      <div id="register-sec">
      <?php echo anchor('register', $this->lang->line('auth_login_link_register')); ?>
      </div>
<?php echo form_close(); ?>
    </div>
</div>