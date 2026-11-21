
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// LOGIN DAN LOGOUT
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

// LUPA PASSWORD ADMIN
$routes->get('forgot-password', 'Auth::forgotPassword');
$routes->post('forgot-password', 'Auth::sendResetLink');
// RESET PASSWORD ADMIN
$routes->get('reset-password/(:segment)', 'Auth::resetPassword/$1');
$routes->post('reset-password/(:segment)', 'Auth::updatePassword/$1');
// =====================================
// HALAMAN UTAMA
// =====================================

// Landing Page: dapat diakses tanpa login
$routes->get('/', 'Home::index');

// Dashboard: wajib login
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);


// =====================================
// API DATA DOSEN TRPL KELOMPOK 4
// =====================================

$routes->group('api', [
    'namespace' => 'App\Controllers\Api'
], function ($routes) {

    // GET: Dapat diakses kelompok lain
    $routes->get('cek-koneksi', 'Dosen::cekKoneksi');
    $routes->get('dosen', 'Dosen::index');
    $routes->get('dosen/search', 'Dosen::search');
    $routes->get('dosen/filter', 'Dosen::filter');
    $routes->get('dosen/(:segment)', 'Dosen::show/$1');

    // POST: Menambah data (wajib API Key)
    $routes->post('dosen', 'Dosen::store', [
        'filter' => 'apiKey'
    ]);

    // PUT: Mengubah data (wajib API Key)
    $routes->put('dosen/(:num)', 'Dosen::update/$1', [
        'filter' => 'apiKey'
    ]);

    // DELETE: Menghapus data (wajib API Key)
    $routes->delete('dosen/(:num)', 'Dosen::delete/$1', [
        'filter' => 'apiKey'
    ]);
});


// =====================================
// WEBSITE DATA DOSEN PUBLIK
// KHUSUS PENGUNJUNG
// =====================================

// READ: Menampilkan daftar dosen publik
$routes->get('direktori-dosen', 'DosenWeb::publik');


// =====================================
// WEBSITE DATA DOSEN
// CRUD DIKELOLA OLEH ADMIN
// =====================================

// READ: Menampilkan daftar dosen Admin
$routes->get('dosen', 'DosenWeb::index', ['filter' => 'auth']);

// CREATE: Menampilkan form tambah dosen
$routes->get('dosen/tambah', 'DosenWeb::create', ['filter' => 'auth']);

// CREATE: Menyimpan data dosen
$routes->post('dosen/simpan', 'DosenWeb::store', ['filter' => 'auth']);

// UPDATE: Menampilkan form edit dosen
$routes->get('dosen/edit/(:num)', 'DosenWeb::edit/$1', ['filter' => 'auth']);

// UPDATE: Menyimpan perubahan data dosen
$routes->post('dosen/update/(:num)', 'DosenWeb::update/$1', ['filter' => 'auth']);

// DELETE: Menghapus data dosen
$routes->post('dosen/hapus/(:num)', 'DosenWeb::delete/$1', ['filter' => 'auth']);

// READ: Menampilkan detail dosen khusus Admin
$routes->get('dosen/(:num)', 'DosenWeb::detail/$1', ['filter' => 'auth']);
// POST: Menambah data (wajib API Key)
$routes->post('dosen', 'Dosen::store', [
    'filter' => 'apiKey'
]);

// PUT: Mengubah data (wajib API Key)
$routes->put('dosen/(:num)', 'Dosen::update/$1', [
    'filter' => 'apiKey'
]);

// DELETE: Menghapus data (wajib API Key)
$routes->delete('dosen/(:num)', 'Dosen::delete/$1', [
    'filter' => 'apiKey'
]);