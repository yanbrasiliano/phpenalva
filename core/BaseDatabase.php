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


      $defaultDriver = $_ENV['DB_CONNECTION'] ?: $this->config['default'];
      $driverConfig = $this->config['connections'][$defaultDriver] ?: $this->config['connections']['pgsql'];

      $driver = $driverConfig['driver'];
      $host = $driverConfig['host'];
      $port = $driverConfig['port'];
      $database = $driverConfig['database'];
      $username = $driverConfig['username'];
      $password = $driverConfig['password'];



      $pdo = new \PDO("$driver:host=$host;port=$port;dbname=$database;", $username, $password);
      $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);

      return $pdo;
    } catch (\PDOException $e) {
      $errorDetails = [
        'message' => 'Connection failed: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'status_code' => $e->getCode() ?: 500,
        'trace' => $e->getTraceAsString(),
      ];

      include __DIR__ . '/../app/Views/System/exception.phtml';
      exit;
    }
  }
}
