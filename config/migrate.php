<?php

require __DIR__ . '/../vendor/autoload.php';

use Core\BaseDatabase;
use Core\MigrationManager;

$config = require __DIR__ . '/database.php';
$database = new BaseDatabase($config);
$pdo = $database->getDatabase();

$migrationManager = new MigrationManager($pdo);
$migrationManager->migrate();

echo "Migrations applied successfully.\n";
