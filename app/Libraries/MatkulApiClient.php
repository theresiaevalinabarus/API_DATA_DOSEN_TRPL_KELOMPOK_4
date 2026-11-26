<?php

namespace App\Libraries;

class MatkulApiClient
{
    private string $baseUrl = 'http://siakad-matkul.rf.gd/api/';

    public function getMataKuliah(): array
    {
        $url = $this->baseUrl . 'matkul';

        $res = $this->fetchInfinityFree($url);

        if ($res === false) {
            return [
                'status' => false,
                'message' => 'Gagal menghubungi API Mata Kuliah'
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

        if ($res === false) {
            return [
                'status' => false,
                'message' => 'Request ulang API Mata Kuliah gagal'
            ];
        }

        $data = json_decode($res, true);

        if (!is_array($data)) {
            return [
                'status' => false,
                'message' => 'Respons API Mata Kuliah bukan JSON yang valid'
            ];
        }

        return $data;
    }

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
