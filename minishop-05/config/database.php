<?php

class Database
{
    public static function getConnection(): PDO
    {
        $username = 'root';
        $password = '';

        try {
            $dsn = 'mysql:host=127.0.0.1;dbname=minishop_cse485;charset=utf8mb4';
            return new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            try {
                $fallbackDsn = 'mysql:host=127.0.0.1;dbname=minishop;charset=utf8mb4';
                return new PDO($fallbackDsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $ex) {
                throw new RuntimeException('Database connection failed: ' . $e->getMessage());
            }
        }
    }
}
