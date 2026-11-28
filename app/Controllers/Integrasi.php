<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Libraries\MatkulApiClient;
use App\Libraries\JadwalApiClient;
use Throwable;

class Integrasi extends BaseController
{
    protected DosenModel $dosenModel;
    protected MatkulApiClient $matkulApiClient;
    protected JadwalApiClient $jadwalApiClient;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->matkulApiClient = new MatkulApiClient();
        $this->jadwalApiClient = new JadwalApiClient();
    }

    /**
     * Halaman dashboard integrasi API.
     * URL: /integrasi
     */
    public function index()
    {
        try {
            // =====================================
            // 1. DATA DOSEN KELOMPOK 4
            // =====================================

            $dosenLokal = $this->dosenModel->findAll();

            // =====================================
            // 2. DATA MATA KULIAH KELOMPOK 3
            // =====================================

            $matkul = $this->matkulApiClient->getMataKuliah();

            // =====================================
            // 3. DATA API KELOMPOK 2
            // =====================================

            $dosenApi = $this->jadwalApiClient->getDosen();

            $pengampu = $this->jadwalApiClient->getPengampu();

            $jadwal = $this->jadwalApiClient->getJadwal();

            // =====================================
            // 4. STATUS KONEKSI API
            // =====================================

            $status = [
                'dosen' => true,

                'matkul' => !empty($matkul['status']),

                'dosen_api' => !empty($dosenApi['status']),

                'pengampu' => !empty($pengampu['status']),

                'jadwal' => !empty($jadwal['status']),
            ];

            // =====================================
            // 5. DATA UNTUK HALAMAN
            // =====================================

            $data = [
                'title' => 'Integrasi API',

                'dosen' => $dosenLokal,

                'matkul' => $matkul['data'] ?? [],

                'dosen_api' => $dosenApi['data'] ?? [],

                'pengampu' => $pengampu['data'] ?? [],

                'jadwal' => $jadwal['data'] ?? [],

                // Total masing-masing data
                'total_dosen' => count($dosenLokal),

                'total_matkul' => $matkul['total']
                    ?? count($matkul['data'] ?? []),

                'total_dosen_api' => $dosenApi['total']
                    ?? count($dosenApi['data'] ?? []),

                'total_pengampu' => $pengampu['total']
                    ?? count($pengampu['data'] ?? []),

                'total_jadwal' => $jadwal['total']
                    ?? count($jadwal['data'] ?? []),

                // Status koneksi
                'status_api' => $status,

                // Pesan diagnostik
                'diagnostik' => [
                    'matkul' => $matkul['message'] ?? '',

                    'dosen' => $dosenApi['message'] ?? '',

                    'pengampu' => $pengampu['message'] ?? '',

                    'jadwal' => $jadwal['message'] ?? '',
                ],
            ];

            return view('integrasi/index', $data);

        } catch (Throwable $e) {

            log_message(
                'error',
                'Gagal memuat halaman integrasi: ' . $e->getMessage()
            );

            return view('errors/html/error_exception', [
                'title' => 'Kesalahan Integrasi',
                'message' => 'Terjadi kesalahan saat mengambil data integrasi.',
                'exception' => $e,
            ]);
        }
    }
}
