<?php

//********** FLASHDATA (BEGIN) **********

function set_temporary_msg($msg, $target_location = '', $form_fields = '')
{

	$CI =& get_instance();
	$CI->session->set_flashdata('temp_msg', $msg);

	if($form_fields != '')
	{
		foreach($form_fields as $name => $value)
		{
			$CI->session->set_flashdata($name, $value); 
			if(is_array($value))
				maintain_mulivalue_elements($name, $value); 
		}
	}
	
	redirect($target_location);
}

function get_temporary_msg() 
{
	$CI =& get_instance();
	echo $CI->session->flashdata('temp_msg');
}

function maintain_mulivalue_elements($field_name, $value)
{
	$CI =& get_instance();
	foreach($value as $key => $v)
	{
		$CI->session->set_flashdata($field_name.'['.$v.']', $v); 
	}
}

function keep_value($field_name, $default = '')
{
	$CI =& get_instance();
	return $CI->session->flashdata($field_name) ? $CI->session->flashdata($field_name) : $default;
}

function keep_multivalue($field_name, $value, $selection_attribute) 
{
	$CI =& get_instance();	
	return ($CI->session->flashdata($field_name) == $value) ?  $selection_attribute : '';
}

//********** FLASHDATA (END) **********

//********** UPLOAD IMAGE/FILE (BEGIN) **********

function upload_image($field_name = 'post_image_original', $allowed_types = 'gif|jpg|png', $max_size = '2048', $max_width = '2000', $max_height = '2000', $thumb_width = 150, $thumb_height = 100)
{
	$CI =& get_instance();

	//setup image config
	$config['upload_path'] = ATTACHMENTS_FOLDER; //or: ATTACHMENTS_FOLDER.'/'.$CI->tank_auth->get_user_id();
	$config['allowed_types'] = $allowed_types;
	$config['max_size']	= $max_size; //2048 KB is equivelant to 2 MB
	$config['max_width']  = $max_width;
	$config['max_height']  = $max_height;
	$CI->load->library('upload', $config);

	//confirm that file name does not have disallowed characters. If user uploads a file name with disallowed characters,
	//he won't be able to download the file. Everytime user tries to download it, will see the error page: The URI you submitted 
	//has disallowed characters. Therefore, i need to make sure file names does not violate the $config['permitted_uri_chars'] prior
	//uploading it to the server
	if(!preg_match('/^[a-zA-Z0-9._-]+$/', $_FILES[$field_name]['name']))
	{
		return '<div '.CSS_CLASS_ERROR.'>File name can only contain "a-z", "A-Z", "0-9", "-", "_", and "."</div>';
	}
	
	//upload image
	if(strlen($_FILES[$field_name]['name']) <= MAX_FILENAME_LENGTH) //since form validation does not handle Upload componenet, i had to check the chars manually. Why? attachment field in DB has char(30) so file name shouldn't exceed 30. Otherwise, record will be inserted successfully while attachment file is inserted as NULL without any notification is given
	{
		if (!$CI->upload->do_upload($field_name))
		{
			return $CI->upload->display_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}
	}
	else
	{
		return '<div '.CSS_CLASS_ERROR.'>Max file name characters including extension should not exceed '.MAX_FILENAME_LENGTH.' characters.</div>';
	}

	//Once image is uploaded, setup thumbnail config
	$image_data = $CI->upload->data();
	$config = array(
		'image_library' => 'gd2',
		'source_image' => $image_data['full_path'], 
		'new_image' => $image_data['file_path'].'thumbs/', 
		'create_thumb' => TRUE,
		'maintain_ration' => TRUE, 
		'width' => $thumb_width,
		'height' => $thumb_height
	);
	
	$CI->load->library('image_lib', $config);
	
	//upload thumbnail
	$CI->image_lib->resize(); 
	
	//return uploaded image file name and its thumbnail name
	$arr['image_name'] = $image_data['file_name'];
	$arr['thumb_name'] = $image_data['raw_name'].'_thumb'.$image_data['file_ext'];

	return $arr;
}

