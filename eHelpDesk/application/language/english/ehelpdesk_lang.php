<?php
//Personal preceeding convensions for $lang are:
//	msg, hdr, lbl, btn, link, error, success, page, and content
//***Explanation:
//msg: short message is shown to user such as "no posts found!"
//hdr: table header
//lbl: label
//btn: button
//link: hyperlink
//error: error message
//success: success message
//page: a text to be displayed in all pages such as default title, meta keywords, meta description and the like
//content: a content of a fixed page including its HTML tags, e.g. about us content, faq content, etc. NOTE: we could store these contents in DB rather than in $lang file.

//****** GLOBAL VALUES *********

$lang['value_yes'] = 'Yes ';
$lang['value_no'] = 'No ';

//****** HEADER - START: ****** 

$lang['header_lbl_welcome'] = 'Welcome ';
$lang['header_link_my_tickets'] = 'My Tickets';
$lang['header_link_open_new_tickets'] = 'Open New Ticket';
$lang['header_link_account_settings'] = 'Account Settings';
$lang['header_link_logout'] = 'Logout';
$lang['header_msg_greeting'] = 'Welcome to GMA Techs Ticketing System';
$lang['header_btn_select_lang'] = 'Change';

//*** ADD ADMIN LABEL - JAN 12
$lang['header_lbl_admin_features'] = 'Administration Features: ';
$lang['header_link_manage_tickets'] = 'Manage Tickets';
$lang['header_link_manage_users'] = 'Manage Users';

//****** HEADER - END ****** 

//****** OPENING HTML - START: ****** 

$lang['header_page_default_title'] = SITE_NAME.' - GMA Techs Support Ticket System'; //NOTE: "header_page_default_title" SUPPOSE TO BE "opening_html_page_default_title" i didn't change it because i will have to go back to controllers and views and change the name to "opening_html_page_default_title"
$lang['opening_html_page_keywords'] = "'register,html,css,course,web development,first project'";
$lang['opening_html_page_description'] = "'the first xhml/css project'";

//****** OPENING HTML - END ****** 

//****** FOOTER - START: ****** 

$lang['footer_link_login'] = 'Login';
$lang['footer_link_about'] = 'About Us';
$lang['footer_link_contact'] = 'Contact Us';
$lang['footer_link_faq'] = 'FAQ';
$lang['footer_link_privacy_policy'] = 'Privacy Policy';
$lang['footer_link_terms'] = 'Terms and Conditions';
$lang['footer_copyrights'] = 'GMA tech Inc. All rights reserved. Powered by eHelpDesk from XP tech Inc.';

//****** FOOTER - END ****** 

//about_us controller
$lang['about_us_content_main_content'] = '<p>Learn more about TicTalk</p>';

//contact_us controller
$lang['contact_us_lbl_name'] = 'Name ';
$lang['contact_us_lbl_email'] = 'Email ';
$lang['contact_us_lbl_title'] = 'Title ';
$lang['contact_us_lbl_message'] = 'Message ';
$lang['contact_us_header_message'] = 'If you have business inquiries or other questions, please fill out the following form to contact us. Thank you. ';
$lang['contact_us_btn_send'] = 'Send';
$lang['contact_us_success_message_sent'] = '<div '.CSS_CLASS_SUCCESS.'>Thanks for contacting us. Expect to hear from us within 48 hours</div>';
$lang['contact_us_error_message_failed'] = '<div '.CSS_CLASS_ERROR.'>Email was not sent successfully. We probably have a temporary technical issue. Please try again</div>';

//faq controller
$lang['faq_content_main_content'] = '<p>Frequently asked questions</p>';

//privacy_policy controller
$lang['privacy_policy_page_title'] = SITE_NAME.' - Privacy Policy';
$lang['privacy_policy_content_main_content'] = 

"<h1>Privacy Policy</h1>
<p>Yes! Where are you? Where have you been?</p>
<p>Din't you see me?</p>";

//terms controller
$lang['terms_page_title'] = SITE_NAME.' - Terms and Conditions';
$lang['terms_content_main_content'] = '<p>About terms and conditions</p>';

//custom404 controller
$lang['custom404_page_title'] = SITE_NAME.' - Ops! 404 Page Not Found';
$lang['custom404_msg_wisdom'] = "If You Do Not Know Where You Are Going, Any Road Will Take You There!";
$lang['custom404_msg_404'] = 'Page Not Found 404'; 

//new_ticket controller
$lang['new_ticket_page_title'] = SITE_NAME.' - Post New Ticket';
$lang['new_ticket_lbl_priority'] = 'Priority ';
$lang['new_ticket_lbl_category'] = 'Category ';
$lang['new_ticket_lbl_title'] = 'Title';
$lang['new_ticket_lbl_question'] = 'Question ';
$lang['new_ticket_lbl_attach'] = 'Attachment ';
$lang['new_ticket_btn_post'] = 'Post';
$lang['new_ticket_error_ticket_failed'] = '<div '.CSS_CLASS_ERROR.'>Problem occured; please re-post your ticket. If problem persists, contact us.</div>';
$lang['new_ticket_success_ticket_posted'] = '<div '.CSS_CLASS_SUCCESS.'>Your ticket is posted successfully.</div>';

