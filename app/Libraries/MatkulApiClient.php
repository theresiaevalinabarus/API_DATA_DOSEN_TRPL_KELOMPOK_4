<?php

namespace App\Libraries;

class MatkulApiClient
{
    private string $baseUrl = 'http://siakad-matkul.rf.gd/api/';

    public function getMataKuliah(): array
    {
        $url = $this->baseUrl . 'matkul';

        // Mengambil data dari API Mata Kuliah
        $res = $this->fetchInfinityFree($url);

        if ($res === false) {
            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'message' => 'Gagal menghubungi API Mata Kuliah',
                'http_status' => 0
            ];
        }

        // Memproses challenge AES InfinityFree
        if (strpos($res, 'aes.js') !== false) {

            preg_match_all(
                '/toNumbers\\(\"([a-f0-9]+)\"\\)/',
                $res,
                $matches
            );

            if (count($matches[1]) >= 3) {

                $key = hex2bin($matches[1][0]);
                $iv  = hex2bin($matches[1][1]);
                $enc = hex2bin($matches[1][2]);

                if ($key !== false && $iv !== false && $enc !== false) {

                    $dec = openssl_decrypt(
                        $enc,
                        'AES-128-CBC',
                        $key,
                        OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING,
                        $iv
                    );

                    if ($dec !== false) {

                        $cookie = bin2hex($dec);

                        $res = $this->fetchInfinityFree(
                            $url . '?i=1',
                            $cookie
                        );
                    }
                }
            }
        }

        if ($res === false) {
            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'message' => 'Request ulang API Mata Kuliah gagal',
                'http_status' => 0
            ];
        }

        // Mengubah respons JSON menjadi array
        $data = json_decode($res, true);

        if (!is_array($data)) {
            return [
                'status' => false,
                'total' => 0,
                'data' => [],
                'message' => 'Respons API Mata Kuliah bukan JSON yang valid',
                'http_status' => 0
            ];
        }

        // Menyeragamkan struktur respons API
        return [
            'status' => $data['status'] ?? false,
            'total' => $data['total'] ?? count($data['data'] ?? []),
            'data' => $data['data'] ?? [],
            'message' => $data['message'] ?? 'Respons API diterima',
            'http_status' => 200
        ];
    }

    /**
     * Mengirim request ke API InfinityFree.
     */
    private function fetchInfinityFree(
        string $url,
        string $cookie = ''
    ) {
        $ch = curl_init($url);

        $headers = [
            'User-Agent: Mozilla/5.0'
        ];

        if ($cookie !== '') {
            $headers[] = 'Cookie: __test=' . $cookie;
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30
        ]);

        $res = curl_exec($ch);

        curl_close($ch);

        return $res;
    }
}
