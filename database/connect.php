<?php

// settings
$dsn = 'mysql:host=localhost;dbname=php-quiz';
$username = 'root';
$password = '';

// PDO options
$opt = array(
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8, time_zone = '+04:00'"
);

// connection
try {
    $con = new PDO($dsn, $username, $password, $opt);
} catch(PDOException $e) {
    echo 'Connection failed: '.$e->getMessage();
}

?>

