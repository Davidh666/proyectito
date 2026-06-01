<?php

require_once "models/Producto.php";

$producto = new Producto();
$productoEditar = null;

// Obtener producto para editar
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $datos = $producto->listar();
    foreach($datos as $fila) {
        if($fila['id'] == $id) {
            $productoEditar = $fila;
            break;
        }
    }
}

// Procesar actualización
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    
    if(!empty($nombre) && $precio > 0 && $stock >= 0) {
        if($producto->actualizar($id, $nombre, $precio, $stock)) {
            header('Location: listar.php?exito=actualizado');
            exit();
        } else {
            header('Location: listar.php?error=actualizar');
            exit();
        }
    } else {
        header('Location: actualizar.php?id='.$id.'&error=validacion');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0">Editar Producto</h5>
                    </div>
                    <div class="card-body">
                        <?php if($productoEditar): ?>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $productoEditar['id'] ?>">
                                
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del Producto</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($productoEditar['nombre']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?= $productoEditar['precio'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stock / Cantidad</label>
                                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $productoEditar['stock'] ?>" required>
                                </div>
                                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                                <a href="listar.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-danger">Producto no encontrado</div>
                            <a href="listar.php" class="btn btn-secondary w-100">Volver al Panel</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>