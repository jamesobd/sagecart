<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
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

$route['default_controller'] = "index";
$route['404_override'] = '';

// Skip the RESTful routes if this is a CRON job
if (php_sapi_name() === 'cli' OR defined('STDIN')) {
    return;
}

// RESTful actions (non-CRUD)
$route['api/contacts/login'] = 'api/contacts/login'; // LOGIN
$route['api/contacts/logout'] = 'api/contacts/logout'; // LOGOUT
$route['api/products/test'] = 'api/products/test';
$route['api/products/checkout'] = 'api/products/checkout'; // CHECKOUT
$route['api/products/submit'] = 'api/products/submit'; // SUBMIT
$route['api/products/clear'] = 'api/products/clear'; // CLEAR
$route['api/products/sync'] = 'api/products/sync'; // SYNC

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // The POST CRUD action
    $route['api/(:any)'] = 'api/$1/' . $_SERVER['REQUEST_METHOD']; // POST
} else {
    // The other CRUD actions
    $route['api/(:any)/(:any)'] = 'api/$1/' . $_SERVER['REQUEST_METHOD'] . '/$2'; // GET,PUT,PATCH,DELETE
    $route['api/(:any)'] = 'api/$1/getall'; // GETALL
}


// Pages
$route['shop'] = 'index/shop'; // Home



/* End of file routes.php */
/* Location: ./application/config/routes.php */