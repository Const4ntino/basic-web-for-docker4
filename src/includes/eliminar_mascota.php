<?php

declare(strict_types=1);
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

$id = trim($_POST['id'] ?? '');

if ($id !== ''):
    try {
        $db = Database::getConnection();
        $query = 'DELETE FROM mascotas WHERE id = :id';
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => (int)$id]);

        header('Location: ../index.php?status=deleted');
    } catch (PDOException $e) {
        error_log('Error al eliminar el registro: ' . $e->getMessage());
        exit('Ocurrió un error inesperado al eliminar el registro.');
    }
else:
    header('Location ../index.php?status=error');
    exit;
endif;
