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
$routes->get('hakkimizda', 'Pages::hakkimizda');
$routes->get('mongo/(:num)', 'Home::test/$1');

$routes->group('admin', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('login', 'Pages::login');
    $routes->post('login', 'Pages::login');  
    $routes->get('panel', 'Admin::panel');
    $routes->get('ekle', 'Admin::ekle');
    $routes->post('ekle', 'Admin::ekle');
    $routes->get('duzenle/(:segment)', 'Admin::duzenle/$1');
    $routes->post('duzenle/(:segment)', 'Admin::duzenle/$1');
    $routes->get('sil/(:segment)', 'Admin::sil/$1');
});
