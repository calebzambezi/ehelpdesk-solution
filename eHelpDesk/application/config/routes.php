<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//Note: routes will run in the order that they appear
//CLIENT SIDE
$route['default_controller'] = 'auth/login';
$route['404_override'] = 'custom404'; //***ADDED
$route['error-404'] = $route['404_override']; //i display it in the redirect URL, when standard user tries to sneal to admin pages manually
$route['new-ticket'] = 'new_ticket/index';
$route['view-tickets'] = 'view_tickets/index';
$route['view-tickets/status/desc'] = 'view_tickets/index/status/desc';
$route['view-tickets/status/asc'] = 'view_tickets/index/status/asc';
$route['view-tickets/status/asc/(:num)'] = 'view_tickets/index/status/asc/$1';
$route['view-tickets/status/desc/(:num)'] = 'view_tickets/index/status/desc/$1';

$route['view-tickets/dateop/desc'] = 'view_tickets/index/dateop/desc';
$route['view-tickets/dateop/asc'] = 'view_tickets/index/dateop/asc';
$route['view-tickets/dateop/asc/(:num)'] = 'view_tickets/index/dateop/asc/$1';
$route['view-tickets/dateop/desc/(:num)'] = 'view_tickets/index/dateop/desc/$1';

$route['account-settings'] = 'account_settings/index';

$route['login'] = '/auth/login';
$route['logout'] = '/auth/logout';
$route['register'] = 'auth/register';
$route['forgot-password'] = 'auth/forgot_password';
$route['resend'] = 'auth/send_again';

$route['privacy-policy'] = 'privacy_policy/index';
$route['aboutus'] = 'about_us/index';
$route['contactus'] = 'contact_us/index';

$route['ticket/(:num)'] = 'ticket/index/$1';
$route['ticket/(:num)/(:any)'] = 'ticket/index/$1/$2'; //:any will hold post's title

$route['download/(:any)'] = 'download/index/$1'; //(:any) represents file name

$route['edit-ticket'] = 'edit_ticket/index'; //controller will then redirect user to default controller, login page.
$route['edit-ticket/(:num)'] = 'edit_ticket/index/$1';

//ADMIN SIDE
$route['manage-tickets'] = 'manage_tickets/index';
$route['manage-tickets/status/desc'] = 'manage_tickets/index/status/desc';
$route['manage-tickets/status/asc'] = 'manage_tickets/index/status/asc';
$route['manage-tickets/status/asc/(:num)'] = 'manage_tickets/index/status/asc/$1';
$route['manage-tickets/status/desc/(:num)'] = 'manage_tickets/index/status/desc/$1';

$route['manage-tickets/dateop/desc'] = 'manage_tickets/index/dateop/desc';
$route['manage-tickets/dateop/asc'] = 'manage_tickets/index/dateop/asc';
$route['manage-tickets/dateop/asc/(:num)'] = 'manage_tickets/index/dateop/asc/$1';
$route['manage-tickets/dateop/desc/(:num)'] = 'manage_tickets/index/dateop/desc/$1';

$route['manage-tickets/datecl/desc'] = 'manage_tickets/index/datecl/desc';
$route['manage-tickets/datecl/asc'] = 'manage_tickets/index/datecl/asc';
$route['manage-tickets/datecl/asc/(:num)'] = 'manage_tickets/index/datecl/asc/$1';
$route['manage-tickets/datecl/desc/(:num)'] = 'manage_tickets/index/datecl/desc/$1';

$route['manage-tickets/lreply/desc'] = 'manage_tickets/index/lreply/desc';
$route['manage-tickets/lreply/asc'] = 'manage_tickets/index/lreply/asc';
$route['manage-tickets/lreply/asc/(:num)'] = 'manage_tickets/index/lreply/asc/$1';
$route['manage-tickets/lreply/desc/(:num)'] = 'manage_tickets/index/lreply/desc/$1';

$route['manage-tickets/act/desc'] = 'manage_tickets/index/act/desc';
$route['manage-tickets/act/asc'] = 'manage_tickets/index/act/asc';
$route['manage-tickets/act/asc/(:num)'] = 'manage_tickets/index/act/asc/$1';
$route['manage-tickets/act/desc/(:num)'] = 'manage_tickets/index/act/desc/$1';

$route['manage-tickets/title/desc'] = 'manage_tickets/index/title/desc';
$route['manage-tickets/title/asc'] = 'manage_tickets/index/title/asc';
$route['manage-tickets/title/asc/(:num)'] = 'manage_tickets/index/title/asc/$1';
$route['manage-tickets/title/desc/(:num)'] = 'manage_tickets/index/title/desc/$1';

$route['manage-users'] = 'manage_users/index';
$route['manage-users/datec/desc'] = 'manage_users/index/datec/desc';
$route['manage-users/datec/asc'] = 'manage_users/index/datec/asc';
$route['manage-users/datec/asc/(:num)'] = 'manage_users/index/datec/asc/$1';
$route['manage-users/datec/desc/(:num)'] = 'manage_users/index/datec/desc/$1';

$route['manage-users/dateu/desc'] = 'manage_users/index/dateu/desc';
$route['manage-users/dateu/asc'] = 'manage_users/index/dateu/asc';
$route['manage-users/dateu/asc/(:num)'] = 'manage_users/index/dateu/asc/$1';
$route['manage-users/dateu/desc/(:num)'] = 'manage_users/index/dateu/desc/$1';

$route['admin-ticket/(:num)'] = 'admin_ticket/index/$1';
$route['admin-ticket/(:num)/(:any)'] = 'admin_ticket/index/$1/$2'; //:any will hold post's title

$route['admin-edit-ticket'] = 'admin_edit_ticket/index'; //controller will then redirect user to default controller, login page.
$route['admin-edit-ticket/(:num)'] = 'admin_edit_ticket/index/$1';

$route['admin-edit-user/(:num)'] = 'admin_edit_user/index/$1';

$route['admin-add-user'] = 'admin_add_user/index';

/* End of file routes.php */
/* Location: ./application/config/routes.php */