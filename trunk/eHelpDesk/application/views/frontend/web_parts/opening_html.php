<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset='utf-8' /> 
	<meta name='keywords' content=<?php echo $this->lang->line('opening_html_page_keywords'); ?> />
	<meta name='description' content=<?php echo $this->lang->line('opening_html_page_description'); ?> />
	<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>" media="screen" />
	<script type="text/javascript" src="<?php echo JS_CKEDITOR; ?>"></script>
	<title><?php echo (isset($page_title) ? $page_title : $this->lang->line('header_page_default_title')); ?></title>
</head>
<body>
