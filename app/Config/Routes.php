<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Pages');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Pages::index');
$routes->get('detay/(:segment)', 'Pages::detay/$1');
$routes->get('hakkimizda', 'Pages::hakkimizda');
$routes->get('mongo/(:num)', 'Home::test/$1');

// Admin routes
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/login', 'Admin::login');
$routes->get('admin', 'Admin::panel');
$routes->get('admin/panel', 'Admin::panel');
$routes->get('admin/ekle', 'Admin::ekle');
$routes->post('admin/ekle', 'Admin::ekle');
$routes->get('admin/duzenle/(:segment)', 'Admin::duzenle/$1');
$routes->post('admin/duzenle/(:segment)', 'Admin::duzenle/$1');
$routes->get('admin/sil/(:segment)', 'Admin::sil/$1');
