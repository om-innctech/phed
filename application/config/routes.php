<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// ********** API routes Only Goes Here Start ******** //
//$route['sample-details-post'] = 'api/post_sample_details';
// *********** API routes Only Goes Here End ************** //

// *********** Common routes Only Goes Here Start *************** //
$route['change-password'] = 'auth/change_password';
$route['forgot-password'] = 'auth/forgot_password';
$route['logout'] = 'auth/logout';
$route['reset-password'] = 'dashboard/reset_password';
// *********** Common routes Only Goes Here End *************** //


// *********** Admin routes Only Goes Here Start ************ //

$route['add-member/?(:num)?'] = 'dashboard/add_member/$1';
$route['members-list/?(:num)?'] = 'dashboard/members_list/$1';
$route['delete-member/(:num)'] = 'dashboard/delete_member/$1';

$route['block-mapping'] = 'dashboard/block_mapping';

//Note :: dl (Division Level) - Means below users of Division Level
$route['add-dl-member/?(:num)?'] = 'dashboard/add_dl_member/$1';
$route['dl-members-list/?(:num)?'] = 'dashboard/dl_members_list/$1';
$route['delete-dl-member/(:num)'] = 'dashboard/delete_dl_member/$1';

// *********** Admin routes Only Goes Here End ************** //


// *********** Report routes Only Goes Here Start ************ //
$route['view-report'] = 'report';
$route['ae/(:num)'] = 'report/rpt_sub_divisions/$1';
$route['se/(:num)'] = 'report/rpt_blocks/$1';
$route['sarpanchs/(:num)'] = 'report/rpt_sarpanchs/$1';
$route['sachivs/(:num)'] = 'report/rpt_sachivs/$1';
// *********** Report routes Only Goes Here End ************** //
