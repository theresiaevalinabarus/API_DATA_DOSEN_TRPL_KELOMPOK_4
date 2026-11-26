<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Libraries\MatkulApiClient;
use Throwable;

class IntegrasiApi extends BaseController
{
    protected DosenModel $dosenModel;
    protected MatkulApiClient $matkulApiClient;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->matkulApiClient = new MatkulApiClient();
    }

    /**
     * GET /api/integrasi
     * Mengambil data Dosen dan Mata Kuliah.
     */
    public function index()
    {
        try {
            // Mengambil data Dosen Kelompok 4
            $dosen = $this->dosenModel->findAll();

            // Mengambil data Mata Kuliah Kelompok 3
            $matkul = $this->getDataMataKuliah();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data integrasi berhasil diproses',

                'data' => [
                    'dosen' => [
                        'total' => count($dosen),
                        'data' => $dosen
                    ],

                    'mata_kuliah' => [
                        'total' => $matkul['total'],
                        'data' => $matkul['data'],
                        'message' => $matkul['message'],
                        'http_status' => $matkul['http_status']
                    ]
                ],

                'integrasi' => [
                    'api_dosen' => 'Terhubung',

                    'api_matkul' => $matkul['status']
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'api_jadwal' => 'Belum tersedia',
                    'relasi_dosen_matkul' => 'Belum tersedia'
                ]

            ])->setStatusCode(200);

        } catch (Throwable $e) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal mengambil data integrasi',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * GET /api/integrasi/dosen/{id}
     * Mengambil data dosen berdasarkan ID.
     */
    public function show($id = null)
    {
        try {
            if (!is_numeric($id) || (int) $id <= 0) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'ID dosen tidak valid'
                ])->setStatusCode(400);
            }

            // Mencari dosen berdasarkan ID
            $dosen = $this->dosenModel->find($id);

            if (!$dosen) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data dosen tidak ditemukan'
                ])->setStatusCode(404);
            }

            // Mengambil data Mata Kuliah
            $matkul = $this->getDataMataKuliah();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data dosen berhasil ditemukan',

                'data' => [
                    'dosen' => $dosen,

                    // Relasi belum tersedia
                    'mata_kuliah' => []
                ],

                'integrasi' => [
                    'api_dosen' => 'Terhubung',

                    'api_matkul' => $matkul['status']
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'api_jadwal' => 'Belum tersedia',

                    'keterangan' =>
                        'Relasi dosen dan mata kuliah menunggu data penghubung.'
                ],

                'diagnostik_matkul' => [
                    'message' => $matkul['message'],
                    'http_status' => $matkul['http_status']
                ]

            ])->setStatusCode(200);

        } catch (Throwable $e) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal mengambil data dosen',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Mengambil data Mata Kuliah menggunakan MatkulApiClient.
     */
    private function getDataMataKuliah(): array
    {
        try {
            return $this->matkulApiClient->getMataKuliah();

        } catch (Throwable $e) {

            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'message' => $e->getMessage(),
                'http_status' => 0
            ];
        }
    }
}
