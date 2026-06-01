<?php
require_once "models/Producto.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = new Producto();
    
    // Captura de datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $nombre_cliente = $_POST['nombre_cliente'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $venta = $_POST['venta'] ?? 0;
    
    // Validación básica
    if(!empty($nombre) && $precio > 0 && $stock >= 0 && !empty($nombre_cliente)) {
        
        // 1. Guardar en tu base de datos local (asegúrate que el método en Producto.php reciba estos 6 parámetros)
        if($producto->insertar($nombre, $precio, $stock, $nombre_cliente, $correo, $venta)) {
            
            // 2. Preparar los datos para enviar a Make
            $webhook_url = "https://hook.us2.make.com/agsbu94o62ges2weykvl67ldjbdrsgjk";
            $data = [
                'nombre'         => $nombre,
                'precio'         => $precio,
                'stock'          => $stock,
                'nombre_cliente' => $nombre_cliente,
                'correo'         => $correo,
                'venta'          => $venta
            ];

            // 3. Enviar los datos mediante cURL
            $ch = curl_init($webhook_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
            curl_exec($ch);
            curl_close($ch);

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