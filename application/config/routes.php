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

$route['default_controller'] = "home";
$route['404_override'] = '';
$route['pages/(:any)'] = 'pages/index/$1';
$route['downloads/(:any)'] = 'downloads/index/$1';
$route['mentorship/(:num)'] = 'mentorship/index/$1';
$route['mentorship/page/(:num)'] = 'mentorship/index/$1';
$route['rss/(:any).xml'] = 'rss/feed/$1';
$route['rss/(:any).rss'] = 'rss/feed/$1';

// Mentorship acp reroute
$route['teachers/dashboard/mentorship'] = 'mentorship_admin';
$route['teachers/dashboard/mentorship/(:any)'] = 'mentorship_admin/$1';

// Teachers section routing
$route['teachers/dashboard'] = 'teacher_dashboard';
$route['teachers/dashboard/(:any)'] = 'teacher_dashboard/$1';
$route['teachers/(:any)/page/(:any)'] = 'teachers/page/$1/$2';
$route['teachers/(:any)/blog/view/(:num)'] = 'teachers/blog_entry/$1/$2';
$route['teachers/(:any)/blog/page/(:num)'] = 'teachers/blog_home/$1/$2';
$route['teachers/(:any)/blog'] = 'teachers/blog_home/$1';
$route['teachers/(:any)'] = 'teachers/about/$1';

/* End of file routes.php */
/* Location: ./application/config/routes.php */