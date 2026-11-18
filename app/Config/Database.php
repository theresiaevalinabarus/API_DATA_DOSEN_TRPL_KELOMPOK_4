<?php
namespace Config;
use CodeIgniter\Database\Config;
class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;

    public string $defaultGroup = 'default';

    public array $default = [];

    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => '',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => true,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
        'synchronous' => null,
        'dateFormat'  => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];

    public function __construct()
    {
        parent::__construct();

        $this->default = [
            'DSN'        => '',
            'hostname'   => getenv('DB_HOST') ?: 'localhost',
            'username'   => getenv('DB_USERNAME') ?: '',
            'password'   => getenv('DB_PASSWORD') ?: '',
            'database'   => getenv('DB_DATABASE') ?: '',
            'schema'     => getenv('DB_SCHEMA') ?: 'public',
            'DBDriver'   => getenv('DB_DRIVER') ?: 'Postgre',
            'DBPrefix'   => '',
            'pConnect'   => false,
            'DBDebug'    => ENVIRONMENT !== 'production',
            'charset'    => 'utf8',
            'swapPre'    => '',
            'failover'   => [],
            'port'       => (int) (getenv('DB_PORT') ?: 5432),
            'dateFormat' => [
                'date'     => 'Y-m-d',
                'datetime' => 'Y-m-d H:i:s',
                'time'     => 'H:i:s',
            ],
        ];

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }
    }
}
