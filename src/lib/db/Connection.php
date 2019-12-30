<?php

namespace app\lib\db;

use PDO;

abstract class Connection {

    private static $instance;

    private function __construct() {}

    public static function getInstance() {
        if (!isset(self::$instance)) {
            $db = include_once __DIR__ . '/../../../config/db.php';
            $host = "mysql:dbname={$db['database']};host={$db['dsn']};charset=utf8";
            self::$instance = new PDO($host, $db['user'], $db['password']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}