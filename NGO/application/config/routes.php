<?php

defined('BASEPATH') or exit('No direct script access allowed');

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

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = false;

//Admin
$route['admin'] = 'admin/console';
$route['admin/settings/store/(:any)'] = 'admin/settings/store/index/$1';

// Public
$route['home'] = 'home/index';
$route['menus'] = 'menus/index';
$route['checkout'] = 'checkout/index';
$route['login'] = 'login/index';
$route['signup'] = 'signup/index';
$route['menus/category/(:any)'] = 'menus/index/$1';
$route['menus/(:num)/(:any)'] = 'menus/view/$1/$2';
$route['blog/(:num)/(:any)'] = 'blog/view/$1/$2';
$route['blog'] = 'blog/index';

$route['account'] = 'account/index';
$route['reviews'] = 'reviews/index';
$route['reviews/create'] = 'reviews/save';
$route['account/orders/(:any)'] = 'account/orders/order_details/$1';
$route['account']='account/account/index';
$route['account/orders']='account/orders/index';
$route['account/password/(:any)']='account/password/index/$1';
$route['account/logout']='account/account/logout';
$route['language/(:any)'] = 'language/index/$1';

$route['reset-password']='resetpassword/index';
$route['reset-password/(:any)']='resetpassword/update/$1';


// Stripe
$route['payment/stripe'] = 'payment_stripe/processing';

// Braintree
$route['payment/braintree'] = 'payment_braintree/processing';

$route['(:any)'] = 'page/index/$1';





