<?php

echo '<br />';
echo '<br />';
$login_link = (!$this->tank_auth->is_logged_in()) ? anchor('login', $this->lang->line('footer_link_login')).' *** ' : '';
echo 'Footer: '.$login_link.anchor('aboutus', $this->lang->line('footer_link_about')).' *** '.anchor('faq', $this->lang->line('footer_link_faq')).' *** '.anchor('contactus', $this->lang->line('footer_link_contact')).' *** '.anchor('privacy-policy', $this->lang->line('footer_link_privacy_policy')).' *** '.anchor('terms', $this->lang->line('footer_link_terms'));
?>
</div>