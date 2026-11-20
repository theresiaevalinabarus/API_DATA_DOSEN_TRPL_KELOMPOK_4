<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Mengambil API Key dari file .env
        $apiKey = trim((string) env('API_ADMIN_KEY', ''));

        // Mengambil API Key dari HTTP Header
        $requestKey = trim($request->getHeaderLine('X-API-KEY'));

        // Memeriksa kecocokan API Key
        if (
            $apiKey === '' ||
            $requestKey === '' ||
            !hash_equals($apiKey, $requestKey)
        ) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status'  => false,
                    'message' => 'Akses ditolak. API Key tidak valid.'
                ]);
        }

        // API Key valid, request dilanjutkan.
        return null;
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak ada proses tambahan.
    }
}
