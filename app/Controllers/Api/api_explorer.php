<?php


namespace App\Controllers\Api;
use CodeIgniter\Controller;
use Throwable;

class ApiExplorer extends Controller
{
    public function index()
    {
        return view('dosen/api_explorer', [
            'title'     => 'API Explorer | Data Dosen TRPL',
            'heading'   => 'Integrasi API',
            'subtitle'  => 'API Explorer - Kelompok 4 dan Kelompok 3',
            'active'    => 'api-explorer',
            'group4Url' => 'https://api-data-dosen-trpl-kelompok-4.hostless.app/api/dosen',
            'group3Url' => getenv('API_GROUP3_BASE_URL')
                ? rtrim(getenv('API_GROUP3_BASE_URL'), '/') . '/api/v1/matkul'
                : ''
        ]);
    }

    public function send()
    {
        $method = strtoupper(trim((string) $this->request->getPost('method')));
        $url    = trim((string) $this->request->getPost('url'));
        $body   = (string) $this->request->getPost('body');

        if (!in_array($method, ['GET', 'POST', 'PUT', 'DELETE'], true)) {
            return $this->jsonError('Metode HTTP tidak valid.');
        }

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return $this->jsonError('URL endpoint tidak valid.');
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
            return $this->jsonError('Gunakan URL HTTPS yang valid.');
        }

        // Host yang diizinkan
        $configuredHosts = getenv('API_EXPLORER_ALLOWED_HOSTS')
            ?: 'api-data-dosen-trpl-kelompok-4.hostless.app';

        $allowedHosts = array_filter(array_map(
            static fn($host) => strtolower(trim($host)),
            explode(',', $configuredHosts)
        ));

        $host = strtolower($parts['host']);

        if (!in_array($host, $allowedHosts, true)) {
            return $this->jsonError(
                'Host API belum diizinkan dalam konfigurasi.'
            );
        }

        // Validasi JSON
        if (in_array($method, ['POST', 'PUT'], true) && $body !== '') {
            json_decode($body);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->jsonError('Format JSON tidak valid.');
            }
        }

        $headers = [
            'Accept' => 'application/json'
        ];

        if (in_array($method, ['POST', 'PUT'], true)) {
            $headers['Content-Type'] = 'application/json';
        }

      // =====================================
// API KEY KELOMPOK 4
// =====================================

if ($host === 'api-data-dosen-trpl-kelompok-4.hostless.app') {

    $apiKey = trim(
        (string) $this->request->getPost('api_key')
    );

    // GET boleh tanpa API Key.
    // POST, PUT, PATCH, DELETE wajib menggunakan API Key.
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

    // API Key hanya dikirim jika kolom diisi.
    if ($apiKey !== '') {
        $headers['X-API-KEY'] = $apiKey;
    }
}
    }

    private function jsonError(string $message)
    {
        return $this->response->setJSON([
            'success'  => false,
            'status'   => 0,
            'reason'   => 'Request Error',
            'duration' => 0,
            'size'     => 0,
            'body'     => $message
        ]);
    }
}
