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
|	https://codeigniter.com/userguide3/general/routing.html
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

$route['default_controller'] = 'AuthController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'AuthController/login';
$route['logout/(:num)'] = 'AuthController/logout/$1';
$route['register'] = 'AuthController/register'; // Used for both GET and POST

// Admin: Dashboard
$route['admin/dashboard'] = 'AdminController/dashboard';

// Admin: Manage Shopkeepers (using RESTful conventions)
$route['admin/shopkeepers'] = 'AdminController/shopkeepers';

$route['admin/shopkeepers/add'] = 'AdminController/addShopkeeper';

$route['admin/shopkeepers/edit/(:num)'] = 'AdminController/editShopkeeper/$1';

$route['admin/shopkeepers/delete/(:num)'] = 'AdminController/deleteShopkeeper/$1';

// Admin: Manage Workers
$route['admin/workers'] = 'AdminController/workers';
$route['admin/workers/add'] = 'AdminController/addWorker';
$route['admin/workers/edit/(:num)'] = 'AdminController/editWorker/$1';
$route['admin/workers/delete/(:num)'] = 'AdminController/deleteWorker/$1';

// Shopkeeper: Dashboard
$route['shopkeeper/dashboard'] = 'ShopkeeperController/dashboard';

// Shopkeeper: Manage Workers
$route['shopkeeper/workers'] = 'ShopkeeperController/workers';
$route['shopkeeper/workers/add'] = 'ShopkeeperController/addWorker';
$route['shopkeeper/workers/edit/(:num)'] = 'ShopkeeperController/editWorker/$1';
$route['shopkeeper/workers/delete/(:num)'] = 'ShopkeeperController/deleteWorker/$1';

// Shopkeeper: Manage Categories
$route['shopkeeper/categories'] = 'ShopkeeperController/categories';
$route['shopkeeper/categories/add'] = 'ShopkeeperController/addCategory';
$route['shopkeeper/categories/edit/(:num)'] = 'ShopkeeperController/editCategory/$1';
$route['shopkeeper/categories/delete/(:num)'] = 'ShopkeeperController/deleteCategory/$1';

// Shopkeeper: Manage Products
$route['shopkeeper/products'] = 'ShopkeeperController/products';
$route['shopkeeper/products/add'] = 'ShopkeeperController/addProduct';
$route['shopkeeper/products/edit/(:num)'] = 'ShopkeeperController/editProduct/$1';
$route['shopkeeper/products/delete/(:num)'] = 'ShopkeeperController/deleteProduct/$1';

// Worker: Dashboard
$route['worker/dashboard'] = 'WorkerController/dashboard';

// Worker: Manage Categories
$route['worker/categories'] = 'WorkerController/categories';

// Worker: Manage Products
$route['worker/products'] = 'WorkerController/products';
$route['worker/products/add'] = 'WorkerController/addProduct';
$route['worker/products/edit/(:num)'] = 'WorkerController/editProduct/$1';
$route['worker/products/delete/(:num)'] = 'WorkerController/deleteProduct/$1';

// Worker: Profile
$route['worker/profile'] = 'WorkerController/profile';
