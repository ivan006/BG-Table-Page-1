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

$route['default_controller'] = "g_relate/database_c/database";
$route['404_override'] = '';

$route['bugs'] = "bugs/welcome";
$route['welcome'] = "bugs/welcome";
$route['login'] = "bugs/login";

$route['webslesson'] = "trips/webslesson_c";
$route['webslesson/api'] = "trips/webslesson_c/api";


$route['techontech'] = 'trips/techontech_c/index';
$route['techontech/insert'] = 'trips/techontech_c/insert';
$route['techontech/fetch'] = 'trips/techontech_c/fetch';
$route['techontech/delete'] = 'trips/techontech_c/delete';
$route['techontech/edit'] = 'trips/techontech_c/edit';
$route['techontech/update'] = 'trips/techontech_c/update';

$route['trips'] = 'trips/trips_c/index';
$route['trips/insert'] = 'trips/trips_c/insert';
$route['trips/fetch'] = 'trips/trips_c/fetch';
$route['trips/delete'] = 'trips/trips_c/delete';
$route['trips/edit'] = 'trips/trips_c/edit';
$route['trips/update'] = 'trips/trips_c/update';

$route['events'] = 'trips/events_c/index';
$route['events/insert'] = 'trips/events_c/insert';
$route['events/fetch'] = 'trips/events_c/fetch';
$route['events/delete'] = 'trips/events_c/delete';
$route['events/edit'] = 'trips/events_c/edit';
$route['events/update'] = 'trips/events_c/update';



$route['migration'] = "g_relate/migrations_c";

$route['g_relate/database'] = 'g_relate/database_c/database';
$route['g_relate/database_api'] = 'g_relate/database_c/database_api';

$route['g_relate/table/t/(:any)'] = 'g_relate/table_c/index/$1';

$route['g_relate/api/table/t/(:any)/insert'] = 'g_relate/table_c/insert/$1';
$route['g_relate/api/table/t/(:any)/fetch'] = 'g_relate/table_c/fetch/$1';
$route['g_relate/api/table/t/(:any)/delete'] = 'g_relate/table_c/delete/$1';
$route['g_relate/api/table/t/(:any)/edit'] = 'g_relate/table_c/edit/$1';
$route['g_relate/api/table/t/(:any)/update'] = 'g_relate/table_c/update/$1';
$route['g_relate/api/table/t/(:any)/fetch_where/h/(:any)/n/(:any)'] = 'g_relate/table_c/fetch_where/$1/$2/$3';
// $route['g_relate/api/table/t/(:any)/fetch_join_where/t/(:any)/h/(:any)/n/(:any)'] = 'g_relate/table_c/fetch_join_where/$1/$2/$3/$4';
$route['g_relate/api/table/t/(:any)/fetch_join_where/t/(:any)/h/(:any)/n/(:any)'] = 'g_relate/table_c/fetch_join_where/$1/$2/$3/$4';

$route['g_relate/record/t/(:any)/r/(:num)'] = 'g_relate/record_c/index/$1/$2';

$route['mergetest'] = 'g_relate/record_c/mergetest';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