function upload_file($field_name, $allowed_types = 'gif|jpg|png|xls|doc|docx|txt|pdf', $max_size = '2048')
{
	$CI =& get_instance();

	//setup file config
	$config['upload_path'] = ATTACHMENTS_FOLDER; //or: ATTACHMENTS_FOLDER.'/'.$CI->tank_auth->get_user_id(); 
	$config['allowed_types'] = $allowed_types;
	$config['max_size']	= $max_size; //2048 KB is equivelant to 2 MB
	$CI->load->library('upload', $config);
 
	//confirm file name does not contain disallowed characters
	if(!preg_match('/^[a-zA-Z0-9._-]+$/', $_FILES[$field_name]['name']))
	{
		return '<div '.CSS_CLASS_ERROR.'>File name can only contain "a-z", "A-Z", "0-9", "-", "_", and "."</div>';
	}

	//upload file
	if(strlen($_FILES[$field_name]['name']) <= MAX_FILENAME_LENGTH) //since form validation does not handle Upload componenet, i had to check the chars manually. Why? attachment field in DB has char(30) so file name shouldn't exceed 30. Otherwise, record will be inserted successfully while attachment file is inserted as NULL without any notification is given
	{
		if (!$CI->upload->do_upload($field_name))
		{
			return $CI->upload->display_errors('<div '.CSS_CLASS_ERROR.'>', '</div>');
		}
	}
	else
	{
		return '<div '.CSS_CLASS_ERROR.'>Max file name characters including extension should not exceed '.MAX_FILENAME_LENGTH.' characters.</div>';
	}
	
	//return uploaded file name
	$attachment_data = $CI->upload->data();
	$arr['file_name'] = $attachment_data['file_name'];
	
	return $arr;
}

//********** UPLOAD IMAGE/FILE (END) **********

//********** HOSOUB CAPTCHA (BEGIN) **********

function view_captcha($key, $lang = 'ar', $background = '#ffffff', $border = '#c5dbec') 
{
		return "
		<script type='text/javascript'>
			hcaptcha_options = {language: '$lang', key: '$key', background: '$background', border: '$border'};
		</script>
		<script type='text/javascript' src='https://captcha.hsoub.com/hcaptcha.js'></script>
		";
}

function validate_captcha($hcaptcha_input, $captcha_challenge, $captcha_key, $captcha_lang) 
{	
	$url = "http://captcha.hsoub.com/api/$captcha_lang/verify?key=$captcha_key&input=$hcaptcha_input&challenge=$captcha_challenge"; 
	$request = curl_init($url);
	curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($request); 
	curl_close($request);

	return $response; //true: success. false: wrong input; try again
}

//********** HOSOUB CAPTCHA (END) **********

//********** EMAIL (BEGIN) **********

function send_email($from_email, $from_name, $replyto_email, $replyto_name, $to_email, $subject, $msg, $attachment_path = NULL) 
{	
	$CI =& get_instance();
	$CI->load->library('email');
	$CI->email->from($from_email, $from_name);
	$CI->email->reply_to($replyto_email, $replyto_name);
	$CI->email->to($to_email);
	$CI->email->subject($subject);
	$CI->email->message($msg);

	if($attachment_path) 
	{
	
		$file = $SERVER_ROOT . $attachment_path; //Path sample: 'ci_centric/attachment/welcome.pdf';
		$CI->email->attach($file);
		
	}

	if($CI->email->send()) 
	{
		return true;
	}
	else
	{
		return false;
	}
}

//********** EMAIL (END) **********

//********** CKEDITOR (BEGIN) **********

function view_ckeditor($textarea_id, $toolbar_type = 'basic', $language = 'en') 
{
	return "	
		<script type='text/javascript'>
			CKEDITOR.replace( '".$textarea_id."',
				{
					toolbar:'".$toolbar_type."',
					language:'".$language."'
				});
				
		</script>
	";
}
	
//********** CKEDITOR (END) **********

//********** MENUS (BEGIN) **********

function show_menu() 
{
	$CI =& get_instance();
	$CI->load->model('menu_model');
	
	$menu_list = array();
	$menu = array();
	
	$menu_list = $CI->menu_model->read('menu_id, menu_name, parent_id');
	foreach($menu_list['rows'] as $value) 
	{
		$menu[] = Array('menu_id'=>$value->menu_id, 'menu_name'=>$value->menu_name, 'parent_id'=>$value->parent_id);
    }

	return treemenu($menu);
}

