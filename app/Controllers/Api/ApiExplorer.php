<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use Throwable;

class ApiExplorer extends Controller
{
    /**
     * Menampilkan halaman API Explorer.
     */
   
public function index()
{
    // Membaca pilihan menu dari URL: group=2, group=3, atau tanpa group.
    $group = (string) $this->request->getGet('group');

    $group2BaseUrl = trim((string) getenv('API_GROUP2_BASE_URL'));
    $group3BaseUrl = trim((string) getenv('API_GROUP3_BASE_URL'));

    $group2Url = $group2BaseUrl !== ''
        ? rtrim($group2BaseUrl, '/') 
        : '';

    $group3Url = $group3BaseUrl !== ''
        ? rtrim($group3BaseUrl, '/') . '/matkul'
        : '';

    $group4Url = 'https://api-data-dosen-trpl-kelompok-4.hostless.app/api/dosen';

    // Menentukan halaman berdasarkan menu yang diklik.
    if ($group === '2') {
        $heading = 'Jadwal Kuliah';
        $subtitle = 'API Kelompok 2 - Jadwal Perkuliahan';
        $active = 'jadwal';
        $defaultUrl = $group2Url;
        $pageDescription = 'Halaman pengujian API Jadwal Kuliah Kelompok 2.';
        $apiAvailable = $group2Url !== '';

    } elseif ($group === '3') {
        $heading = 'Mata Kuliah';
        $subtitle = 'API Kelompok 3 - Data Mata Kuliah';
        $active = 'matkul';
        $defaultUrl = $group3Url;
        $pageDescription = 'Halaman pengujian API Mata Kuliah Kelompok 3.';
        $apiAvailable = $group3Url !== '';

    } else {
        $heading = 'Integrasi API';
        $subtitle = 'API Explorer - Kelompok 4, 3, dan 2';
        $active = 'api-explorer';
        $defaultUrl = $group4Url;
        $pageDescription = 'Uji dan panggil endpoint API dari setiap kelompok.';
        $apiAvailable = true;
    }

    return view('dosen/api_explorer', [
        'title'          => $heading . ' | Data Dosen TRPL',
        'heading'        => $heading,
        'subtitle'       => $subtitle,
        'active'         => $active,
        'group'          => $group,
        'group2Url'      => $group2Url,
        'group3Url'      => $group3Url,
        'group4Url'      => $group4Url,
        'defaultUrl'     => $defaultUrl,
        'pageDescription'=> $pageDescription,
        'apiAvailable'   => $apiAvailable
    ]);
}

    public function send()
    {
        $method = strtoupper(
            trim((string) $this->request->getPost('method'))
        );

        $url = trim(
            (string) $this->request->getPost('url')
        );

        $body = (string) $this->request->getPost('body');

        // =====================================
        // VALIDASI METHOD
        // =====================================

        $allowedMethods = [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'HEAD',
            'OPTIONS'
        ];

        if (!in_array($method, $allowedMethods, true)) {
            return $this->jsonError(
                'Metode HTTP tidak valid.',
                400
            );
        }

        // =====================================
        // VALIDASI URL
        // =====================================

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->jsonError(
                'URL endpoint tidak valid.',
                400
            );
        }

        $parts = parse_url($url);

        if (
            !$parts ||
            strtolower($parts['scheme'] ?? '') !== 'https' ||
            empty($parts['host']) ||
            isset($parts['user']) ||
            isset($parts['pass']) ||
            isset($parts['port'])
        ) {
            return $this->jsonError(
                'Gunakan URL HTTPS yang valid.',
                400
            );
        }

        // =====================================
        // VALIDASI HOST API
        // =====================================

        $configuredHosts = getenv('API_EXPLORER_ALLOWED_HOSTS')
            ?: 'api-data-dosen-trpl-kelompok-4.hostless.app';

        $allowedHosts = array_filter(
            array_map(
                static fn($host) => strtolower(trim($host)),
                explode(',', $configuredHosts)
            )
        );

