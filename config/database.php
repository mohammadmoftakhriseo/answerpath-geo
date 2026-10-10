<?php
declare(strict_types=1);

/**
 * Enterprise Database Configuration
 * Mohammad Moftakhari CMS (maaadmr.ir)
 * Reads sensitive credentials securely from .env
 */

use App\Core\Env;

return [
    'driver'    => Env::get('DB_DRIVER', 'mysql'),
    'host'      => Env::get('DB_HOST', 'localhost'),
    'port'      => (int)Env::get('DB_PORT', 3306),
    'database'  => Env::get('DB_DATABASE', 'ozroiffx_cms'),
    'username'  => Env::get('DB_USERNAME', 'ozroiffx_mohammad'),
    'password'  => Env::get('DB_PASSWORD', 'Lu,*a,BukHvY3A]3'),
    'charset'   => Env::get('DB_CHARSET', 'utf8mb4'),
    'collation' => 'utf8mb4_unicode_ci',
    'options'   => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::ATTR_TIMEOUT            => 5,
    ]
];
