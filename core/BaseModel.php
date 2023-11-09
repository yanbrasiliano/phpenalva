<?php

namespace Core;

abstract class BaseModel
{
    protected $pdo;
    protected $table;
    protected $connection;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->connection = new BaseDatabase();
    }

    public function getModel($model)
    {
        $objModel = '\\App\\Models\\'.$model;

        return new $objModel($this->connection->getDatabase());
    }

    public function getAll()
    {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();

        return $result;
    }
}
