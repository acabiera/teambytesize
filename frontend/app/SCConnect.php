<?php

namespace scservice;

//connection

class SCConnect {
    
    //Connection - var type
    private static $conn;

    //connect() returns PDO
    //throws exception on error

    public function connect() {
    $params = parse_ini_file('database.ini');
    if ($params === false){
        throw new \Exception("Error reading database.ini");
    }
    $connect = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
        $params['host'], $params['port'], $params['database'], $params['user'], $params['password']);
    $pdo = new \PDO($connect);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    return $pdo;
    }
    
    //constructor for class

    public static function get(){
        if (null=== static::$conn) {
            static::$conn = new static();
        }
        return static::$conn;
    }
    protected function __construct() {
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}    
?>
