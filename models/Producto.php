<?php

require_once "config/Conexion.php";

class Producto {

    private $conexion;

    public function __construct() {

        $db = new Conexion();
        $this->conexion = $db->conectar();

    }

    // ==========================
    // INSERTAR
    // ==========================
  // En models/Producto.php

    public function insertar($nombre, $precio, $stock, $nombre_cliente, $correo, $venta) {
        $sql = "INSERT INTO productos(nombre, precio, stock, nombre_cliente, correo, venta) 
                VALUES(:nombre, :precio, :stock, :nombre_cliente, :correo, :venta)";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":stock", $stock);
        $stmt->bindParam(":nombre_cliente", $nombre_cliente);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":venta", $venta);

        return $stmt->execute();
    }

    // ==========================
    // LISTAR
    // ==========================
    public function listar() {

        $sql = "SELECT * FROM productos";

        $stmt = $this->conexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ==========================
    // ACTUALIZAR
    // ==========================
    public function actualizar($id, $nombre, $precio, $stock) {

        $sql = "UPDATE productos
                SET nombre = :nombre,
                    precio = :precio,
                    stock = :stock
                WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":precio", $precio);
        $stmt->bindParam(":stock", $stock);

        return $stmt->execute();
    }

    // ==========================
    // ELIMINAR
    // ==========================
    public function eliminar($id) {

        $sql = "DELETE FROM productos WHERE id = :id";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

}
?>