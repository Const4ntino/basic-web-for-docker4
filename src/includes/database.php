<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;
    public static function getConnection(): PDO
    {
        if (self::$instance === null):
            $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
            $port = $_ENV['DB_PORT'] ?? '5432';
            $dbName = $_ENV['DB_NAME'] ?? 'veterinaria';
            $user = $_ENV['DB_USER'] ?? 'postgres';
            $password = $_ENV['DB_PASSWORD'] ?? 'postgres';

            $dsn = "pgsql:host={$host};port={$port};dbname={$dbName};options='--client_encoding=UTF8'";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ];

            try {
                self::$instance = new PDO($dsn, $user, $password, $options);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new RuntimeException("Error al conectar con la base de datos");
            }
        endif;

        return self::$instance;
    }
}