function treemenu($menu_array, $parent=0) 
{
    echo "<ul>";
    foreach ($menu_array as $row) 
	{
        if ($row['parent_id'] == $parent) 
		{
            echo "<li>".$row['menu_name']."";
            treemenu($menu_array, $row['menu_id']);
            echo "</li>";
		}   
	}
    echo "</ul>";
}

//********** MENUS (END) **********

//********** ERROR PAGE (BEGIN) **********

function view_404() 
{
	$CI =& get_instance();
	$CI->output->set_status_header('404');
	$data['main_page'] = 'custom404/index';
	$data['page_title'] = $CI->lang->line('custom404_page_title');
	$CI->load->view(FRONTEND_SKELETON, $data);
}

//********** ERROR PAGE (END) **********

//********** TANK AUTH HELPERS (START) **********

function require_login($target = 'login') 
{
	$CI =& get_instance();
	if (!$CI->tank_auth->is_logged_in())
		redirect($target); //Original route of login is: /auth/login/ ... auth is controller and login is method
}

function access_is_only_for($group_ids, $target = '') 
{
	$CI =& get_instance();
	$group_id = $CI->tank_auth->get_group_id(); 

	if(!in_array($group_id, $group_ids)) 
	{
		//set_temporary_msg('<div '.CSS_CLASS_ERROR.'>You are not allowed to access the page! Don\'t mess things up...</div>', $target);
		set_temporary_msg('', $target);
	}
}

//********** TANK AUTH HELPERS (END) **********

//********** GRAB QUERY STRING (START) **********

function get_query_string()
{
	if($_SERVER['QUERY_STRING'])
		return '?'.$_SERVER['QUERY_STRING'];
	else
		return '';
}

//********** GRAB QUERY STRING (END) **********

//**************** SOCIAL MEDIA SECTION - START ***************

//**************** FACEBOOK - START **************

//Source: http://developers.facebook.com/docs/plugins/

function facebook_js() //Include the ýJavaScript SDKý on your page once, ideally right after the opening ý<body>ý tag.
{
	return '
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, \'script\', \'facebook-jssdk\'));</script>
	';
}

function facebook_like_box($website, $box_width = 292, $show_faces = true, $data_stram = false, $data_header = false)
{
	return '<div class="fb-like-box" data-href="'.$website.'" data-width="'.$box_width.'" data-show-faces="'.$show_faces.'" data-stream="'.$data_stram.'" data-header="'.$data_header.'"></div>';
}

function facebook_like_button($website, $area_width = 100, $show_faces = true, $send_button = true, $data_font = 'arial', $button_type = 'button_count')
{
	return '<div class="fb-like" data-href="'.$website.'" data-send="'.$send_button.'" data-layout="'.$button_type.'" data-width="'.$area_width.'" data-show-faces="'.$show_faces.'" data-font="'.$data_font.'"></div>';
}

//**************** FACEBOOK - END **************

//**************** TWITTER- START **************

//Source: https://dev.twitter.com/docs/tweet-button

//Tweet Button will use the URL of the current webpage and the content of the <title> element as the text of the Tweet; javascript included
function twitter_tweet_button()
{
	return 
	'<a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="en">Tweet</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	';
}

//**************** TWITTER- END **************
	
//**************** SOCIAL MEDIA SECTION - END ***************

//************** PERSONAL PAGINATION *************

//Tutorial: http://www.youtube.com/watch?v=8BxlBlHhU_4

