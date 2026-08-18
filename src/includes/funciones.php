<?php
include(__DIR__ . '/database.php');

function hec(?string $value, string $default = ''): string
{
    return htmlspecialchars($value ?? $default, ENT_QUOTES, 'UTF-8');
}
function getMascotas(PDO $db)
{
    $query = "SELECT * FROM mascotas;";
    $stmt = $db->prepare($query);
    $stmt->execute([]);
    return $stmt;
}
