
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// =====================================
// HALAMAN UTAMA
// =====================================

$routes->get('/', 'Home::index');
$routes->get('dashboard', 'Dashboard::index');


// =====================================
// API DATA DOSEN TRPL KELOMPOK 4
// KHUSUS READ / GET
// =====================================

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
// WEBSITE DATA DOSEN
// CRUD DIKELOLA OLEH ADMIN
// =====================================

// READ: Menampilkan daftar dosen
$routes->get('dosen', 'DosenWeb::index');

// CREATE: Menampilkan form tambah dosen
$routes->get('dosen/tambah', 'DosenWeb::create');

// CREATE: Menyimpan data dosen
$routes->post('dosen/simpan', 'DosenWeb::store');

// UPDATE: Menampilkan form edit dosen
$routes->get('dosen/edit/(:num)', 'DosenWeb::edit/$1');

// UPDATE: Menyimpan perubahan data dosen
$routes->post('dosen/update/(:num)', 'DosenWeb::update/$1');

// DELETE: Menghapus data dosen
$routes->post('dosen/hapus/(:num)', 'DosenWeb::delete/$1');

// READ: Menampilkan detail dosen
$routes->get('dosen/(:num)', 'DosenWeb::detail/$1');
