<?php



echo '<br />';
echo '<br />';
$login_link = (!$this->tank_auth->is_logged_in()) ? anchor('login', $this->lang->line('footer_link_login')).' *** ' : '';

?>
<footer class="center-text">
<hr/>
<ul class="inline">
<li><?php echo  anchor('aboutus', $this->lang->line('footer_link_about'));?></li>
<li><?php echo  anchor('faq', $this->lang->line('footer_link_faq'));?></li>
<li><?php echo  anchor('contactus', $this->lang->line('footer_link_contact'));?></li>
<li><?php echo  anchor('privacy-policy', $this->lang->line('footer_link_privacy_policy'));?></li> 
<li><?php echo  anchor('terms', $this->lang->line('footer_link_terms'));?></li>

</ul>
<p>&copy; 
<?php echo date('Y').' '.$this->lang->line('footer_copyrights');?>
</p>
</div>
</footer>