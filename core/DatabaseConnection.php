<?php

namespace Core;

class DatabaseConnection
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $this->connection = new \PDO(
            'pgsql:host='.env('DB_HOST', 'localhost').';port='.env('DB_PORT', '5432').';dbname='.env('DB_DATABASE', 'phpenalva'),
            env('DB_USERNAME', 'postgres'),
            env('DB_PASSWORD', '')
        );
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
