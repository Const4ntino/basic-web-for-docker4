<?php

declare(strict_types=1);
require_once(__DIR__ . '/database.php');

// Verificación de existencia del método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

// Verificar si viene un id del input hidden
$id = trim($_POST['id'] ?? '');

// Validación de valores
$nombre = trim($_POST['nombre'] ?? '');
$tipo = trim($_POST['tipo'] ?? '');
$sexo = trim($_POST['sexo'] ?? 'M');
$nacimientoInput = trim($_POST['nacimiento'] ?? '');

if ($nombre === '' || $tipo === '' || $sexo === '') {
    exit('Por favor completa los campos requeridos.');
}

$nacimiento = ($nacimientoInput === '') ? null : (int)$nacimientoInput;
$fecha_ingreso = new DateTimeImmutable('now', new DateTimeZone('UTC'));

try {
    $db = Database::getConnection();

    if ($id !== '') :
        $query = "UPDATE mascotas SET nombre = :nombre, tipo = :tipo, sexo = :sexo, nacimiento = :nacimiento WHERE id = :id;";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nombre' => $nombre,
            'tipo' => $tipo,
            'sexo' => $sexo,
            'nacimiento' => $nacimiento,
            'id' => (int)$id
        ]);
    else:
        $query = "INSERT INTO mascotas (nombre, tipo, sexo, nacimiento, fecha_ingreso) VALUES
                    (:nombre, :tipo, :sexo, :nacimiento, :fecha_ingreso);";
        $stmt = $db->prepare($query);
        $stmt->execute([
            'nombre' => $nombre,
            'tipo' => $tipo,
            'sexo' => $sexo,
            'nacimiento' => $nacimiento,
            'fecha_ingreso' => $fecha_ingreso->format('Y-m-d')
        ]);
    endif;

    header('Location: ../index.php?status=success');
    exit;
} catch (PDOException $e) {
    error_log('Error al insertar el registro: ' . $e->getMessage());
    exit('Ocurrió un error inesperado al guardar los datos.');

    // Inspección directa para depurar en local
    // echo '<h2>Error de Base de Datos</h2>';
    // echo '<p><strong>Mensaje:</strong> ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    // echo '<p><strong>Código SQLSTATE:</strong> ' . htmlspecialchars((string)$e->getCode(), ENT_QUOTES, 'UTF-8') . '</p>';
    // echo '<p><strong>Archivo:</strong> ' . htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8') . ' en la línea ' . $e->getLine() . '</p>';
    // exit;
}