        $host = strtolower($parts['host']);

        if (!in_array($host, $allowedHosts, true)) {
            return $this->jsonError(
                'Host API belum diizinkan dalam konfigurasi.',
                403
            );
        }

        // =====================================
        // VALIDASI JSON
        // =====================================

        $bodyMethods = [
            'POST',
            'PUT',
            'PATCH'
        ];

        if (
            in_array($method, $bodyMethods, true) &&
            $body !== ''
        ) {
            json_decode($body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonError(
                    'Format JSON tidak valid: ' . json_last_error_msg(),
                    400
                );
            }
        }

        // =====================================
        // HEADER REQUEST
        // =====================================

        $headers = [
            'Accept' => 'application/json'
        ];

        if (in_array($method, $bodyMethods, true)) {
            $headers['Content-Type'] = 'application/json';
        }

        // =====================================
        // API KEY KELOMPOK 4
        // =====================================

        if (
            $host === 'api-data-dosen-trpl-kelompok-4.hostless.app'
        ) {
           $apiKey = trim(
    (string) getenv('API_ADMIN_KEY')
);

            if ($apiKey === '') {
                return $this->jsonError(
                    'API Key Kelompok 4 belum dikonfigurasi di file .env.',
                    500
                );
            }

            // API Key dikirim untuk seluruh HTTP Method.
            $headers['X-API-KEY'] = $apiKey;
        }

        // =====================================
        // REQUEST OPTIONS
        // =====================================

        $options = [
            'headers'         => $headers,
            'http_errors'     => false,
            'timeout'         => 25,
            'connect_timeout' => 10,
            'allow_redirects' => false,
            'verify'          => true
        ];

        if (
            in_array($method, $bodyMethods, true) &&
            $body !== ''
        ) {
            $options['body'] = $body;
        }

        // =====================================
        // KIRIM REQUEST
        // =====================================

        $start = microtime(true);

        try {
            $client = \Config\Services::curlrequest();

            $response = $client->request(
                $method,
                $url,
                $options
            );

            $duration = round(
                (microtime(true) - $start) * 1000
            );

            $responseBody = (string) $response->getBody();

            $statusCode = $response->getStatusCode();

            $reason = $response->getReasonPhrase();

            // =================================
            // RESPONSE API
            // =================================

            return $this->response->setJSON([
                'success'  => $statusCode >= 200 && $statusCode < 300,
                'status'   => $statusCode,
                'reason'   => $reason,
                'duration' => $duration,
                'size'     => strlen($responseBody),
                'body'     => $responseBody
            ]);

        } catch (Throwable $e) {

            log_message(
                'error',
                'API Explorer Error: ' . $e->getMessage()
            );

            $duration = round(
                (microtime(true) - $start) * 1000
            );

            return $this->response->setJSON([
                'success'  => false,
                'status'   => 502,
                'reason'   => 'Bad Gateway',
                'duration' => $duration,
                'size'     => 0,
                'body'     => 'Tidak dapat terhubung ke server API. Periksa koneksi atau alamat endpoint.'
            ]);
        }
    }

    /**
     * Menghasilkan response error JSON.
     */
    private function jsonError(
        string $message,
        int $httpStatus = 400
    ) {
        $responseData = [
            'success'  => false,
            'status'   => $httpStatus,
            'reason'   => $this->getStatusReason($httpStatus),
            'duration' => 0,
            'size'     => strlen($message),
            'body'     => $message
        ];

        return $this->response
            ->setStatusCode($httpStatus)
            ->setJSON($responseData);
    }

    /**
     * Mendapatkan nama status HTTP.
     */
    private function getStatusReason(int $status): string
    {
        $reasons = [
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            408 => 'Request Timeout',
            409 => 'Conflict',
            415 => 'Unsupported Media Type',
            422 => 'Unprocessable Entity',
            429 => 'Too Many Requests',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout'
        ];

        return $reasons[$status] ?? 'HTTP Error';
    }
}
