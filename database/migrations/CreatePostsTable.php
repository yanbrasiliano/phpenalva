<?php

use Core\BaseMigration;

class CreatePostsTable extends BaseMigration
{
  public function up()
  {
    $this->execute("CREATE TABLE IF NOT EXISTS posts (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            description VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
  }

  public function down()
  {
    $this->execute("DROP TABLE IF EXISTS posts");
  }
}
