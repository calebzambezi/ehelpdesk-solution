<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*

What is Downalod controller? Whenever user downloads a file, redirect them to Download controller. The URL looks like: 

http://localhost/ehelpdesk/download/target_file_name.txt

Download controller is secured! User can not access it without logging in.

target_file_name.txt must given. Otherwise, user will be reidrected to default controller.

Download controller does not need a view page.

*/

class Download extends Secured_Frontend_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->helper('download'); //responsible for forcing downloads
	}

	public function index($filename = '') 
	{
		if($filename == '')
			redirect();
		
		//check if filename belongs to that particular user or not based on users_id. Alterntively, we can check wether file exists within the server or not: file_exists(ATTACHMENTS_FOLDER.'/fjamal/'.$filename)
		if (file_exists(ATTACHMENTS_FOLDER.'/'.$filename)) //or: if (file_exists(ATTACHMENTS_FOLDER.'/'.$this->tank_auth->get_user_id().'/'.$filename))
		{
			$data = file_get_contents(ATTACHMENTS_FOLDER.'/'.$filename); //or: $data = file_get_contents(ATTACHMENTS_FOLDER.'/'.$this->tank_auth->get_user_id().'/'.$filename); //If you want to download an existing file from your server you'll need to read the file into a string:

			force_download($filename, $data); //$filename represents the name of the file to be downloaded. Hence, you could name it anythin you like; i prefer to make the name identical to the originl file 
		}
		else //if file doesn't exist return user to the previous page, the one just before http://localhost/ehelpdesk/download/target_file_name.txt, and show the message 'File doesn't exist'. If no previous page exist, it means user tried to access the link directly by manual typing or copy/paste: http://localhost/ehelpdesk/download/target_file_name.txt. Thus, redirect user to default controller
		{
			//We can use php to get the last visited page url for a current web page. Server global variables in php provides this functionality. Any time we can get the url of the web site that requested the current page. This is known as referring site url. When you access a website directly by entering the url in the browser there will be no referring url. This is very useful to generate and identify the stats about visitors to your site. Use the code given below to track the last/previous visited url known as referring url. 
			if(isset($_SERVER['HTTP_REFERER']))
				set_temporary_msg($this->lang->line('download_error_no_file'), $_SERVER['HTTP_REFERER']);
			else
				redirect();
		}
	}
}