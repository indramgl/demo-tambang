<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', function () {
    return redirect()->to('/id/');
});

$routes->group('{locale}', ['filter' => 'locale'], function ($routes) {
    $routes->get('/', 'Home::index');
});
