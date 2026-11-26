<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================================
// LOGIN DAN LOGOUT
// =====================================

$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// =====================================
// LUPA PASSWORD ADMIN
// =====================================

$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::sendResetLink');

// RESET PASSWORD ADMIN
$routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('reset-password/(:segment)', 'Auth::updatePassword/$1');

// =====================================
// HALAMAN UTAMA
// =====================================

$routes->get('/', 'Home::index');

$routes->get('dashboard', 'Dashboard::index', [
    'filter' => 'auth'
]);

// =====================================
// API EXPLORER
// Controller: app/Controllers/Api/ApiExplorer.php
// =====================================

$routes->get('api-explorer', 'Api\ApiExplorer::index', [
    'filter' => 'auth'
]);

$routes->post('api-explorer/send', 'Api\ApiExplorer::send', [
    'filter' => 'auth'
]);
// =====================================
// HALAMAN WEB DATA DOSEN
// =====================================

$routes->get('dosen', 'DosenWeb::index', [
    'filter' => 'auth'
]);

 // =====================================
 // API DATA DOSEN DAN INTEGRASI
 // =====================================

$routes->group('api', [
    'namespace' => 'App\Controllers\Api'
], function ($routes) {

    // =================================
    // API DATA DOSEN
    // =================================

    // GET
    $routes->get('cek-koneksi', 'Dosen::cekKoneksi');
    $routes->get('dosen', 'Dosen::index');
    $routes->get('dosen/search', 'Dosen::search');
    $routes->get('dosen/filter', 'Dosen::filter');
    $routes->get('dosen/(:segment)', 'Dosen::show/$1');

    // POST
    $routes->post('dosen', 'Dosen::store', [
        'filter' => 'apiKey'
    ]);

    // PUT
    $routes->put('dosen/(:num)', 'Dosen::update/$1', [
        'filter' => 'apiKey'
    ]);

    // PATCH
    $routes->patch('dosen/(:num)', 'Dosen::update/$1', [
        'filter' => 'apiKey'
    ]);

    // DELETE
    $routes->delete('dosen/(:num)', 'Dosen::delete/$1', [
        'filter' => 'apiKey'
    ]);

    // =================================
    // API INTEGRASI KELOMPOK 4
    // =================================

    // GET semua data dosen dan mata kuliah
    $routes->get('integrasi', 'IntegrasiApi::index');

    // GET detail integrasi berdasarkan ID dosen
    $routes->get('integrasi/dosen/(:num)', 'IntegrasiApi::show/$1');
});
