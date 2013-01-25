<?php	//Keep these two snippets wherever there is expetency of showing a message to user ?>
<?php  	echo get_temporary_msg(); //essentially it shows success message ?>
<?php  	if(isset($error_messages)) echo $error_messages; //it shows error message ?>
