<?php

require_once "models/Producto.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $producto = new Producto();
    
    if($producto->eliminar($id)) {
        header('Location: listar.php?exito=eliminado');
        exit();
    } else {
        header('Location: listar.php?error=eliminar');
        exit();
    }
} else {
    header('Location: listar.php');
    exit();
}

?>