<?php


 declare(strict_types=1);

 class Database{
  

    public static function getConnection(): PDO
    {
        static $pdo = null;
        if($pdo instanceof PDO){
            return $pdo;
        }

        $host = getenv("HOST");
        $bdName = getenv("BDNAME");
        $user = getenv("USER");
        $password = getenv("PASSWORD");

        $dsn = "mysql:host={$host};dbname={$bdName};charset=utf8";

        $pdo = new PDO($dsn, $user, $password, [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    }
 }