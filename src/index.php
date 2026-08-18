<?php
require_once("./includes/funciones.php");

$db = Database::getConnection();
$mascotas = getMascotas($db);

// Verificar si se intenta editar una mascota
$mascotaData = null;
$id = $_GET['id'] ?? null;

if ($id !== null) {
    $query = "SELECT * FROM mascotas WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute(['id' => (int)$id]);
    $mascotaData = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinaria</title>
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="./build/css/app.css">
</head>

<body>
    <main>
        <h1>Módulo de Mascotas</h1>
        <section class="crud-mascotas">
            <form id="form_mascota" action="./includes/procesar_mascota.php" method="POST">
                <input type="hidden" name="id" value="<?= hec((string)($mascotaData['id'] ?? '')) ?>">
                <div>
                    <label for="nombre">Nombre</label>
                    <input class="formulario-input" type="text" name="nombre" id="nombre" required maxlength="20"
                        value="<?= hec($mascotaData['nombre'] ?? '') ?>">
                </div>
                <div>
                    <label for="tipo">Tipo</label>
                    <input class="formulario-input" type="text" name="tipo" id="tipo" required maxlength="40"
                        value="<?= hec($mascotaData['tipo'] ?? '') ?>">
                </div>
                <div>
                    <label for="sexo">Sexo</label>
                    <?php $sexo = $mascotaData['sexo'] ?? ''; ?>
                    <select name="sexo" id="sexo">
                        <option value="M" <?= ($sexo === 'M') ? 'selected' : '' ?>>Macho</option>
                        <option value="F" <?= ($sexo === 'F') ? 'selected' : '' ?>>Hembra</option>
                    </select>
                </div>
                <div>
                    <label for="nacimiento">Nacimiento</label>
                    <div class="input-nacimiento">
                        <input type="number" name="nacimiento" id="nacimiento" min="1999" max="2026"
                            value="<?= hec($mascotaData['nacimiento'] ?? '') ?>">
                        <button class="formulario-input" type="button" id="btn_limpiar_nac">X</button>
                    </div>
                </div>
                <div>
                    <button type="submit"><?= ($id === null) ? 'Guardar Registro' : 'Editar Registro' ?></button>
                    <button id="btn_limpiar_cancelar"
                        data-id="<?= hec((string)($id ?? '')) ?>"
                        type="button"
                        ><?= ($id === null) ? 'Limpiar Formulario' : 'Cancelar' ?></button>
                </div>
            </form>

            <div class="table-container">
                <table>
                    <caption>Lista de Mascotas</caption>
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Nacimiento</th>
                            <th scope="col">Fecha de Ingreso</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($mascota = $mascotas->fetch(PDO::FETCH_ASSOC)):
                            $sexo = $mascota["sexo"] === "M" ? "Macho" : "Hembra" ?>
                            <tr>
                                <td><?= hec($mascota["nombre"]) ?></td>
                                <td><?= hec($mascota["tipo"]) ?></td>
                                <td><?= hec($sexo, "Sin registrar") ?></td>
                                <td><?= hec($mascota["nacimiento"], "Sin registrar") ?></td>
                                <td><?= hec($mascota["fecha_ingreso"]) ?></td>
                                <td>
                                    <div class="celda-acciones">
                                        <a href="index.php?id=<?= hec((string)$mascota["id"]) ?>">Editar</a>
                                        <button class="btn-abrir-modal"
                                            data-id="<?= hec((string)$mascota["id"]) ?>"
                                            data-nombre="<?= hec((string)$mascota["nombre"]) ?>">Eliminar</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table> <!-- Lista de Mascotas -->
            </div>
        </section>
    </main>
    <script src="./build/js/app.js"></script>
</body>

</html>
<dialog id="modal_eliminar_mascota">
    <article>
        <h2>Confirmar Acción</h2>
        <p>¿Estás seguro que deseas eliminar a <strong id="p_mascota_nombre">esta mascota</strong>?</p>
        <p>Esta acción no se puede deshacer.</p>
        <form action="./includes/eliminar_mascota.php" method="POST">
            <input type="hidden" name="id" id="input_mascota_id" value="">
            <button class="btn-form-confirmar secondary"  id="btn_cancelar">Cancelar</button>
            <button class="btn-form-confirmar" type="submit" id="btn_confirmar">Confirmar</button>
        </form>
    </article>
</dialog>