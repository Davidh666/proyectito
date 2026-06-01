<?php
require_once "models/Producto.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = new Producto();
    
    // Captura de datos
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0; // Se usa como cantidad comprada
    $nombre_cliente = $_POST['nombre_cliente'] ?? '';
    $correo = $_POST['correo'] ?? '';
    
    // ==========================================
    // 1. CÁLCULOS MATEMÁTICOS (Lo que pidió el Inge)
    // ==========================================
    $subtotal = $precio * $stock; 
    $porcentaje_descuento = 10; // Ejemplo: 10%
    $descuento = $subtotal * ($porcentaje_descuento / 100);
    $total_final = $subtotal - $descuento;

    if(!empty($nombre) && $precio > 0 && $stock >= 0) {
        
        // 2. Guardar en base de datos local
        // (Asegúrate de que tu función en Producto.php reciba también los nuevos campos calculados si los quieres guardar)
        if($producto->insertar($nombre, $precio, $stock, $nombre_cliente, $correo, $total_final)) {
            
            // 3. Preparar datos para Make (incluyendo cálculos)
            $webhook_url = "https://hook.us2.make.com/agsbu94o62ges2weykvl67ldjbdrsgjk";
            $data = [
                'nombre'         => $nombre,
                'precio'         => $precio,
                'cantidad'       => $stock,
                'nombre_cliente' => $nombre_cliente,
                'correo'         => $correo,
                'subtotal'       => $subtotal,
                'descuento'      => $descuento,
                'total_final'    => $total_final
            ];

            // 4. Enviar vía cURL
            $ch = curl_init($webhook_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
            curl_exec($ch);
            curl_close($ch);

            header('Location: listar.php?exito=insertado');
            exit();
        }
    }
}
?>