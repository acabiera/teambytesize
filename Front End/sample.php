<?php

require 'vendor/autoload.php';
 
use scservice\Connection as Connection;
use scservice\SCServiceDisplay as Display;
 
try {
    // connect to the PostgreSQL database
    $pdo = Connection::get()->connect();
    // 
    $display = new Display($pdo);
    // get all stocks data
    $sample = $display->specRow(6);
    
    var_dump($sample);
    
} catch (\PDOException $e) {
    echo $e->getMessage();
}
?>
