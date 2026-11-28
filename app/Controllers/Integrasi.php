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

    public function index()
    {
        try {
            // 1. Ambil seluruh dosen dari database lokal
            $dosenLokal = $this->dosenModel
                ->orderBy('nama', 'ASC')
                ->findAll();

            // 2. Ambil data dari API kelompok lain
            $matkulResponse = $this->matkulApiClient->getMataKuliah();
            $dosenApiResponse = $this->jadwalApiClient->getDosen();
            $pengampuResponse = $this->jadwalApiClient->getPengampu();
            $jadwalResponse = $this->jadwalApiClient->getJadwal();

            $matkulData = $matkulResponse['data'] ?? [];
            $dosenApiData = $dosenApiResponse['data'] ?? [];
            $pengampuData = $pengampuResponse['data'] ?? [];
            $jadwalData = $jadwalResponse['data'] ?? [];

            // Pastikan data berbentuk array
            $matkulData = is_array($matkulData) ? $matkulData : [];
            $dosenApiData = is_array($dosenApiData) ? $dosenApiData : [];
            $pengampuData = is_array($pengampuData) ? $pengampuData : [];
            $jadwalData = is_array($jadwalData) ? $jadwalData : [];

            // 3. Buat indeks mata kuliah berdasarkan nama
            $indeksMatkul = [];

            foreach ($matkulData as $matkul) {
                if (!is_array($matkul)) {
                    continue;
                }

                $namaMatkul = $this->normalisasiNama(
                    $matkul['nama_matkul']
                    ?? $matkul['nama']
                    ?? $matkul['mata_kuliah']
                    ?? ''
                );

                if ($namaMatkul !== '') {
                    $indeksMatkul[$namaMatkul] = $matkul;
                }
            }

            // 4. Buat indeks jadwal berdasarkan id_pengampu
            $indeksJadwal = [];

            foreach ($jadwalData as $jadwal) {
                if (!is_array($jadwal)) {
                    continue;
                }

                $idPengampu = $jadwal['id_pengampu'] ?? null;

                if ($idPengampu !== null) {
                    $indeksJadwal[(string) $idPengampu][] = $jadwal;
                }
            }

            // 5. Gabungkan seluruh data dosen dengan data API
            $hasilIntegrasi = [];

            foreach ($dosenLokal as $dosen) {
                $kodeDosen = strtoupper(trim($dosen['kode_dosen'] ?? ''));

                $pengampuDosen = [];

                foreach ($pengampuData as $pengampu) {
                    if (!is_array($pengampu)) {
                        continue;
                    }

                    $kodePengampu = strtoupper(
                        trim($pengampu['kode_dosen'] ?? '')
                    );

                    if ($kodeDosen !== '' && $kodeDosen === $kodePengampu) {
                        $pengampuDosen[] = $pengampu;
                    }
                }

                $daftarMatkul = [];
                $daftarJadwal = [];

                foreach ($pengampuDosen as $pengampu) {
                    $namaMatkulAsli = $pengampu['nama_matkul'] ?? '';
                    $namaMatkulNormal = $this->normalisasiNama($namaMatkulAsli);

                    $dataMatkul = $indeksMatkul[$namaMatkulNormal] ?? null;

                    $idPengampu = $pengampu['id_pengampu'] ?? null;
                    $jadwalPengampu = $idPengampu !== null
                        ? ($indeksJadwal[(string) $idPengampu] ?? [])
                        : [];

                    $daftarMatkul[] = [
                        'id_pengampu' => $idPengampu,
                        'nama_matkul' => $namaMatkulAsli ?: '-',
                        'kode_matkul' => $dataMatkul['kode_matkul']
                            ?? $dataMatkul['kode']
                            ?? '-',
                        'status_matkul' => $dataMatkul !== null,
                        'nama_kelas' => $pengampu['nama_kelas'] ?? '-',
                        'semester' => $pengampu['semester_kuliah']
                            ?? $pengampu['semester']
                            ?? '-',
                        'jumlah_jadwal' => count($jadwalPengampu),
                    ];

                    foreach ($jadwalPengampu as $jadwal) {
                        $daftarJadwal[] = [
                            'nama_matkul' => $namaMatkulAsli ?: '-',
                            'kode_matkul' => $dataMatkul['kode_matkul']
                                ?? $dataMatkul['kode']
                                ?? '-',
                            'nama_kelas' => $jadwal['nama_kelas']
                                ?? $pengampu['nama_kelas']
                                ?? '-',
                            'semester' => $jadwal['semester_kuliah']
                                ?? $pengampu['semester_kuliah']
                                ?? $pengampu['semester']
                                ?? '-',
                            'hari' => $jadwal['hari'] ?? '-',
                            'jam_mulai' => $jadwal['jam_mulai'] ?? '-',
                            'jam_selesai' => $jadwal['jam_selesai'] ?? '-',
                            'ruangan' => $jadwal['kode_ruang']
                                ?? $jadwal['nama_ruang']
                                ?? '-',
                            'status_jadwal' => $jadwal['status_jadwal'] ?? '-',
                        ];
                    }
                }

                $hasilIntegrasi[] = [
                    'id_dosen' => $dosen['id_dosen'] ?? null,
                    'kode_dosen' => $kodeDosen ?: '-',
                    'nama' => $dosen['nama'] ?? '-',
                    'nip' => $dosen['nip'] ?? '-',
                    'jumlah_matkul' => count($daftarMatkul),
                    'jumlah_jadwal' => count($daftarJadwal),
                    'mata_kuliah' => $daftarMatkul,
                    'jadwal' => $daftarJadwal,
                    'status' => count($daftarMatkul) > 0
                        ? 'Ditemukan'
                        : 'Belum ditemukan',
                ];
            }

            // 6. Hitung statistik
            $totalDosen = count($hasilIntegrasi);
            $dosenDitemukan = 0;
            $totalPengajaran = 0;
            $totalJadwal = 0;

            foreach ($hasilIntegrasi as $item) {
                if ($item['jumlah_matkul'] > 0) {
                    $dosenDitemukan++;
                }

                $totalPengajaran += $item['jumlah_matkul'];
                $totalJadwal += $item['jumlah_jadwal'];
            }

            // 7. Status koneksi API
            $statusApi = [
                'dosen_lokal' => true,
                'matkul' => !empty($matkulResponse['status']),
                'dosen_api' => !empty($dosenApiResponse['status']),
                'pengampu' => !empty($pengampuResponse['status']),
                'jadwal' => !empty($jadwalResponse['status']),
            ];

            $data = [
                'title' => 'Integrasi API',
                'hasil_integrasi' => $hasilIntegrasi,

                'total_dosen' => $totalDosen,
                'dosen_ditemukan' => $dosenDitemukan,
                'dosen_belum_ditemukan' => $totalDosen - $dosenDitemukan,
                'total_pengajaran' => $totalPengajaran,
                'total_jadwal' => $totalJadwal,

                'total_matkul_api' => $matkulResponse['total']
                    ?? count($matkulData),
                'total_dosen_api' => $dosenApiResponse['total']
                    ?? count($dosenApiData),
                'total_pengampu_api' => $pengampuResponse['total']
                    ?? count($pengampuData),
                'total_jadwal_api' => $jadwalResponse['total']
                    ?? count($jadwalData),

                'status_api' => $statusApi,

                'diagnostik' => [
                    'matkul' => $matkulResponse['message'] ?? '-',
                    'dosen' => $dosenApiResponse['message'] ?? '-',
                    'pengampu' => $pengampuResponse['message'] ?? '-',
                    'jadwal' => $jadwalResponse['message'] ?? '-',
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

    private function normalisasiNama(string $nama): string
    {
        $nama = trim($nama);
        $nama = preg_replace('/\s+/', ' ', $nama);

        return mb_strtolower($nama);
    }
}
