<?php

namespace Core;

use PDO;

class MigrationManager
{
  protected PDO $pdo;
  protected string $migrationTable = 'migrations';

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
    $this->createMigrationTable();
  }

  protected function createMigrationTable()
  {
    $this->pdo->exec("CREATE TABLE IF NOT EXISTS {$this->migrationTable} (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
  }

  public function migrate()
  {
    $migrations = glob(__DIR__ . '/../database/migrations/*.php');
    $appliedMigrations = $this->getAppliedMigrations();

    foreach ($migrations as $migrationFile) {
      $migrationClass = pathinfo($migrationFile, PATHINFO_FILENAME);

      if (in_array($migrationClass, $appliedMigrations)) {
        continue;
      }

      require_once $migrationFile;
      $migrationInstance = new $migrationClass($this->pdo);

      echo "Applying migration: $migrationClass\n";
      $migrationInstance->up();
      $this->logMigration($migrationClass);
    }
  }

  protected function getAppliedMigrations(): array
  {
    $statement = $this->pdo->query("SELECT migration FROM {$this->migrationTable}");
    return $statement->fetchAll(PDO::FETCH_COLUMN);
  }

  protected function logMigration(string $migrationClass)
  {
    $stmt = $this->pdo->prepare("INSERT INTO {$this->migrationTable} (migration) VALUES (:migration)");
    $stmt->execute(['migration' => $migrationClass]);
  }
}