//view_tickets and manage_tickets controller
$lang['view_tickets_page_title'] = SITE_NAME.' - View Your Tickets';
$lang['view_tickets_lbl_count'] = 'Total Tickets: ';
$lang['view_tickets_lbl_search'] = 'Search Tickets';
$lang['view_users_lbl_search'] = 'Search Users';

$lang['view_tickets_tbl_lb_info'] = 'Ticket Details:';
$lang['view_tickets_lb_reply'] = 'Reply:';
$lang['view_tickets_lb_add_reply'] = 'Add Reply:';

$lang['view_tickets_btn_find'] = 'Find ';
$lang['view_tickets_msg_no_posts'] = 'No Posts Found!';
$lang['view_tickets_hdr_priority'] = 'Priority ';
$lang['view_tickets_hdr_date_ticket_opened'] = 'Date Opened: ';
$lang['view_tickets_hdr_status'] = 'Status: ';
$lang['view_tickets_hdr_ticket_id'] = 'Ticket ID: ';
$lang['view_tickets_hdr_title'] = 'Title: ';
$lang['view_tickets_hdr_category'] = 'Category: ';
$lang['view_tickets_hdr_date_closed'] = 'Date Closed: ';
$lang['manage_tickets_hdr_latest_reply'] = 'Latest Reply: ';
$lang['manage_tickets_hdr_is_active'] = 'Is Active ';
$lang['manage_tickets_hdr_act'] = 'Act ';
$lang['manage_tickets_hdr_username'] = 'Username ';

//reply section
$lang['ticket_replies_hdr_id'] = 'Reply ID ';
$lang['ticket_replies_hdr_message'] = 'Reply Message ';
$lang['ticket_replies_hdr_attachment'] = 'Attachment ';

//manage_users controller
$lang['manage_users_hdr_user_id'] = 'User ID ';
$lang['manage_users_hdr_username'] = 'Username ';
$lang['manage_users_hdr_email'] = 'Email ';
$lang['manage_users_hdr_group_id'] = 'Group ID ';
$lang['manage_users_hdr_is_active'] = 'Is Active ';
$lang['manage_users_hdr_register_date'] = 'Register Date ';
$lang['manage_users_hdr_is_updat_date'] = 'Update Date ';
$lang['manage_users_lbl_count'] = 'Total Users';
$lang['manage_users_no_members'] = 'No results found';
$lang['manage_users_btn_find'] = 'Find';
$lang['manage_users_lbl_search'] = 'Search';

//account_settings controller
$lang['account_settings_page_title'] = SITE_NAME.' - Account Settings';
$lang['account_settings_lbl_user_id'] = 'User ID: ';
$lang['account_settings_lbl_username'] = 'Username: ';
$lang['account_settings_lbl_current_email'] = 'Current Email: ';
$lang['account_settings_lbl_new_email'] = 'New Email (Optional): ';
$lang['account_settings_lbl_new_password'] = 'New Password: ';
$lang['account_settings_lbl_confirm_new_password'] = 'Confirm New Password: ';
$lang['account_settings_lbl_notify'] = 'Notify me by email whenever i get a reply';
$lang['account_settings_lbl_old_password'] = 'Old Password: ';
$lang['account_settings_btn_update'] = 'Update Settings';
$lang['account_settings_error_email_exists'] = '<div '.CSS_CLASS_ERROR.'>Email already exists within the system. Please pick another email.</div>';
$lang['account_settings_success_update_succeded'] = 'Your account is updated successfully :)';
$lang['account_settings_error_update_failed'] = '<div '.CSS_CLASS_SUCCESS.'>No update took place because you did not make any changes.</div>';
$lang['account_settings_error_invalid_password'] = '<div '.CSS_CLASS_ERROR.'>Invalid current password. Please insert a correct password</div>';

//****** auth controller ($langs are called in "auth" views such as login.php, forgot-password.php, etc) - START: *******

//*** called in login.php
$lang['auth_login_lbl_username_or_email'] = 'Email or Username';
$lang['auth_login_lbl_username'] = 'Username';
$lang['auth_login_lbl_email'] = 'Email';
$lang['auth_login_lbl_password'] = 'Password';
$lang['auth_login_lbl_remember_me'] = 'Remember me';
$lang['auth_login_link_forgot_password'] = 'Forgot password';
$lang['auth_login_link_register'] = 'Don\'t have an account yet? Sign up here!';
$lang['auth_login_btn_login'] = 'Login';

//*** forgot_password.php
$lang['auth_forgot_password_lbl_username_or_email'] = 'Email or Username';
$lang['auth_forgot_password_lbl_email'] = 'Email';
$lang['auth_forgot_password_btn_get_password'] = 'Get a new password';

