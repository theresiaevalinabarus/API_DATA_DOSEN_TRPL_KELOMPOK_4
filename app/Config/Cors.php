<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Cross-Origin Resource Sharing (CORS) Configuration
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
 */
class Cors extends BaseConfig
{
    /**
     * Default CORS configuration.
     *
     * @var array
     */
    public array $default = [

        // Website Kelompok 3 yang diizinkan mengakses API Dosen
        'allowedOrigins' => [
            'http://siakad-matkul.rf.gd',
        ],

        'allowedOriginsPatterns' => [],

        // Tidak menggunakan cookie lintas origin
        'supportsCredentials' => false,

        // Header yang diizinkan
        'allowedHeaders' => [
            'Content-Type',
            'Authorization',
            'X-API-KEY',
            'Accept',
        ],

        'exposedHeaders' => [],

        // HTTP methods yang diizinkan
        'allowedMethods' => [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'OPTIONS',
        ],

        // Cache preflight selama 2 jam
        'maxAge' => 7200,
    ];
}
