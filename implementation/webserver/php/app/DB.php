<?php

class DB {
    static $Pdo;
    static function prepare($query, array $options = []) {
        return static::$Pdo->prepare($query, $options);
    }

    static function query($query) {
        return static::$Pdo->query($query);
    }

    static function exec($statement) {
        return static::$Pdo->exec($statement);
    }

    static function lastInsertId() {
    return static::$Pdo->lastInsertId();
    }

    static function beginTransaction() {
        return static::$Pdo->beginTransaction();
    }

    static function commit() {
        return static::$Pdo->commit();
    }

    static function rollBack() {
        return static::$Pdo->rollBack();
    }

    public function __construct() {
        $db='iothome';
        $user='root';
        $password='root-heslo';
        $dsn="mysql:host=db;port=3306;dbname=$db;charset=UTF8";
        try {
            static::$Pdo = new Pdo($dsn,$user,$password);
        } catch( PDOException $Exc ) {
            die("Error: DB init");
        }
    }


}