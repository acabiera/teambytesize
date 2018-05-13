<?php
//this is a test to see if I can get the connection working

$host="127.0.0.1";
$port="5432";
$database="scserver";
$user="scserver";
$password="452&Uark";

try{
    $pdo = new PDO("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", $host, $port, $database, $user, $password);
    $echo "Connection successful";
} catch (\PDOException $e) {
    echo $e->getMessage();
}
?>
