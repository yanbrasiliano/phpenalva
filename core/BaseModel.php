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

    public function getById($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();

        return $result;
    }

    public function save($data)
    {
        try {
            $query = "INSERT INTO {$this->table} (description) VALUES (:description)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':description', $data['description']);
            $stmt->execute();
            $result = $this->pdo->lastInsertId();
            $stmt->closeCursor();

            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
