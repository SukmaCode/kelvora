<?php

/**
 * Database Configuration
 * 
 * PDO connection settings for MySQL.
 * Change these values according to your environment.
 */

return [
    'driver'   => 'mysql',
    'host'     => '127.0.0.1',
    'port'     => '3306',
    'database' => 'kelvora',
    'username' => 'root',
    'password' => '',
    'charset'  => 'utf8mb4',
    'collation'=> 'utf8mb4_unicode_ci',
    'options'  => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_STRINGIFY_FETCHES  => false,
    ],
];
