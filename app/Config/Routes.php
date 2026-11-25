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
// API DATA DOSEN TRPL KELOMPOK 4
// =====================================

$routes->group('api', [
    'namespace' => 'App\Controllers\Api'
], function ($routes) {

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
});
// HEAD
$routes->head('dosen', 'Dosen::index');
$routes->head('dosen/(:num)', 'Dosen::show/$1');

// OPTIONS
$routes->options('dosen', 'Dosen::options');
$routes->options('dosen/(:num)', 'Dosen::options');
// =====================================
// WEBSITE DATA DOSEN PUBLIK
// =====================================

$routes->get('direktori-dosen', 'DosenWeb::publik');

// =====================================
// WEBSITE DATA DOSEN ADMIN
// =====================================

$routes->get('dosen', 'DosenWeb::index', [
    'filter' => 'auth'
]);

$routes->get('dosen/tambah', 'DosenWeb::create', [
    'filter' => 'auth'
]);

$routes->post('dosen/simpan', 'DosenWeb::store', [
    'filter' => 'auth'
]);

$routes->get('dosen/edit/(:num)', 'DosenWeb::edit/$1', [
    'filter' => 'auth'
]);

$routes->post('dosen/update/(:num)', 'DosenWeb::update/$1', [
    'filter' => 'auth'
]);

$routes->post('dosen/hapus/(:num)', 'DosenWeb::delete/$1', [
    'filter' => 'auth'
]);

$routes->get('dosen/(:num)', 'DosenWeb::detail/$1', [
    'filter' => 'auth'
]);
