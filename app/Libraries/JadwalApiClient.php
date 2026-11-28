<?php

namespace App\Libraries;

class JadwalApiClient
{
    private string $baseUrl = 'https://api.jsdwaltrpl.my.id/api/v1/';

    /**
     * Mengambil seluruh data dosen Kelompok 2.
     */
    public function getDosen(): array
    {
        return $this->getAllPages('dosen');
    }

    /**
     * Mengambil seluruh data pengampu Kelompok 2.
     */
    public function getPengampu(): array
    {
        return $this->getAllPages('pengampu');
    }

    /**
     * Mengambil seluruh data jadwal Kelompok 2.
     */
    public function getJadwal(): array
    {
        return $this->getAllPages('jadwal');
    }

    /**
     * Mengambil seluruh data mata kuliah Kelompok 2.
     */
    public function getMataKuliah(): array
    {
        return $this->getAllPages('mata-kuliah');
    }

    /**
     * Mengambil jadwal berdasarkan ID dosen Kelompok 2.
     * Contoh: dosen/7/jadwal
     */
    public function getJadwalDosen(int $idDosen): array
    {
        if ($idDosen <= 0) {
            return [
                'status' => false,
                'message' => 'ID dosen harus lebih besar dari 0',
                'data' => [],
                'http_status' => 400
            ];
        }

        return $this->request('dosen/' . $idDosen . '/jadwal');
    }

    /**
     * Mengambil seluruh halaman dari endpoint paginated.
     */
    private function getAllPages(string $endpoint): array
    {
        $firstPage = $this->request($endpoint . '?page=1');

        if (!$firstPage['status']) {
            return $firstPage;
        }

        $allData = $firstPage['data'] ?? [];
        $totalPages = (int) ($firstPage['meta']['total_pages'] ?? 1);

        for ($page = 2; $page <= $totalPages; $page++) {
            $result = $this->request(
                $endpoint . '?page=' . $page
            );

            if (!$result['status']) {
                return [
                    'status' => false,
                    'total' => count($allData),
                    'data' => $allData,
                    'meta' => $firstPage['meta'],
                    'message' => 'Gagal mengambil halaman ' . $page
                        . ' dari endpoint ' . $endpoint,
                    'http_status' => $result['http_status']
                ];
            }

            $allData = array_merge(
                $allData,
                $result['data'] ?? []
            );
        }

        return [
            'status' => true,
            'total' => count($allData),
            'data' => $allData,
            'meta' => $firstPage['meta'],
            'message' => 'Seluruh data berhasil diambil',
            'http_status' => $firstPage['http_status']
        ];
    }

    /**
     * Mengirim GET request ke API Kelompok 2.
     */
    private function request(string $endpoint): array
    {
        $url = $this->baseUrl . $endpoint;

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: Mozilla/5.0'
            ]
        ]);

        $response = curl_exec($ch);
        $httpStatus = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        curl_close($ch);

        if ($response === false) {
            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'meta' => [],
                'message' => 'Gagal menghubungi API Kelompok 2: ' . $error,
                'http_status' => $httpStatus
            ];
        }

        $json = json_decode($response, true);

        if (!is_array($json)) {
            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'meta' => [],
                'message' => 'Respons API Kelompok 2 bukan JSON valid',
                'http_status' => $httpStatus
            ];
        }

        $data = $json['data'] ?? [];

        $items = is_array($data) && array_is_list($data)
            ? $data
            : [];

        return [
            'status' => ($httpStatus >= 200 && $httpStatus < 300)
                && (($json['status'] ?? '') === 'success'),
            'total' => $json['meta']['total']
                ?? $json['jumlah_data']
                ?? count($items),
            'data' => $data,
            'meta' => $json['meta'] ?? [],
            'message' => $json['message'] ?? 'Respons API diterima',
            'http_status' => $httpStatus
        ];
    }
}
