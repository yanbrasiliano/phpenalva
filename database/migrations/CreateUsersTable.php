<?php

use Core\BaseMigration;

class CreateUsersTable extends BaseMigration
{
  public function up()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100),
            email VARCHAR(100) UNIQUE,
            password VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
  }

  public function down()
  {
    $this->execute("DROP TABLE IF EXISTS users");
  }
}
