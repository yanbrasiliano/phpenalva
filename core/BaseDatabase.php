<?php

namespace Core;

class BaseDatabase
{
  private $config;

  public function __construct(array $config = [])
  {
    $this->config = $config ?: require __DIR__ . '/../config/database.php';
  }

  public function getDatabase()
  {
    try {
      $defaultDriver = $_ENV['DB_CONNECTION'] ?? $this->config['default'];
      $driverConfig = $this->config['connections'][$defaultDriver] ?? $this->config['connections']['pgsql'];
      $driver = $driverConfig['driver'];

      $pdo = $driver === 'sqlite'
        ? new \PDO("sqlite:{$driverConfig['database']}")
        : new \PDO("{$driver}:host={$driverConfig['host']};port={$driverConfig['port']};dbname={$driverConfig['database']};", $driverConfig['username'], $driverConfig['password']);

      $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

      return $pdo;
    } catch (\PDOException $exception) {
      $errorDetails = [
        'message' => 'Connection failed: ' . $exception->getMessage(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'status_code' => $exception->getCode() ?: 500,
        'trace' => $exception->getTraceAsString(),
      ];

      include __DIR__ . '/../app/Views/System/exception.phtml';
      exit;
    }
  }
}
