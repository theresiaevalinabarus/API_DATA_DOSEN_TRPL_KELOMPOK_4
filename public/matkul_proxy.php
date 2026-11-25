
<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$allowedMethods = ['GET', 'POST', 'PUT', 'DELETE'];

$method = $_SERVER['REQUEST_METHOD'];

if (!in_array($method, $allowedMethods, true)) {
    http_response_code(405);
    echo json_encode([
        'status' => false,
        'message' => 'Metode HTTP tidak diizinkan'
    ]);
    exit;
}

$endpoint = $_GET['path'] ?? 'matkul';

// Hanya izinkan endpoint matkul
if (!preg_match('#^matkul(?:/[a-zA-Z0-9_-]+)*$#', $endpoint)) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => 'Endpoint tidak valid'
    ]);
    exit;
}

$targetUrl = 'http://siakad-matkul.rf.gd/api/' . $endpoint;

function fetchInfinityFree($url, $method = 'GET', $body = null, $cookie = '')
{
    $ch = curl_init($url);

    $headers = ['User-Agent: Mozilla/5.0'];

    if ($cookie !== '') {
        $headers[] = 'Cookie: __test=' . $cookie;
    }

    if ($body !== null && $body !== '') {
        $headers[] = 'Content-Type: application/json';
    }

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST  => $method,
        CURLOPT_POSTFIELDS     => $body,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_TIMEOUT        => 30,
    ]);

    $res = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if ($res === false) {
        return json_encode([
            'status' => false,
            'message' => 'Koneksi proxy gagal: ' . $error
        ]);
    }

    return $res;
}

$body = file_get_contents('php://input');

$res = fetchInfinityFree($targetUrl, $method, $body);

// Memproses challenge aes.js InfinityFree
if (strpos($res, 'aes.js') !== false) {

    preg_match_all(
        '/toNumbers\("([a-f0-9]+)"\)/',
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

            $res = fetchInfinityFree(
                $targetUrl . '?i=1',
                $method,
                $body,
                $cookie
            );
        }
    }
}

echo $res;
