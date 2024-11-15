<?php

/**
 * Options are mysql, pgsql, sqlite, sqlsrv.
 */

return [
  'default' => $_ENV['DB_CONNECTION'] ?? 'sqlite',
  'connections' => [
    'mysql' => [
      'driver' => 'mysql',
      'host' => $_ENV['DB_HOST'] ?? 'localhost',
      'port' => $_ENV['DB_PORT'] ?? '3306',
      'database' => $_ENV['DB_DATABASE'] ?? '',
      'username' => $_ENV['DB_USERNAME'] ?? 'root',
      'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
    'pgsql' => [
      'driver' => 'pgsql',
      'host' => $_ENV['DB_HOST'] ?? 'localhost',
      'port' => $_ENV['DB_PORT'] ?? '5432',
      'database' => $_ENV['DB_DATABASE'] ?? 'phpenalva',
      'username' => $_ENV['DB_USERNAME'] ?? 'postgres',
      'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
    'sqlite' => [
      'driver' => 'sqlite',
      'database' => $_ENV['DB_DATABASE'] ?? __DIR__ . '/../database/database.sqlite',
      'prefix' => '',
    ],
    'sqlsrv' => [
      'driver' => 'sqlsrv',
      'host' => $_ENV['DB_HOST'] ?? 'localhost',
      'port' => $_ENV['DB_PORT'] ?? '1433',
      'database' => $_ENV['DB_DATABASE'] ?? 'phpenalva',
      'username' => $_ENV['DB_USERNAME'] ?? 'root',
      'password' => $_ENV['DB_PASSWORD'] ?? '',
    ],
  ],
];
