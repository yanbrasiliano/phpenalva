<?php

namespace Core;

use PDO;

abstract class BaseMigration
{
  protected PDO $pdo;

  public function __construct(PDO $pdo)
  {
    $this->pdo = $pdo;
  }

  abstract public function up();
  abstract public function down();

  protected function execute(string $sql)
  {
    $this->pdo->exec($sql);
  }
}
