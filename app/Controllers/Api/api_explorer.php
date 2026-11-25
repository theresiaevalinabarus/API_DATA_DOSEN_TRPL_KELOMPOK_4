<?php

namespace App\Controllers\Api;

use CodeIgniter\Controller;
use Throwable;

class ApiExplorer extends Controller
{
    public function index()
    {
        $group = (string) $this->request->getGet('group');

        // Endpoint API Kelompok 4
        $group4Url = site_url('api/dosen');

        // Proxy API Mata Kuliah Kelompok 3
        $group3Url = rtrim(base_url(), '/')
            . '/matkul_proxy.php?path=matkul';

        // URL default
        $defaultUrl = $group === '3'
            ? $group3Url
            : $group4Url;

        $heading = $group === '3'
            ? 'Mata Kuliah'
            : 'Integrasi API';

        return view('dosen/api_explorer', [
            'title'           => $heading . ' | Data Dosen TRPL',
            'heading'         => $heading,
            'subtitle'        => 'API Explorer - Kelompok 4 dan Kelompok 3',
            'active'          => $group === '3' ? 'matkul' : 'api-explorer',
            'group'           => $group,
            'group4Url'       => $group4Url,
            'group3Url'       => $group3Url,
            'defaultUrl'      => $defaultUrl,
            'pageDescription' => 'Uji dan panggil endpoint API dari setiap kelompok.',
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
            return $this->jsonError('Metode HTTP tidak valid.', 400);
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->jsonError('URL endpoint tidak valid.', 400);
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
            return $this->jsonError('Gunakan URL HTTPS yang valid.', 400);
        }

        // Validasi host API eksternal
        $configuredHosts = getenv('API_EXPLORER_ALLOWED_HOSTS')
            ?: 'api-data-dosen-trpl-kelompok-4.hostless.app';

        $allowedHosts = array_filter(array_map(
            static fn($host) => strtolower(trim($host)),
            explode(',', $configuredHosts)
        ));

        $host = strtolower($parts['host']);

        if (!in_array($host, $allowedHosts, true)) {
            return $this->jsonError(
                'Host API belum diizinkan dalam konfigurasi.',
                403
            );
        }

        // Validasi JSON
        $bodyMethods = ['POST', 'PUT', 'PATCH'];

        if (in_array($method, $bodyMethods, true) && $body !== '') {
            json_decode($body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonError(
                    'Format JSON tidak valid: ' . json_last_error_msg(),
                    400
                );
            }
        }

        $headers = [
            'Accept' => 'application/json'
        ];

        if (in_array($method, $bodyMethods, true)) {
            $headers['Content-Type'] = 'application/json';
        }

        // API Key Kelompok 4
        if ($host === 'api-data-dosen-trpl-kelompok-4.hostless.app') {
            $apiKey = trim(
                (string) $this->request->getPost('api_key')
            );

            $protectedMethods = [
                'POST',
                'PUT',
                'PATCH',
                'DELETE'
            ];

            if (
                in_array($method, $protectedMethods, true) &&
                $apiKey === ''
            ) {
                return $this->jsonError(
                    'API Key wajib diisi untuk metode ' . $method . '.',
                    401
                );
            }

            if ($apiKey !== '') {
                $headers['X-API-KEY'] = $apiKey;
            }
        }

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

        $start = microtime(true);

        try {
            $client = \Config\Services::curlrequest();

            $response = $client->request(
                $method,
                $url,
                $options
            );

            $responseBody = (string) $response->getBody();

            $statusCode = $response->getStatusCode();

            $duration = round(
                (microtime(true) - $start) * 1000
            );

            return $this->response->setJSON([
                'success'  => $statusCode >= 200 && $statusCode < 300,
                'status'   => $statusCode,
                'reason'   => $response->getReasonPhrase(),
                'duration' => $duration,
                'size'     => strlen($responseBody),
                'body'     => $responseBody
            ]);

        } catch (Throwable $e) {

            log_message(
                'error',
                'API Explorer Error: ' . $e->getMessage()
            );

            return $this->jsonError(
                'Tidak dapat terhubung ke server API.',
                502
            );
        }
    }

    private function jsonError(
        string $message,
        int $httpStatus = 400
    ) {
        return $this->response
            ->setStatusCode($httpStatus)
            ->setJSON([
                'success'  => false,
                'status'   => $httpStatus,
                'reason'   => $this->getStatusReason($httpStatus),
                'duration' => 0,
                'size'     => strlen($message),
                'body'     => $message
            ]);
    }

    private function getStatusReason(int $status): string
    {
        $reasons = [
            200 => 'OK',
            201 => 'Created',
            204 => 'No Content',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            422 => 'Unprocessable Entity',
            500 => 'Internal Server Error',
            502 => 'Bad Gateway'
        ];

        return $reasons[$status] ?? 'HTTP Error';
    }
}
