
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// API DATA DOSEN TRPL KELOMPOK 2
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {

    $routes->get('dosen', 'Dosen::index');

    // Pencarian harus sebelum detail
    $routes->get('dosen/search', 'Dosen::search');
    // GET: Filter dosen berdasarkan status aktivitas
    $routes->get('dosen/filter', 'Dosen::filter');
    $routes->get('dosen/(:segment)', 'Dosen::show/$1');
   
    //Memasang API Key pada POST, PUT, dan DELETE.
    $routes->post('dosen', 'Dosen::create', ['filter' => 'apiKey']);
    $routes->put('dosen/(:segment)', 'Dosen::update/$1', ['filter' => 'apiKey']);
    $routes->delete('dosen/(:segment)', 'Dosen::delete/$1', ['filter' => 'apiKey']);

});