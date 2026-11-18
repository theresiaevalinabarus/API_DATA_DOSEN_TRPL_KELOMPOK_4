<?php
namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = env('API_ADMIN_KEY');
        $requestKey = $request->getHeaderLine('X-API-KEY');

        if (
            empty($apiKey) ||
            empty($requestKey) ||
            !hash_equals($apiKey, $requestKey)
        ) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Akses ditolak. API Key tidak valid.'
                ]);
        }
    }

    public function after(
        RequestInterface $request,
        ResponseInterface $response,
        $arguments = null
    ) {
        // Tidak ada proses tambahan.
    }
}
