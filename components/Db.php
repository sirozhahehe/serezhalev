<?php


class Db{
    public static function sqlConnection() {
        $data_path = ROOT.'/config/db_cfg.php';
        $data = include($data_path);
        $host = $data['host'];
        $database = $data['database'];
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8";
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, $data['user'], $data['password'], $opt);
            return $pdo;
        }
        catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}