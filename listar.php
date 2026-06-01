<?php
require_once "models/Producto.php";

$producto = new Producto();
$datos = $producto->listar();
$mensaje = "";

// Mostrar mensaje de éxito o error
if(isset($_GET['exito'])) {
    if($_GET['exito'] == 'insertado') {
        $mensaje = '<div class="alert alert-success alert-dismissible fade show" role="alert">✓ Producto insertado y enviado correctamente<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
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
                            <div class="mb-2"><label>Nombre Producto</label><input type="text" class="form-control" name="nombre" required></div>
                            <div class="mb-2"><label>Precio</label><input type="number" step="0.01" class="form-control" name="precio" required></div>
                            <div class="mb-2"><label>Stock</label><input type="number" class="form-control" name="stock" required></div>
                            <div class="mb-2"><label>Nombre Cliente</label><input type="text" class="form-control" name="nombre_cliente" required></div>
                            <div class="mb-2"><label>Correo</label><input type="email" class="form-control" name="correo" required></div>
                            <div class="mb-3"><label>Monto Venta</label><input type="number" step="0.01" class="form-control" name="venta" required></div>
                            <button type="submit" class="btn btn-success w-100">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white"><h5 class="card-title mb-0">Lista de Productos</h5></div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Cliente</th><th>Correo</th><th>Venta</th><th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($datos)): foreach($datos as $fila): ?>
                                    <tr>
                                        <td><?= $fila["id"] ?></td>
                                        <td><?= htmlspecialchars($fila["nombre"]) ?></td>
                                        <td>Bs. <?= number_format($fila["precio"], 2) ?></td>
                                        <td><?= $fila["stock"] ?></td>
                                        <td><?= htmlspecialchars($fila["nombre_cliente"]) ?></td>
                                        <td><?= htmlspecialchars($fila["correo"]) ?></td>
                                        <td>Bs. <?= number_format($fila["venta"], 2) ?></td>
                                        <td>
                                            <a href="actualizar.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="eliminar.php?id=<?= $fila['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro?')">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="8" class="text-center">No hay productos.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>