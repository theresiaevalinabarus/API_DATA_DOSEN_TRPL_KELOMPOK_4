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

// Menampilkan daftar dosen
$routes->get('dosen', 'DosenWeb::index', [
    'filter' => 'auth'
]);

// Menampilkan detail dosen
$routes->get('dosen/(:num)', 'DosenWeb::detail/$1', [
    'filter' => 'auth'
]);

// Form tambah dosen
$routes->get('dosen/create', 'DosenWeb::create', [
    'filter' => 'auth'
]);

// Menyimpan dosen baru
$routes->post('dosen/store', 'DosenWeb::store', [
    'filter' => 'auth'
]);

// Form edit dosen
$routes->get('dosen/edit/(:num)', 'DosenWeb::edit/$1', [
    'filter' => 'auth'
]);

// Memperbarui dosen
$routes->post('dosen/update/(:num)', 'DosenWeb::update/$1', [
    'filter' => 'auth'
]);

// Menghapus dosen
$routes->post('dosen/delete/(:num)', 'DosenWeb::delete/$1', [
    'filter' => 'auth'
]);

// Form tambah dosen (alamat lama yang masih digunakan tombol)
$routes->get('dosen/tambah', 'DosenWeb::create', [
    'filter' => 'auth'
]);

// Menyimpan dosen (alamat lama dari form)
$routes->post('dosen/simpan', 'DosenWeb::store', [
    'filter' => 'auth'
]);

// Menghapus dosen (alamat lama dari tombol hapus)
$routes->post('dosen/hapus/(:num)', 'DosenWeb::delete/$1', [
    'filter' => 'auth'
]);
// Direktori Dosen (akses publik tanpa login)
$routes->get('direktori-dosen', 'DosenWeb::publik');
 // =====================================
 // API DATA DOSEN DAN INTEGRASI
 // =====================================

$routes->group('api', [
    'namespace' => 'App\Controllers\Api'
], function ($routes) {
// CORS Preflight
$routes->options('dosen', static function () {
    return service('response')->setStatusCode(204);
});

$routes->options('dosen/(:any)', static function () {
    return service('response')->setStatusCode(204);
});
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
