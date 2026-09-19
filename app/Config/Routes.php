<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', function () {
    return redirect()->to('/id/');
});

$routes->group('{locale}', ['filter' => 'locale'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('sejarah', 'Home::page/history');
    $routes->get('visi-misi', 'Home::page/vision-mission');
    $routes->get('layanan', 'Home::page/services');
    $routes->get('kontak', 'Home::page/contact');
    $routes->get('portofolio', 'Home::page/portfolio');
    $routes->get('investor', 'Home::page/investor');
    $routes->get('tentang', 'Home::page/about');
});
