<?php

declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;
    public static function getConnection(): PDO
    {
        if (self::$instance === null):
            $host = $_ENV('DB_HOST');
            $port = $_ENV('DB_PORT');
            $dbName = $_ENV('DB_NAME');
            $user = $_ENV('DB_USER');
            $password = $_ENV('DB_PASSWORD');
            
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