/*
	Why? This allows us to have multiple pagination within a signle page. This function returns records and tacks a query string to
	whatever existing link we have. Thus, we could have www.example.com/home/4?side=5 whereas 4 is codeigniter pagination and 5 is the
	pagination of the secondary list records that is somewhere at the side of the page. Refer to Supporting snippet folder, to see how
	to implement it.

*/
/*
	$per_page: number of records per page
	$columns: specify columns of the returned records
	$table: table name
	$where: filter returned records - OPTIONAL
	$key: the value that you represents the element e.g. <.... value='5'>TITLE!</..> 5 is the key
	$value: TITLE! is the value
	$get_var: query string variable ?p=## whereas p represents the get_var
	
	Return values: array of rows and page_links
	
	NOTE: key and value have to be exist in columns parameter.
	
	Sample:
	side_pagin(10, 'question_id, title, start_date, date_updated', 'question', 'is_active = 1 AND is_running = 0', 'question_id', 'title', 'p');
*/
function side_pagin($per_page, $columns, $table, $where = '', $key, $value, $get_var)
{
	$arr = array();
	
	if(!isset($_GET["$get_var"]))
		$page = 1;
	else
		$page = (int)$_GET["$get_var"];
	
	$records_at_page = $per_page;
	
	$where = ($where != '') ? "WHERE $where" : '';
	
	$q = mysql_query("SELECT * FROM $table ".$where);
	$records_count = @mysql_num_rows($q);
	@mysql_free_result($q);
	
	$pages_count = (int)ceil(($records_count) / $records_at_page);
	if(($page > $pages_count) || ($page <= 0))
	{
		$page = $pages_count;
	}
	
	$start = ($page - 1) * $records_at_page;
	$end = $records_at_page;
	
	if($records_count != 0)
	{
		$q = mysql_query("SELECT $columns FROM $table $where LIMIT $start, $end");
		while($o = mysql_fetch_object($q))
		{
			$arr['rows'][$o->$key] = $o->$value.'<br />';
		}
	}
	else
	{
		$arr['rows'] = FALSE;
	}
	
	echo '<br />';
	
	$next = $page + 1;
	$prev = $page - 1;
	$pl = '';
	if($next <= $pages_count)
		$pl .= "<a href='?$get_var=$next'>>></a>";
		
	for($i = 1; $i <= $pages_count; $i++)
	{
		if($page == $i)
			$pl .= $page;
		else
			$pl .= "<a href='?$get_var=$i'>$i</a>";
		
		if($i != $pages_count)
			$pl .= '-';
	}
	
	if($prev > 0)
		$pl .= "<a href='?$get_var=$prev'><<</a>";
	
	$arr['page_links'] = $pl;
	
	return $arr;
}

//************************ FIND COLUMN TO BE SORTED (START) **********
/*
THIS HAS TO BE COPIED AND PASTED WITHIN THE CONTROLLER. Dont call it from here because
there are some parts in function are easier to be hardcoded. Look
at "Sample Codes.php" for further info: ABOUT FIND SORT COLUMN.

	private function _find_sort_column($selected_table_column)
	{
		$sort_columns = array("date_created" => "dateop", "status_id" => "status"); //*** THATS THE ONLY PART NEED TO BE CHANGED BY LIST OF COLUMNS TO BE SORTED ****
		$sort_by = array_search($selected_table_column, $sort_columns); //returns key i.e. status_id or date_created. If none, false is returned
		$key = (!$sort_by) ? 'date_created' : $sort_by; //date_created is the defaultcolumn
		return $key; //will be either status_id or date_created
	}

*/
//********************** FIND COLUMN TO BE SORTED (END) **********


//************************* HANDLE FILES ***************************

//**** DELETE FILE

/** SAMPLE:

	private function _delete_attachment($p_id, $file_name)
	{
		$deletion_status = delete_file(ATTACHMENTS_FOLDER.'/'.$this->tank_auth->get_user_id().'/'.$file_name);
		if($deletion_status == 'true' || $deletion_status == 'no file') //if file doesn't exist in db (probably because it was deleted already but file name not yet removed from db), remove the name from db. 
		{
			//delete from the DB
			$data['effected_rows'] = $this->ticket_model->update("ticket_id = $p_id AND users_id = ".$this->tank_auth->get_user_id(), array('attachment' => NULL));
			if($data['effected_rows'])
				set_temporary_msg('', $this->uri->uri_string());
			else
				return '<div '.CSS_CLASS_ERROR.'>Temporary issue is encountered. Please press delete button again. If problem persists, contact us.</div>';
		}
		else
		{
			return '<div '.CSS_CLASS_ERROR.'>Attachment could not be deleted. Please contact us.</div>'; 
		}
	}
	
**/
function delete_file($path)
{
	if (file_exists($path))
	{
		if(unlink($path))
		{
			return "true"; //deleted successfully
		}
		else
		{
			return "false"; //failed to delete due to privilages issues or so
		}
	}
	else
	{
		return "no file"; //file doesn't exist in the server anymore. It was already deleted but file name is not yet deleted from db.
	}
}

//*********** VALIDATE SELECTED TRNALSATION LANGUAGE ************

function is_selected_lang_valid($selected_lang)
{
	$language_list = array("en", "fr");
	return in_array($selected_lang, $language_list); //returns true if selected_lang exists in language_list
}
	
/* End of general_helper.php */
