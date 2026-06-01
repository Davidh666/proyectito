<?php

require_once "models/Producto.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = new Producto();
    
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    
    if(!empty($nombre) && $precio > 0 && $stock >= 0) {
        if($producto->insertar($nombre, $precio, $stock)) {
            header('Location: listar.php?exito=insertado');
            exit();
        } else {
            header('Location: listar.php?error=insertar');
            exit();
        }
    } else {
        header('Location: listar.php?error=validacion');
        exit();
    }
} else {
    header('Location: listar.php');
    exit();
}

?>