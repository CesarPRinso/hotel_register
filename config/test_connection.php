<?php
$dsn = 'pgsql:host=127.0.0.1;port=5432;dbname=emergento;';
$user = 'emergento';
$password = '0000';

try {
    $pdo = new PDO($dsn, $user, $password);
    echo "Connected to the database successfully!";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>