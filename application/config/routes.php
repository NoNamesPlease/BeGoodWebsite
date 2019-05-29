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
$route['default_controller'] = 'welcome';
$route['admin'] = 'admin/Login/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['cafe'] = 'cards';
$route['profile'] = 'User_profile';
$route['profile/edit'] = 'User_profile/edit_profile';
$route['profile/update'] = 'User_profile/update_profile';
$route['ourstory'] = 'Sitepages';
$route['cafe/(:any)'] = 'Register_Cafe/cafe_page/$1';
$route['refreshcafe'] = 'Register_Cafe/refresh_cafepage';
$route['testsee/(:any)'] = 'Test/seepage/$1';
$route['search-vendor'] = 'cards/search_vendor';
$route['cafebyaddress'] = 'cards/cafebyaddress';
// $route['verifyotp/(:any)'] = 'User_login/verifyotp/$1';
$route['verifyotp'] = 'User_login/verifyotp';
$route['sendnewotp'] = 'User_login/sendnewotp';
$route['dashboard'] = 'User_dashboard';

// Admin routes
$route['admin/action/deactivate'] = 'admin/Actions/userdeactivate';
$route['admin/action/activate'] = 'admin/Actions/useractivate';
$route['admin/managecafe/(:num)'] = 'admin/Managecafe/edit_cafe/$1';
$route['admin/action/activate_cafe'] = 'admin/Actions/activate_cafe';
$route['admin/editcontent'] = 'admin/Managecontent';
$route['admin/changeadminpass'] = 'admin/Actions/changeadminpass';

$route['login'] = 'User_login';
$route['logout'] = 'User_profile/logout';
$route['register'] = 'User_login/signup';
$route['confirm_email/(:any)'] = 'User_login/confirm_email/$1';
$route['forgotpass'] = 'Forgot_pass';
$route['resetpassword/(:any)'] = 'Forgot_pass/resetpassword/$1';
$route['resetpassword'] = 'Forgot_pass/resetpassword';
$route['forgotpass/verified'] = 'Forgot_pass/verified';
$route['fb_authentication'] = 'Fb_Authentication';
$route['insta_authentication'] = 'Insta_Authentication';
$route['register-cafe'] = 'Register_Cafe';

// $route['(:any)'] = 'welcome';