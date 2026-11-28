<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\DosenModel;
use App\Libraries\MatkulApiClient;
use App\Libraries\JadwalApiClient;
use Throwable;

class IntegrasiApi extends BaseController
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
     * GET /api/integrasi
     * Menampilkan ringkasan integrasi tiga kelompok.
     */
    public function index()
    {
        try {
            $dosen = $this->dosenModel->findAll();

            $matkul = $this->getDataMataKuliah();
            $dosenJadwal = $this->jadwalApiClient->getDosen();
            $pengampu = $this->jadwalApiClient->getPengampu();
            $jadwal = $this->jadwalApiClient->getJadwal();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data integrasi berhasil diproses',

                'data' => [
                    'dosen' => [
                        'total' => count($dosen),
                        'data' => $dosen
                    ],

                    'mata_kuliah' => [
                        'total' => $matkul['total'] ?? 0,
                        'data' => $matkul['data'] ?? [],
                        'message' => $matkul['message'] ?? ''
                    ],

                    'dosen_api_jadwal' => [
                        'total' => $dosenJadwal['total'] ?? 0,
                        'status' => $dosenJadwal['status'] ?? false,
                        'message' => $dosenJadwal['message'] ?? ''
                    ],

                    'pengampu' => [
                        'total' => $pengampu['total'] ?? 0,
                        'status' => $pengampu['status'] ?? false
                    ],

                    'jadwal' => [
                        'total' => $jadwal['total'] ?? 0,
                        'status' => $jadwal['status'] ?? false
                    ]
                ],

                'integrasi' => [
                    'api_dosen' => 'Terhubung',

                    'api_matkul' => !empty($matkul['status'])
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'api_jadwal' => !empty($jadwal['status'])
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'api_pengampu' => !empty($pengampu['status'])
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'relasi_dosen_jadwal' => 'Menggunakan kode_dosen',

                    'relasi_pengampu_matkul' =>
                        'Menggunakan nama_matkul yang dicocokkan'
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
     * Detail dosen beserta mata kuliah, kelas, dan jadwal.
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

            // 1. Mengambil dosen dari database Kelompok 4.
            $dosen = $this->dosenModel->find($id);

            if (!$dosen) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Data dosen tidak ditemukan'
                ])->setStatusCode(404);
            }

            $kodeDosen = $dosen['kode_dosen'] ?? '';

            // 2. Mengambil data mata kuliah Kelompok 3.
            $matkul = $this->getDataMataKuliah();

            // 3. Mengambil data pengampu Kelompok 2.
            $pengampu = $this->jadwalApiClient->getPengampu();

            // 4. Menggabungkan data dosen, mata kuliah, dan jadwal.
            $hasil = $this->getDataIntegrasiDosen(
                $kodeDosen,
                $matkul,
                $pengampu
            );

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Data integrasi dosen berhasil diproses',

                'data' => [
                    'dosen' => $dosen,

                    'total_mata_kuliah' => count($hasil['mata_kuliah']),

                    'mata_kuliah' => $hasil['mata_kuliah'],

                    'total_jadwal' => count($hasil['jadwal']),

                    'jadwal' => $hasil['jadwal']
                ],

                'integrasi' => [
                    'api_dosen' => 'Terhubung',

                    'api_matkul' => !empty($matkul['status'])
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'api_pengampu' => !empty($pengampu['status'])
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    // Status ini berdasarkan koneksi API Jadwal,
                    // bukan berdasarkan ada atau tidaknya pengampu dosen.
                    'api_jadwal' => $hasil['status_jadwal']
                        ? 'Terhubung'
                        : 'Tidak terhubung',

                    'relasi_dosen' => 'kode_dosen',

                    'relasi_mata_kuliah' => 'nama_matkul',

                    'relasi_jadwal' => 'id_pengampu'
                ],

                'diagnostik' => [
                    'kode_dosen' => $kodeDosen,

                    'message_matkul' => $matkul['message'] ?? '',

                    'message_pengampu' =>
                        $pengampu['message'] ?? '',

                    'message_jadwal' => $hasil['message']
                ]

            ])->setStatusCode(200);

        } catch (Throwable $e) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal mengambil data integrasi dosen',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Menggabungkan data pengampu Kelompok 2,
     * mata kuliah Kelompok 3, dan jadwal Kelompok 2.
     */
    private function getDataIntegrasiDosen(
        string $kodeDosen,
        array $matkul,
        array $pengampu
    ): array {
        $hasilMatkul = [];
        $hasilJadwal = [];

        if (trim($kodeDosen) === '') {
            return [
                'mata_kuliah' => [],
                'jadwal' => [],
                'status_jadwal' => false,
                'message' => 'Kode dosen tidak tersedia'
            ];
        }

        // 1. Mengambil jadwal secara langsung untuk memeriksa
        // apakah API Jadwal benar-benar dapat diakses.
        $semuaJadwal = $this->jadwalApiClient->getJadwal();

        $jadwalBerhasil = !empty($semuaJadwal['status']);

        // 2. Memeriksa koneksi API Pengampu.
        if (empty($pengampu['status'])) {
            return [
                'mata_kuliah' => [],
                'jadwal' => [],
                'status_jadwal' => $jadwalBerhasil,
                'message' => 'API Pengampu gagal diakses. '
                    . ($pengampu['message'] ?? '')
            ];
        }

        // 3. Membuat indeks mata kuliah Kelompok 3 berdasarkan nama.
        $indeksMatkul = [];

        foreach (($matkul['data'] ?? []) as $item) {
            $nama = $this->normalisasiNama(
                $item['nama_matkul'] ?? ''
            );

            if ($nama !== '') {
                $indeksMatkul[$nama] = $item;
            }
        }

        // 4. Mengambil pengampu milik dosen yang sedang dicari.
        $pengampuDosen = [];

        foreach (($pengampu['data'] ?? []) as $item) {
            $kode = strtoupper(trim(
                $item['kode_dosen'] ?? ''
            ));

            if ($kode === strtoupper(trim($kodeDosen))) {
                $pengampuDosen[] = $item;
            }
        }

        // 5. Jika dosen tidak memiliki data pengampu.
        // Status API Jadwal tetap mengikuti hasil pemeriksaan koneksi.
        if (empty($pengampuDosen)) {
            return [
                'mata_kuliah' => [],
                'jadwal' => [],
                'status_jadwal' => $jadwalBerhasil,
                'message' => $jadwalBerhasil
                    ? 'API Jadwal terhubung, tetapi pengampu untuk dosen '
                        . $kodeDosen . ' tidak ditemukan'
                    : 'Pengampu untuk dosen ini tidak ditemukan. '
                        . 'API Jadwal gagal diakses: '
                        . ($semuaJadwal['message']
                            ?? 'Tidak ada informasi tambahan')
            ];
        }

        // 6. Membuat indeks jadwal berdasarkan id_pengampu.
        $indeksJadwal = [];

        if ($jadwalBerhasil) {
            foreach (($semuaJadwal['data'] ?? []) as $item) {
                $idPengampu = (string) (
                    $item['id_pengampu'] ?? ''
                );

                if ($idPengampu !== '') {
                    $indeksJadwal[$idPengampu][] = $item;
                }
            }
        }

        // 7. Menggabungkan pengampu dengan mata kuliah dan jadwal.
        foreach ($pengampuDosen as $item) {
            $namaMatkul = $item['nama_matkul'] ?? '';

            $keyMatkul = $this->normalisasiNama($namaMatkul);

            $dataMatkul = $indeksMatkul[$keyMatkul] ?? null;

            $idPengampu = (string) (
                $item['id_pengampu'] ?? ''
            );

            $jadwalItem = $indeksJadwal[$idPengampu] ?? [];

            $hasilMatkul[] = [
                'id_pengampu' => $item['id_pengampu'] ?? null,

                'kelas' => $item['nama_kelas'] ?? null,

                'semester' => $item['semester_kuliah'] ?? null,

                'mata_kuliah_kelompok_2' => $namaMatkul,

                'mata_kuliah_kelompok_3' => $dataMatkul,

                'status_pencocokan' => $dataMatkul
                    ? 'Cocok'
                    : 'Mata kuliah tidak ditemukan di Kelompok 3'
            ];

            foreach ($jadwalItem as $jadwal) {
                $hasilJadwal[] = [
                    'id_jadwal' => $jadwal['id_jadwal'] ?? null,

                    'id_pengampu' => $jadwal['id_pengampu'] ?? null,

                    'kode_dosen' => $jadwal['kode_dosen'] ?? $kodeDosen,

                    'nama_dosen' => $jadwal['nama_dosen'] ?? null,

                    'kode_matkul' => $dataMatkul['kode_matkul'] ?? null,

                    'nama_matkul' => $dataMatkul['nama_matkul']
                        ?? $namaMatkul,

                    'kelas' => $jadwal['nama_kelas']
                        ?? ($item['nama_kelas'] ?? null),

                    'semester' => $jadwal['semester_kuliah']
                        ?? ($item['semester_kuliah'] ?? null),

                    'hari' => $jadwal['hari'] ?? null,

                    'jam_mulai' => $jadwal['jam_mulai'] ?? null,

                    'jam_selesai' => $jadwal['jam_selesai'] ?? null,

                    'ruang' => $jadwal['kode_ruang'] ?? null,

                    'status_jadwal' => $jadwal['status_jadwal'] ?? null
                ];
            }
        }

        return [
            'mata_kuliah' => $hasilMatkul,

            'jadwal' => $hasilJadwal,

            'status_jadwal' => $jadwalBerhasil,

            'message' => $jadwalBerhasil
                ? (
                    empty($hasilJadwal)
                        ? 'API Jadwal terhubung, tetapi jadwal untuk pengampu '
                            . 'dosen ini belum ditemukan'
                        : 'Data pengampu dan jadwal berhasil diproses'
                )
                : (
                    $semuaJadwal['message']
                    ?? 'Gagal mengambil data jadwal'
                )
        ];
    }

    /**
     * Menyeragamkan nama mata kuliah untuk pencocokan.
     */
    private function normalisasiNama(string $nama): string
    {
        $nama = trim($nama);

        $nama = preg_replace('/\s+/', ' ', $nama);

        return mb_strtolower($nama);
    }

    /**
     * Mengambil data mata kuliah Kelompok 3.
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

    /**
     * GET /api/integrasi/cek-jadwal
     * Pemeriksaan data API Kelompok 2.
     */
    public function cekJadwal()
    {
        try {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Pemeriksaan API Kelompok 2',

                'data' => [
                    'dosen' => $this->jadwalApiClient->getDosen(),

                    'pengampu' => $this->jadwalApiClient->getPengampu(),

                    'jadwal' => $this->jadwalApiClient->getJadwal(),

                    'mata_kuliah' => $this->jadwalApiClient->getMataKuliah()
                ]

            ])->setStatusCode(200);

        } catch (Throwable $e) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal memeriksa API Kelompok 2',
                'error' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
