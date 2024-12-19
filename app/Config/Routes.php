<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Pages::index');
$routes->get('hakkimizda', 'Pages::hakkimizda');
$routes->get('mongo/(:num)', 'Home::test/$1');
