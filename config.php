<?php

/**
 * Configuration for database connection 
 */

require_once 'credentials.php';

$pdo = NULL;
$dsn = 'mysql:host=' . $host . ';dbname=' . $schema;

/* Connection inside a try/catch block */
try {
    /* PDO object creation */
    $pdo = new PDO($dsn, $user,  $password);

    /* Enable exceptions on errors */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $error) {
    echo 'Database connection failed<br>';
    exit();
}
