<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;
    public static function getConnection(): PDO
    {
        if (self::$instance === null):
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $dbName = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $password = getenv('DB_PASSWORD');
            // $host = getenv('DB_HOST') ?: "127.0.0.1";
            // $port = getenv('DB_PORT') ?: "5432";
            // $dbName = getenv('DB_NAME') ?: "veterinaria";
            // $user = getenv('DB_USER') ?: "postgres";
            // $password = getenv('DB_PASSWORD') ?: "postgres";
            
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbName};options='--client_encoding=UTF8'";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ];

            try {
                echo $dsn;
                self::$instance = new PDO($dsn, $user, $password, $options);
            } catch (PDOException $e) {
                error_log("Database connection error: " . $e->getMessage());
                throw new RuntimeException("Error al conectar con la base de datos");
            }
        endif;

        return self::$instance;
    }
}
