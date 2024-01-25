<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Panel::dashboard');
$routes->get('/products', 'Panel::products');
$routes->get('/products/add', 'Panel::add_product');
$routes->get('/products/edit/(:num)', 'Panel::edit_product/$1');
$routes->get('/licenses', 'Panel::licenses');
$routes->get('/licenses/add', 'Panel::add_license');
$routes->get('/licenses/edit/(:num)', 'Panel::edit_license/$1');
$routes->get('/checks', 'Panel::license_checks');
$routes->get('/warnings', 'Panel::unauthorized_uses');
$routes->get('/settings', 'Panel::general_settings');
$routes->get('/admins', 'Panel::admins');
$routes->get('/admins/add', 'Panel::add_admin');
$routes->get('/admins/edit/(:num)', 'Panel::edit_admin/$1');
$routes->get('/integration', 'Panel::integration');
$routes->get('/encoder', 'Panel::php_encoder');
$routes->post('/encoder', 'Panel::php_encoder_post');
$routes->get('/page/warning', 'Warning');
$routes->get('/login', 'Auth::login');
$routes->get('/logout', 'Panel::logout');

$routes->post('/check', 'LicenseCheck::check_license');
$routes->post('/checkAdmin', 'LicenseCheck::check_license_product');
$routes->post('/products/delete', 'PanelAjax::delete_product');
$routes->post('/licenses/delete', 'PanelAjax::delete_license');
$routes->post('/admins/delete', 'PanelAjax::delete_admin');
$routes->post('/ajax/login', 'Auth::login_process');
$routes->post('/ajax/addProduct', 'PanelAjax::add_product');
$routes->post('/products/update', 'PanelAjax::update_product');
$routes->post('/ajax/addLicense', 'PanelAjax::add_license');
$routes->post('/licenses/update', 'PanelAjax::update_license');
$routes->post('/ajax/addAdmin', 'PanelAjax::add_admin');
$routes->post('/admins/update', 'PanelAjax::update_admin');
$routes->post('/checks/delete', 'PanelAjax::delete_license_check');
$routes->post('/ajax/updateSettings', 'PanelAjax::update_settings');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}