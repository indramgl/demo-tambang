<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', function () {
    return redirect()->to('/id/');
});

$routes->group('{locale}', ['filter' => 'locale'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('sejarah', 'Home::history');
    $routes->get('visi-misi', 'Home::visionMission');
    $routes->get('layanan', 'Home::services');
    $routes->get('kontak', 'Home::contact');
    $routes->get('portofolio', 'Home::portfolio');
    $routes->get('investor', 'Home::investor');
});
