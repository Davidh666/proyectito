<?php

require_once "models/Producto.php";

$producto = new Producto();
$datos = $producto->listar();
$mensaje = "";

// Mostrar mensaje de éxito o error
if(isset($_GET['exito'])) {
    if($_GET['exito'] == 'insertado') {
        $mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert">✓ Producto insertado correctamente<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } elseif($_GET['exito'] == 'actualizado') {
        $mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert">✓ Producto actualizado correctamente<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    } elseif($_GET['exito'] == 'eliminado') {
        $mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert">✓ Producto eliminado correctamente<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
    }
}
if(isset($_GET['error'])) {
    $mensaje = '<div class="alert alert-danger alert-dismissible fade show" role="alert">✗ Error al procesar la operación<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Sistema de Gestión de Productos</h1>

        <?= $mensaje ?>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Agregar Producto</h5>
                    </div>
                    <div class="card-body">
                        <form action="insertar.php" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock / Cantidad</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Guardar Producto</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="card-title mb-0">Lista de Productos</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)): ?>
                                    <?php foreach($datos as $fila): ?>
                                        <tr>
                                            <td><?= $fila["id"] ?></td>
                                            <td><?= htmlspecialchars($fila["nombre"]) ?></td>
                                            <td>Bs. <?= number_format($fila["precio"], 2) ?></td>
                                            <td><?= $fila["stock"] ?></td>
                                            <td>
                                                <a href="actualizar.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                                <a href="eliminar.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">No hay productos registrados.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>