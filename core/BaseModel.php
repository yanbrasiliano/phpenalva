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

    public function save(array $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = ':'.implode(', :', array_keys($data));

            $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(':'.$key, $value);
            }

            $stmt->execute();
            $result = $this->pdo->lastInsertId();
            $stmt->closeCursor();

            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function update(array $data)
    {
        try {
            $setClause = implode(', ', array_map(fn ($key) => "$key = :$key", array_keys($data)));

            $query = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";
            $stmt = $this->pdo->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(':'.$key, $value);
            }

            $stmt->execute();
            $result = $stmt->rowCount();
            $stmt->closeCursor();

            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }

    public function exists($id)
    {
        $query = "SELECT COUNT(*) FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $result = $stmt->rowCount();
            $stmt->closeCursor();

            return $result;
        } catch (\PDOException $e) {
            return $e->getMessage();
        }
    }
}
