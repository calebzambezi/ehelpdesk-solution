<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8' /> 
	<meta name='keywords' content=<?php echo $this->lang->line('opening_html_page_keywords'); ?> />
	<meta name='description' content=<?php echo $this->lang->line('opening_html_page_description'); ?> />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>resources/bootstrap/css/bootstrap.min.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>resources/css/style.css" media="screen" />
	<script type="text/javascript" src="<?php echo base_url();?>resources/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>resources/bootstrap/js/bootstrap.min.js"></script>        

	<title><?php echo (isset($page_title) ? $page_title : $this->lang->line('header_page_default_title')); ?></title>    
    <style type="text/css">
    body
        {
            background-image:url('<?php echo base_url();?>resources/repeat_texture.jpg');
        }
</style>
</head>
<body>

