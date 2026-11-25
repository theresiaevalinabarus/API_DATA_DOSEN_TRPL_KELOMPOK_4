<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = trim((string) env('API_ADMIN_KEY', ''));
        $requestKey = trim($request->getHeaderLine('X-API-KEY'));

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