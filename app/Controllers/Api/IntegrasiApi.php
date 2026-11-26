<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use Config\Services;
use Throwable;

class IntegrasiApi extends BaseController
{
    protected DosenModel $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    /**
     * GET /api/integrasi
     * Mengambil data Dosen dan Mata Kuliah.
     */
    public function index()
    {
        try {
            // Mengambil data dosen dari database Kelompok 4
            $dosen = $this->dosenModel->findAll();

            // Mengambil data mata kuliah dari API Kelompok 3
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
                        'data' => $matkul['data']
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

            $dosen = $this->dosenModel->find($id);

            if (!$dosen) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data dosen tidak ditemukan'
                ])->setStatusCode(404);
            }

            $matkul = $this->getDataMataKuliah();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data dosen berhasil ditemukan',

                'data' => [
                    'dosen' => $dosen,

                    // Belum diisi karena belum ada tabel
                    // atau API penghubung dosen dan mata kuliah.
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
     * Mengambil data Mata Kuliah dari proxy Kelompok 3.
     */
    private function getDataMataKuliah(): array
    {
        try {
            $url = base_url('matkul_proxy.php?path=matkul');

            $client = Services::curlrequest();

            $response = $client->get($url, [
                'timeout' => 30,
                'connect_timeout' => 10,
                'http_errors' => false,
                'verify' => true
            ]);

            $result = json_decode(
                $response->getBody(),
                true
            );

            if (
                $response->getStatusCode() !== 200 ||
                !is_array($result) ||
                !($result['status'] ?? false)
            ) {
                return [
                    'status' => false,
                    'total' => 0,
                    'data' => [],
                    'message' => 'Gagal mengambil data Mata Kuliah'
                ];
            }

            return [
                'status' => true,
                'total' => $result['total'] ?? count($result['data'] ?? []),
                'data' => $result['data'] ?? [],
                'message' => 'Data Mata Kuliah berhasil diambil'
            ];

        } catch (Throwable $e) {

            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'message' => $e->getMessage()
            ];
        }
    }
}
