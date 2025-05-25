<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'coupe_system');
define('DB_USER', 'root');
define('DB_PASS', 'bassem1234');


$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage());
}
?>