//*** register.php
$lang['auth_register_lbl_username'] = 'Username';
$lang['auth_register_lbl_email'] = 'Email';
$lang['auth_register_lbl_password'] = 'Password';
$lang['auth_register_lbl_confirm_password'] = 'Confirm Password';
$lang['auth_register_btn_register'] = 'Register';
$lang['auth_register_link_privacy_policy'] = 'Privacy Policy';

//****** auth controller ($langs are called in "auth" views such as login.php, forgot-password.php, etc) - END *******

//ticket controller
$lang['ticket_page_title'] = SITE_NAME.' - ';
$lang['ticket_lbl_status'] = 'Status ';
$lang['ticket_btn_update'] = 'Update';
$lang['ticket_lbl_ticket_id'] = 'Ticket ID ';
$lang['ticket_lbl_username'] = 'Username ';
$lang['ticket_lbl_date_created'] = 'Date Created ';
$lang['ticket_lbl_date_updated'] = 'Date Updated ';
$lang['ticket_lbl_date_closed'] = 'Date Closed ';
$lang['ticket_lbl_category'] = 'Category ';
$lang['ticket_lbl_priority'] = 'Priority ';
$lang['ticket_lbl_title'] = 'Title ';
$lang['ticket_lbl_message'] = 'Message ';
$lang['ticket_lbl_attachment'] = 'Attachment ';
$lang['ticket_link_edit'] = 'Edit ';
$lang['ticket_lbl_count_replies'] = 'Total Replies ';
$lang['ticket_btn_reply'] = 'Reply';
$lang['ticket_error_reply_failed'] = '<div '.CSS_CLASS_ERROR.'>Problem occured; please re-post your reply. If problem persists, contact us.</div>';
$lang['ticket_success_ticket_closed'] = '<div '.CSS_CLASS_SUCCESS.'>Your ticket is closed.</div>';

//download controller
$lang['download_error_no_file'] = '<div '.CSS_CLASS_ERROR.'>File doesnt exist</div>';

//edit_ticket controller
$lang['edit_ticket_page_title'] = 'Edit Ticket# ';
$lang['edit_ticket_lbl_priority'] = 'Priority ';
$lang['edit_ticket_lbl_category'] = 'Category ';
$lang['edit_ticket_lbl_title'] = 'Title ';
$lang['edit_ticket_lbl_question'] = 'Question ';
$lang['edit_ticket_lbl_attach'] = 'Attachment ';
$lang['edit_ticket_btn_delete_attachment'] = 'Delete Attachment';
$lang['edit_ticket_btn_edit'] = 'Edit';
$lang['edit_ticket_link_back'] = 'Back';
$lang['edit_ticket_error_edit_failed'] = '<div '.CSS_CLASS_ERROR.'>Editing failed. Please press "Edit" again. If problem persists, contact us.</div>';
$lang['edit_ticket_success_edit_ok'] = '<div '.CSS_CLASS_SUCCESS.'>Your ticket is updated successfully.</div>';
$lang['edit_ticket_error_del_attach_failed1'] = '<div '.CSS_CLASS_ERROR.'>Temporary issue is encountered. Please press delete button again. If problem persists, contact us.</div>';
$lang['edit_ticket_error_del_attach_failed2'] = '<div '.CSS_CLASS_ERROR.'>Attachment could not be deleted. Please contact us.</div>';

//admin-ticket controller
$lang['ticket_success_ticket_deleted'] = '<div '.CSS_CLASS_SUCCESS.'>Ticket is deleted (inactivated) successfully.</div>';
$lang['ticket_success_ticket_undeleted'] = '<div '.CSS_CLASS_SUCCESS.'>Ticket is undeleted (activated) successfully</div>';
$lang['ticket_lbl_is_active'] = "Is Active";
$lang['ticket_btn_delete'] = 'Update';
$lang['ticket_success_ticket_opened'] = '<div '.CSS_CLASS_SUCCESS.'>Ticket is opened successfully</div>';

//admin-edit-ticket controller
$lang['admin_edit_ticket_btn_reset'] = "Send Reset Password Link";

//admin-edit-user controller
$lang['admin_edit_user_edited_email_success'] =  '<div '.CSS_CLASS_SUCCESS.'>Email notification has been sent to the user</div>';
$lang['admin_edit_user_lbl_groupid'] = 'Group';
$lang['admin_edit_user_lbl_is_banned'] = 'Is Banned';
$lang['admin_edit_user_password_reset'] = '<div '.CSS_CLASS_SUCCESS.'>An Email has been Sent to the User</div>';

//admin-add-user controller
$lang['admin_add_user_link'] = 'Add New User';
$lang['admin_add_user_add'] = 'Add User';
$lang['admin_add_user_page_title'] = SITE_NAME.' - Add New User';
$lang['admin_add_user_success'] = 'User is added successfully. An email has been sent to the user.';
$lang['admin_add_user_fail_username'] = '<div '.CSS_CLASS_ERROR.'>Username is already taken. Please pick another username</div>';
$lang['admin_add_user_fail_email'] = '<div '.CSS_CLASS_ERROR.'>Email is already taken. Please pick another email.</div>';
