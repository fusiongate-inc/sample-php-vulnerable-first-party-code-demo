<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('input', 'Main::input');
$routes->get('checkout', 'Main::checkout');
$routes->match(['get', 'post'], 'checkout', 'Main::checkout');